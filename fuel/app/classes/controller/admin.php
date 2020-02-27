<?php

class Controller_Admin extends Controller_Base {

    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);

        $admin = Model_Users::query()
        ->where("user_id", $this->current_user->user_id)
        ->where("group_id", 5)
        ->get_one();
        if(!$admin){
        	\Fuel\Core\Response::redirect('pages/home');
        }
    }
	

	public function action_index() {
        $search_text = "";
        if(Input::post()) {
              if ($_POST['submit1'] == 'Save')
              {
                    $members=$_POST['membertype'];
                    foreach($members as $key=> $val){
                        DB::update('profiles')
                              ->where('id',$key)
                              ->value('member_type_id',$val)
                              ->execute();
                    }
                    $subscription_date=$_POST['subscription_date'];
                    foreach($subscription_date as $key=> $val){
                        DB::update('profiles')
                              ->where('id',$key)
                              ->value('subscription_date',isset($val) && $val <> null ? strtotime($val) : null)
                              ->execute();
                    }
                    $subscription_expiry_date=$_POST['subscription_expiry_date'];
                    foreach($subscription_expiry_date as $key=> $val){
                        DB::update('profiles')
                              ->where('id',$key)
                              ->value('subscription_expiry_date',isset($val) && $val <> null ? strtotime($val): null)
                              ->execute();
                    }
                    Response::redirect('admin/index');
              }
              if ($_POST['submit1'] == 'Delete')
              {
                if(!isset($_POST['list']))
                {
                    Session::set_flash("error", "Please select at least one member to delete.");
                }
                else
                {
                    $delete_members = $_POST['list'];
                    foreach($delete_members as $key=> $val){
                        DB::update('profiles')
                            ->where('id',$key)
                            ->value('disable',1)
                            ->execute();
                    }
                }
                Response::redirect('admin/index');
              }
              if ($_POST['submit1'] == 'Block') {
                  if(!isset($_POST['list']))
                  {
                      Session::set_flash("error", "Please select at least one member to block.");
                  }
                  else
                  {
                      $block_members = $_POST['list'];
                      foreach($block_members as $key=> $val){
                          DB::update('profiles')
                              ->where('id',$key)
                              ->value('is_blocked',1)
                              ->execute();
                      }
                  }
                  Response::redirect('admin/index');
              }
              if ($_POST['submit1'] == 'Search') {
                    $search_text = $_POST['searchbox'];
              }
          }

		  $base_url=\uri::base(false).'admin/index';
		  Pagination::set('per_page', 10);


        if($search_text <> "") {
            $members = Model_profile::query()->related('user')->where('user.group_id', '!=', '5')->where('disable','<>', 1)
                ->and_where_open()
                ->where('user.username','like','%'.$search_text.'%')->or_where('user.email','like','%'.$search_text.'%')
                ->and_where_close()
                ->get();
        } else {
            $members = Model_profile::query()->related('user')->where('user.group_id', '!=', '5')->where('disable','<>', 1)->order_by('created_at', 'DESC')->get();
        }

	      $config = array(
              'pagination_url' => $base_url,
              'total_items'    => count($members),
              'per_page'       => 10,
              'uri_segment'    => 3,
              'template' => array(
                  'wrapper_start' => '<div class="my-pagination"> ',
                  'wrapper_end' => ' </div>',
              ),
          );
	
	      $pagination = Pagination::forge('mypagination',$config);

          if($search_text <> "") {
              $members = Model_profile::query()->related('user')->where('user.group_id', '!=', '5')->where('disable','<>', 1)
                  ->and_where_open()
                  ->where('user.username','like','%'.$search_text.'%')->or_where('user.email','like','%'.$search_text.'%')
                  ->and_where_close()
                  ->order_by('created_at', 'DESC')
                  ->rows_offset($pagination->offset)
                  ->rows_limit(\Pagination::get('per_page'))
                  ->get();
          } else {
              $members = Model_profile::query()->related('user')->where('user.group_id', '!=', '5')->where('disable','<>', 1)->order_by('created_at', 'DESC')
                  ->rows_offset($pagination->offset)
                  ->rows_limit(\Pagination::get('per_page'))
                  ->get();
          }

          $data['profiles'] = $members;
	      $data['pagination'] = $pagination->render();

	      $view = View::forge('admin/members_privilage',$data);
          $membershiptype=Model_membershiptype::find('all');
	      $view->membershiptype = $membershiptype;
          $view->set_global('page_css', 'admin/admin.css');
          $view->set_global('page_js', 'admin/index.js');
          $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
          $this->template->content = $view;
    }

    public function action_dashboard() {
        $view = View::forge('admin/dashboard');
        $view->members_count = Model_profile::count();
        $view->getaways_count = Model_Getaway::count();
        $view->events_count = Model_Event::count();
        $view->date_ideas_count = 0;
        $view->notifications_count = Model_Notification::count();
        $view->dating_agents_count = Model_Datingagentinvitaion::count();

        $view->set_global('page_css', 'admin/dashboard.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
        $this->template->content = $view;
    }

    public function action_notification() {
        if(Input::post()) {
            if (Input::post() && $_POST['submit'] == 'Save')
            {
                $current_date = date("Y-m-d H:i:s");


                if(Input::post('to_member_id') == "All"){
                    $profiles = Model_Profile::find('all');
                    foreach($profiles as $profile) {
                        $message = Model_Message::forge(array(
                            'from_member_id' => $this->current_profile->id,
                            'subject' => "Admin Notification",
                            'body' => Input::post('body'),
                            'date_sent' => $current_date,
                            'message_status' => 0,
                            'is_deleted_sender' => 0,
                            'is_deleted_receiver' => 0,
                            'parent_message_id' => 0,
                            'archive_inbox' => 0,
                            'archive_sent' => 0,
                            'is_deleted_reciever_forever' => 0,
                            'archive_inbox_id' => 0,
                            'archive_sent_id' => 0,
                            'trash_inbox_id' => 0,
                            'trash_sent_id' => 0,
                            'is_deleted_sender_forever' => 0,
                        ));
                        $message->to_member_id = $profile->id;
                        $message->save();
                        Model_Notification::save_notifications(Model_Notification::MESSAGE_SENT, $message->id, $message->to_member_id, $message->from_member_id);
                        if($profile->send_me_announcement_info == 1){
                            Email::forge()
                                ->to(Model_Profile::get_email($profile->user_id))
                                ->from("admin@whereweallmeet.com")
                                ->subject("You have a new Message")
                                ->html_body(View::forge('email/message_sent',array("message" => 'WWAM Admin has sent you a message',)))
                                ->send();
                        }
                        Session::set_flash('success', 'Message Sent ');
                    }
                } elseif(Input::post('to_member_id') == "Free Members") {
                    $profiles = Model_Profile::find('all', array("where" => array(array("member_type_id", Model_Membershiptype::FREE_MEMBER))));
                    foreach($profiles as $profile) {
                        $message = Model_Message::forge(array(
                            'from_member_id' => $this->current_profile->id,
                            'subject' => "Admin Notification",
                            'body' => Input::post('body'),
                            'date_sent' => $current_date,
                            'message_status' => 0,
                            'is_deleted_sender' => 0,
                            'is_deleted_receiver' => 0,
                            'parent_message_id' => 0,
                            'archive_inbox' => 0,
                            'archive_sent' => 0,
                            'is_deleted_reciever_forever' => 0,
                            'archive_inbox_id' => 0,
                            'archive_sent_id' => 0,
                            'trash_inbox_id' => 0,
                            'trash_sent_id' => 0,
                            'is_deleted_sender_forever' => 0,
                        ));
                        $message->to_member_id = $profile->id;
                        $message->save();
                        Model_Notification::save_notifications(Model_Notification::MESSAGE_SENT, $message->id, $message->to_member_id, $message->from_member_id);
                        if($profile->send_me_announcement_info == 1){
                            Email::forge()
                                ->to(Model_Profile::get_email($profile->user_id))
                                ->from("admin@whereweallmeet.com")
                                ->subject("You have a new Message")
                                ->html_body(View::forge('email/message_sent',array("message" => 'WWAM Admin has sent you a message',)))
                                ->send();
                        }
                        Session::set_flash('success', 'Message Sent ');
                    }
                } elseif(Input::post('to_member_id') == "Paid Members") {
                    $profiles = Model_Profile::find('all', array("where" => array(array("member_type_id", Model_Membershiptype::PREMIER_MEMBER))));
                    foreach($profiles as $profile) {
                        $message = Model_Message::forge(array(
                            'from_member_id' => $this->current_profile->id,
                            'subject' => "Admin Notification",
                            'body' => Input::post('body'),
                            'date_sent' => $current_date,
                            'message_status' => 0,
                            'is_deleted_sender' => 0,
                            'is_deleted_receiver' => 0,
                            'parent_message_id' => 0,
                            'archive_inbox' => 0,
                            'archive_sent' => 0,
                            'is_deleted_reciever_forever' => 0,
                            'archive_inbox_id' => 0,
                            'archive_sent_id' => 0,
                            'trash_inbox_id' => 0,
                            'trash_sent_id' => 0,
                            'is_deleted_sender_forever' => 0,
                        ));
                        $message->to_member_id = $profile->id;
                        $message->save();
                        Model_Notification::save_notifications(Model_Notification::MESSAGE_SENT, $message->id, $message->to_member_id, $message->from_member_id);
                        if($profile->send_me_announcement_info == 1){
                            Email::forge()
                                ->to(Model_Profile::get_email($profile->user_id))
                                ->from("admin@whereweallmeet.com")
                                ->subject("You have a new Message")
                                ->html_body(View::forge('email/message_sent',array("message" => 'WWAM Admin has sent you a message',)))
                                ->send();
                        }
                        Session::set_flash('success', 'Message Sent ');
                    }
                } elseif(Input::post('to_member_id') == "Dating Agents") {
                    $profiles = Model_Profile::find('all', array("where" => array(array("member_type_id", Model_Membershiptype::DATING_AGENT_MEMBER))));
                    foreach($profiles as $profile) {
                        $message = Model_Message::forge(array(
                            'from_member_id' => $this->current_profile->id,
                            'subject' => "Admin Notification",
                            'body' => Input::post('body'),
                            'date_sent' => $current_date,
                            'message_status' => 0,
                            'is_deleted_sender' => 0,
                            'is_deleted_receiver' => 0,
                            'parent_message_id' => 0,
                            'archive_inbox' => 0,
                            'archive_sent' => 0,
                            'is_deleted_reciever_forever' => 0,
                            'archive_inbox_id' => 0,
                            'archive_sent_id' => 0,
                            'trash_inbox_id' => 0,
                            'trash_sent_id' => 0,
                            'is_deleted_sender_forever' => 0,
                        ));
                        $message->to_member_id = $profile->id;
                        $message->save();
                        Model_Notification::save_notifications(Model_Notification::MESSAGE_SENT, $message->id, $message->to_member_id, $message->from_member_id);
                        if($profile->send_me_announcement_info == 1){
                            Email::forge()
                                ->to(Model_Profile::get_email($profile->user_id))
                                ->from("admin@whereweallmeet.com")
                                ->subject("You have a new Message")
                                ->html_body(View::forge('email/message_sent',array("message" => 'WWAM Admin has sent you a message',)))
                                ->send();
                        }
                        Session::set_flash('success', 'Message Sent ');
                    }
                } else {
                    $message = Model_Message::forge(array(
                        'from_member_id' => $this->current_profile->id,
                        'subject' => "Admin Notification",
                        'body' => Input::post('body'),
                        'date_sent' => $current_date,
                        'message_status' => 0,
                        'is_deleted_sender' => 0,
                        'is_deleted_receiver' => 0,
                        'parent_message_id' => 0,
                        'archive_inbox' => 0,
                        'archive_sent' => 0,
                        'is_deleted_reciever_forever' => 0,
                        'archive_inbox_id' => 0,
                        'archive_sent_id' => 0,
                        'trash_inbox_id' => 0,
                        'trash_sent_id' => 0,
                        'is_deleted_sender_forever' => 0,
                    ));
                    $message->to_member_id = Input::post('to_member_id');
                    $message->save();
                    Model_Notification::save_notifications(Model_Notification::MESSAGE_SENT, $message->id, $message->to_member_id, $message->from_member_id);
                    $objProfile = Model_Profile::find(Input::post('to_member_id'));
                    if(isset($objProfile) && $objProfile->send_me_announcement_info == 1){
                        Email::forge()
                            ->to(Model_Profile::get_email($objProfile->user_id))
                            ->from("admin@whereweallmeet.com")
                            ->subject("You have a new Message")
                            ->html_body(View::forge('email/message_sent',array("message" => 'WWAM Admin has sent you a message',)))
                            ->send();
                    }
                    Session::set_flash('success', 'Message Sent ');
                }
                Response::redirect('admin/notification');
            }
        }
        $view = View::forge('admin/notification');

        $view->profiles = Model_Profile::find("all");
        $view->set_global('page_css', 'admin/dashboard.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
        $this->template->content = $view;
    }

    public function action_event_plan() {
        $events = Model_Event::query()
            ->order_by('created_at', 'DESC')
            ->get();

        $identifier = 0;
    	$view = View::forge('admin/event_plan');
    	$view->events = $events;
    	$view->identifier = $identifier;
    	
    	if(\Fuel\Core\Input::post())
    	{
    		$val = \Fuel\Core\Validation::forge();
    		$val->add('title', 'Event Name')->add_rule('required');
    		$val->add('long_description', 'Long Description')->add_rule('required');
    		$val->add('short_description', 'Short Description')->add_rule('required');
    		$val->add('organizers_details', 'Organizers Details')->add_rule('required');

    		if( ! $val->run()){
    			$view->set_global('page_css', 'admin/event_plan.css');
    			$this->template->title = 'Where We All Meet &raquo; Admin';
    			$view->set_global('page_js', 'events/create.js');
    			$view->set_global('errors',$val->error());
    			$this->template->content = $view;
    		}
    		if($val->run()){
    		$event = Model_Event::forge();
    		$upload_file = Input::file("photo");
    		
    		if ($upload_file["size"] > 0) {
    			$config = array(
    					'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR .'events',
    					'auto_rename' => false,
    					'overwrite' => true,
    					'randomize' => true,
    					'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
    					'create_path' => true,
    					'path_chmod' => 0777,
    					'file_chmod' => 0777,
    			);
    	
    			\Fuel\Core\Upload::process($config);
    	
    			if (\Fuel\Core\Upload::is_valid()) {
    				\Fuel\Core\Upload::save();
    				$file = Upload::get_files(0);
    				$event->photo = $file['saved_as'];
    				$event->title = Input::post('title');
    				$event->organizers_details = Input::post('organizers_details');
    				$event->long_description = Input::post('long_description');
    				$event->short_description = Input::post('short_description');
    				$event->url = Input::post('url');
                    $event->youtube_video = Input::post('youtube_video');
                    $event->state = Input::post('state');
    				$event->city = Input::post('city');
    				$event->venue = Input::post('venue');
    				$event->start_date = Input::post('event_date');
    				$event->time_zone = Input::post('start_date');
    				$event->start_time = Input::post('start_time_hour');
    				$event->end_time = Input::post('end_time_hour');
    				$event->zip = Input::post('zip');
    				$event->event_end_date = Input::post('event_end_date');
    				$event->start_pm_am = Input::post('start_pm_am');
    				$event->end_pm_am = Input::post('end_pm_am');
                    $event->type = Input::post('type');

                    if(isset($_POST['is_featured']))
    				{
    					$event->is_featured = 1;
    				} else{
    					$event->is_featured = 0;
    				}
    	
    				$filepath = $file['saved_to'] . $file['saved_as'];
    	
    				foreach (Model_Event::$thumbnails as $type => $dimensions) {
    					Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
    				}
    	
    				if($event->save()){
    					Session::set_flash('success', 'You have successfully saved the event.');
    					\Fuel\Core\Response::redirect('admin/event_plan');
    				}
    	           
    				else
    				{
    					Session::set_flash('error', 'There is an error and the event is not saved. Please try again');
    				}
    				
    			}
    		}
    	}
     }
    	    	   

    	$view->set_global('page_js', 'events/create.js');
    	$view->set_global('page_css', 'admin/event_plan.css');
    	$this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
    	$this->template->content = $view;
    	 
    }

    public function action_dating_packages() {
    	$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
    	$identifier = 0;
    	$view = View::forge('admin/dating_packages');
    	$view->events = $events;
    	$view->identifier = $identifier;

    	if(\Fuel\Core\Input::post())
    	{
    		$val = \Fuel\Core\Validation::forge();
    		$val->add('title', 'Venue Name')->add_rule('required');
    		$val->add('long_description', 'Date Idea Description')->add_rule('required');
    		$val->add('short_description', 'Venue Details')->add_rule('required');
    		$val->add('price', 'Price')->add_rule('required');
    		if( ! $val->run()){
    			$view->set_global('page_css', 'admin/event_plan.css');
    			$this->template->title = 'Where We All Meet &raquo; Admin';
    			$view->set_global('page_js', 'events/create.js');
    			$view->set_global('errors',$val->error());
    			$this->template->content = $view;
    			 
    			 
    		}
    		if($val->run()){
    		$event = Model_Datepackage::forge();
    		$upload_file = Input::file("photo");
    	
    		if ($upload_file["size"] > 0) {
    			 
    			$config = array(
    					'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR .'packages',
    					'auto_rename' => false,
    					'overwrite' => true,
    					'randomize' => true,
    					'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
    					'create_path' => true,
    					'path_chmod' => 0777,
    					'file_chmod' => 0777,
    			);
    			 
    			\Fuel\Core\Upload::process($config);
    			 
    			if (\Fuel\Core\Upload::is_valid()) {
    				\Fuel\Core\Upload::save();
    				$file = Upload::get_files(0);
    				$event->picture = $file['saved_as'];
    				$event->title = Input::post('title');
    				$event->short_description = Input::post('short_description');
    				$event->long_description = Input::post('long_description');
                    $event->url = Input::post('url');
                    $event->youtube_video = Input::post('youtube_video');
                    $event->state = Input::post('state');
    				$event->city = Input::post('city');
    				$event->event_venue = Input::post('event_venue');
    				$event->event_date = Input::post('event_date');
    				$event->time_from = Input::post('time_from');
    				$event->time_to = Input::post('time_to');
    				$event->zip_code = Input::post('zip');
    				$event->price = Input::post('price');
    				$event->event_end_date = Input::post('event_end_date');
    				$event->start_pm_am = Input::post('start_pm_am');
    				$event->end_pm_am = Input::post('end_pm_am');
    				if(isset($_POST['is_featured']))
    				{
    					$event->is_featured = 1;
    				} else{
    					$event->is_featured = 0;
    				}
    				 
    				$filepath = $file['saved_to'] . $file['saved_as'];
    				    				
    			  foreach (Model_Datepackage::$thumbnails as $type => $dimensions) {
    					Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
    				}
    				   				 
    				if($event->save()){
    					Session::set_flash('success', 'You have successfully saved the date idea.');
    					\Fuel\Core\Response::redirect('admin/dating_packages');
    				}
    	
    				else
    				{
    					Session::set_flash('error', 'There is an error and the date idea is not saved. Please try again');
    				}
    	          
    			}
    		}
    	}
    	} 
    	 
    	
    	$view->set_global('page_js', 'events/create.js');
    	$view->set_global('page_css', 'admin/event_plan.css');
    	$this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
    	$this->template->content = $view;
    
    }

    public function action_getaways() {
        $getaways = Model_Getaway::query()->order_by('created_at', 'DESC')->get();
        $identifier = 0;
        $view = View::forge('admin/getaways');
        $view->getaways = $getaways;
        $view->identifier = $identifier;
        $view->countries = Model_Country::find('all', array('order_by' => 'name'));

        if(\Fuel\Core\Input::post())
        {
            $val = \Fuel\Core\Validation::forge();
            $val->add('title', 'Title')->add_rule('required');
            $val->add('long_description', 'Long Description')->add_rule('required');
            $val->add('short_description', 'Short Description')->add_rule('required');
            $val->add('organizers_details', 'Organizers Details')->add_rule('required');
            $val->add('country', 'Country')->add_rule('required');

            if( ! $val->run()){

                $view->set_global('page_css', 'admin/event_plan.css');
                $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
                $view->set_global('errors',$val->error());
                $this->template->content = $view;
            }
            if($val->run()){
                $getaways = Model_Getaway::forge();
                $upload_file = Input::file("photo");

                if ($upload_file["size"] > 0) {

                    $config = array(
                        'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR .'getaways',
                        'auto_rename' => false,
                        'overwrite' => true,
                        'randomize' => true,
                        'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                        'create_path' => true,
                        'path_chmod' => 0777,
                        'file_chmod' => 0777,
                    );

                    \Fuel\Core\Upload::process($config);

                    if (\Fuel\Core\Upload::is_valid()) {
                        \Fuel\Core\Upload::save();
                        $file = Upload::get_files(0);
                        $getaways->photo = $file['saved_as'];
                        $getaways->title = Input::post('title');
                        $getaways->organizers_details = Input::post('organizers_details');
                        $getaways->long_description = Input::post('long_description');
                        $getaways->short_description = Input::post('short_description');
                        $getaways->url = Input::post('url');
                        $getaways->youtube_video = Input::post('youtube_video');
                        $getaways->country = Input::post('country');
                        $getaways->state = Input::post('state');
                        $getaways->city = Input::post('city');
                        $getaways->venue = Input::post('venue');
                        $getaways->start_date = Input::post('get_away_date');
                        $getaways->time_zone = Input::post('start_date');
                        $getaways->start_time = Input::post('start_time_hour');
                        $getaways->end_time = Input::post('end_time_hour');
                        $getaways->zip = Input::post('zip');
                        $getaways->get_away_end_date = Input::post('get_away_end_date');
                        $getaways->start_pm_am = Input::post('start_pm_am');
                        $getaways->end_pm_am = Input::post('end_pm_am');

                        if(isset($_POST['is_featured']))
                        {
                            $getaways->is_featured = 1;
                        } else{
                            $getaways->is_featured = 0;
                        }

                        $filepath = $file['saved_to'] . $file['saved_as'];

                        foreach (Model_Getaway::$thumbnails as $type => $dimensions) {
                            Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                        }

                        if($getaways->save()){
                            Session::set_flash('success', 'You have successfully saved the getaway.');
                            \Fuel\Core\Response::redirect('admin/getaways');
                        }

                        else
                        {
                            Session::set_flash('error', 'There is an error and the getaway is not saved. Please try again');
                        }

                    }
                }
            }
        }
        $view->set_global('page_css', 'admin/event_plan.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
        $this->template->content = $view;
    }
    
    public function action_manage_events() 
    {
    	if(! Input::post()) {
            Response::redirect('Admin');
        } else {
            $events = Model_Event::query()
                ->order_by('created_at', 'DESC')
                ->get();

            $view = View::forge('admin/event_plan');
            $view->events = $events;

            if ($_POST['action1'] == 'Edit')
            {
                if(!isset($_POST['eventids']))
                {
                    $identifier = 0;
                    Session::set_flash("error", "Please select at least one event to edit.");
                }
                else
                {
                    $edit_events = $_POST['eventids'];
                    foreach($edit_events as $key=> $val){
                        $editevents = Model_Event::query()
                            ->where("id", $key)
                            ->get_one();
                    }
                    $identifier = 1;
                    $view->editevents = $editevents;
                }
                $view->identifier = $identifier;
            }
            if ($_POST['action1'] == 'Delete')
            {
                if(!isset($_POST['eventids']))
                {
                    Session::set_flash("error", "Please select at least one event to delete.");
                }
                else
                {
                    $delete_events = $_POST['eventids'];
                    foreach($delete_events as $key=> $val){
                        DB::delete('events')->where('id',$key)->execute();
                    }
                }
                $identifier = 0;
                $view->identifier = $identifier;
            }

            $view->set_global('page_js', 'events/create.js');
            $view->set_global('page_css', 'admin/event_plan.css');
            $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
            $this->template->content = $view;
        }
   }

    public function action_edit_events()
    {
    	if(! Input::post()) {
            Response::redirect('Admin');
        } else {
            $events = Model_Event::query()
                ->order_by('created_at', 'DESC')
                ->get();

            $identifier = 0;
            $view = View::forge('admin/event_plan');
            $view->events = $events;
            $view->identifier = $identifier;

            $val = \Fuel\Core\Validation::forge();
            $val->add('title', 'Event Name')->add_rule('required');
            $val->add('long_description', 'Long Description')->add_rule('required');
            $val->add('short_description', 'Short Description')->add_rule('required');
            $val->add('url', 'URL')->add_rule('required');
            $val->add('organizers_details', 'Organizers Details')->add_rule('required');
            $val->add('state', 'State')->add_rule('required');
            $val->add('city', 'City')->add_rule('required');
            $val->add('venue', 'Address')->add_rule('required');
            $val->add('start_date', 'Time Zone')->add_rule('required');
            $val->add('zip', 'ZIP Code')->add_rule('required');
            $val->add('event_date', 'Event Start Date')->add_rule('required');
            $val->add('event_end_date', 'Event End Date')->add_rule('required');

            if( ! $val->run()){
                $view->set_global('errors',$val->error());
            }
            else {
                $event = Model_Event::find($_POST['idholder']);
                $upload_file = Input::file("photo");

                if ($upload_file["size"] > 0) {
                    $config = array(
                        'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR .'events',
                        'auto_rename' => false,
                        'overwrite' => true,
                        'randomize' => true,
                        'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                        'create_path' => true,
                        'path_chmod' => 0777,
                        'file_chmod' => 0777,
                    );

                    \Fuel\Core\Upload::process($config);

                    if (\Fuel\Core\Upload::is_valid()) {
                        \Fuel\Core\Upload::save();
                        $file = Upload::get_files(0);
                        $event->photo = $file['saved_as'];
                        $filepath = $file['saved_to'] . $file['saved_as'];

                        foreach (Model_Event::$thumbnails as $type => $dimensions) {
                            Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                        }
                    }
                }
                $event->title = Input::post('title');
                $event->organizers_details = Input::post('organizers_details');
                $event->long_description = Input::post('long_description');
                $event->short_description = Input::post('short_description');
                $event->url = Input::post('url');
                $event->youtube_video = Input::post('youtube_video');
                $event->state = Input::post('state');
                $event->city = Input::post('city');
                $event->venue = Input::post('venue');
                $event->start_date = Input::post('event_date');
                $event->time_zone = Input::post('start_date');
                $event->start_time = Input::post('start_time_hour');
                $event->end_time = Input::post('end_time_hour');
                $event->zip = Input::post('zip');
                $event->event_end_date = Input::post('event_end_date');
                $event->start_pm_am = Input::post('start_pm_am');
                $event->end_pm_am = Input::post('end_pm_am');
                $event->type = Input::post('type');
                if(isset($_POST['is_featured']))
                {
                    $event->is_featured = 1;
                } else{
                    $event->is_featured = 0;
                }

                if($event->save()){
                    Session::set_flash('success', 'You have successfully saved the event.');
                }
                else
                {
                    Session::set_flash('error', 'There is an error and the event is not saved. Please try again');
                }
            }
        }
        $view->set_global('page_js', 'events/create.js');
        $view->set_global('page_css', 'admin/event_plan.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
        $this->template->content = $view;
    }

    public function action_manage_packages()
    {
    	if(! Input::post())
    		Response::redirect('Admin');
    	
    	if(Input::post()) {
    	if ($_POST['action1'] == 'Edit')
    	{
    		if(!isset($_POST['eventids']))
    		{
    		
    			$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
    			$identifier = 0;
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			Session::set_flash("error", "Please select at least one date idea to edit.");
    		}
    		else
    		{
    			$edit_events = $_POST['eventids'];
    			foreach($edit_events as $key=> $val){
    				$editevents = Model_Datepackage::query()
    				->where("id", $key)
    				->get_one();
    					
    			}
    			$identifier = 1;
    			$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			$view->editevents = $editevents;
    			   
    		}
    	}
    	if ($_POST['action1'] == 'Delete')
    	{
    		
    		if(!isset($_POST['eventids']))
    		{
    		
    			$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
    			$identifier = 0;
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			Session::set_flash("error", "Please select at least one date idea to delete.");
    		}
    		else
    		{
    			$delete_events = $_POST['eventids'];
    			foreach($delete_events as $key=> $val){
    				DB::delete('datepackages')
    				->where('id',$key)
    				->execute();
    				 
    			}
    			$events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
    			$identifier = 0;
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			
    	}
      }
     $view->set_global('page_js', 'events/create.js');
     $view->set_global('page_css', 'admin/event_plan.css');
     $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
     $this->template->content = $view;
    }
    }
    
    public function action_edit_packages()
    {
        $events = Model_Datepackage::query()->order_by('created_at', 'DESC')->get();
        $identifier = 0;
        $view = View::forge('admin/dating_packages');
        $view->events = $events;
        $view->identifier = $identifier;

    	if(Input::post()) {
    	    $val = \Fuel\Core\Validation::forge();
    		$val->add('title', 'Venue Name')->add_rule('required');
    		$val->add('long_description', 'Dating Package Description')->add_rule('required');
    		$val->add('short_description', 'Venue Details')->add_rule('required');
    		$val->add('state', 'State')->add_rule('required');
    		$val->add('city', 'City')->add_rule('required');
    		$val->add('price', 'Price')->add_rule('required');
    		$val->add('event_date', 'Dating Package Start date')->add_rule('required');

    		if( ! $val->run()){
    			$view->set_global('page_css', 'admin/event_plan.css');
    			$this->template->title = 'Where We All Meet &raquo; Admin';
    			$view->set_global('page_js', 'events/create.js');
    			$view->set_global('errors',$val->error());
    			$this->template->content = $view;
    		}
    		if($val->run()){    			
    			$view = View::forge('admin/dating_packages');
    			$view->events = $events;
    			$view->identifier = $identifier;
    			$event = Model_Datepackage::find($_POST['idholder']);
    			$upload_file = Input::file("photo");
    
    			if ($upload_file["size"] > 0) {
    				$config = array(
    						'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR .'packages',
    						'auto_rename' => false,
    						'overwrite' => true,
    						'randomize' => true,
    						'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
    						'create_path' => true,
    						'path_chmod' => 0777,
    						'file_chmod' => 0777,
    				);
    
    				\Fuel\Core\Upload::process($config);
    
    				if (\Fuel\Core\Upload::is_valid()) {
    					\Fuel\Core\Upload::save();
    					$file = Upload::get_files(0);
    					$event->picture = $file['saved_as'];
    					$filepath = $file['saved_to'] . $file['saved_as'];
    						
    					foreach (Model_Datepackage::$thumbnails as $type => $dimensions) {
    						Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
    					}
    				}
    			}
    			    $event->title = Input::post('title');
    				$event->short_description = Input::post('short_description');
    				$event->long_description = Input::post('long_description');
                    $event->url = Input::post('url');
                    $event->youtube_video = Input::post('youtube_video');
                    $event->state = Input::post('state');
    				$event->city = Input::post('city');
    				$event->event_venue = Input::post('event_venue');
    				$event->event_date = Input::post('event_date');
    				$event->time_from = Input::post('time_from');
    				$event->time_to = Input::post('time_to');
    				$event->zip_code = Input::post('zip');
    				$event->price = Input::post('price');
    				$event->event_end_date = Input::post('event_end_date');
    				$event->start_pm_am = Input::post('start_pm_am');
    				$event->end_pm_am = Input::post('end_pm_am');
    			if(isset($_POST['is_featured']))
    			{
    				$event->is_featured = 1;
    			} else{
    				$event->is_featured = 0;
    			}

    			if($event->save()){
    				Session::set_flash('success', 'You have successfully saved the date idea.');
    			}
    			else
    			{
    				Session::set_flash('error', 'There is an error and the date idea is not saved. Please try again');
    			}
    		}
    	}
    	$view->set_global('page_js', 'events/create.js');
    	$view->set_global('page_css', 'admin/event_plan.css');
    	$this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
    	$this->template->content = $view;
    	 
    }

    public function action_manage_getaways()
    {
        if(! Input::post())
            Response::redirect('Admin');
        if(Input::post()) {
            if ($_POST['action1'] == 'Edit')
            {
                if(!isset($_POST['getawayids']))
                {
                    $getaways = Model_Getaway::query()->order_by('created_at', 'DESC')->get();
                    $identifier = 0;
                    $view = View::forge('admin/getaways');
                    $view->getaways = $getaways;
                    $view->identifier = $identifier;
                    Session::set_flash("error", "Please select at least one getaway to edit.");
                }
                else
                {
                    $edit_getaways = $_POST['getawayids'];
                    foreach($edit_getaways as $key=> $val){
                        $editgetaways = Model_Getaway::query()->where("id", $key)->get_one();
                    }
                    $identifier = 1;
                    $getaways = Model_Getaway::query()->order_by('created_at', 'DESC')->get();
                    $view = View::forge('admin/getaways');
                    $view->getaways = $getaways;
                    $view->identifier = $identifier;
                    $view->editgetaways = $editgetaways;
                }
            }
            if ($_POST['action1'] == 'Delete')
            {
                if(!isset($_POST['getawayids']))
                {
                    $getaways = Model_Getaway::query()->order_by('created_at', 'DESC')->get();
                    $identifier = 0;
                    $view = View::forge('admin/getaways');
                    $view->getaways = $getaways;
                    $view->identifier = $identifier;
                    Session::set_flash("error", "Please select at least one getaway to delete.");
                }
                else
                {
                    $delete_getaways = $_POST['getawayids'];
                    foreach($delete_getaways as $key=> $val){
                        DB::delete('getaways')->where('id',$key)->execute();
                    }
                    $getaways = Model_Getaway::query()->order_by('created_at', 'DESC')->get();
                    $identifier = 0;
                    $view = View::forge('admin/getaways');
                    $view->getaways = $getaways;
                    $view->identifier = $identifier;
                }
            }
            $view->countries = Model_Country::find('all', array('order_by' => 'name'));
            $view->set_global('page_css', 'admin/event_plan.css');
            $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
            $this->template->content = $view;
        }
    }

    public function action_edit_getaways()
    {
        $getaways = Model_Getaway::query()->order_by('created_at', 'DESC')->get();
        $identifier = 0;
        $view = View::forge('admin/getaways');
        $view->getaways = $getaways;
        $view->identifier = $identifier;
        $view->countries = Model_Country::find('all', array('order_by' => 'name'));

//        if(! Input::post())
//            Response::redirect('Admin');
        if(Input::post()) {

            $val = \Fuel\Core\Validation::forge();
            $val->add('title', 'Title')->add_rule('required');
            $val->add('long_description', 'Long Description')->add_rule('required');
            $val->add('short_description', 'Short Description')->add_rule('required');
            $val->add('organizers_details', 'Organizers Details')->add_rule('required');
            $val->add('country', 'Country')->add_rule('required');

            if( ! $val->run()){
                $view->set_global('page_css', 'admin/event_plan.css');
                $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
                $view->set_global('errors',$val->error());
                $this->template->content = $view;
            }
            if($val->run()){
                $getaways = Model_Getaway::find($_POST['idholder']);
                $upload_file = Input::file("photo");

                if ($upload_file["size"] > 0) {
                    $config = array(
                        'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR .'getaways',
                        'auto_rename' => false,
                        'overwrite' => true,
                        'randomize' => true,
                        'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                        'create_path' => true,
                        'path_chmod' => 0777,
                        'file_chmod' => 0777,
                    );

                    \Fuel\Core\Upload::process($config);

                    if (\Fuel\Core\Upload::is_valid()) {
                        \Fuel\Core\Upload::save();
                        $file = Upload::get_files(0);
                        $getaways->photo = $file['saved_as'];
                        $filepath = $file['saved_to'] . $file['saved_as'];

                        foreach (Model_Getaway::$thumbnails as $type => $dimensions) {
                            Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                        }
                    }
                }
                $getaways->title = Input::post('title');
                $getaways->organizers_details = Input::post('organizers_details');
                $getaways->long_description = Input::post('long_description');
                $getaways->short_description = Input::post('short_description');
                $getaways->url = Input::post('url');
                $getaways->youtube_video = Input::post('youtube_video');
                $getaways->country = Input::post('country');
                $getaways->state = Input::post('state');
                $getaways->city = Input::post('city');
                $getaways->venue = Input::post('venue');
                $getaways->start_date = Input::post('get_away_date');
                $getaways->time_zone = Input::post('start_date');
                $getaways->start_time = Input::post('start_time_hour');
                $getaways->end_time = Input::post('end_time_hour');
                $getaways->zip = Input::post('zip');
                $getaways->get_away_end_date = Input::post('get_away_end_date');
                $getaways->start_pm_am = Input::post('start_pm_am');
                $getaways->end_pm_am = Input::post('end_pm_am');
                if(isset($_POST['is_featured']))
                {
                    $getaways->is_featured = 1;
                } else{
                    $getaways->is_featured = 0;
                }

                if($getaways->save()){
                    Session::set_flash('success', 'You have successfully saved the getaway.');
                    \Fuel\Core\Response::redirect('admin/getaways');
                }
                else
                {
                    Session::set_flash('error', 'There is an error and the getaway is not saved. Please try again');
                }
            }
        }

        $view->set_global('page_css', 'admin/event_plan.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Admin';
        $this->template->content = $view;
    }

    public function action_bannerAds() {
        $view = View::forge('admin/banner_ads');

        $view->current_user = $this->current_user;

        if (Input::post('btnPublishBanner')) {
            $post = Input::post();

            $post['btnPublishBanner'] = null;

            $upload_file = Input::file("banner_image");

            if ($upload_file["size"] > 0) {
                $config = array(
                    'path' => DOCROOT . "uploads/banner_image",
                    'auto_rename' => false,
                    'overwrite' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );
                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);

                    // Update banner image information
                    $post["image"] = $file['saved_as'];
                    Model_Banner::forge($post)->save();

                    Session::set_flash("success", "Banner successfully created");
                }
                // and process any errors
                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['message']);
                }
            } else {
                Session::set_flash("error", "Banner should be selected");
            }
        } elseif(Input::post('btnDeleteBanner')) {
            $post = Input::post();
            $post['btnDeleteBanner'] = null;

            if (count(Input::post('image_items')) > 0) {
                $images = Input::post('image_items');
                foreach ($images as $image_id) {
                    $objBanner = Model_Banner::find($image_id);
                    if ($objBanner) {
                        $image_directory = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . "banner_image" . DIRECTORY_SEPARATOR;
                        try {
                            $file = File::get($image_directory . $objBanner->image);
                            $file->delete();
                        } catch (Exception $e) {

                        }
                        $objBanner->delete();
                    }
                }
                Session::set_flash("success", "Banner ADs deleted successfully !");
            } else {
                Session::set_flash("error", "Select at least one Banner AD to delete !");
            }
        }

        $view->bannerAds = Model_Banner::find('all');

        $view->set_global('page_css', 'admin/banner_ads.css');
        $view->set_global('page_js', 'admin/banner_ads.js');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Banner ADs';
        $this->template->content = $view;
    }

    public function action_manage_banners() {
        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $banner_id = Input::post("banner_id");
        $banner = Model_Banner::find($banner_id);

        if ($banner) {
            $banner->delete();
            $response_message = "Banner deleted successfully.";

            $response->body(json_encode(array(
                'status' => true,
                'message' => $response_message,
            )));
        }

        return $response;
    }
}