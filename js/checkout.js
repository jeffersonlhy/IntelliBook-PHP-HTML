(function addCreateAcctListener() {
    $(document).ready(function () {
        $('button.create-btn').on('click', function (e) {
            e.preventDefault();
            if ($('div#loggedin').length) {
                if ($('input#full_name').val() == "" ||
                    $('input#addr_1').val()    == "" ||
                    $('input#city').val()      == "" ||
                    $('input#country').val()   == "" ||
                    $('input#zip').val()       == "") {
                    alert("Please do not leave the fields empty.");
                } else {
                    $("form.new-cust").submit();
                }
            } else {
                if ($("input#user").val()      == "" ||
                    $("input#password").val()  == "" ||
                    $('input#full_name').val() == "" ||
                    $('input#addr_1').val()    == "" ||
                    $('input#city').val()      == "" ||
                    $('input#country').val()   == "" ||
                    $('input#zip').val()       == "") {
                    alert("Please do not leave the fields empty.");
                } else {
                    if ($('span.user-dup-msg').length) {
                        alert('Username Duplicated!')
                    } else {
                        $("form.new-cust").submit();
                    }
                }
            }
        })

        $('input#user').on('blur', function () {
            console.log("checking username")
            $.ajax({
                type: "POST",
                url: "./php/createAccount.php",
                data: { 'check_duplicated': 1, "user": $('input#user').val() }, // serializes the form's elements.
                success: function (data) {
                    console.log(data); // show response from the php script.
                    var response = JSON.parse(data);
                    var isDuplicated = response['duplicated'];
                    if (isDuplicated) {
                        $('input#user').css("border", "1.2px solid red");
                        if ($('span.user-dup-msg').length == 0) {
                            $('input#user').parent().append("<span class='user-dup-msg' style='font-size: 0.9em; color: red; margin-top: 4px;'> Username Duplicated! </span>");
                        }
                    } else {
                        $('input#user').css("border", "");
                        $('input#user').parent().find('span.user-dup-msg').remove();
                    }
                }
            })
        })

        if ($('div#loggedin').length) {
            $('div.new-cust-cred').css("display", "none");
            $('div.exist-customer-dialog').css('display', 'none');
            $('div.new-heading').text("Address Information");
        }
    })
})()