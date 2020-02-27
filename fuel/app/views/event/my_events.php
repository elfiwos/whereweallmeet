<div id="content" class="clearfix referral invitations">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <div id="profile-pic"><?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
                <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
            </div>
        </div>
        <?php echo View::forge("profile/partials/profile_nav"); ?>
    </aside>
    <div id="middle" class="referal-middle invitation-middle">
        <section id="latest-members">
              <div class="header-section">
                  <ul class="header-text header-links">
                      <li class="active"><a href="#" >My Events <span class="blue"></span></a></li> 
                      <li>|</li>
                      <li><a href="#" >Future Events</a></li> 
                      <li>|</li>
                      <li><a href="#">Plan on Attending <span class="light-gray"></span></a></li>
                  </ul>
                  <div class="clearfix"></div>
                  
              </div>
                
                <div class="content">
                    <div class="invitations-upper">
                        <p class="pull-left gray">Viewing my all Events</p>
                       <!-- <button class="blue-btn manage-photo pull-left">Manage Events</button> -->
                        <div class="clearfix"></div>
                    </div>
        <div class="event-listings">

        <?php
            $no_event = true;

            if(isset($active_events) and $active_events !== false){
                $no_event = false;
                foreach($active_events as $event):
                    ?>
           <div class="event">
            <div class="event-thumb pull-left">
                <a href="<?php echo \Fuel\Core\Uri::create('event/view/'.$event['slug']) ?>">
                    <?php
                    if(empty($event['photo'])):
                    ?>
                        <img src="temp/event_thumb.jpg" />
                    <?php
                    else:
                    ?>
                        <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_list_'.$event['photo'] ?>" />
                    <?php
                    endif;
                    ?>

                </a>
                </div>
                 <div class="pull-left event-detail">
                                <p class="title"><?php echo $event['title'] ?></p>
                                <p class="location"><span class="gray">LOCATED:</span><?php echo $event['venue'] ?></p>
                                <p class="date"><?php echo $event['start_date'] ?></p>
                                <p class="detail gray"><?php echo \Fuel\Core\Str::truncate($event['long_description'], 150)//echo substr($event->short_description, 0, 400).'...' ?></p>
                               <?php echo \Fuel\Core\Html::anchor('event/view/'.$event['slug'], 'View-event', array('class' => 'button')) ;?>
                            </div>
                            <div class="clearfix"></div>
                </div>  
             
                    <hr>
            <?php

                endforeach;?>
                  <div class="view-more-wrap">
                            <button class="view-more-friend">View More</button>             
                        </div>                        
                    </div>

           <?php }
           else{

            echo "There are no active events";
            }

            ?>

                    
                                                             
                      
            <div class="event-listings">

        <?php
            $no_event = true;

            if(isset($past_events) and $active_events !== false){
                $no_event = false;
                foreach($past_events as $event):
                    ?>
           <div class="event">
            <div class="event-thumb pull-left">
                <a href="<?php echo \Fuel\Core\Uri::create('event/view/'.$event['slug']) ?>">
                    <?php
                    if(empty($event['photo'])):
                    ?>
                        <img src="temp/event_thumb.jpg" />
                    <?php
                    else:
                    ?>
                        <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_list_'.$event['photo'] ?>" />
                    <?php
                    endif;
                    ?>

                </a>
                </div>
                 <div class="pull-left event-detail">
                                <p class="title"><?php echo $event['title'] ?></p>
                                <p class="location"><span class="gray">LOCATED:</span><?php echo $event['venue'] ?></p>
                                <p class="date"><?php echo $event['start_date'] ?></p>
                                <p class="detail gray"><?php echo \Fuel\Core\Str::truncate($event['long_description'], 250)//echo substr($event->short_description, 0, 400).'...' ?></p>
                                <a class="btn-detail" href="#"><?php echo \Fuel\Core\Html::anchor('event/view/'.$event['slug'], 'View-event', array('class' => 'button')) ;?></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>  
             
                    <hr>
            <?php

                endforeach; ?>
                <div class="view-more-wrap">
                            <button class="view-more-friend">View More</button>             
                        </div>   

           <?php }
           else{

            echo "There are no Past events";
            }

            ?>

                    
                                                             
                                             
                    </div>

    </div>
            </section>
        <div class="border-icon1"></div>
        <div class="border-circle referal-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle referal-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
    </div>
</div>

