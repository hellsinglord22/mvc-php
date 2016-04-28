<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("quote_form.php", ["title" => "quote"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // get the stock name 
        $symbol = $_POST["symbol"]; 
        
        // check for the stock 
        $stock = lookup($_POST["symbol"]); 
        
        // check if quote is valid 
        if (empty($stock))
        {
            apologize("Invalid stock name"); 
        }
        else 
        {
            // get name, symbol and price 
            extract($stock); 
            
            
            // render result 
            if (isset($name) && isset($price))
            {
                // format price to at least two decimal places
                $price = number_format($price, 2); 
                
                // render this information 
                render("quote_result.php", ["title" => "result", "name" => $name, "price" => $price]); 
            }
        }
        
        
        
    }

?>
