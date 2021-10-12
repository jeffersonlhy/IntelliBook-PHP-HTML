<?php
    include_once "template/header.php"
?>
    <div class="signup-container">
        <div class="signup">
            <h1 id="signup-heading">Create Account</h1>
            <form action="./php/createAccount.php" method="POST" class="form">
                <input class="login-input" type="text" id="user" name="user" placeholder="desired username">
                <input class="login-input" type="password" id="password" name="password" placeholder="desired password">
                <div class="button-group">
                    <button type="submit" class="btn" name="sign_up" onclick="checkAccountFormBlank()">Confirm</button>
                    <button type="button" id="back" href="./login.php" class="btn" name="back">Back</button>
                    <script>
                        var btn = document.getElementById('back');
                        btn.addEventListener('click', function() {
                            document.location.href = './login.php';
                        });
                    </script>
                </div>
            </form>
        </div>
    </div>


</body>