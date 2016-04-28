<?php

    // configuration
    require("../includes/config.php"); 
    
    
    // GET then return the form 
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
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
            render("sell_form.php", ["title" => "sell", "user" => $user, "positions" => $positions]);
        }
        
        apologize("An Error occure"); 
        
        
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // You get stock data 
        if (isset($_POST["soldStocks"]))
        {
            $soldStocks = $_POST["soldStocks"]; 
            $cash = 0; 
            
            // print each stock 
            foreach($soldStocks as $stockSymbol)
            {
                // get the cash 
                $sharesQuery = CS50::query("SELECT shares FROM portfolios WHERE user_id = ? AND symbol = ?", 
                    $_SESSION["id"], $stockSymbol); 
                    
                // if you found any cash add it 
                if (!empty($sharesQuery))
                {
                    // getting stock value 
                    $stockInfo = lookup($stockSymbol);
                    
                    // Stock and shares 
                    $stockPrice = $stockInfo["price"]; 
                    $stockShares = $sharesQuery[0]["shares"]; 
                    
                    // add up the cash 
                    $cash += ($stockPrice * $stockShares); 
                    
                }
                
                
                
                
                CS50::query("DELETE FROM portfolios WHERE user_id = ? AND symbol = ?", $_SESSION['id'], $stockSymbol); 
            }
            
            // Update the cash 
            CS50::query("UPDATE users SET cash = cash + ? WHERE id = ?", $cash, $_SESSION["id"]); 
            
            // get current user cash 
            $users = CS50::query("SELECT * FROM users WHERE id= ?", $_SESSION["id"]); 
            $userCash = $users[0]["cash"]; 
            
            
            // redirect the user to portfolios 
            redirect("/"); 
            
            
            
        }
        else
        {
            apologize("You didn't choose any stock to sell"); 
        }
    }
    
    



?>
