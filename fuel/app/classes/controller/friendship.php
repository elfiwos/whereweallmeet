<?php

class Controller_Friendship extends Controller_Base {
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_request() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            if (!Model_Profile::find(Input::post("receiver_id"))) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user you are trying to send a friend request to does not exist!"
                )));
            }
            else if(Input::post("sender_id") !== $this->current_profile->id) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "A friend request sender does not exist!"
                )));
            }
            else if($already_sent = Model_Friendship::request_exchanged($this->current_profile->id, Input::post("receiver_id"))){
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "A friend request has already been exchanged with this person!"
                )));
            } else {

                $friendship = Model_Friendship::forge(array(
                    "sender_id" => $this->current_profile->id,
                    "receiver_id" => Input::post("receiver_id"),
                    "status" => Model_Friendship::STATUS_SENT
                ));
                $friendship->save();



                $reciever_profile = DB::select('*')
                            ->from('profiles')
                            ->where('id',Input::post("receiver_id"))
                            ->execute();
                $reciever_info = DB::select('*')
                            ->from('users')
                            ->where('id',$reciever_profile[0]['user_id'])
                            ->execute();

                Model_Notification::save_notifications(
                    Model_Notification::FRIEND_REQUEST_SENT,
                    $friendship->id,
                    $friendship->receiver_id,
                    $friendship->sender_id
                );

                if($reciever_profile[0]['send_me_announcement_info'] == 1){
                    $message = $this->current_profile->first_name .' '.$this->current_profile->last_name .' has sent you a friend request';
                                 Email::forge()
                                         ->to($reciever_info[0]['email'])
                                         ->from("admin@whereweallmeet.com")
                                        ->subject("You have a new Friend Request")
                                        ->html_body(
                                     View::forge('email/friend_request',
                                                 array(
                                                     "message" => $message,
            
                                                    "from_name" => $from_name,
                                            )
                                         )
                                     )->send();
                }
                $receiver = Model_Profile::find($friendship->receiver_id);
                $response->body(json_encode(array(
                    'status' => true,
                    'message' => "Your friendship request sent to <strong>" . Model_Profile::get_username($receiver->user_id). "</strong>",
                )));
            }

            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_update() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $receiver_id = Input::post("receiver_id");
            $sender_id = Input::post("sender_id");

            $friendship =Model_Friendship::query()->where("sender_id", "=", $sender_id)
                                                    ->where("receiver_id", "=", $receiver_id)->get_one();

            if ($friendship) {
                $friendship->status = Input::post("status");

                if($friendship->status === Model_Friendship::STATUS_REJECTED){
                    $friendship->delete();
                } else {
                    $friendship->save();
                }

                if($friendship->status == Model_Friendship::STATUS_ACCEPTED){
                    $response_message = "Friendship request accepted.";
                }else if($friendship->status == Model_Friendship::STATUS_REJECTED){
                    $response_message =  "Friendship deleted.";
                }

                $response->body(json_encode(array(
                    'status' => true,
                    'message' => $response_message,
                )));
            } else {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "Friendship request does not exist!",
                )));
            }
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_accept_reject($sender_id = null) {
            $receiver_id = $this->current_profile->id;
            $friendship =Model_Friendship::query()->where("sender_id", "=", $sender_id)
                                                    ->where("receiver_id", "=", $receiver_id)->get_one();
            if ($friendship) {
                if($friendship->status === Model_Friendship::STATUS_REJECTED){
                    $friendship->delete();
                } else {
                    $friendship->save();
                }
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
        $view = View::forge('profile/my_friends');
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
        //$online_members = Quicksearch::get_online_members($username, $password);
       // $view->online_members  =  $online_members;  
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");

        $view->set_global('page_js', 'profile/my_friends.js');      

        $view->set_global('page_css', 'events/event.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Friends';
        $this->template->content = $view;
                
           
        
    }

    public function action_manage_friends() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $current_profile_id = $this->current_profile->id;
            $friend_id = Input::post("friend_id");

            $friendship = Model_Friendship::query()->and_where_open()
                ->where("sender_id", "=", $current_profile_id)
                ->where("receiver_id", "=", $friend_id)
                ->and_where_close()
                ->or_where_open()
                ->where("sender_id", "=", $friend_id)
                ->where("receiver_id", "=", $current_profile_id)
                ->or_where_close()
                ->get_one();

            if ($friendship) {
                $friendship->status = Input::post("status");

                if($friendship->status === Model_Friendship::STATUS_DELETED){
                    $friendship->delete();

                    if(Model_Profile::is_dating_agent($friend_id)) {
                        $agent_client =Model_Agentclient::query()->where("sender_id", "=", $current_profile_id)
                            ->where("receiver_id", "=", $friend_id)->get_one();
                        if ($agent_client) {
                            $agent_client->delete();
                        }
                    }

                } else {
                    $friendship->save();
                }

                if($friendship->status == Model_Friendship::STATUS_BLOCKED){
                    $response_message = "Friend has been blocked.";
                }else if($friendship->status == Model_Friendship::STATUS_DELETED){
                    $response_message =  "Friend has been deleted.";
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

    public function action_get_friends_usernames() {
        $response = Response::forge();
        $friends_usernames = array();

        if (Input::method() == 'POST' or Input::is_ajax()) {
            $friends = Model_Friendship::get_friends($this->current_profile->id);
            if($friends){
                foreach ($friends as $friend) {
                    $user = \Auth\Model\Auth_User::find($friend->user_id);
                    if($user) {
                        array_push($friends_usernames, $user->username);
                    }
                }
            }
            $response->body(json_encode(array(
                'status' => true,
                'friends_usernames' => $friends_usernames,
            )));
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }
}