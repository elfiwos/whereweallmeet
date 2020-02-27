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
                      <li class="active"><a href="#" >My Invitations <span class="blue"><?php echo count($event_invitations); ?></span></a></li>
                  </ul>
                  <div class="clearfix"></div>
                  
              </div>
                
                <div class="content">
                    <div class="invitations-upper">
                        <div class="clearfix"></div>
                    </div>
                    <div class="invitation-listings">
                        <?php foreach ($event_invitations as $event_invitation):?>
                            <?php $sender = Model_Profile::find($event_invitation->refered_by);?>
                            <?php $event = Model_Event::find($event_invitation->event_id) ?>
                            <div class="invitation">
                                <div class="invitation-avatar pull-left">
                                    <?php echo Html::anchor(Uri::create('profile/public_profile/'. $sender->id), Html::img(Model_Profile::get_picture($sender->picture, $sender->user_id, "activity-avatar"))); ?>
                                </div>
                                <div class="pull-left">
                                    <p class="invitation-text"><span class="blue"><?php echo Model_Profile::get_username($sender->user_id); ?></span> has invited you to an event,
                                        <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $event->slug) ?>">
                                            <span class="blue"><?php echo $event->title;?></span>
                                        </a>
                                    </p>
                                    <?php if($event_invitation->message == Model_Friendship::STATUS_SENT){ ?>
                                        <p class="invitation-sub-text pull-left">Do you accept this inivation? </p>
                                        <p class="btns pull-left">
                                            <a class="request-btn event-invite" data-action="<?php echo Uri::base() . 'profile/manage_event_invite'; ?>" data-status="<?php echo Model_Friendship::STATUS_ACCEPTED ?>" data-my-invitation-id="<?php echo $event_invitation->id ?>" href="#"><i class="request-accept event-invite-request-accept"></i><span>Yes</span></a>
                                            <a class="request-btn event-invite" data-action="<?php echo Uri::base() . 'profile/manage_event_invite'; ?>" data-status="<?php echo Model_Friendship::STATUS_REJECTED ?>" data-my-invitation-id="<?php echo $event_invitation->id ?>" href="#"><i class="request-reject event-invite-request-reject"></i><span>No</span></a>
                                        </p>
                                    <?php } else { ?>
                                        <p class="btns pull-left">
                                            <a class="request-btn event-invite" data-action="<?php echo Uri::base() . 'profile/manage_event_invite'; ?>" data-status="<?php echo Model_Friendship::STATUS_REJECTED ?>" data-my-invitation-id="<?php echo $event_invitation->id ?>" href="#"><i class="request-reject event-invite-request-reject"></i><span>Delete</span></a>
                                        </p>
                                    <?php } ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php endforeach; ?>
<!--                    -->
<!--                        <div class="view-more-wrap">-->
<!--                            <button class="view-more-friend">View More</button>             -->
<!--                        </div>                        -->
                    </div>
                </div>
            </section>
        <div class="border-icon1"></div>
        <div class="border-circle referal-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle referal-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
    </div>
</div>

