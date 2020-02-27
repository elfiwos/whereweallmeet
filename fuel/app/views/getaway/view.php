<div id="content" class="clearfix">
  <div class="inner-wrapper" style = "width: 980px; !important;padding-bottom: 10px;!important">
        <div class="section-title">
            <h3>Latest GetAways</h3>
            <p>Plan Your Next Vacation Today !</p>
            <div class="getaway-icon"></div>
            <div class="clearfix"></div>
        </div>

          <?php if (isset($getaway) and $getaway !== false): ?>
            <?php //foreach ($active_getaways as $getaway): ?>
                  <div class="detail-content" style = "width: 970px; !important">
                      <div class="col1 pull-left">
                          <a href="<?php echo \Fuel\Core\Uri::create('getaway/view/' .  $getaway['slug']) ?>">
                              <?php if (empty($getaway['photo'])): ?>
                                  <img src="temp/getaway_thumb.jpg" />
                              <?php else: ?>
                                  <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/getaways/getaway_detail_' .  $getaway['photo'] ?>" />
                              <?php endif; ?>
                          </a>
                          <div class="inner-content">
                              <p>Who wants to go with me? </p>
                              <form method="POST" action="<?php echo Uri::create('getaway/invite_a_friend');?>">
                                  <input type="hidden" name="getaway_id" value="<?php echo $getaway['id'];?>">
                                  <select name="location"  onchange="document.getElementById('location').value=this.options[this.selectedIndex].text; document.getElementById('idValue').value=this.options[this.selectedIndex].value;" >
                                      <option value="" >Select your friend from list</option>
                                      <?php $friend_list = Model_Friendship::get_friends($current_profile->id); ?>
                                      <?php foreach ($friend_list as $friend): ?>
                                          <option> <?php echo Model_Profile::get_username($friend->user_id); ?></option>
                                      <?php endforeach; ?>
                                  </select>
                                  <input type="submit" name="search" value="Send Invite" />
                              </form>
                    </div>
                      </div>
                      <div class="col2 pull-left">
                          <p class="title"><?php echo $getaway['title']; ?></p>
                          <p class="location"><span class="gray">LOCATED: </span><?php echo $getaway['city'] . ', '. $getaway['state']; ?></p>
                          <p class="date"><?php echo $getaway['start_date']; ?></p>
                          <p class="gray detail-text"><?php echo $getaway['long_description'];  ?></p>
                          <div class="book-btn-wrap green-bg">
                              <a href="<?php echo $getaway['url'] ?>" target="_blank">BOOK EVENT</a>
                          </div>
                      </div>
                      <div class="clearfix"></div>
                  </div>
                  <?php if(isset($getaway['youtube_video'])):  ?>
                      <div id="youtube-video-container" style = "background-color: #fff;width: 970px;">
                          <embed width="420" height="315" src="<?php echo $getaway['youtube_video']; ?>"></embed>
                      </div>
                  <?php endif; ?>
              <?php //endforeach; ?>
          <?php else: ?>
              <div class="event-list clearfix" id="no-event">
                  No getaway found from your location.
              </div>
          <?php endif; ?>

       
   
    <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
    <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
   
   </div>
 <p class="go-back"><a href="<?php echo \Fuel\Core\Uri::create('getaway') ?>"><< back to all getaways</a>
<br> <br> <br> <br> <br> <br>
<!-- end of detail view of a getaway -->
