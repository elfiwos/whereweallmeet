<div id="content" class="clearfix referral photos">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <div id="profile-pic"><?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
                <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
            </div>
        </div>
        <?php echo View::forge("profile/partials/profile_nav"); ?>
    </aside>
    <div id="middle" class="referal-middle">
        <section id="latest-members">
              <div class="header-section">
                  <p class="header-text">My Photos</p>
              </div>
                
            <div class="content">
                 <div class="photos-upper">
                     <div id='upload-section'>
                        <?php echo Form::open(array("action" => "profile/upload_photo", "enctype" => "multipart/form-data", "class" => "clearfix")) ?>
                            <div id="upper-content">
                                <p>Upload Photo</p>
                                <p id="profile-photo-select">
                                    <input hidden="true" type="file" id="profile-picture" name="picture" size="1"/>
                                    <a id="profile-upload-button" class="upload-button">Browse</a>
                                    <span>No file selected</span>
                                </p>
                            </div>
                            <div id="middle-content">
                                <img id="profile-photo-preview"/>
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="w" name="w" />
                                <input type="hidden" id="h" name="h" />
                            </div>
                            <div id="lower-content">
                                <p>Description</p>
                                <textarea name="description" placeholder="Title of Photo Caption..."></textarea>
                            </div>
                            <div id="upload-button">
                                <input class="submit_input" type="submit" value="Upload" />
                            </div>
                        <?php echo Form::close(); ?>
                     </div>
                     <div class="fileUpload btn btn-primary" id="upload" >
                        <a><span>Upload Photo</span></a>
                     </div>
                     <div class="clearfix"></div>

                 </div>
                    <div id ="normal-view">
                    <div class="photo-listings">
                    
                        <?php if (isset($images) || $current_profile->picture != ""): ?>
                        <?php foreach ($images as $image): ?>
                            <div class="photo">
                                <?php echo Html::anchor(Model_Profile::get_picture($image['file_name'], $current_profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($image['file_name'], $current_profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => $image['description'] )); ?>
                                <p class="photo-caption" title="<?php echo $image['description']; ?>"><?php echo Str::truncate($image['description'], 17 ) ?></p>
                            </div>
                        <?php endforeach; ?>
                        <?php if($current_profile->picture != ""): ?>
                            <div class="photo">
                                <?php echo Html::anchor(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => "Profile Picture" )); ?>
                                <p title="<?php echo "Profile Picture"; ?>"><?php echo "Profile Picture" ?></p>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>No photos added yet!</p>
                    <?php endif; ?>

                        <div class="clearfix"></div>
                        <hr class="friend-divider"/>
                        <div class="view-more-wrap">
                        <button class="view-more-friend">View More</button>             
                        </div>                        
                    </div>
                    </div>

                    <div id="manage">
                    <div class="photo-listings">
                    <?php echo Form::open(array("action" => "profile/manage_photos", "class" => "clearfix")) ?>
                        <?php if (isset($images) || $current_profile->picture != ""): ?>
                        <?php foreach ($images as $image): ?>
                            <div class="photo">
                               <input class="checkbox-item" type="checkbox"  name="image_items[]" value="<?php echo $image->id; ?>" />
                                <?php echo Html::anchor(Model_Profile::get_picture($image['file_name'], $current_profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($image['file_name'], $current_profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => $image['description'] )); ?>
                                <p class="photo-caption" title="<?php echo $image['description']; ?>"><?php echo Str::truncate($image['description'], 17 ) ?></p>
                            </div>
                        <?php endforeach; ?>

                        <?php if($current_profile->picture != ""): ?>
                            <div class="photo">
                                <?php echo Html::anchor(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => "Profile Picture" )); ?>
                                <p title="<?php echo "Profile Picture"; ?>"><?php echo "Profile Picture" ?></p>
                            </div>
                        <?php endif; ?>
                        <div id="delete-photo-container">
                    <input class="blue-btn" type="submit" src="" name="btnRemovePhoto" value="Remove" />
                      </div>
                <?php echo Form::close(); ?>
                    <?php else: ?>
                        <p>No photos added yet!</p>
                    <?php endif; ?>
                      
                        <div class="clearfix"></div>
                        <hr class="friend-divider"/>
                        <div class="view-more-wrap">
                        <button class="view-more-friend">View More</button>             
                        </div>                        
                    </div>
                </div>
                </div>
            </section>
        <div class="border-icon1"></div>
        <div class="border-circle referal-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle referal-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
    </div>
</div>

