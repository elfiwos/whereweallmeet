<!-- client detail view of a respective dating agent -->
<div id="content" class="clearfix">
    <aside id="left-sidebar">
    <div id="profile-summary">
        <div class="content">
            
            <div id="profile-pic">
            <?php echo Asset::img("temp/dating-agent_propic.jpg"); ?>
            </div>
            <div id="profile_name"> Dating Agent2</div>
            <div id="states">
                <?php echo Asset::img("state_icons.png"); ?> Losangeles, CA
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
              <p class="header-text">Hello</p>
          </div>
            
            <div class="content">
                <div id="description">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. 
                    </p>
                    <p class="gray-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. 
                    </p>
                </div>

            </div>
        </section>   

        <section id="latest-members" class="agent-profile">
          <div class="header-section">
              <p class="header-text">A few words about myself...</p>
          </div>
            
            <div class="content">
                <div id="description">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. 
                    </p>
                </div>

            </div>
        </section>  

                 <section id="latest-members" class="agent-profile">
          <div class="header-section">
              <p class="header-text">My Goal for you!</p>
          </div>
            
            <div class="content">
                <div id="description">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. 
                    </p>
                    <p class="gray-text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt 
                    </p>
                </div>

            </div>
        </section>  
        <div class="get-started get-started-profile">
            <div class="btn-wrap gold-bg">
                    <a href="#">GET STARTED TODAY - IT ONLY TAKES A MINUTE</a>
            </div>    
        </div>
        <div class="border-icon1-pagent"></div>
        <div class="border-icon2-pagent"></div>
        <div class="border-circle border-circle-1-pagent"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-2-pagent"><?php echo Asset::img('line_end.png'); ?></div>
    </div>
</div>
