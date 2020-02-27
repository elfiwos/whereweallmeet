<div id="compose-popup-container" onclick="check(event)" >
    <a  id="close"><?php echo Asset::img("close1.png"); ?></a>

    <div id= "compose-popup">
        <button class="compose"> <i class="compose-icon"></i>Compose</button>
        <form action='<?php echo Uri::create('message/dashboard_compose');?>' method="post">
            <div class="event-list">
                <input type="hidden" name="from_member_id" value="">
                <div class="message-entry">
                    <select name="to_member_id"  onchange="document.getElementById('to_member_id').value=this.options[this.selectedIndex].text; document.getElementById('idValue').value=this.options[this.selectedIndex].value;" >
                        <option > </option>
                        <?php if($current_profile->member_type_id == 1 ):   ?>
                            <!--                            <option > All </option>-->
                            <?php $friend_list = Model_Friendship::get_friends($current_profile->id); ?>
                            <?php $objInviter = Model_Invitedmember::find('first', array("where" => array(array("member_id", $current_profile->id)))) ?>
                            <?php if (($friend_list !== false)):
                                foreach ($friend_list as $friend): ?>
                                    <?php if($objInviter && $objInviter->inviter_id == $friend->id): ?>
                                        <option> <?php echo Model_Profile::get_username($friend->user_id); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; endif; ?>
                        <?php elseif($current_profile->member_type_id!=3 ):   ?>
                            <option > All </option>
                            <?php if (($friend_list !== false)):
                                foreach ($friend_list as $friend):
                            ?>
                                    <option> <?php echo Model_Profile::get_username($friend->user_id); ?></option>
                            <?php endforeach;
                            endif; ?>
                        <?php else: ?>
                            <option style="font-weight:bold">All Clients</option>
                            <?php foreach($profiles as $profile): ?>
                                <?php if($current_profile->id!=$profile->id): ?>
                                    <option>
                                        <?php echo Model_Profile::get_username($profile->user_id)."<br>"; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </select>
                </div>
                <div id='username_availability_result'></div>
                <div class="message-entry">
                    <input type="text" name="subject" placeholder=" Subject:">
                </div>
                <div class="message-entry">
                    <textarea name="body" placeholder=" Your messaage will be typed here..."></textarea>

                    <button type="submit" id="check_username_availability" class="compose" >Send</button>
                </div>
            </div>
        </form>
    </div>

</div>



<div id="notification-container" class="alert alert-success rounded-corners">
    <i class="close-dialog fa fa-times-circle-o close"></i>
    <h4></h4>
    <p></p>
</div>

