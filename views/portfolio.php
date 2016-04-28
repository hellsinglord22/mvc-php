<div id="middle">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Shares</th>
                <th>Price</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <td colspan="4">CASH</td>
                <td><?= htmlspecialchars(number_format($user["cash"], 2)). " $" ?></td>
            </tr>
                            
            <!--Check if its not empty -->
            <?php
                if(!empty($positions))
                {
                    foreach ($positions as $position)
                    {
                        // print tabel information 

                        
                        print("<tr>");
                        print("<td>" . $position["symbol"] . "</td>");
                        print("<td>" . $position["name"]   . "</td>"); 
                        print("<td>" . $position["shares"] . "</td>");
                        print("<td>" . $position["price"]  . "</td>"); 
                        print("<td>" . $position["total"]  . "</td>");
                        print("</tr>");
                    }
                }
               
            ?>
        </tbody>

    </table>
</div>
