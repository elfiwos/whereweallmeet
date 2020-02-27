<div id="content" class="clearfix">

    <div id="middle">


        <div id="messages_header"> 
            <h2 class="pull-left">Messages Compose</h2>
            <p class="pull-right">
                <span class="small"><u>Want to start a conversation?</u></span>
                <a class="compose"><i class="compose-icon"></i><span>Compose</span></a>
            </p>
            <div class="clearfix"></div>
        </div>

        <div class="sub-nav">
        <ul  class="nav nav-pills">
            <li><?php echo \Fuel\Core\Html::anchor('message/index', '<i class="inbox-icon"></i> Inbox',array('class' => 'active')) ?>   </li>
            <li><?php echo \Fuel\Core\Html::anchor('message/sent', '<i class="sent-icon"></i> Sent',array('class' => 'active')) ?></li>
            <li ><?php echo \Fuel\Core\Html::anchor('message/trash_total', '<i class="trash-icon"></i> Trash',array('class' => 'active')) ?></li>
        </ul>
            <div class="clearfix"></div>
        </div>
              

               <form action='<?php echo Uri::create('message/compose');?>' method="post">
               <div class="event-list">
                    <input type="hidden" name="to_email" value="">
                    <select name="to_member_id"  onchange="document.getElementById('to_member_id').value=this.options[this.selectedIndex].text; document.getElementById('idValue').value=this.options[this.selectedIndex].value;" >
                                              
					   <option > </option>
                        
						<?php if($current_profile->id==$profileid[0]['id'] AND $membertypeid[0]['member_type_id']!=3 ):   ?>
						<option > All </option>
				      <?php foreach ($friendship as $friend): ?>
                            <?php if ($friend->sender_id == $resultsprofile[0]['id']): ?>
                                <?php if ($friend->status == 'accepted'): ?>
                                    <option>
                                        <?php foreach ($users as $user): ?>
                                            <?php foreach ($profiles as $profile): ?>
											   <?php if ($friend->receiver_id == $profile->id): ?>   
                                                    <?php if ($user->id == $profile->user_id): ?>                
                                                        <?php echo $user->username; ?>  
                                                   <?php endif; ?>
											  <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </option>
                                <?php endif; ?>
                            <?php elseif ($friend->receiver_id == $resultsprofile[0]['id']): ?>
                                <?php if ($friend->status == 'accepted'): ?>
                                    <option>
                                        <?php foreach ($users as $user): ?>
                                            <?php foreach ($profiles as $profile): ?>
											    <?php if ($friend->sender_id == $profile->id): ?>   
                                                    <?php if ($user->id == $profile->user_id): ?>                      
                                                        <?php echo $user->username; ?>  
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
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
                    <div id='username_availability_result'></div>
                    <div>
                    <input type="text" name="subject" placeholder=" Subject:">
                    </div>
                    <div>
                    <textarea name="body" placeholder=" Your messaage will be typed here..."></textarea>
                    
                    </div>
                    <div>
                    <button type="submit" id="check_username_availability" class="upload-button" >Send</button>
                    </div>
                </div>
              </form>
     </div>
        
		  
    </div>
    
</div>
