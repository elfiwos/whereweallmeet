<script type="text/javascript">

function checkAll(checkId){
    var inputs = document.getElementsByTagName("input");
    var input = document.getElementById("chk_new");
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].type == "checkbox" && inputs[i].id == checkId) {
            if(input.checked == false) {
                inputs[i].checked = false ;
            } else if (input.checked == true ) {
                inputs[i].checked = true ;
            }
        } 
    } 
}

</script>

<div id="content" class="clearfix">
                    <div class="sub-nav">
                    <ul  class="nav nav-pills">
                        <li><?php echo \Fuel\Core\Html::anchor('admin/index', 'Members Privilege',array('class' => 'active-link')) ?>   </li>
                        <li><?php echo \Fuel\Core\Html::anchor('admin/event_plan', 'Event Planning') ?></li>
                        <li><?php echo \Fuel\Core\Html::anchor('admin/dating_packages', 'Date Ideas') ?></li>
                        <li><?php echo \Fuel\Core\Html::anchor('admin/getaways', 'Get-Aways') ?></li>
                    </ul>
                </div>
				<div id="main">
				   <div id="submain">
			        <div class="allcontent">
					<form name=myform  method=post action = "index">
					    <div id="search-field-container">
                            <input type="text" name="searchbox" size="90" placeholder="Search by username or email" value=""/>
                            <input name="submit1" type="submit" value="Search">
					    </div>
                        <ul  class="nav nav-pills">
                            <li><input type="checkbox" id="chk_new"  name="CheckAll" onclick="checkAll('list');"></li>
                            <li class="member-name">Name</li>
                            <li class="promo-code">Promo Code</li>
                            <li class="date-joined">Date Joined</li>
                            <li class="membership-status">Membership</li>
                            <li class="blocked-status">Blocked</li>
                            <li class="deleted-status">Deleted</li>
                        </ul>
					<div id="content-members">
					<?php foreach($profiles as $profile): ?>
                        <span id="personal">
                            <div id="box">
                                <input type="checkbox" id="list" name="list[<?php echo $profile->id; ?>]" value=<?php echo $profile->id; ?>>
                            </div>
                            <div id="profile-picture">
                                <?php echo Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium")); ?>
                                <p><?php echo Model_Profile::get_username($profile->user_id); ?></p>
                            </div>
                            <div id="name">
                                <?php echo $profile->first_name . ' ' . $profile->last_name; ?>
                            </div>
                            <div id="promo-code">
                                <?php echo $profile->promo_code; ?>
                            </div>
                            <div id="joined">
                                <?php echo date("Y-m-d",$profile->created_at); ?>
                            </div>
                            <input name="id[]" type="hidden" value=<?php echo $profile->id; ?>  >
                           <div id="member-status">
                              <select name='membertype[<?php echo $profile->id ?>]' >
                                <?php foreach($membershiptype as $member): ?>
                                    <option value=<?php echo $member->id; ?> <?php echo ($member->id == $profile->member_type_id)? 'selected' : '' ;?>><?php echo $member->name; ?> </option>
                                <?php endforeach; ?>
                              </select>
                           </div>
                           <div id="is-blocked">
                               <?php echo $profile->is_blocked == 1 ? "Yes" : "No"; ?>
                           </div>
                            <div id="is-deleted">
                                <?php echo $profile->disable == 1 ? "Yes" : "No"; ?>
                            </div>
                            <div id="subscription-date-container" class="clearfix">
                                <span>Subscription Date</span>
                                <?php echo \Fuel\Core\Form::input('subscription_date['. $profile->id . ']', $profile->subscription_date==''? "" :date("Y-m-d",$profile->subscription_date), array('id'=>'subscription-date-'.$profile->id, 'class'=>'date-picker'))?>
                                <span>Subscription Expiry Date</span>
                                <?php echo \Fuel\Core\Form::input('subscription_expiry_date['. $profile->id . ']', $profile->subscription_expiry_date==''? "" :date("Y-m-d",$profile->subscription_expiry_date), array('id'=>'subscription-expiry-date'.$profile->id, 'class'=>'date-picker'))?>
                            </div>
                        </span>
                    <?php endforeach; ?>
					 
					 </div>
					 <div id="save-members">
					  <input type="submit" id="save" name="submit1" value="Save" >
					  <input type="submit" id="delete" name="submit1" value="Delete" >
                      <input type="submit" id="block" name="submit1" value="Block" >
					
					  <p id="page-container">
                          <?php echo Pagination::instance('mypagination')->previous(); ?>
                          <?php  echo Pagination::instance('mypagination')->pages_render(); ?>
                          <?php  echo Pagination::instance('mypagination')->next(); ?>
					  </p>
					  </div>
					  </form>
					 </div>
               </div>					
				</div>
        
</div>

