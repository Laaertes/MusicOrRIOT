<?php
    // configuration
    require("../src/config.php");

    $party = query("SELECT * FROM Party WHERE id = ? AND admin = ?", $user['party_id'], $user['id']);

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if ($party) {
            $id = $_POST['id'];
            $check = query("SELECT * FROM Song WHERE id = ? AND party_id = ?", $id, $party["id"]);
            if ($check) {
                // delete song
                insert_or_update("DELETE FROM SongVotes WHERE song_id = ?", $check['id']);
                insert_or_update("DELETE FROM Song WHERE id = ?", $check['id']);
                //return the queue
                $songs_by_score_desc = query_all("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC,id ASC", $party['id']);
                if($songs_by_score_desc){
                    insert_or_update("UPDATE Party Set current_song_id = ? WHERE id=?",  $songs_by_score_desc[0]['id'], $party["id"]);
                }
                echo json_encode($songs_by_score_desc);
                exit;
            }
        }
    }
    http_response_code(400);
?>
