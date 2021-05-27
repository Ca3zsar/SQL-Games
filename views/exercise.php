<?php
/** @var $model Exercise */

use app\core\Application;
use app\models\Exercise;

if (isset($_SESSION['user'])) {
    $status = Exercise::checkStatus(Application::$app->user->id, $model->id);
    $voteStatus = Exercise::checkVoted(Application::$app->user->id, $model->id);

    $exStatus = '';
    if ($status == -1) {
        $exStatus = 'blocked';
    }
    if ($status == 0) {
        $exStatus = 'tried';
    }
    if ($status == 1) {
        $exStatus = 'solved';
        if ($voteStatus == 1) {
            $voteStatus = 'voted';
        } else {
            $voteStatus = 'novote';
        }
    }
    $reset = '';
    if ($model->authorId == Application::$app->user->id) {
        $reset = '<button class="edit-button">Edit exercise</button>';
    }
} else {
    $reset = '';
    $exStatus = 'blocked';
}

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
                <p class="voted-by" itemprop="interactionStatistic"> <?php echo $model->stars ?> &#9733;</p>
                <p class="bought-by" itemprop="interactionStatistic">bought by : <?php echo $model->boughtBy ?>
                    users</p>
                <p class="solved-by" itemprop="interactionStatistic">solved by : <?php echo $model->solvedBy ?>
                    users</p>
            </div>

        </div>
        <div class="exercise-status <?php echo $exStatus; ?>">
            <?php if ($exStatus == "solved" && $model->authorId != Application::$app->user->id) {
                echo "<img class='star-image $voteStatus' src='/resources/images/star.png'/>";
            } ?>
        </div>
    </div>
    <div class="editor-wrapper">
        <?php if (isset($_SESSION['user'])) {
            if (Exercise::checkStatus(Application::$app->user->id, $model->id) == -1) {
                echo '<div class="not-bought">';
                if (Application::$app->user->coins < $model->price) {
                    echo '<p class="buy-text">Not enough eSQLids</p>
                   <button class="buy cant-buy">' . $model->price . ' eSQLids</button> 
                ';
                } else {
                    echo '<p class="buy-text">Buy exercise</p>
                    <button class="buy can-buy">' . $model->price . ' eSQLids</button> ';
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
                <div class="line-number" role="presentation"></div>
         
                <textarea id="editor" autocomplete="off" spellcheck="false" class="editor allow-tabs"></textarea>
                <label style="display:none;" for="editor">
                CEVA
                </label>
                <pre><code class="sql syntax-highlight "></code></pre>
           
            </div>
            <div class="exercise-message"></div>
            <div class="buttons">' . $reset .
                    '<button class="reset-button">Reset Content</button>
                <button class="submit-button">Submit Answer</button>
            </div>
                <script src="/scripts/highlighter.js"></script>
        ';
            }
        } ?>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/highlight.min.js"></script>
    <script src="/scripts/exercise.js"></script>



<?php echo '</div>'; ?>