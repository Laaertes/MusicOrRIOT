<?php
    //configuration
    require("../src/config.php");

    //current party name
    $party = query("SELECT * FROM Party WHERE id = ?", $user['party_id']);

    //check to see if the current user is the admin of the party
    if($party["admin"] == $user['id']){
        $admin = true;
    }
    else {
        $admin = false;
    }

    //render the template
    render("../templates/partypage.php", ["party" => $party, "admin" => $admin]);
?>
