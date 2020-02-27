
<nav id="main-nav" class="clearfix">
    <div>
    <?php if ($current_user) { ?>
        <?php $home_link = $current_user->get("profile")->is_completed ? Uri::base() : "profile/edit"; ?>
        <ul>
            <li <?php echo isset($active_page) && $active_page == "events" ? "class='active'" : "";?>><?php echo Html::anchor(Uri::create("event"), "EVENTS"); ?></li>
            <li <?php echo isset($active_page) && $active_page == "dating_packages" ? "class='active'" : "";?>><?php echo Html::anchor(Uri::create("package"), "DATE IDEAS"); ?></li>
            <li <?php echo isset($active_page) && $active_page == "get_aways" ? "class='active'" : "";?>><?php echo Html::anchor(Uri::create("getaway"), "GET-AWAYS"); ?></li>
            <li <?php echo isset($active_page) && $active_page == "dating_agent" ? "class='active'" : "";?>><?php echo Html::anchor(Uri::create("agent"), "DATING AGENT"); ?></li>
            <li <?php echo isset($active_page) && $active_page == "browse" ? "class='active'" : "";?>><?php echo Html::anchor(Uri::create("browse"), "BROWSE"); ?></li>
            <li <?php echo isset($active_page) && $active_page == "upgrade" ? "class='active'" : "";?>><?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "UPGRADE"); ?></li>
        </ul>
    <?php } ?>

    <div id="login-status">
        <?php if ($current_user) { ?>
            <?php //$profile_type = $current_user->get("profile")->is_paid_member() ? "Premium" : "Free"; ?>
            <?php
                $profile_type_name = "";
                if($current_profile->member_type_id == 2){
					$profile_type = "Premium";
				}else if($current_profile->member_type_id == 3){
					$profile_type = "Dating Agent";
                }else if($current_profile->member_type_id == 4){
                    $profile_type = "Gold";
				}else if($current_user->group_id == 5){
					$profile_type_name = $current_user->username;
					$profile_type = "Admin";
				}else{
					$profile_type = "Free";
				}
            ?>
            <?php if($current_user->group_id == 5):?>
            <span>Membership: <?php echo Html::anchor("#", $profile_type); ?> | <?php echo Html::anchor("admin/index", $profile_type_name); ?> | <?php echo Html::anchor("users/logout", "Logout"); ?></span>
            <?php else: ?>
           <div id="user-logout"> <span>Membership: <?php echo Html::anchor(Uri::create("profile/dashboard"), $profile_type); ?> | <?php echo Html::anchor("users/logout", "Logout"); ?></span></div>
            <?php endif; ?>
        <?php } else { ?>
            <span><?php echo Html::anchor("pages/home", "Sign up"); ?> | <?php echo Html::anchor("users/login", "Login"); ?></span>
        <?php } ?>
        <div id="logged-in-user-notification"><?php echo $current_user ? $current_user->username : ''; ?></div>
        <div id="chat-base-url"><?php echo Uri::base(); ?></div>
    </div>
    </div>
</nav>

<?php echo View::forge("layout/partials/banner_container"); ?>
