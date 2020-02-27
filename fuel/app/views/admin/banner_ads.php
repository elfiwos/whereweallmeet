<div id="center" class="clearfix">
    <div id="content" class="with-sidebar-left profile">
        <div id="banner-ads">
            <h2><span>Banner Ads</span></h2>
            <div class="content-box">
                <?php echo Form::open(array("action" => "admin/bannerAds", "enctype" => "multipart/form-data")); ?>
                <div class="items clearfix">
                    <div>
                        <p id="upload-button-container">
                            <input hidden="true" type="file" id="banner-image" name="banner_image" size="1"/>
                            <a id="banner-upload-button" class="upload-button">Browse</a>
                            <span>No file selected</span>
                        </p>
                    </div>
                    <div>
                        <p>Title:</p>
                        <?php echo Form::input('title', '', array("class" => "text-field long")); ?>
                    </div>
                    <div>
                        <p>Web Address:</p>
                        <?php echo Form::input('web_address', '', array("class" => "text-field long")); ?>
                    </div>
                    <div id="publish">
                        <?php echo Form::submit('btnPublishBanner', 'Publish', array("class" => "button")); ?>
                    </div>
                </div>
                <?php echo Form::close(); ?>
                <div id="banner-list-container">
                    <?php echo Form::open(array("action" => "admin/bannerAds", "class" => "clearfix")) ?>
                        <?php if($bannerAds): ?>
                            <div id="button-container" class="clearfix">
                                <input class="submit_input" type="submit" src="" name="btnDeleteBanner" value="Delete Selected" />
                            </div>
                            <table>
                                <thead>
                                    <tr class="table-heading">
                                        <th>&nbsp;</th>
                                        <th class="text-left">Title</th>
                                        <th class="text-left">Web Address</th>
                                        <th class="text-left">Banner</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bannerAds as $bannerAd) : ?>
                                        <tr id="<?php echo $bannerAd->id; ?>">
                                            <td><input class="checkbox-item" type="checkbox"  name="image_items[]" value="<?php echo $bannerAd->id; ?>" /></td>
                                            <td><?php echo $bannerAd->title; ?></td>
                                            <td><?php echo $bannerAd->web_address; ?></td>
                                            <td><?php echo $bannerAd->image; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="no-data-message">No Banner ADs Uploaded!</p>
                        <?php endif; ?>
                    <?php echo Form::close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

