<div id="content">
    <div class="header-content">
    <h1>Upgrade Now To Message, Chat, Travel & Experience The Full Version Of WhereWeAllMeet.com!</h1>
    <ul id="matches">
        <?php for ($i = 1; $i <= 6; $i++) { ?>
            <li class="match">
                <?php echo Asset::img("temp/upgrade_thumb_" . $i . ".jpg"); ?>
            </li>
        <?php } ?>
    </ul>
    </div>

    <?php echo Form::open(array("action" => "membership/account_upgrade", "id" => "upgrade-form", "class" => "clearfix")) ?>
    <div id="plan">
        <h2>Choose The Right Plan For You!</h2>

        <div class="details-container">
            <ul>
                <?php foreach ($payment_types as $payment_type) { ?>
                    <?php $has_paid_for_service = Model_Service::has_service($profile->id, $payment_type->id); ?>
                    <?php $strike = $has_paid_for_service ? 'strike-through' : ''; ?>
                    <li class="clearfix <?php echo $strike; ?>" >
                            <span class="price">
                                <?php if ($payment_type->mode == "recurring") { ?>
                                    <?php
                                        if(!$has_paid_for_service) {
                                            echo Form::radio($payment_type->mode, $payment_type->id);
                                        } else {
                                            echo Form::radio($payment_type->mode, $payment_type->id, true, array("disabled" => "disabled", "checked" => "checked"));
                                        }
                                    ?>
                                <?php } else { ?>
                                    <?php
                                        if(!$has_paid_for_service) {
                                            echo Form::checkbox($payment_type->mode, $payment_type->id);
                                        } else {
                                            echo Form::checkbox($payment_type->mode, $payment_type->id, true, array("disabled" => "disabled", "checked" => "checked"));
                                        }
                                    ?>
                                <?php } ?>
                                <?php echo $payment_type->formatted_amount(); ?>
                            </span>
                        <span class="savings"><?php echo $payment_type->name; ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div id="payment-info">
        <h2>Enter Your Payment info</h2>

        <div class="details-container">
            <div class="col">
                <p>Name on Card</p>
                <?php echo Form::input("first_name", $profile->first_name, array("class" => "required", "readonly"=>"")); ?>
                <span class="error with-margin ">First Name is a required field</span>
            </div>

            <div class="col">
                <p>&nbsp;</p>
                <?php echo Form::input("last_name", $profile->last_name, array("class" => "required", "readonly"=>"")); ?>
                <span class="error with-margin ">Last Name is a required field</span>
            </div>
            <div class="clearfix"></div>         

            <div class="col">
                <p>Card Type:</p>
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
                <p>Card Number:</p>
                <?php echo Form::input("card_num", null, array("class" => "required")); ?>
                <span class="error with-margin ">Card Number is a required field</span>
            </div>

            <div class="clearfix"></div>

            <div class="col">
                <p>Exp Date:</p>
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
                <p>Security Code:</p>
                <?php echo Form::input("security_code", null, array("class" => "short required")); ?>                
                <span class="error with-margin ">Security Code is a required field</span>
            </div>
            <div class="clearfix"></div>
            <div id="show-billing-wrap">
            <?php echo Html::anchor("#", "View Billing Details", array("id" => "show-billing")); ?>
            </p>
            </div>
            <div id="billing-details">
                
                <div class="details">
                    <div class="col">
                        <p>Country:</p>
                        <select name="country" class="required">
                            <?php foreach($countries as $country) {?>
                                <option value="<?php echo $country->id; ?>" <?php echo $country->id == $profile->id ? "selected" : "" ?>>
                                    <?php echo $country->name; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <span class="error with-margin ">Country is a required field</span>
                    </div>

                    <div class="col">
                        <p>State:</p>
                        <?php echo Form::input("state", $profile->state, array("class" => "required")); ?>
                        <span class="error with-margin ">State is a required field</span>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col">
                        <p>City:</p>
                        <?php echo Form::input("city", $profile->city, array("class" => "required")); ?>
                        <span class="error with-margin ">City is a required field</span>
                    </div>

                    <div class="col">
                        <p>Address:</p>
                        <?php echo Form::input("address", $billing->street_address, array("class" => "required")); ?>
                        <span class="error with-margin ">Address is a required field</span>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col">
                        <p>Postal Code:</p>
                        <?php echo Form::input("postal_code", $profile->zip, array("class" => "short required")); ?>
                        <span class="error with-margin ">Postal Code is a required field</span>
                    </div>

                    <div class="col">
                        <p>Email:</p>
                        <?php echo Form::input("email", $current_user->email, array("class" => "email required")); ?>
                        <span class="error with-margin">Email is a required field</span>
                        <span class="error with-margin email">Email should be in appropriate format</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
                                  

            <div class="btn-wrap gold-bg">
                <?php echo Form::submit("upgrade_now", "UPGRADE NOW", array("id" => "upgrade-button")); ?>
            </div>
        </div>
    </div>
    <div id="what-you-get">
        <h3>Here's What You Get!!</h3>

        <div class="details-container">
            <article>
                <header>Unlimited Messaging</header>
                <ul>
                    <li><i class="fa fa-star"></i> Send unlimited messages</li>
                    <li><i class="fa fa-star"></i> Send friend requests</li>
                    <li><i class="fa fa-star"></i> Chat with friends</li>
                    <li><i class="fa fa-star"></i> Refer favorite matches to friends</li>
                    <li><i class="fa fa-star"></i> Post comments</li>
                    <li><i class="fa fa-star"></i> Send Hellos</li>
                </ul>
            </article>
            <article>
                <header>Socialization</header>
                <ul>
                    <li><i class="fa fa-star"></i> Create friend network</li>
                    <li><i class="fa fa-star"></i> Attend events</li>
                    <li><i class="fa fa-star"></i> Book dating deals</li>
                    <li><i class="fa fa-star"></i> Upload and share photos</li>
                    <li><i class="fa fa-star"></i> Refer friends for bonus points</li>
                </ul>
            </article>
            <article>
                <header>Bonus Features</header>
                <ul>
                    <li><i class="fa fa-star"></i> 100% member authenticity</li>
                    <li><i class="fa fa-star"></i> Personal dating agents</li>
                    <li><i class="fa fa-star"></i> Easy turn off billing renewal</li>
                    <li><i class="fa fa-star"></i> Top customer service</li>
                    <li><i class="fa fa-star"></i> Bonus points for free memberships</li>
                </ul>
            </article>

        </div>
    </div>
    <?php echo Form::close(); ?>
</div>