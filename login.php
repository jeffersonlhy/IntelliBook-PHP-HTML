<?php
    if (isset($_SESSION['loggedin']) && $_SESSION["loggedin"]){
        header("Location: ./index.php");
    }
    include_once "template/header.php";
?>

<!-- LOGIN PAGE -->
    <div class="signup-container">
        <div class="signup">
            <h1 id="signup-heading">Login</h1>
            <form action="./php/verifyLogin.php" method="POST" class="form">
                <input class="login-input" type="text" id="user" name="user" placeholder="username">
                <input class="login-input" type="password" id="password" name="password" placeholder="password">
                <?php 
                    if (isset($_GET['redirect'])) {
                        echo "<input type='hidden' name='redirect' value=$_GET[redirect]>";
                    }
                ?>
                <div class="button-group">
                    <button type="submit" class="btn" name="login" onclick="checkAccountFormBlank()">Submit</button>
                    <button type="button" id="create-acct" href="./create.php" class="btn" name="back">Create</button>
                    <script>
                        var btn = document.getElementById('create-acct');
                        btn.addEventListener('click', function() {
                            document.location.href = './create.php';
                        });
                    </script>
                </div>
            </form>
        </div>
    </div>


</body>