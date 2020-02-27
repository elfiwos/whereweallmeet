<div id="content" class="clearfix">
  <div id="admin-notification-container" class="clearfix">
      <div id="messages_header"> <h2>Admin Notification</h2></div>
      <form action="notification" method="post">
          <div id="send-to">
              <span>Send To:</span>
              <select name="to_member_id">
                  <option > </option>
                  <option > All </option>
                  <option > Free Members </option>
                  <option > Paid Members </option>
                  <option > Dating Agents </option>
                  <?php foreach($profiles as $profile): ?>
                      <?php if($current_profile->id!=$profile->id): ?>
                          <option value="<?php echo $profile->id; ?>"><?php echo Model_Profile::get_username($profile->user_id); ?></option>
                      <?php endif; ?>
                  <?php endforeach; ?>
              </select>
          </div>
          <div id="message-body">
              <span>Send To:</span>
              <textarea name="body" placeholder=" Your messaage will be typed here..."></textarea>
          </div>
          <input type="submit" id="send-message" name="submit" value="Save" >
      </form>
  </div>
</div>

