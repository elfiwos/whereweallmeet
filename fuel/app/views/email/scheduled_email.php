<?php if($show == "Suggested Match"): ?>
    <div id="suggested_matches_container" style="background-color: white;margin: 10px auto;width: 800px;">
        <?php echo Asset::img('pages/home2/color.jpg', array('class' => 'header-top', "style" => "border: 0 none;vertical-align: top;width: 100%;")); ?>
        <div id="logo-container" style="margin-bottom: 30px;margin-top: 30px;text-align: center;">
            <?php echo Html::anchor(Uri::base(), Asset::img("logo_main_2.png")); ?>
        </div>
        <?php if ($suggested_matches): ?>
            <div id="suggested_matches" class="clearfix" style="margin:0 auto;width: 607px;">
                <?php foreach ($suggested_matches as $suggested_match): ?>
                    <?php if ($suggested_match['group_id'] != 5 && !Model_Profile::is_deleted_account($suggested_match['id']) && !Model_Friendship::are_friends($profile->id, $suggested_match['id']) && !Model_Dislike::is_member_disliked($profile->id, $suggested_match['id'])): ?>
                        <div class="match" style="border: 1px solid #e8e8e8;float: left;font-family: arial;font-size: 13px;line-height: 20px;margin-bottom: 15px;margin-right: 15px;padding: 10px;width: 165px;height: 187px;">
                            <div class="user-image"><?php echo Html::anchor(Uri::create('profile/public_profile/' . $suggested_match['id']), Html::img(Model_Profile::get_picture($suggested_match['picture'], $suggested_match['user_id'], "profile_medium"))); ?></div>
                            <div class="caption" style="color: #37a7cc;font-weight: bold;"><?php echo Model_Profile::get_username($suggested_match['user_id'],18) ?></div>
                            <div class="location-caption" style="color: #737373;"><?php echo substr($suggested_match['city'],0,19) . ' ' . $suggested_match['state'] ?></div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
        <?php endif; ?>
        <div id="bottom-container" style="margin-top: 30px;padding-bottom: 30px;text-align: center;">
            <?php echo Html::anchor(Uri::base(), "WhereWeAllMeet.com © 2013-2015 WhereWeAllMeet, LLC,", array("style" => "color: #737373;display: block;font-family: arial;font-size: 13px;margin-bottom: 10px;text-decoration: none;")); ?>
            <?php echo Html::anchor(Uri::base()."profile/my_notification", "You can adjust your email settings or unsubscribe here.", array("style" => "color: #737373;display: block;font-family: arial;font-size: 13px;margin-bottom: 10px;text-decoration: none;")); ?>
        </div>
    </div>
<?php endif; ?>
<?php if($show == "Events"): ?>
    <div style="background-color: white;margin: 10px auto;width: 800px;">
        <?php echo Asset::img('pages/home2/color.jpg', array('class' => 'header-top', "style" => "border: 0 none;vertical-align: top;width: 100%;")); ?>
        <div id="logo-container" style="margin-bottom: 30px;margin-top: 30px;text-align: center;">
            <?php echo Html::anchor(Uri::base(), Asset::img("logo_main_2.png")); ?>
        </div>
        <?php if ($active_events): ?>
            <div class="clearfix" style="margin:0 auto;width: 678px;">
                <?php foreach ($active_events as $event): ?>
                    <div class="event" style="border: 1px solid #e8e8e8;float: left;font-family: arial;font-size: 13px;line-height: 20px;margin-bottom: 15px;margin-right: 15px;padding: 10px;width: 301px;height: 271px;">
                        <div class="image-holder">
                            <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $event['slug']) ?>">
                                <?php if(empty($event['photo'])): ?>
                                    <img src="temp/event_thumb.jpg" />
                                <?php else: ?>
                                    <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_featured_'.$event['photo'] ?>" />
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="event-caption-wrapper">
                            <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $event['slug']) ?>"><i class="event-forward"></i></a>
                            <p title="<?php echo $event['title'];  ?>" class="event-caption-top"><?php echo Str::truncate($event['title'], 30); ?></p>
                            <p class="event-caption-bottom"><?php echo $event['start_date'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
        <?php endif; ?>
        <div id="bottom-container" style="margin-top: 30px;padding-bottom: 30px;text-align: center;">
            <?php echo Html::anchor(Uri::base(), "WhereWeAllMeet.com © 2013-2015 WhereWeAllMeet, LLC,", array("style" => "color: #737373;display: block;font-family: arial;font-size: 13px;margin-bottom: 10px;text-decoration: none;")); ?>
            <?php echo Html::anchor(Uri::base()."profile/my_notification", "You can adjust your email settings or unsubscribe here.", array("style" => "color: #737373;display: block;font-family: arial;font-size: 13px;margin-bottom: 10px;text-decoration: none;")); ?>
        </div>
    </div>
<?php endif; ?>
