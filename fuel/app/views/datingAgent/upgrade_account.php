<!-- user upgrade account -->
<div id="content" class="clearfix">
    <aside id="left-sidebar">
    <div id="profile-summary">
        <div class="content">
            
            <div id="profile-pic">
            <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($agent->picture, $agent->user_id, "profile_medium"))); ?>
            </div>
            <div id="profile_name"> <?php echo $agent->first_name; ?></div>
            <div id="states">
                <?php echo Asset::img("state_icons.png"); ?> <?php echo $agent->state;?>
                <?php echo Asset::img("agent-gear.jpg"); ?> </div>
        </div>
    </div>
    <div id="online-status-container">
       <?php echo Asset::img("online_dot.png"); ?>  Hello, I'm Online   </div>
    <div class="profile-sub-menu">
        <a id="book-me" class="menu-btn menu-btn-book"  href="#"><i class="book-me"></i>Book Me</a>
        <a id="send-message" class="menu-btn menu-btn-msg"  href="#"><i class="send-msg"></i>Send Message</a>
        <a id="send-chat" class="menu-btn menu-btn-chat"  href="#"><i class="chat"></i>Chat With Me</a>
        <div class="latest-invites"><a href="<?php echo Uri::create("agent"); ?>"><p><?php echo Asset::img('profile/chat-icon.png'); ?></p><p>Live agents online</p><?php echo '(' . $countOnlineDatingAgents . ')' ?><p>Chat Now!</p></a></div>
    </div>
    <div id="invite-friend-container">
        <p>REFER ME To A FRIEND</p>
        <a href="#"><i class="refer-me"></i>REFER ME</a>
    </div>
    </aside>
    <div id="middle" class="agent-profile-middle">
        <section id="latest-members" class="agent-profile">
          <div class="header-section">
              <p class="header-text">Concierge Agent</p>
          </div>
            
            <div class="content">
                <div id="description">
                    <p>
                        Where We All Meet Concierge agents are like your own personal dating agent. Our goal is to build
                        a personal relationship with WWAM members, that way we can get a better sense of your
                        personality and what you are looking for in order to find you the right match. Our agents are here
                        to simply guide you through the dating process and be there if you need any advice. Take a look
                        and see what our social agent services provide.
                    </p>

                </div>

            </div>
        </section>   

        <section id="latest-members" class="agent-profile agent-form">
          <div class="header-section">
              <p class="header-text">Enter Your Payment Info</p>
          </div>
           <?php echo Form::open(array("action" => "membership/account_upgrade", "id" => "upgrade-form", "class" => "clearfix")) ?>
                <div class="form-content">
                    <p class="header-text"><strong>Enter Your Payment Information</strong></p>
                    <div class="column ">
                        <div class="col">
                            <?php echo Form::input("first_name", $profile->first_name, array("class" => "required", "disabled"=>"", 'placeholder'=>"First Name")); ?>
                            <span class="error with-margin ">First Name is a required field</span>
                        </div>
                        <div class="col">
                            <?php echo Form::input("last_name", $profile->last_name, array("class" => "required", "disabled"=>"", 'placeholder'=>"Last Name" )); ?>
                            <span class="error with-margin ">Last Name is a required field</span>
                        </div>
                        <?php echo Form::input("agent_id", $agent->id, array("class" => "required", "type"=>"hidden" )); ?>
                        <select name="country" class="required" >
                            <?php foreach($countries as $country) {?>
                                <option value="<?php echo $country->id; ?>" <?php echo $country->id == $profile->id ? "selected" : "" ?>>
                                    <?php echo $country->name; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="col">
                            <?php echo Form::input("state" , $billing->state, array("class" => "required", 'placeholder'=>"State")); ?>
                            <span class="error with-margin ">State is a required field</span>
                        </div>
                        <div class="col">
                            <?php echo Form::input("city", $billing->city, array("class" => "required",'placeholder'=>"City")); ?>
                            <span class="error with-margin ">City is a required field</span>
                        </div>
                        <div class="col">
                            <?php echo Form::input("address", $billing->street_address, array("class" => "required",'placeholder'=>"Address")); ?>
                            <span class="error with-margin ">Address is a required field</span>
                        </div>
                        <div class="col">
                            <?php echo Form::input("postal_code", $billing->postal_code, array("class" => "short required",'placeholder'=>"Postal Code")); ?>
                            <span class="error with-margin ">Postal Code is a required field</span>
                        </div>
                        <div class="col">
                            <?php echo Form::input("email", $current_user->email, array("class" => "email required")); ?>
                            <span class="error with-margin">Email is a required field</span>
                            <span class="error with-margin email">Email should be in appropriate format</span>
                        </div>
                    </div>

                    <div class="column column2">
                        <div class="col">
                            <p class="lbl">Card Type</p>
                            <?php echo Form::select(
                                "card_type",
                                "none",
                                array(
                                    "" => "Please Select",
                                    "American Express" => "American Express",
                                    "Discover" => "Discover",
                                    "Mastercard" => "Mastercard",
                                    "Visa" => "Visa",
                                    "JCB" => "JCB",
                                    "Diners Club/ Carte Blanche" => "Diners Club/ Carte Blanche"
                                ),
                                array("class" => "required")
                            ); ?>
                            <span class="error with-margin ">Card Type is a required field</span>
                        </div>
                        <div class="col">
                            <p class="lbl">Card Number</p>
                            <?php echo Form::input("card_num", null, array("class" => "required")); ?>
                            <span class="error with-margin ">Card Number is a required field</span>
                        </div>
                        <div class="col">
                            <p class="lbl">Exp Date</p>
                            <select name="exp_month" class="required">
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                    <option
                                        value="<?php echo $i < 10 ? "0" . $i : $i; ?>"><?php echo $i < 10 ? "0" . $i : $i; ?></option>
                                <?php
                                }
                                $i = 0; ?>
                            </select>
                            <select name="exp_year" class="required">
                                <?php for ($i = date('Y'); $i <= date('Y') + 5; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                                }
                                $i = 0; ?>
                            </select>
                            <span class="error with-margin ">Expiry Date is a required field</span>
                        </div>
                        <div class="col">
                            <p class="lbl">Security Code</p>
                            <?php echo Form::input("security_code", null, array("class" => "short required")); ?>
                            <span class="error with-margin ">Security Code is a required field</span>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <p class="agreement">
                        <input id="agree-to-terms" type="checkbox" value="0">
                        <span>I have read and Agreed to Terms and Conditions</span>
                        <span class="error with-margin ">You must Agree to the Terms and Conditions</span>
                    </p>
                    <?php echo Form::input("id", $agent->id, array("class" => "",  'type'=>"hidden")); ?>
                </div>
                <button class="yellow-submit" type="submit"><span>UPGRADE NOW!</span></button>
                

           <?php echo Form::close(); ?>
        </section>  

        <section id="latest-members" class="agent-profile">
          <div class="header-section">
              <p class="header-text">How It Works</p>
          </div>
            
            <div class="content">
                <div id="description">
                    <p>
                        How it Works: Where We All Meet offers premium and personalized dating agent membership.
                        Premium service allows members to ask dating agents to search for their perfect match by
                        completing a private personal survey. The selected dating agent is there to provide dating advice
                        and more. One of our dating agents will respond within 48 hours. Personalized service allows
                        members the ability to live chat social agents for an instant response and If your social agent is
                        not online, you are guaranteed an answer within 24 hours.
                        Connect with one of our dating agents today and start living the social life you’ve always wanted.
                    </p>
                </div>

            </div>
        </section>  
        <div class="border-icon1-pagent"></div>
        <div class="border-icon2-pagent"></div>
        <div class="border-circle border-circle-1-pagent"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-2-pagent"><?php echo Asset::img('line_end.png'); ?></div>
    </div>
</div>
