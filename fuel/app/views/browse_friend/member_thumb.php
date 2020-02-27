<?php if($photo_selected == 0): ?>
    <div class="member">
        <div class="user-image"><?php echo Html::anchor(Uri::create('profile/public_profile/' . $member['id'].'/'."browse"), Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?></div>
        <div class="caption">
            <p class="name"><?php echo Model_Profile::get_username($member['user_id'],18) ?></p>
            <p class="location"><?php echo substr($member['city'],0,19) . ' ' . $member['state'] ?></p>
        </div>
    </div>
<?php else: ?>
    <?php if (isset($member['picture']) && $member['picture'] != "") : ?>
        <div class="member">
            <div class="user-image"><?php echo Html::anchor(Uri::create('profile/public_profile/' . $member['id'].'/'."browse"), Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?></div>
            <div class="caption">
                <p class="name"><?php echo Model_Profile::get_username($member['user_id'],18) ?></p>
                <p class="location"><?php echo substr($member['city'],0,19) . ' ' . $member['state'] ?></p>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>


