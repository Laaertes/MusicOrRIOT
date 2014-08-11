//search the api for the correct track
function searchMe() {
	var searchTerm = document.getElementById("searchbox1").value;
	//alert("Searching for: "+"\""+searchTerm+"\"");
    //insert API call here
    var spotifyApi = new SpotifyWebApi();
        spotifyApi.searchTracks(searchTerm)
            .then(function(data) {
                    console.log('Found: ', data);
                    //Sort through and display the data with a function call here
                    search(data);
                    //playSong(data.tracks.items[0].preview_url);
                }, function(err) {
                    //Handle an API search error
                    console.error(err);
                });
}

//Displays search results
function search(data) {
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

//Prepares the audioObject to play the a song
var audioObject;
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

var playing = false;
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
//start playing on page load?
function loaded() {
    //this loads the current que from the database
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

//add song to database on click
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

function refreshQueue(data){
    var list = document.getElementById('queueList');
    while(list.hasChildNodes()){
        list.removeChild(list.lastChild);
    }
    for(var i = 0; i < data.length; i++){
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
