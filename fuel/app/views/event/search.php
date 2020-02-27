<div id="content" class="clearfix">
    <div class="inner-wrapper">
        <div class="section-title">
            <h3>Event Search Result</h3>
            <div class="border-icon4"></div>
            <div class="clearfix"></div>
        </div>

        <div id="middle">
            <?php if (isset($events) and $events !== false): ?>
                <div id="event-list-container">
                    <?php foreach ($events as $event): ?>
                        <div class="content-item">
                            <div class="image pull-left">
                                <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $event['slug']) ?>">
                                    <?php if (empty($event['photo'])): ?>
                                        <img src="temp/event_thumb.jpg" />
                                    <?php else: ?>
                                        <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/events/event_list_' . $event['photo'] ?>" />
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="decription pull-left">
                                <p class="title"><?php echo $event['title'] ?></p>
                                <p class="location"><span class="gray">Located:</span><?php echo $event['city'] . ', '. $event['state']; ?></p>
                                <p class="date"><?php echo $event['start_date'] ?></p>
                                <p class="detail gray"><?php echo $event['short_description'];  ?></p>
                                <?php echo Html::anchor('event/view/' . $event['slug'], 'View Event', array('class' => 'btn-detail')); ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if(count($events)> 10): ?>
                    <div class="btn-holder">
                        <a class="more-events" data-count="<?php echo count($events); ?>" href="#">More Events</a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="event-list clearfix" id="no-event">
                    No event found for your search.
                </div>
            <?php endif; ?>

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

</div> <!-- end of content -->

<script>
    $(function() {
        $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
    $(function() {
        $( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
</script>