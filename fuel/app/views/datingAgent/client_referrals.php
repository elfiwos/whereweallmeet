<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">

                <div id="profile-pic">
                <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?>
                </div>
                <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
            </div>
        </div>
        <nav id="profile-nav">
            <div id="online-status-container">
                <?php echo Asset::img("online_dot.png"); ?>
                <?php echo $current_user->username . " is Online"; ?>
            </div>
            <?php echo Html::anchor(Uri::create('agent'), '<i class="my_friends"> </i>Clients (' . $countAgentClients . ')'); ?>
            <?php echo Html::anchor(Uri::create('profile/my_photos'), '<i class="my_photos"></i>Photos (' . $countImage . ')'); ?>
            <?php echo Html::anchor(Uri::create('agent/client_referrals'), '<i class="my_date"></i>Client Referals (' . $countAgentReferals . ')'); ?>
            <div class="latest-invites"><a href="<?php echo Uri::create("agent"); ?>"><p><?php echo Asset::img('profile/chat-icon.png'); ?></p><p>Live agents online</p><?php echo '(' . $countOnlineDatingAgents . ')' ?><p>Chat Now!</p></a></div>
        </nav>
        <div class="border-icon1"></div>
        <div class="border-icon2"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-3"><?php echo Asset::img('line_end.png'); ?></div>
    </aside>
    <div id="middle" class="agent-profile-middle">
        <section class="agent-listing agent-profile-page">
          <div class="header-section">
              <p class="header-text">Client Referrals</p>
          </div>
            
            <div class="content">
                <?php if(isset($referred_friends)): ?>
                    <?php $counter = 0; ?>

                    <?php foreach($referred_friends as $referred_friend): ?>
                        <?php if( ! Model_Profile::is_deleted_account($referred_friend->id)): ?>
                            <?php $counter++; $online_u = 0; ?>
                            <div class="agent">
                                <div class="online-status">
                                    <?php if($referred_friend->is_logged_in): ?>
                                        <?php echo Asset::img("online_dot.png"); ?><span>Online</span>
                                    <?php else: ?>
                                        <?php echo Asset::img("offline_dot.png"); ?><span>Offline</span>
                                    <?php endif; ?>
                                </div>
                                <div class="agent-image"><?php echo View::forge("profile/partials/member_thumb", array("member" => $referred_friend)); ?></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
        </section>
    </div>
</div>
