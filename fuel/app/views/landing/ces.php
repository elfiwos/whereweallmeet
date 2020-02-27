<div class="wrapper">
    <div id="top-section" class="clearfix">
        <div id="top-section-content" class="clearfix">
            <div id="logo-container">
                <a href="<?php echo Uri::base(false);?>"><?php echo Asset::img('pages/home2/logo.png'); ?></a>
            </div>
            <div id="header-left-text" class="clearfix">
                <p>Join <span class="light-blue">Where</span><span class="pink">We</span><span class="light-grn">All</span><span class="yellow">Meet</span>.com &amp; Find Your Vacation Package Today!</p>
            </div>
        </div>
    </div>
    <div id="signup-container" class="clearfix">
        <div id="signup-content" class="clearfix">
            <div id="left-section-content" >
                <div class="slogan">
                    <p>Connect, Share,</p>
                    <p class="middle-text">& Experience the 2015</p>
                    <p class="last-text">CES Las Vegas</p>
                </div>
                <p id="middle-content">
                    From keynote addresses to conference sessions
                    and from events to awards—CES has got it all.
                    Explore Whereweallmeet.com to get a list of the
                    CES events.
                </p>
                <div id="bottom-content">
                    <div class="col-md-6">
                        <?php echo Asset::img('pages/home2/ces-logo.png', array('class' => '')); ?>
                    </div>
                    <div class="col-md-6 right-content-text">
                        <p>
                            Thought-leaders and visionaries from the CES industry will once again take the keynote stage at the 2015 Inter-national CES. Don't miss what these exciting executives have to say about the future of their company and consumer technology. 
                        </p>
                    </div>
                </div>
            </div>
            <div id="right-section-content" >
                <p id="get-started">Get started <span> - it's free.</span></p>
                <p id="registration-text">Registration takes less than 2 minutes.</p>
                <?php echo Form::open(array("action" => "users/sign_up", "class" => "")) ?>
                <p class="full-name clearfix">
                    <input type="text" name="first_name" placeholder="First Name"  class="inline" />
                    <input type="text" name="last_name" placeholder="Last Name" class="inline lastname" />
                </p>
                <p class="birth-date">
                    <select class="signup-margin days form-control pull-left" name="month">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <select class="signup-margin days form-control pull-left" name="day">
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <select class="form-control year pull-left" name="year">
                        <?php for ($i = date('Y') - 18; $i >= 1915; $i--): ?>
                            <option><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </p>
                <select class="full-row" name="state">
                    <option value="">Please Select State</option>
                    <?php foreach ($state as $item) : ?>
                        <option value="<?php echo $item->name; ?>"><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="email" placeholder="Email Address" class="full-row" />
                <input type="text" name="username" placeholder="Username" class="full-row" />
                <input type="password" name="password" placeholder="Password" class="full-row" />
                <input type="password" name="confirm_password" placeholder="Confirm Password" class="full-row" />
                <p class="gender">
                    <input type="radio" name="gender_id" value="1" checked><span>Male</span>
                    <input type="radio" name="gender_id" value="2"><span>Female</span>
                </p>
                <button name="submit" type="submit" class="">Sign Up Today For Free</button>
                <p class="terms-text">By continuing, you agree to our terms of service and that you have read our User Agreement and  Privacy Policy</p>
                <?php echo Form::close();?>
            </div>
        </div>

    </div>
    <div id="get-started-container" class="clearfix">
        <div id="get-started-content">
            <?php echo Asset::img('pages/home2/color-small.jpg', array('class' => 'get-started-bgcolor')); ?>
            <h1>Our Group Travel Packages includes: All-Inclusive Accommodations</h1>
            <div id="get-started-list" class="clearfix">
                <div>
                    <?php echo Asset::img('pages/home2/we_plan.png'); ?>
                </div>
                <div>
                    <?php echo Asset::img('pages/home2/corporate_events.png'); ?>
                </div>
                <div class="last-item">
                    <?php echo Asset::img('pages/home2/for_everybody.png'); ?>
                </div>

            </div>
        </div>
        <div id="ces-detail-container">
            <div id="ces-detail">
                <div id="ces-opening-party">
                    <p class="image-cotainer">
                        <?php echo Asset::img('pages/home2/ces_opening_party.jpg'); ?>
                    </p>
                    <p class="event-header">CES Opening Party</p>
                    <p class="event-time">10 PM - 2 AM  |  Monday, January 5, 2015</p>
                    <p class="event-description">
                        Join us at the number one nightclub in North
                        America, Marquee, for the CES Opening Party
                        on the eve of CES. MARQUEE Nightclub & Day
                        Club is a 66,000 square foot entertainment
                        complex at The Cosmopolitan of Las Vegas.
                    </p>
                    <p class="learn-more"><a href="#">Learn More ></a></p>
                </div>
                <div id="ces-startup-stage">
                    <p class="image-cotainer">
                        <?php echo Asset::img('pages/home2/ces_startup_stage.jpg'); ?>
                    </p>
                    <p class="event-header">Startup Stage</p>
                    <p class="event-time">10:30-11:30 AM  |  Tuesday, January 6</p>
                    <p class="event-description">
                        Four days of programming in Eureka Park. The
                        Startup Stage will feature panels with iconic
                        entrepreneurs, VCs, media and other young
                        companies. Unique programming, office hours,
                        pitching and networking will make the Start-
                        up Stage a can’t miss destination...
                    </p>
                    <p class="learn-more"><a href="#">Learn More ></a></p>
                </div>
                <div id="ces-international" class="last-item">
                    <p class="image-cotainer">
                        <?php echo Asset::img('pages/home2/ces_international.jpg'); ?>
                    </p>
                    <p class="event-header">Internatonal Matchmaking</p>
                    <p class="event-time">6 PM - 7:30 AM  |  Tuesday, January 6, 2015</p>
                    <p class="event-description">
                        Don’t miss this opportunity and enjoy light
                        refreshments after an exciting day on the CES
                        show floor. This event is open to all internat-
                        ional registrants and their invited guests. At this
                        reception, the U.S. Department of Commerce will
                        host a matchmaking program for U.S. compani...
                    </p>
                    <p class="learn-more"><a href="#">Learn More ></a></p>
                </div>
            </div>
            <div id="signup-now">
                <p><span class="big-text">Sign Up Now and Take Advantage of these Exciting Corporate Events</span>
                    <a class="sign-btn" href="#">SIGN UP</a></p>
            </div>
        </div>
    </div>

    <div id="footer-section">
        <div id="footer-content" class="clearfix">
            <p><a data-dialog="terms">Terms of Service</a></p>
            <p><a data-dialog="privacy">Privacy Policy</a></p>
            <p><a>Blog</a></p>
            <p class="right">&#169; 2014 Where We All Meet</p>
        </div>

        <?php echo Asset::img('pages/home2/color.jpg', array('class' => 'footer-bottom')); ?>
    </div>

