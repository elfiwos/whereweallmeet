<?php
use \Model\Quicksearch;
class Controller_Event extends Controller_Base
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
        $view = View::forge('event/index');

        $view->set_global('active_events', Model_Event::get_active_events_by_region($this->current_profile->state, $this->current_profile->city));
        $view->active_event_states = Model_Event::get_distinct_event_states();
        $view->set_global("active_page", "events");
        $view->set_global('page_js', 'events/index.js');
        $view->set_global('page_css', 'events/event.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Events';
        $this->template->content = $view;
    }

    public function action_getaway($state = null, $city = null){
             //$view = View::forge('event/getaway');
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
         
        //If city and state not provided set defaults from user profile data
        //Better implemented by Auth::get_profile_fields('state') and Auth::get_profile_fields('city')
        is_null($state) and $state = Model_Profile::query()->where('user_id', \Auth\Auth::get('id'))->get_one()->state;
        is_null($city) and $city = Model_Profile::query()->where('user_id', \Auth\Auth::get('id'))->get_one()->city;

        $view = View::forge('event/getaway');
        
        $view->set_global('active_getaways', Model_Getaway::get_featured_getaways());



        //added to display dating packages from the users  location
        $view->set_global('active_datingPackages', Model_Datingpackage::get_random_active_dating_packages_by_state(9999,$this->current_profile->id));
        $view->set_global('state', $state);
        $view->set_global('city', $city);

        $profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
             $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
        $latest_members = DB::select()
            ->from('profiles')
            ->where('id', '<>', $this->current_profile->id )
            ->order_by('created_at', 'desc')
            ->limit(8)->execute()->as_array();
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "getaways");
        $view->set_global('page_js', 'events/index.js');
        $view->set_global('page_css', 'events/event.css');

     $online_members = Quicksearch::get_online_members($username, $password);
     $view->profile_address = $profile_address;
            $view->profile_state = $profile_state;
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $this->template->title = 'WHERE WE ALL MEET &raquo; Events';
        $this->template->content = $view;
    }

    public function action_view($event_slug = null)
    {
        is_null($event_slug) and \Fuel\Core\Response::redirect('pages/404');

        $event = Model_Event::find_by_slug($event_slug);

        if($event === false)
            \Fuel\Core\Response::redirect('pages/404');


        $view = View::forge('event/view');
        $view->set_global('event', $event);

        $a_get =  Model_Event::find_by_slug($event_slug);


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
        $view->set('profiles', $profiles);
        $view->set('users', $users);

        $view->set_global('page_js', 'events/view.js');
        $view->set_global("active_page", "events");
        $view->set_global('page_css', 'events/event.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Event Details';
        $this->template->content = $view;
    }

    public function action_rsvp()
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('page/404');

        $response = Response::forge();
        $rsvp = Model_Rsvp::forge();
        $rsvp->event_id = \Fuel\Core\Input::post('event_id');
        $rsvp->member_id = $this->current_user->id;
        if( ! Model_Rsvp::is_going($rsvp->event_id) and $rsvp->save())
        {

            Model_Notification::save_notifications(
                Model_Notification::EVENT_RSVP_SENT,
                $rsvp->event_id,
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
                    ->subject("Event RSVP from WHERE WE ALL MEET.COM")
                    ->html_body(
                        View::forge('email/event_rsvp',
                            array(
                                "event" => Model_Event::find($rsvp->event_id),
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

    public function action_cancel_rsvp()
    {

        if(\Fuel\Core\Input::post())
        {
            $query = Model_Rsvp::query()->where(array(
                'event_id' => \Fuel\Core\Input::post('event_id'),
                'member_id'=> \Auth\Auth::get('id'),
            ));

            if(Model_Rsvp::is_going(\Fuel\Core\Input::post('event_id')) and $query->delete())
            {
                \Fuel\Core\Response::redirect_back();
            }
        }

        \Fuel\Core\Response::redirect('page/404');
    }

    public function action_my_events()
    {
        $view = View::forge('event/my_events');

        $view->set_global('active_events', Model_Event::get_events_by_member_rsvp(\Auth\Auth::get('id')));
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
        $view->set_global("active_page", "events");
        $view->set_global('page_css', 'profile/dashboard.css');


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
        $event = Model_Event::find(\Fuel\Core\Input::post('event_id'));
        $event_url = \Fuel\Core\Uri::base().'event/view/'.$event->slug;


        $response = Response::forge();

        try {
            Email::forge()
                ->to($to_email)
                ->from($this->current_user->email)
                ->subject("Checkout this event")
                ->html_body(
                    View::forge('email/event_refer_a_friend',
                        array(
                            "message" => $message,
                            "event_url" => $event_url,
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
        
        $message = Input::post('location').'has sent you an event invitation' ;
        $event = Model_Event::find(\Fuel\Core\Input::post('event_id'));
        $event_url = \Fuel\Core\Uri::base().'event/view/'.$event->slug;

         Model_Notification::save_notifications(
                Model_Notification::EVENT_RSVP_SENT,
                $event->id,
                $this->current_profile->id,
                $user[0]['id']
            );


        try {
            Email::forge()
                ->to($to_email[0]['email'])
                ->from($this->current_user->email)
                ->subject("Checkout this Event")
                ->html_body(
                    View::forge('email/event_refer_a_friend',
                        array(
                            "message" => $message,
                            "event_url" => $event_url,
                            "from_name" => $from_name,
                        )
                    )
                )->send();
                Response::redirect('event/view/'.$event->slug);
        } catch (EmailSendingFailedException $e) {
            Response::redirect('getaway/view/'.$event->slug);
        }
    }

    public function action_search() {
        $view = View::forge('event/search');
        $location = Input::post('location');
        $from_date = Input::post('from');
        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = Input::post('to');
        $to_date = date('Y-m-d', strtotime($to_date));
        if ($location !== null && (Input::post('from') == '' || Input::post('to') == '')) {
            $view->events = Model_Event::get_events_by_location($location);
        } elseif (isset($location) && ($from_date !== null || $to_date !== null)) {
            $view->events = Model_Event::get_events_by_location_and_date($location, $from_date, $to_date);
        }

        $view->active_event_states = Model_Event::get_distinct_event_states();

        $view->set_global("active_page", "Events");
        $view->set_global('page_js', 'events/index.js');
        $view->set_global('page_css', 'events/event.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Events';
        $this->template->content = $view;
    }

    public function action_send_event_invite() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            if (!Model_Profile::find(Input::post("refered_by"))) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user you are trying to send event invite to does not exist!"
                )));
            }
            else if(!Model_Profile::find(Input::post("refered_to"))) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "event invite sender does not exist!"
                )));
            }
            else if($already_sent = Model_Referedevent::event_invite_exchanged(Input::post("event_id"),Input::post("refered_by"), Input::post("refered_to"))){
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "Event invite has already been exchanged with this person!"
                )));
            } else {

                $event_invite = Model_Referedevent::forge(array(
                    "event_id" => Input::post("event_id"),
                    "refered_by" => Input::post("refered_by"),
                    "refered_to" => Input::post("refered_to"),
                    "message" => Model_Friendship::STATUS_SENT
                ));
                $event_invite->save();

                Model_Notification::save_notifications(
                    Model_Notification::EVENT_INVITE_SENT,
                    Input::post("event_id"),
                    Input::post("refered_to"),
                    Input::post("refered_by")
                );

                Email::forge()
                    ->to($this->current_user->email)
                    ->from("noreply@whereweallmeet.com")
                    ->subject("You have a new Event Invite")
                    ->html_body("You have received a new Event Invite. Check your My Invitations page.")->send();
                $response->body(json_encode(array(
                    'status' => true,
                    'message' => "Event Invitation sent successfully",
                )));
            }

            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_book_event()
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('pages/404');

        $response = Response::forge();

        if (!Model_Profile::find(Input::post("member_id"))) {
            $response->body(json_encode(array(
                'status' => false,
                'message' => "The member does not exist!"
            )));
        } else if(!Model_Event::find(Input::post("event_id"))){
            $response->body(json_encode(array(
                'status' => false,
                'message' => "Event does not exist!"
            )));
        } else if(Model_Memberevent::is_event_booked(Input::post("event_id"), Input::post("member_id"))){
            $response->body(json_encode(array(
                'status' => false,
                'message' => "Member Event already booked!"
            )));
        } else {
            $member_event = Model_Memberevent::forge();
            $member_event->event_id = Input::post('event_id');
            $member_event->member_id = Input::post("member_id");

            $member_event->save();

            $response->body(json_encode(array(
                'success' => true,
                'message' => "Member Event successfully saved"
            )));
        }
        return $response;
    }
}