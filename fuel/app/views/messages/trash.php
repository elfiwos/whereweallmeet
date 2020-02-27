<div id="compose-popup-container" onclick="check(event)" >
         <a  id="close"><?php echo Asset::img("close1.png"); ?></a>

          <div id= "compose-popup">
         <button class="compose"> <i class="compose-icon"></i>Compose</button>
            <form action='<?php echo Uri::create('message/compose');?>' method="post">
               <div class="event-list">
                    <input type="hidden" name="from_member_id" value="">
                <div class="message-entry">
                    <select name="to_member_id"  onchange="document.getElementById('to_member_id').value=this.options[this.selectedIndex].text; document.getElementById('idValue').value=this.options[this.selectedIndex].value;" >
                                              
                       <option > </option>

                        <?php if($current_profile->member_type_id == 1 ):   ?>
                            <!--                            <option > All </option>-->
                            <?php $friend_list = Model_Friendship::get_friends($current_profile->id); ?>
                            <?php $objInviter = Model_Invitedmember::find('first', array("where" => array(array("member_id", $current_profile->id)))) ?>
                            <?php if (($friend_list !== false)):
                                foreach ($friend_list as $friend): ?>
                                    <?php if($objInviter && $objInviter->inviter_id == $friend->id): ?>
                                        <option> <?php echo Model_Profile::get_username($friend->user_id); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; endif; ?>
                        <?php elseif($current_profile->member_type_id!=3 ):   ?>
                        <option > All </option>
                            <?php $friend_list = Model_Friendship::get_friends($current_profile->id); ?>
                            <?php if (($friend_list !== false)):
                                foreach ($friend_list as $friend):
                                    ?>
                                    <option> <?php echo Model_Profile::get_username($friend->user_id); ?></option>
                                <?php endforeach;
                            endif; ?>
                          <?php else: ?>
                           <option style="font-weight:bold">All Clients</option>
                         
                            <?php foreach($profiles as $profile): ?> 
                            <?php if($current_profile->id!=$profile->id): ?>
                           <option>
                        
                           <?php echo Model_Profile::get_username($profile->user_id)."<br>"; ?>
                         
                       </option>
                         <?php endif; ?>
                         <?php endforeach; ?>
                        <?php endif; ?>
                           
                            </select>
                    </div>
                    <div id='username_availability_result'></div>
                    <div class="message-entry">
                    <input type="text" name="subject" placeholder=" Subject:">
                    </div>
                    <div class="message-entry">
                    <textarea name="body" placeholder=" Your messaage will be typed here..."></textarea>
                    
                    <button type="submit" id="check_username_availability" class="compose" >Send</button>
                    </div>
                </div>
              </form>
            </div>

        </div>
<div id="content" class="clearfix">
    <div id="middle">

        <div id="messages_header"> 
            <h2 class="pull-left">Messages</h2>
            <p class="pull-right">
                <span class="small"><u>Want to start a conversation?</u></span>
                <a class="compose"><i class="compose-icon"></i><span>Compose</span></a>
            </p>
            <div class="clearfix"></div>
        </div>

        <div class="sub-nav">
        <ul  class="nav nav-pills">
            <li><?php echo \Fuel\Core\Html::anchor('message/index', '<i class="inbox-icon"></i> Inbox') ?>   </li>
            <li><?php echo \Fuel\Core\Html::anchor('message/sent', '<i class="sent-icon"></i> Sent') ?></li>
            <li ><?php echo \Fuel\Core\Html::anchor('message/trash_total', '<i class="trash-icon"></i> Trash',array('class' => 'active')) ?></li>
        </ul>
            <div class="clearfix"></div>
        </div>

        <div class="message-wrapper trash-wrapper">

        <?php if ($trash_sent_id OR $trash_inbox_id): ?>  
             <?php foreach ($trash_sent_id as $sent): ?>
                <?php $profile = Model_Profile::find($sent->to_member_id); ?>
                <?php if($profile): ?>
                    <div id="<?php echo "message-container-" . $sent->id; ?>" class="message">
                        <div class="pull-left user-avatar">
                            <?php echo Html::anchor(Uri::create('profile/public_profile/' . $sent->to_member_id), Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium"))); ?>
                        </div>
                        <div class="pull-left user-info">
                            <p class="name"><?php echo Model_Profile::get_username($profile->user_id); ?></p>
                            <p class="sub"><?php echo $profile->address ; ?></p>
                            <p class="bottom gray"><?php echo $profile->city . ' , '. $profile->state ;?></p>
                        </div>
                        <div class="pull-left vertical-separtor">  </div>
                        <div class="pull-left message-intro">
                            <p class="message-subject"><a><?php echo $sent->subject ;?></a></p>
                            <p class="gray"><?php echo $sent->body; ?></p>
                        </div>
                        <div class="pull-left vertical-separtor"></div>
                        <div class="pull-left message-date">
                            <p class="date"><?php echo date("F-d-Y", strtotime($sent->date_sent));?></p>
                            <p class="time gray"><?php echo date("H:i", strtotime($sent->date_sent));?></p>
                        </div>
                        <div class="pull-right message-del">
                            <?php echo Html::anchor("#", "X", array("class" => "", "data-action" => Uri::create('message/delete_message'), "data-message-container" => "message-container-" . $sent->id, "data-message-id" => $sent->id, "data-message-section" => "trash-sent")); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php foreach ($trash_inbox_id as $inbox): ?>
               <?php $profile = Model_Profile::find($inbox->from_member_id); ?>
                <?php if($profile): ?>
                    <div id="<?php echo "message-container-" . $inbox->id; ?>" class="message">
                <div class="pull-left user-avatar">
                    <?php echo Html::anchor(Uri::create('profile/public_profile/' . $inbox->from_member_id), Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium"))); ?>
                </div>
                <div class="pull-left user-info">
                    <p class="name"><?php echo Model_Profile::get_username($profile->user_id); ?></p>
                    <p class="sub"><?php echo $profile->address ; ?></p>
                    <p class="bottom gray"><?php echo $profile->city . ' , '. $profile->state ;?></p>
                </div>
                <div class="pull-left vertical-separtor">  </div>
                <div class="pull-left message-intro">
                    <p class="message-subject"><a><?php echo $inbox->subject ;?></a></p>
                    <p class="gray"><?php echo $inbox->body; ?></p>
                </div>
                <div class="pull-left vertical-separtor"></div>
                <div class="pull-left message-date">
                    <p class="date"><?php echo date("F-d-Y", strtotime($inbox->date_sent));?></p>
                    <p class="time gray"><?php echo date("H:i", strtotime($inbox->date_sent));?></p>
                </div>
                <div class="pull-right message-del">
                    <?php echo Html::anchor("#", "X", array("class" => "", "data-action" => Uri::create('message/delete_message'), "data-message-container" => "message-container-" . $inbox->id, "data-message-id" => $inbox->id, "data-message-section" => "trash-inbox")); ?>
                </div>
                <div class="clearfix"></div>
            </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>

             <p>No Messages.</p>
         <?php endif; ?>
        </div>

        <div class="border-icon1"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
    </div>
</div>

