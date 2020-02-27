<?php
use \Model\Quicksearch;
class Controller_Base extends Controller_Template{

    public function before(){
        parent::before();

        if(Auth::check()){
            list($driver, $user_id) = Auth::get_user_id();

            $this->current_user = \Auth\Model\Auth_User::find($user_id);
            $this->current_profile = Model_Profile::find('first', array("where" => array(array("user_id", $user_id))));

            if($this->current_profile->subscription_expiry_date < strtotime(date("Y/m/d")) && $this->current_profile->member_type_id == 4) {
                $this->current_profile->member_type_id = 2;
                $this->current_profile->save();
                Model_Agentclient::delete_booked_client($this->current_profile->id);
            }

            if($this->current_profile->is_logged_in == 0) {
                $this->current_profile->is_logged_in = 1;
                $this->current_profile->save();
            }

            if(Model_Datingagentinvitaion::has_pending_invitations($this->current_profile->id)){
                View::set_global('dating_agent_invitation', Model_Datingagentinvitaion::get_one_pending_invitation($this->current_profile->id));
            }
            if(Model_Referfriends::has_pending_invitations($this->current_profile->id)) {
                View::set_global('refer_friend', Model_Referfriends::get_one_pending_invitation($this->current_profile->id));
            }
            if(\Fuel\Core\Session::get_flash("logedIn") && Model_Profile::is_dating_agent($this->current_profile->id)){
                Response::redirect("agent/index");
            }
        } else {
            $this->current_user = null;
            $this->current_profile = null;
        }



        View::set_global('current_user', $this->current_user);
        View::set_global('current_profile', $this->current_profile);
        
        if($this->current_profile != null)
        {
            View::set_global('countFriend',  Model_Friendship::get_friends($this->current_profile->id));
            View::set_global('countHello',  Model_Hello::count_hello($this->current_profile->id));
            View::set_global('countImage',  Model_Image::count_image($this->current_profile->id));
            View::set_global('countEvent',  Model_Rsvp::count_event($this->current_user->id));
            View::set_global('countInvitations', count(Model_Referedevent::find('all', array("where" => array(array("refered_to", $this->current_profile->id))))));

            View::set_global('countFavorites',  Model_Favorite::count_favorites($this->current_profile->id));
            View::set_global('countReferals', Model_Profile::count_referals($this->current_profile->id));

            View::set_global('countnewmessage', Model_Message::count_unread($this->current_profile->id));
            View::set_global('countfriendrequest', Model_Friendship::count_pending_friends($this->current_profile->id));
            //Count all online members
            View::set_global('all_online_members_count',  Model_Profile::count_all_online_members());

            //count all dating agent clients
            if($this->current_profile->member_type_id == 3) {
                View::set_global('countAgentClients',  Model_Agentclient::count_clients($this->current_profile->id));
            } else {
                View::set_global('countAgentClients',  0);
            }
            View::set_global('countAgentReferals', Model_Referfriends::count_agent_referrals($this->current_profile->id));

            //Count all online dating agents
            View::set_global('countOnlineDatingAgents',  Model_Profile::online_dating_agents_count());
        }
    }

    public function check_permission($exception){
        if(!Auth::check() && !in_array("*", $exception) && !in_array(Request::active()->action, $exception) ){
            Session::set_flash('error', 'Access to requested area requires logging in. Please login!');
            Response::redirect(Router::get("login"));
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

    public function action_send_scheduled_email()
    {
        $profiles = Model_profile::query()->where('send_me_listing_info', 1)->get();
        foreach($profiles as $profile) {
            $email = Model_Profile::get_email($profile->user_id);

            if($profile->member_type_id == 3)
            {
                $suggested_matches = Quicksearch::get_dating_agent_result($profile->id);
            }
            else
            {
                $suggested_matches = Quicksearch::get_random_matches($profile->id);
            }
            if(count($suggested_matches) > 0) {
                Email::forge()->to($email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Suggested Matches")
                    ->html_body(View::forge('email/scheduled_email', array("profile" => $profile,"suggested_matches" => $suggested_matches, "show" => "Suggested Match")))->priority(\Email\Email::P_HIGH)->send();
            }

            $active_events = Model_Event::get_active_events_by_region($profile->state, $profile->city);
            if ($active_events !== false) {
                Email::forge()->to($email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Suggested Events")
                    ->html_body(View::forge('email/scheduled_email', array("active_events" => $active_events, "show" => "Events")))->priority(\Email\Email::P_HIGH)->send();
            }
        }
        $response = Response::forge();
        $response->body("Scheduled Email Sent");
        return $response;
    }
      
}