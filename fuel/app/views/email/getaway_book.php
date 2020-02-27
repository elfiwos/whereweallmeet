<div id="middle">
    <div id="content" class="full">
        <h1><?php echo $current_user->username ?>
            sent RSVP to <?php echo $getaway->title ?> getaway!
        </h1>
        <p>
            Click <a href="<?php Uri::create('getaway/view/'.$getaway->slug) ?>">here</a> to see the getaway.
        </p>
    </div>
</div>
