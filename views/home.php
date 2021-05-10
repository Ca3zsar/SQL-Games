<?php use app\core\Application;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SQL-Games</title>
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

    <link rel="stylesheet" href="styles/content_style.css"/>
    <link rel="stylesheet" href="styles/navbar.css"/>
    <link rel="stylesheet" href="styles/footer.css"/>
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
            <a class="coins">10<img
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
<div class="banner-area" itemscope itemtype="https://schema.org/WPHeader">
    <div class="banner-title"></div>
    <img
            id="sql-image"
            alt=""
            src="resources/images/animation.gif"
            itemprop="image"
    />
    <h2 itemprop="name">SQL-Games</h2>
</div>
<div class="content-area" id="content-id">
    <div class="content-wrapper">
        <div class="present-site">
            <div class="image">
                <img
                        itemprop="image"
                        src="resources/images/sql-presentation.png"
                        alt="sql-photo"
                />
            </div>
            <article>
                <h3 itemprop="description">Improve your SQL skills</h3>
                <p itemprop="description">
                    Try our database-related exercises and prove your knowledge.
                    There are three main types of exercises depending on your level:
                    <strong>Beginner</strong>, <strong>Intermediate</strong> and
                    <strong>Skilled</strong>
                </p>
            </article>
        </div>

        <div class="present-site">
            <article>
                <h3 itemprop="description">
                    Earn coins, get achievements and climb the top!
                </h3>
                <p itemprop="description">
                    For each exercise that you solve you will receive a specific number
                    of <strong>eSQLids</strong> based on its difficulty. Be among
                    the first ones to solve an exercise and you will receive a bonus.
                    Solve as many exercises as you can and be among the
                    <strong>best</strong>!
                </p>
            </article>
            <div class="image" id="second-image">
                <img src="resources/images/achievement.png" alt="achievement"/>
            </div>
        </div>
    </div>
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
<script src="scripts/resize.js"></script>
</body>
</html>