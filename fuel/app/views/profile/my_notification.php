<script type="text/javascript"> 
function confirmDelete() { 
 return confirm("Are you sure you want to delete?");   
} 
</script> 

<div id="content" class="clearfix">
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
        <?php echo View::forge("profile/partials/setting_nav"); ?>
    </aside>
    <div id="middle" class="notification-middle">

        
        <div class="header-section">
            <p class="header-text">My Notifications</p>
        </div>

        <div class="form-wrapper notification-form">
        
         
        <?php echo Form::open(array("action" => "profile/save_notification_setting", "id" => "notification-form", "class" => "form")) ?>
              <div class="inner-wrapper">
                <div class="field">
                    <p class="label pull-left">My Account</p>
                    <div class="pull-right">
                    <?php if($current_profile->send_me_account_info == 1){ ?>
                        <label><input type="checkbox" name="account_email" checked="checked" />Email</label>
                    <?php } else { ?>
                        <label><input type="checkbox" name="account_email" />Email</label>
                    <?php } ?>
                    <label><input type="checkbox" name="account_sms" />SMS</label>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="field">
                    <p class="label pull-left">My Listings</p>
                    <div class="pull-right">
                    <?php if($current_profile->send_me_listing_info == 1){ ?>
                        <label><input type="checkbox" name="listing_email" checked="checked" />Email</label>
                    <?php } else { ?>
                        <label><input type="checkbox" name="listing_email" />Email</label>
                    <?php } ?>
                    <label><input type="checkbox" name="listing_sms" value=""/>SMS</label>
                    </div>
                    <div class="clearfix"></div>
                </div>                
                <div class="field">
                    <p class="label pull-left">My Dates</p>
                    <div class="pull-right">
                    <?php if($current_profile->send_me_date_invitations == 1){ ?>
                        <label><input type="checkbox" name="date_email" checked="checked"/>Email</label>
                    <?php } else { ?>
                        <label><input type="checkbox" name="date_email" />Email</label>
                    <?php } ?>
                    <label><input type="checkbox" name="date_sms" value=""/>SMS</label>
                    </div>
                    <div class="clearfix"></div>
                </div>  
                <div class="field">
                    <p class="label pull-left">Announcements</p>
                    <div class="pull-right">
                    <?php if($current_profile->send_me_announcement_info == 1){ ?>
                        <label><input type="checkbox" name="announcment_email" checked="checked" />Email</label>
                    <?php } else { ?>
                        <label><input type="checkbox" name="announcment_email" />Email</label>
                    <?php } ?>
                    <label><input type="checkbox" name="announcment_sms" />SMS</label>
                    </div>
                    <div class="clearfix"></div>
                </div>  
                <div class="field">
                    <p class="label pull-left">Special Deals</p>
                    <div class="pull-right">
                    <?php if($current_profile->send_me_specialdeal_info == 1){ ?>
                        <label><input type="checkbox" name="deal_email" checked="checked"/>Email</label>
                    <?php } else { ?>
                        <label><input type="checkbox" name="deal_email" />Email</label>
                    <?php } ?>
                    <label><input type="checkbox" name="deal_sms" value=""/>SMS</label>
                    </div>
                    <div class="clearfix"></div>
                </div>                                                
                                
                </div>

                <div class="submit-btn">
                        <div class="btn-wrap gold-bg">
                        <input type="submit" name="submit" value="SAVE" />
                        </div>
                </div>

            </form>
        </div>

        <div class="border-icon1"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div> 
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div> 

    </div> <!-- end of middle -->
</div>
