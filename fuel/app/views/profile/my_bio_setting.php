<script type="text/javascript"> 
function confirmDelete() { 
 return confirm("Are you sure you want to delete?");   
} 
</script> 

<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <div id="profile-pic"><?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
                <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
            </div>
        </div>
        <?php echo View::forge("profile/partials/setting_nav"); ?>
    </aside>
    <div id="middle">

        
        <div class="header-section">
            <p class="header-text">Bio</p>
        </div>

        <div class="form-wrapper profile-form bio-form">
        
           <form method="post" action="<?php echo Uri::create('profile/update_bio_setting');?>" class="form" enctype="multipart/form-data">
              <div class="inner-wrapper">


                    <p class="lbl">Tell me about your hobbies. Be impressive!</p>
                    <div class="form-inline">
                        <textarea name="about_me"><?php if(isset($current_profile->about_me)){
                           echo $current_profile->about_me; }?></textarea>
                        <p class="below-bio">The more you write, the easier it is for others to get to know your interests. Minimum 80 Characters</p>
                    </div> 
                <div id='more'>
                    <p class="more-wrap more-wrap-bio">
                        <a href="#">Show More Questions (Optional)</a>
                    </p>
                </div>
                <div id='showmore-list'>

                    <p class="lbl">Awesome Places That I've Visited</p>
                    <div class="form-inline">
                        <textarea name="places_visted"><?php if(isset($current_profile->places_visted)){
                           echo $current_profile->places_visted; }?></textarea>
                    </div>
                    <p class="lbl">What I'm Looking for</p><hr/><br/>
                    <div class="field">
                        <p class="label">Age</p>

                        <strong>From </strong>
                        <select name="ages_from">
                            <?php for($i=18; $i<100;$i++): ?>
                                <option value="<?php echo $i;?>"
                                <?php if($current_profile->ages_from == $i) echo " selected "; ?>
                                >
                                <?php echo $i;?>
                                </option>
                            <?php endfor;?>
                        </select> 
                        <strong>To </strong>
                        <select name="ages_to">
                            <?php for($i=18; $i<100;$i++): ?>
                                <option value="<?php echo $i;?>"
                                <?php if($current_profile->ages_to == $i) echo " selected "; ?>
                                >
                                <?php echo $i;?>
                                </option>
                            <?php endfor;?>
                        </select> 
                        
                    </div> 
                    <div class="field">
                        <p class="label">Education</p>
                        <select name="seeking_education_id">
                            <option value="">Select your education</option>
                            <?php
                            foreach ($educations as $education):
                            ?>
                                <option 
                                <?php if($current_profile->seeking_education_id == $education['id']) echo 'selected ' ?>
                                value="<?php echo $education['id']; ?>">
                                <?php echo $education['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div> 


                    <div class="field">
                        <p class="label">Occupation</p>
                        <select name="seeking_occupation_id">
                            <option value="">Select your occupation</option>
                            <?php
                            foreach ($occupations as $occupation):
                            ?>
                                <option 
                                <?php if($current_profile->seeking_occupation_id == $occupation['id']) echo 'selected ' ?>
                                value="<?php echo $occupation['id']; ?>">
                                <?php echo $occupation['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div> 

                     <div class="field">
                        <p class="label">Ethnicity</p>
                        <select name="seeking_ethnicity_id">
                            <option value="">Select ethniciy</option>
                            <?php foreach ($ethnicities as $ethnicity) : ?>
                                        <?php
                                        $selected = '';
                                        if ($ethnicity['id'] == $current_profile->seeking_ethnicity_id)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $ethnicity['id']; ?>" <?php echo $selected; ?>><?php echo $ethnicity['name']; ?></option>
                            <?php endforeach; ?>
                        </select>    
                    </div>  

                    <div class="field">
                        <p class="label">Faith</p>
                        <select name="seeking_religion_id">
                            <option value="">Select your faith</option>
                            <?php
                            foreach ($faiths as $faith):
                            ?>
                                <option 
                                <?php if($current_profile->seeking_religion_id == $faith['id']) echo 'selected ' ?>
                                value="<?php echo $faith['id']; ?>">
                                <?php echo $faith['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>               

                    <div class="field">
                        <p class="label">Children</p>
                        
                        <select name="seeking_children_id" class="long">
                            <option value="">Do you want children</option>
                            <?php
                            foreach ($children as $child):
                            ?>
                                <option 
                                <?php if($current_profile->seeking_children_id == $child['id']) echo 'selected ' ?>
                                value="<?php echo $child['id']; ?>">
                                <?php echo $child['name'] ?>
                                </option>
                            <?php endforeach;?>
                                       
                            </select>   
                    </div> 
                    <div id="seeking_height_container" class="field">
                        <p class="label">Height</p>
                        <select name="seeking_height">
                            <option value="" <?php if($current_profile->seeking_height == "") echo " selected ";?>></option>
                            <option <?php if($current_profile->seeking_height == "4'11\" to 5'3\"") echo " selected ";?>>4'11" to 5'3"</option>
                            <option <?php if($current_profile->seeking_height == "5'4\" to 5'7\"") echo " selected ";?>>5'4" to 5'7"</option>
                            <option <?php if($current_profile->seeking_height == "5'8\" to 6'0\"") echo " selected ";?>>5'8" to 6'0"</option>
                            <option <?php if($current_profile->seeking_height == "6'1\" to 6'4\"") echo " selected ";?>>6'1" to 6'4"</option>
                            <option <?php if($current_profile->seeking_height == "6'5\" to 6'9\"") echo " selected ";?>>6'5" to 6'9"</option>
                            <option <?php if($current_profile->seeking_height == "6'10\" to 7'0\"") echo " selected ";?>>6'10" to 7'0"</option>
                            <option <?php if($current_profile->seeking_height == "7'1\" to +") echo " selected ";?>>7'1" to +</option>
                        </select>
                    </div>
                    <div class="field">
                        <p class="label">Politics</p>
                        <select name="seeking_politics_id">
                            <option value="">What is your political inclination?</option>
                            <?php
                            foreach ($politics as $politic):
                            ?>
                                <option 
                                <?php if($current_profile->seeking_politics_id == $politic['id']) echo 'selected ' ?>
                                value="<?php echo $politic['id']; ?>">
                                <?php echo $politic['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>  

                    <div class="field">
                        <p class="label">Exercise</p>
                        <select name="seeking_exercise_id">
                            <option value="">How often do you exercise?</option>
                            <?php
                            foreach ($exercises as $exercise):
                            ?>
                                <option 
                                <?php if($current_profile->seeking_exercise_id == $exercise['id']) echo 'selected ' ?>
                                value="<?php echo $exercise['id']; ?>">
                                <?php echo $exercise['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>


                    <div class="field">
                        <p class="label">Body type</p>
                        <select name="seeking_body_type_id">
                            <option value="">Select your body type</option>
                            <?php
                            foreach ($body_types as $body_type):
                            ?>
                                <option 
                                <?php if($current_profile->seeking_body_type_id == $body_type['id']) echo 'selected ' ?>
                                value="<?php echo $body_type['id']; ?>">
                                <?php echo $body_type['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>


                        <div class="field">
                        <p class="label">Smoke</p>
                        <select name="seeking_smoke_id">
                            <option value="">How often do you smoke?</option>
                            <?php
                            foreach ($smokes as $smoke):
                            ?>
                                <option 
                                <?php if($current_profile->seeking_smoke_id == $smoke['id']) echo 'selected ' ?>
                                value="<?php echo $smoke['id']; ?>">
                                <?php echo $smoke['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>           

                    <div class="field">
                        <p class="label">Drinking</p>
                        <select name="seeking_drink_id">
                            <option value="">How often do you drink?</option>
                            <?php
                            foreach ($drinks as $drink):
                            ?>
                                <option 
                                <?php if($current_profile->seeking_drink_id == $drink['id']) echo 'selected ' ?>
                                value="<?php echo $drink['id']; ?>">
                                <?php echo $drink['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div> 

                    <hr/>

                    <p class="lbl">What I like to do</p>
                    <div class="form-inline">
                        <textarea name="like_doing"><?php if(isset($current_profile->like_doing)){
                           echo $current_profile->like_doing; }?></textarea>
                    </div>  

                    <p class="lbl">What I Plan for the future</p>
                    <div class="form-inline">
                        <textarea name="plan_for_future"><?php if(isset($current_profile->plan_for_future)){
                           echo $current_profile->plan_for_future; }?></textarea>
                    </div> 
                </div>                                        

                    </div>

                    <div class="submit-btn">
                            <div class="btn-wrap gold-bg">
                            <input type="submit" name="submit" value="SAVE" />
                            </div>
                    </div>

            </form>
        </div>

        <div class="border-icon1"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div> 
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div> 

    </div> <!-- end of middle -->
</div>
