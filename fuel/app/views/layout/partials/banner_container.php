<?php if(isset($current_profile)):  ?>
<?php if(Model_Profile::is_free_member($current_profile->id)): ?>
    <div id="advertizment-container">
        <?php $bannerADs = Model_Banner::find('all'); ?>
        <?php if (isset($bannerADs) ): ?>
            <?php
            $banner_id = 1;
            $banner_count = count($bannerADs);
            ?>
            <?php foreach ($bannerADs as $bannerAD): ?>
                <a target="_blank" href="<?php echo $bannerAD->web_address  ?>"><img id="BN<?php echo $banner_id ?>" class="<?php echo $banner_id == $banner_count ? 'active' : 'inactive-banner' ?>" src="<?php echo Model_Banner::get_banner($bannerAD); ?>" /></a>
                <?php $banner_id++; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
    <p id="advertizment-upgrade"><?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Upgrade",array()); ?> to never see ads again. <?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Remove",array('class' => 'white')); ?></p>

<?php endif; ?>
<?php endif; ?>