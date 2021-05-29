<?php
/** @var $model \app\models\User */
?>

<div class="achievements-header">
    <h1>Achievements</h1>
</div>


<div class="achievements-list">
    <div class="achievement-box">
        <div class="achievement-icon">
            <img src="/resources/achievements/early-bird.png">
        </div>
        <div class="achievement-stats">
            <div class="achievement-title">
                <p>Gather 30 eSQLids.</p>
            </div>
            <div class="achievement-loading-bar">
                    <progress max="30" value="<?php echo 10; ?>"></progress>
            </div>
        </div>
    </div>
</div>


<div class="achievements-list">
    <div class="achievement-box">
        <div class="achievement-icon">
            <img src="/resources/images/checked.png">
        </div>
        <div class="achievement-stats">
            <div class="achievement-title">
                <p>Solve 10 exercises.</p>
            </div>
            <div class="achievement-loading-bar">
                <progress max="10" value="<?php echo 7; ?>"></progress>
            </div>
        </div>
    </div>
</div>

