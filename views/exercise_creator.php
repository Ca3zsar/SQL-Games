<?php
/** @var $model Creator */

use app\models\Creator;
use app\core\form\Form;

$type = '';
if($model->title === '')
{
    $type = 'creator.js';
}else{
    $type = 'editor.js';
}
$difficulties = array("easy" => '', "medium" => '', "hard" => '');
$difficulties[$model->difficulty] = "checked";

$form = Form::begin('', "") ?>
<div class="container">

    <div class="meta-info">
        <div class="title-subdiv">
            <label class="meta-label">
                Exercise Title
                <?php echo $form->field($model, 'title', 'title-area')->textArea() ?>
                <?php echo $form->field($model, 'title', '')->errorField(); ?>
            </label>
        </div>
        <div class="difficulty-subdiv">
            <label class="meta-label">
                Difficulty

            </label>
            <div class="choices">
                <?php
                ?>
                <?php echo $form->field($model, 'difficulty', 'input-hidden', 'id="easy" value="easy" ' . $difficulties["easy"])->radioButton() ?>
                <label for="easy">
                    <img class="difficulty-img" src="/resources/images/difficulty_easy.png" alt="Easy"/>
                </label>
                <?php echo $form->field($model, 'difficulty', 'input-hidden', 'id="medium" value="medium" ' . $difficulties["medium"])->radioButton() ?>
                <label for="medium">
                    <img class="difficulty-img" src="/resources/images/difficulty_medium.png"
                         alt="Medium"/>
                </label>
                <?php echo $form->field($model, 'difficulty', 'input-hidden', 'id="hard" value="hard" ' . $difficulties["hard"])->radioButton() ?>
                <label for="hard">
                    <img class="difficulty-img" src="/resources/images/difficulty_hard.png"
                         alt="Hard"/>
                </label>
            </div>
        </div>
    </div>
    <div class="exercise-requirement">
        <label class="requirement-label">
            Exercise Requirement
            <?php echo $form->field($model, 'requirement', 'requirement-text')->textArea() ?>
            <?php echo $form->field($model, 'requirement', '')->errorField(); ?>
        </label>
    </div>
    <div class="price-div">
        <label class="price-label">
            Exercise Price
            <?php echo $form->field($model, 'price', 'slider', 'id="price_range" min="1" max="15" value=' . $model->price)->slider() ?>
        </label>
        <output class="bubble"></output>
    </div>
    <div class="correct-solution">
        <label class="correct-label" for="text-editor">
            Your Solution
        </label>
        <div class="editor-holder">

            <pre><code class="syntax-highlight sql"></code></pre>
            <?php echo $form->field($model, 'correctQuery', 'editor', 'id="text-editor"')->textArea() ?>
        </div>
        <?php echo $form->field($model, 'correctQuery', '')->errorField(); ?>
        <div class="to-download">
            <h1 class="download-text"><a id="downloadButton" href="#">Here</a> is the result of your query</h1>
        </div>
        <div class="buttons">
            <button type="button" class="verify-button">Verify Query</button>
            <button type="button" class="reset-button">Reset Content</button>
            <button type="button" class="submit-button">Submit</button>
        </div>

    </div>
</div>
<?php Form::end() ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/highlight.min.js"></script>
<script src="/scripts/common_creator.js"></script>
<?php echo "<script src='/scripts/$type'></script>" ; ?>
