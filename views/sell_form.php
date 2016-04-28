<div id="middle">
    <form method="post" action="sell.php">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Symbol</th>
                    <th>Name</th>
                    <th>Shares</th>
                    <th>Price</th>
                    <th>TOTAL</th>
                    <th>SELL</th>
                </tr>
            </thead>
            
            <tbody>
                
                                
                <!--Check if its not empty -->
                <?php
                    if(!empty($positions))
                    {
                        foreach ($positions as $position)
                        {
                            // print tabel information 
                            // stock 
                            
                            
                            $symbol = $position["symbol"]; 
                            
                            
                            print("<tr>");
                            print("<td>" . $position["symbol"] . "</td>");
                            print("<td>" . $position["name"]   . "</td>"); 
                            print("<td>" . $position["shares"] . "</td>");
                            print("<td>" . $position["price"]  . "</td>"); 
                            print("<td>" . $position["total"]  . "</td>");
                            print("<td><input type='checkbox' name='soldStocks[]' value='{$symbol}'/></td>"); 
                            print("</tr>");
                        }
                    }
                   
                ?>
            </tbody>
        </table>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                Sell
            </button>
        </div>
    </form>
</div>
