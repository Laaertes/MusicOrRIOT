<?php
    // configuration
    require("../src/config.php");
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["party"]))
        {
            apologize("You must provide a party name.");
        }
        
        // check of party name already exists
        $result = query("SELECT * FROM Party WHERE PartyName = ?", $_POST["party"]);
        if ($result)
        {
            apologize("That party already exists. I guess you weren't invited");
        }
        else
        {
            // we finally filled out the form right, add the user
            $check = query("INSERT INTO Party (PartyName, IPAddress) VALUES(?, ?)", $_POST["party"], crypt($_POST["cookies"]));
            
            // just in case it went wrong
            if ($check === false)
            {
                apologize("Please try again");
            }
            
            /*// if everything went right
            $rows = query("SELECT LAST_INSERT_ID() AS id");
            $id = $rows[0]["id"];
            // remember that user's now logged in by storing user's ID in session
            $_SESSION["id"] = $id;
            */
            
            // redirect to queue
            redirect("/partypage.php");
        }
        
        // if invalid stock symbol
       /* if ($stock === false)
        {
            apologize("You must provide a valid stock symbol");
        }
        else
        {   
            // direct to party queue
            render("partypage.php", ["title" => "Party Page", 'symbol' => $stock['symbol'], 'name' => $stock['name'], 'price' => $price]);
        }*/
    }
    else
    {
        render("create_form.php", ["title" => "Create Party"]);
    }
?>
