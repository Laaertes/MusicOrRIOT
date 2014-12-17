<?php
    // configuration
    require("../src/config.php");

    $party = query("SELECT * FROM Party WHERE id = ?", $user['party_id']);

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $name = $_POST['name'];
        $url = $_POST['url'];
        //check if the song is already in the queue
        $check = query("SELECT * FROM Song WHERE name = ? AND party_id = ?", $name, $party["id"]);
        if($check) {
            $songs_by_score_desc = query_all("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC", $party['id']);
            echo json_encode($songs_by_score_desc);
        }
        else {
            $complete = insert_or_update("INSERT INTO Song (name, url, party_id) VALUES(?, ?, ?)", $name, $url, $party["id"]);
            //check if the song was correctly inserted
            if($complete === false || $complete === 0){
                http_response_code(400);
                $error = "There was an error adding your file to the server";
                echo json_encode($error);
            }
            else{
                $songs_by_score_desc = query_all("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC", $party['id']);
                echo json_encode($songs_by_score_desc);
            }
        }
    }
?>
