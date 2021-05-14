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
</div>
<div class="page-buttons">
    <button id="previous">1</button>
    <button id="current">2</button>
    <button id="next">3</button>
</div>
<script src="scripts/shop_resizer.js"></script>
<script src="scripts/shop_loader.js"></script>