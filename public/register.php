<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // Check username, password is their and make sure they match 
        if (empty($_POST["username"]))
        {
            apologize("You must provide a username.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide a password.");    
        }
        else if ($_POST["password"] != $_POST["confirmation"])
        {
            apologize("Password doesn't match"); 
        }
        
        // inserting username and password into database 
        $result = CS50::query("INSERT IGNORE INTO users (username, hash, cash) VALUES(?, ?, 10000.0000)",
            $_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT));
            
            if ($result != 0)
            {
                // Then you did find the id 
                $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
                $id = $rows[0]["id"];
                
                // User is logged in 
                $_SESSION["id"] = $id; 
                
                // redirect the user to index 
                redirect("/");
            }
        
        
        apologize("Username is already in use"); 
    }

?>