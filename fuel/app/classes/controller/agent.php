<?php
use \Model\Quicksearch;
class Controller_Agent extends Controller_Base
{
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_client_view($profile_id)
    {
        $client_profile = Model_Profile::find($profile_id);
        $client_user = Model_Users::find($client_profile->user_id);
        $matches = Quicksearch::get_result($client_user->username, $client_user->password);
            $view = View::forge('datingAgent/client_view');
            $view->set_global('page_js', 'dating_agent/main.js');
            $view->set_global('page_css', 'datingAgent/client_view.css');
            $view->set_global('client_profile', $client_profile);
            $view->set_global('matches', $matches);
            $view->set_global("active_page", "dating_agent");
            $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Agent';
            $this->template->content = $view;
    }

    public function action_index()
    {
        if(Model_Profile::is_dating_agent($this->current_profile->id))
        {
            $view = View::forge('datingAgent/profile');
            $view->set_global('page_js', 'dating_agent/main.js');
            $view->set_global('page_css', 'datingAgent/profile.css');

            $view->clients = Model_Agentclient::get_clients($this->current_profile->id);
        }
        else
        {
            if(Model_Agentclient::is_already_booked($this->current_profile->id)) {
                \Fuel\Core\Response::redirect("agent/client_survey");
            } else {
                $view = View::forge('datingAgent/datingAgent');
                $dating_agents = Model_Profile::get_dating_agents();
                $view->dating_agents = $dating_agents;

                $view->set_global('page_js', 'dating_agent/main.js');
                $view->set_global('page_css', 'datingAgent/datingAgent.css');
            }
        }

        $view->set_global("active_page", "dating_agent");
        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Agent';
        $this->template->content = $view;
    }

    public function action_manage_clients()
    {
        if(Model_Profile::is_dating_agent($this->current_profile->id))
        {
            $view = View::forge('datingAgent/manage_clients');
            $view->set_global('page_js', 'dating_agent/manage_clients.js');
            $view->set_global('page_css', 'datingAgent/profile.css');

            $view->clients = Model_Agentclient::get_pending_clients($this->current_profile->id);
        }
        else
        {
            \Fuel\Core\Response::redirect("agent");
        }

        $view->set_global("active_page", "dating_agent");
        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Agent';
        $this->template->content = $view;
    }

    public function action_update_agent_client() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $receiver_id = $this->current_profile->id;
            $sender_id = Input::post("sender_id");

            $client_request =Model_Agentclient::query()->where("sender_id", "=", $sender_id)
                ->where("receiver_id", "=", $receiver_id)->get_one();

