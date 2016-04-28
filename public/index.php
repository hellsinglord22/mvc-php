<?php

    // configuration
    require("../includes/config.php"); 
    
    
    // get user infor from the database 
    $users = CS50::query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
    
    // if you found only one match 
    if(count($users) == 1)
    {
        // get the only result 
        $user = $users[0];
        $rows = CS50::query("SELECT * FROM portfolios WHERE user_id = ?", $_SESSION["id"]);
        $positions = []; 
        
        
        
        foreach($rows as $row)
        {
            $stock = lookup($row["symbol"]); 
            
            if ($stock !== false)
            {
                $positions[] = [
                    "name" => $stock["name"],
                    "price" => number_format($stock["price"],2),
                    "shares" => $row["shares"],
                    "symbol" => $row["symbol"],
                    "total" => number_format($stock["price"] * $row["shares"], 2)
                ];
            }
        }
        
        
        // render portfolio
        render("portfolio.php", ["title" => "Portfolio", "user" => $user, "positions" => $positions]);
    }
    
    apologize("An Error occure"); 
    
    
    



?>
