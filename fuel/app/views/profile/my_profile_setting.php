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
            <p class="header-text">Profile</p>
        </div>

        <div class="form-wrapper profile-form">
        

            <form method="post" action="<?php echo Uri::create('profile/update_profile_setting');?>" class="form" enctype="multipart/form-data">
              <div class="inner-wrapper">
                  <div class="profile-field">
                    <p class="label"><strong>Where are you located?</strong></p>
                    <div class="form-inline">
                        <input name="city" type="text" placeholder="City..." value="<?php  echo isset($profile->city) ? $profile->city : ""; ?>" >

                        <select name="state">
                            <option value="">State</option>
                            <?php foreach ($state as $item) : ?>
                                <?php $selected = ($item->name == $profile->state ? 'selected' : ''); ?>
                                <option value="<?php echo $item->name; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input name="zip" type="text" placeholder="Zip/Postal" value="<?php  echo isset($profile->zip) ? $profile->zip : ""; ?>">
                    </div>
                   </div>

                    <p class="lbl"><strong>When is your birthday(m/d/y)?</strong></p>

                    <div class="form-inline">
                        <select name="month">
                            <option value="">Month</option>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <?php $selected = ($i == date('m', $profile->birth_date) ? 'selected' : ''); ?>
                                <option <?php echo $selected; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="day">
                            <option value="">Day</option>
                            <?php for ($i = 1; $i <= 31; $i++): ?>
                                <?php $selected = ($i == date('d', $profile->birth_date) ? 'selected' : ''); ?>
                                <option <?php echo $selected; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="year">
                            <option value="">Year</option>
                            <?php for ($i = date('Y') - 18; $i >= 1915; $i--): ?>
                                <?php $selected = ($i == date('Y', $profile->birth_date) ? 'selected' : ''); ?>
                                <option <?php echo $selected; ?>><?php echo $i; ?></option>
                             <?php endfor; ?>
                        </select>                                                                   
                    </div>

                     <div class="field">
                        <p class="label">Job / Career</p>
                        <input name="career" type="text" placeholder="Career..." value="<?php  echo isset($profile->career) ? $profile->career : ""; ?>" >
                        <!--<select name="occupation_id" class="long">
                                    <option value="1" <?php /*if ($profile->occupation_id == 1)
                                        echo ' selected="selected"'; ?>>Administrative / Secretarial</option>
                                    <option value="2" <?php if ($profile->occupation_id == 2)
                                                echo ' selected="selected"'; ?>>Artistic / Creative / Performance</option>
                                    <option value="3" <?php if ($profile->occupation_id == 3)
                                                echo ' selected="selected"'; ?>>Executive / Management</option>
                                    <option value="5" <?php if ($profile->occupation_id == 5)
                                                echo ' selected="selected"'; ?>>Financial services</option>
                                    <option value="6" <?php if ($profile->occupation_id == 6)
                                                echo ' selected="selected"'; ?>>Labor / Construction</option>
                                    <option value="7" <?php if ($profile->occupation_id == 7)
                                                echo ' selected="selected"'; ?>>Legal</option>
                                    <option value="8" <?php if ($profile->occupation_id == 8)
                                                echo ' selected="selected"'; ?>>Medical / Dental / Veterinary</option>
                                    <option value="9" <?php if ($profile->occupation_id == 9)
                                                echo ' sele cted="selected"'; ?>>Sales / Marketing</option>
                                    <option value="10" <?php if ($profile->occupation_id == 10)
                                                echo ' selected="selected"'; ?>>Technical / Computers / Engineering</option>
                                    <option value="11" <?php if ($profile->occupation_id == 11)
                                                echo ' selected="selected"'; ?>>Travel / Hospitality / Transportation</option>
                                    <option value="12" <?php if ($profile->occupation_id == 12)
                                                echo ' selected="selected"'; ?>>Political / Govt / Civil Service / Military</option>
                                    <option value="13" <?php if ($profile->occupation_id == 13)
                                                echo ' selected="selected"'; ?>>Retail / Food services</option>
                                    <option value="14" <?php if ($profile->occupation_id == 14)
                                                echo ' selected="selected"'; ?>>Teacher / Professor</option>
                                    <option value="15" <?php if ($profile->occupation_id == 15)
                                                echo ' selected="selected"'; ?>>Student</option>
                                    <option value="16" <?php if ($profile->occupation_id == 16)
                                                echo ' selected="selected"'; ?>>Retired</option>
                                    <option value="17" <?php if ($profile->occupation_id == 17)
                                                echo ' selected="selected"'; */ ?>>Other profession</option>
                            </select>   -->
                    </div>   
                     <div class="field">
                        <p class="label">Children</p>
                        
                        <select name="children_id" class="long">
                            <option value=""></option>
                            <?php
                            foreach ($children as $child):
                            ?>
                                <option 
                                <?php if($profile->children_id == $child['id']) echo 'selected ' ?>
                                value="<?php echo $child['id']; ?>">
                                <?php echo $child['name'] ?>
                                </option>
                            <?php endforeach;?>
                                       
                            </select>   
                    </div>   
