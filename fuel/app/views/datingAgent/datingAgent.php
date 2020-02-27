<div id="content" class="clearfix">

    <div id="middle">

        <section id="latest-members">
          <div class="header-section">
              <p class="header-text">About WhereWeAllMeets Dating agents</p>
          </div>
            
            <div class="content">
            	<div id="description">
                    <p>
                        Our personal Dating Concierge Agents take the work out of the online dating process.
                        Let us help you improve the quality and quantity of your dates and maximize your online experience.
                    </p>
                    <p>
                        Our Dating Concierge Agents are socially on point savvy women and men highly educated in communication
                        and the art of online dating. We are dedicated to helping you put your best foot forward and helping
                        you navigate through the often scary world of online dating.
                    </p>
            	</div>

            </div>
        </section>   

        <section class="agent-listing">
            <div class="header-section">
                <p class="header-text">Current Dating Agents</p>
            </div>
            <div class="content">
                <?php if(isset($dating_agents)): ?>
                    <?php $counter = 0; ?>

                    <?php foreach($dating_agents as $agent): ?>
                        <?php if( ! Model_Profile::is_deleted_account($agent->id)): ?>
                            <?php $counter++; $online_u = 0; ?>
                            <div class="agent">
                                <div class="online-status">
                                    <?php if($agent->is_logged_in): ?>
                                        <?php echo Asset::img("online_dot.png"); ?><span>Online</span>
                                    <?php else: ?>
                                        <?php echo Asset::img("offline_dot.png"); ?><span>Offline</span>
                                    <?php endif; ?>
                                </div>
                                <div class="agent-image"><?php echo View::forge("profile/partials/member_thumb", array("member" => $agent)); ?></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
            <div class="link"><a href="#">View All Agents</a></div>
        </section>

        <div class="get-started">
            <h2>Sit back and relax, let our dating agents do the work for you.</h2>  
            <div class="btn-wrap gold-bg">
                    <a href="#">SELECT A DATING AGENT TO GET STARTED</a>
            </div>    
        </div>          
        <div class="border-icon1"></div>
        <div class="border-icon2"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
    </div>

    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online"); ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><?php echo Asset::img("temp/events-sidebar.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('package') ?>"><?php echo Asset::img("temp/date-idea-sidebar.jpg"); ?></a>
        </div>

    </aside>
</div>


<div id="upgrade" class="dialog">
    <p>You must <?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), 'upgrade'); ?> your account to see a dating agent profile.</p>
</div>