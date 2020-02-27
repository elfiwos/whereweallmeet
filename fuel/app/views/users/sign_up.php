<div id="content" >
    <div id="top-section-border"></div>
    <div id="top-section" class="clearfix">
        <div id="top-section-content" class="clearfix">
            <div id="logo-container">
                <a href="<?php echo Uri::base(false);?>"><?php echo Asset::img('pages/home2/logo-medium.png'); ?></a>
            </div>
            <div id="login-button-container" class="clearfix">
                <?php echo Html::anchor("users/login", "Login", array("id"=> "login-button")); ?>
            </div>
        </div>
    </div>
    <div id="our-services-container" >

    </div>
    <div id="center-form-container" class="sign-up">
        <?php if(isset($success)): ?>
            <div id="confirmation">
                <h2>Sign up successful</h2>
                <div>
                    <p>A message has been sent to your email. Please use the link provided in your email to activate your account.</p>
                    <p>Please check your spam folder in your email if you don't see the authentication email in your inbox folder.</p>
                </div>
            </div>
        <?php  else: ?>
            <div>
                <?php echo Form::open(array("action" => "/users/m_sign_up/" . $invited_by_id, "enctype" => "multipart/form-data" , "class" => "clearfix")) ?>
                <?php if (isset($error)) { ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php } ?>

                <p>
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" id="profile-picture" name="picture" size="1"/>
                </p>
                <p>
                    <label for="first_name">Zip Code:</label>
                    <?php echo Form::input('zip', Validation::instance()->validated('zip')); ?>
                    <span class="error with-margin"><?php echo Validation::instance()->error('zip'); ?></span>
                </p>
                <p>
                    <label for="first_name">Birthday(d/m/y):</label>
                    <select name="day" id="day" class="inline">
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option ><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="month" id="month" class="inline">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <select name="year" id="year" class="inline">
                        <?php for ($i = date('Y') - 18; $i >= 1915; $i--): ?>
                            <option><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </p>
                <p>
                    <label for="first_name">First Name:</label>
                    <?php echo Form::input('first_name', Validation::instance()->validated('first_name')); ?>
                    <span class="error with-margin"><?php echo Validation::instance()->error('first_name'); ?></span>
                </p>
                <p>
                    <label for="last_name">Last Name:</label>
                    <?php echo Form::input('last_name', Validation::instance()->validated('last_name')); ?>
                    <span class="error with-margin"><?php echo Validation::instance()->error('last_name'); ?></span>
                </p>
                <p>
                    <label for="email">Email:</label>
                    <?php echo Form::input('email', Validation::instance()->validated('email')); ?>
                    <span class="error with-margin"><?php echo Validation::instance()->error('email'); ?></span>
                </p>
                <p>
                    <label for="username">Username:</label>
                    <?php echo Form::input('username', Validation::instance()->validated('username')); ?>
                    <span class="error with-margin"><?php echo Validation::instance()->error('username'); ?></span>
                <p>
                    <label for="password">Password:</label>
                    <?php echo Form::password('password', ''); ?>
                    <span class="error with-margin"><?php echo Validation::instance()->error('password'); ?></span>
                </p>
                <p>
                    <label for="confirm_password">Confirm Password:</label>
                    <?php echo Form::password('confirm_password', ''); ?>
                    <span class="error with-margin"><?php echo Validation::instance()->error('confirm_password'); ?></span>

                        <?php echo Form::hidden('disable', Input::post('disable'), array('class' => 'error with-margin', 'placeholder'=>'Message status'));  ?>
                </p>
                <p>
                    <label>Gender:</label>
                    <select id="select-gender" name="gender_id">
                        <?php foreach ($genders as $item) : ?>
                            <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p class="submit">
                    <input type="submit" name="btnGetStartedHim" value="Create Your Account"/>
                    <span>By signing up you agree to the <a target="_blank" href="http://whereweallmeet.com/blog/terms/">Terms of Use</a> and the <a target="_blank" href="http://whereweallmeet.com/blog/privacy/">Privacy Policy</a></span>
                </p>
                <?php echo Form::close(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>