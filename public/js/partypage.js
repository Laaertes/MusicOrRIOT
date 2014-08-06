function searchMe() {
	var searchTerm = document.getElementById("searchbox1").value;
	//alert("Searching for: "+"\""+searchTerm+"\"");
    //insert API call here
	
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
	    		alert("Found name! And it is: " + subText[i+1] + " at index: "+i);
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