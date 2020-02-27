<div id="content" class="clearfix">
  <div class="inner-wrapper inner-wrapper-getaway">
    <div class="section-title section-title-getaway">
        <div class="border-icon4 border-icon4-getaway"></div>
        <h3>Latest Get-Aways</h3>
        <p>Plan your next vaccation Today and Invite Friends!</p>
        <div class="clearfix"></div>
    </div>

    <div id="middle">
        <?php if (isset($active_getaways) and $active_getaways !== false): ?>
            <?php foreach ($active_getaways as $getaway): ?>
                <div class="content-item">
                    <div class="image pull-left">
                        <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $event['slug']) ?>">
                            <?php if (empty($getaway['photo'])): ?>
                                <img src="temp/event_thumb.jpg" />
                            <?php else: ?>
                                <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/events/event_list_' . $event['photo'] ?>" />
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="decription pull-left">
                        <p class="title"><?php echo $getaway['title'] ?></p>
                        <p class="location"><span class="gray">Located:</span><?php echo $getaway['city'] . ', '. $getaway['state']; ?></p>
                        <p class="date"><?php echo $getaway['start_date'] ?></p>
                        <p class="detail gray"><?php echo $getaway['short_description'];  ?></p>
                        <?php echo Html::anchor('event/view/' . $getaway['slug'], 'View Get-Away', array('class' => 'btn-detail-getaway')); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php endforeach; ?>
            <div class="btn-holder"><a class="" href="#">More GetAways</a></div>
        <?php else: ?>
            <div class="event-list clearfix" id="no-event">
                No getaway found from your location.
            </div>
        <?php endif; ?>

    </div>

    <aside id="right-sidebar">

        <div class="upper">
            <div class="text">
                <h3 class="getaway-side-title">Recommended Get-Aways</h3>

                <div class="rec-getaway">
                  <div class="getaway-thmb"><?php echo Asset::img('temp/getaway-thumb.jpg', array('class' => '')); ?></div>
                  <div class="getaway-detl">
                      <h4>Name of Get...</h4>
                      <p class="getway-locn">Las vegas nevada</p>
                      <p><a class="btn-detail getaway-btn-detail" href="#">Preview</a></p>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="rec-getaway">
                  <div class="getaway-thmb"><?php echo Asset::img('temp/getaway-thumb.jpg', array('class' => '')); ?></div>
                  <div class="getaway-detl">
                      <h4>Name of Get...</h4>
                      <p class="getway-locn">Las vegas nevada</p>
                      <p><a class="btn-detail getaway-btn-detail" href="#">Preview</a></p>
                  </div>
                  <div class="clearfix"></div>
                </div>

            </div>
            <div class="form getaway-form">
                <form method="POST">
                    
                    <p class="title pink">Select Your Friend</p>
                    <select name="friend">
                        <option value="" >Name of Friend</option>
                    </select>

                    <input type="submit" name="search" class="blue-btn"  value="Send to Friend" />
                </form>
            </div>
        </div>

        <div class="lower">
            <?php echo Asset::img('temp/date-operator.jpg', array('class' => '')); ?>
            <div class="inner-content">
                <p><strong>Let Us help</strong></p>
                <p class="sub-text"><strong>Upgrade to connect to our dating agents.</strong></p>
                <div class="btn-con"><a class="upgrade-btn yellow-btn" href="<?php echo Uri::create("agent") ?>">Upgrade Now</a></div>
            </div>
        </div>
        
    </aside>
    <div class="clearfix"></div>
    <div class="border-circle border-circle-0"><?php echo Asset::img('line_end.png'); ?></div>
    <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
    <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
</div>

</div> <!-- end of content -->

<!-- The below code is to display detail  view of an event, i wrote it on this page cuz I dont know the VIEW file, 
please move it to its respective view file, and its CSS can be found on events.css at the bottom part (commented on CSS)-->
<!-- detail view of an event -->
<div id="content" class="detail-view clearfix">

  <div class="inner-wrapper inner-wrapper-getaway">
    <div class="section-title section-title-getaway">
        <div class="border-icon4 border-icon4-getaway"></div>
        <h3>Latest Get-Aways</h3>
        <p>Plan your next vaccation Today and Invite Friends!</p>
        <div class="clearfix"></div>
    </div>

          <?php if (isset($active_getaways) and $active_getaways !== false): ?>
              <?php foreach ($active_getaways as $getaway): ?>
                  <div class="detail-content">
                      <div class="col1 pull-left">
                          <a href="<?php echo \Fuel\Core\Uri::create('event/view/' .  $getaway['slug']) ?>">
                              <?php if (empty($getaway['photo'])): ?>
                                  <img src="temp/event_thumb.jpg" />
                              <?php else: ?>
                                  <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/events/event_detail_' .  $getaway['photo'] ?>" />
                              <?php endif; ?>
                          </a>
                          <div class="inner-content inner-content-getaway">
                              <p>Who wants to go with me? </p>
                              <form method="POST">
                                  <select name="location">
                                      <option value="" >Select your friends from list</option>
                                  </select>
                                  <input type="submit" name="search" value="Send Invite" />
                              </form>
                          </div>
                      </div>
                      <div class="col2 pull-left">
                          <p class="title"><?php echo $event['title']; ?></p>
                          <p class="location"><span class="gray">LOCATED: </span><?php echo $event['city'] . ', '. $event['state']; ?></p>
                          <p class="date"><?php echo $event['start_date']; ?></p>
                          <p class="gray detail-text"><?php echo $event['long_description'];  ?></p>
                          <div class="book-btn-wrap blue-bg">
                              <a href="#">BOOK GET-AWAY</a>
                          </div>
                      </div>
                      <div class="clearfix"></div>
                  </div>
              <?php endforeach; ?>
          <?php else: ?>
              <div class="event-list clearfix no-getaway" id="no-event">
                  No Get-Away found from your location.
              </div>
          <?php endif; ?>

        <p class="go-back"><a href="<?php echo \Fuel\Core\Uri::create('getaway') ?>"><< back to all Get-Aways</a>
    <div class="border-circle border-circle-0"><?php echo Asset::img('line_end.png'); ?></div>
    <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
    <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
   
   </div>
</div>
<!-- end of detail view of an event -->