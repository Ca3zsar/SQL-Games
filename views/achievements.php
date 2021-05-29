<?php
/** @var $achievements Achievements **/

use app\models\Achievements;

?>

<div class="achievements-header">
    <h1>Achievements</h1>
</div>


<div class="achievements-list">
    <?php
        foreach($achievements as $achievement)
        {
            echo '
            <div class="achievement-box">
                <div class="achievement-icon">
                    <img class="achievement-image" src="/resources/achievements/'. $achievement->image .'">
                </div>
                <div class="achievement-stats">
                    <p class="achievement-title">'.$achievement->name .'</p>
                    <p class="achievement-description">' . $achievement->description .'</p>
                    <div class="progress-div">
                        <progress class="progress" value="'.$achievement->current.'" max="'.$achievement->target.'"></progress>
                        <p class="progress-text">'.$achievement->current.'/'.$achievement->target.'</p>
                    </div>
                </div>
            </div>
            
            ';
        }
    ?>

</div>


