<input type="hidden" id="email_exists" value="<?php echo Uri::base(false) . 'pages/email_exists'; ?>">
<div class="wrapper">
    <div id="top-section" class="clearfix">
        <div id="top-section-content" class="clearfix" >
            <div id="logo-container">
                <a href="<?php echo Uri::base(false);?>"><?php echo Asset::img('pages/home2/logo-dark.png'); ?></a>
            </div>
            <div id="company-identity-container" class="clearfix">
                <h3><span class="blue">Connect,</span> Share <span class="purple">Experiences,</span> and <span class="green">Explore</span> Dating <span class="yellow">Ideas</span> </h3>
            </div>
        </div>        
    </div>
    <div id="login-section" class="clearfix">
        <div id="top-section-content" class="clearfix">
            
            <div id="login-container" class="clearfix">
                <?php echo Form::open(array("action" => "users/login", "class" => "form-inline", "role" => "form")) ?>
                    <div class="form-group" style="margin-top:2px">Already a Member?</div>
                    <div class="form-group">
                        <input type="text" name="username" placeholder="Username:" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password:" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn blue-btn">Login</button>
                    </div>
                    <div class="form-group">
                        <label>
                          <input type="checkbox"> Remember Me<br>
                          <a href="<?php echo Uri::base(false) . 'users/forgot_password'; ?>">
                        Forgot Your Password?</a>
                        </label>  
                        
                    </div>

                    
                    
                    <!-- <div class="login-btn-container">
                        <button name="btnLogin" type="submit">Login</button>
                    </div>  -->
                <?php echo Form::close();?>
            </div>
        </div>
    </div>
    <div id="signup-container" class="clearfix">
        <div id="signup-content" class="clearfix">
            <div id="left-section-content" >
                <!-- <h3>Connect, Share Experiences, and Explore our Event/Vacation Packages. </h3>
                <p>WhereWeAllMeet.com is a social dating, event promotion and vacation discovery platform that provides a meeting place to interact with friends and meet new friends online.</p>
                <div class="more-text">
                    <p>Real online dating agents are here to assist the busy person that doesn't have time to search for their potential dream date!</p>
                    <p>Want to meet people but hate dating website? Whereweallmeet.com puts the fun back into dating!</p>
                </div>
                <p class="more-less-button"><a>Read More</a></p> -->
            </div>
            <div id="right-section-content" >
                <h3 id="registration-text">
                Find Your Match, Get Started Today
                </h3>
                <?php echo Form::open(array("action" => "users/sign_up", "class" => "")) ?>
                    
                    <div class="clearfix">
                        <label for="iam">I'm a</label>
                        <div class="styled-select">
                            <select class="inline" id="iam" name="iam">
                            <?php foreach ($genders as $gender):?>
                                <?php
                                
                                if(in_array($gender['name'], array('male', 'female'))):?>

                                <option value="<?php echo $gender['id'];?>" 
                                 
                                 <?php
                                 if($gender['name']=='female') echo ' selected';
                                 ?>
                                >
                                <?php echo $gender['name'];?>
                                </option>
                            <?php endif;?>

                            <?php endforeach;?>
                        </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label for="seeking">Seeking a</label>
                        <div class="styled-select">
                            <select class="inline" id="seeking" name="seeking">
                            <?php foreach ($genders as $gender):?>
                                <option value="<?php echo $gender['id'];?>" 
                                <?php if($gender['name']=='male') echo ' selected';?>
                                >
                                <?php echo $gender['name'];?>
                                </option>
                            <?php endforeach;?>
                        </select>
                        </div>
                    </div>
                    <div class="clearfix" style="clear:both;margin-top:10px">
                    <button id="step_zero" type="button" data-dialog="create_account">Sign Up Today For Free</button>
                    </div>
                <?php echo Form::close();?>
            </div>
        </div>

    </div>
    <div id="get-started-container" class="clearfix">
        <div id="get-started-content">
            <?php echo Asset::img('pages/home2/color-small.jpg', array('class' => 'get-started-bgcolor')); ?>
            <h1><span>See How to get started...It’s easy!!!</span></h1>
            <div id="get-started-list" class="clearfix">
                <div class="col-md-3">
                    <?php echo Asset::img('pages/home2/events.jpg'); ?>
                    <h3><span class="blue-underline">Eve</span>nts</h3>
                    <p>Bringing people together through live experiences and 
                    social gatherings.</p>
                    <a class="easy-to-join-btn" data-dialog="join">Learn More</a>
                </div>
                <div class="col-md-3">
                    <?php echo Asset::img('pages/home2/dating-ideas.jpg'); ?>
                    <h3><span class="purple-underline">Dat</span>ing Ideas</h3>
                    <p>Browse our list of dating ideas or create your own,
                    connect with someone you like.</p>
                    <a class="build-your-profile-btn" data-dialog="profile">Learn More</a>
                </div>
                <div class="col-md-3">
                    <?php echo Asset::img('pages/home2/dating-agents.jpg'); ?>
                    <h3><span class="green-underline">Dat</span>ing Agents</h3>
                    <p>Offering exclusive dating agent service for the discrete gentleman or woman.</p>
                    <a class="my-dating-agent-btn" data-dialog="agent">Learn More</a>
                </div>
                <div class="col-md-3">
                    <?php echo Asset::img('pages/home2/chat-instantly.jpg'); ?>
                    <h3><span class="yellow-underline">Cha</span>t Instantly</h3>
                    <p>Use our instant messenger from real-time chat, to group chat
                     to get to know new people.</p>
                    <a class="chat-instantly-btn" data-dialog="chat">Learn More</a>
                </div>

            </div>
        </div>
    </div>

    <div id="footer-section">
        <div id="footer-content" class="clearfix">
            <p><a target="blank" href="http://whereweallmeet.com/blog/about/">About</a></p>
			<p><a target="blank" href="http://whereweallmeet.com/blog/faq/">FAQ</a></p>
			<p><a target="blank" href="http://whereweallmeet.com/blog/jobs/">Jobs</a></p>
			<p><a target="blank" href="http://whereweallmeet.com/blog/affiliates/">Affiliates</a></p>		
            <p><a target="blank" href="http://whereweallmeet.com/blog/terms/" >Terms of Service</a></p> <!--class="show_dialog" data-dialog="terms"-->
            <p><a target="blank" href="http://whereweallmeet.com/blog/privacy/" >Privacy Policy</a></p> <!--class="show_dialog" data-dialog="privacy" -->
            <p><a target="blank" href="http://whereweallmeet.com/blog/">Blog</a></p>
			<p><a target="blank" href="#">Security</a></p>
            <p class="right">All Rights Reserved: WhereWellAllMeet.com</p>
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
                <h3 class="modal-title" id="myModalLabel">Dating Ideas!!</h3>

            </div>
            <div class="modal-body">
                <!-- <h4>Dating Ideas</h4>
                <hr/> -->
                <div> 
                    Have an idea about a fun date? 
                    WhereWeAllMeet.com let's you suggest a date to 
                    your friends with similar interest. You can create 
                    your own dating idea to find someone that's interested 
                    in connecting and getting out there on real dates. 
                    It's easy, just fill in your dating idea and send it to
                    a member on your network and connect to enjoy the date.
                </div>
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
                <h3 class="modal-title" id="myModalLabel">Events!!</h3>

            </div>
            <div class="modal-body">
                <!-- <h4>Welcome to WhereWeAll Meet.com </h4>
                <hr/> -->
                Looking for inspiration on where to go to 
                    meet interesting and new people? 
                    WhereWeAllMeet.com has organized a roster 
                    of exciting events and group Vacation packages 
                    ared to offer our members an adventurous place 
                    to meet and mingle with other members of 
                    WhereWeAllMeet.com.
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


