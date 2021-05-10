<?php use app\core\Application; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{title}}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
    <meta name="keywords" content="HTML, CSS, JavaScript, SQL"/>
    <meta
            name="description"
            content="An website where you can solve SQL exercises"
    />
    <meta
            name="author"
            content="Buliga Eugeniu, Todirisca Cezar, Toma Andrei"
    />
    <meta name="application-name" content="SQL-Games"/>

    <link rel="stylesheet" href="styles/navbar.css"/>
    <link rel="stylesheet" href="styles/footer.css"/>
    {{styles}}
    <script src="scripts/navFunctions.js"></script>

    <link rel="shortcut icon" type="image/png" href="resources/favicon.png"/>
</head>

<body itemscope itemtype="http://schema.org/WebPage">
<header itemscope itemtype="https://schema.org/SiteNavigationElement">
    <div class="left-side">
        <div class="logo" itemscope itemtype="http://schema.org/logo">
            <a href="/" itemprop="name">SQL-GAMES</a>
        </div>
    </div>
    <nav class="right-nav">
        <?php if (!Application::isGuest()): ?>
            <a class="coins"
            >10<img
                        src="resources/images/coin.png"
                        class="coin-img"
                        alt="eSQLids"
                        itemscope
                        itemtype="https://schema.org/ImageObject"
                /></a>
            <a class="coins-collapsed"
            >Coins : 10<img
                        src="resources/images/coin.png"
                        class="coin-img"
                        alt="eSQLids"
                /></a>
        <?php endif; ?>
        <a href="/shop" itemprop="url">Exercises</a>

        <?php if (Application::isGuest()): ?>
            <a href="/login">Login/Register</a>
        <?php endif; ?>

        <?php if (!Application::isGuest()): ?>
            <div class="dropdown">
                <p class="dropbtn">Account</p>
                <div
                        class="dropdown-content"
                        itemscope
                        itemtype="https://schema.org/ItemList"
                >
                    <a href="/profile_settings" itemprop="url"
                    ><span itemprop="name">Profile Settings</span></a
                    >
                    <a href="#" itemprop="url"
                    ><span itemprop="name">Statistics</span></a
                    >
                    <a href="/logout" itemprop="url"><span itemprop="name">Log out</span></a>
                </div>
            </div>
        <?php endif; ?>
    </nav>
    <div class="toggle-btn" onclick="displayOptions()">
        <span></span>
        <span></span>
        <span></span>
    </div>
</header>
<div class="content-area" id="content-id">
    {{content}}

    <footer class="footer-bar">
        <a href="#">Contact us</a>
        <a href="/scholarlyhtml">Scholarly HTML</a>
        <h4 itemscope itemtype="https://schema.org/copyrightHolder">
            © SQL-GAMES 2021
            <span
                    itemscope=""
                    itemtype="http://schema.org/Person"
                    itemprop="author"
            >Buliga Eugeniu, Todirisca Cezar, Toma Andrei</span
            >
        </h4>
    </footer>
</div>
</body>
</html>
