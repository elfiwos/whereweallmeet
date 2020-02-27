<?php

use \Model\Quicksearch;

class Controller_Profile extends Controller_Base {

    public $template = 'layout/template';

    public function before() {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }    

    public function action_quicksearch()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	 
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	
    	if(count($subsc) === 1)
    	{
    	$subscribed = true;
    	}
    	else
    	{
    	$subscribed = false;
    	}
    	
    	$online_members = Quicksearch::get_online_members($username, $password);
    	$result = Quicksearch::get_result($username, $password);  
    	$dating_members = Quicksearch::get_dating_agent_result($this->current_profile->id);
    	$view = View::forge('profile/quicksearch_view');   	
    	if($this->current_profile->member_type_id == 3)
    	{
    		$view->latest_members = $dating_members;
    	}
    	else
    	{
    		$view->latest_members = $result[0];
    		$view->counter = $result[1];
    		$view->percentage = $result[2];
    	}
    	$view->online_members  =  $online_members;
    	$view->referd  =  $referd;
    	$view->subscribed  =  $subscribed;
    	$view->set_global('page_js', 'profile/dashboard.js');
    	$view->set_global('page_css', 'profile/dashboard.css');
    	
    	$this->template->title = 'WHERE WE ALL MEET &raquo; All Latest Members';
    	$this->template->content = $view;
    	    	
    	
    }

    public function action_like(){
            $response = Response::forge();

             if (Input::method() == 'POST' or Input::is_ajax()) {

                $liker = Input::post("liker");
                $photo_name = Input::post("photo_name");
                $date = date('Y-m-d H:i:s');

                $newrow = array();
               
                $newrow['file_name']= $photo_name;
                $newrow['liker']= $liker;
                $newrow['date']= $date;

             list($insert_id, $rows_affected) = DB::insert('photo_likes')->set($newrow)->execute();

             

            $likes = DB::query("SELECT * FROM photo_likes WHERE file_name='" . $photo_name . "'")->execute()->as_array();

            $total_likes =count($likes); 
            

            $response->body(json_encode(array(
                         'status' => true,
                         'total_likes' => $total_likes,
                     )));
        
            return $response;

        }
    }

    public function action_online_members()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	
    $subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	
    	if(count($subsc) === 1)
    	{
    	$subscribed = true;
    	}
    	else
    	{
    	$subscribed = false;
    	}
    	$view = View::forge('profile/all_online_friends');
    	$online_members = Quicksearch::get_all_online_members($username, $password);
    	$view->online_members  =  $online_members;
    	$view->referd  =  $referd;
    	$view->subscribed  =  $subscribed;
    	$view->set_global('page_js', 'profile/dashboard.js');
    	$view->set_global('page_css', 'profile/dashboard.css');
    	 
    	$this->template->title = 'WHERE WE ALL MEET &raquo; Online Members';
    	$this->template->content = $view;
    
    	 
    }   

    public function action_dashboard()
    {
        $view = View::forge('profile/dashboard');

        $dating_members = Quicksearch::get_dating_agent_result($this->current_profile->id);
        $matched_members = Quicksearch::get_random_matches($this->current_profile->id);
        if($this->current_profile->member_type_id == 3)
        {
            $view->latest_members = $dating_members;
        }
        else
        {
            $view->latest_members = $matched_members;
        }
        $profiles = Model_profile::find('all');
        $view->set('profiles', $profiles);

        $view->friend_list  = Model_Friendship::get_friends($this->current_profile->id);
        $view->profiles  = $profiles;

        $notifications = Model_Notification::get_notifications($this->current_profile->id);

        $posts = Model_Post::get_post_by($this->current_profile->id);
        $view->posts = $posts;

        if($notifications) {
            $view->notifications = $notifications;
        }

        $active_events = Model_Event::get_active_events_by_region($this->current_profile->state, $this->current_profile->city);
        if ($active_events !== false) {
            $view->set_global("active_events", $active_events);
        }

        $view->active_datingPackages = Model_Datepackage::get_active_packages_by_region($this->current_profile->state, $this->current_profile->city);

        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/dashboard.js');
        $view->set_global('page_css', 'profile/dashboard.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Dashboard';
        $this->template->content = $view;
    }

    public function action_save_notification_setting(){

        if (Input::post()) {
            $post = Input::post();

            if(isset($post['account_email'])){
                $enable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('send_me_account_info',1)
                            ->execute();

            }else{
                $disable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('send_me_account_info',0)
                            ->execute();
            }
            if(isset($post['listing_email'])){

                $enable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('send_me_listing_info',1)
                            ->execute();                
            }else{
                $disable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('send_me_listing_info',0)
                            ->execute();    
            }
            if(isset($post['date_email'])){

                $enable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('send_me_date_invitations',1)
                            ->execute();
                
            }else{

                $disable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('send_me_date_invitations',0)
                            ->execute();

            }
            if(isset($post['announcment_email'])){

                $enable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('send_me_announcement_info',1)
                            ->execute();
                                
            }else{

                $disable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('send_me_announcement_info',0)
                            ->execute();
            }
            if(isset($post['deal_email'])){

                $enable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('send_me_specialdeal_info',1)
                            ->execute();
                
            }else{
                $disable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('send_me_specialdeal_info',0)
                            ->execute();

            }


       }
             Session::set_flash('success', 'Notifications setting updated successfully.!');   
             Response::redirect("profile/my_notification");


   }

    public function action_account_setting(){
         if (Input::post()) {
            $post = Input::post();


            $username= $post['username'];
            $email = $post['email'];
            $mobile = $post['mobile'];
            $gender = $post['gender'];
            $password = $post['pass'];
            $confirm = $post['pass2'];

            if($password === $confirm ){
                $error = null;
            }else{
                $error = "Your password doesn't match";
            }

        
           
          if($error == null){
             $query1 = DB::update('users');
             $query1->set(array(
                             "username" => $username,
                             "email" => $email,
                             "password" => $password
                ));
             $query1->where('id', $this->current_user->id);
             $query1->execute();
            }

             $query2 = DB::update('profiles');
             $query2->set(array(
                             "gender_id" => $gender
                ));
             $query2->where('id', $this->current_profile->id);
             $query2->execute();


            if(!empty($post['acc_del'])){
                $disable=DB::update('profiles')
                            ->where('user_id',$this->current_user->id)
                            ->value('disable',1)
                            ->execute();

                    $user_account = Model_User::find($this->current_user->id);
                    if($user_profile->send_me_account_info == 1){

                         Email::forge()->to($user_account->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Account Delete Notification")
                                        ->html_body(View::forge('email/delete_account_notification', array("notification" => $this->current_profile->first_name . ' ' . $this->current_profile->last_name ." you have deleted your account.")))->priority(\Email\Email::P_HIGH)->send();



                    }
                            Response::redirect(Router::get("login"));
                 }
        

            }

         
        Response::redirect('profile/my_setting/'.$error);


      }

    public function action_edit() {
        $gender = Model_Gender::find('all');
        $state = Model_State::find('all');
        $occupation = Model_Occupation::find('all');
        $relationship_status = Model_Relationshipstatus::find('all');
        $body_type = Model_Bodytype::find('all');
        $ethnicity = Model_Ethnicity::find('all');
        $eye_color = Model_Eyecolor::find('all');
        $hair_color = Model_Haircolor::find('all');
        $religion = Model_Religion::find('all');
        $smoke = Model_Smoke::find('all');
        $drink = Model_Drink::find('all');
        $priority_field = Model_Priorityfield::find('all');

        $view = View::forge('profile/edit', array(
                    'gender' => $gender,
                    'state' => $state,
                    'occupation' => $occupation,
                    'relationship_status' => $relationship_status,
                    'body_type' => $body_type,
                    'ethnicity' => $ethnicity,
                    'eye_color' => $eye_color,
                    'hair_color' => $hair_color,
                    'religion' => $religion,
                    'smoke' => $smoke,
                    'drink' => $drink,
                    'priority_field' => $priority_field,
                ));

        $preferred_members = DB::select('id', 'user_id', 'first_name', 'last_name', 'picture', 'city', 'state')
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->where('birth_date', '>=', Model_Profile::get_birth_date_from_age($this->current_profile->ages_to))
                        ->where('birth_date', '<=', Model_Profile::get_birth_date_from_age($this->current_profile->ages_from))
                        ->where('gender_id', $this->current_profile->gender_id == 1 ? 2 : 1) //inorder to select opposite gender
                        ->where('state', $this->current_profile->state)
                        ->where('disable', 0)
                        ->where('is_activated', 1)
                        ->where('user_id', 'not in', Model_Profile::get_admin_user_ids() )
                        ->where('member_type_id', '<>', Model_Membershiptype::DATING_AGENT_MEMBER)
                        ->order_by(DB::expr('RAND()'))->limit(4)->execute()->as_array();

        $view->preferred_members = $preferred_members;
        $view->profile = $this->current_profile;
        $view->current_user = $this->current_user;

        $view->set_global('page_js', 'profile/edit.js');
        $view->set_global('page_css', 'profile/edit.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Edit Profile';
        $this->template->content = $view;
    }

    public function action_wel_come() {
        $view = View::forge("profile/wel_come");

        $view->profile = $this->current_profile;
        $view->current_user = $this->current_user;

        $view->set_global('page_js', 'profile/edit.js');
        $view->set_global('page_css', 'profile/edit.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Edit Profile';
        $this->template->content = $view;
    }

    public function action_process_profile() {
        $gender = Model_Gender::find('all');
        $state = Model_State::find('all');
        $occupation = Model_Occupation::find('all');
        $relationship_status = Model_Relationshipstatus::find('all');
        $body_type = Model_Bodytype::find('all');
        $ethnicity = Model_Ethnicity::find('all');
        $eye_color = Model_Eyecolor::find('all');
        $hair_color = Model_Haircolor::find('all');
        $religion = Model_Religion::find('all');
        $smoke = Model_Smoke::find('all');
        $drink = Model_Drink::find('all');
        $priority_field = Model_Priorityfield::find('all');

        $view = View::forge('profile/process_profile', array(
                    'gender' => $gender,
                    'state' => $state,
                    'occupation' => $occupation,
                    'relationship_status' => $relationship_status,
                    'body_type' => $body_type,
                    'ethnicity' => $ethnicity,
                    'eye_color' => $eye_color,
                    'hair_color' => $hair_color,
                    'religion' => $religion,
                    'smoke' => $smoke,
                    'drink' => $drink,
                    'priority_field' => $priority_field,
                ));

        $preferred_members = DB::select('id', 'user_id', 'first_name', 'last_name', 'picture', 'city', 'state')
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->where('birth_date', '>=', Model_Profile::get_birth_date_from_age($this->current_profile->ages_to))
                        ->where('birth_date', '<=', Model_Profile::get_birth_date_from_age($this->current_profile->ages_from))
                        ->where('gender_id', $this->current_profile->gender_id == 1 ? 2 : 1) //inorder to select opposite gender
                        ->where('state', $this->current_profile->state)
                        ->where('disable', 0)
                        ->where('is_activated', 1)
                        ->where('user_id', 'not in', Model_Profile::get_admin_user_ids() )
                        ->where('member_type_id', '<>', Model_Membershiptype::DATING_AGENT_MEMBER)
                        ->order_by(DB::expr('RAND()'))->limit(4)->execute()->as_array();

        $view->preferred_members = $preferred_members;
        $view->profile = $this->current_profile;
        $view->current_user = $this->current_user;

        $view->set_global('page_js', 'profile/edit.js');
        $view->set_global('page_css', 'profile/edit.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Edit Profile';
        $this->template->content = $view;
    }

    public function action_thank_you() {
        $view = View::forge("profile/thank_you");

        $view->profile = $this->current_profile;
        $view->current_user = $this->current_user;

        $view->set_global('page_js', 'profile/edit.js');
        $view->set_global('page_css', 'profile/edit.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Edit Profile';
        $this->template->content = $view;
    }

    public function action_update_account_setting() {
        
        if (Input::post()) {
            $post = Input::post();

            $val = Validation::forge();


            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');

            if($post["password"] <> "") {
                $val->add('password', 'Password')->add_rule('required')->add_rule('max_length', 255)->add_rule('min_length', 6);
                $val->add('confirm_password', 'Confirm Password')->add_rule('match_field', 'password');
            }

            $this->current_profile->gender_id = $post['gender'];
            unset($post['gender']);

            if(isset($post['acc_del'])){
                $this->current_profile->disable = 1;
            } else {
                $this->current_profile->disable = 0;
            }
            unset($post['acc_del']);

            if(isset($post['visibility'])){
                $this->current_profile->visible_for_friends = 1;
            } else {
                $this->current_profile->visible_for_friends = 0;
            }
            unset($post['visibility']);

            $this->current_profile->save();
            
            if ($val->run()) {
                if($post["password"] <> "") {
                    Auth::change_password($post['old-password'], $post['password']);
                }
                unset($post['old-password']);
                unset($post['password']);
                unset($post['confirm_password']);
                $this->current_user->set($post);
                if ($this->current_user->save()) {
                    Session::set_flash('success', 'User account updated successfully.!');
                    Response::redirect("profile/my_setting");
                }else {
                    Session::set_flash('error', 'Updating user account failed. Please try again!');
                } 
        }else {
                    Session::set_flash('error', 'Updating user account failed. Please Insert a password of minimum 6 in length that mtaches and a valid email adress!');
                     Response::redirect("profile/my_setting");
                } 
    }
}

    public function action_update_profile_setting() {
        if (Input::method() == 'POST') {
            $post = Input::post();
            foreach ($post as $key => $value) {
                if ($value == '') {
                    unset($post[$key]);
                }
                else{
                    if(isset($post['city'])){
                        $post['city'] = trim($post['city']);
                    }                    
                }
            }

                // var_dump($post);die;

            if(isset($post['feet']) && isset($post['inches']))
            {
                $post['height'] = $post['feet'] . '*';
                $post['height'] .= $post['inches'] . '**';
                unset($post['feet']);
                unset($post['inches']);
            } else {
                $post['height'] = "";
                if(isset($post['feet']))
                    unset($post['feet']);
                if(isset($post['inches']))
                    unset($post['inches']);
            }

            if(isset($post['seeking_feet'])){
                $post['seeking_height'] = $post['seeking_feet'] . '*';
                unset($post['seeking_feet']);
            }

            if(isset($post['seeking_inches'])){
                $post['seeking_height'] .= $post['seeking_inches'] . '**';
                unset($post['seeking_inches']);
            }


            $post['birth_date'] = strtotime(date('Y-m-d', mktime(0, 0, 0, $post['month'], $post['day'], $post['year'])));
            unset($post['month'], $post['day'], $post['year']);

          /*  $city = $post['city'];
            $state = $post['state'];
            $zip = $post['zip'];
            $birth_date= $post['birth_date'];
            $height = $post['height'];
            $body_type = $post['body-type'];
            $ethnicity =$post['ethnicity'];
            $age_from = $post['age-from'];
            $age_to = $post['age-to'];
            $looking_for = $post['looking-for'];
            $relationship_status = $post['relationship-stat'];
            $smoker = $post['smoker'];
            $drinker = $post['drinker'];
            $education = $post['education'];
            $occupation = $post['occupation'];
            $income = $post['income']; */

            


           $this->current_profile->set($post);
                if ($this->current_profile->save()) {
                    Session::set_flash('success', 'User profile updated successfully.!');
                    Response::redirect("profile/my_profile_setting");
                } else {
                    Session::set_flash('error', 'Updating user profile failed. Please try again!');
                }
           
        }


        
    }

    public function action_update_bio_setting() {
        if (Input::method() == 'POST') {
            $post = Input::post();
            foreach ($post as $key => $value) {
                if ($value == '') {
                    unset($post[$key]);
                }
            }
            $this->current_profile->set($post);
            if ($this->current_profile->save()) {
                Session::set_flash('success', 'User profile updated successfully.!');
                Response::redirect("profile/my_bio_setting");
            } else {
                Session::set_flash('error', 'Updating user profile failed. Please try again!');
            }
        }
    }

    public function action_update() {
        if (Input::method() == 'POST') {
            $post = Input::post();

            foreach ($post as $key => $value) {
                if ($value == '') {
                    unset($post[$key]);
                }
                else{
                	if(isset($post['city'])){
                		$post['city'] = trim($post['city']);
                	}                    
                }
            }

            $post['birth_date'] = strtotime(date('Y-m-d', mktime(0, 0, 0, $post['month'], $post['day'], $post['year'])));
            unset($post['month'], $post['day'], $post['year']);

            $height = '';
            $height .= isset($post['height_foot']) ? $post['height_foot'] . "'" : '';
            $height .= isset($post['height_inches']) ? $post['height_inches'] . "''" : '';
            if ($height != '') {
                $post['height'] = $height;
            }

            $seeking_height = '';
            $seeking_height .= isset($post['seeking_height_foot']) ? $post['seeking_height_foot'] . "'" : '';
            $seeking_height .= isset($post['seeking_height_inches']) ? $post['seeking_height_inches'] . "''" : '';
            if ($seeking_height != '') {
                $post['seeking_height'] = $seeking_height;
            }

            $seeking_height_to = '';
            $seeking_height_to .= isset($post['seeking_height_to_foot']) ? $post['seeking_height_to_foot'] . "'" : '';
            $seeking_height_to .= isset($post['seeking_height_to_inches']) ? $post['seeking_height_to_inches'] . "''" : '';
            if ($seeking_height_to != '') {
                $post['seeking_height_to'] = $seeking_height_to;
            }

            unset($post['height_foot'], $post['height_inches'], $post['seeking_height_foot'], $post['seeking_height_inches'], $post['seeking_height_to_foot'], $post['seeking_height_to_inches']);

            if ($this->current_profile) {
                if($this->current_profile->picture == ""){
                    $post['is_completed'] = 0; //if profile picture is not yet uploaded set is_completed to false
                }

                $this->current_profile->set($post);
                if ($this->current_profile->save()) {
                    Session::set_flash('success', 'User profile updated successfully.!');
                } else {
                    Session::set_flash('error', 'Updating user profile failed. Please try again!');
                }
            } else {
                Session::set_flash('error', 'Please login to edit profile.');
            }
        }

        if (Input::is_ajax()) {
            $response = Response::forge();
            $response->body(json_encode(array(
                        'status' => true,
                    )));
            return $response;
        } else {
            if ($this->current_profile->is_completed) {
                Response::redirect("profile/dashboard");
            } else {
                Response::redirect("profile/edit");
            }
        }
    }

    public function action_update_profile() {
        if (Input::method() == 'POST') {
            $post = Input::post();

            $user = $this->current_user;
            $profile = $this->current_profile;

            $upload_file = Input::file("profile_pic");

            if ($upload_file["size"] > 0) {

                $config = array(
                    'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($user['username']),
                    'auto_rename' => false,
                    'overwrite' => true,
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );

                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);
                    $profile->picture = $file['saved_as'];
                    $profile->save();

                    $filepath = $file['saved_to'] . $file['saved_as'];

                    foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                        Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                    }
                    Session::set_flash("success", "Your profile picture is successfully uploaded!");
                } else {
                    Session::set_flash("error", "The file is not valid. Please try again!");
                }

                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['error']);
                }
            } else {

                Session::set_flash("error", "Select a profile picture to upload!");
            }

            foreach ($post as $key => $value) {
                if ($value == '') {
                    unset($post[$key]);
                }
                else{
                    if(isset($post['city'])){
                        $post['city'] = trim($post['city']);
                    }                    
                }
            }

            $post['birth_date'] = strtotime(date('Y-m-d', mktime(0, 0, 0, $post['month'], $post['day'], $post['year'])));
            unset($post['month'], $post['day'], $post['year']);
           

            if ($this->current_profile) {
                              
                $post['is_completed'] = 1;
              
                $this->current_profile->set($post);
                if ($this->current_profile->save()) {
                    Session::set_flash('success', 'User profile updated successfully.!');
                } else {
                    Session::set_flash('error', 'Updating user profile failed. Please try again!');
                }
            } else {
                Session::set_flash('error', 'Please login to edit profile.');
            }

             Response::redirect("profile/thank_you");
        }      
    }

    public function action_upload_profile_picture() {
        if (Input::post()) {
            $post = Input::post();
            $user = $this->current_user;
            $profile = $this->current_profile;

            $upload_file = Input::file("picture");

            if ($upload_file["size"] > 0) {

                $config = array(
                    'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($user['username']),
                    'auto_rename' => false,
                    'overwrite' => true,
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );

                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);
                    $profile->picture = $file['saved_as'];
                    $profile->save();

                    $filepath = $file['saved_to'] . $file['saved_as'];

                    foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                        Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                    }
                    Session::set_flash("success", "Your profile picture is successfully uploaded!");
                } else {
                    Session::set_flash("error", "The file is not valid. Please try again!");
                }

                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['error']);
                }
            } else {
                Session::set_flash("error", "Select a profile picture to upload!");
            }
        }
        Response::redirect('profile/edit');
    }

    public function action_public_profile($id=null, $section=null)
    {
        if($id==null) {
            $profile = $this->current_profile;
        } else {
            $profile = Model_Profile::find($id);
        }

        if(!empty($profile->gender_id))
        {
            $gender = Model_Gender::find($profile->gender_id);
            $occupation = Model_Occupation::find($profile->occupation_id);
            $relationship_status = Model_Relationshipstatus::find($profile->relationship_status_id);
            $body_type = Model_Bodytype::find($profile->body_type_id);
            $ethnicity = Model_Ethnicity::find($profile->ethnicity_id);
            $eye_color = Model_Eyecolor::find($profile->eye_color_id);
            $hair_color = Model_Haircolor::find($profile->hair_color_id);
            $religion = Model_Religion::find($profile->religion_id);
            $smoke = Model_Smoke::find($profile->smoke_id);
            $drink = Model_Drink::find($profile->drink_id);
            $children = Model_Children::find($profile->children_id);
            $height = $profile->height;;
            $education = Model_Education::find($profile->education_id);
            $faith = Model_Faith::find($profile->faith_id);
            $politics = Model_Politics::find($profile->politics_id);
            $exercise = Model_Exercise::find($profile->exercise_id);
            
            $seeking_education = Model_Education::find($profile->seeking_education_id);
            $seeking_gender = Model_Gender::find($profile->seeking_gender_id);
            $seeking_children = Model_Children::find($profile->seeking_children_id);
            $seeking_occupation = Model_Occupation::find($profile->seeking_occupation_id);
            $seeking_relationship_status = Model_Relationshipstatus::find($profile->seeking_relationship_status_id);
            $seeking_body_type = Model_Bodytype::find($profile->seeking_body_type_id);
            $seeking_ethnicity = Model_Ethnicity::find($profile->seeking_ethnicity_id);
            $seeking_eye_color = Model_Eyecolor::find($profile->seeking_eye_color_id);
            $seeking_hair_color = Model_Haircolor::find($profile->seeking_hair_color_id);
            $seeking_religion = Model_Faith::find($profile->seeking_religion_id);
            $seeking_smoke = Model_Smoke::find($profile->seeking_smoke_id);
            $seeking_height= $profile->seeking_height;
            $seeking_politics = Model_Politics::find($profile->seeking_politics_id);
            $seeking_drink = Model_Drink::find($profile->seeking_drink_id);
            $seeking_exercise = Model_Exercise::find($profile->seeking_exercise_id);
            $view = View::forge('profile/public_profile', array(
                        'gender' => $gender,
                        'occupation' => $occupation,
                        'relationship_status' => $relationship_status,
                        'body_type' => $body_type,
                        'education' => $education,
                        'ethnicity' => $ethnicity,
                        'eye_color' => $eye_color,
                        'hair_color' => $hair_color,
                        'faith' => $faith,
                        'children' => $children,
                        'smoke' => $smoke,
                        'politics' => $politics,  
                        'drink' => $drink,                        
                        'height' => $height,                   
                        'exercise' => $exercise,
                        'seeking_gender' => $seeking_gender,
                        'seeking_education' => $seeking_education,
                        'seeking_occupation' => $seeking_occupation,
                        'seeking_children' => $seeking_children,
                        'seeking_relationship_status' => $seeking_relationship_status,
                        'seeking_body_type' => $seeking_body_type,
                        'seeking_ethnicity' => $seeking_ethnicity,
                        'seeking_eye_color' => $seeking_eye_color,
                        'seeking_hair_color' => $seeking_hair_color,
                        'seeking_religion' => $seeking_religion,
                        'seeking_smoke' => $seeking_smoke,
                        'seeking_politics' => $seeking_politics,
                        'seeking_height' => $seeking_height,
                        'seeking_drink' => $seeking_drink,
                        'seeking_exercise' => $seeking_exercise,
                    ));

            $friends=Model_Friendship::get_friends($this->current_profile->id);
            $view->friends= $friends;
            $view->profile = $profile;
            $view->latest_photos = Model_Image::query()->where("member_id", $profile->id)->order_by('created_at', 'desc')->limit(4)->get();
            $view->featured_events = Model_Referedevent::get_invited_events($profile->id);
            $view->section = $section;

            $notifications = Model_Notification::get_public_notifications($profile->id);
            if($notifications) {
                 $view->notifications = $notifications;
            }

            $view->set_global("active_page", "dashboard");
            $view->set_global('page_js', 'profile/public_profile.js');
            $view->set_global('page_css', 'profile/public_profile.css');

            $this->template->title = 'WHERE WE ALL MEET &raquo; Public Profile';
            $this->template->content = $view;
        }
        else
        {
            \Fuel\Core\Response::redirect('pages/404');
        }
   }

    public function action_my_profile()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
        $profile = $this->current_profile;
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
        	$referd = false;
        }
        else {
        	$referd = true;
        }
        
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        $gender = Model_Gender::find($profile->gender_id);
        $occupation = Model_Occupation::find($profile->occupation_id);
        $relationship_status = Model_Relationshipstatus::find($profile->relationship_status_id);
        $body_type = Model_Bodytype::find($profile->body_type_id);
        $ethnicity = Model_Ethnicity::find($profile->ethnicity_id);
        $eye_color = Model_Eyecolor::find($profile->eye_color_id);
        $hair_color = Model_Haircolor::find($profile->hair_color_id);
        $religion = Model_Religion::find($profile->religion_id);
        $smoke = Model_Smoke::find($profile->smoke_id);
        $drink = Model_Drink::find($profile->drink_id);
        $seeking_gender = Model_Gender::find($profile->seeking_gender_id);
        $seeking_occupation = Model_Occupation::find($profile->seeking_occupation_id);
        $seeking_relationship_status = Model_Relationshipstatus::find($profile->seeking_relationship_status_id);
        $seeking_body_type = Model_Bodytype::find($profile->seeking_body_type_id);
        $seeking_ethnicity = Model_Ethnicity::find($profile->seeking_ethnicity_id);
        $seeking_eye_color = Model_Eyecolor::find($profile->seeking_eye_color_id);
        $seeking_hair_color = Model_Haircolor::find($profile->seeking_hair_color_id);
        $seeking_religion = Model_Religion::find($profile->seeking_religion_id);
        $seeking_smoke = Model_Smoke::find($profile->seeking_smoke_id);
        $seeking_drink = Model_Drink::find($profile->seeking_drink_id);
        $view = View::forge('profile/my_profile', array(
                    'gender' => $gender,
                    'occupation' => $occupation,
                    'relationship_status' => $relationship_status,
                    'body_type' => $body_type,
                    'ethnicity' => $ethnicity,
                    'eye_color' => $eye_color,
                    'hair_color' => $hair_color,
                    'religion' => $religion,
                    'smoke' => $smoke,
                    'drink' => $drink,
                    'seeking_gender' => $seeking_gender,
                    'seeking_occupation' => $seeking_occupation,
                    'seeking_relationship_status' => $seeking_relationship_status,
                    'seeking_body_type' => $seeking_body_type,
                    'seeking_ethnicity' => $seeking_ethnicity,
                    'seeking_eye_color' => $seeking_eye_color,
                    'seeking_hair_color' => $seeking_hair_color,
                    'seeking_religion' => $seeking_religion,
                    'seeking_smoke' => $seeking_smoke,
                    'seeking_drink' => $seeking_drink,
                ));
        $view->current_user = $this->current_user;
        $view->profile = $profile;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->latest_photos = Model_Image::query()->where("member_id", $profile->id)->order_by('created_at', 'desc')->limit(10)->get();
	    $view->featured_datingPackages = Model_Datingpackage::get_random_active_dating_packages_by_state(9999,$this->current_profile->id);

        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->my_friends = Model_Friendship::get_friends($this->current_profile->id);
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_profile.css');


        $this->template->title = 'WHERE WE ALL MEET &raquo; My Profile';
        $this->template->content = $view;
    }

    public function action_my_hellos()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	 
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	 
    	if(count($subsc) === 1)
    	{
    		$subscribed = true;
    	}
    	else
    	{
    		$subscribed = false;
    	}
        $view = View::forge('profile/my_hellos');

        $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
	$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
     $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();	
      $view->profile_address = $profile_address;	
	  $view->profile_state = $profile_state;	

        $view->current_user = $this->current_user;
        $view->hello_profiles = $hello_profiles;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");        
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_hellos.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Hellos';
        $this->template->content = $view;
    }

    public function action_my_favorites()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
        $view = View::forge('profile/my_favorites');
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
        	$referd = false;
        }
        else {
        	$referd = true;
        }
        
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        $favorites_profiles = array();
        $profile_ids = array();
        $favorites = Model_Favorite::find('all', array("where" => array(array("member_id", $this->current_profile->id))));
        foreach ($favorites as $favorite) {
            array_push($profile_ids, $favorite->favorite_member_id);
        }
        if (!empty($profile_ids)) {
            $favorites_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
       $profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
     $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();	
      $view->profile_address = $profile_address;	
	  $view->profile_state = $profile_state;	
        $view->current_user = $this->current_user;
        $view->favorites_profiles = $favorites_profiles;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_photos.js');
        $view->set_global('page_css', 'profile/my_hellos.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Favorites';
        $this->template->content = $view;
    }

    public function action_my_friends()
    {
        $view = View::forge('profile/my_friends');
        $view->pending_friends = Model_Friendship::get_pending_friends($this->current_profile->id);

        if(Input::post() && Input::post('search_text'))
        {
            $view->friends = Model_Friendship::search_friends($this->current_profile->id, Input::post('search_text'));
            $view->search_text = Input::post('search_text');
        } else {
            $view->friends = Model_Friendship::get_friends($this->current_profile->id);
        }

        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_friends.js');
        $view->set_global('page_css', 'profile/dashboard.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Friends';
        $this->template->content = $view;
    }

    public function action_my_photos()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	 
    	if(count($subsc) === 1)
    	{
    		$subscribed = true;
    	}
    	else
    	{
    		$subscribed = false;
    	}

        $view = View::forge('profile/my_photos');
        $view->profile_address = $this->current_profile->city;
	    $view->profile_state = $this->current_profile->state;
        $view->current_user = $this->current_user;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->images = Model_Image::find('all', array("where" => array(array("member_id", $this->current_profile->id))));
        
       // print_r( $view->images);
        //die;

        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_photos.js');
        $view->set_global('page_css', 'profile/dashboard.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Photos';
        $this->template->content = $view;
    }

    public function action_manage_friends()
    {
        $view = View::forge('profile/manage_friends');
        $view->friends = Model_Friendship::get_friends($this->current_profile->id);


        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_friends.js');
        $view->set_global('page_css', 'profile/dashboard.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Friends';
        $this->template->content = $view;
    }

    public function action_manage_photos()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	 
    	if(count($subsc) === 1)
    	{
    		$subscribed = true;
    	}
    	else
    	{
    		$subscribed = false;
    	}
        $view = View::forge('profile/manage_photos');

		 //$count_image = Model_Friendship::get_friends($this->current_profile->id);
		 //print_r(count($count_image));
		 // die;
        if (Input::post('btnRemovePhoto')) {
            if (count(Input::post('image_items')) > 0) {
                $images = Input::post('image_items');
                foreach ($images as $image_id) {
                    if($image_id == "profile") {
                        try {
                            $image_directory = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($this->current_user['username']) . DIRECTORY_SEPARATOR;
                            $file = File::get($image_directory . $this->current_profile->picture); //delete the main image
                            $file->delete();
                            foreach (Model_Profile::$thumbnails as $type => $dimensions) { //delete all thumbnails
                                $file = File::get($image_directory . $type . "_" . $this->current_profile->picture);
                                $file->delete();
                            }
                        } catch (Exception $e) {

                        }
                        $this->current_profile->picture = "";
                        $this->current_profile->save();
                    }
                    else {
                        $objImage = Model_Image::find($image_id);
                        if ($objImage) {
                            $image_directory = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($this->current_user['username']) . DIRECTORY_SEPARATOR;
                            try {
                                $file = File::get($image_directory . $objImage->file_name); //delete the main image
                                $file->delete();
                                foreach (Model_Profile::$thumbnails as $type => $dimensions) { //delete all thumbnails
                                    $file = File::get($image_directory . $type . "_" . $objImage->file_name);
                                    $file->delete();
                                }
                            } catch (Exception $e) {

                            }
                            $objImage->delete();
                        }
                    }
                }
                Session::set_flash("success", "Photos deleted successfully !");
            } else {
                Session::set_flash("error", "Select at least one photo to delete !");
            }
             Response::redirect('profile/my_photos');
        }
           $profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
           $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();	
		 $view->profile_address = $profile_address;	
	    $view->profile_state = $profile_state;	
        $view->current_user = $this->current_user;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->my_photos = Model_Image::find('all', array("where" => array(array("member_id", $this->current_profile->id))));
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_photos.js');
        $view->set_global('page_css', 'profile/my_photos.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Manage Photos';
        $this->template->content = $view;
    }

    public function action_remove_photo(){

        if (Input::post()) {
            $post = Input::post();
                $image_id = Input::post('image');
            
                    if($image_id == "profile") {
                        try {
                            $image_directory = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($this->current_user['username']) . DIRECTORY_SEPARATOR;
                            $file = File::get($image_directory . $this->current_profile->picture); //delete the main image
                            $file->delete();
                            foreach (Model_Profile::$thumbnails as $type => $dimensions) { //delete all thumbnails
                                $file = File::get($image_directory . $type . "_" . $this->current_profile->picture);
                                $file->delete();
                            }
                        } catch (Exception $e) {

                        }
                        $this->current_profile->picture = "";
                        $this->current_profile->save();
                    }
                    else {
                        $objImage = Model_Image::find($image_id);
                        if ($objImage) {
                            $image_directory = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($this->current_user['username']) . DIRECTORY_SEPARATOR;
                            try {
                                $file = File::get($image_directory . $objImage->file_name); //delete the main image
                                $file->delete();
                                foreach (Model_Profile::$thumbnails as $type => $dimensions) { //delete all thumbnails
                                    $file = File::get($image_directory . $type . "_" . $objImage->file_name);
                                    $file->delete();
                                }
                            } catch (Exception $e) {

                            }
                            $objImage->delete();
                        }
                    }
             
                Session::set_flash("success", "Photo deleted successfully !");
            } else {
                Session::set_flash("error", "Select at least one photo to delete !");
            }
         Response::redirect('profile/my_photo_setting');
    }

    public function action_upload_photo() {
        if (Input::post()) {
            $post = Input::post();
            $user = $this->current_user;
            $profile = $this->current_profile;

            $upload_file = Input::file("picture");

            if ($upload_file["size"] > 0) {

                $config = array(
                    'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($user['username']),
                    'auto_rename' => false,
                    'overwrite' => true,
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );

                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);
                    $post['member_id'] = $this->current_profile->id;
                    $post['file_name'] = $file['saved_as'];
                    $post['dashboard'] = 1;
                    $objImage = Model_Image::forge($post);
                    $objImage->save();

                    $filepath = $file['saved_to'] . $file['saved_as'];

                    Image::load($filepath)->crop($post['x'], $post['y'],$post['x'] + $post['w'], $post['y'] + $post['h'])->save($filepath);

                    foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                        Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                    }
                    Session::set_flash("success", "Photo uploaded successfully!");
                } else {
                    Session::set_flash("error", "The file is not valid. Please try again!");
                }

                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['error']);
                }
            } else {
                Session::set_flash("error", "Select a picture to upload!");
            }
        }
        Response::redirect('profile/my_photos');
    }

    public function action_upload_photo_settings() {
        if (Input::post()) {
            $post = Input::post();
            $user = $this->current_user;
            $profile = $this->current_profile;

            $upload_file = Input::file("picture");

            if ($upload_file["size"] > 0) {

                $config = array(
                    'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($user['username']),
                    'auto_rename' => false,
                    'overwrite' => true,
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );

                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);
                    $post['member_id'] = $this->current_profile->id;
                    $post['file_name'] = $file['saved_as'];
                    $post['dashboard'] = 1;
                    $objImage = Model_Image::forge($post);
                    $objImage->save();

                    $filepath = $file['saved_to'] . $file['saved_as'];

                    foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                        Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                    }
                    Session::set_flash("success", "Photo uploaded successfully!");
                } else {
                    Session::set_flash("error", "The file is not valid. Please try again!");
                }

                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['error']);
                }
            } else {
                Session::set_flash("error", "Select a picture to upload!");
            }
        }
        Response::redirect('profile/my_photo_setting');
    }

    public function action_upload_photo_dashboard() {
        if (Input::post()) {
            $post = Input::post();
            $user = $this->current_user;
            $profile = $this->current_profile;

            $upload_file = Input::file("picture");

            if ($upload_file["size"] > 0) {

                $config = array(
                    'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($user['username']),
                    'auto_rename' => false,
                    'overwrite' => true,
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );

                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);
                    $post['member_id'] = $this->current_profile->id;
                    $post['file_name'] = $file['saved_as'];
                    $post['dashboard'] = 1;
                    $objImage = Model_Image::forge($post);
                    $objImage->save();

                    $filepath = $file['saved_to'] . $file['saved_as'];

                    foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                        Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                    }
                        $image_id=DB::select('id')
                                     ->from('images')
                                     ->where('file_name',$file['saved_as'])
                                     ->execute();


                        Model_Notification::save_notifications(
                        Model_Notification::PHOTO_UPLOADED,
                        $image_id[0]['id'],
                        0,
                        $this->current_profile->id
                        );

                    Session::set_flash("success", "Photo uploaded successfully!");

                } else {
                    Session::set_flash("error", "The file is not valid. Please try again!");
                }

                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['error']);
                }
            } else {
                Session::set_flash("error", "Select a picture to upload!");
            }
        }
        Response::redirect('profile/dashboard');
    }

    public function action_upload_profile_photo() {
        if (Input::method() == 'POST') {
            $post = Input::post();

            $user = $this->current_user;
            $profile = $this->current_profile;

            $upload_file = Input::file("profile_pic");


            if ($upload_file["size"] > 0) {

                $config = array(
                    'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($user['username']),
                    'auto_rename' => false,
                    'overwrite' => true,
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );

                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);
                    $profile->picture = $file['saved_as'];
                    $profile->save();

                    $filepath = $file['saved_to'] . $file['saved_as'];

                    foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                        Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                    }
                    Session::set_flash("success", "Your profile picture is successfully uploaded!");
                } else {
                    Session::set_flash("error", "The file is not valid. Please try again!");
                }

                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['error']);
                }      
                
            } else {
                Session::set_flash("error", "Select a picture to upload!");
            }
        }

        Response::redirect('profile/my_photo_setting');
    }

    public function action_my_setting($error = null) {
        $view = View::forge('profile/my_setting');

        if(isset($error)){
            $view->error = $error;
        }
        $username = Auth::get_screen_name(); 
        $password = Auth::get('password');
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
        	$referd = false;
        }
        else {
        	$referd = true;
        }
        
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        $online_members = Quicksearch::get_online_members($username, $password);
         
		 /*$setting_value=Db::select('profile_id')
		            ->from('setting')
					->where('profile_id',$this->current_profile->id)
					->execute();
				
	      if(empty($setting_value[0]['profile_id'])){
		        $view = View::forge('profile/my_setting');
		                   }
	             else {
	         $view = View::forge('profile/update_setting');

	                  }
    */  
	     // $blocked_profile=Model_Profile::find('all',array("where"=> array(array("is_blocked",0))));
		 //$profiles = Model_profile::find('all',);
		/* $savedsetting=Model_Setting::find('all',array(
		                     "where"=> array(
							 array("profile_id" ,$this->current_profile->id),
							 )
		               ));
					
		$profiles = Model_profile::find('all', array(
                    "where" => array(
                        array("is_blocked",1),
                   )
                ));
		
		
	   $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
		
		*/
		
        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
           
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
				$setting_id = Model_setting::find('all', array(
                    "where" => array(
                        array("profile_id", $this->current_profile->id),
                     )
                ));
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
     $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();	
      $view->profile_address = $profile_address;	
	  $view->profile_state = $profile_state;	
        $view->getemailaddress=$getemailaddress;
		//$view->savedsetting=$savedsetting;
        $view->current_user = $this->current_user;
        //$view->hello_profiles = $hello_profiles;
        $view->online_members = $online_members ;
        $view->referd  =  $referd;
		//$view->setting_id=$setting_id; 
        $view->subscribed  =  $subscribed;
		//$view->set('profiles', $profiles);
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Hellos';
        $this->template->content = $view;
    }
	
    public function action_my_notification() {
        $view = View::forge('profile/my_notification');
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Notifications Setting';
        $this->template->content = $view;
    }
	
	public function action_my_profile_setting() {
       
        $username = Auth::get_screen_name(); 
        $password = Auth::get('password');
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
        	$referd = false;
        }
        else {
        	$referd = true;
        }
        
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        $online_members = Quicksearch::get_online_members($username, $password);
         
		$gender = Model_Gender::find('all');
        $state = Model_State::find('all');
        $occupation = Model_Occupation::find('all');
        $body_types = Model_Bodytype::find('all');
        $relationship_status = Model_Relationshipstatus::find('all');
        $body_types = Model_Bodytype::find('all');
        $eye_color = Model_Eyecolor::find('all');
        $hair_color = Model_Haircolor::find('all');
        $ethnicities = Model_Ethnicity::find('all');
        $educations = Model_Education::find('all');
        $faiths = Model_Faith::find('all');
        $children = Model_Children::find('all');
        $exercises = Model_Exercise::find('all');
        $politics = Model_Politics::find('all');
        $children = Model_Children::find('all');
        $religion = Model_Religion::find('all');
        $smokes = Model_Smoke::find('all');
        $drinks = Model_Drink::find('all');
        $priority_field = Model_Priorityfield::find('all');

        $view = View::forge('profile/my_profile_setting', array(
                    'genders' => $gender,
                    'state' => $state,
                    'occupation' => $occupation,
                    'relationship_status' => $relationship_status,
                    'body_types' => $body_types,
                    'ethnicities' => $ethnicities,
                    'eye_color' => $eye_color,
                    'children' => $children,
                    'exercises' => $exercises,
                    'smokes' => $smokes,
                    'educations' => $educations,
                    'body_types' => $body_types,
                    'faiths' => $faiths,
                    'politics' => $politics,
                    'hair_color' => $hair_color,
                    'religion' => $religion,
                    'drinks' => $drinks,
                    'priority_field' => $priority_field,
                ));

        $preferred_members = DB::select('id', 'user_id', 'first_name', 'last_name', 'picture', 'city', 'state')
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->where('birth_date', '>=', Model_Profile::get_birth_date_from_age($this->current_profile->ages_to))
                        ->where('birth_date', '<=', Model_Profile::get_birth_date_from_age($this->current_profile->ages_from))
                        ->where('gender_id', $this->current_profile->gender_id == 1 ? 2 : 1) //inorder to select opposite gender
                        ->where('state', $this->current_profile->state)
                        ->where('disable', 0)
                        ->where('is_activated', 1)
                        ->where('user_id', 'not in', Model_Profile::get_admin_user_ids() )
                        ->where('member_type_id', '<>', Model_Membershiptype::DATING_AGENT_MEMBER)
                        ->order_by(DB::expr('RAND()'))->limit(4)->execute()->as_array();

        $view->preferred_members = $preferred_members;
        $view->profile = $this->current_profile;
        $view->current_user = $this->current_user;

        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
           
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
				$setting_id = Model_setting::find('all', array(
                    "where" => array(
                        array("profile_id", $this->current_profile->id),
                     )
                ));
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
     $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();	
      $view->profile_address = $profile_address;	
	  $view->profile_state = $profile_state;	
      $view->getemailaddress=$getemailaddress;
		//$view->savedsetting=$savedsetting;
        $view->current_user = $this->current_user;
        //$view->hello_profiles = $hello_profiles;
        $view->online_members = $online_members ;
        $view->referd  =  $referd;
		$view->setting_id=$setting_id; 
        $view->subscribed  =  $subscribed;
		//$view->set('profiles', $profiles);
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Profile Settings';
        $this->template->content = $view;
    }
	
	public function action_my_bio_setting() {
        $view = View::forge('profile/my_bio_setting');

        $view->educations = Model_Education::find('all');
        $view->faiths = Model_Faith::find('all');
        $view->children = Model_Children::find('all');
        $view->body_types = Model_Bodytype::find('all');
        $view->exercises = Model_Exercise::find('all');
        $view->politics = Model_Politics::find('all');
        $view->children = Model_Children::find('all');
        $view->religion = Model_Religion::find('all');
        $view->smokes = Model_Smoke::find('all');
        $view->occupations = Model_Occupation::find('all');
        $view->ethnicities = Model_Ethnicity::find('all');
        $view->drinks = Model_Drink::find('all');

        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Bio Settings';
        $this->template->content = $view;
    }	
	
	public function action_my_photo_setting() {
        $view = View::forge('profile/my_photo_setting');
         $username = Auth::get_screen_name(); 
        $password = Auth::get('password');
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
        	$referd = false;
        }
        else {
        	$referd = true;
        }
        
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        $online_members = Quicksearch::get_online_members($username, $password);
         
		/* $setting_value=Db::select('profile_id')
		            ->from('setting')
					->where('profile_id',$this->current_profile->id)
					->execute();
				
	      if(empty($setting_value[0]['profile_id'])){
		        $view = View::forge('profile/my_photo_setting');
		                   }
	             else {
	         $view = View::forge('profile/update_setting');
	                  }
	     // $blocked_profile=Model_Profile::find('all',array("where"=> array(array("is_blocked",0))));
		 //$profiles = Model_profile::find('all',);
		 $savedsetting=Model_Setting::find('all',array(
		                     "where"=> array(
							 array("profile_id" ,$this->current_profile->id),
							 )
		               ));
					
		$profiles = Model_profile::find('all', array(
                    "where" => array(
                        array("is_blocked",1),
                   )
                ));
		
		
	     $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
		
		
		
        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
           
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
				$setting_id = Model_setting::find('all', array(
                    "where" => array(
                        array("profile_id", $this->current_profile->id),
                     )
                ));
        */


