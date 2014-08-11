<?php
    require("../src/config.php");
    $party = query("SELECT * FROM Party WHERE id = ?", $user['party_id']);
    if($party["admin"] == $user['id']){
        $admin = true;
    }
    else {
        $admin = false;
    }
    $songs_by_score_desc = query_all("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC", $party['id']);
    render("../templates/partypage.php", ["songs_by_score_desc" => $songs_by_score_desc, "party" => $party, "admin" => $admin]);
?>
