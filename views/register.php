<?php
/** @var $model \app\models\User */
?>

<?php if (\app\core\Application::$app->session->getFlash('success')): ?>
    <div class="container-flash">
        <div class="alert alert-success">
            <?php echo \app\core\Application::$app->session->getFlash('success') ?>
        </div>
    </div>
<?php endif; ?>


<div class="container right-panel-active" id="container">


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
                <a href="/login"><button class="action-button ghost" id="signIn">Sign In</button></a>
            </div>
            <div class="overlay-panel overlay-right">
                <h1 class="h1-title">Hello, Friend!</h1>
                <p class="general-info">
                    Enter your details to start conquering SQl-craft!
                </p>
               <button type="submit" href="/register" class="action-button ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>