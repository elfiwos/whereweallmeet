<div id="content" class="clearfix">
    <div class="inner-wrapper" style = "width: 980px; !important;padding-bottom: 10px;!important">
        <div class="section-title">
            <h3>Latest Date Ideas</h3>
            <p>Break the Ice with an unforgettable first date!</p>
            <div class="getaway-icon"></div>
            <div class="clearfix"></div>
        </div>

        <?php if (isset($event) and $event !== false): ?>
            <div class="detail-content" style = "width: 970px; !important">
                <div class="col1 pull-left">
                    <a href="<?php echo \Fuel\Core\Uri::create('package/view/' .  $event['id']) ?>">
                        <?php if (empty($event['picture'])): ?>
                            <?php echo Asset::img('temp/event_thumb.jpg'); ?>
                        <?php else: ?>
                            <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/packages/event_list_' . $event['picture'] ?>" />
                        <?php endif; ?>
                    </a>


                    <div class="inner-content">
                        <p>Who wants to go with me? </p>
                        <form id="friend-date-idea-invite" method="POST" action="<?php echo Uri::create('package/invite_a_friend');?>">
                            <input type="hidden" name="event_id" value="<?php echo $event['id'];?>">
                            <select name="location"  onchange="document.getElementById('location').value=this.options[this.selectedIndex].text; document.getElementById('idValue').value=this.options[this.selectedIndex].value;" >
                                <option value="" >Select your friends from list</option>
                                <?php foreach ($my_friends as $friend) : ?>
                                    <?php $friend_username = Model_Profile::get_username($friend->user_id) ?>
                                    <option value="<?php echo $friend_username; ?>"><?php echo $friend_username; ?></option>
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
                        <a href="<?php echo $event['url'] ?>" target="_blank">BOOK EVENT</a>
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
                No date idea found from your location.
            </div>
        <?php endif; ?>

      

        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>

    </div>
  <p class="go-back"><a href="<?php echo \Fuel\Core\Uri::create('package/index') ?>"><< back to all Date Ideas</a>
<br> <br> <br> <br> <br> <br>