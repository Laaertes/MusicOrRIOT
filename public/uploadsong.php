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
        $url = $_GET['url'];
        //check if the song is already in the queue
        $check = query("SELECT * FROM Song WHERE name = ? AND party_id = ?", $name, $user["party_id"]);
        if($check) {
            echo json_encode("Song Exists");
        }
        else {
            $complete = insert_or_update("INSERT INTO Song (name, url, party_id) VALUES(?, ?, ?)", $name, $url, $party["id"]);
            //check if the song was correctly inserted
            if($complete === false || $complete === 0){
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