            if ($client_request) {
                $client_request->status = Input::post("status");

                if($client_request->status === Model_Agentclient::STATUS_REJECTED){
                    $client_request->delete();
                } else {
                    $client_request->save();
                }

                if($client_request->status == Model_Agentclient::STATUS_ACCEPTED){
                    $response_message = "Client request accepted.";
                }else if($client_request->status == Model_Agentclient::STATUS_REJECTED){
                    $response_message =  "Client deleted.";
                }

                $response->body(json_encode(array(
                    'status' => true,
                    'message' => $response_message,
                )));
            } else {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "Client request does not exist!",
                )));
            }
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_book_me()
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('pages/404');

        $response = Response::forge();

        if (!Model_Profile::find(Input::post("dating_agent_id"))) {
            $response->body(json_encode(array(
                'status' => false,
                'message' => "The dating agent does not exist!"
            )));
        } else if(Model_Agentclient::is_already_client($this->current_profile->id, Input::post("dating_agent_id"))){
            $response->body(json_encode(array(
                'status' => false,
                'message' => "You are already a client for the selected dating agent!"
            )));
        } else if(Model_Agentclient::is_already_booked($this->current_profile->id)){
            $response->body(json_encode(array(
                'status' => false,
                'message' => "You are already a client for a dating agent!"
            )));
        }else {
            $dating_agent_invitation = Model_Agentclient::forge();
            $dating_agent_invitation->sender_id = $this->current_profile->id;
            $dating_agent_invitation->receiver_id = Input::post('dating_agent_id');
            $dating_agent_invitation->status = Model_Agentclient::STATUS_SENT;

            $dating_agent_invitation->save();

            if(!Model_Friendship::request_exchanged($this->current_profile->id, Input::post("dating_agent_id"))) {
                $friendship = Model_Friendship::forge(array(
                    "sender_id" => $this->current_profile->id,
                    "receiver_id" => Input::post('dating_agent_id'),
                    "status" => Model_Friendship::STATUS_SENT
                ));
                $friendship->save();
            }

            $response->body(json_encode(array(
                'status' => true,
                'message' => "Book Me successfully sent"
            )));
        }
        return $response;
    }

    public function action_view_all_profile()
    {
        $view = View::forge('datingAgent/view_all_profile');
        $view->set_global('page_js', 'dating_agent/main.js');
        $view->set_global('page_css', 'datingAgent/profile.css');


        $admin_users =  Model_Users::find('all', array('where' => array('group_id' => 5)));
        $admin_profiles = array(); $i=0;
        foreach($admin_users as $admin){
            $admin_profiles[$i] = Model_Profile::query()->where('user_id', $admin->id)->get_one()->id;
        }
        $admin_profile_ids = '';
        for($j=0;$j<count($admin_profiles);$j++){
            if($j == count($admin_profiles) - 1)
                $admin_profile_ids .= $admin_profiles[$j].'';
            else
                $admin_profile_ids .= ','.$admin_profiles[$j].',';
        }

        $latest_members = DB::select()
            ->from('profiles')
            ->where('id', '<>', $this->current_profile->id )
            ->where('id', 'not in', array($admin_profile_ids) )
            ->where('member_type_id', '<>', Model_Membershiptype::DATING_AGENT_MEMBER)
            ->where('disable', 0)
            ->order_by('created_at', 'desc')->execute();

        $view->latest_members = $latest_members;
        $view->set_global("active_page", "dating_agent");
        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Agent';
        $this->template->content = $view;
    }

    public function action_client_survey()
    {
        $post = Input::post();
        if($post) {
            $client_survey = Model_Agentclient::find($post["id"]);
            unset($post["id"]);
            $client_survey->set($post);

            if ($client_survey->save()) {
                Session::set_flash('success', 'Client Survey updated successfully!');
            } else {
                Session::set_flash('error', 'Updating Client Survey failed. Please try again!');
            }
        }
        $view = View::forge('datingAgent/client_survey');
        $client_agent = Model_Agentclient::get_client_agent($this->current_profile->id);
        $view->client_agent = $client_agent;
        if($client_agent) {
            $view->client_agent_profile = Model_Profile::find($client_agent->receiver_id);
            $view->referred_friends = Model_Referfriends::get_agent_referrals($this->current_profile->id,$client_agent->receiver_id);
        } else {
            \Fuel\Core\Response::redirect("agent");
        }

        $view->set_global("active_page", "dating_agent");
        $view->set_global('page_css', 'datingAgent/datingAgent.css');
        $view->set_global('page_js', 'dating_agent/client_survey.js');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Agent';
        $this->template->content = $view;
    }

    public function action_agent_survey($client_id)
    {
        $view = View::forge('datingAgent/agent_client');

        if($client_id <> null && Model_Profile::is_dating_agent($this->current_profile->id)) {
            $view->client_profile = Model_Profile::find($client_id);
            $view->client_agent = Model_Agentclient::get_client_agent($client_id);

            $view->agent_clients = Model_Friendship::get_friends($this->current_profile->id); // Model_Agentclient::get_clients($this->current_profile->id);
            $view->referred_friends = Model_Referfriends::get_agent_referrals($client_id,$this->current_profile->id);
        } else {
            \Fuel\Core\Response::redirect("agent");
        }

        $view->set_global("active_page", "dating_agent");
        $view->set_global('page_css', 'datingAgent/datingAgent.css');
        $view->set_global('page_js', 'dating_agent/client_survey.js');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Agent';
        $this->template->content = $view;
    }

    public function action_client_referrals()
    {
        $view = View::forge('datingAgent/client_referrals');

        if(Model_Profile::is_dating_agent($this->current_profile->id)) {
            $view->referred_friends = Model_Referfriends::get_agent_all_referrals($this->current_profile->id);
        } else {
            \Fuel\Core\Response::redirect("agent");
        }

        $view->set_global("active_page", "dating_agent");
        $view->set_global('page_js', 'dating_agent/main.js');
        $view->set_global('page_css', 'datingAgent/profile.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Agent';
        $this->template->content = $view;
    }

    public function action_refer_to_client(){
        $response = Response::forge();
        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }
        $post = Input::post();
        $refer_from = $post['from_id'];
        $refer_to = $post['refered_member'];
        $referred_id = $post['to_id'];

        $query = DB::select('*')->from('refer_friends');
        $query->where('refer_to', $refer_to);
        $query->where('refered_id', $referred_id);
        $result = $query->execute();

        if(count($result) > 0){
            $response->body(json_encode(array(
                'status' => false,
                'heading' => "Refer Me!",
                'message' => "Member already referred ",
            )));
        } else {
            $refer_friends = Model_Referfriends::forge(array(
                "refer_from" => $refer_from,
                "refer_to" => $refer_to,
                "refered_id" => $referred_id,
                "status" => 0
            ));
            $refer_friends->save();

            $response->body(json_encode(array(
                'status' => true,
                'heading' => "Refer Me!",
                'message' => "Member Successfully referred",
            )));
        }
        return $response;
    }

    public function action_view($agent_profile_id)
    {
        $view = View::forge('datingAgent/datingAgentDetail');
        
        $dating_agent = Model_Profile::find($agent_profile_id);
        
        if(false !== Model_Comment::get_comments_by_receiver($agent_profile_id)){
            $comments = Model_Comment::get_comments_by_receiver($agent_profile_id);
            $view->set_global('comments', $comments);
        }
            
        
        $view->set_global('dating_agent', $dating_agent);
        
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
         $view->profile_address = $profile_address;
            $view->profile_state = $profile_state;
        $view->set_global("active_page", "dating_agent");
        $view->set_global('page_js', 'dating_agent/main.js');
        $view->set_global('page_css', 'datingAgent/datingAgentDetail.css');
        


        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Agent Details';

        $this->template->content = $view;
    }
    
    public function action_refer_a_friend()
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('page/404');
    
        $from_name = $this->current_profile->first_name.' '.$this->current_profile->last_name;
        $gender = $this->current_profile->gender_id;
        $to_email = \Fuel\Core\Input::post('email');
        $message = \Fuel\Core\Input::post('message'); 
     
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $to_email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
            
            $refer_data["email_from"] = $this->current_user->email;
            $refer_data["refered_email"] = $to_email;           
            $refer_emails = Model_Referedemail::forge($refer_data);
            $refer_emails->save();
        }
            
        $response = Response::forge();
         try {
             if (Model_Setting::is_set_email_notification($this->current_profile->id)){
                 Email::forge()->to($to_email)->from($this->current_user->email)->subject("friend invitation")
                ->html_body(View::forge('email/dating',array("message" => $message, "from_name" => $from_name, "gender" => $gender, )   )
                )->send();
             }
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
    
    public function action_refer_me()
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('page/404');
    
        $from_name = $this->current_profile->first_name.' '.$this->current_profile->last_name;
        $to_email = \Fuel\Core\Input::post('email');
        $dating_agent_id = Input::post('dating_agent_id');
        $dating_agent_url = Uri::create('agent/view/'.$dating_agent_id);
    
    
        $response = Response::forge();
    
        try {
            if (Model_Setting::is_set_email_notification($this->current_profile->id)){
                Email::forge()
                ->to("abbifa@gmail.com")
                ->from($this->current_user->email)
                ->subject("Checkout this event")
                ->html_body(
                        View::forge('email/event_refer_a_friend',
                                array(
                                        "dating_agent_url" => $dating_agent_url,
                                        "from_name" => $from_name,
                                )
                        )
                )->send();
            }
    
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

    public function action_send_invitation()
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('pages/404');

        $response = Response::forge();


        $dating_agent_invitation = Model_Datingagentinvitaion::forge();
        $dating_agent_invitation->dating_agent_profile = Input::post('dating_agent_profile');
        $dating_agent_invitation->profile_from = $this->current_profile->id;
        $dating_agent_invitation->profile_to = Input::post('profile_to');
        $dating_agent_invitation->status = Model_Datingagentinvitaion::INVITATION_PENDING;

        if($dating_agent_invitation->save()){
            Model_Notification::save_notifications(
                Model_Notification::DATING_AGENT_INVITATION_SENT,
                $dating_agent_invitation->dating_agent_profile,
                $dating_agent_invitation->profile_to,
                $this->current_profile->id
            );
            $notification_profile = Model_Profile::find($dating_agent_invitation->profile_to);
            $notification_user = Model_Users::find($notification_profile->user_id);
            try{
                if (Model_Setting::is_set_email_notification($this->current_profile->id)){
                    Email::forge()->to($notification_user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                        ->html_body(View::forge('email/notification', array("notification" => $this->current_profile->first_name . ' ' . $this->current_profile->last_name ." has invited you to a dating agent!")))->priority(\Email\Email::P_HIGH)->send();
                }
            }catch (EmailSendingFailedException $e) {

            }

            return $response->body(json_encode(array(
                'status' => true
            )));
        }

        return $response->body(json_encode(array(
            'status' => false
        )));

    }

    public function action_accept_invitation($invitation_id)
    {
        if( ! Input::is_ajax())
        \Fuel\Core\Response::redirect('pages/404');

        $response = \Fuel\Core\Response::forge();
        $invitation = Model_Datingagentinvitaion::find($invitation_id);
        $invitation->status = Model_Datingagentinvitaion::INVITATION_ACCEPTED;

        if($invitation->save()){
            return $response->body(json_encode(array(
                'accepted' => true,
                'url' => \Fuel\Core\Uri::create('agent/view/'.$invitation->dating_agent_profile)
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
        $invitation = Model_Datingagentinvitaion::find($invitation_id);
        $invitation->status = Model_Datingagentinvitaion::INVITATION_REJECTED;

        if($invitation->save()){
            return $response->body(json_encode(array(
                'rejected' => true,
            )));
        }

        return $response->body(json_encode(array(
            'rejected' => false,
        )));

    }

    public function action_report_me()
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('pages/404');

        $response = \Fuel\Core\Response::forge();

        $message = Input::post('message');
        $dating_agent_id = Input::post('dating_agent_id');
        $reported_dating_agent = Model_Profile::find($dating_agent_id);
        try {
            //Craig@themanyouwant.com is currently serving as the admin's email address
            Email::forge()
                ->to('support@whereweallmeet.com')
                ->from($this->current_user->email)
                ->subject("Member report on a dating agent")
                ->html_body(
                    View::forge('email/violation_report',
                        array(
                            "reported_profile" => $reported_dating_agent,
                            "message" => $message,
                        )
                    )
                )->send();

        } catch (EmailSendingFailedException $e) {
            return $response->body(json_encode(array(
                'status' => true
            )));
        }

        return $response->body(json_encode(array(
            'status' => true
        )));
    }

    public function action_upgrade_account($id =null)
    {
        $view = View::forge('datingAgent/upgrade_account');
        if($id){
            $agent = Model_Profile::find($id);
        }

        $profile = Model_Profile::query()->where('user_id', $this->current_user->id)->get_one();
        $view->profile = $profile;
        $countries = Model_Country::find('all', array('order_by' => 'name'));
        $view->countries = $countries;
        $payment_types = Model_Paymenttype::find('all');
        $view->payment_types =  $payment_types;

        $billing = Model_Billing::query()->where('profile_id', $profile->id)->get_one();
        $billing = $billing == null ? Model_Billing::forge() : $billing;

        $view->billing = $billing;

        $view->agent = $agent;

        $view->set_global("active_page", "dating_agent");
        $view->set_global('page_js', 'membership/agent_client.js');
        $view->set_global('page_css', 'datingAgent/datingAgent.css');


        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Agent';

        $this->template->content = $view;
    }

}