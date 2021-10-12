<?php
    include_once "./connectDb.php";
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']){
        session_destroy();
        echo "<html>
        <style>
            * {
                font-family: system-ui;
            }
        
            div.container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
            }
        
            h2 {
                color: #2f989f;
                font-size: 1.8em;
                text-align: center;
                margin-bottom: 2px;
            }
        
            p {
                text-align: center;
            }
        </style>
        <div class='container'>
            
            <h2> Logging out </h2>
            <p> Redirect to main page after 3 seconds...</p>
        </div>
        
        </html>";

    } 
    header("refresh:3; url= ../index.php");