<div id="content" class="clearfix referral">
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
    <div id="middle" class="referal-middle">
        <section id="latest-members">
              <div class="header-section">
                  <p class="header-text">My Friends</p>
              </div>
                
                <div class="content">
                    <div>
                        <form action="" method="post" class="pull-right">
                            <label>Search Friends: <input type="text" name="search_text" class="friend_inp" value="<?php echo isset($search_text)? $search_text : "" ?>" /></label>
                        </form>
<!--                        <button class="blue-btn">Manage Friends</button>-->
                        <?php echo Html::anchor(Uri::create("profile/manage_friends"), "Manage Friends",array('id'=>'manage-friends-link', 'class' => 'blue-btn')); ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="referal_members friends">
                        <?php if ($friends): ?>
                            <div id="friend-list-container" class="friend-list">
                                <?php foreach ($friends as $member): ?>
                                    <div class="referal_member friend">
                                        <?php echo View::forge("profile/partials/friends_thumb", array("member" => $member)); ?>
                                    </div>
                                <?php endforeach; ?>
                                <div class="clearfix"></div>
                            </div>
                            <div class="btn-holder"><a class="more-friends" data-count="<?php echo count($friends); ?>" href="#">More Friends</a></div>
                        <?php else: ?>
                            <p>No <?php echo Model_Profile::is_dating_agent($current_profile->id)? 'clients' : 'friends' ?> added yet!</p>
                        <?php endif; ?>
                        <hr class="friend-divider"/>
                    </div>
                </div>
            </section>
        <div class="border-icon1"></div>
        <div class="border-circle referal-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle referal-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
    </div>
</div>

