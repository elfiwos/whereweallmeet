
<div id="notification-container" class="alert alert-success rounded-corners">
    <i class="close-dialog fa fa-times-circle-o close"></i>
    <h4></h4>
    <p></p>
</div>
<?php if($profile->visible_for_friends == 1 && !(Model_Friendship::are_friends($profile->id, $current_profile->id ))){?>
<?php echo "This profile is visible only for Friends"?>
<?php }else{ ?>
<div class="main-container profile-row">
    <div class="inner-wrapper">
        <div class="profile-menu">
            <div class="profile-menu-inner">
                <div class="profile-avatar-wrapper">
                <div class="camera-image"></div>
                    <?php echo Html::anchor(Model_Profile::get_picture($profile->picture, $profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "profile_medium")), array("rel" => "lightbox-photos", "title" => "Profile Picture" )); ?>

                </div>
                <div class="member-date">
                    <p><span>Member Since:</span><?php echo date('M,Y', $profile->created_at) ?></p>
                </div>
                <div class="profile-sub-menu">
                    <?php if($current_profile->member_type_id == 1): ?>
                        <?php echo Html::anchor("#", '<i class="send-msg"></i>Send Message', array("id" => "send-message","class"=>"menu-btn","data-dialog" => "upgrade-message-dialog",)); ?>
                        <?php echo Html::anchor("#", '<i class="chat"></i>Chat With Me', array("id" => "send-chat","class"=>"menu-btn menu-btn-chat", "data-dialog" => "upgrade-chat-dialog")); ?>
                    <?php else: ?>
                        <?php if($profile->member_type_id == 3 && $profile->id <> $current_profile->id){?>
                            <?php if($current_profile->member_type_id == 2): ?>
                                <?php echo Html::anchor("agent/upgrade_account/".$profile->id."/", '<i class="book-me"></i>Book Me', array("class" => "menu-btn menu-btn-book") ); ?>
                            <?php else: ?>
                                <?php echo Html::anchor("#", '<i class="book-me"></i>Book Me', array("class" => "send-book-me menu-btn menu-btn-book", "data-confirmation-dialog" => "book-me-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $profile->id, "data-username" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list") )); ?>
                            <?php endif; ?>
                        <?php } ?>
                        <?php echo Html::anchor("#", '<i class="send-msg"></i>Send Message', array("class" => "send-message-icon menu-btn", "data-confirmation-dialog" => "message-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $profile->id, "data-username" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list") )); ?>
                        <?php echo Html::anchor("#", '<i class="chat"></i>Chat With Me', array("class" => "send-chat-request menu-btn menu-btn-chat", "data-confirmation-dialog" => "chat-confirmation-dialog", "data-username" => Model_Profile::get_username($profile->user_id), "data-full-name" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list"))); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="border-icon1"></div>
            <div class="border-icon2"></div>
            <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        </div>

        <div class="profile-top">
            <div class="profile-top-inner">
                <div class="pull-left">
                    <p class="profile-name" >
                        <?php echo Html::anchor(Uri::create('profile/public_profile/'.$profile->id), ucfirst(Model_Profile::get_username($profile->user_id)), array("id" => "profile-link")); ?>
                        <span class="gray online-indicator">
                            <?php if($profile->is_logged_in): ?>
                                <i class="green-circle"></i><?php echo Model_Profile::get_username($profile->user_id); ?> is online
                            <?php else: ?>
                                <i class="red-circle"></i><?php echo Model_Profile::get_username($profile->user_id); ?> is offline
                            <?php endif; ?>
                        </span>
                    </p>
                    <p class="profile-info-age" >
                        <?php echo ($profile->birth_date == null ? '' : Model_Profile::get_age($profile->birth_date).' Years Old, '). ($gender == null ? '' : $gender->name) ?>
                    </p>
                    <p class="profile-info-location" >
                        <?php  echo $profile->city == "" ? $profile->state : $profile->city . ", ". $profile->state; ?>
                    </p>
                </div>
                <?php if (!Model_Friendship::request_exchanged($current_profile->id, $profile->id) AND $current_profile->id != $profile->id){  ?>
                    <div class="pull-right">
                        <p class="friend-status-display">
                            <?php if($current_profile->member_type_id == 1): ?>
                                <?php echo Html::anchor("#", "Send Friend Request", array("id" => "request-as-friend-bottom","class"=>"request-as-friend-upgrade","data-dialog" => "upgrade-friendship-dialog",)); ?>
                            <?php else: ?>
                                <?php echo Html::anchor("#", "Send Friend Request", array("id" => "request-as-friend-bottom", "data-dialog" => "send-invite-dialog")); ?>
                            <?php endif; ?>

                        </p>
                    </div>
               <?php }else{?>
                <div class="pull-right">
                    <p class="friend-status-display"><i class="friends"></i>You are Friends with this user<i class="down-arrow"></i></p>
                </div>
                <?php } ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php if(isset($section) && $section == "browse"): ?>
            <div id="back-to-search">
                <?php echo \Fuel\Core\Html::anchor('browse/browse_members', 'Back to Search',array('class' => '')) ?>
            </div>
        <?php endif; ?>
        <?php if($profile->member_type_id == 2 || $profile->member_type_id == 3 || $profile->member_type_id == 1 || $profile->member_type_id == 4){ ?>
            
            <div class="profile-more">
                <h3 class="title"><em>A little more about myself</em></h3>
                <div id="about-myself" class="text-wrapper">
                    <div id="about-me-full-content" class="text">
                        <p><?php echo $profile->about_me  ?></p>
                    </div>
                    <!-- <div id="looking-for-content" class="more-text">
                        <p class="section-title">What I'm looking for</p>
                        <p>
                        Ages From: <strong> <?php echo $profile->ages_from ?> </strong>
                         To: <strong><?php echo $profile->ages_to ?></strong>
                        </p>
                        <p>
                        Education: <strong> <?php if(isset($seeking_education)) echo $seeking_education['name'] ?></strong>
                        </p>                        
                        <p>
                        Ethnicity: <strong> <?php if(isset($seeking_ethnicity)) echo $seeking_ethnicity['name'] ?></strong>
                        </p>                                              
                        <p>
                        Faith: <strong> <?php if(isset($seeking_religion)) echo $seeking_religion['name'] ?></strong>
                        </p>                                            
                        <p>
                        Children: <strong> <?php if(isset($seeking_children)) echo $seeking_children['name'] ?></strong>
                        </p>   
                        <?php

                        $feetAndInches = explode('**', $seeking_height);
                        $height_array = explode("*", $feetAndInches[0]);
                        if(isset($height_array[0]))
                            $feet = $height_array[0];
                        if(isset($height_array[1]))
                            $inches = $height_array[1];
                        ?>                                          
                        <p>
                        Height: <strong> 
                        <?php if(isset($feet))echo $feet . "'" ?>
                        <?php if(isset($inches)) echo $inches . "''"?>
                         </strong>
                        </p>                                           
                        <p>
                        Politics: <strong> <?php if(isset($seeking_politics))
                         echo $seeking_politics['name'] ?>
                         </strong>
                        </p>                                         
                        <p>
                        Exercise: <strong> <?php if(isset($seeking_exercise))
                         echo $seeking_exercise['name'] ?>
                         </strong>
                        </p>                                       
                        <p>
                        Drink: <strong> <?php if(isset($seeking_drink))
                         echo $seeking_drink['name'] ?>
                         </strong>
                        </p>                                      
                        <p>
                        Smoke: <strong> <?php if(isset($seeking_smoke))
                         echo $seeking_smoke['name'] ?>
                         </strong>
                        </p>  
                    </div> -->
                    <!-- <div id="life-so-far-content" class="more-text">
                        <p class="section-title">Awesome Places I've visited</p>
                        <p><?php echo $profile->places_visted ?></p>
                    </div>
                    <div id="like-doing-content" class="more-text">
                        <p class="section-title">What I like to do</p>
                        <p><?php echo $profile->like_doing ?></p>
                    </div>
                    <div id="like-doing-content" class="more-text">
                        <p class="section-title">What I Plan for Future</p>
                        <p><?php echo $profile->plan_for_future ?></p>
                    </div> -->
                </div>
            </div>

            <div class="profile-more full-view">
                <h3 class="title"><em>Awesome Places I've visited</em></h3>
                <div id="about-myself" class="text-wrapper">
                    <div id="about-me-full-content" class="text">
                        <p><?php echo $profile->places_visted ?></p>
                    </div>
                </div>
            </div>


            <div class="profile-more full-view">
                <h3 class="title"><em>What I like to do</em></h3>
                <div id="about-myself" class="text-wrapper">
                    <div id="about-me-full-content" class="text">
                        <p><?php echo $profile->like_doing ?></p>
                    </div>
                </div>
            </div>

            <div class="profile-more full-view">
                <h3 class="title"><em>My plans for the future</em></h3>
                <div id="about-myself" class="text-wrapper">
                    <div id="about-me-full-content" class="text">
                        <p><?php echo $profile->plan_for_future ?></p>
                    </div>
                </div>
            </div>
            <div class="profile-more">
                <a href="#" class="read-more">View Full Bio ></a>
            </div>

        <?php }else{ ?>
            <div class="profile-more">
                <h3 class="title">Hello</h3>
                <div class="text-wrapper">
                    <p class="text">My name is <?php echo $profile->first_name.' '.$profile->last_name; ?> I am a dating agnet.</p>
                </div>

            </div>
            <div class="profile-more full-view">
                <h3 class="title">A little more about myself</h3>
                <div id="about-myself" class="text-wrapper">
                    <div id="about-me-full-content" class="text">
                        <p class="section-title">A little more about myself...</p>
                        <p><?php echo $profile->about_me  ?></p>
                    </div>
                    <div id="looking-for-content" class="more-text">
                        <p class="section-title">What I'm looking for</p>
                        <p><?php echo $profile->looking_for ?></p>
                    </div>
                    <div id="life-so-far-content" class="more-text">
                        <p class="section-title">My life so far</p>
                        <p><?php echo $profile->life_so_far ?></p>
                    </div>
                    <div id="like-doing-content" class="more-text">
                        <p class="section-title">What I like to do</p>
                        <p><?php echo $profile->like_doing ?></p>
                    </div>
                    <a href="#" class="read-more">Read More ></a>
                </div>
            </div>
            <div class="profile-more full-view">
                <h3 class="title">My goals for you</h3>
                <div class="text-wrapper">
                    <p class="text"><?php echo $profile->about_me ?></p>
                <a class="read-more" href="#">Read More</a>
                </div>
                <?php  if($current_profile->member_type_id == 2):  ?>
                    <div class="btn-wrap gold-bg">
                            <?php echo Html::anchor(Uri::create("agent/upgrade_account/".$profile->id.'/'), 'GET STARTED TODAY IT ONLY TAKES A MINUTE');?>
                    </div>
                <?php endif; ?>
            </div>
        <?php } ?>
        <div class="clearfix"></div>
       
        <?php if($profile->member_type_id == 2 || $profile->member_type_id == 3 || $profile->member_type_id == 1 || $profile->member_type_id == 4){ ?>
        <div class="profile-events">
            <h3 class="section-title">Events I Would Like To Attend</h3>
            <?php if(isset($featured_events) && count($featured_events)>0): ?>
                <div class="event-list">
                    <?php foreach($featured_events as $featured_event): ?>
                        <div class="event">
                            <div class="image-holder">
                                <div class="image-plus-sign">
                                    <?php if($current_profile->member_type_id == 1): ?>
                                        <?php echo Html::anchor("#", Asset::img("event-plus.jpg"), array("id" => "send-event-invite","class"=>"","data-dialog" => "upgrade-invite-dialog",)); ?>
                                    <?php else: ?>
                                        <?php echo Html::anchor("#", Asset::img("event-plus.jpg"), array("class" => "send-event-invite-icon", "data-confirmation-dialog" => "send-event-invite-dialog", "data-event-id" => $featured_event['id'], "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list"), "data-username" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list") )); ?>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $featured_event['slug']) ?>">
                                    <?php if(empty($featured_event['photo'])): ?>
                                        <img src="temp/event_thumb.jpg" />
                                    <?php else: ?>
                                        <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_featured_'.$featured_event['photo'] ?>" />
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="event-caption-wrapper">
                                <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $featured_event['slug']) ?>"><i class="event-forward"></i></a>
                                <p title="<?php echo $featured_event['title'];  ?>" class="event-caption-top"><?php echo Str::truncate($featured_event['title'], 30);  ?></p>
                                <p class="event-caption-bottom"><?php echo $featured_event['start_date'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="clearfix"></div>
                </div>
            <?php else: ?>
                <p class="nodata-message"> No Event! </p>
            <?php endif; ?>

            <div class="border-circle border-circle-2"><?php echo Asset::img("line_end.png"); ?></div>
        </div>

        <div class="clearfix"></div>

        <div class="profile-activities">
            <div class="border-icon3"></div>
            <h3 class="section-title">More About Me</h3>
            <div class="more-about-me-title">
                <div id="personal_info" class="active"><strong>Personal Information</strong></div>
                <div id="dating_info"><strong>What I'm Looking For</strong></div>
            </div>
            
            <div class="more-about-me-body">
                <div class="left-info personal">
                    <div>
                        <strong>Career / Job Title</strong>
                        <span class="briefcase"><?php echo $profile->career ?></span>
                    </div>
                    <div>
                        <?php

                        $feetAndInches = explode('**', $height);
                        $height_array = explode("*", $feetAndInches[0]);
                        if(isset($height_array[0]))
                            $feet = $height_array[0];
                        if(isset($height_array[1]))
                            $inches = $height_array[1];
                        ?> 
                        <strong>Height</strong>
                        <span class="measure">
                            <input disabled value="<?php echo isset($feet)?$feet:'' ?> ft" />
                            <input disabled value="<?php echo isset($inches)?$inches:'' ?> in" />
                        </span>
                    </div>
                   
                    <div>
                        <strong>Education</strong>
                        <span class="measure"><?php echo $education['name'] ?></span>
                    </div>
                   <div>
                        <strong>Body Type</strong>
                        <span class="measure">
                            <?php echo $body_type['name'];?>
                        </span>
                    </div>
                    <div>
                        <strong>Children</strong>
                        <span class="children">
                        <?php echo $children['name'] ?>
                        </span>
                    </div>
                    <div>
                        <strong>Faith</strong>
                        <span class="globe">
                            <?php echo $faith['name'] ?>
                        </span>
                    </div>
                    <div>
                        <strong>Politics</strong>
                        <span class="globe"><?php echo $politics['name'] ?></span>
                    </div>
                    <div>
                        <strong>Ethnicity</strong>
                        <span class="globe">
                            <?php echo $ethnicity['name'] ?>
                        </span>
                    </div>
                </div>
                <div class="right-info personal">
                    <div>
                        <strong>How often do you go to the gym?</strong>
                        <div class="how-often">
                            <div class="<?php
                                if(isset($exercise['id'])){
                                    if(in_array($exercise['id'], array(1,2,3,4,5))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($exercise['id'])){
                                    if(in_array($exercise['id'], array(1,2,3,4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($exercise['id'])){
                                    if(in_array($exercise['id'], array(1,2,3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($exercise['id'])){
                                    if(in_array($exercise['id'], array(1,2))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($exercise['id'])){
                                    if(in_array($exercise['id'], array(1))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                        </div>
                        <div>
                            <span>Never</span>
                            <span>Sometimes</span>
                            <span>Often</span>
                        </div>
                    </div>
                    <div>
                        <strong>Do you drink?</strong>
                        <div class="how-often">
                            <div class="<?php
                                if(isset($drink['id'])){
                                    if(in_array($drink['id'], array(1, 2, 3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($drink['id'])){
                                    if(in_array($drink['id'], array(2, 3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($drink['id'])){
                                    if(in_array($drink['id'], array(2, 3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($drink['id'])){
                                    if(in_array($drink['id'], array(3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($drink['id'])){
                                    if(in_array($drink['id'], array(3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                        </div>
                        <div>
                            <span>Never</span>
                            <span>Sometimes</span>
                            <span>Often</span>
                        </div>
                    </div>
                    <div>
                        <strong>How often do you smoke?</strong>
                        <div class="how-often">
                            <div class="<?php
                                if(isset($smoke['id'])){
                                    if(in_array($smoke['id'], array(1, 2, 3, 4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($smoke['id'])){
                                    if(in_array($smoke['id'], array(2, 3, 4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($smoke['id'])){
                                    if(in_array($smoke['id'], array(2, 3, 4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($smoke['id'])){
                                    if(in_array($smoke['id'], array(3, 4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($smoke['id'])){
                                    if(in_array($smoke['id'], array(3, 4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                        </div>
                        <div>
                            <span>Never</span>
                            <span>Sometimes</span>
                            <span>Often</span>
                        </div>
                    </div>
                </div>

                <div class="left-info dating">
                    <div>
                        <strong>Career / Job Title</strong>
                        <span class="measure"><?php echo $seeking_occupation['name'] ?></span>
                    </div>
                    <div>
                        <?php

                        $feetAndInches = explode('**', $seeking_height);
                        $height_array = explode("*", $feetAndInches[0]);
                        if(isset($height_array[0]))
                            $feet = $height_array[0];
                        if(isset($height_array[1]))
                            $inches = $height_array[1];
                        ?> 
                        <strong>Height</strong>
                        <span class="measure">
                            <input disabled value="<?php echo isset($feet)?$feet:'' ?> ft" />
                            <input disabled value="<?php echo isset($inches)?$inches:'' ?> in" />
                        </span>
                    </div>
                   
                    <div>
                        <strong>Education</strong>
                        <span class="measure"><?php echo $seeking_education['name'] ?></span>
                    </div>
                   <div>
                        <strong>Body Type</strong>
                        <span>
                            <?php echo $seeking_body_type['name'] ?>
                        </span>
                    </div> 
                    <div>
                        <strong>Children</strong>
                        <span class="children"><?php echo $seeking_children['name'] ?></span>
                    </div>
                    <div>
                        <strong>Faith</strong>
                        <span class="globe">
                            <?php echo $seeking_religion['name'] ?>
                        </span>
                    </div>
                    <div>
                        <strong>Politics</strong>
                        <span class="globe"><?php echo $seeking_politics['name'] ?></span>
                    </div>
                    <div>
                        <strong>Ethnicity</strong>
                        <span class="globe">
                            <?php echo $seeking_ethnicity['name'] ?>
                        </span>
                    </div>
                    <div>
                        <strong>Preferred Ages</strong>
                        <span class="measure">
                            <input disabled value="<?php echo $profile->ages_from ?> yr" />
                            <input disabled value="<?php echo $profile->ages_to ?> yr" />
                        </span>
                    </div>
                </div>
                <div class="right-info dating">
                    <div>
                        <strong>How often do you go to the gym?</strong>
                        <div class="how-often">
                            <div class="<?php
                                if(isset($seeking_exercise['id'])){
                                    if(in_array($seeking_exercise['id'], array(1,2,3,4,5))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_exercise['id'])){
                                    if(in_array($seeking_exercise['id'], array(1,2,3,4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_exercise['id'])){
                                    if(in_array($seeking_exercise['id'], array(1,2,3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_exercise['id'])){
                                    if(in_array($seeking_exercise['id'], array(1,2))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_exercise['id'])){
                                    if(in_array($seeking_exercise['id'], array(1))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                        </div>
                        <div>
                            <span>Never</span>
                            <span>Sometimes</span>
                            <span>Often</span>
                        </div>
                    </div>
                    <div>
                        <strong>Do you drink?</strong>
                        <div class="how-often">
                            <div class="<?php
                                if(isset($seeking_drink['id'])){
                                    if(in_array($seeking_drink['id'], array(1, 2, 3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_drink['id'])){
                                    if(in_array($seeking_drink['id'], array(2, 3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_drink['id'])){
                                    if(in_array($seeking_drink['id'], array(2, 3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_drink['id'])){
                                    if(in_array($seeking_drink['id'], array(3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_drink['id'])){
                                    if(in_array($seeking_drink['id'], array(3))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                        </div>
                        <div>
                            <span>Never</span>
                            <span>Sometimes</span>
                            <span>Often</span>
                        </div>
                    </div>
                    <div>
                        <strong>How often do you smoke?</strong>
                        <div class="how-often">
                            <div class="<?php
                                if(isset($seeking_smoke['id'])){
                                    if(in_array($seeking_smoke['id'], array(1, 2, 3, 4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_smoke['id'])){
                                    if(in_array($seeking_smoke['id'], array(2, 3, 4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_smoke['id'])){
                                    if(in_array($seeking_smoke['id'], array(2, 3, 4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_smoke['id'])){
                                    if(in_array($seeking_smoke['id'], array(3, 4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                            <div class="<?php
                                if(isset($seeking_smoke['id'])){
                                    if(in_array($seeking_smoke['id'], array(3, 4))){
                                        echo 'blue';
                                    }
                                }
                             ?>"
                             ></div>
                        </div>
                        <div>
                            <span>Never</span>
                            <span>Sometimes</span>
                            <span>Often</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- <div class="activities-inner">
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

                        switch ($notification['object_type_id']) {
                            case (Model_Notification::EVENT_RSVP_SENT):
                                $notification_link = 'event/view/' . Model_Event::get_slug($notification['object_id']);
                                $notification_object = Model_Event::get_title($notification['object_id']);
                                $event = Model_Event::get_start_date($notification['object_id']);
                                $notification_verb = $event['start_date'];
                                break;

                            case (Model_Notification::MESSAGE_SENT):
                                $notification_link = 'message/index/';
                                $message_sender = Model_Profile::find($notification['actor_id']);
                                $message = Model_Message::find($notification['object_id']);
                                $notification_object = Model_Profile::get_username($message_sender->user_id);
                                $notification_content = $message->subject;
                                $notification_verb = ' sent you a <a id="message_sent" style="">message!<i ></i> </a>';
                                break;

                            case (Model_Notification::POST_SENT):
                                $notification_link = 'profile/dashboard';
                                $post_sender = Model_Profile::find($notification['actor_id']);
                                $post = Model_Post::find($notification['object_id']);
                                $notification_object = Model_Profile::get_username($post_sender->user_id);
                                $notification_content = $post->post_content;
                                $notification_verb = ' sent you a <a id="message_sent" style="">post!<i ></i> </a>';
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
                                break;

                            case (Model_Notification::NEW_MATCH_FOUND):
                                $notification_link = 'profile/dashboard';
                                $notification_object = 'You';
                                $notification_verb = ' <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> have new matches!</a>';
                                break;
                            case (Model_Notification::GETAWAY_RSVP_SENT):
                                $notification_link = 'profile/dashboard';
                                $post_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($post_sender->user_id);
                                $notification_verb = ' sent you a <a id="message_sent" style="">post!<i ></i> </a>';
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
                            case (Model_Notification::PHOTO_UPLOADED):
                                $notification_link = 'profile/dashboard';

                                $post_sender = Model_Profile::find($notification['actor_id']);
                                $message = DB::select('description')
                                            ->from('images')
                                            ->where('id',$notification['object_id'])
                                            ->execute();
                                $file_name = DB::select('file_name')
                                            ->from('images')
                                            ->where('id',$notification['object_id'])
                                            ->execute();
                                $file_id = $notification['object_id'];
                                $file_name = $file_name[0]['file_name'];
                                $notification_object_type_id = $notification['object_type_id'];
                                $message = $message[0]['description'];
                                
                                break;



                            default:
                                break;
                        }
                        ?>

                        <div class="activity">

                            <?php if(($notification['object_type_id'] == Model_Notification::POST_SENT)) {  ?>

                            <div class="user-info pull-left">
                                <div class="pull-left avatar">
                                    <?php $activity_profile = Model_Profile::find($notification['actor_id']); ?>
                                    <?php echo Html::anchor(Uri::create('profile/public_profile/'. $notification['actor_id']), Html::img(Model_Profile::get_picture($activity_profile->picture, $activity_profile->user_id, "activity-avatar"))); ?>

                                </div>
                                <div class="pull-left">
                                    <p class="activity-user"><?php echo $notification_object ?> <span class="light-gray"><?php echo $notification_verb ?></span></p>
                                    <p class="activity-date light-gray"><?php echo date('Y-m-d h:ia', $notification['created_at']); ?></p>
                                    <?php if(isset($notification_object_type_id) ){ ?>
                                      <p><?php echo $message;?></p>
                                      <?php } ?>
                                    <p><?php echo $notification_content; ?></p>
                                </div>
                               
                            </div>
                            <div class="activity-vertical-separator pull-left"></div>
                             <?php   } ?>

                            
                             <div class="clearfix"></div>
                            

                           <?php if(($notification['object_type_id'] == Model_Notification::PHOTO_UPLOADED)) {  ?>  
                            <div class="activity-content pull-right">

                                  <?php $activity_profile = Model_Profile::find($notification['actor_id']); ?>
                                 <table style="width: 500px;">
                                 <tr>
                                 <td>
                                 <div class ="activity-photo"> <img src="<?php echo \Fuel\Core\Uri::base().'uploads/'.$activity_profile->first_name.'/members_list_'.$file_name ?>" /></div>
                                 </td>

                                 <td>
                                 <table>
                                 <tr style="{ width = 50px; }">
                                 <td>
                                 <p><?php echo $message; ?></p>
                                 </td>
                                 <td style="text-align: left;">
                                     <div class="like">
                                         <a href="" url="<?php echo Uri::create('profile/like')?>" data-photo-id="<?php echo $file_id ; ?>" data-photo-name="<?php echo $file_name ; ?>" data-liker-id="<?php echo $current_profile->id; ?>"><i class="like"></i></a>   
                                     </div>
                                     <div id="count-likes-<?php echo $file_id ; ?>">
                                        <p> </p> 
                                     </div>
                                 </td>
                                 </tr>
                                 <tr>
                                 <td style="text-align: right;">
                                  <i class="zoom"></i>
                                 </td>
                                 <td>
                                  <div class="photo" data-photo="<?php echo $file_name; ?>"> <a href="" data-photo="<?php echo $file_name; ?>" data-first-name="<?php echo $activity_profile->first_name; ?>"> <p>See Larger Photo </p></a> </div>
                                 </td>
                                 </tr>
                                 </table>
                                 </td>
                                 </tr>
                                 
                                 </table>

                            </div>
                             <div class="clearfix"></div>

                            
                            <?php   } ?>
                        </div>


                       
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>You have no notification.</p>
                <?php endif; ?>
            </div> -->
        </div> <!-- end of activities -->

        <div class="clearfix"></div>

        <div class="profile-photos">
            <h3 class="section-title">Photos <?php echo Asset::img("profile/border-icon4.jpg"); ?></h3>
            <div class="photos-inner">
                <?php if ($latest_photos || $profile->picture != ""): ?>
                    <?php foreach ($latest_photos as $photo): ?>
                        <div class="photo">
                            <?php echo Html::anchor(Model_Profile::get_picture($photo['file_name'], $profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($photo['file_name'], $profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => $photo['description'] )); ?>
                            <div class="photo-caption">
                                <p title="<?php echo $photo['description']; ?>"><?php echo Str::truncate($photo['description'], 17 ) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="photo">
                        <?php echo Html::anchor(Model_Profile::get_picture($profile->picture, $profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => "Prfile Picture" )); ?>
                        <div class="photo-caption">
                            <p title="<?php echo "Profile Picture"; ?>"><?php echo "Profile Picture" ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="btn-holder"><a class="more-photo" href="#">More Photos</a></div>
                <?php else: ?>
                    <p class="nodata-message">No photos added yet!</p>
                <?php endif; ?>

            </div>
            <div class="border-circle border-circle-3"><?php echo Asset::img("line_end.png"); ?></div>
            <div class="border-circle border-circle-4"><?php echo Asset::img("line_end.png"); ?></div>
        </div> <!-- end of photos -->
  <?php } ?>
    </div>
</div>


<?php if (!Model_Friendship::request_exchanged($current_profile->id, $profile->id) AND $current_profile->id != $profile->id):  ?>
    <div id="send-invite-dialog" class="public-profile-dialog dialog">
        <i class="close-dialog fa fa-times-circle-o"></i>
        <div class="dialog-header">
            <h2>Send Invite</h2>
        </div>
        <div class="dialog-content">
            <?php echo Form::open(array("id" => "send-invite-form", "action" => "friendship/request", "class" => "clearfix")) ?>
            <?php echo Form::hidden('sender_id', $current_profile->id); ?>
            <?php echo Form::hidden('receiver_id', $profile->id); ?>
            <?php echo Form::hidden('status', Model_Friendship::STATUS_SENT); ?>
            <div id="send-invite-content" class="clearfix">
                <p><span>Invite</span> <?php echo Model_Profile::get_username($profile->user_id) ?> to join your profile network</p>
                <p class="submit">
                    <input type="submit" name="#" value="Send Invite"/>
                </p>
            </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
<?php endif; ?>

<div id="refer-to-friend-dialog" class="public-profile-dialog dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>Refer to Friends</h2>
    </div>
    <div class="dialog-content">
  
            <?php echo Form::open(array("id" => "", "action" => "profile/refer_friends", "class" => "clearfix")) ?>
            <?php echo Form::hidden('refer_from', $current_profile->id); ?>
			  <?php echo Form::hidden('refered_id',$profile->id); ?>                                                         
            <div id="refer-to-friend-content" class="clearfix">
			
                <p>Refer to a Friends <select name= "referOption" ><span> <option></option><?php foreach($friends as $friend): ?>
				      <?php if($friend->id!=$profile->id): ?>        
				<option  value=<?php echo $friend->id; ?> ><?php echo Model_Profile::get_username($friend->user_id); ?></option>  <?php endif; ?><?php endforeach; ?></span></select></p>
			          
                <p class="submit">
                    <input type="submit" name="#" value="Refer to Friends"/>
                </p>
            </div>
            <?php echo Form::close(); ?>
       
    </div>
</div>

    <div id="send-event-invite-dialog" class="dialog confirmation-dialog">
        <div class="dialog-header">
            <?php echo Asset::img('pages/home2/mini.png'); ?>
            <h2>Request to Join</h2>
        </div>
        <div class="dialog-content">
            <img src="" class="dialog-logo"/>
            <div class="right-content">
                <p class="username">Do you want to request to join the member on this event?</p>
                <p>Do you want to send this request?</p>
                <a class="button chat confirm-event-send" data-action="<?php echo Uri::base() . 'event/send_event_invite'; ?>" data-status="accept" data-from-member-id="<?php echo $profile->id ?>" data-to-member-id="<?php echo $current_profile->id ?>" href="#">Yes</a>
                <a class="button no-button"  data-status="decline" href="#">No</a>
            </div>
        </div>
    </div>

<div id="report-me-dialog" class="dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>Report Me To Administrator</h2>
    </div>
    <div class="dialog-content">
        <?php echo Form::open(array("id" => "report-me-form", "action" => "agent/report_me", "class" => "clearfix")) ?>
        <?php echo Form::hidden('dating_agent_id', $profile->id); ?>
        <p class="clearfix">
            <label>Message:</label>
            <textarea name="message"></textarea><br/>
        </p>
        <p class="submit">
            <input type="submit" name="#" value="Send"/>
        </p>
        <?php echo Form::close(); ?>

    </div>
</div>
<?php } ?>














