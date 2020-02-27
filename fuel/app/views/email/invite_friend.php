<div id="middle">
    <div id="content" class="full">
        <h3><?php echo $from_name ?> has sent you an invite to join 
        <?php if($gender == 1):?>
        <?php echo "his" ?> 
        <?php else: ?> 
        <?php echo "her" ?> 
        <?php endif; ?>   
        friend's list for the social dating website <a href="<?php echo Uri::create('users/m_sign_up/'.$current_profile->id) ?>">Whereweallmeet.com.</a></h3>
        <p>
            <?php echo $message ?>
        </p>
        <p>
            Click the link to join the <?php echo $from_name ?>  friends at no cost to you.
        </p>
    </div>
</div>
