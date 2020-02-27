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
	              <p class="header-text">Referal Members</p>
	          </div>
	            
	            <div class="content">
	            	<div id="description">
	                    <p>
	                        These members have been selected for you to review and communicate. These members have accepted your profile for a date.
	                    </p>
	            	</div>

	            	<?php foreach ($my_referals as $referal){?>
	            	   <?php $member_refered = Model_Profile::find($referal['refered_id'])?>
			          <div class="referal_members">
			            <div class="referal_member">
			                <div class="referal_member_avatar">
			                   <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture( $member_refered->picture,  $member_refered->user_id, "profile_medium"))); ?>
			                    <p class="name_of_match"><?php  echo $member_refered->first_name .' '. $member_refered->last_name?></p>
			                </div>
			                <!--<div class="referal_buttons">
			                    <div class="referal_button"><?php /* echo Asset::img('messages_1.png'); ?></div>
			                    <div class="referal_button"><?php echo Asset::img('hello_01.png'); ?></div>
			                    <div class="referal_button"><?php echo Asset::img('favorite.png'); */?></div>
			                    <div class="clearfix"></div>
			                </div> -->
			            </div>
			           <?php } ?>
			            <div class="clearfix"></div>
	            </div>
	            </div>
	        </section>
	    <div class="border-icon1"></div>
        <div class="border-circle referal-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle referal-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
    </div>
</div>