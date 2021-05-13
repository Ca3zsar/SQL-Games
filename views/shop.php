<div class="shop-header">
    <h1>SQL Exercises SHOP</h1>
</div>

<div class="shop-manager">
    <div class="search-box">
        <input
            class="search-input"
            type="text"
            name="search-input"
            placeholder="Search"
        />
        <button class="search-button">
            <img class="search-image" src="resources/images/search.png" alt="search" />
        </button>
    </div>

    <div class="shop-filter">
        <div class="shop-select">
            <label>Difficulty:</label>
            <form>
                <select>
                    <option selected>Not specified</option>
                    <option>Easy</option>
                    <option>Medium</option>
                    <option>Hard</option>
                </select>
            </form>
        </div>

        <div class="shop-select">
            <label>Order by:</label>
            <form>
                <select>
                    <option selected>Popularity</option>
                    <option>Date added</option>
                </select>
            </form>
        </div>

        <div class="shop-filter-layout">
            <form>
                <label>Layout</label>
                <img src="resources/images/compact_button.png" id="compact" alt="minimize"/>
                <img src="resources/images/extended_button.png" id="extended" alt="maximize"/>
            </form>
        </div>
    </div>
</div>

<div class="exercise-list">
<!--    <div class="exercise-wrapper">-->
<!--        <div class="exercise-requirement">-->
<!--            <div class="requirements">-->
<!--                <div class="meta-info">-->
<!--                    <div class="difficulty-wrapper">-->
<!--                        <p class="difficulty-title">Difficulty:</p>-->
<!--                        <img-->
<!--                            class="difficulty-bar"-->
<!--                            src="resources/images/difficulty_medium.png"-->
<!--                            alt="difficulty"-->
<!--                        />-->
<!--                    </div>-->
<!--                    <h3 class="exercise-author">by Nume_Imaginar</h3>-->
<!--                </div>-->
<!--                <br class="meta-break" />-->
<!--                <div class="title-holder">-->
<!--                    <a href="/exercise" class="exercise-title">#001 Test1</a>-->
<!--                    <img alt="first" src="resources/first.png" class="first-image" />-->
<!--                </div>-->
<!--                <div-->
<!--                    itemscope-->
<!--                    itemtype="http://schema.org/Product"-->
<!--                    class="exercise-content"-->
<!--                >-->
<!--                    <div itemprop="description" class="requirement-text">-->
<!--                        Sa se afiseze toti studentii care au un coleg de grupa nascut in-->
<!--                        aceeasi zi a saptamanii cu el si au nume de familie care incep-->
<!--                        cu aceeasi litera.-->
<!--                    </div>-->
<!--                    <div class="exercise-statistics">-->
<!--                        <p>-->
<!--                            Difficulty :-->
<!--                            <span class="difficulty-span medium">Medium</span>-->
<!--                        </p>-->
<!--                        <p>Solved by : 10</p>-->
<!--                    </div>-->
<!--                    <div class="solve-button-div">-->
<!--                        <a class="exercise-button to-solve" href="/exercise">-->
<!--                            Solve Exercise-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="exercise-wrapper">-->
<!--        <div class="exercise-requirement">-->
<!--            <div class="requirements">-->
<!--                <div class="meta-info">-->
<!--                    <div class="difficulty-wrapper">-->
<!--                        <p class="difficulty-title">Difficulty:</p>-->
<!--                        <img-->
<!--                            class="difficulty-bar"-->
<!--                            src="resources/images/difficulty_hard.png"-->
<!--                            alt="difficulty"-->
<!--                        />-->
<!--                    </div>-->
<!--                    <h3 class="exercise-author">by Nume_Imaginar</h3>-->
<!--                </div>-->
<!--                <br class="meta-break" />-->
<!--                <div class="title-holder">-->
<!--                    <a href="/exercise" class="exercise-title">#002 Test2</a>-->
<!--                </div>-->
<!--                <div-->
<!--                    itemscope-->
<!--                    itemtype="http://schema.org/Product"-->
<!--                    class="exercise-content"-->
<!--                >-->
<!--                    <div itemprop="description" class="requirement-text">-->
<!--                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque,-->
<!--                        minus accusantium? Molestias ipsam est vel delectus! Officia-->
<!--                        laudantium voluptatum aperiam optio, perspiciatis sint atque-->
<!--                        quasi! Necessitatibus sequi aliquam consectetur. Rerum!-->
<!--                    </div>-->
<!--                    <div class="exercise-statistics">-->
<!--                        <p>-->
<!--                            Difficulty : <span class="difficulty-span hard">Hard</span>-->
<!--                        </p>-->
<!--                        <p>Solved by : 10</p>-->
<!--                    </div>-->
<!--                    <div class="solve-button-div">-->
<!--                        <a-->
<!--                            itemprop="offers"-->
<!--                            itemscope-->
<!--                            itemtype="http://schema.org/Offer"-->
<!--                            class="exercise-button to-buy"-->
<!--                            href="/exercise"-->
<!--                        >-->
<!--                            10 eSQLids-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="exercise-wrapper">-->
<!--        <div class="exercise-requirement">-->
<!--            <div class="requirements">-->
<!--                <div class="meta-info">-->
<!--                    <div class="difficulty-wrapper">-->
<!--                        <p class="difficulty-title">Difficulty:</p>-->
<!--                        <img-->
<!--                            class="difficulty-bar"-->
<!--                            src="resources/images/difficulty_easy.png"-->
<!--                            alt="difficulty"-->
<!--                        />-->
<!--                    </div>-->
<!--                    <h3 class="exercise-author">by Nume_Imaginar</h3>-->
<!--                </div>-->
<!--                <br class="meta-break" />-->
<!--                <div class="title-holder">-->
<!--                    <a href="/exercise" class="exercise-title">#003 Test3</a>-->
<!--                </div>-->
<!--                <div-->
<!--                    itemscope-->
<!--                    itemtype="http://schema.org/Product"-->
<!--                    class="exercise-content"-->
<!--                >-->
<!--                    <div itemprop="description" class="requirement-text">-->
<!--                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque,-->
<!--                        minus accusantium? Molestias ipsam est vel delectus! Officia-->
<!--                        laudantium voluptatum aperiam optio, perspiciatis sint atque-->
<!--                        quasi! Necessitatibus sequi aliquam consectetur. Rerum!-->
<!--                    </div>-->
<!--                    <div class="exercise-statistics">-->
<!--                        <p>-->
<!--                            Difficulty : <span class="difficulty-span easy">Easy</span>-->
<!--                        </p>-->
<!--                        <p>Solved by : 10</p>-->
<!--                    </div>-->
<!--                    <div class="solve-button-div">-->
<!--                        <a-->
<!--                            itemprop="offers"-->
<!--                            itemscope-->
<!--                            itemtype="http://schema.org/Offer"-->
<!--                            class="exercise-button blocked"-->
<!--                            href="/exercise"-->
<!--                        >-->
<!--                            20 eSQLids-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="exercise-wrapper">-->
<!--        <div class="exercise-requirement">-->
<!--            <div class="requirements">-->
<!--                <div class="meta-info">-->
<!--                    <div class="difficulty-wrapper">-->
<!--                        <p class="difficulty-title">Difficulty:</p>-->
<!--                        <img-->
<!--                            class="difficulty-bar"-->
<!--                            src="resources/images/difficulty_medium.png"-->
<!--                            alt="difficult"-->
<!--                        />-->
<!--                    </div>-->
<!--                    <h3 class="exercise-author">by Nume_Imaginar</h3>-->
<!--                </div>-->
<!--                <br class="meta-break" />-->
<!--                <div class="title-holder">-->
<!--                    <a href="/exercise" class="exercise-title">#004 Test4</a>-->
<!--                </div>-->
<!--                <div class="exercise-content">-->
<!--                    <div class="requirement-text">-->
<!--                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque,-->
<!--                        minus accusantium? Molestias ipsam est vel delectus! Officia-->
<!--                        laudantium voluptatum aperiam optio, perspiciatis sint atque-->
<!--                        quasi! Necessitatibus sequi aliquam consectetur. Rerum!-->
<!--                    </div>-->
<!--                    <div class="exercise-statistics">-->
<!--                        <p>-->
<!--                            Difficulty :-->
<!--                            <span class="difficulty-span medium">Medium</span>-->
<!--                        </p>-->
<!--                        <p>Solved by : 10</p>-->
<!--                    </div>-->
<!--                    <div class="solve-button-div">-->
<!--                        <a class="exercise-button solved" href="/exercise">-->
<!--                            Solved-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>
<script src="scripts/shop_resizer.js"></script>
<script src="scripts/shop_loader.js"></script>