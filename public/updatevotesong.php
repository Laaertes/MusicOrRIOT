<?php
    // configuration
    require("../src/config.php");

    $party = query("SELECT * FROM Party WHERE id = ?", $user['party_id']);

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $id = $_POST['id'];
        $score = intval($_POST['score']);
        //check if the song is already in the queue
        $song = query("SELECT * FROM Song WHERE id = ? AND party_id = ?", $id, $party['id']);
        if ($song) {
            //check if it has been voted on
            $check = query("SELECT * FROM SongVotes WHERE song_id = ? AND user_id = ?", $song['id'], $user['id']);
            //If the song exists update the number count
            if($check) {
                if ($check['score'] == $score) {
                    $complete = insert_or_update("UPDATE SongVotes Set score = 0 WHERE id = ?", $check['id']);
                }
                else {
                    $complete = insert_or_update("UPDATE SongVotes Set score = ? WHERE id = ?", $score, $check['id']);
                }
                //check if the song was correctly inserted
                if($complete) {
                    $songs_by_score_desc = query_all("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC,id ASC", $party['id']);
                    echo json_encode($songs_by_score_desc);
                    exit;
                }
            }
            //If the song does not exist add it to the song vote table
            else {
                $complete = insert_or_update("INSERT INTO SongVotes (user_id, song_id, score) VALUES(?, ?, ?)", $user['id'], $song['id'], $score);
                //check if the song was correctly inserted
                if($complete) {
                    $songs_by_score_desc = query_all("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC,id ASC", $party['id']);
                    echo json_encode($songs_by_score_desc);
                    exit;
                }
            }
        }
        http_response_code(400);
        $error = "There was an error updating the score";
        echo json_encode($error);
    }
?>
