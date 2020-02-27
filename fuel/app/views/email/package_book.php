<div id="middle">
    <div id="content" class="full">
        <h1><?php echo $current_user->username ?>
            sent RSVP to <?php echo $event->title ?> getaway!
        </h1>
        <p>
            Click <a href="<?php Uri::create('package/view/'.$event->id) ?>">here</a> to see the date idea.
        </p>
    </div>
</div>
