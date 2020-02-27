<div id="content" class="clearfix">
  <div class="inner-wrapper">
    <div class="section-title">
        <h3>Latest GetAways</h3>
        <p>Plan Your Next Vacation Today !</p>
        <div class="getaway-icon"></div>
        <div class="clearfix"></div>
    </div>

    <div id="middle">
        <?php if (isset($active_getaways) and $active_getaways !== false): ?>
            <div id="event-list-container">
                <?php foreach ($active_getaways as $getaway): ?>
                <div class="content-item">
                    <div class="image pull-left">
                        <a href="<?php echo \Fuel\Core\Uri::create('getaway/view/' . $getaway['slug']) ?>">
                            <?php if (empty($getaway['photo'])): ?>
                                <img src="temp/getaway_thumb.jpg" />
                            <?php else: ?>
                                <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/getaways/getaway_list_' . $getaway['photo'] ?>" />
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="decription pull-left">
                        <p class="title"><?php echo $getaway['title'] ?></p>
                        <p class="location"><span class="gray">Located:</span><?php echo $getaway['city'] . ', '. $getaway['state']; ?></p>
                        <p class="date"><?php echo $getaway['start_date'] ?></p>
                        <p class="detail gray"><?php echo \Fuel\Core\Str::truncate($getaway['short_description'], 165);  ?></p>
                        <?php echo Html::anchor('getaway/view/' . $getaway['slug'], 'View Get-Away', array('class' => 'btn-detail-getaway')); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php if(count($active_getaways)> 10): ?>
                <div class="btn-holder">
                    <a class="more-events" data-count="<?php echo count($active_getaways); ?>" href="#">More Get-Aways</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="event-list clearfix" id="no-event">
                No getaway found from your location.
            </div>
        <?php endif; ?>

    </div>

    <aside id="right-sidebar">

        <div class="upper">
            <?php echo Asset::img('temp/event-sidebar.jpg', array('class' => '')); ?>
            <div class="text">
                <h3>WhereWeAllMeet.com GetAways</h3>
                <p class="gray"><strong>Connect with others to go to plays, sporting events, concerts, etc. </strong></p>
                <br/>
                <p class="gray"><strong>Whatever they like and with someone who wants to do the same thing.</strong></p>
            </div>
            <div class="form">
                <h3 class="blue">Find Your Perfect GetAway</h3>
                <form action='<?php echo Uri::create('getaway/search');?>' method="POST">
                    <select name="location">
                        <option value="" >GetAway Location:</option>
                        <?php if($countries):  ?>
                            <?php foreach ($countries as $country): ?>
                                <option><?php echo $country->name ?></option>
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

<script>
    $(function() {
        $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
    $(function() {
        $( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
</script>