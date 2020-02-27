<div id="content" class="clearfix">
  <div class="inner-wrapper">
    <div class="section-title">
        <h3>Request</h3>
        <p>See who wants to be your friend / chat now!</p>
        <div class="border-icon4"></div>
        <div class="clearfix"></div>
    </div>

    <div id="middle">

        <div class="sub-nav">
        <ul>
            <li><div id="incoming"><a href="#" class="active" ><i class="inbox-icon"></i> Inbox</a></div> </li>
            <li><div id="outgoing"><a href="#"><i class="sent-icon" id="sent"></i> Sent</a></div></li>
        </ul>
            <div class="clearfix"></div>
        </div>
        
    <div id='incoming-request'>
        <div class="message-wrapper inbox-wrapper">
        <?php if(isset($friend_request)){ ?>
            <?php if(count($friend_request) == 0 ){ ?>
                <p class="no-data-message"><?php echo "No friend request sent for you!" ?></p>
            <?php } ?>
        <?php foreach($friend_request as $request) { ?>
            <div id="<?php echo "request-container-" . $request['id']; ?>" class="message">
                <div class="pull-left online-status">
                    <?php echo Asset::img('online_dot.png', array('class' => '')); ?>
                </div>
                <div class="pull-left user-avatar">
                   <?php echo Html::anchor(Uri::create('profile/public_profile/' . $request['id']), Html::img(Model_Profile::get_picture($request['picture'], $request['user_id'], "members_medium"))); ?>
                </div>
                <div class="pull-left user-info">
                    <p class="name"><?php echo Model_Profile::get_username($request['user_id']); ?></p>
                    <p class="sub"><?php echo $request['address'];?></p>
                    <p class="bottom gray"><?php echo $request['city']. ' '.$request['state'] ;?></p>
                </div>
                <div class="pull-left vertical-separtor"></div>
                <div class="pull-left message-date">
                    <p class="info">Has sent you a friend request</p>
                    <p class="date"><?php echo date("F-d-Y", time($request['created_at']));?></p>

                    <div class="btns clearfix">
                        <?php echo Form::open(array("id" => "friendship-form", "action" => "friendship/update", "class" => "clearfix")) ?>
                            <p class="accept-request">
                                <?php echo Asset::img("accept.png"); ?>
                                <?php echo Html::anchor("#", "ACCEPT", array("class" => "a-none", "data-sender-id" => $request['id'], "data-receiver-id" => $current_profile->id, "data-action" => Uri::create('friendship/update'), "data-request-container" => "request-container-" . $request['id'], "data-friendship-status" => Model_Friendship::STATUS_ACCEPTED)); ?>
                            </p>
                            <p class="reject-request">
                                <?php echo Asset::img("reject.png"); ?>
                                <?php echo Html::anchor("#", "DECLINE", array("class" => "a-none", "data-sender-id" => $request['id'], "data-receiver-id" => $current_profile->id, "data-action" => Uri::create('friendship/update'), "data-request-container" => "request-container-" . $request['id'], "data-friendship-status" => Model_Friendship::STATUS_REJECTED)); ?>
                            </p>
                        <?php echo Form::close(); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php } } ?>
        </div>
    </div>

    <div id="outgoing-request">

    <div class="message-wrapper sent-wrapper">
      <?php if(isset($request_sent)){ ?>
          <?php if(count($request_sent) == 0 ){ ?>
              <p class="no-data-message"><?php echo "No friend request sent!" ?></p>
          <?php } ?>
        <?php foreach($request_sent as $sent) { ?>

        <?php  $receiver = Model_Profile::Find($sent['receiver_id']); ?>
            <div id="<?php echo "request-container-" . $sent['id']; ?>" class="message">
                <div class="pull-left online-status">
                    <?php echo Asset::img('online_dot.png', array('class' => '')); ?>
                </div>
                <div class="pull-left user-avatar">
                   <?php echo Html::anchor(Uri::create('profile/public_profile/' . $receiver['id']), Html::img(Model_Profile::get_picture($receiver['picture'], $receiver['user_id'], "members_medium"))); ?>
                </div>
                <div class="pull-left user-info">
                    <p class="name"><?php echo Model_Profile::get_username($receiver['user_id']); ?></p>
                    <p class="sub"><?php echo $receiver['address'];?></p>
                    <p class="bottom gray"><?php echo $receiver['city']. ' '.$receiver['state'] ;?></p>
                </div>
                <div class="pull-left vertical-separtor"></div>
                <div class="pull-left message-date">
                    <p class="info">You sent a Friend Request</p>
                    <p class="date"><?php echo date("F, Y", time($sent['created_at']));?></p>

                    <p class="btns">
                    <?php if($sent['status'] ==='sent'){?>
                       <button class="request-btn"> <?php echo'Pending Request';?></button>
                    <?php } elseif($sent['status'] ==='accepted'){ ?>
                      <button class="request-btn"> <?php echo'Request Accepted';?></button>
                    <?php }else{ ?>
                       <button class="request-btn"> <?php echo'Request Rejected';?></button>
                    <?php } ?>
                    </p>

                </div>
                <div class="pull-right message-del">
                    <?php echo Html::anchor("#", "X", array("class" => "", "data-sender-id" => $current_profile->id, "data-receiver-id" => $sent['receiver_id'], "data-action" => Uri::create('friendship/update'), "data-request-container" => "request-container-" . $sent['id'], "data-friendship-status" => Model_Friendship::STATUS_REJECTED)); ?>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php } } ?>
        </div>
    </div>  

    </div>

    <aside id="right-sidebar">

        <div class="upper">
            <?php echo Asset::img('temp/event-sidebar.jpg', array('class' => '')); ?>
            <div class="text">
                <h3>WhereWeAllMeet.com Events</h3>
                <p class="gray"><strong>Connect with others to go to plays, sporting events, concerts, etc. </strong></p>
                <br/>
                <p class="gray"><strong>Whatever they like and with someone who wants to do the same thing.</strong></p>
            </div>
            <div class="form">
                <h3 class="green">Find Your Event</h3>
                <form action='<?php echo Uri::create('event/search');?>' method="POST">
                    <select name="location">
                        <option value="" >Event Location:</option>
                        <?php if($active_event_states):  ?>
                            <?php foreach ($active_event_states as $state): ?>
                                <option><?php echo $state["state"] ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <input type="text" id = "datepicker" name="from" placeholder="From" />
                    <input type="text" id = "datepicker2" name="to" placeholder="To" />

                    <input type="submit" name="search" value="Search" />
                </form>
            </div>
        </div>

        <div class="lower">
            <?php echo Asset::img('temp/event-operator.jpg', array('class' => '')); ?>
            <div class="inner-content">
                <p><strong>Let Us help</strong></p>
                <p class="sub-text"><strong>Upgrade to connect to our dating agents.</strong></p>
                <div class="btn-con"><a class="upgrade-btn pink-btn" href="<?php echo Uri::create("agent") ?>">Upgrade Now</a></div>
            </div>
        </div>
        
    </aside>
    <div class="clearfix"></div>
    <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
    <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
</div>
</div>
<!-- end of content -->
<script>
    $(function() {
        $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
    $(function() {
        $( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
</script>