<div id="content" class="clearfix">

    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
			    <div id="profile-pic"><?php echo Html::anchor(Uri::create('profile/dashboard'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
                <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/dashboard'), $current_user->username, array("id" => "profile-link")); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
            </div>
        </div>
        <?php echo View::forge("profile/partials/profile_nav"); ?>
        <div class="border-icon1"></div>
        <div class="border-icon2"></div>
        <div class="border-icon3"></div>
    </aside>
    <div id="middle">

    <div id="post-section">

        <section class="latest-matches"> 
            <div class="header-section">
                <p class="header-text pull-left">Suggested Matches</p>
                <p class="pull-right">
                    <?php echo Html::anchor("/browse", "View more matches"); ?>
                </p>
                <div class="clearfix"></div>
            </div>
            <div class="content match-slider">
                <?php echo View::forge("profile/partials/latest_member_thumb", array("latest_members" => $latest_members)); ?>
            </div>
        </section>
       
        <section class="user-status">
            <div class="header-section">
                <p class="header-text pull-left">What's Going On?</p>
                <div class="clearfix"></div>
            </div>
            <div class="content">


              <?php if (isset($notifications)):
                    $notification_type = null;

                    foreach ($notifications as $notification):
                        if ($notification_type !== $notification['category']):

                            $notification_type = $notification['category'];
                            switch ($notification_type) {
                                case (Model_Notification::EVENT_NOTIFICATIONS):
                                    $notification_type_name = "Events";
                                    break;

                                default:
                                    $notification_type_name = "Notifications";
                                    break;
                            }
                            ?>

                            <h3><?php echo $notification_type_name ?></h3>

                        <?php endif;
                        $right_button_text = "Send a Message";
                        $section_url = "";
                        switch ($notification['object_type_id']) {
                            case (Model_Notification::EVENT_RSVP_SENT):
                                $notification_link = 'event/view/' . Model_Event::get_slug($notification['object_id']);
                                $notification_object = Model_Event::get_title($notification['object_id']);
                                $event = Model_Event::get_start_date($notification['object_id']);
                                $notification_verb = $event['start_date'];
                                $right_button_text = "View Event";
                                $section_url = uri::base(false) . "event";
                                break;
                            case (Model_Notification::EVENT_INVITE_SENT):
                                $notification_link = 'event/view/' . Model_Event::get_slug($notification['object_id']);
                                $invite_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = $invite_sender ? Model_Profile::get_username($invite_sender->user_id): "";
                                $event = Model_Event::get_start_date($notification['object_id']);
                                $notification_verb = ' sent you an Event ' . Model_Event::get_title($notification['object_id']) . ' invite';
                                $right_button_text = "View Event Invite";
                                $section_url = uri::base(false) . "profile/my_invitations";
                                break;
                            case (Model_Notification::MESSAGE_SENT):
                                $notification_link = 'message/index/';
                                $message_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($message_sender->user_id);
                                $notification_verb = ' sent you a <a id="message_sent" style="">message!<i ></i> </a>';
                                $right_button_text = "View Message";
                                $section_url = uri::base(false) . "message";
                                break;
                            case (Model_Notification::FRIEND_REQUEST_SENT):
                                $notification_link = 'profile/friend_request';
                                $friend_request_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($friend_request_sender->user_id);
                                $notification_verb = ' sent you a <a id="message_sent" style="">friend request!<i ></i> </a>';
                                $right_button_text = "View Friend Request";
                                $section_url = uri::base(false) . "profile/friend_request";
                                break;
                            case (Model_Notification::HELLO_SENT):
                                $hello = Model_Hello::find($notification['object_id']);
                                $hello_receiver = Model_Profile::find($hello->to_member_id);
                                $notification_link = \Fuel\Core\Uri::create('profile/public_profile/' . $hello_receiver->id);
                                $notification_object = 'You';
                                $notification_verb = ' sent a hello to ' . Model_Profile::get_username($hello_receiver->user_id) . '!';
                                break;

                            case (Model_Notification::HELLO_RECEIVED):
                                $notification_link = \Fuel\Core\Uri::create('profile/my_hellos');
                                $hello_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($hello_sender->user_id);
                                $notification_verb = ' sent you a <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> hello!</a>';
                                break;
                            case (Model_Notification::SAVED_AS_FAVORITE):
                                $favorite = Model_Favorite::find($notification['object_id']);
                                $favorite_sender = Model_Profile::find($favorite->member_id);
                                $notification_link = \Fuel\Core\Uri::create('profile/public_profile/' . $favorite_sender->id);
                                $notification_object = Model_Profile::get_username($favorite_sender->user_id);
                                $notification_verb = ' saved you as <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> favorite!</a>';
                                break;
                            case (Model_Notification::CHAT_REQUEST_SENT):
                                $notification_link = \Fuel\Core\Uri::create('profile/public_profile/' . $notification['actor_id']);
                                $chat_request_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($chat_request_sender->user_id);
                                $notification_verb = ' sent you a <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;">Chat Request!</a>';
                                break;
                            case (Model_Notification::DATING_PACKAGE_INVITATION_SENT):
                                $notification_link = 'datingpackage/refer/' . $notification['object_id'];
                                $invite_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($invite_sender->user_id);
                                $notification_verb = ' has invited you to a <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> dating package!</a>';
                                break;

                            case (Model_Notification::DATING_AGENT_INVITATION_SENT):
                                $notification_link = 'agent/view/' . $notification['object_id'];
                                $invite_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($invite_sender->user_id);
                                $notification_verb = ' has invited you to a <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;">dating agent!</a>';
                                break;

                            case (Model_Notification::REFERRED_A_FRIEND):
                                $notification_link = 'profile/public_profile/' . $notification['object_id'];
                                $invite_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($invite_sender->user_id);
                                $notification_verb = '<a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> has referred you a friend!</a>';
                                $right_button_text = "View Referral";
                                $section_url = uri::base(false) . "profile/my_referrals";
                                break;

                            case (Model_Notification::NEW_MATCH_FOUND):
                                $notification_link = 'profile/dashboard';
                                $notification_object = 'You';
                                $notification_verb = ' <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> have new matches!</a>';
                                break;
                            case (Model_Notification::POST_SENT):
                                $notification_link = 'profile/dashboard';
                                $post_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($post_sender->user_id);
                                $notification_verb = ' sent you a <a id="message_sent" style="">post!<i ></i> </a>';
                                break;
                            case (Model_Notification::GETAWAY_RSVP_SENT):
                                $notification_link = 'profile/dashboard';
                                $post_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($post_sender->user_id);
                                $notification_verb = ' sent you a <a id="message_sent" style="">getaway invitation!<i ></i> </a>';
                                break;
                            case (Model_Notification::DATE_IDEA_SENT):
                                $notification_link = 'profile/dashboard';

                                $post_sender = Model_Profile::find($notification['actor_id']);
                                $message = DB::select('message')
                                            ->from('refereddateideas')
                                            ->where('id',$notification['object_id'])
                                            ->execute();
                                $notification_object_type_id = $notification['object_type_id'];
                                $message = $message[0]['message'];
                                $notification_object = Model_Profile::get_username($post_sender->user_id);
                                $notification_verb = ' sent you a <a id="message_sent" style="">a new date idea!<i ></i> </a>';
                                break;

                            default:
                                break;
                        }
                        ?>

                        <div class="activity">
                            <div class="user-info pull-left">
                                <div class="pull-left avatar">
                                    <?php $activity_profile = Model_Profile::find($notification['actor_id']); ?>
                                    <?php echo Html::anchor(Uri::create('profile/public_profile/'. $notification['actor_id']), Html::img(Model_Profile::get_picture($activity_profile->picture, $activity_profile->user_id, "activity-avatar"))); ?>
                                </div>
                                <div class="pull-left what-is-going-on-left">

                                    <p class="activity-user"><?php echo $notification_object; ?> <span class="light-gray"><?php echo $notification_verb ?></span></p>
                                    <p class="activity-date light-gray"><?php echo date('Y-m-d h:i:s a', $notification['created_at']); ?></p>
                                     <?php if(isset($notification_object_type_id) ){ ?>
                                      <p><?php echo $message;?></p>
                                      <?php } ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="activity-vertical-separator pull-left"></div>
                            <div class="pull-right notification-message-container">
                                <?php if($right_button_text == "Send a Message"): ?>
                                    <a class="notification-send-message" href="#">
                                        <?php echo Asset::img("yes.jpg") ?>
                                        <span> <?php echo $right_button_text; ?></span>
                                    </a>
                                <?php else: ?>
                                    <a class="notification-section-link" href="<?php echo $section_url ?>">
                                        <?php echo Asset::img("yes.jpg") ?>
                                        <span> <?php echo $right_button_text; ?></span>
                                    </a>
                                <?php endif ?>
                            </div>
                            <?php echo Html::anchor("#", "X", array("class" => "delete-notification", "data-action" => Uri::create('notification/delete_notification'), "data-notification-id" => $notification["id"])); ?>

                            <div class="clearfix"></div>
                        </div>

                        <hr id="<?php echo "separator-" . $notification["id"] ?>" class="activity-horizontal-separator clearfix"/>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>You have no notification.</p>
                <?php endif; ?>
                <div>

                </div>


                <!-- <h3>Posts</h3>

                <?php if (isset($posts)):

                    foreach ($posts as $post){
                        ?>
                        <div class="activity">
                            <div class="user-info pull-left">
                                <div class="pull-left avatar">
                                    <?php $activity_profile = Model_Profile::find($post['posted_by']); ?>
                                    <?php echo Html::anchor(Uri::create('profile/public_profile/'. $post['posted_by']), Html::img(Model_Profile::get_picture($activity_profile->picture, $activity_profile->user_id, "activity-avatar"))); ?>
                                </div>
                                <div class="pull-left">
                                    <p class="activity-user"> <span class="light-gray"><?php echo $post['post_content'] ?></span></p>
                                    <p class="activity-date light-gray"><?php echo date('Y-m-d h:ia', $post['created_at']); ?></p>
                                     <div class="like" >
                                    <button>
                                   <a url="<?php echo Uri::create('post/likes/')?>" data-post-id="<?php echo $post['id']; ?>" data-liker-id="<?php echo $current_profile->id; ?>">Like</a>
                                    </button>
                                    </div>
                                    <button>
                                     <a href="post/comment" >Comment</a>
                                     </button>
                                     </p>
                                     <div id="count-likes">
                                    <p> </p> </div>
                                    <input type='text' placeholder="Write a comment" />
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="activity-vertical-separator pull-left"></div>

                            <div class="chat-request pull-left">

                            </div>
                            <div class="pull-right">

                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <hr class="activity-horizontal-separator clearfix"/>
                  <?php

                        
                    }
                     endif; 

                 ?> -->

            </div>

        </section>
    </div>

     <div id="upload-section">
      <div class="activity-content">
       <div class="upload-image">
       <section>
        <div class="content clearfix">
        <?php echo Form::open(array("action" => "profile/upload_photo_dashboard", "enctype" => "multipart/form-data", "class" => "clearfix")) ?>
                    <div id="upper-content">
                        <p>Upload Photo</p>
                        <p id="profile-photo-select">
                            <input hidden="true" type="file" id="profile-picture" name="picture" size="1"/>
                            <a id="profile-upload-button" class="upload-button">Browse</a>
                            <span>No file selected</span>
                        </p>
                    </div>
                    <div id="lower-content">
                        <p>Description</p>
                        <textarea name="description" placeholder="Title of Photo Caption..."></textarea>
                    </div>
                    <div id="upload-button">
                        <input class="submit_input" type="submit" value="Upload" />
                    </div>
             <?php echo Form::close(); ?>
        </div>
        </section>
         </div>
    </div>
     </div>
    </div> <!-- end of middle -->

          <div class="latest-events date-ideas">
            <div class="section-title">
                <h3>Latest Date Ideas</h3>
                <p> Break the ice with an unforgotable first date!</p>
                <div class="clearfix"></div>
            </div>
            <div id="date-idea-list-container" class="event-list">
                <?php if (isset($active_datingPackages) and $active_datingPackages !== false): ?>
                    <?php foreach ($active_datingPackages as $packages): ?>
                        <div class="event">
                            <div class="image-holder">
                                <a href="<?php echo \Fuel\Core\Uri::create('package/view/' . $packages['id']) ?>">
                                    <?php if (empty($packages['picture'])): ?>
                                        <?php echo Asset::img('temp/event_thumb.jpg'); ?>
                                    <?php else: ?>
                                        <img width="301" height="231" src="<?php echo \Fuel\Core\Uri::base() . 'uploads/packages/event_list_' . $packages['picture'] ?>" />
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="event-caption-wrapper">
                                <a href="<?php echo \Fuel\Core\Uri::create('package/view/' . $packages['id']) ?>"><i class="event-forward"></i></a>
                                <p title="<?php echo $packages['title'];  ?>" class="event-caption-top"><?php echo \Fuel\Core\Str::truncate($packages['title'], 30) ?></p>
                                <p class="event-caption-bottom"><?php echo \Fuel\Core\Str::truncate($packages['start_date'] . "-" . $packages['end_date'], 30)  ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="clearfix"></div>
                <?php else: ?>
                    <div class="event-list clearfix" id="no-event">
                        No date idea found from your location.
                    </div>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
            <div class="btn-holder"><a class="more-date-ideas" data-count="<?php echo count($active_datingPackages); ?>" href="#">More Date Ideas</a></div>

              <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
            <div class="border-circle border-circle-3"><?php echo Asset::img('line_end.png'); ?></div>
        </div> <!-- end of latest ideas -->

        <div class="latest-events">
            <div class="section-title">
                <h3>Latest Events</h3>
                <p>Experience a night out with friends!</p>
                <div class="border-icon4"></div>
                <div class="clearfix"></div>
            </div>
            <?php if(isset($active_events)): ?>
                <div id="event-list-container" class="event-list">
                    <?php foreach($active_events as $active_event): ?>
                        <div class="event">
                            <div class="image-holder">
                                <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $active_event['slug']) ?>">
                                    <?php if(empty($active_event['photo'])): ?>
                                        <img src="temp/event_thumb.jpg" />
                                    <?php else: ?>
                                        <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_featured_'.$active_event['photo'] ?>" />
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="event-caption-wrapper">
                                <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $active_event['slug']) ?>"><i class="event-forward"></i></a>
                                <p title="<?php echo $active_event['title'];  ?>" class="event-caption-top"><?php echo Str::truncate($active_event['title'], 30); ?></p>
                                <p class="event-caption-bottom"><?php echo $active_event['start_date'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="clearfix"></div>
                </div>
                <div class="btn-holder"><a class="more-events" data-count="<?php echo count($active_events); ?>" href="#">More Events</a></div>
            <?php else: ?>
                <p class="nodata-message"> No Featured Event! </p>
            <?php endif; ?>
        </div> <!-- end of events -->

</div>

<!--Suggested matches popup-->
<?php if($latest_members): ?>
<div id="suggested-matches-dialog" class="dialog">
    <i id="close-suggested-matches" class="close-dialog fa fa-times-circle-o"></i>

    <div class="dialog-content">
        <div id="profile-pictures-container" class="clearfix">
            <div id="left-arrow">
                <a href="#" data-direction="left"><?php echo Asset::img("white_left_scroller.png"); ?></a>
            </div>
            <div id="picture-container">
                <div id="photos-inner" data-left="0" class="clearfix">
                    <?php foreach ($latest_members as $member): ?>
                        <?php if ($member['group_id'] != 5 && !Model_Profile::is_deleted_account($member['id']) && !Model_Friendship::are_friends($current_profile->id, $member['id']) && !Model_Dislike::is_member_disliked($current_profile->id, $member['id'])): ?>
                            <a href="<?php echo Uri::create('profile/public_profile/' . $member['id']) ?>">
                                <?php echo Html::img(Model_Profile::get_picture($member["picture"],$member["user_id"], "referred_friend"), array("id" => "profile-image-".$member['id'])) ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="right-arrow">
                <a href="#" data-direction="right"><?php echo Asset::img("white_right_scroller.png"); ?></a>
            </div>
        </div>
        <?php $order_number = 1; ?>
        <?php foreach ($latest_members as $member): ?>
            <?php if ($member['group_id'] != 5 && !Model_Profile::is_deleted_account($member['id']) && !Model_Friendship::are_friends($current_profile->id, $member['id']) && !Model_Dislike::is_member_disliked($current_profile->id, $member['id'])): ?>
                <?php $active = $order_number ==1 ? "active" : ""; ?>
                <div id="<?php echo "profile-description-".$order_number; ?>" data-profile-id="<?php echo $member["id"] ?>" class="profile-description <?php echo $active; ?>">
                    <span class="username"><?php echo $member["username"]; ?></span><span>|</span>
                    <span><?php echo isset($member["birth_date"]) ? Model_Profile::get_age($member["birth_date"]).' years old' : "" ?></span><span>|</span>
                    <span><?php  echo $member["city"] == "" ? $member["state"] : $member["city"] . ", ". $member["state"]; ?></span>
                </div>
                <?php $order_number++; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="clearfix"></div>

        <form id="suggested-matches-reply">
            <a class="suggested-matches-reply" id="accept" href="<?php echo \Fuel\Core\Uri::create('profile/accept_suggested_match') ?>"><?php echo Asset::img("like.png");?><span>Like This Match</span></a>
            <a class="suggested-matches-reply"  id="reject" href="<?php echo \Fuel\Core\Uri::create('profile/reject_suggested_match') ?>"><?php echo Asset::img("dislike.png");?><span>Deny This Match</span></a>
        </form>
    </div>
</div>
<?php endif; ?>




