<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form class="complete-form" action="" method="post">
            <h1 class="h1-title">Create Account</h1>
            <input name="name" class="user-input" type="text" placeholder="Name" />
            <input name="email" class="user-input" type="email" placeholder="Email" />
            <input name="password" class="user-input" type="password" placeholder="Password" />
            <input name="confirmPassword" class="user-input" type="password" placeholder="Confirm Password "/>
            <button type="submit" class="action-button">Sign Up</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form class="complete-form" action="" method="post">
            <h1 class="h1-title">Sign in</h1>
            <input name="email" class="user-input" type="email" placeholder="Email" />
            <input name="password" class="user-input" type="password" placeholder="Password" />
            <a class="forgot-password" href="#">Forgot your password?</a>
            <button type="submit" class="action-button">Sign In</button>
        </form>
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
                <button type="submit" class="action-button ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>