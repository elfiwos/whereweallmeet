<!-- agent profile page as viewed by the agent -->
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
        <div id="invite-friend-container">
            <p>REFER ME To A FRIEND</p>
            <a href="#"><i class="refer-me"></i>REFER ME</a>
        </div>

        <div class="border-icon1"></div>
        <div class="border-icon2"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-3"><?php echo Asset::img('line_end.png'); ?></div>
    </aside>
    <div id="middle" class="agent-profile-middle">
        <section class="agent-listing agent-profile-page">
          <div class="header-section">
              <p class="header-text">Manage Clients</p>
          </div>
            
            <div id="latest-client-requests" class="content">
                <?php if(isset($clients)): ?>
                    <?php $counter = 0; ?>

                    <?php foreach($clients as $client): ?>
                        <?php if( ! Model_Profile::is_deleted_account($client->id)): ?>
                            <?php $counter++; $online_u = 0; ?>
                            <div class="agent">
                                <div class="online-status">
                                    <?php if($client->is_logged_in): ?>
                                        <?php echo Asset::img("online_dot.png"); ?><span>Online</span>
                                    <?php else: ?>
                                        <?php echo Asset::img("offline_dot.png"); ?><span>Offline</span>
                                    <?php endif; ?>
                                </div>
                                <div class="agent-image">
                                    <?php //echo View::forge("profile/partials/member_thumb", array("member" => $client)); ?>
                                    <div class="member">
                                        <?php echo Html::anchor(Uri::create('profile/public_profile/' . $client['id']), Html::img(Model_Profile::get_picture($client['picture'], $client['user_id'], "members_medium"))); ?>
                                        <p><?php echo Model_Profile::get_username($client['user_id'],18) ?></p>
                                        <p class="location"><?php echo substr($client['city'],0,19) . ' ' . $client['state'] ?></p>

                                        <?php echo Form::open(array("id" => "client-management-form", "action" => "agent/update_agent_client", "class" => "clearfix")) ?>
                                            <?php echo Html::anchor("#", "ACCEPT", array("class" => "accept", "data-sender-id" => $client['id'], "data-client-status" => Model_Agentclient::STATUS_ACCEPTED)); ?>
                                            <?php echo Html::anchor("#", "REJECT", array("class" => "decline", "data-sender-id" => $client['id'], "data-client-status" => Model_Agentclient::STATUS_REJECTED)); ?>
                                        <?php echo Form::close(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section> 

    </div>
</div>
