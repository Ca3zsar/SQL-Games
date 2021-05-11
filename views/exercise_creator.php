<?php
/** @var $model Creator */

use app\models\Creator;

?>

<?php

use app\core\form\Form;

$form = Form::begin('', "post") ?>
<div class="container">

    <div class="meta-info">
        <div class="title-subdiv">
            <label class="meta-label">
                Exercise Title
                <?php echo $form->field($model, 'title', 'title-area')->textArea() ?>
            </label>
        </div>
        <div class="difficulty-subdiv">
            <label class="meta-label">
                Difficulty

            </label>
            <div class="choices">
                <input type="radio" name="difficulty" id="easy" class="input-hidden"/>
                <label for="easy">
                    <img class="difficulty-img" src="resources/images/difficulty_easy.png" alt="Easy"/>
                </label>
                <input type="radio" name="difficulty"
                       id="medium" class="input-hidden"/>
                <label for="medium">
                    <img class="difficulty-img" src="resources/images/difficulty_medium.png"
                         alt="Medium"/>
                </label>
                <input type="radio" name="difficulty"
                       id="hard" class="input-hidden"/>
                <label for="hard">
                    <img class="difficulty-img" src="resources/images/difficulty_hard.png"
                         alt="Hard"/>
                </label>
            </div>
        </div>
    </div>
    <div class="exercise-requirement">
        <label class="requirement-label">
            Exercise Requirement
            <?php echo $form->field($model, 'requirement', 'requirement-text')->textArea() ?>
        </label>
    </div>
    <div class="price-div">
        <label class="price-label">
            Exercise Price
            <input name="slider" type="range" min="1" max="15" value="3" class="slider" id="price_range">

        </label>
        <output class="bubble"></output>
    </div>
    <div class="correct-solution">
        <label class="correct-label">
            Your Solution
        </label>
        <div class="editor-holder">
            <?php echo $form->field($model, 'correctQuery', 'editor')->textArea() ?>
<!--            <textarea name="correctQuery" autocomplete="off" spellcheck="false" class="editor"></textarea>-->
            <pre><code class="syntax-highlight html"></code></pre>
        </div>
        <div class="to-download">
            <h1 class="download-text"><a class="download-link" href="#">Here</a> is the result of your query</h1>
        </div>
        <div class="buttons">
            <button class="verify-button">Verify Query</button>
            <button class="reset-button">Reset Content</button>
            <button class="submit-button">Submit</button>
        </div>

    </div>
</div>
<?php echo Form::end() ?>
<script src="scripts/creator.js"></script>
