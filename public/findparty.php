<<<<<<< HEAD
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
            // redirect to queue
            redirect("/partypage.php");
        }
        else
        {
             apologize("That party does not exist.");
        }
    }
=======
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
            // redirect to queue
            redirect("/partypage.php");
        }
        else
        {
             apologize("That party does not exist.");
        }
    }
>>>>>>> origin/master
?>