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
            insert_or_update("UPDATE User SET party_id=? WHERE session_identifier=?", $result['id'], $user['session_identifier']);
            // redirect to queue
            redirect("partypage.php");
        }
        else
        {
             apologize("That party does not exist.");
        }
    }
?>