<!-- Tell US Eight -->
<div class="modal-container get-info-modals" id="step_nine_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">
                ADD A PHOTO
                </h3>
                <p>
                    It only takes a second. Just choose your 
                    favorite picture of you being yourself
                </p>
            </div>
             
    <?php echo Form::open(array("action" => "users/sign_up", "enctype" => "multipart/form-data")) ?>
            <div class="modal-body">

                <div class="floating-container" style="background-color: transparent">
                    

                    <div class="row">
                        <div class="col upload-box" style="background-color:#fff">
                            <?php echo Asset::img('pages/home2/upload-pc.png', array('class' => '', 'id'=> 'preview')); ?>
                            
                            
                            <div class="clearfix">
                           
                                <button>From My Computer</button>
                                <input id="imgInp" name="picture" type="file" class="upload" style = "
                                    cursor: pointer;
                                    font-size: 20px;
                                    margin: 0;
                                    opacity: 0;
                                    padding: 0;
                                    position: relative;
                                    right: 5px;
                                    top: -31px;
                                    left: 21px;
                                    width: 180px;">                     
                            </div>

                      <input name = "gender_id" type="hidden" id = "info1">
                      <input name = "seeking"  type="hidden" id = "info2">
                      <input name = "zip" type="hidden" id = "info3">
                      <input name = "day" type = "hidden" id = "info4">
                      <input name = "month" type = "hidden" id = "info5">
                      <input name = "year" type = "hidden" id = "info6">
                      <input name = "username" type = "hidden" id = "info7">
                      <input name = "password" type = "hidden" id = "info8">
                      <input name = "confirm_password" type = "hidden" id = "info9">
                      <input name = "first_name" type = "hidden" id = "info10">
                      <input name = "last_name" type = "hidden" id = "info11">
                      <input name = "email" type = "hidden" id = "info12">
                      <input name = "career" type = "hidden" id = "info13">
                      <input name = "education_id" type = "hidden" id = "info14">
                      <input name = "ethnicity_id" type = "hidden" id = "info15">
                      <input name = "match_ethnicity" type = "hidden" id = "info16">
                      <input name = "faith_id" type = "hidden" id = "info17">
                      <input name = "faith_importance" type = "hidden" id = "info18">
                      <input name = "children_id" type = "hidden" id = "info19">
                      <input name = "feet" type = "hidden" id = "info20">
                      <input name = "inches" type = "hidden" id = "info21">
                      <input name = "politics_id" type = "hidden" id = "info22">
                      <input name = "politics_importance" type = "hidden" id = "info23">
                      <input name = "exercise_id" type = "hidden" id = "info24">
                      <input name = "drink_id" type = "hidden" id = "info25">
                      <input name = "smoke_id" type = "hidden" id = "info26">
                      <input name = "about_me" type = "hidden" id = "info27">
                      <input name = "places_visted" type = "hidden" id = "info28">
                      <input name = "like_doing" type = "hidden" id = "info29">
                      <input name = "plan_for_future" type = "hidden" id = "info30">
                      <input name = "ages_from" type = "hidden" id = "info31">
                      <input name = "ages_to" type = "hidden" id = "info32">
                      <input name = "seeking_education_id" type = "hidden" id = "info33">
                      <input name = "seeking_ethnicity_id" type = "hidden" id = "info34">
                      <input name = "seeking_matching_ethnicity" type = "hidden" id = "info35">
                      <input name = "seeking_religion_id" type = "hidden" id = "info36">
                      <input name = "seeking_faith_importance" type = "hidden" id = "info37">
                      <input name = "seeking_children_id" type = "hidden" id = "info38">
                      <input name = "seeking_feet" type = "hidden" id = "info39">
                      <input name = "seeking_inches" type = "hidden" id = "info40">
                      <input name = "seeking_politics_id" type = "hidden" id = "info41">
                      <input name = "seeking_politics_importance" type = "hidden" id = "info42">
                      <input name = "seeking_exercise_id" type = "hidden" id = "info43">
                      <input name = "seeking_drink_id" type = "hidden" id = "info44">
                      <input name = "seeking_smoke_id" type = "hidden" id = "info45">
                      <input name = "body_type_id" type = "hidden" id = "info46">
                      <input name = "seeking_body_type_id" type = "hidden" id = "info47">
 



                        </div>
                        <div class="col upload-box" style="background-color:#fff">
                            <?php echo Asset::img('pages/home2/upload-fb.png', array('class' => '')); ?>
                            <div class="clearfix">
                                <button>From Facebook</button>
                                <input type="file1"  style = "
                                    cursor: pointer;
                                    font-size: 20px;
                                    margin: 0;
                                    opacity: 0;
                                    padding: 0;
                                    position: relative;
                                    right: 5px;
                                    top: -31px;
                                    left: 0px;
                                    width: 180px;">                     
                            </div>
                            </div>
                        </div>

                        <div class="clearfix" style="clear:both">
                            <p style="padding:10px;margin:10px">Photos are required to be found on 
                            WhereWeAllMeet.com Upload your first 
                            photo now. You can add more later.</p>
                        </div>
                        
                    </div>
              
                    <div class="row">
                        <div class="col col-md-12 text-center">
                            <button type="submit" id="step_nine">
                            Finish
                            </button>
                        </div>
                    </div>
                  
                </div>
                
            </div>
              <?php echo Form::close(); ?>
        </div>
    </div>