if (Input::post('btnRemovePhoto')) {
            if (count(Input::post('image_items')) > 0) {
                $images = Input::post('image_items');
                foreach ($images as $image_id) {
                    if($image_id == "profile") {
                        try {
                            $image_directory = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($this->current_user['username']) . DIRECTORY_SEPARATOR;
                            $file = File::get($image_directory . $this->current_profile->picture); //delete the main image
                            $file->delete();
                            foreach (Model_Profile::$thumbnails as $type => $dimensions) { //delete all thumbnails
                                $file = File::get($image_directory . $type . "_" . $this->current_profile->picture);
                                $file->delete();
                            }
                        } catch (Exception $e) {

                        }
                        $this->current_profile->picture = "";
                        $this->current_profile->save();
                    }
                    else {
                        $objImage = Model_Image::find($image_id);
                        if ($objImage) {
                            $image_directory = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($this->current_user['username']) . DIRECTORY_SEPARATOR;
                            try {
                                $file = File::get($image_directory . $objImage->file_name); //delete the main image
                                $file->delete();
                                foreach (Model_Profile::$thumbnails as $type => $dimensions) { //delete all thumbnails
                                    $file = File::get($image_directory . $type . "_" . $objImage->file_name);
                                    $file->delete();
                                }
                            } catch (Exception $e) {

                            }
                            $objImage->delete();
                        }
                    }
                }
                Session::set_flash("success", "Photos deleted successfully !");
            } else {
                Session::set_flash("error", "Select at least one photo to delete !");
            }
        }
           
        
        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
     $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();	

        $view->profile_address = $profile_address;	
	    $view->profile_state = $profile_state;	
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->my_photos = Model_Image::find('all', array("where" => array(array("member_id", $this->current_profile->id))));
        $view->getemailaddress=$getemailaddress;
		//$view->savedsetting=$savedsetting;
        $view->current_user = $this->current_user;
        //$view->hello_profiles = $hello_profiles;
        $view->online_members = $online_members ;
        $view->referd  =  $referd;
		//$view->setting_id=$setting_id; 
        $view->subscribed  =  $subscribed;
		//$view->set('profiles', $profiles);
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Photo Settings';
        $this->template->content = $view;
    }		

    public function action_crop_photo(){
             if (Input::method() == 'POST') {
                    $targ_w = $_POST['targ_w'];
                    $targ_h = $_POST['targ_h'];
                    $the_name = explode(".", $_POST['original']);
                    $name = $the_name[0];
                    $extension =$the_name[1];

                if($extension == 'jpg'){
                    $jpeg_quality = 90;
                    $src =trim($_POST['photo_url']);
                    $img_r = imagecreatefromjpeg($src);
                    $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
                    imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'], $targ_w,$targ_h,$_POST['w'],$_POST['h']);
                    imagejpeg($dst_r,$src,$jpeg_quality);

                    foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                        $file_name = $_POST['path']. $type . "_" .$_POST['original'];
                        if(file_exists($file_name)) {
                            unlink($file_name);
                        }
                        Image::load($src)->crop_resize($dimensions["width"], $dimensions["height"])->save( $_POST['path']. $type . "_" .$name);
                    }
                } else if($extension == 'png'){
                    $png_quality = 9;
                    $src = trim($_POST['photo_url']);
                    $img_r = imagecreatefrompng($src);
                    $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

                    imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'], $targ_w,$targ_h,$_POST['w'],$_POST['h']);
                    imagepng($dst_r,$src,$png_quality);

                    foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                        $file_name = $_POST['path']. $type . "_" .$_POST['original'];
                        if(file_exists($file_name)) {
                            unlink($file_name);
                        }
                        Image::load($src)->crop_resize($dimensions["width"], $dimensions["height"])->save( $_POST['path']. $type . "_" .$name);
                    }
                }
                //echo '<img src="'.$src.'">';
                //exit;
                 $response = Response::forge();
                 return $response->body(json_encode(array(
                     'status' => true,
                     'url' => Uri::create("profile/my_photo_setting"),
                 )));
             }
    }

    public function action_delete_account() {
       $view = View::forge('profile/my_setting');
       $username = Auth::get_screen_name();
       $password = Auth::get('password');
       $email = DB::select('refered_email')
       ->from('referedemails')
       ->where('refered_email', $this->current_user->email)
       ->execute();
       $num_records = count($email);
       if($num_records == 0){
       	$referd = false;
       }
       else {
       	$referd = true;
       }
       
       $subsc = Model_Service::query()
       ->where("profile_id", $this->current_profile->id)
       ->get_one();
        
       if(count($subsc) === 1)
       {
       	$subscribed = true;
       }
       else
       {
       	$subscribed = false;
       }
	    $online_members = Quicksearch::get_online_members($username, $password);
		$savedsetting=Model_Setting::find('all',array(
		                     "where"=> array(
							 array("profile_id" ,$this->current_profile->id),
							 )
		               ));
	   if (Input::method() == 'POST') {
	   	$val = Model_Setting::validate('create');
	         //echo Auth::hash_password($_POST['paswword']).'<br>';
			 //echo $password;
			 
			 
			 $email=$_POST['email'];
			 $emailcheck=DB::select('id')
			             ->from('users')
						 ->where('email',$email)
						 ->execute();
						 
						
			 if ($val->run()) 
			 {
			  //echo $_POST['paswword'];
			 if($password==Auth::hash_password($_POST['paswword']))
			    {
			     $disable=DB::update('profiles')
				            ->where('user_id',$emailcheck[0]['id'])
							->value('disable',1)
							->execute();
							Response::redirect(Router::get("login"));
			     }
				
			  }
			 else {
                    Session::set_flash('error', $val->error());
					 $view = View::forge('profile/update_setting');
					
                }

	       }
		   $profiles = Model_profile::find('all', array(
                    "where" => array(
                        array("is_blocked",1),
                   )
                ));
 $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
           
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
				$setting_id = Model_setting::find('all', array(
                    "where" => array(
                        array("profile_id", $this->current_profile->id),
                     )
                ));
        $view->getemailaddress=$getemailaddress;
         $view->setting_id=$setting_id; 
		
        $view->current_user = $this->current_user;
        $view->hello_profiles = $hello_profiles;
        $view->online_members = $online_members ;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
		$view->set('profiles',$profiles);
		 $view->savedsetting=$savedsetting;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Hellos';
        $this->template->content = $view;
    
           
       
    }

    public function action_insert_setting() {
	 $view = View::forge('profile/my_setting');
       $username = Auth::get_screen_name();
       $password = Auth::get('password');
       $email = DB::select('refered_email')
       ->from('referedemails')
       ->where('refered_email', $this->current_user->email)
       ->execute();
       $num_records = count($email);
       if($num_records == 0){
       	$referd = false;
       }
       else {
       	$referd = true;
       }
       
       $subsc = Model_Service::query()
       ->where("profile_id", $this->current_profile->id)
       ->get_one();
        
       if(count($subsc) === 1)
       {
       	$subscribed = true;
       }
       else
       {
       	$subscribed = false;
       }
	    $online_members = Quicksearch::get_online_members($username, $password);
	
		 
		if (Input::method() == 'POST') {
	
		   if(empty($_POST['list']) )
		   {
		      $_POST['list']=0;
		   }			 
		if(empty($_POST['list1']))
			       {
				   $_POST['list1']=0; 
				   }
		if(empty($_POST['list2']))
				   {
				    $_POST['list2']=0; 
				   }
		if(empty($_POST['list3']))
				   {
				   $_POST['list3']=0; 
				   }
				   
		  
	   $hello=$_POST['hellosetting'];
	   $message=$_POST['messagesetting'];
	   $perweek=$_POST['perweek'];
	   $subscribe=$_POST['subscribe'];
				  // echo $_POST['list'];
				   // echo $_POST['list1'];
					// echo $_POST['list2'];
					 // echo $_POST['list3'];
	 		   
	    $setting = Model_Setting::forge(array(
                      'private_profile'=> $_POST['list'],
                      'data_sharing'=>$_POST['list1'],
                      'where_we_all_meet'=> $_POST['list2'],
                      'hello_notification'=>$hello,
                      'message_notification'=>$message,
                      'top_matches'=>$perweek,
                      'special_offers'=>$subscribe,
                      'send_me_email_notifcation'=>$_POST['list3'],
					   'profile_id'=>$this->current_profile->id,
                           ));
				if ($setting and $setting->save())
				{	
				 Session::set_flash('success', 'updated file ');
                 Response::redirect('profile/my_setting');
						   
		 }
		}
		 $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
           
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
        $view->getemailaddress=$getemailaddress;

        $view->current_user = $this->current_user;
        $view->hello_profiles = $hello_profiles;
        $view->online_members = $online_members ;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Hellos';
        $this->template->content = $view;
     
	 }

    public function action_updating_setting() {
	       $view = View::forge('profile/my_setting');
         $username = Auth::get_screen_name(); 
        $password = Auth::get('password');
        $online_members = Quicksearch::get_online_members($username, $password);
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
        	$referd = false;
        }
        else {
        	$referd = true;
        }
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        if (Input::method() == 'POST') {
		   if(empty($_POST['list']) )
		   {
		      $_POST['list']=0;
		   }			 
		if(empty($_POST['list1']))
			       {
				   $_POST['list1']=0; 
				   }
		if(empty($_POST['list2']))
				   {
				    $_POST['list2']=0; 
				   }
		if(empty($_POST['list3']))
				   {
				   $_POST['list3']=0; 
				   }
			 $hello=$_POST['hellosetting'];
	   $message=$_POST['messagesetting'];
	   $perweek=$_POST['perweek'];
	   $subscribe=$_POST['subscribe'];

	   $result = DB::update('setting')
                  ->set(array(
                      'private_profile'=>$_POST['list'],
                      'data_sharing'=>$_POST['list1'],
					  'where_we_all_meet'=>$_POST['list2'],
                      'hello_notification'=>$hello,
					  'message_notification'=>$message,
                      'top_matches'=>$perweek,
					  'special_offers'=>$subscribe,
                      'send_me_email_notifcation'=>$_POST['list3'],
    ))
    ->where('profile_id', '=',$this->current_profile->id)
    ->execute();
		    Session::set_flash('success', 'updated file ');
                 Response::redirect('profile/my_setting');
						   
		 
					  
			}		  
        $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
           
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
        $view->getemailaddress=$getemailaddress;

        $view->current_user = $this->current_user;
        $view->hello_profiles = $hello_profiles;
        $view->online_members = $online_members ;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Hellos';
        $this->template->content = $view;
	  }

	public function action_refer_friends()
    {
	    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
		if (Input::method() == 'POST') {
		$refer_from = Input::post('refer_from');
		$refer_id = Input::post('refered_id');
		$refer_to= $_POST['referOption'];
		$status= 0;
		 $refer_friends = Model_Referfriends::forge(array(
                                        'refer_from' => $refer_from,
                                        'refer_to' => $refer_to,
										'refered_id' => $refer_id,
                                        'status' => $status,
                                        ));
	    if ($refer_friends and $refer_friends->save()) {
                       	{
                      Session::set_flash('success', 'successfully refered to a friends ');
                         }
		
		 }
		 }
     $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        $view = View::forge('profile/my_friends');
        $view->current_user = $this->current_user;
        $view->pending_friends = Model_Friendship::get_pending_friends($this->current_profile->id);
        $view->friends = Model_Friendship::get_friends($this->current_profile->id);
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->online_members  =  $online_members;  
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_friends.js');      
        $view->set_global('page_css', 'profile/my_friends.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; My Friends';
        $this->template->content = $view;
	
	
    	    }

    public function action_accept_invitation($invitation_id)
    {
        if( ! Input::is_ajax())
        \Fuel\Core\Response::redirect('pages/404');

        $response = \Fuel\Core\Response::forge();
        $invitation = Model_Referfriends::find($invitation_id);
        $invitation->status = Model_Referfriends::INVITATION_ACCEPTED;

        if($invitation->save()){
            return $response->body(json_encode(array(
                'accepted' => true,
                'url' => \Fuel\Core\Uri::create('profile/public_profile/'.$invitation->refered_id)
            )));
        }

        return $response->body(json_encode(array(
            'accepted' => false,
        )));

    }

    public function action_reject_invitation($invitation_id)
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('pages/404');

        $response = \Fuel\Core\Response::forge();
        $invitation = Model_Referfriends::find($invitation_id);
        $invitation->status = Model_Referfriends::INVITATION_REJECTED;

        if($invitation->save()){
            return $response->body(json_encode(array(
                'rejected' => true,
            )));
        }

        return $response->body(json_encode(array(
            'rejected' => false,
        )));

    }

    public function action_accept_suggested_match()
    {
        $response = Response::forge();
        if(Input::is_ajax()) {
            $objReceiver = Model_Profile::find(Input::post("member_id"));
            if (!$objReceiver) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user you are trying to send a friend request to does not exist!"
                )));
            }
            else if($already_sent = Model_Friendship::request_exchanged($this->current_profile->id, Input::post("member_id"))){
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "A friend request has already been exchanged with this person!"
                )));
            }
            else {
                $friendship = Model_Friendship::forge(array(
                    "sender_id" => $this->current_profile->id,
                    "receiver_id" => Input::post("member_id"),
                    "status" => Model_Friendship::STATUS_SENT
                ));
                $friendship->save();

                Model_Notification::save_notifications(
                    Model_Notification::FRIEND_REQUEST_SENT,
                    $friendship->id,
                    $friendship->receiver_id,
                    $friendship->sender_id
                );

                Email::forge()
                    ->to(Model_Profile::get_email($objReceiver->user_id))
                    ->from("admin@whereweallmeet.com")
                    ->subject("You have a new Friend Request")
                    ->html_body(
                        View::forge('email/friend_request', array("message" => $this->current_user->username .' has sent you a friend request', ))
                    )->send();

                $response->body(json_encode(array(
                    'status' => true,
                    'message' => "Your friendship request sent to <strong>" . Model_Profile::get_username($objReceiver->user_id). "</strong>",
                )));
            }
            return $response;
        } else {
            return $response->set_status(400);
        }
    }

    public function action_reject_suggested_match()
    {
        $response = Response::forge();
        if(Input::is_ajax()) {
            $objMember = Model_Profile::find(Input::post("member_id"));
            if (!$objMember) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user you are trying to dislike does not exist!"
                )));
            }
            else if($already_sent = Model_Dislike::is_member_disliked($this->current_profile->id, Input::post("member_id"))){
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "Member is already in dislike list!"
                )));
            }
            else {
                $dislike = Model_Dislike::forge(array(
                    "member_id" => $this->current_profile->id,
                    "disliked_member_id" => Input::post("member_id")
                ));
                $dislike->save();

                $response->body(json_encode(array(
                    'status' => true,
                    'message' => "Member successfully added to dislike list",
                )));
            }
            return $response;
        } else {
            return $response->set_status(400);
        }
    }

    public function action_get_profile_picture() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user) {
                $profile = Model_Profile::find('first', array("where" => array(array("user_id", $user->id))));
                if($profile) {
                    $response->body(json_encode(array(
                        'status' => true,
                        'profile_picture' => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list"),
                    )));
                }
                else {
                    $response->body(json_encode(array(
                        'status' => false,
                        'profile_picture' => Model_Profile::get_picture("", 0, "members_list"),
                    )));
                }
            }
            else {
                $response->body(json_encode(array(
                    'status' => false,
                    'profile_picture' => Model_Profile::get_picture("", 0, "members_list"),
                )));
            }
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }
	
    public function action_my_referrals()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	 
    	if(count($subsc) === 1)
    	{
    		$subscribed = true;
    	}
    	else
    	{
    		$subscribed = false;
    	}

        $query = DB::select('*')->from('refer_friends');
        $query->where('refer_to', $this->current_profile->id);
        $result = $query->execute();

        $my_referals = array();

        foreach ($result as $res){
            array_push($my_referals, $res);
        }


        $view = View::forge('profile/my_referrals');

        $view->my_referals = $my_referals;
        $view->profile_address = $this->current_profile->city;
	    $view->profile_state = $this->current_profile->state;
        $view->current_user = $this->current_user;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->images = Model_Image::find('all', array("where" => array(array("member_id", $this->current_profile->id))));
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        //$view->set_global('page_js', 'profile/my_referrals.js');
        $view->set_global('page_css', 'profile/dashboard.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Referrals';
        $this->template->content = $view;
    }

    public function action_friend_request()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	 
    	if(count($subsc) === 1)
    	{
    		$subscribed = true;
    	}
    	else
    	{
    		$subscribed = false;
    	}
        $view = View::forge('profile/friend_request');

        $friend_request = Model_Friendship::get_pending_friends($this->current_profile->id);
        $request_sent = DB::select('*')
                        ->from('friendships')
                        ->where('sender_id', $this->current_profile->id)
                        ->execute();

       $view->request_sent = $request_sent;
       $view->friend_request =  $friend_request;


	   $profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
       $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
        $view->active_event_states = Model_Event::get_distinct_event_states();

        $view->profile_address = $profile_address;
	    $view->profile_state = $profile_state;	
        $view->current_user = $this->current_user;
        $view->pending_friends = Model_Friendship::get_pending_friends($this->current_profile->id);
        
        $view->friends = Model_Friendship::get_friends($this->current_profile->id);
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->online_members  =  $online_members;  
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");

        $view->set_global('page_js', 'profile/my_friends.js');      

        $view->set_global('page_css', 'profile/my_friends.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Friends';
        $this->template->content = $view;
    }

    public function action_friend_request_response ($response=null, $sender=null){


             $query = DB::update('friendships');
             $query->set(array(
                             "status" => $response
                ));
             $query->where('sender_id', $sender);
             $query->where('receiver_id',$this->current_profile->id);
             $query->execute();  


        $username = Auth::get_screen_name();
        $password = Auth::get('password');
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
            $referd = false;
        }
        else {
            $referd = true;
        }
        
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
            $subscribed = true;
        }
        else
        {
            $subscribed = false;
        }
        $view = View::forge('profile/friend_request');

        $friend_request = Model_Friendship::get_pending_friends($this->current_profile->id);
        $request_sent = DB::select('*')
                        ->from('friendships')
                        ->where('sender_id', $this->current_profile->id)
                        ->execute();

       $view->request_sent = $request_sent;             
       $view->friend_request =  $friend_request;


       $profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
       $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute(); 
        $view->profile_address = $profile_address;  
        $view->profile_state = $profile_state;  
        $view->current_user = $this->current_user;
        $view->pending_friends = Model_Friendship::get_pending_friends($this->current_profile->id);
        
        $view->friends = Model_Friendship::get_friends($this->current_profile->id);
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->online_members  =  $online_members;  
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");

        $view->set_global('page_js', 'profile/my_friends.js');      

        $view->set_global('page_css', 'profile/my_friends.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Friends';
        $this->template->content = $view;


    }

    public function action_my_invitations()
    {
        $event_invitations = Model_Referedevent::find('all', array("where" => array(array("refered_to", $this->current_profile->id))));

        $view = View::forge('profile/my_invitations');
        $view->event_invitations = $event_invitations;

        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_invitations.js');
        $view->set_global('page_css', 'profile/dashboard.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Invitations';
        $this->template->content = $view;
    }

    public function action_manage_event_invite() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $status = Input::post("status");
            $invitation_id = Input::post("invitation_id");

            $invitation = Model_Referedevent::find($invitation_id);
            if($invitation) {
                $invitation->message = $status;
                if($invitation->message == Model_Friendship::STATUS_REJECTED) {
                    $invitation->delete();
                    $response_message = "Event Invite request has been rejected.";
                } else {
                    $invitation->save();
                    $response_message = "Event Invite request has been accepted.";
                }
                $response->body(json_encode(array(
                    'status' => true,
                    'message' => $response_message,
                )));

            } else {
                $response->set_status(500);
            }

            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_invite_a_friend()
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('page/404');

        $from_name = $this->current_user->username;
        $gender = $this->current_profile->gender_id;
        $to_email = \Fuel\Core\Input::post('email');
        $message = \Fuel\Core\Input::post('message');

        $response = Response::forge();

        try {
            Email::forge()->to($to_email)->from("admin@whereweallmeet.com")->subject("Friend Invitation")
                ->html_body(View::forge('email/invite_friend',array("message" => $message, "from_name" => $from_name, "gender" => $gender)))->priority(\Email\Email::P_HIGH)->send();
            $response->body(json_encode(array(
                'status' => true,
                'message' => "Friend Invite sent successfully",
            )));
        } catch (EmailSendingFailedException $e) {
            $response->body(json_encode(array(
                'status' => false,
                'message' => "Sending Friend Invite failed",
            )));
        }
        return $response;
    }


}