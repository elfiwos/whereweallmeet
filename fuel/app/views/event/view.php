<div id="content" class="clearfix">
    <div class="inner-wrapper" style = "width: 980px; !important;padding-bottom: 10px;!important">
        <div class="section-title">
            <h3>Latest Events</h3>
            <p>Plan Your Next Event Today !</p>
            <div class="getaway-icon"></div>
            <div class="clearfix"></div>
        </div>

        <?php if (isset($event) and $event !== false): ?>
            <div class="detail-content" style = "width: 970px; !important">
                <div class="col1 pull-left">
                    <a href="<?php echo \Fuel\Core\Uri::create('event/view/' .  $event['slug']) ?>">
                        <?php if (empty($event['photo'])): ?>
                            <img src="temp/getaway_thumb.jpg" />
                        <?php else: ?>
                            <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/events/event_detail_' .  $event['photo'] ?>" />
                        <?php endif; ?>
                    </a>
                    <div class="inner-content">
                        <p>Who wants to go with me? </p>
<!--            <form id="friend-event-invite" method="POST" action="--><?php //echo Uri::create('event/invite_a_friend');?><!--">-->
                        <form id="friend-event-invite" method="POST" action="<?php echo Uri::create('event/send_event_invite');?>">
                            <input type="hidden" name="event_id" value="<?php echo $event['id'];?>">
                            <input type="hidden" name="refered_by" value="<?php echo $current_profile->id; ?>">

                            <select name="refered_to"  onchange="document.getElementById('location').value=this.options[this.selectedIndex].text; document.getElementById('idValue').value=this.options[this.selectedIndex].value;" >
                                <option value="" >Select your friend from list</option>
                                <option value="<?php echo $current_profile->id ?>"><?php echo $current_user->username ?> </option>
                                <?php $friend_list = Model_Friendship::get_friends($current_profile->id); ?>
                                <?php foreach ($friend_list as $friend): ?>
                                    <option value="<?php echo $friend->id; ?>"> <?php echo Model_Profile::get_username($friend->user_id); ?></option>
                                <?php endforeach; ?>
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
                    <div class="book-btn-wrap green-bg">
                        <a id="book_event" data-action="<?php echo \Fuel\Core\Uri::create('event/book_event') ?>" data-event-id = <?php echo $event['id'] ?> data-member-id = <?php echo $current_profile->id ?> href="<?php echo $event['url'] ?>" target="_blank">
                            BOOK EVENT
                        </a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php if(isset($event['youtube_video'])):  ?>
                <div id="youtube-video-container" style = "background-color: #fff;width: 970px;">
                    <embed width="420" height="315" src="<?php echo $event['youtube_video']; ?>"></embed>
                </div>
            <?php endif; ?>
            <?php //endforeach; ?>
        <?php else: ?>
            <div class="event-list clearfix" id="no-event">
                No Event found from your location.
            </div>
        <?php endif; ?>

       

        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>

    </div>

 <p class="go-back"><a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><< Back to all Events</a>

 <br> <br> <br> <br> <br> <br>