</div>


<!-- Tell US Seven -->
<div class="modal-container get-info-modals" id="step_eight_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">
                TELL US WHAT YOUR LOOKING FOR
                </h3>
                <p>
                    Answer a few questions that will help us determine 
                    which users are a perfect match for you
                </p>
            </div>
            <div class="modal-body">
                <div class="floating-container">
                    <div class="row">
                        <div class="col col-md-3">Ages From</div>
                        <div class="col col-md-9 half-width">
                            <select  name="seeking_from" id="seeking_from">
                                <?php for($i=18; $i<100;$i++): ?>
                                <option><?php echo $i;?></option>
                                <?php endfor;?>
                            </select>
                            <select name="seeking_to" id="seeking_to">
                                <?php for($i=18; $i<100;$i++): ?>
                                <option <?php if($i==99) echo 'selected' ?>><?php echo $i;?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>  

                    <div class="row">
                        <div class="col col-md-3">Education</div>
                        <div class="col col-md-9 full-width">
                            <select name="seeking_education" id="seeking_education">
                                <option value="">Select your education</option>
                                <?php foreach ($educations as $education):?>
                                <option value="<?php echo $education['id'] ?>">
                                    <?php echo $education['name'] ?>
                                </option>
                            <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3">Ethnicity</div>
                        <div class="col col-md-9 half-width">
                            <select name="seeking_ethnicity" id="seeking_ethnicity">
                                <option value="">Select your ethnicity</option>
                                <?php foreach ($ethnicities as $ethnicity):?>
                                <option value="<?php echo $ethnicity['id'] ?>">
                                    <?php echo $ethnicity['name'] ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <select name="seeking_matching_ethnicity" id="seeking_matching_ethnicity">
                                <option>Matches ethnicity</option>
                                <?php foreach ($ethnicities as $ethnicity):?>
                                <option value="<?php echo $ethnicity['id'] ?>">
                                    <?php echo $ethnicity['name'] ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>  

                    <div class="row">
                        <div class="col col-md-3">Faith</div>
                        <div class="col col-md-9 half-width">
                            <select name="seeking_faith" id="seeking_faith">
                                <option value="">Select your faith</option>
                                <?php foreach ($faiths as $faith):?>
                                <option value="<?php echo $faith['id'] ?>">
                                    <?php echo $faith['name'] ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <select  name="seeking_faith_importance" id="seeking_faith_importance">
                                <option value="">Importance Level</option>
                                <option>Very Important</option>
                                <option>Somewhat Important</option>
                                <option>Not Important</option>
                                <option>No Comment</option>
                            </select>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col col-md-3">Children</div>
                        <div class="col col-md-9 full-width">
                            <select name="seeking_children" id="seeking_children">
                                <?php foreach ($children as $child):?>
                                <option value="<?php echo $child['id'] ?>">
                                    <?php echo $child['name'] ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col col-md-3">Height</div>
                        <div class="col col-md-9 half-width">
                            <select name="seeking_feet" id="seeking_feet">
                                <option value="">Feet</option>
                                <?php for($i=4;$i<8;$i++): ?>
                                    <option value="<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <select name="seeking_inches" id="seeking_inches">
                                <option value="">Inches</option>
                                <?php for($i=0;$i<13;$i++): ?>
                                    <option value="<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col col-md-3">Politics</div>
                        <div class="col col-md-9 half-width">
                            <select name="seeking_politics" id="seeking_politics">
                                <option value="">Select your politics</option>
                                <?php foreach ($politics as $politic):?>
                                <option value="<?php echo $politic['id'] ?>">
                                    <?php echo $politic['name'] ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <select name="seeking_politics_importance" id="seeking_politics_importance">
                                <option value="">Importance Level</option>
                                <option>Very Important</option>
                                <option>Somewhat Important</option>
                                <option>Not Important</option>
                                <option>No Comment</option>
                            </select>
                        </div>
                    </div> 


                    <div class="row">
                        <div class="col col-md-3">Exercise</div>
                        <div class="col col-md-9 full-width">
                            <select name="seeking_exercise" id="seeking_exercise">
                                <option value="">How often do you exercise?</option>
                                <?php foreach ($exercise as $exerz):?>
                                <option value="<?php echo $exerz['id'] ?>">
                                    <?php echo $exerz['name'] ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col col-md-3">Body Type</div>
                        <div class="col col-md-9 full-width">
                            <select name="seeking_body_type_id" id="seeking_body_type_id">
                            <option value="" selected>Select your body type</option>
                            <?php foreach ($body_types as $body_type):?>
                                <option value="<?php echo $body_type['id'] ?>">
                                    <?php echo $body_type['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>  
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3">Drink</div>
                        <div class="col col-md-9 full-width">
                            <select name="seeking_drink" id="seeking_drink">
                                <option value="0">How often do you drink?</option>
                                <?php foreach ($drinks as $drink):?>
                                <option value="<?php echo $drink['id'] ?>">
                                    <?php echo $drink['name'] ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col col-md-3">Smoke</div>
                        <div class="col col-md-9 full-width">
                            <select name="seeking_smoke" id="seeking_smoke">
                                <option value="">How often do you smoke?</option>
                                <?php foreach ($smokes as $smoke):?>
                                <option value="<?php echo $smoke['id'] ?>">
                                    <?php echo $smoke['name'] ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-6">
                            <button id="step_eight" 
                            data-dialog="step_nine_dialog">
                            Continue
                            </button>
                        </div>
                        <div class="col col-md-6">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Tell US Six -->
<div class="modal-container get-info-modals" id="step_seven_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">
                TELL US ABOUT YOURSELF
                </h3>
                <p>
                    Answer a few profile questions. It's a simple, 
                    fun way to tell your story.
                </p>
            </div>
            <div class="modal-body">
                <div class="floating-container">
                    <div class="row">
                        <div class="col col-md-12">
                            <h3 class="text-center">
                            WHAT I PLAN FOR THE FUTURE</h3>
                            <textarea name="futureplan" id="futureplan" placeholder="Write something here..." style="width:100%;height:150px"></textarea>

                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col col-md-6">
                            <button id="step_seven" 
                            data-dialog="step_eight_dialog">
                            Continue
                            </button>
                        </div>
                        <div class="col col-md-6">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Tell US Five -->
<div class="modal-container get-info-modals" id="step_six_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">
                TELL US ABOUT YOURSELF
                </h3>
                <p>
                    Answer a few profile questions. It's a simple, 
                    fun way to tell your story.
                </p>
            </div>
            <div class="modal-body">
                <div class="floating-container">
                    <div class="row">
                        <div class="col col-md-12">
                            <h3 class="text-center">
                            WHAT I LIKE TO DO</h3>
                            <textarea name="liketodo" id="liketodo" placeholder="Write something here..." style="width:100%;height:150px"></textarea>

                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col col-md-6">
                            <button id="step_six" 
                            data-dialog="step_seven_dialog">
                            Continue
                            </button>
                        </div>
                        <div class="col col-md-6">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Tell US Four -->
<div class="modal-container get-info-modals" id="step_five_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">
                TELL US ABOUT YOURSELF
                </h3>
                <p>
                    Answer a few profile questions. It's a simple, 
                    fun way to tell your story.
                </p>
            </div>
            <div class="modal-body">
                <div class="floating-container">
                    <div class="row">
                        <div class="col col-md-12">
                            <h3 class="text-center">
                            AN AWESOME PLACE I'VE VISITED</h3>
                            <textarea name="visited" id="visited" placeholder="Write something here..." style="width:100%;height:150px"></textarea>

                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col col-md-6">
                            <button id="step_five" 
                            data-dialog="step_six_dialog">
                            Continue
                            </button>
                        </div>
                        <div class="col col-md-6">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Tell US Three -->
<div class="modal-container get-info-modals" id="step_four_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">
                TELL US ABOUT YOURSELF
                </h3>
                <p>
                    Answer a few profile questions. It's a simple, 
                    fun way to tell your story.
                </p>
            </div>
            <div class="modal-body">
                <div class="floating-container">
                    <div class="row">
                        <div class="col col-md-12">
                            <h3 class="text-center">A LITTLE MORE ABOUT ME</h3>
                            <textarea name="aboutme" id="aboutme" placeholder="Write something here..." style="width:100%;height:150px"></textarea>

                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col col-md-6">
                            <button id="step_four" data-dialog="step_five_dialog">
                            Continue
                            </button>
                        </div>
                        <div class="col col-md-6">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Tell US Two -->
<div class="modal-container get-info-modals" id="step_three_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">
                A FEW MORE OF THE BASICS
                </h3>
                <p>
                    Tell us a few more things about you. People with 
                    complete profiles go on more dates.
                </p>
            </div>
            <div class="modal-body">
                <div class="floating-container">
                    <div class="row">
                        <div class="col col-md-3">Children</div>
                        <div class="col col-md-9 full-width">
                            <select name="children" id="children">
                                <?php foreach ($children as $child):?>
                                <option value="<?php echo $child['id']; ?>"><?php echo $child['name'] ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3">Height</div>
                        <div class="col col-md-9 half-width">
                            <select name="feet" id="feet">
                                <option selected value="">Feet</option>
                                <?php for($i=4;$i<8;$i++): ?>
                                    <option value="<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <select name="inches" id="inches">
                                <option selected value="">Inches</option>
                                <?php for($i=0;$i<13;$i++): ?>
                                    <option value="<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3">Politics</div>
                        <div class="col col-md-9 half-width">
                            <select name="politics" id="politics">
                                <option value="0">Select your politics</option>
                                <?php foreach ($politics as $politic):?>
                                <option value="<?php echo $politic['id']; ?>"><?php echo $politic['name'] ?></option>
                                <?php endforeach;?>
                            </select>  
                            <select name="politics_importance" id="politics_importance">
                                <option value="">Importance Level</option>
                                <option>Very Important</option>
                                <option>Somewhat Important</option>
                                <option>Not Important</option>
                                <option>No Comment</option>
                            </select>    
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3">Exercise</div>
                        <div class="col col-md-9 full-width">
                            <select name="exercise" id="exercise">
                                <option value="">How often do you exercise?</option>
                                <?php foreach ($exercise as $exerz):?>
                                <option value="<?php echo $exerz['id']; ?>"><?php echo $exerz['name'] ?></option>
                                <?php endforeach;?>
                            </select>  
                        </div>
                    </div>


                    <div class="row">
                        <div class="col col-md-3">Body Type</div>
                        <div class="col col-md-9 full-width">
                            <select name="body_type_id" id="body_type_id">
                            <option value="" selected>Select your body type</option>
                            <?php foreach ($body_types as $body_type):?>
                                <option value="<?php echo $body_type['id'] ?>">
                                    <?php echo $body_type['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>  
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3">Drink</div>
                        <div class="col col-md-9 full-width">
                            <select name="drink" id="drink">
                                <option>How often do you drink?</option>
                                <?php foreach ($drinks as $drink):?>
                                <option value="<?php echo $drink['id']; ?>">
                                <?php echo $drink['name'] ?></option>
                                <?php endforeach;?>
                            </select>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3">Smoke</div>
                        <div class="col col-md-9 full-width">
                            <select name="smoke" id="smoke">
                                <option value="">How often do you smoke?</option>
                                <?php foreach ($smokes as $smoke):?>
                                <option value="<?php echo $smoke['id']; ?>">
                                <?php echo $smoke['name'] ?></option>
                                <?php endforeach;?>
                            </select>   
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"></div>
                        <div class="col col-md-9">
                            <button id="step_three" data-dialog="step_four_dialog">
                            Continue
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tell US One -->
<div class="modal-container get-info-modals" id="step_two_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">
                TELL US ABOUT YOURSELF
                </h3>
                <p>
                    Fill in a few basic facts. It'll help us send you 
                    people you'll like and dates you'll want to go on.
                </p>
            </div>
            <div class="modal-body">
                <div class="floating-container">
                    <div class="row">
                        <div class="col col-md-3">Career</div>
                        <div class="col col-md-9">
                            <input name="career" id="career" 
                            type="text" maxlength="20" 
                            placeholder="e.g. Graphics Designer">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3">Education</div>
                        <div class="col col-md-9 full-width">
                            <select name="education" id="education">
                            <option value="" selected>Select your education</option>
                            <?php foreach ($educations as $education):?>
                                <option value="<?php echo $education['id'] ?>">
                                    <?php echo $education['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3">Ethnicity</div>
                        <div class="col col-md-9 half-width">
                            <select name="ethnicity" id="ethnicity">
                                <option value="">Select your ethnicity</option>
                                <?php foreach ($ethnicities as $ethnicity) : ?>
                                    <option value="<?php echo $ethnicity['id']; ?>"> <?php echo $ethnicity['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>  
                            <select name="match_ethnicity" id="match_ethnicity">
                                <option value="">Match ethnicity</option>
                                <?php foreach ($ethnicities as $ethnicity) : ?>
                                    <option value="<?php echo $ethnicity['id']; ?>" ><?php echo $ethnicity['name']; ?></option>
                                <?php endforeach; ?>
                            </select>   
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3">Faith</div>
                        <div class="col col-md-9 half-width">
                            <select name="faith" id="faith">
                                <option value="">Select your faith</option>
                                <?php foreach ($faiths as $faith) : ?>
                                    <option value="<?php echo $faith['id']; ?>">
                                    <?php echo $faith['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>   
                            <select name="faith_importance" id="faith_importance">
                                <option>Importance Level</option>
                                <option>Very Important</option>
                                <option>Somewhat Important</option>
                                <option>Not Important</option>
                                <option>No Comment</option>
                            </select>     
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"></div>
                        <div class="col col-md-9">
                            <input type="checkbox">
                            I'd rather date people who have my faith (we'll keep this private)   
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"></div>
                        <div class="col col-md-9">
                            <button id="step_two" data-dialog="step_three_dialog">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Account -->
<div class="modal-container account-modal" id="create_account">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body modal-privacy">
                <div class="row">
                    <div class="col col-md-7">
                        <div id="popup_one_text">
                            <h3>Sign Up Now & <span class="blue">Meet</span>
                             <span class="purple">Your</span> 
                             <span class="green">Dream</span> 
                             <span class="yellow">Match</span>
                             </h3>
                            <p>
                                Your first name, last name and state of your
                                billing address must match your credit card 
                                information in order to subscribe to 
                                whereweallmet.com.
                            </p>
                        </div>
                    </div>
                    
                    <div class="col col-md-5 account-form">
                        <h2>Create a Free Account</h2>
                        <div class="row">
                            <div class="col col-md-4">
                                Zip Code
                            </div>
                            <div class="col col-md-8">
                                <input type="text" name="zipcode" id="zipcode">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-4">
                                Birthday
                            </div>
                            <div class="col col-md-8">

                                <select name="day" id="day" class="inline">
                                    <option value="">Day</option>
                                    <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <option ><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="month" id="month" class="inline">
                                    <option value="">Month</option>
                                    <?php for ($i = 1; $i <= 12; $i++): ?>                              
                                    <option><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select id="year" class="inline">
                                    <option value="">Year</option>
                                    <?php for ($i = date('Y') - 18; $i >= 1915; $i--): ?>                      
                                        <option><?php echo $i; ?></option>
                                     <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-4">
                                First Name
                            </div>
                            <div class="col col-md-8">
                                <input type="text" name="firstname" id="firstname" 
                            placeholder="Your first name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-md-4">
                                Last Name
                            </div>
                            <div class="col col-md-8">
                                <input type="text" name="lastname" id="lastname" 
                            placeholder="Your last name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-md-4">
                                Email
                            </div>
                            <div class="col col-md-8">
                                <input type="text" name="email" id="email" 
                            placeholder="Enter your email ">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col col-md-4">
                                Username
                            </div>
                            <div class="col col-md-8">
                                <input type="text" name="username" id="username" 
                            placeholder="Enter your username ">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col col-md-4">
                                Password
                            </div>
                            <div class="col col-md-8">
                                <input type="password" name="password" id="password" 
                            placeholder="Enter your password">
                            </div>
                        </div>


                        
                        <div class="row">
                            <div class="col col-md-4">
                                Confirm
                            </div>
                            <div class="col col-md-8">
                                <input type="password" name="confirm" id="confirm" 
                            placeholder="Confirm your password">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col col-md-4">
                            </div>
                            <div class="col col-md-8">
                                <button id="step_one" data-dialog="step_two_dialog">
                                Get Started Now
                                </button>
                                
                            </div>

                        <div class="clearfix">
                        </div>
                        <p><strong>By signing up you agree to the 
                        <span class="purple"><a href="#">Terms of Use</a></span> 
                        and the <span class="purple"><a href="#">Privacy Policy</a>
                        </span></strong></p>
                    </div>
            </div>

                </div>

                    <div class="col col-md-4"></div>

            </div>
            </div>
        </div>
    </div>
    
</div>



<script>
 function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInp").change(function(){
        readURL(this);
       
    });

</script>
