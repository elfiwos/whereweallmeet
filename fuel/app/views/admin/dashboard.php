<div id="content" class="clearfix">
  <div id="dashboard-container" class="clearfix">
      <div>
          <p class="title">MEMBERS</p>
          <a href="<?php echo Uri::base() . 'admin/index'; ?>">
              <p class="count"><?php echo $members_count ?></p>
          </a>
      </div>
      <div>
          <p class="title">GET-AWAYS</p>
          <a href="<?php echo Uri::base() . 'admin/index'; ?>">
              <p class="count"><?php echo $getaways_count ?></p>
          </a>
      </div>
      <div>
          <p class="title">EVENTS</p>
          <a href="<?php echo Uri::base() . 'admin/index'; ?>">
              <p class="count"><?php echo $events_count ?></p>
          </a>
      </div>
      <div>
          <p class="title">DATING IDEAS</p>
          <a href="<?php echo Uri::base() . 'admin/index'; ?>">
              <p class="count"><?php echo $date_ideas_count ?></p>
          </a>
      </div>
      <div>
          <p class="title">NOTIFICATIONS</p>
          <a href="<?php echo Uri::base() . 'admin/notification'; ?>">
              <p class="count"></p>
          </a>
      </div>
      <div>
          <p class="title">DATING AGENTS</p>
          <a href="<?php echo Uri::base() . 'admin/index'; ?>">
              <p class="count"><?php echo $dating_agents_count ?></p>
          </a>
      </div>
  </div>
  <div class="banner-ad-button-container">
    <a href="<?php echo Uri::base() . 'admin/bannerAds'; ?>">Banner Ad</a>
  </div>
</div>

