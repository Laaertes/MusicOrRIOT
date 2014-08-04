# Get current user

`$user = query("SELECT * FROM User WHERE session_identifier = ?", $session_identifer);`

# Get party for current user

`$party = query("SELECT * FROM Party WHERE id = ?", $user['party_id']);`

# Get songs for this party

`$songs = query("SELECT * FROM Song WHERE party_id = ?", $user['party_id']);`
OR
`$songs = query("SELECT * FROM Song WHERE party_id = ?", $party['id']);`

# Votes for a song

`$song_score = query("SELECT sum(score) FROM SongVotes WHERE song_id = ?", $song['id']);`

# Songs by their score descending

`$songs_by_score_desc = query("SELECT s.*, ifnull(sum(v.score), 0) as score FROM Song s LEFT JOIN SongVotes v ON s.id = v.song_id WHERE s.party_id = ? GROUP BY s.id ORDER BY score DESC", $party['id']);`

# Get all of a users votes

`$votes = query("SELECT * FROM SongVotes WHERE user_id = ?", $user['id']);`

# Check if a user has voted for a song

`$vote = query("SELECT * FROM SongVotes WHERE user_id = ? AND song_id = ?", $user['id'], $song['id']);`

# Update a vote to different score

`$vote = query("UPDATE SongVotes SET score = -1 WHERE id = ?", $vote['id']);`

# Delete a song and all song votes

`query("DELETE FROM Song WHERE id = ?", $song['id']);`
`query("DELETE FROM SongVotes WHERE song_id = ?", $song['id']);`
