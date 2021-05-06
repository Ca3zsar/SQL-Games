<?php
/** @var $model \app\models\User */
?>

<div class="container" id="container">


    <div class="form-container sign-up-container">
        <?php use app\core\form\Form;
        $form = Form::begin('', "post") ?>
        <h1 class="h1-title">Create Account</h1>
        <?php echo $form->field($model, 'username') ?>
        <?php echo $form->field($model, 'email') ?>
        <?php echo $form->field($model, 'password')->passwordField() ?>
        <?php echo $form->field($model, 'confirmPassword')->passwordField() ?>
        <button type="submit" class="action-button">Sign Up</button>
        <?php echo Form::end() ?>p
    </div>
    <div class="form-container sign-in-container">
        <?php $form = Form::begin('', "post") ?>
        <h1 class="h1-title">Sign in</h1>
        <?php echo $form->field($model, 'username') ?>
        <?php echo $form->field($model, 'password')->passwordField() ?>
        <a class="forgot-password" href="#">Forgot your password?</a>
        <button type="submit" class="action-button">Sign In</button>
        <?php echo Form::end() ?>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1 class="h1-title">Welcome Back!</h1>
                <p class="general-info">
                    Please enter your login and password to keep SQL-ing.
                </p>
                <button class="action-button ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1 class="h1-title">Hello, Friend!</h1>
                <p class="general-info">
                    Enter your details to start conquering SQl-craft!
                </p>
                <a href="/register"><button type="submit" class="action-button ghost" id="signUp">Sign Up</button></a>
            </div>
        </div>
    </div>
</div>