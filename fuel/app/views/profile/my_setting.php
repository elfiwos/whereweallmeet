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
    <div id="middle">

        
        <div class="header-section">
            <p class="header-text">My Account</p>
        </div>

        <div class="form-wrapper">
        <?php echo Form::open(array("action" => "profile/update_account_setting", "id" => "account-form", "class" => "form")) ?>
              <div class="inner-wrapper">
                <div class="field">

                    <p class="label">Username</p>
                     <?php echo Form::input("username", $current_user->username, array('disabled', 'type'=>"text", "placeholder"=>"Your username...")); ?>
                    
                </div>
                <div class="field">
                    <p class="label">Email Address</p>
                    <?php echo Form::input("email", $current_user->email, array( 'type'=>"text", "placeholder"=>"youremail@domain.com")); ?>
                    
                </div>                   
                <div class="field">
                    <p class="label">Gender</p>
                    <select name="gender">
                        <option value="1" <?php echo ($current_profile->gender_id == 1)? 'selected' : '';?>>Male</option>
                        <option value="2" <?php echo ($current_profile->gender_id == 2)? 'selected' : '';?>>Female</option>
                    </select>    
                </div>   
                <div class="field">
                    <p class="label">Old Password</p>
                    <?php echo Form::input("old-password", '', array( 'type'=>"password", "placeholder"=>"*******", "class"=>"pull-left", "value"=>"" )); ?>   
                     
                    <div class="clearfix"></div>
                </div>
                <div class="field">
                    <p class="label">Password</p>
                    <?php echo Form::input("password", '', array( 'type'=>"password", "placeholder"=>"*******", "class"=>"pull-left", "value"=>"" )); ?>   
                    <div class="clearfix"></div>
                </div>   
                <div class="field">
                    <p class="label">Confirm Password</p>
                    <?php echo Form::input("confirm_password", '', array( 'type'=>"password", "placeholder"=>"", "value"=>"" )); ?>   
                      
                </div>   
                <div class="field">
                    <span class="label">Delete My Account</span>
                    <?php if($current_profile->disable == 1){ ?>
                        <input type="checkbox" name="acc_del" checked="checked" />
                    <?php } else { ?>
                        <input type="checkbox" name="acc_del" />
                    <?php } ?>
                </div>
                <div class="field">
                    <span class="label">Make my profile visible to my friends only</span>
                    <?php if($current_profile->visible_for_friends == 1){ ?>
                        <input type="checkbox" name="visibility" checked="checked" />
                    <?php } else { ?>
                        <input type="checkbox" name="visibility" />
                    <?php } ?>
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
