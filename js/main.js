function bookDataToHtml(bookdata) {
    var str = "";
    for (let i = 0; i < bookdata.length; ++i) {
        let book = bookdata[i];
        str += (book.new_arrival == 1) ? `<div class='book-box-red-border'> <div class='new-arrival-tag'> NEW ARRIVAL </div>`
            : `<div class='book-box-grey-border'>`
        str += `
                <div class='book-thumbnail'>
                    <img class='book-thumbnail' src="./img/book_${book.book_id}.jpeg">
                </div>
                <div class='book-name'>${book.book_name}</div>
                <div class='book-author'>${book.author}</div>
                <div class='book-pub'>${book.publisher}</div>
                <div class='book-price'>$ ${book.price}</div>
            </div>
        `
    }
    return str;
}

function bookDetailToHtml(bookdata) {
    var htmlstr =
        `<div class='book-detail-panel'>
        <div class='book-detail-img'>
            <img src="./img/book_${bookdata.book_id}.jpeg"> 
        </div>
            <div class='book-details'>
                <div class='book-detail-name'>${bookdata.book_name}</div>
                <div class='book-detail-author'>${bookdata.author}</div>
                <div class='book-detail-pub'>${bookdata.publisher}</div>
                <div class='book-detail-cate'>${bookdata.category}</div>
                <div class='book-detail-lang'>${bookdata.lang}</div>
                <div class='book-detail-desc'>${bookdata.description}</div>
            <div class='book-detail-price'>$ ${bookdata.price}</div>
            <div class='purchase-section'>
                <label> Order </label>
                <form class='purchase-control' action="./php/cart.php?book_id=${bookdata.book_id}" method="POST">
                    <input id="purchase-quantity" type="text" name="quantity" value="1" placeholder="">
                    <button type="button" class='submit-quantity'>Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
    `
    $('div#books-overview-panel').html(htmlstr);
    $('button.submit-quantity').on('click', function (e) {
        e.preventDefault();
        let quantity = $('input#purchase-quantity').val();
        let link = $('form.purchase-control').attr('action');
        $.ajax({
            url: link,
            method: "POST",
            data: { 'quantity': quantity },
            success: function (data) {
                console.log(data)
                let quantity = parseInt($('input#purchase-quantity').val())
                var a = parseInt($('span#cart-counter').text())
                $('span#cart-counter').text(a + quantity);
                // var res = JSON.parse(data);
                // var status = res.status;
                // if (status == 'success'){
                //     alert("success")
                // }
            }
        })
    })
}

function displayBooksByCate(categoryName) {
    // Change the main panel according to the passed in category name
    $.ajax({
        url: "./php/getBooksByCate.php",
        method: "POST",
        data: { 'category': categoryName },
        success: function (data) {
            var bookdata = JSON.parse(data);
            var panel = $('div#books-overview-panel')
            panel.html(bookDataToHtml(bookdata['books']))
            curBooks = bookdata['books'].slice();
            enableSortFunction();
            sortButtonOff();
            updateBreadcrumb(categoryName);

        }
    })
}

function initializeAllBooks() {
    $.ajax({
        url: "./php/getBooksByCate.php",
        method: "POST",
        data: { 'all': true },
        success: function (data) {
            var bookdata = JSON.parse(data);
            allBooks = bookdata['books'];
        }
    })
}

function initializeBooksPanel() {
    $(document).ready(function () {
        console.log($('input#search').val())
        if ($('input#search').val() == "") {
            displayAllBook();
        } else {
            initializeAllBooks();
            displaySearchResult();
        }
    })
}

function addAllBookDetailListener() {
    $("div#books-overview-panel").on('click', "div[class*='book-box']", function () {
        var bookName = $(this).find("div.book-name").text()
        console.log(bookName)
        displayBookDetails(bookName);
        disableSortFunction();
        if ($('ul.breadcrumb > span:last-child').attr("id") == "home") {
            $("ul.breadcrumb").append(`<div class='nav-separator'> > </div>`)
            $("ul.breadcrumb").append(`<span>${bookName}</span>`)
        } else {
            $("ul.breadcrumb > span:last-child").text(bookName)
        }
    })
}

function displayAllBook() {
    // Only register once is enough 
    if (allBooks == undefined) {
        $(document).ready(function () {
            $.ajax({
                url: "./php/getBooksByCate.php",
                method: "POST",
                data: { 'all': true },
                success: function (data) {
                    var bookdata = JSON.parse(data);
                    allBooks = bookdata['books'];
                    curBooks = allBooks.slice();
                    var panel = $('div#books-overview-panel')
                    panel.html(bookDataToHtml(allBooks))
                    // addAllBookDetailListener();
                    sortButtonOff();
                }
            })
        })
    } else {
        $('div#books-overview-panel').html(bookDataToHtml(allBooks))
        curBooks = allBooks.slice();
        sortButtonOff();
    }
};

function displayBookDetails(bookname) {
    for (let i = 0; i < allBooks.length; ++i) {
        let book = allBooks[i];
        if (book.book_name == bookname) {
            bookDetailToHtml(book);
        }
    }
}

function disableSortFunction() {
    $('div.price-sort-section').css("display", "none");
}

function enableSortFunction() {
    $('div.price-sort-section').css("display", "flex");
}

function sortButtonOn() {
    $('span.price-sort-text').attr("data-sorted", "true")
}

