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
                    playSong(data.tracks.items[0].preview_url);
                }, function(err) {
                    //Handle an API search error
                    console.error(err);
                });
}

//Displays search results
function search(data) {
	alert("Attempting to display search results...");
	
	document.getElementById("name").innerHTML=data.tracks.items[0].name;
	document.getElementById("artist").innerHTML=data.tracks.items[0].artists[0].name;
	document.getElementById("album").innerHTML=data.tracks.items[0].album.name;
	
	//alert(data.tracks.items[0].name);
	//alert(data.tracks.items[0].artist);
}

//Prepares the audioObject to play the a song
var audioObject;
function playSong(url){
    audioObject = new Audio(url);
    var that = audioObject;
    audioObject.addEventListener('ended', function() {
        var queueList = document.getElementById("queueList");
        if (queueList.hasChildNodes()){
            var next = queueList.firstChild.preview_url;
            that.src = ("https://p.scdn.co/mp3-preview/6c43a340ad55f6961354bfa3b24499058dff1cb6");
            that.load();
            that.play();
        }
    });
    audioObject.addEventListener('pause', function() {
        //target.classList.remove(playingCssClass);
    });
}

var playing = false;
function play(data){
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
    var queueList = document.getElementById("queueList");
    if (queueList.hasChildNodes()){
        playSong("https://p.scdn.co/mp3-preview/856be864790a7e2136743a8ac5c368478fcbcac0");
        play();
    }
    else {
        console.log("AH!");
    }
}

//add song to database on click
function sendToDatabase(name, url){
    if (url=="" || name=="") {
        console.log("Error in element values");
        return;
    }
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var data = JSON.parse(xmlhttp.responseText);
            console.log(data);
            if(data === "Song Exists" || data === "There was an error adding your file to the server"){
                console.log("Error Occurred");
            }
            else{
                refreshQueue(data);
            }
        }
    };
    name = "name";
    url = "https://p.scdn.co/mp3-preview/856be864790a7e2136743a8ac5c368478fcbcac0";
    xmlhttp.open("GET","uploadsong.php?name="+name+"&url="+url,true);
    xmlhttp.send();
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
        
        upvoteNode.onclick = function(song) { updateVoteCount(song.id, 1) }.bind(undefined, data[i]);
        upvoteNode.textContent = "Up Vote";
        downvoteNode.onclick = function(song) { updateVoteCount(song.id, -1) }.bind(undefined, data[i]);
        downvoteNode.textContent = "Down Vote";
        
        liNode.textContent = (data[i].name + ": " + data[i].score);
        liNode.appendChild(upvoteNode);
        liNode.appendChild(downvoteNode);
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
