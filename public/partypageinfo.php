<?php
    //configuration
    require("../src/config.php");

    //If a request was submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        //return the queue
        $party = query("SELECT * FROM Party WHERE id = ?", $user['party_id']);
        $songs_by_score_desc = songs_by_score_desc($party['id']);
        if($songs_by_score_desc == null || $songs_by_score_desc[0]['id'] == $party['current_song_id']){
            echo json_encode($songs_by_score_desc);
            exit;
        }
        else{
            $songs_by_score_desc = order_queue($songs_by_score_desc, $party['current_song_id']);
            echo json_encode($songs_by_score_desc);
            exit;
        }
        http_response_code(400);
        $error = "There was an error updating the score";
        echo json_encode($error);
    }
?>
