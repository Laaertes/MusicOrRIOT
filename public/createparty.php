
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
        $result = query("SELECT * FROM Party WHERE name = ?", $_POST["party"]);
        if ($result)
        {
            apologize("That party already exists. I guess you weren't invited");
        }
        else
        {
            // we finally filled out the form right, add party to database
            $check = insert_or_update("INSERT INTO Party (name, admin) VALUES(?, ?)", $_POST["party"], $user["id"]);
            
            // just in case it went wrong
            if ($check === false || $check === 0)
            {
                apologize("Please try again");
            }
            
            // add user to party
            insert_or_update("UPDATE User SET party_id=? WHERE session_identifier=?", get_handle()->lastInsertId(), $user['session_identifier']);
            
            // redirect to queue
            redirect("/partypage.php");
        }
    } else {
        render("create_form.php", ["title" => "Create Party"]);
    }
?>