function sortButtonOff() {
    $('span.price-sort-text').attr("data-sorted", "false")
}

function displaySearchResult() {
    let pre_keywords = $('input#search').val().split(" ");
    keywords = pre_keywords.filter(function (elem) {
        return elem != "";
    })
    console.log("Search Keywords: ", keywords)
    if (keywords.length > 0) {
        $.ajax({
            url: "./php/search.php",
            method: "POST",
            data: { 'search': keywords },
            success: function (data) {
                var result = JSON.parse(data);

                $('h1.right-panel-title').text("Search Result")
                if (result.books.length > 0) {
                    $('div#books-overview-panel').html(bookDataToHtml(result.books));
                    curBooks = result.books.slice();
                } else {
                    curBooks = [];
                    $('div#books-overview-panel')
                        .html(`<h3 class='no-result'> No results for ${$('input#search').val()} in books </h3>`)
                }
                sortButtonOff();
                disableSortFunction();
                resetBreadcrumb();
                $('input#search').val("");
            }
        })
    }
}

function checkAccountFormBlank() {
    var username = $('#user').val()
    var password = $('#password').val()
    if (username == "" || password == "") {
        event.preventDefault();
        alert('Please do not leave the fields empty');
    }
    console.log("Checked")
    return true;
}

function displayBooksSortedPrice() {
    if ($('span.price-sort-text').attr('data-sorted') == "true") {
        curBooks.sort(function (a, b) { return a.price - b.price }) // ascending
        console.log("ascending")
        // console.log(curBooks['books'].price)
    } else {
        curBooks.sort(function (a, b) { return b.price - a.price }) // descending
        console.log("descending")
        // console.log(curBooks['books'][1].price)
    }
    if (curBooks.length > 0) {
        $('div#books-overview-panel').html(bookDataToHtml(curBooks));
    }
    // curBooks['books'].sort(function(a,b){return b.price - a.price})
}

function searchBarRoute() {
    var url = window.location.href;
    let keywords = $('input#search').val().split(" ");
    if (url.includes("/login.php") || url.includes("/create.php") || url.includes("/viewCart.php")) {
        $.ajax({
            url: "./php/search.php",
            data: { 'searchPending': keywords },
            method: "POST",
            success: function (data) {
                console.log('end');
                window.location.href = `./index.php`
            }
        })
    } else {
        displaySearchResult();
    }
}

function isCategory(text){
    return text == 'Storybook' || text == 'Contemporary Fiction' || text == 'Picture Book' || text == 'History';
}

function breadcrumbHandler(elem){
    var clickedName = $(elem).text().trim();
    console.log("breadcrumbHandler: ", clickedName);
    if (clickedName == "Home"){
        location.reload();
    } else if (isCategory(clickedName)){
        displayBooksByCate(clickedName);
    }

}

function resetBreadcrumb(){
    breadMaster = ['Home', "", ""];
    $('ul.breadcrumb').html(`<li class='breadcrumb-item'><span id="Home"> Home </span></li>`);
}

function updateBreadcrumb(clickName) {
    function makeBreadcrumbHTML() {
        var html = "";
        let breadcrumb = breadMaster.slice();
        // var breadcrumb = breadcrumb1.filter(function(elem){
        //     return elem != "";
        // })
        console.log("breadcrumb", breadcrumb);
        let length = breadcrumb.length;
        for (let i = 0; i < length; ++i) {
            if (i == length - 1 && breadcrumb[i] != ""){
                html += `<li class='breadcrumb-item'><span id="${breadcrumb[i]}"> ${breadcrumb[i]} </span></li>`
            } else if (breadcrumb[i] != ""){
                html += `<li class='breadcrumb-item'><span class='breadcrumb-clickable' id="${breadcrumb[i]}" onclick=breadcrumbHandler(this) > ${breadcrumb[i]} </span></li>`;
            }
        }
        return html;
    }
    function renderNewBreadcrumb() {
        var breadcrumbHTML = makeBreadcrumbHTML();
        $('ul.breadcrumb').html(breadcrumbHTML);
    }
    var curPage = breadMaster[breadMaster.length - 1];
    console.log("clickName", clickName);
    if (isCategory(clickName) && breadMaster[2] == "") {
        breadMaster[1] = clickName;
        renderNewBreadcrumb();
    } else if (isCategory(clickName) && breadMaster[2] != ""){
        breadMaster[1] = clickName;
        breadMaster[2] = "";
        renderNewBreadcrumb();
    } 
    else if (!isCategory(clickName)) {
        // var pos = breadMaster.indexOf(clickName);
        // breadMaster = breadMaster.slice(0, pos + 1);
        breadMaster[2] = clickName;
        renderNewBreadcrumb();
    }
}


(function addSortEventListener() {
    $(document).ready(function () {
        $('span.price-sort-text').on('click', function () {
            displayBooksSortedPrice();
            let sorted_flag = ($('span.price-sort-text').attr("data-sorted") == "false") ? "true" : "false"
            $('span.price-sort-text').attr("data-sorted", sorted_flag)
            let title = $('h1.right-panel-title').text().trim();
            title = (title == "All Books") ? "All Books (Sort by Price Highest)" : "All Books";
            $('h1.right-panel-title').text(title);
        })
    })
})()

var allBooks;
var curBooks;
var breadMaster = ['Home', "", ""];
initializeBooksPanel();