<?php
/** @var $model \app\models\History */
?>

<div class="achievements-header">
    <h1>Achievements</h1>
</div>


<div class="achievements-manager">
    <div class="achievements-filter">

        <div class="achievements-select">
            <label>Order by:</label>
            <form>
                <select id="order-by-filter">
                    <option value="dateCompleted" selected>Date Completed</option>
                    <option value="progress">Progress</option>
                </select>
            </form>
        </div>

    </div>
</div>


<div class="achievements-list">
    <div class="achievement-box">
        <div class="achievement-icon">
            <img src="/resources/images/achievement.png">
        </div>
        <div class="achievement-stats">
            <div class="achievement-title">
                <p>Gather 30 eSQLids.</p>
            </div>
            <div class="achievement-loading-bar">
                <p>1/30</p>
                <progress max="100" value="80"></progress>
            </div>
        </div>
    </div>

</div>

<div class="page-buttons">
    <button id="previous">1</button>
    <button id="current">2</button>
    <button id="next">3</button>
</div>

<script src="scripts/shop_loader.js"></script>
