<!-- agent view of respective client -->
<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">

                <div id="profile-pic">
                    <?php echo Html::anchor(Uri::create('profile/dashboard'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?>
                </div>
                <div id="profile_name"><?php echo Html::anchor(Uri::create('profile/dashboard'), Model_Profile::get_username($current_profile->user_id), array("id" => "profile-link")); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
            </div>
            <div id="online-status-container">
                <?php if($current_profile->is_logged_in): ?>
                    <?php echo Asset::img("online_dot.png"); ?>  Hello, I'm Online
                <?php else: ?>
                    <?php echo Asset::img("offline_dot.png"); ?>  I'm Offline
                <?php endif; ?>

            </div>
            <div class="profile-sub-menu">
                <?php echo Html::anchor("#", '<i class="send-msg"></i>Send Message', array("class" => "send-message-icon menu-btn", "data-confirmation-dialog" => "message-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $client_profile->id, "data-username" => Model_Profile::get_username($client_profile->user_id), "data-profile-picture" => Model_Profile::get_picture($client_profile->picture, $client_profile->user_id, "members_list") )); ?>
                <?php echo Html::anchor("#", '<i class="chat"></i>Chat With Me', array("class" => "send-chat-request menu-btn menu-btn-chat", "data-confirmation-dialog" => "chat-confirmation-dialog", "data-username" => Model_Profile::get_username($client_profile->user_id), "data-full-name" => Model_Profile::get_username($client_profile->user_id), "data-profile-picture" => Model_Profile::get_picture($client_profile->picture, $client_profile->user_id, "members_list"))); ?>
                <div class="latest-invites"><a href="<?php echo Uri::create("agent"); ?>"><p><?php echo Asset::img('profile/chat-icon.png'); ?></p><p>Live agents online</p><?php echo '(' . $countOnlineDatingAgents . ')' ?><p>Chat Now!</p></a></div>
            </div>
            <div id="invite-friend-container">
                <?php if(Model_Profile::is_dating_agent($current_profile->id)): ?>
                    <p>REFER ME To A FRIEND</p>
                    <a id="btn-refer-me" href="#"><i class="refer-me"></i>REFER ME</a>
                <?php endif; ?>
            </div>
    </aside>
    <div id="middle" class="agent-profile-middle agent-client-middle">
        <section id="latest-members" class="agent-profile">
            <div class="header-section">
                <p class="header-text">Dating Agent Client</p>
            </div>

            <div class="content">
                <div id="">
                    <p>
                    <div class="client_avatar">
                        <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($client_profile->picture, $client_profile->user_id, "profile_medium"))); ?>
                    </div>
                    <div class="client_detail">
                        <p class="client_name"><?php echo Model_Profile::get_username($client_profile->user_id); ?></p>
                        <p class="client_online"><?php echo $client_profile->is_logged_in ?  Asset::img("online_dot.png") : Asset::img("offline_dot.png");; ?><?php echo Model_Profile::get_username($client_profile->user_id) . " is Online"; ?></p>
                        <p class="client_age"><?php echo ($client_profile->birth_date == null ? '' : Model_Profile::get_age($client_profile->birth_date).' Years Old, '). ($client_profile->gender_id == null ? '' : Model_Gender::find($client_profile->gender_id)->name) ?></p>
                        <p class="client_location"><?php  echo $client_profile->city == "" ? $client_profile->state : $client_profile->city . ", ". $client_profile->state; ?></p>
                        <div id="about-me-full-content" class="text">
                            <p class="client_detail_text partial_text"><?php echo Str::truncate($client_profile->about_me, 50, '...')   ?></p>
                            <p class="client_detail_text full_text"><?php echo $client_profile->about_me  ?></p>
                        </div>
                        <a class="client_read_more" href="#">Read More ></a>
                    </div>
                    <div class="clearfix"></div>
                    </p>

                </div>

            </div>
        </section>

        <section id="latest-members" class="agent-profile agent-form">
            <div class="header-section">
                <p class="header-text">Quick Personal Survey</p>
            </div>
            <?php echo Form::open(array("action" => "agent/client_survey", "id" => "survey-form", "class" => "clearfix")) ?>
            <div class="form-survey">
                <p><strong>Describe Your Occupation</strong></p>
                <p class="survey-detail"><?php echo $client_agent['occupation']; ?></p>
                <p class="survey-label"><strong>What I'm Looking for...</strong></p>
                <p class="survey-detail"><?php echo $client_agent['looking_for']; ?></p>
                <p class="survey-label"><strong>My Life So Far...</strong></p>
                <p class="survey-detail"><?php echo $client_agent['life_so_far']; ?></p>
                <p class="survey-label"><strong>What I like to do...</strong></p>
                <p class="survey-detail"><?php echo $client_agent['like_to_do']; ?></p>
                <p class="survey-label"><strong>My Favorite Things...</strong></p>
                <p class="survey-detail"><?php echo $client_agent['favorite_things']; ?></p>
                <p class="survey-label"><strong>My favorite Places To Go...</strong></p>
                <p class="survey-detail"><?php echo $client_agent['favorite_places']; ?></p>
            </div>
            <?php echo Form::close(); ?>
        </section>

        <div class="border-icon1-pagent"></div>
        <div class="border-icon2-pagent"></div>
        <div class="border-circle border-circle-1-pagent"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-2-pagent"><?php echo Asset::img('line_end.png'); ?></div>
    </div>

    <div id="" class="agent-client-right">
        <div class="right-big-btn-wrp">
            <?php echo Html::anchor("#", 'SEND ME A MESSAGE', array("class" => "right-big-btn send-message-icon", "data-confirmation-dialog" => "message-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $client_profile->id, "data-username" => Model_Profile::get_username($client_profile->user_id), "data-profile-picture" => Model_Profile::get_picture($client_profile->picture, $client_profile->user_id, "members_list") )); ?>
        </div>
        <div class="right-big-btn-wrp right-big-btn-wrp-pink">
            <?php echo Html::anchor("#", 'SEND ME A CHAT', array("class" => "right-big-btn send-chat-request", "data-confirmation-dialog" => "chat-confirmation-dialog", "data-username" => Model_Profile::get_username($client_profile->user_id), "data-full-name" => Model_Profile::get_username($client_profile->user_id), "data-profile-picture" => Model_Profile::get_picture($client_profile->picture, $client_profile->user_id, "members_list"))); ?>
        </div>
        <p class="referal_header"><strong>Referrals members</strong></p>
        <hr/>
        <div class="referal_members">
            <?php if($referred_friends){ ?>
                <?php foreach($referred_friends as $referred_friend){ ?>
                    <div class="referal_member">
                        <div class="referal_member_avatar">
                            <?php echo Html::anchor(Uri::create('profile/public_profile/' . $referred_friend['id']), Html::img(Model_Profile::get_picture($referred_friend['picture'], $referred_friend['user_id'], "referral"))); ?>
                            <p><?php echo Model_Profile::get_username($referred_friend['user_id'],18) ?></p>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No Referrals</p>
            <?php } ?>
            <div class="clearfix"></div>
            <hr />
        </div>

        <div class="exp-dat-wrap"><p>MEMBERSHIP EXP. DATE<br/><span class="exp-date"><?php echo $client_profile->subscription_expiry_date == '' ? "Subscription Expiry Date not defined" : date("Y-m-d", $client_profile->subscription_expiry_date) ?></span></p></div>

    </div>
    <div class="clearfix"></div>
</div>

<!--Refer me popup-->
<div id="refer-popup-container" class="dialog confirmation-dialog">
    <div class="dialog-header">
        <?php echo Asset::img('pages/home2/mini.png'); ?>
        <h2>Refer Me</h2>
    </div>
    <div id="client-popup">
        <div class="content">
            <div id="">
                <p>
                <div class="client_avatar">
                    <?php echo Html::anchor(Uri::create('profile/public_profile/'.$client_profile->id), Html::img(Model_Profile::get_picture($client_profile->picture, $client_profile->user_id, "profile_medium"))); ?>
                </div>
                <div class="client_detail">
                    <p class="client_name"><?php echo Model_Profile::get_username($client_profile->user_id) ;?></p>
                    <p class="client_location"><?php echo $client_profile->city . ", " . $client_profile->state; ?></p>
                    <p class="client_detail_text"> <?php echo $client_profile->about_me; ?></p>
                </div>
                <div class="clearfix"></div>
                </p>
                <p>
                <div class="client_detail">
                    <?php echo Form::open(array("action" => "agent/refer_to_client", "id" => "refer-form", "class" => "clearfix")) ?>
                    <select name ="refered_member" >
                        <?php foreach ($agent_clients as $agent_client){ ?>
                            <?php if($client_profile->id <> $agent_client->id): ?>
                                <option  value="<?php echo $agent_client->id; ?>">
                                    <?php echo Model_Profile::get_username($agent_client->user_id); ?>
                                </option>
                            <?php endif; ?>
                        <?php } ?>
                    </select>
                    <?php echo Form::input("to_id", $client_profile->id, array("class" => "email required",  'type'=>"hidden")); ?>
                    <?php echo Form::input("from_id", $current_profile->id, array("class" => "email required",  'type'=>"hidden")); ?>
                    <button  type="submit"><span>REFER</span></button>
                    <?php echo Form::close(); ?>
                </div>
                </p>
            </div>

        </div>

    </div>
</div>