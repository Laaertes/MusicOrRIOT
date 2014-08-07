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
                    //yourfunction(data);
                    playSong(data.tracks.items[0].preview_url);
                }, function(err) {
                    //Handle an API search error
                    console.error(err);
                });
	//test code for now
	readTextFile();
}

function readTextFile()
{
	alert("Attempting to read .txt...");
	
	//Loading text file for testing parsing
	var x = new XMLHttpRequest(); 
	x.open("GET","js/searchPF.txt",false); 
	x.send(); 
	var myTextFile=x.responseText; 
	
	//splitting the string into substrings
	var subText = myTextFile.split(" ");
	
	//alert(subText[89]);
	//alert("\"name\": \"Time\",");
	
	var answ=0;
	for (i = 0; i<200; i++) { 
	    if (subText[i]==="\"name\":")
	    	{
	    		var name1=subText[i+1];
	    		var name="loudsource";
	    		//alert("name1[6] is: " + name1[6]);
	    		
	    		//*
	    		//Here is where the parsing happens
	    		//It goes through every letter of the substring right after "Name": and isolates the name of the song to return
	    		for (j=1;j<name1.length-2;j++)
	    			{
	    				alert("loop " + j);
	    				alert(name1[j]);
	    				//name[j-1]=name1[j];
	    				//alert(name[j-1]);
	    			}
	    		//*/
	    		alert("Found name! And it is: " + name + " at index: "+i);
	    		answ=1;
	    	}
	}
	
	
	if (answ===0)
		{
			alert("Did not find name");
		}
	
	
	
	
	
	//Displays result
	//document.getElementById("displayResult").innerHTML = subText;
	
	
	alert("Finish");
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
        liNode.textContent = (data[i].name + ": " + data[i].score);
        list.appendChild(liNode);
    }
}

function updateVoteCount(num){
    if (this.textContent === "" || num === null) {
        console.log("Error Empty Element");
        return;
    }
    //var name = this.textContent.split(";")[0];
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            var data = JSON.parse(xmlhttp.responseText);
            console.log(data);
            if(data === "There was an error adding your file to the server"){
                console.log("Error Occurred");
            }
            else{
                refreshQueue(data);
            }
        }
    };
    var name = 'name';
    num = 1;
    xmlhttp.open("GET","updatevotesong.php?name="+name+"&number="+num,true);
    xmlhttp.send();
}