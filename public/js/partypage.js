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