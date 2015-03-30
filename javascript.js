/* JavaScript for Checkin
 *
 * All code by Matt DePero
 */

// URL to folder that contains serverfile.php, including '/' on the end
var serverRootURL = "http://107.10.18.206/";

// The refresh rate for pulling updates to the check in database in refreshes per second (can be less than one per second)
var refreshfps=1;




var xmlhttp;
if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari

	xmlhttp=new XMLHttpRequest();
}else{// code for IE6, IE5

	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}






// +----------------------------------------+
// |             Sending Checkin            |
// +----------------------------------------+


function setData( data ){
	var url = serverRootURL+"serverfile.php?set="+data+"&t=" + Math.random();
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
}


// +----------------------------------------+
// |        Getting Roster/Checkins         |
// +----------------------------------------+



function fetchData(){
	var url = serverRootURL+"serverfile.php?get&t=" + Math.random();
	xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            returnedData = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function refresh(){
 alert("Test");
	
}

window.onload = window.setInterval(refresh, 1000/refreshfps);



