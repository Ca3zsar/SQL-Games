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
            <img class="search-image" src="resources/images/search.png" alt="search"/>
        </button>
    </div>

    <div class="shop-filter">
        <div class="shop-select">
            <label>Difficulty:</label>
            <form>
                <select id="difficulty-filter">
                    <option class="diff-choice" value="" selected>Not specified</option>
                    <option class="diff-choice" value="easy">Easy</option>
                    <option class="diff-choice" value="medium">Medium</option>
                    <option class="diff-choice" value="hard">Hard</option>
                </select>
            </form>
        </div>

        <div class="shop-select">
            <label>Order by:</label>
            <form>
                <select id="order-by-filter">
                    <option value="popularity" selected>Popularity</option>
                    <option value="dateAdded">Date added</option>
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
</div>
<div class="page-buttons">
    <button id="previous">1</button>
    <button id="current">2</button>
    <button id="next">3</button>
</div>
<script src="scripts/shop_resizer.js"></script>
<script src="scripts/shop_loader.js"></script>