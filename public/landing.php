<?php
    require('../src/config.php');
    //render('../templates/landingForm.php');

    $rows = query("SELECT * FROM Party WHERE Id = 1")[0];
    render('../templates/landingForm.php', ['Id' => $rows['Id'], 'IPAddress' => $rows['IPAddress'], 'PartyName' => $rows['PartyName']]);
?>