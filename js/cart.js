function deleteCartItem(elem){
    var itemRow = $(elem).closest('tr')
    var itemId = $(itemRow).find('td:nth-child(4)').attr("data-id")
    console.log(itemId);
    $.ajax({
        url: `./php/cart.php`,
        data: {'action': 'delete', 'bookid': itemId},
        method: "GET",
        success: function(data){
            console.log(data);
            if (data.includes('success')){
                $(itemRow).remove();
                if ($('#checkout-table > tbody > tr').length == 0){
                    displayBlankCartPage();
                    updateCartCount();
                } else{
                    updatePriceSum();
                    updateCartCount();
                }
            }
        }
    })
}

function clearCartTable(){
    $('div.checkout-inner').html("<div class='empty-cart-warning'> Your cart is empty! </div>")
    $('div.checkout-sum').html("");
}

function disableCheckoutButton(){
    $('button#checkout-checkout').css("display", "none");
}

function displayBlankCartPage(){
    if ($('#checkout-table > tbody > tr').length == 0){
        $('table#checkout-table').remove();
        $('div.checkout-inner').prepend("<div class='empty-cart-warning'> Your cart is empty! </div>")
        $('div.checkout-sum').remove();
        $('button#checkout-checkout').remove();
    }
}

function updateCartCount(){
    $.ajax({
        url: './php/cart.php?getCartCount=1',
        method: "GET",
        success: function(data){
            $("span#cart-counter").text(data);
        }
    })
}

function updatePriceSum(){
    $.ajax({
        url: './php/cart.php?getCartPriceSum=1',
        method: "GET",
        success: function(data){
            console.log(`new price sum = ${data}`);
            $("span.checkout-sum-val").text("$"+data+".00");
        }
    })
}

