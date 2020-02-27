<script type="text/javascript"> 
function confirmDelete() { 
 return confirm("Are you sure you want to delete?");   
} 
</script> 

<div id="content" class="clearfix">
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
        <?php echo View::forge("profile/partials/setting_nav"); ?>
    </aside>
    <div id="middle">

        
        <div class="header-section">
            <p class="header-text">Photos</p>
        </div>

        <div class="form-wrapper profile-form bio-form">
        
          
              <div class="inner-wrapper">




              <?php if($current_profile->picture != ""): ?>
                <?php echo Form::open(array("action" => "profile/crop_photo", "enctype" => "multipart/form-data", "class" => "clearfix")) ?>
                <div class="photo-listings">
                            <div class="photo">
                                <?php echo Html::anchor(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => "Profile Picture" )); ?>
                                <div class="photo-edit-con" id="photo-edit-con1"><a href="#"><?php echo Asset::img('icons/photo_edit.png'); ?></a></div>
                                <p title="<?php echo "Profile Picture"; ?>"><?php echo "Profile Picture" ?></p>
                            </div>

                </div>
                

                <?php
                         $image_url = Uri::create("uploads/" . Model_Profile::clean_name($current_user->username) . "/" . $current_profile->picture);
                         $photo_url = DOCROOT."uploads". DIRECTORY_SEPARATOR. Model_Profile::clean_name($current_user->username). DIRECTORY_SEPARATOR. $current_profile->picture;
                         $file = explode(".", $current_profile->picture);
                         $file_name = rtrim($file[0]);
                         $original = $current_profile->picture;
                         //$photo_id = $my_photo['id'];
                         //$file= pathinfo($my_photo['file_name']);
                         //$file_name = ($file['filename']);

                         $path =DOCROOT."uploads". DIRECTORY_SEPARATOR. Model_Profile::clean_name($current_user->username).DIRECTORY_SEPARATOR;
                ?>

                <div data-id='edit-photo-crop1'>
                        <input class="submit_input" type="button" value="Crop" onclick="show_popup_crop1(<?php echo " '".$image_url. "'"; ?>)"  />
                </div>
                <div data-id='edit-photo1'>

                </div>

                <div id="pic_url"  url ="<?php echo $photo_url; ?> "  origin ="<?php echo $original; ?>" file ="<?php echo $file_name; ?> " path="<?php echo $path; ?>"  >

                </div> 

                
                </form>

                <div id="popup_crop1" url = "<?php echo Uri::create('profile/crop_photo')?>">
                        <div class="form_crop">
                            <span class="close" onclick="close_popup('popup_crop1')">x</span>
                                <h2>Crop photo</h2>
            <!-- This is the image we're attaching the crop to -->
                                <img id="cropbox1" />

                                
                                  <form>
                                    
                                    <input type="hidden" id="x" name="x" />
                                    <input type="hidden" id="y" name="y" />
                                    <input type="hidden" id="w" name="w" />
                                    <input type="hidden" id="h" name="h" />
                                    <input type="hidden" id="photo_url" name="photo_url" />
                                    

                                    <input type="button" value="Crop Image" id="crop_btn" onclick="crop_photo1()" />
                                </form>
                            </div>
                </div>

            <?php endif; ?>  




          <?php echo Form::open(array("action" => "profile/upload_profile_photo", "enctype" => "multipart/form-data", "class" => "clearfix")) ?>
                    <p class="lbl">Upload a New Profile Pic (optional)</p>
                    
                    <div class="form-inline">
                        <input class="pro-pic-upload" type="file" name="profile_pic">
                         <input class="submit_input" type="submit" value="Upload" />

                    </div>      
                 
        <?php echo Form::close(); ?> 

                <p class="more-wrap more-wrap-photo">
                        <span>NO NUDITY. NO SEXUALLY-SUGGESTIVE PHOTOS.</span>
                    </p>

            <div class="photos-upper">
                <div id='upload-section'>  
                <?php echo Form::open(array("action" => "profile/upload_photo_settings", "enctype" => "multipart/form-data", "class" => "clearfix")) ?>
                    <p class="lbl">Upload other Pictures (optional)</p>
                    
                    <div id="upper-content">

                        <p id="profile-photo-select">
                            <input hidden="true" type="file" id="profile-picture" name="picture" size="1"/>
                            <a id="profile-upload-button" class="upload-button">Browse</a>
                            <span>No file selected</span>
                        </p>
                    </div>
                    <div id="lower-content">
                        <p>Description</p>
                        <textarea name="description" placeholder="Photo Caption..."></textarea>
                    </div>
                    <div id="upload-button">
                        <input class="submit_input" type="submit" value="Upload" />
                    </div>
                <?php echo Form::close(); ?> 
                 </div>
            </div>
             <br/>
        <div class="header-section">
            <p class="header-text">Edit Your Photos</p>
        </div>
                     
            <?php if (isset($my_photos)): ?>
                    <div class="photo-listings">

                     <?php foreach ($my_photos as $my_photo):  ?>
                 <?php echo Form::open(array("action" => "profile/remove_photo", "class" => "clearfix")) ?>
                        <div class="photo">
                            <?php //echo Html::img(Model_Profile::get_picture($my_photo['file_name'], $current_profile->user_id, "members_medium")); ?>
                            <?php echo Html::anchor(Model_Profile::get_picture($my_photo['file_name'], $current_profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($my_photo['file_name'], $current_profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => $my_photo['description'] )); ?>
                            <div class="photo-edit-con"><a href="#"><?php echo Asset::img('icons/photo_edit.png'); ?></a></div>
                            <p class="photo-caption"><?php echo $my_photo->description; ?></p>
                            <input type='hidden' name="image" value="<?php echo $my_photo->id; ?>" />

                        </div>


                        <div data-id='edit-photo'>
                        <input class="submit_input" type="submit" value="Remove" />
                        </div>
                        <?php
                         $image_url = Uri::create("uploads/" . Model_Profile::clean_name($current_user->username) . "/" . $my_photo['file_name']);
                         $photo_url = DOCROOT."uploads". DIRECTORY_SEPARATOR. Model_Profile::clean_name($current_user->username). DIRECTORY_SEPARATOR. $my_photo['file_name'];
                         $file = explode(".", $my_photo['file_name']);
                         $file_name = rtrim($file[0]);
                         $original = $my_photo['file_name'];
                         $photo_id = $my_photo['id'];
                         //$file= pathinfo($my_photo['file_name']);
                         //$file_name = ($file['filename']);

                         $path =DOCROOT."uploads". DIRECTORY_SEPARATOR. Model_Profile::clean_name($current_user->username).DIRECTORY_SEPARATOR;
                        ?>
                        <div data-id='edit-photo-crop'>
                        <input class="submit_input" type="button" value="Crop" onclick="show_popup_crop(<?php echo " '".$image_url. "'"; ?>, <?php echo "'".$my_photo['id']. "'"; ?>)"  />
                        </div>
                        <div id="pic_url_<?= $my_photo['id']; ?>"  image-id="<?php echo $photo_id; ?> " url ="<?php echo $photo_url; ?> "  origin ="<?php echo $original; ?>" file ="<?php echo $file_name; ?> " path="<?php echo $path; ?>"  >

                        </div>            
                        <div class="clearfix"></div>

                       </form>


                      <div id="popup_crop" url = "<?php echo Uri::create('profile/crop_photo')?>">>
                        <div class="form_crop">
                            <span class="close" onclick="close_popup('popup_crop')">x</span>
                                <h2>Crop photo</h2>
            <!-- This is the image we're attaching the crop to -->
                                <img id="cropbox" />

                                
                                  <form>
                                    
                                    <input type="hidden" id="x" name="x" />
                                    <input type="hidden" id="y" name="y" />
                                    <input type="hidden" id="w" name="w" />
                                    <input type="hidden" id="h" name="h" />
                                    <input type="hidden" id="photo_url" name="photo_url" />
                                    <input type="hidden" id="photo_id" name="photo_id" />

                                    <input type="button" value="Crop Image" id="crop_btn" onclick="crop_photo()" />
                                </form>
                            </div>
                        </div>



                    <?php endforeach; ?>
                    </div>                                  
                  <?php endif; ?>  
                </div>
                
                        

<!--                <div class="submit-btn">-->
<!--                        <div class="btn-wrap gold-bg">-->
<!--                        <input type="submit" name="submit" value="SAVE" />-->
<!--                        </div>-->
<!--                </div>-->

            
        </div>



        <div class="border-icon1"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div> 
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div> 

    </div> <!-- end of middle -->
</div>
