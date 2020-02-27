<?php
use \Model\Quicksearch;
class Controller_Getaway extends Controller_Base
{
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_index($state = null, $city = null)
    {
		$view = View::forge('getaway/index');

        $view->set_global('active_getaways', Model_Getaway::get_featured_getaways());
        $view->countries = Model_Country::find('all', array('order_by' => 'name'));

        $view->set_global("active_page", "getaways");
        $view->set_global('page_js', 'events/index.js');
        $view->set_global('page_css', 'events/event.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Get-Aways';
        $this->template->content = $view;
    }

    public function action_view_all($state = null, $city = null)
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

        //If city and state not provided set defaults from user profile data
        //Better implemented by Auth::get_profile_fields('state') and Auth::get_profile_fields('city')
        is_null($state) and $state = Model_Profile::query()->where('user_id', \Auth\Auth::get('id'))->get_one()->state;
        is_null($city) and $city = Model_Profile::query()->where('user_id', \Auth\Auth::get('id'))->get_one()->city;

        $view = View::forge('getaway/view_all');

        $view->set_global('active_getaways', Model_Getaway::get_active_getaways_by_region($state, $city));
        $view->set_global("active_page", "getaways");
        $view->set_global('page_js', 'events/index.js');
        $view->set_global('page_css', 'events/event.css');

        $online_members = Quicksearch::get_online_members($username, $password);
        $view->profile_address = $this->current_profile->city;
        $view->profile_state = $this->current_profile->state;
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $this->template->title = 'WHERE WE ALL MEET &raquo; Events';
        $this->template->content = $view;
    }

    public function action_view($getaway_slug = null)
    {
        is_null($getaway_slug) and \Fuel\Core\Response::redirect('pages/404');

        $getaway = Model_Getaway::find_by_slug($getaway_slug);

        if($getaway === false)
            \Fuel\Core\Response::redirect('pages/404');

        $view = View::forge('getaway/view');


        $view->set_global('getaway', Model_Getaway::find_by_slug($getaway_slug));
        $a_get =  Model_Getaway::find_by_slug($getaway_slug);


        $friendship = Model_friendship::find('all');

        $profiles = Model_profile::find('all');
        $users = Model_Users::find('all');
        $fromusername = Auth::instance()->get_screen_name();

        foreach ($users as $user) {
            $results12 = DB::select('id')
                    ->from('users')
                    ->where('username', $fromusername)
                    ->execute();
        }

        $profileid=DB::select('id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
       $membertypeid=DB::select('member_type_id')
                       ->from('profiles')
                       ->where('id',$this->current_profile->id) 
                       ->execute();         

        foreach ($profiles as $profile) {
            $resultsprofile = DB::select('id')
                    ->from('profiles')
                    ->where('user_id', $results12[0]['id'])
                    ->execute();
        }

        $view->profileid=$profileid;
        $view->membertypeid=$membertypeid;     
        $view->set('resultsprofile', $resultsprofile);
        $view->set('friendship', $friendship);
//		$view->profile_address = $profile_address;
//		$view->profile_state = $profile_state;
//        $view->latest_members = $latest_members;
        $view->set('profiles', $profiles);
        $view->set('users', $users);
        $view->set_global('page_js', 'events/view.js');
        $view->set_global("active_page", "getaways");
        $view->set_global('page_css', 'events/event.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Get-Away Details';
        $this->template->content = $view;
    }

    public function action_rsvp()
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('page/404');

        $response = Response::forge();
        $rsvp = Model_Rsvp::forge();
        $rsvp->getaway_id = \Fuel\Core\Input::post('getaway_id');
        $rsvp->member_id = $this->current_user->id;
        if( ! Model_Rsvp::is_going($rsvp->getaway_id) and $rsvp->save())
        {

            Model_Notification::save_notifications(
                Model_Notification::EVENT_RSVP_SENT,
                $rsvp->getaway_id,
                $this->current_profile->id,
                $this->current_profile->id
            );

            try {
                //Craig@themanyouwant.com is currently serving as the admin's email address
                Email::forge()
                    ->to(
                        array('Craig@themanyouwant.com', $this->current_user->email)
                    )
                    ->from($this->current_user->email)
                    ->subject("Getaway RSVP from WHERE WE ALL MEET.COM")
                    ->html_body(
                        View::forge('email/getaway_rsvp',
                            array(
                                "getaway" => Model_Getaway::find($rsvp->getaway_id),
                            )
                        )
                    )->send();
            } catch (EmailSendingFailedException $e) {
                $response->body(json_encode(array(
                    'status' => false
                )));
                return $response;
            }

            $response->body(json_encode(array(
                'status' => true
            )));
        }
        else{
            $response->body(json_encode(array(
                'status' => false
            )));
        }


        return $response;
    }
    public function action_book()
    {
        
        $rsvp = Model_Rsvp::forge();
        $getaway = Model_Getaway::find(Input::post('getaway_id'));
        $rsvp->getaway_id = \Fuel\Core\Input::post('getaway_id');
        $rsvp->member_id = $this->current_user->id;
        if( ! Model_Rsvp::is_going($rsvp->getaway_id) and $rsvp->save())
        {

            Model_Notification::save_notifications(
                Model_Notification::EVENT_RSVP_SENT,
                $rsvp->getaway_id,
                $this->current_profile->id,
                $this->current_profile->id
            );

            try {
                //Craig@themanyouwant.com is currently serving as the admin's email address
                Email::forge()
                    ->to(
                        array('Craig@themanyouwant.com', $this->current_user->email)
                    )
                    ->from($this->current_user->email)
                    ->subject("Getaway RSVP from WHERE WE ALL MEET.COM")
                    ->html_body(
                        View::forge('email/getaway_book',
                            array(
                                "getaway" => Model_Getaway::find($rsvp->getaway_id),
                            )
                        )
                    )->send();
            } catch (EmailSendingFailedException $e) {
                Response::redirect('getaway/view/'.$getaway->slug);
                
            }

            
        }
        else{
           Response::redirect('getaway/view/'.$getaway->slug); 
        }


    }

    public function action_cancel_rsvp()
    {

        if(\Fuel\Core\Input::post())
        {
            $query = Model_Rsvp::query()->where(array(
                'getaway_id' => \Fuel\Core\Input::post('getaway_id'),
                'member_id'=> \Auth\Auth::get('id'),
            ));

            if(Model_Rsvp::is_going(\Fuel\Core\Input::post('getaway_id')) and $query->delete())
            {
                \Fuel\Core\Response::redirect_back();
            }
        }

        \Fuel\Core\Response::redirect('page/404');
    }

    public function action_my_events()
    {
        $view = View::forge('getaway/my_events');

        $view->set_global('active_getaways', Model_Event::get_getaways_by_member_rsvp(\Auth\Auth::get('id')));
        $state = Model_Profile::query()->where('user_id', \Auth\Auth::get('id'))->get_one()->state;
        $city = Model_Profile::query()->where('user_id', \Auth\Auth::get('id'))->get_one()->city;

        $view->set_global('state', $state);
        $view->set_global('city', $city);

        $latest_members = DB::select()
            ->from('profiles')
            ->where('id', '<>', $this->current_profile->id )
            ->order_by('created_at', 'desc')
            ->limit(8)->execute()->as_array();
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
     $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
        $view->active_datingPackages =Model_Datingpackage::get_random_active_dating_packages_by_state(9999,$this->current_profile->id);
        $view->profile_address = $profile_address;
	    $view->profile_state = $profile_state;
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "getaways");
        $view->set_global('page_css', 'profile/my_event.css');


        $this->template->title = 'WHERE WE ALL MEET &raquo; My Events';
        $this->template->content = $view;
    }

