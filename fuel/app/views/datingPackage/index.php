<div id="content" class="clearfix">
  <div class="inner-wrapper">
    <div class="section-title">
        <h3>Latest Date Ideas</h3>
        <p>Break the Ice with an unforgettable first date!</p>
        <div class="border-icon4"></div>
        <div class="clearfix"></div>
    </div>

    <div id="middle">
        <?php if (isset($active_datingPackages) and $active_datingPackages !== false): ?>
            <div id="event-list-container">
                <?php foreach ($active_datingPackages as $packages): ?>
                <div class="content-item">
                    <div class="image pull-left">
                        <a href="<?php echo \Fuel\Core\Uri::create('package/view/' . $packages['id']) ?>">
                            <?php if (empty($packages['picture'])): ?>
                                <?php echo Asset::img('temp/event_thumb.jpg'); ?>
                            <?php else: ?>
                                <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/packages/event_list_' . $packages['picture'] ?>" />
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="decription pull-left">
                        <p class="title"><?php echo $packages['title'] ?></p>
                        <p class="location"><span class="gray">Located:</span><?php echo $packages['city'] . ', '. $packages['state']; ?></p>
                        <p class="date"><?php echo $packages['start_date'] ?></p>
                        <p class="detail gray"><?php echo $packages['short_description'];  ?></p>
                        <?php echo Html::anchor('package/view/' . $packages['id'], 'View Date Idea', array('class' => 'btn-detail')); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php if(count($active_datingPackages)> 10): ?>
                <div class="btn-holder">
                    <a class="more-events" data-count="<?php echo count($active_datingPackages); ?>" href="#">More Events</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="event-list clearfix" id="no-event">
                No date idea found from your location.
            </div>
        <?php endif; ?>

    </div>

    <aside id="right-sidebar">

        <div class="upper">
            <div class="text">
                <h3>Do you have a date idea?</h3>
            </div>
            <div class="form">
               <form id="date-idea-invitation-form" method="POST" action="<?php echo Uri::create('package/date_idea_invitation');?>">
                    <textarea name='idea' placeholder='type your ideas here'></textarea>
                    <p class="title pink">Select Your Friend</p>
                    <select name="friend">
                        <option value="">Name of Friend</option>
                        <?php foreach ($friends as $friend): ?>
                            <option value="<?php echo Model_Profile::get_username($friend->user_id); ?>"><?php echo Model_Profile::get_username($friend->user_id); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" name="search" value="Send to Friend" />
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
    <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
    <div class="border-circle border-circle-3"><?php echo Asset::img('line_end.png'); ?></div>
</div>

</div> <!-- end of content -->