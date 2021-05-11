<div class="container">
    <div class="meta-info">
        <div class="title-subdiv">
            <label class="meta-label">
                Exercise Title
                <textarea class="title-area" spellcheck="false"></textarea>
            </label>
        </div>
        <div class="difficulty-subdiv">
            <label class="meta-label">
                Difficulty

            </label>
            <div class="choices">
                <input
                        type="radio" name="difficulty"
                        id="easy" class="input-hidden"/>
                <label for="easy">
                    <img class="difficulty-img"
                         src="resources/images/difficulty_easy.png"
                         alt="Easy"/>
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
            <textarea class="requirement-text" spellcheck="false"></textarea>
        </label>
    </div>
    <div class="price-div">
        <label class="price-label">
            Exercise Price
            <input name="slider" type="range" min="1" max="15" value="3" class="slider" id="price_range">
            <div class="bubble-wrap">
                <output class="bubble"></output>
            </div>
        </label>
    </div>
    <div class="correct-solution">
        <label class="correct-label">
            Your Solution
        </label>
        <div class="editor-holder">
                <textarea autocomplete="off" spellcheck="false" class="editor"></textarea>
                <pre><code class="syntax-highlight html"></code></pre>
        </div>
        <div class="to-download">
            <h1 class="download-text"><a class="download-link" href="#">Here</a> is the result of your query</h1>
        </div>
        <div class="buttons">
            <button class="reset-button">Reset Content</button>
            <button class="submit-button">Submit</button>
        </div>

    </div>
    <div class="correct-output">

    </div>
    <div class="submit-changes">

    </div>
</div>
<script src="scripts/creator.js"></script>
