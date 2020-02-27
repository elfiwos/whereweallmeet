<?php

class Controller_Package extends Controller_Base
{
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_index()
    {
        if( ! \Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');

        $view = View::forge('datingPackage/index');
        $view->set_global('active_datingPackages', Model_Datepackage::get_active_packages_by_region($this->current_profile->state, $this->current_profile->city));

        $friends = Model_friendship::get_friends($this->current_profile->id);
        $view->set('friends', $friends);

        $view->set_global("active_page", "dating_packages");
        $view->set_global('page_js', 'dating_package/package.js');
        $view->set_global('page_css', 'datingPackage/datingPackage.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Packages';
        $this->template->content = $view;
    }

    public function action_view($id = null)
    {
        is_null($id) and \Fuel\Core\Response::redirect('pages/404');

        $event = Model_Datepackage::find($id);

        if($event === false)
            \Fuel\Core\Response::redirect('pages/404');

        $view = View::forge('datingPackage/view');
        $view->event = $event;
        $view->my_friends = Model_Friendship::get_friends($this->current_profile->id);
        $view->profiles = Model_profile::find('all');

        $view->set_global("active_page", "dating_packages");
        $view->set_global('page_js', 'dating_package/view.js');
        $view->set_global('page_css', 'events/event.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Package Details';
        $this->template->content = $view;
    }

    public function action_book()
    {
        $rsvp = Model_Rsvp::forge();
        $event = Model_Datepackage::find(Input::post('event_id'));
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
                    ->subject("Date Idea RSVP from WHERE WE ALL MEET.COM")
                    ->html_body(
                        View::forge('email/package_book',
                            array(
                                "event" => Model_Datepackage::find($rsvp->event_id),
                            )
                        )
                    )->send();
            } catch (EmailSendingFailedException $e) {
                Response::redirect('package/view/'.$event->id);
            }
        }
        else{
            Response::redirect('package/view/'.$event->id);
        }
    }

    public function action_invite_a_friend()
    {
        $to_email = DB::select('email')
            ->from('users')
            ->where('username',Input::post('location'))
            ->execute();
        $id=DB::select('id')
            ->from('users')
            ->where('username',Input::post('location'))
            ->execute();
        $reciever = DB::select('*')
            ->from('profiles')
            ->where('user_id',$id[0]['id'])
            ->execute();

        $from_name = $this->current_user->username;

        $message = Input::post('location').'has sent you a date idea invitation' ;
        $event = Model_Datepackage::find(\Fuel\Core\Input::post('event_id'));
        $event_url = \Fuel\Core\Uri::base().'package/view/'.$event->id;
         
    
        if($reciever[0]['send_me_date_invitations'] == 1){
            try {
                Email::forge()
                    ->to($to_email[0]['email'])
                    ->from($this->current_user->email)
                    ->subject("Checkout this date idea")
                    ->html_body(
                        View::forge('email/package_invite_a_friend',
                            array(
                                "message" => $message,
                                "event_url" => $event_url,
                                "from_name" => $from_name,
                            )
                        )
                    )->send();
            } catch (EmailSendingFailedException $e) {
            }
        }
        Response::redirect('package/view/'.$event->id);
    }

    public function action_date_idea_invitation()
    {
        if(Input::post('friend') == "") {
            Response::redirect('package/index');
        }
        $to_email = DB::select('email')
            ->from('users')
            ->where('username',Input::post('friend'))
            ->execute();
        $id = DB::select('id')
            ->from('users')
            ->where('username',Input::post('friend'))
            ->execute();
        $user = DB::select('id')
            ->from('profiles')
            ->where('user_id',$id[0]['id'])
            ->execute();

        $from_name = $this->current_user->username;
        $message = Input::post('idea') ;

        $query = DB::insert('refereddateideas');
        $query->set(array(
            "refered_by" => $this->current_profile->id,
            "refered_to" => $user[0]['id'],
            "message" => $message
        ));
        $query->execute();

        $dateidea_id = DB::select('id')
            ->from('refereddateideas')
            ->where('refered_by',$this->current_profile->id)
            ->where('refered_to',$user[0]['id'])
            ->where('message',$message)
            ->execute();


        Model_Notification::save_notifications(
            Model_Notification::DATE_IDEA_SENT,
            $dateidea_id[0]['id'],
            $user[0]['id'],
            $this->current_profile->id
        );


        try {
            Email::forge()
                ->to($to_email[0]['email'])
                ->from("noreply@whereweallmeet.com")
                ->subject("Checkout this Date Idea of Mine")
                ->html_body(
                    View::forge('email/dateidea_refer_a_friend',
                        array(
                            "message" => $message,
                            "from_name" => $from_name,
                        )
                    )
                )->send();
            Response::redirect('package/index');


        } catch (EmailSendingFailedException $e) {
            Response::redirect('package/index');
        }
    }

}