<?php

class Controller_Users extends Controller_Base {

    public $template = 'layout/template';

    public function before() {
        parent::before();

        $login_exception = array("login", "sign_up", "m_sign_up", "activate", "forgot_password", "reset_password", "reset", "index", "show", "resend_activation", "send_activation");

        parent::check_permission($login_exception);
    }

    public function action_login() {

//        if ($this->current_user) {
//            Response::redirect("profile/dashboard/");
//        }

        $view = View::forge('users/login');

        if (Input::post()) {

            $val = Validation::forge();

            $val->add('username', 'Username')->add_rule('required')->add_rule('max_length', 255);

            $val->add('password', 'Password')->add_rule('required')->add_rule('max_length', 255);

            if ($val->run()) {

                $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")), 'or' => array(array('email', Input::post("username")),),)));
                if(isset($user)) {
                    $objProfile = Model_Profile::find('first', array(
                        'where' => array(
                            array('user_id', $user->id),
                        ),
                    ));

                    if(isset($objProfile)) {
                        if (isset($objProfile) && !$objProfile->is_activated) {
                            Response::redirect("users/resend_activation/msg");
                        }

                        if (isset($objProfile) && $objProfile->is_blocked) {
                            Session::set_flash('error', 'Your account is blocked. Please contact TMYW admin for solution.');
                            Response::redirect(Router::get("login"));
                        }
                         if (isset($objProfile) && $objProfile->disable==1) {
                            Session::set_flash('error', 'Your Profile has been disabled, Please contact the Whereweallmeet.com support team for assistance');
                            Response::redirect(Router::get("login"));
                        }

                        if (Auth::login()) {
                        $objProfile->is_logged_in = 1;
                        $objProfile->save();

                        if ($user->group_id == 5) {
                            Response::redirect("admin/dashboard");
                        } else {
                            \Fuel\Core\Session::set_flash("logedIn", true);
                            Response::redirect("profile/dashboard");
                            
//                            if($objProfile->is_completed) {
//                                \Fuel\Core\Session::set_flash("logedIn", true);
//                                Response::redirect("profile/dashboard");
//                            }
//                            else {
//                                Response::redirect("profile/wel_come");
//                            }
                        }
                    } else {
                        Session::set_flash('error', 'Wrong username/password combination. Please try again!');
                    }
                    } else {
                        Session::set_flash('error', 'The profile does not exist. Please signup again.');
                        Response::redirect(Router::get("login"));
                    }
                }
                else {
                    Session::set_flash('error', 'The user does not exist . Please try again.');
                    Response::redirect(Router::get("login"));
                }
            }
            $view->val = $val;
        }

        $view->set_global('page_css', 'users/login.css');

        $this->template->title = "WHERE WE ALL MEET  &raquo; Login";
        $this->template->content = $view;
    }

    public function action_logout() {
        $this->current_profile->is_logged_in = 0;
        $this->current_profile->save();

        Auth::logout();
        $this->current_user = null;
        $this->current_profile = null;
        Response::redirect('pages/home');
    }

