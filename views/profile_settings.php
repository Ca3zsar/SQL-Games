<?php
/** @var $model User */

use app\core\form\Form;
use app\models\User;

?>

<div class="settings-area">
    <div
            class="settings-nav"
            itemscope
            itemtype="https://schema.org/ItemList"
    >
        <h1 class="account-settings">Account Settings</h1>
        <a href="#personal-info">Personal information</a>
        <a href="#pass-info">Password</a>
        <a href="#contact-info">Contact</a>
        <a href="#about-info">About</a>
        <button type="submit" form="complete-form" class="submit-changes" id="submit-changes">Save Changes</button>
    </div>
    <!--    <div class="settings">-->
    <?php $form = Form::begin("", "post") ?>
    <br id="personal-info"/>
    <div class="personal-info">
        <h1 class="section-header">Personal information</h1>
        <div class="information">
            <div class="name-info">
                <div class="first-name-div">
                    <label
                            for="first-name-input"
                            class="first-name-label settings-label"
                    >First Name</label
                    >
                    <?php echo $form->field($model, 'firstName', "", "id='first-name-input'"); ?>
                </div>
                <div class="last-name-div">
                    <label
                            for="last-name-input"
                            class="last-name-label settings-label"
                    >Last Name</label
                    >
                    <?php echo $form->field($model, 'lastName', "", "id='last-name-input' "); ?>
                </div>
            </div>
            <div class="email-info">
                <div class="email-div">
                    <label for="email-input" class="email-label settings-label"
                    >Email Address</label
                    >
                    <?php echo $form->field($model, 'email', "", "id='email-input'"); ?>
                    <?php echo $form->field($model, 'email', '')->errorField(); ?>
                </div>
            </div>
        </div>
    </div>
    <br id="pass-info"/>
    <div class="pass-info">
        <h1 class="section-header">Password</h1>
        <div class="information">
            <div class="current-info">
                <div class="current-password-div">
                    <label
                            for="current-pass-input"
                            class="current-pass-label settings-label"
                    >Current Password</label
                    >

                    <?php echo $form->field($model, 'currentPassword', "", "id='current-pass-input'")->passwordField(); ?>
                    <?php echo $form->field($model, 'currentPassword', '')->errorField(); ?>
                </div>
            </div>

            <div class="password-info">
                <div class="password-div">
                    <label
                            for="password-input"
                            class="password-label settings-label"
                    >New Password</label
                    >

                    <?php echo $form->field($model, 'newPassword', "", "id='password-input'")->passwordField(); ?>
                    <?php echo $form->field($model, 'newPassword', '')->errorField(); ?>
                </div>
                <div class="confirm-password-div">
                    <label
                            for="confirm-input"
                            class="confirm-label settings-label"
                    >Confirm Password</label
                    >

                    <?php echo $form->field($model, 'confirmPassword', "", "id='confirm-input'")->passwordField(); ?>
                    <?php echo $form->field($model, 'confirmPassword', '')->errorField(); ?>
                </div>
            </div>
        </div>
    </div>
    <br id="contact-info"/>
    <div class="contact-info">
        <h1 class="section-header">Contact</h1>
        <div class="information">
            <div class="contact-info-phone">
                <div class="phone-div">
                    <label for="phone-number" class="phone-label settings-label"
                    >Phone Number</label
                    >

                    <?php echo $form->field($model, 'phone', "", "pattern='[0-9]{10}' id='phone-number'")->telField(); ?>
                    <?php echo $form->field($model, 'phone', '')->errorField(); ?>
                </div>
            </div>

            <div class="contact-info-address">
                <div class="address-div">
                    <label for="address" class="address-label settings-label"
                    >Address</label>

                    <?php echo $form->field($model, 'address', "", "id='address'"); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="about-info">
        <h1 class="section-header" id="about-info">About</h1>
        <div class="information">
            <div class="about-info-birthday">
                <div class="birthday-div">
                    <label for="birthday" class="birthday-label settings-label"
                    >Birthday</label>
                    <?php echo $form->field($model, 'birthday', "", "id='birthday'")->dateField(); ?>
                </div>
            </div>

            <div class="about-info-description">
                <div class="description-div">
                    <label for="description" class="description-label settings-label">Description</label>
                    <?php echo $form->field($model, 'description', "", "name='description' id='description'")->textArea(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php Form::end();?>
</div>
<script src="scripts/profile_settings.js"></script>