</div>


<!-- Modal build your profile -->
<div class="modal-container" id="profile">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">Build Your Profile!!</h3>

            </div>
            <div class="modal-body">
                <h4>Profile Page</h4>
                <hr/>
                <p>Profile pages are the main focus points for daters as they search for mates.</p>
                <div class="more-text"> Members should put specific detail about wants and needs to ensure matches are truly authentic. The profile page has priority criteria that a member can rank based on importance for potential matches. The first step is filling out the quick signup form and joining WhereWeAllMeet.com.</div>
                <p class="more-less-button"><a>Read More</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal dating agent -->
<div class="modal-container" id="agent">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">My Dating Agent!!</h3>

            </div>
            <div class="modal-body">
                <h4>Concierge Dating Agents</h4>
                <hr/>In addition to the WhereWeAllMeet.com core services, we offer our personal concierge service to all of our subscribing members at anytime. Concierge Service for personalized date planning, personalized match searched based on personal survey. Stress-free so you can relax and have a wonderful dating experience on WhereWeAllMeet.com. Just fill out our free signup form to join our site.
            </div>
        </div>
    </div>
</div>

<!-- Modal join -->
<div class="modal-container" id="join">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">It’s Easy To Join!!</h3>

            </div>
            <div class="modal-body">
                <h4>Welcome to WhereWeAll Meet.com </h4>
                <hr/>
                You can join the site in less than 60 seconds by signing up today and filling out the form.

                All you need to do is enter the form information, and have a valid email address. Your first name, last name, and zip code of your billing address must match your credit card information in order to become a member of WhereWeAllMeet.com. We do this in order to authenticate all of our subscribing members.
            </div>
        </div>
    </div>
</div>

<!-- Modal chat -->
<div class="modal-container" id="chat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">Chat Instantly!!</h3>

            </div>
            <div class="modal-body">
                <h4>WhereWeAllMeet.com Chat System</h4>
                <hr/>
                <p>The live chat feature on WhereWeAllMeet.com is a one-on-one chat session with a friend. You can create a chat room with any friend and invite other friends to join in the conversation to create a group chat. Send a member a quick start conversation topic to break the ice. All this is easy to get started by filling out our quick signup form.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Privacy -->
<div class="modal-container" id="privacy">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">WhereWeAllMeet.com Privacy Policy</h3>

            </div>
            <div class="modal-body modal-privacy">
                <p><?php echo View::forge("pages/privacy"); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal terms and agreement -->
<div class="modal-container" id="terms">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">WhereWeAllMeet.com Terms of Use</h3>

            </div>
            <div class="modal-body modal-privacy">
                <p><?php echo View::forge("pages/agreement"); ?></p>
            </div>
        </div>
    </div>
</div>