    public function action_chat_login() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user) {
                $profile = Model_Profile::find('first', array("where" => array(array("user_id", $user->id))));
                if($profile) {
                    $profile->is_logged_in = 1;
                    $profile->save();
                    $response->body(json_encode(array(
                        'status' => true,
                        'message' => "The user successfully logged in",
                    )));
                }
                else {
                    $response->body(json_encode(array(
                        'status' => false,
                        'message' => "The profile does not exist",
                    )));
                }
            }
            else {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user does not exist ",
                )));
            }
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_chat_logout() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user) {
                $profile = Model_Profile::find('first', array("where" => array(array("user_id", $user->id))));
                if($profile) {
                    $profile->is_logged_in = 0;
                    $profile->save();
                    $response->body(json_encode(array(
                        'status' => true,
                        'message' => "The user successfully logged out",
                    )));
                }
                else {
                    $response->body(json_encode(array(
                        'status' => false,
                        'message' => "The profile does not exist",
                    )));
                }
            }
            else {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user does not exist " . Input::post("username"),
                )));
            }
            return $response;
        }
        else {
            return $response->body(json_encode(array(
                'status' => false,
                'message' => "Invalid request.",
            )));
            //return $response->set_status(400);
        }
    }

    public function action_save_chat(){
        $response = Response::forge();
        $post = Input::post();
          if (Input::post()) {

            $chat_room_id = $post['chat_room_id'];
            $chat_sender = $post['chat_sender'];
            $chat_reciever = $post['chat_reciever'];
            $chat_line =$post['chat_line'];

            $query = DB::insert('chat');

            $query->set(array(
                'chat_room_id' =>  $chat_room_id,
                'chat_sender' =>  $chat_sender,
                'chat_reciever' => $chat_reciever,
                'chat_line' =>  $chat_line,
                ));

            $query->execute();

            $response->body(json_encode(array(
                        "message" =>"data saved",
                        "success"=>true,
                        
                    ))); 

             return $response;
              

          }

    }
    public function action_get_chat(){
        $response = Response::forge();
        $post = Input::post();
        $chat_history = array();
          if (Input::post()) {

                $chat_room_id = $post['chat_room_id'];

                // $query = DB::select('id')->from('chat');
                // $query->where('id',1);
                // $chat = $query->execute(); 

                 $chat = DB::select('*')                   
                        ->from('chat')  
                        ->where('chat_room_id',$chat_room_id)
                        ->execute(); 
                
                foreach($chat as $key => $single_chat){
                    $chat_history[$key] = $single_chat;

                }
                //$chat = DB::query("select * from chat where chat_room_id = $chat_room_id")->as_assoc()->execute();

                $response->body(json_encode(array(
                        "chat" => $chat_history,
                        "room" => $chat_room_id,
                        "success"=>true,
                        
                    ))); 

             return $response;

          }



    }

    public function action_remove_chat(){
        $response = Response::forge();
        $post = Input::post();
        
          if (Input::post()) {

                $chat_room_id = $post['chat_room_id'];

                 $chat = DB::delete('chat')  
                        ->where('chat_room_id',$chat_room_id)
                        ->execute();

                $response->body(json_encode(array(
                        "room" => $chat_room_id,
                        "success"=>true,
                        
                    ))); 

             return $response;

          }



    }


    public function action_sign_up() {

        // $view = View::forge("users/sign_up");
        // $view->errors = [];
        if (Input::post()) {
            $post = Input::post();
            $val = Validation::forge();

            $val->add('first_name', 'First Name')->add_rule('required')->add_rule('max_length', 255);
            $val->add('last_name', 'Last Name')->add_rule('required')->add_rule('max_length', 255);
            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');
            $val->add('username', 'Username')->add_rule('required')->add_rule('max_length', 255);
            $val->add('password', 'Password')->add_rule('required')->add_rule('max_length', 255)->add_rule('min_length', 6);
            $val->add('confirm_password', 'Confirm Password')->add_rule('match_field', 'password');

            if ($val->run()) {
                $postal_code = DB::select('city', 'state')
                    ->from('us_postal_codes')
                    ->where('zip_code', $post["zip"])
                    ->execute()->current();
                $city = $postal_code['city'];
                $state = $postal_code['state'];

                try {
                    $activation_code = Crypt::encode($post["username"]);
                    $user_id = Auth::create_user(
                                    $post["username"], $post["password"], $post["email"], 3
                    );
                    if ($user_id) {
                        $post["city"] = $city;
                        $post["state"] = $state;
                        $post["user_id"] = $user_id;
                        $post["activation_code"] = $activation_code;
                        $post["member_type_id"] = 1; //Free Member
                        $post["is_activated"] = 0;
                        $post["is_completed"] = 0;
                        $post["is_blocked"] = 0;
                        $post["is_logged_in"] = 0;
                        $post["disable"]=0;
                        $post["income_id"]=0;
                        $post["visible_for_friends"]=0;
                        $post["send_me_account_info"]=0;
                        $post["send_me_listing_info"]=0;
                        $post["send_me_date_invitations"]=0;
                        $post["send_me_announcement_info"]=0;
                        $post["send_me_specialdeal_info"]=0;
                        $post["hobbies"]="";
                        $post["looking_for"]="";
                        $post['height'] = "";
                        if(isset($post['feet']) && !empty($post['feet']))
                            $post['height'] = $post['feet']."'";
                        if(isset($post['inches']) && !empty($post['inches']))
                            $post['height'] .= $post['inches'] . "\"";
//                        if(isset($post['seeking_feet']) && !empty($post['seeking_feet'])){
//                            $post['seeking_height'] = $post['seeking_feet'] . '*';
//                            unset($post['seeking_feet']);
//                        }
//                        if(isset($post['seeking_inches']) && !empty($post['seeking_inches'])){
//                            $post['seeking_height'] .= $post['seeking_inches'] . '**';
//                            unset($post['seeking_inches']);
//                        }

                        $post['birth_date'] = strtotime(date('Y-m-d', mktime(0, 0, 0, $post['month'], $post['day'], $post['year'])));
                        // $post["like_doing"]="";                        
                        //$post["life_so_far"]="";
                        $profile = Model_Profile::forge($post);

                        /** Upload code **/

                        if(Input::post("facebook_profile")){
                            $copy_source = Input::post("facebook_profile");
                            $extention = image_type_to_extension(getimagesize($copy_source)[2]);
                            $saved_as = Model_Profile::clean_name($post['username']).$extention;
                            $upload_dir = DOCROOT . "uploads/" . Model_Profile::clean_name($post['username']) ;
                            $filepath = $upload_dir . DIRECTORY_SEPARATOR . $saved_as;
                            copy($copy_source, $filepath);
                            $profile->picture = $saved_as;
                            $profile->save();

                            foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                                Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($upload_dir.'/'. $type . "_" . $saved_as);
                            }
                            Session::set_flash("success", "Your profile picture is successfully uploaded!");
                            
                        } else{

                            $upload_file = Input::file("picture");
                            if ($upload_file["size"] > 0) {
                            $config = array(
                                'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($post['username']),
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
                                //$view->errors[] = "The uploaded file is not valid. Please try again!";
                                //Session::set_flash('error', implode(' ', $view->errors));
                                Response::redirect("pages/home");
                                //Session::set_flash("error", "The file is not valid. Please try again!");
                            }

                            foreach (Upload::get_errors() as $file) {
                                //$view->errors[] = $file['errors'][0]['error'];
                            }
                        }
                        }


                        
                        // end of upload code

                        $profile->save();
                    }

                    //make admin a friend for the new member by default
                    $admin_user = \Model\Auth_User::find('first', array("where" => array(array("username", 'JadaR2020'),)));
                    if(isset($admin_user)) {
                        $objAdminProfile = Model_Profile::find('first', array(
                            'where' => array(
                                array('user_id', $admin_user->id),
                            ),
                        ));
                        if(isset($objAdminProfile)) {
                            $friendship = Model_Friendship::forge(array(
                                "sender_id" => $objAdminProfile->id,
                                "receiver_id" => $profile->id,
                                "status" => Model_Friendship::STATUS_ACCEPTED
                            ));
                            $friendship->save();
                        }
                    }

                    try {
                        Email::forge()->to($post["email"])->from("noreply@whereweallmeet.com")->subject("Sign Up Confirmation")->html_body(View::forge('email/sign_up', array("activation_code" => $activation_code)))->send();
                        
                        //$view->success = true;
                    } catch (EmailSendingFailedException $e) {
                        //Session::set_flash('error', 'Your confirmation email could not be sent, please contact the Administrator for further instructions.');
                        //$view->errors[] = "Your confirmation email could not be sent, please contact the Administrator for further instructions.";
//                        Session::set_flash('error', implode(' ', $view->errors));
//                        Response::redirect("pages/home");
                    }
                } 
                catch (Auth\SimpleUserUpdateException $e) {
                    //$view->errors[] = $e->getMessage();
//                    Session::set_flash('error', implode(' ', $view->errors));
//                    Response::redirect("pages/home");
                }
               
                $email = DB::select('refered_email')
                        ->from('referedemails')
                        ->where('refered_email', $_POST['email'])
                        ->execute();
                $num_records = count($email);
                if($num_records > 0) {
                    $email_refered = DB::select('email_from','refered_email')
                                    ->from('referedemails')
                                    ->where('refered_email', $_POST['email'])
                                    ->execute();
                    $sender_email =  $email_refered[0]['email_from'];
                    $refered_email =  $email_refered[0]['refered_email'];
                    $id_ref = DB::select('profiles.id')
                                ->from('profiles')
                                ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
                                ->where('email', $refered_email)
                                ->execute();
                    $id_refered =  $id_ref[0]['id'];

                    $email_refered = DB::select('profiles.id')
                                    ->from('profiles')
                                    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
                                    ->where('email', $sender_email)
                                    ->execute();
                    $email_sender_id = $email_refered[0]['id'];

                    $email_data["sender_id"] = $id_refered;
                    $email_data["receiver_id"] = $email_sender_id;
                    $email_data["status"] = 'sent';

                    $emails = Model_Friendship::forge($email_data);
                    $emails->save();
                    Session::set_flash('success', 'Thank you for signing up to whereweallmeet.com. Please check your email to verify your account.');

                }
            }


            // $view->val = $val;
            if(isset($view) && count($view->errors) > 0){
    
                Session::set_flash('error', implode(' ', $view->errors));
                Response::redirect("pages/home");
            }
            else{
                Session::set_flash('success', "Thank you for signing up to whereweallmeet.com. Please check your email to verify your account.");
                Response::redirect("pages/home");
            }
        
        }
        else {
            Response::redirect('pages/home');
        }
    }

    public function action_m_sign_up($invited_by_id = null) {

        $view = View::forge("users/sign_up");

        if (Input::post()) {
            $post = Input::post();

            $val = Validation::forge();

            $val->add('zip', 'Zip Code')->add_rule('required')->add_rule('max_length', 255);
            $val->add('first_name', 'First Name')->add_rule('required')->add_rule('max_length', 255);
            $val->add('last_name', 'Last Name')->add_rule('required')->add_rule('max_length', 255);
            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');
            $val->add('username', 'Username')->add_rule('required')->add_rule('max_length', 255);
            $val->add('password', 'Password')->add_rule('required')->add_rule('max_length', 255)->add_rule('min_length', 6);
            $val->add('confirm_password', 'Confirm Password')->add_rule('match_field', 'password');

            if ($val->run()) {
                try {
                    $activation_code = Crypt::encode($post["username"]);
                    $user_id = Auth::create_user(
                        $post["username"], $post["password"], $post["email"], 3
                    );

                    if ($user_id) {
                        $postal_code = DB::select('city', 'state')
                            ->from('us_postal_codes')
                            ->where('zip_code', $post["zip"])
                            ->execute()->current();
                        $post["city"] = $postal_code['city'];
                        $post["state"] = $postal_code['state'];

                        $post["user_id"] = $user_id;
                        $post["activation_code"] = $activation_code;
                        $post["member_type_id"] = 1; //Free Member
                        $post["is_activated"] = 0;$post["is_completed"] = 0;$post["is_blocked"] = 0;$post["is_logged_in"] = 0;$post["disable"]=0;
                        $post["income_id"]=0;$post["visible_for_friends"]=0;$post["send_me_account_info"]=0;$post["send_me_listing_info"]=0;
                        $post["send_me_date_invitations"]=0;$post["send_me_announcement_info"]=0;$post["send_me_specialdeal_info"]=0;
                        $post["hobbies"]="";$post["looking_for"]="";$post['height'] = "";
                        $post['birth_date'] = strtotime(date('Y-m-d', mktime(0, 0, 0, $post['month'], $post['day'], $post['year'])));

                        $post['is_logged_in']=0; $post['career']= "";$post['places_visted']= "";$post['plan_for_future']= "";
                        $post['children_id']= 0;$post['faith_id']= 0;$post['politics_id']= 0;$post['exercise_id']= 0;
                        $post['seeking_children_id'] = 0;$post['seeking_education_id'] = 0;$post['seeking_politics_id'] = 0;$post['seeking_exercise_id'] = 0;

                        $profile = Model_Profile::forge($post);
                        $profile->save();

                        $upload_file = Input::file("picture");
                        if ($upload_file["size"] > 0) {
                            $config = array(
                                'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($post['username']),
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
                            }
                        }

                        //Send friend request if it is friend invitation
                        if ($objInviter = Model_Profile::find($invited_by_id) && !Model_Friendship::request_exchanged($profile->id, $invited_by_id)) {
                            $friendship = Model_Friendship::forge(array(
                                "sender_id" => $profile->id,
                                "receiver_id" => $invited_by_id,
                                "status" => Model_Friendship::STATUS_SENT
                            ));
                            $friendship->save();

                            Model_Notification::save_notifications(
                                Model_Notification::FRIEND_REQUEST_SENT,
                                $friendship->id,
                                $friendship->receiver_id,
                                $friendship->sender_id
                            );

                            $objInvitedMember = Model_Invitedmember::forge(array(
                                "member_id" => $profile->id,
                                "inviter_id" => $invited_by_id
                            ));
                            $objInvitedMember->save();
                        }
                    }

                    //make admin a friend for the new member by default
                    $admin_user = \Model\Auth_User::find('first', array("where" => array(array("username", 'JadaR2020'),)));
                    if(isset($admin_user)) {
                        $objAdminProfile = Model_Profile::find('first', array(
                            'where' => array(
                                array('user_id', $admin_user->id),
                            ),
                        ));
                        if(isset($objAdminProfile)) {
                            $friendship = Model_Friendship::forge(array(
                                "sender_id" => $objAdminProfile->id,
                                "receiver_id" => $profile->id,
                                "status" => Model_Friendship::STATUS_ACCEPTED
                            ));
                            $friendship->save();
                        }
                    }

                    try {
                        Email::forge()->to($post["email"])->from("noreply@whereweallmeet.com")->subject("Sign Up Confirmation")->html_body(View::forge('email/sign_up', array("activation_code" => $activation_code)))->send();

                        $view->success = true;
                    } catch (EmailSendingFailedException $e) {
                        $view->error = "Your confirmation email could not be sent, please contact the Administrator for further instructions.";
                    }
                } catch (Auth\SimpleUserUpdateException $e) {
                    $view->error = $e->getMessage();
                }

                $email = DB::select('refered_email')
                    ->from('referedemails')
                    ->where('refered_email', $_POST['email'])
                    ->execute();
                $num_records = count($email);
                if($num_records > 0) {
                    $email_refered = DB::select('email_from','refered_email')
                        ->from('referedemails')
                        ->where('refered_email', $_POST['email'])
                        ->execute();
                    $sender_email =  $email_refered[0]['email_from'];
                    $refered_email =  $email_refered[0]['refered_email'];
                    $id_ref = DB::select('profiles.id')
                        ->from('profiles')
                        ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
                        ->where('email', $refered_email)
                        ->execute();
                    $id_refered =  $id_ref[0]['id'];

                    $email_refered = DB::select('profiles.id')
                        ->from('profiles')
                        ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
                        ->where('email', $sender_email)
                        ->execute();
                    $email_sender_id = $email_refered[0]['id'];

                    $email_data["sender_id"] = $id_refered;
                    $email_data["receiver_id"] = $email_sender_id;
                    $email_data["status"] = 'sent';

                    $emails = Model_Friendship::forge($email_data);
                    $emails->save();
                }
            }
            $view->val = $val;
        }

        $view->invited_by_id = $invited_by_id;
        $view->genders = Model_Gender::find('all');
        $view->state = Model_State::find('all');
        $view->set_global('page_css', 'users/sign_up.css');
        $view->set_global('page_js', 'users/sign_up.js');

        $this->template->title = "WHERE WE ALL MEET &raquo;  Sign Up";
        $this->template->content = $view;
    }

    public function action_activate($code) {
        $state = Model_State::find('all');

        $view = View::forge("users/activate");
        $view->state = $state;

        if ($code) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Crypt::decode($code)))));
            if ($user) {
                if (Auth::force_login($user)) {
                    $objProfile = Model_Profile::find('first', array(
                        'where' => array(
                            array('user_id', $user->id),
                        ),
                    ));

                    if($objProfile){
                        $objProfile->is_activated = 1;
                        if($objProfile->save()){
                            $view->success = true;
                            Response::redirect("profile/dashboard");
                        }
                        else{
                            $view->success = false;
                            $view->error = "Account activation failed.";
                        }
                    }
                    else {
                        $view->error = "Activation Code not correct, please use the link forwarded to your email." ;
                    }
                }
            } else {
                $view->error = "Activation Code not correct, please use the link forwarded to your email.";
            }
        }

        $this->template->title = "WHERE WE ALL MEET &raquo;  Account Activation";
        $this->template->content = $view;
    }

    public function action_build_profile() {
        $state = Model_State::find('all');
        $view = View::forge("users/build_profile");
        $view->state = $state;

        $view->set_global('page_js', 'users/build_profile.js');
        $view->set_global('page_css', 'users/build_profile.css');
        $this->template->title = "WHERE WE ALL MEET &raquo;  Account Activation";
        $this->template->content = $view;
    }

    public function action_forgot_password() {
        if ($this->current_user) {
            Response::redirect("profile/dashboard/");
        }

        $view = View::forge('users/forgot_password');

        if (Input::post()) {

            $val = Validation::forge();

            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');

            if ($val->run()) {
                $user = \Model\Auth_User::find('first', array("where" => array(array("email", Input::post("email")))));
                if ($user) {

                    $reset_code = Crypt::encode($user->username);
                    try {
                        Email::forge()->to(Input::post("email"))->from("noreply@whereweallmeet.com")->subject("Forgot Password")->html_body(View::forge('email/forgot_password', array("reset_code" => $reset_code)))->send();

                        Session::set_flash("success", "Your password reset email is successfully sent. Please use the link provided in the email to reset your password.");
                        Response::redirect("users/login");
                    } catch (EmailSendingFailedException $e) {
                        Session::set_flash("error", "Your password recovery email could not be sent, please contact the Administrator for further instructions.");
                    }
                } else {
                    Session::set_flash("error", "Your email is not registered. Please Sign Up to get a new account!");
                }
            }
            $view->val = $val;
        }

        $view->set_global('page_css', 'users/forgot_password.css');

        $this->template->title = "WHERE WE ALL MEET &raquo; Forgot Password";
        $this->template->content = $view;
    }

    public function action_reset_password($code) {

        $view = View::forge("users/reset_password");

        if ($code) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Crypt::decode($code)))));
            if ($user) {
                if (Auth::force_login($user)) {
                    $view->username = $user->username;
                    Session::set_flash("info", "Please use the form below to reset your password.");
                }
            } else {
                Session::set_flash("error", "Please use the link provided in your the email to reset your password.");
                Response::redirect("users/login");
            }
        } else {
            Session::set_flash("error", "Please use the link provided in your the email to reset your password.");
            Response::redirect("login");
        }

        $view->set_global('page_css', 'users/forgot_password.css');
        $this->template->title = "WHERE WE ALL MEET &raquo;  Reset Password";
        $this->template->content = $view;
    }

    public function action_reset() {
        if (Input::post("password")) {
            $old_password = Auth::reset_password(Input::post("username"));
            Auth::change_password($old_password, Input::post("password"), Input::post("username"));

            Session::set_flash("success", "Your password has been successfully reset!");

            Response::redirect("profile/dashboard");
        }
        Response::redirect("users/reset_password/wrong");
    }

    public function action_resend_activation($msg = null) {

        $view = View::forge("users/resend_activation");

        if(isset($msg)) {
            $view->error_message = "Your account is awaiting activation. Please use the link in your conformation email to activate your account or use the form below to resend the activation code";
        }

        $view->set_global('page_css', 'users/forgot_password.css');
        $this->template->title = "WHERE WE ALL MEET &raquo;  Resend Activation";
        $this->template->content = $view;
    }

    public function action_send_activation() {
        if (Input::post()) {
            $val = Validation::forge();

            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');

            if ($val->run()) {
                $user = \Model\Auth_User::find('first', array("where" => array(array("email", Input::post("email")))));
                if ($user) {
                    try {
                        Email::forge()->to(Input::post("email"))->from("noreply@whereweallmeet.com")->subject("Sign Up Confirmation")->html_body(View::forge('email/sign_up', array("activation_code" => Crypt::encode($user->username))))->send();

                        Session::set_flash("success", "Your account activation code has been sent to your email. Please use the link forwarded to your email to activate your account.");
                        Response::redirect(Router::get("login"));
                    } catch (EmailSendingFailedException $e) {
                        Session::set_flash("error", "Your account activation code could not be sent. Please try again.");
                        Response::redirect("users/resend_activation/msg");
                    }
                } else {
                    Session::set_flash("error", "The email doesn't exist. Please try again.");
                    Response::redirect("users/resend_activation");
                }
            } else {
                Session::set_flash("error", "Invalid email. Please try again.");
                Response::redirect("users/resend_activation");
            }

        }
        Response::redirect("users/resend_activation/msg");
    }
}