<?php
$feetAndInches = explode('**', $profile->height);
$height_array = explode("*", $feetAndInches[0]);
if(isset($height_array[0]))
    $feet = $height_array[0];
if(isset($height_array[1]))
    $inches = $height_array[1];
?>
                    <div class="field">
                        <p class="label">Height</p>

                        <strong>Feet </strong>
                        <select name="feet">
                            <option value="">Feet</option>
                            <?php for($i=4;$i<8;$i++): ?>
                                <option 
                                <?php 
                                    if(isset($feet) && ($i == $feet))
                                        echo 'selected ';
                                ?>
                                value="<?php echo $i; ?>">
                                <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select> 
                        <strong>Inches </strong>
                        <select name="inches">
                            <option value="">Inches</option>
                            <?php for($i=0;$i<13;$i++): ?>
                                <option 
                                <?php 
                                    if(isset($inches) && ($i == $inches))
                                        echo 'selected ';
                                ?>
                                value="<?php echo $i; ?>">
                                <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select> 
                        
                    </div>

                    <div class="field">
                        <p class="label">Education</p>
                        <select name="education_id">
                            <option value="">Select your education</option>
                            <?php
                            foreach ($educations as $education):
                            ?>
                                <option 
                                <?php if($profile->education_id == $education['id']) echo 'selected ' ?>
                                value="<?php echo $education['id']; ?>">
                                <?php echo $education['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>  

                     <div class="field">
                        <p class="label">Ethnicity</p>
                        <select name="ethnicity_id">
                            <option value="">Select your ethnicity</option>
                            <?php foreach ($ethnicities as $ethnicity) : ?>
                                        <?php
                                        $selected = '';
                                        if ($ethnicity['id'] == $profile->ethnicity_id)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $ethnicity['id']; ?>" <?php echo $selected; ?>><?php echo $ethnicity['name']; ?></option>
                            <?php endforeach; ?>
                        </select>    
                    </div>  

                    <div class="field">
                        <p class="label">Faith</p>
                        <select name="faith_id">
                            <option value="">Select your faith</option>
                            <?php
                            foreach ($faiths as $faith):
                            ?>
                                <option 
                                <?php if($profile->faith_id == $faith['id']) echo 'selected ' ?>
                                value="<?php echo $faith['id']; ?>">
                                <?php echo $faith['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>               

                    <div class="field">
                        <p class="label">Politics</p>
                        <select name="politics_id">
                            <option value="">Select your politics</option>
                            <?php
                            foreach ($politics as $politic):
                            ?>
                                <option 
                                <?php if($profile->politics_id == $politic['id']) echo 'selected ' ?>
                                value="<?php echo $politic['id']; ?>">
                                <?php echo $politic['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>  

                    <div class="field">
                        <p class="label">Exercise</p>
                        <select name="exercise_id">
                            <option value="">Select your exercise</option>
                            <?php
                            foreach ($exercises as $exercise):
                            ?>
                                <option 
                                <?php if($profile->exercise_id == $exercise['id']) echo 'selected ' ?>
                                value="<?php echo $exercise['id']; ?>">
                                <?php echo $exercise['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>  

                    <div class="field">
                        <p class="label">Body Type</p>
                        <select name="body_type_id">
                            <option value="">Select your exercise</option>
                            <?php
                            foreach ($body_types as $body_type):
                            ?>
                                <option 
                                <?php if($profile->body_type_id == $body_type['id']) echo 'selected ' ?>
                                value="<?php echo $body_type['id']; ?>">
                                <?php echo $body_type['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>         

                        <div class="field">
                        <p class="label">How often do you smoke?</p>
                        <select name="smoke_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($smokes as $smoke):
                            ?>
                                <option 
                                <?php if($profile->smoke_id == $smoke['id']) echo 'selected ' ?>
                                value="<?php echo $smoke['id']; ?>">
                                <?php echo $smoke['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>           

                    <div class="field">
                        <p class="label">How often do you drink?</p>
                        <select name="drink_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($drinks as $drink):
                            ?>
                                <option 
                                <?php if($profile->drink_id == $drink['id']) echo 'selected ' ?>
                                value="<?php echo $drink['id']; ?>">
                                <?php echo $drink['name'] ?>
                                </option>
                            <?php endforeach;?>
                        </select>    
                    </div>  
                   <!-- <div class="field">
                        <p class="label">Body Type</p>
                        <select name="body_type_id">
                            <?php /*foreach ($body_types as $body_type) : ?>
                                 
                                        <?php
                                        $selected = '';
                                        if ($body_type['id'] == $profile->body_type_id)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $body_type['id']; ?>" <?php echo $selected; ?>><?php echo $body_type['name']; ?></option>
                                    <?php endforeach; ?>
                        </select>    
                    </div>   

                    

                    <div class="field">
                        <p class="label">What are your prefered ages?</p>
                        <?php $ages = range(18, 100); ?>
                        <select class="age-inline-select" name="ages_from">
                           <?php foreach ($ages as $age) : ?>
                                        <?php
                                        $selected = '';
                                        if ($age == $profile->ages_from)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $age; ?>" <?php echo $selected; ?>><?php echo $age; ?></option>
                           <?php endforeach; ?>
                        </select> 
                        <span>&nbsp;to&nbsp;</span>
                        <select class="age-inline-select" name="ages_to">
                             <?php foreach ($ages as $age) : ?>
                                        <?php
                                        $selected = '';
                                        if ($age == $profile->ages_to)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $age; ?>" <?php echo $selected; ?>><?php echo $age; ?></option>
                             <?php endforeach; */?>
                        </select>                         
                        <div class="clearfix"></div>   
                    </div> -->
               <!-- <div id='more'>
                    <p class="more-wrap">
                        <span><a href="#">Show More Details</a></span>
                    </p>
                </div> 
                <div id='showmore-list'>
                    <div class="field">
                        <p class="label">Looking for</p>
                        <select name="seeking_gender_id">
                            <?php /* foreach ($genders as $gender) : ?>
                                        <?php
                                        $selected = '';
                                        if ($gender['id'] == $profile->seeking_gender_id)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $gender['id']; ?>" <?php echo $selected; ?>><?php echo $gender['name']; ?></option>
                            <?php endforeach; ?>
                        </select>    
                    </div>

                    <div class="field">
                        <p class="label">relationship status</p>
                        <select name="relationship_status_id">
                             <option value="1" <?php if ($profile->relationship_status_id == 1)
                                                echo ' selected="selected"'; ?>>Single</option>
                            <option value="2" <?php if ($profile->relationship_status_id == 2)
                                                echo ' selected="selected"'; ?>>Married</option>
                            <option value="3" <?php if ($profile->relationship_status_id == 3)
                                                echo ' selected="selected"'; ?>>Divorced</option>
                            <option value="4" <?php if ($profile->relationship_status_id == 4)
                                                echo ' selected="selected"'; ?>>Separated</option>
                            <option value="5" <?php if ($profile->relationship_status_id == 5)
                                                echo ' selected="selected"'; ?>>Attached</option>
                            <option value="6" <?php if ($profile->relationship_status_id == 7)
                                                echo ' selected="selected"'; ?>>Widowed</option>
                        </select>    
                    </div> 

                

                                                                                                                            


                   

                    <div class="field">
                        <p class="label">Income</p>
                        <select name="income_id">
                            <option value="1" <?php if ($profile->income_id == 1)
                                                echo ' selected="selected"'; ?>>Rather Not Say</option>
                            <option value="2" <?php if ($profile->income_id  == 2)
                                                echo ' selected="selected"'; ?>>Less than 50K USD</option>
                            <option value="3" <?php if ($profile->income_id == 3)
                                                echo ' selected="selected"'; ?>>$50K – $75K USD</option>
                            <option value="4" <?php if ($profile->income_id  == 4)
                                                echo ' selected="selected"'; ?>>$75K – $100K USD</option>
                            <option value="5" <?php if ($profile->income_id  == 5)
                                                echo ' selected="selected"'; ?>>$100K – $150K USD</option>
                            <option value="6" <?php if ($profile->income_id  == 6)
                                                echo ' selected="selected"'; ?>>$150K - $200K USD</option>
                            <option value="7" <?php if ($profile->income_id  == 7)
                                                echo ' selected="selected"'; ?>>$200K – $300K USD</option>
                            <option value="8" <?php if ($profile->income_id  == 8)
                                                echo ' selected="selected"'; ?>>$300K – $500K USD</option>
                            <option value="9" <?php if ($profile->income_id  == 9)
                                                echo ' selected="selected"'; ?>>$500K - $ 1 Million USD</option>
                            <option value="10" <?php if ($profile->income_id  == 10)
                                                echo ' selected="selected"'; */ ?>>More than $1 Million USD</option>
                        </select>    
                    </div>    

                    </div> -->
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
