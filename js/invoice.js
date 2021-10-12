(function(){
    $(document).ready(function(){
        $('button.back-main').on('click', function(){
            $.ajax({
                url: "./php/cart.php",
                type: 'POST',
                data: {'massDelete': '1'},
                success: function(data){
                    console.log(data);
                    document.location.href = "./index.php";
                }
            })
        })
    })
})()