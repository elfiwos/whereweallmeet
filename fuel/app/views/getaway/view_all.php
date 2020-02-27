<div id="content" class="clearfix">
   
    <div id="middle">
        
            <?php
            $no_getaway = true;

            if (isset($active_getaways) and $active_getaways !== false):
                $no_getaway = false;
                foreach ($active_getaways as $getaway):
                    ?>
                    <div class="content-item">
                    <div class="image pull-left">
                        <a href="<?php echo \Fuel\Core\Uri::create('getaway/view/' . $getaway['slug']) ?>">
                            <?php if (empty($getaway['photo'])): ?>
                                <img src="temp/getaway_thumb.jpg" />
                            <?php else: ?>
                                <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/getaways/getaway_list_' . $getaway['photo'] ?>" />
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="decription pull-left">
                        <p class="title"><?php echo $getaway['title'] ?></p>
                        <p class="location"><span class="gray">Located:</span><?php echo $getaway['city'] . ', '. $getaway['state']; ?></p>
                        <p class="date"><?php echo $getaway['start_date'] ?></p>
                        <p class="detail gray"><?php echo $getaway['short_description'];  ?></p>
                        <?php echo Html::anchor('getaway/view/' . $getaway['slug'], 'View Get-Away', array('class' => 'btn-detail-getaway')); ?>
                    </div>
                    <div class="clearfix"></div>
                   </div>
                    <hr>
                    <?php
                endforeach;

            endif;
            ?>

            <?php
            if ($no_getaway):
                ?>
                <div class="event-list clearfix" id="no-event">
                    No event found from your location.
                </div>
                <?php
            endif;
            ?>
      

        <section id="event-search-section">
            <div class="section-heading"><h2>Find Your Perfect Getaway</h2></div>
            <div id="search-form-container">
                <?php echo Form::open(array('action' => 'getaway/search', 'method' => 'Post', 'enctype' => 'multipart/form-data')); ?>
                <p class="search-parameter">
                    <label class="label" for="destination">Getaway Location </label></br>
                    <select class="search-box" name="location" placeholder="Getaway Location" required >
                        <option></option>
                        <?php $getaway_states = Model_Getaway::get_distinct_getaway_states(); ?>
                            <?php if (($getaway_states !== false)): ?>
                                <?php foreach ($getaway_states as $getaway): ?>
                                    <option value= <?php echo $getaway['state']; ?> > <?php echo ucfirst($getaway['state']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                    </select>
                </p>
                <p class="search-parameter">
                    <label class="search_label" for="from_date"> From:</label>
                    <input id="from_date" type="text" name="from_date" placeholder="From Date (Optional)"  >
                    <label class="search_label to-date" for="to_date"> To:</label>
                    <input id="to_date" type="text" name="to_date" placeholder="To Date (Optional)"  >
                </p>
                <p class="search-parameter">    <input  class="search-button" type="submit" name="search" value="Search" required></p>
                <?php echo Form::close(); ?>
            </div>
        </section>
    </div>

</div>