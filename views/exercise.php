<?php
/** @var $model Exercise */

use app\core\Application;
use app\models\Exercise;

?>
<div class="page-up">
    <div class="exercise-requirement" itemscope itemtype="https://schema.org/Text">
        <div class="requirements">
            <div class="meta-info">
                <div class="difficulty-wrapper">
                    <p class="difficulty-title">Difficulty:</p>
                    <img itemscope itemtype="https://schema.org/ImageObject" class="difficulty-bar" alt="difficulty"
                         src="/resources/images/difficulty_<?php echo $model->difficulty ?>.png"/>
                </div>
                <h3 class="exercise-author" itemscope itemtype="https://schema.org/Person"><span itemprop="givenName">by
                  <?php echo $model->authorName ?></span></h3>
            </div>
            <br class="meta-break"/>
            <h1 class="exercise-title" itemprop="title">#<?php echo $model->id ?>  <?php echo $model->title ?></h1>
            <p class="requirement-text" itemprop="text">
                <?php echo $model->requirement ?>
            </p>
            <div class="exercise-statistics" itemscope itemtype="https://schema.org/InteractionCounter">
                <p class="bought-by" itemprop="interactionStatistic">bought by : <?php echo $model->boughtBy ?> persons</p>
                <p class="solved-by" itemprop="interactionStatistic">solved by : <?php echo $model->solvedBy ?> person</p>
            </div>

        </div>
        <div class="exercise-status"></div>
    </div>
    <div class="editor-wrapper">
<?php if (isset($_SESSION['user'])) {
    if (Exercise::checkStatus(Application::$app->user->id, $model->id) == -1) {
        echo '<div class="not-bought">';
        if (Application::$app->user->coins < $model->price) {
            echo '<p class="buy-text">Not enough eSQLids</p>
                   <button class="buy cant-buy">'. $model->price .' eSQLids</button> 
                ';
        }else{
            echo '<p class="buy-text">Buy exercise</p>
                    <button class="buy can-buy">'. $model->price .' eSQLids</button> ';
        }
        echo '</div>';
    } else {
        echo '
            <div class="editor-holder">
                <ul class="toolbar">
                    <li>
                        <a href="#" id="indent" title="Toggle tabs or spaces"><img alt="I" src="/resources/images/indent.png"
                                                                                   class="indent-class" /></a>
                    </li>
                    <li>
                        <a href="#" id="fullscreen" title="Toggle fullscreen mode"><span class="full-exp"></span></a>
                    </li>
                </ul>
                <div class="scroller" itemscope itemtype="https://schema.org/Code">
                    <div class="line-number" role="presentation"></div>
                    <textarea autocomplete="off" spellcheck="false" class="editor allow-tabs"></textarea>
                    <pre><code class="syntax-highlight html"></code></pre>
                </div>
            </div>
            <div class="buttons">
                <button class="reset-button">Reset Content</button>
                <button class="submit-button">Submit Answer</button>
            </div>
             <script src="/scripts/highlighter.js"></script>
        ';
    }
} ?>
</div>

<script src="/scripts/exercise.js"></script>
<?php echo '</div>'; ?>