<?php
    //configuration
    require("../src/config.php");

    //If a request was submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        //return the queue
        $party = query("SELECT * FROM Party WHERE id = ?", $user['party_id']);
        $songs_by_score_desc = query_all("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC,id ASC", $party['id']);
        if($songs_by_score_desc == null){
            echo json_encode($songs_by_score_desc);
            exit;
        }
        else if($songs_by_score_desc[0]['id'] == $party['current_song_id']){
            echo json_encode($songs_by_score_desc);
            exit;
        }
        else{
            $size = sizeof($songs_by_score_desc);
            for($i = 0; $i < $size; $i++){
                if($songs_by_score_desc[$i]['id'] == $party['current_song_id']){
                    $tmp = $songs_by_score_desc[0];
                    $songs_by_score_desc[0] = $songs_by_score_desc[$i];
                    $songs_by_score_desc[$i] = $tmp;
                }
            }
            echo json_encode($songs_by_score_desc);
            exit;
        }
        http_response_code(400);
        $error = "There was an error updating the score";
        echo json_encode($error);
    }
?>