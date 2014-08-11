/**
 * Uses the spotifyApi to search for a track and returns the data to be displayed by displaySearch()
 */
function searchSpotify() {
	var searchTerm = document.getElementById("searchbox1").value;
    var spotifyApi = new SpotifyWebApi();
        spotifyApi.searchTracks(searchTerm)
            .then(function(data) {
                    console.log('Found: ', data);
                    displaySearch(data);
                }, function(err) {
                    //Errors will appear in the console not to the user
                    console.error(err);
                });
}

/**
 * This will display the data from the spotifyAPI search to the user
 * This will display the first 5 results by Name - Artist - Album
 * @param data - Result object from Spotify
 */
function displaySearch(data) {
    var d = data.tracks.items;
    var list = document.getElementById('searchList');
    while(list.hasChildNodes()){
        list.removeChild(list.lastChild);
    }
	var length = Math.min(5, d.length);
	for (var i=0; i<length; i++) {
	    var liNode = document.createElement("li");
        var innerDiv = document.createElement("div");
	    var addSongButton = document.createElement("button");
	    
	    d[i].loudsourceName = d[i].name + " - " + d[i].artists[0].name + " - " + d[i].album.name;
	    
	    addSongButton.onclick = function(song) { addSong(song.loudsourceName, song.preview_url) }.bind(undefined, d[i]);
        addSongButton.textContent = "Add";
        addSongButton.className += ' btn btn-primary btn-sm';
	    
	    liNode.textContent = d[i].loudsourceName;
	    innerDiv.appendChild(addSongButton);
        liNode.appendChild(innerDiv);
	    list.appendChild(liNode);
	}
}

/**
 * Checks if the key pressed was the enter key. If so searchSpotify()
 */
function checkKey(){
	if(event.keyCode==13) {
        searchSpotify();
	}
}

//audioObject to be shared by the play and the playSong method
var audioObject;

/**
 * Initializes the audiObject
 * When a song is finished it removes that song from the database and begins playing the next song from the queue
 * @param url - url location of the next song to be played
 * @param id - database id of the song being played
 */
function playSong(url, id){
    audioObject = new Audio(url);
    var that = audioObject;
    audioObject.addEventListener('ended', function() {
        reqwest({
            url: 'removefromqueue.php',
            method: 'post',
            type: 'json',
            data: { id: id },
            success: function(resp) {
                refreshQueue(resp);
                playSong(resp[0].url, resp[0].id);
                audioObject.play();
            },
            error: function(error) {
                console.log("Error Occurred: " + error.responseText);
            }
        });
    });
    audioObject.addEventListener('pause', function() {
        //target.classList.remove(playingCssClass);
    });
    audioObject.load();
}

//Keep track of whether or not the current song is being played. On page load this is false.
var playing = false;

/**
 * Allows the party admin to pause and play the music
 */
function play(){
    var player = document.getElementById("player");
    if(!playing){
        audioObject.play();
        player.textContent = "Pause!";
        playing = true;
    }
    else {
        player.textContent = "Play!";
        playing = false;
        audioObject.pause();
    }
}

/**
 * Loads the current queue from the database to be displayed
 * Prepares the player button for the party admin
 */
function loaded() {
    reqwest({
        url: 'partypageinfo.php',
        method: 'get',
        type: 'json',
        success: function(resp) {
            refreshQueue(resp);
            playSong(resp[0].url, resp[0].id);
        },
        error: function(error) {
            console.log("Error Occurred: " + error.responseText);
        }
    });
}

/**
 * When a search result is clicked to be added, add the song to the database and update the queue
 * @param name - name of the song to be added
 * @param url - url of the song to be added
 */
function addSong(name, url){
    if (url=="" || name=="") {
        console.log("Error in element values");
        return;
    }
    reqwest({
        url: 'uploadsong.php',
        method: 'post',
        type: 'json',
        data: { name: name, url: url },
        success: function(resp) {
            var list = document.getElementById('searchList');
            while(list.hasChildNodes()){
                list.removeChild(list.lastChild);
            }
            refreshQueue(resp);
        },
        error: function(error) {
            console.log("Error Occurred: " + error.responseText);
        }
    });
}

/**
 * Refreshes the queue with the data returned from the database
 * @param data - songs are ordered by vote count descending
 */
function refreshQueue(data){
    var list = document.getElementById('queueList');
    while(list.hasChildNodes()){
        list.removeChild(list.lastChild);
    }
    for(var i = 0; i < data.length; i++){
        //The first song is song currently playing
        if(i === 0){
            var currentSong = document.getElementById('currentSong');
            currentSong.textContent = "Now Playing: " + data[i].name + ": " + data[i].score;
        }
        //The rest of the songs are put into the queue list
        else{
            var liNode = document.createElement("li");
            var upvoteNode = document.createElement("button");
            var downvoteNode = document.createElement("button");
            var outerDiv = document.createElement("div");

            upvoteNode.onclick = function(song) { updateVoteCount(song.id, 1) }.bind(undefined, data[i]);
            upvoteNode.textContent = "Up Vote";
            upvoteNode.className += ' btn btn-primary btn-sm';
            downvoteNode.onclick = function(song) { updateVoteCount(song.id, -1) }.bind(undefined, data[i]);
            downvoteNode.textContent = "Down Vote";
            downvoteNode.className += ' btn btn-primary btn-sm';

            liNode.textContent = (data[i].name + ": " + data[i].score);
            outerDiv.appendChild(upvoteNode);
            outerDiv.appendChild(downvoteNode);
            liNode.appendChild(outerDiv);
            list.appendChild(liNode);
        }
    }
}

/**
 * When a song is voted either up or down, make the change in the database and update the queue
 * @param id - id of the song being updated
 * @param score - vote change to be made in the database
 */
function updateVoteCount(id, score){
    if (id === null || score === null) {
        console.log("Error Empty Element");
        return;
    }
    
    reqwest({
        url: 'updatevotesong.php',
        method: 'post',
        type: 'json',
        data: { id: id, score: score },
        success: function(resp) {
            refreshQueue(resp);
        },
        error: function(error) {
            console.log("Error Occurred: " + error);
        }
    });
}
