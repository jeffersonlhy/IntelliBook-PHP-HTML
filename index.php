<?php
include_once "template/header.php";
$db = Database::getConnection();
?>


<div class='main-panel'>
    <div class='left-panel'>
        <div class='left-panel-head'>
            <span id="mobile-cate-icon" class="material-icons">
                list
            </span>
            <span id="desktop-cate-icon" class="material-icons">
                list
            </span>
            <h1 class='left-panel-title'> Categories </h1>
        </div>
        <div class='sticky-cate'>
            <?php
            $query = "SELECT DISTINCT category FROM `books`";
            $result = mysqli_query($db, $query);
            if ($result) {
                while ($row = mysqli_fetch_array($result)) {
                    echo '<div class="category-item">' . $row['category'] . '</div>';
                }
            }
            ?>
        </div>
        <script type="text/javascript">
            $("div.left-panel").on('click', "div.category-item", function() {
                console.log("clicked left categories")
                displayBooksByCate($(this).text());
            })
            $("span#mobile-cate-icon").on('click', function() {
                let cate = document.querySelector('div[class*="sticky-cate"]');
                cate.className = (cate.className === "sticky-cate") ? "sticky-cate show" : "sticky-cate";
            })
        </script>
    </div>

    <div class='right-panel'>
        <ul class='breadcrumb'>
            <span id="Home"> Home </span>
        </ul>
        <script type="text/javascript">
            $("ul.breadcrumb").on('click', "span", function() {
                if ($(this).attr('id') == "Home") {
                    location.reload();
                }
            })
        </script>
        <h1 class='right-panel-title'> All Books</h1>
        <div class='price-sort-section'>
            <div class='price-sort-inner'>
                <span class="material-icons">
                    sort
                </span>
                <span class='price-sort-text' data-sorted="false"> Sort By Price </span>
            </div>
        </div>
        <div id='books-overview-panel'>

        </div>
        <script>
            $("div#books-overview-panel").on('click', "div[class*='book-box']", function() {
                var bookName = $(this).find("div.book-name").text()
                console.log(bookName)
                displayBookDetails(bookName);
                disableSortFunction();
                updateBreadcrumb(bookName);
            })
        </script>
    </div>
</div>


</body>