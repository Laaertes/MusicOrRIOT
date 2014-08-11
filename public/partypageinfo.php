<?php
    require("../src/config.php");
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $party = query("SELECT * FROM Party WHERE id = ?", $user['party_id']);
        $songs_by_score_desc = query_all("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC", $party['id']);
        echo json_encode($songs_by_score_desc);
    }
?>