    public function action_refer_a_friend()
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('page/404');



        $from_name = $this->current_profile->first_name.' '.$this->current_profile->last_name;
        $to_email = \Fuel\Core\Input::post('email');
        $message = \Fuel\Core\Input::post('message');
        $getaway = Model_Getaway::find(\Fuel\Core\Input::post('getaway_id'));
        $getaway_url = \Fuel\Core\Uri::base().'getaway/view/'.$getaway->slug;


        $response = Response::forge();

        try {
            Email::forge()
                ->to($to_email)
                ->from($this->current_user->email)
                ->subject("Checkout this getaway")
                ->html_body(
                    View::forge('email/getaway_refer_a_friend',
                        array(
                            "message" => $message,
                            "event_url" => $getaway_url,
                            "from_name" => $from_name,
                        )
                    )
                )->send();

            $response->body(json_encode(array(
                'status' => true,
            )));
        } catch (EmailSendingFailedException $e) {
            $response->body(json_encode(array(
                'status' => false,
            )));
        }

        return $response;

    }
    public function action_invite_a_friend()
    {
        $to_email = DB::select('email')
                        ->from('users')
                        ->where('username',Input::post('location'))
                        ->execute();
        $id = DB::select('id')
                        ->from('users')
                        ->where('username',Input::post('location'))
                        ->execute();
         $user = DB::select('id')
                        ->from('profiles')
                        ->where('user_id',$id[0]['id'])
                        ->execute();


        $from_name = $this->current_profile->first_name.' '.$this->current_profile->last_name;
        
        $message = Input::post('location').'has sent you a getaway invitation' ;
        $getaway = Model_Getaway::find(\Fuel\Core\Input::post('getaway_id'));
        $getaway_url = \Fuel\Core\Uri::base().'getaway/view/'.$getaway->slug;

         Model_Notification::save_notifications(
                Model_Notification::GETAWAY_RSVP_SENT,
                $getaway->id,
                $this->current_profile->id,
                $user[0]['id']
            );


        try {
            Email::forge()
                ->to($to_email[0]['email'])
                ->from($this->current_user->email)
                ->subject("Checkout this getaway")
                ->html_body(
                    View::forge('email/getaway_invite_a_friend',
                        array(
                            "message" => $message,
                            "event_url" => $getaway_url,
                            "from_name" => $from_name,
                        )
                    )
                )->send();
                Response::redirect('getaway/view/'.$getaway->slug);
        } catch (EmailSendingFailedException $e) {
            Response::redirect('getaway/view/'.$getaway->slug);
        }
    }

    public function action_search($id=null) {
        $view = View::forge('getaway/search');
        $location = Input::post('location');
        $from_date = Input::post('from');
        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = Input::post('to');
        $to_date = date('Y-m-d', strtotime($to_date));
        if ($location !== null && (Input::post('from') == "" || Input::post('to') == "")) {
            $view->getaways = Model_Getaway::get_getaways_by_location($location);
        } elseif (isset($location) && ($from_date !== null || $to_date !== null)) {
            $view->getaways = Model_Getaway::get_getaways_by_location_and_date($location, $from_date, $to_date);
        }
        $view->countries = Model_Country::find('all', array('order_by' => 'name'));

        $view->set_global("active_page", "getaways");
        $view->set_global('page_js', 'events/index.js');
        $view->set_global('page_css', 'events/event.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Getaways';
        $this->template->content = $view;
    }
}