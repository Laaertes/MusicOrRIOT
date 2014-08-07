<?php
    // configuration
    require("../src/functions.php");

    if (empty($_COOKIE['session_identifier'])) {
        srand(time());
        $random_number = rand();
        $session_identifier = sha1($random_number);
        insert_or_update("INSERT INTO User (session_identifier) VALUES (?)", $session_identifier);
        setcookie('session_identifier', $session_identifier, time()+60*60*24*30);
        $user = query("SELECT * FROM User WHERE session_identifier = ?", $session_identifier);
    } else {
        $user = query("SELECT * FROM User WHERE session_identifier = ?", $_COOKIE['session_identifier']);
    }

    $party = query("SELECT * FROM Party WHERE id = ?", $user['party_id']);

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $name = ($_GET['name']);
        $number = intval($_GET['number']);
        //check if the song is already in the queue
        $song = query("SELECT * FROM Song WHERE name = ? AND party_id = ?", $name, $user["party_id"]);
        //check if it has been voted on
        $check = query("SELECT * FROM SongVotes WHERE song_id = ?", $song['id']);
        //If the song exists update the number count
        if($check) {
            $complete = insert_or_update("UPDATE SongVotes Set score = ? WHERE id = ?", ($check['score'] + $number), $check['id']);
            //check if the song was correctly inserted
            if($complete === false || $complete === 0){
                echo json_encode($number);
            }
            else{
                $songs_by_score_desc = query_all("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC", $party['id']);
                echo json_encode($songs_by_score_desc);
            }
        }
        //If the song does not exist add it to the song vote table
        else {
            $complete = insert_or_update("INSERT INTO SongVotes (user_id, song_id, score) VALUES(?, ?, ?)", $user['id'], $song['id'], $number);
            //check if the song was correctly inserted
            if($complete === false || $complete === 0){
                $error = "There was an error adding your file to the server";
                echo json_encode($number);
            }
            else{
                $songs_by_score_desc = query_all("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC", $party['id']);
                echo json_encode($songs_by_score_desc);
            }
        }
    }
?>