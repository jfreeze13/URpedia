<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8"/>
	  <title>URpedia</title>
	  <link rel="stylesheet" type="text/css" href="MainScreenStyle.css">
	  <!--Link scripts to use-->
	  <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	  <script src="/menu.js"></script>

	  <script language="javascript" type="text/javascript">
	  	var SeasonCook=0;
	  	var WeatherCook=0;
	  	var user;
	  	var wthrcook=0;
	  	var ssncook=0;

			//getCookie, checkCookie functions (modified) from w3schools
			function getCookie(cname) {
					//variable name used to search
					var name = cname + "=";
					//splits cookie into parts based on ";" and put into an array
			    var ca = document.cookie.split(';');
					//for every name/value pair in the array
			    for(var i = 0; i < ca.length; i++) {
							//value in the array at index i
							var c = ca[i];
							//gets rid of spaces if there are any
			        while (c.charAt(0) == ' ') {
			            c = c.substring(1);
			        }
							//if the name in the array at index i is the same as the cname
			        if (c.indexOf(name) == 0) {
									//return the value of the cookie
			            return c.substring(name.length, c.length);
			        }
			    }
					//return "" if cookie isn't found
			    return "";
			}

			//Checks if there is a cookie, finds the username, and displays it on the page
			var checkCookie = function() {
			    user=getCookie("username");
			    if (user != "") {
			        document.getElementById("cookieuser").innerHTML = (user);
			    } else {
						//window.location = "/Login.html\r\n";
			    }
			}

			//logoutfunction
			function logOut(){
				document.cookie="username=deleted; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";
				document.cookie ="chk=deleted; expires=Thu, 01 Jan 1920 00:00:00 GMT";
				document.cookie ="wthr=deleted; expires=Thu, 01 Jan 1920 00:00:00 GMT";
				document.cookie ="ssn=deleted; expires=Thu, 01 Jan 1920 00:00:00 GMT";
				document.cookie ="presNum=deleted; expires=Thu, 01 Jan 1920 00:00:00 GMT";
			}


	 	function loadSong(AudioFileName){
		  var player=document.getElementById('player');
			var sourceaudio=document.getElementById('player');
		  sourceaudio.src=AudioFileName;
		  player.load(); //just start buffering (preload)
		  player.play(); //start playing
		}

		function deleteaccount(){
			$.ajax({
               	url: '../cgi-bin/deleteaccount.py',  // lecture 8 script to query the pizza database

               	data: {                       // the data to send

                   	usr: user
               	},

               	type: "POST",                  // GET or POST

               	dataType: "text",             // html format

               	success: function(response) {   // function to execute upon a successful request
               		console.log("success for connection! User Deleted");
               		console.log(response);
               		location.reload();
									logOut();
               	},

               	error: function(request) {   // function to call when the request fails
                   	console.log("error for connection! User NOT deleted");
                   	console.log(request);

               	}
           	});
		}

		function presets(option){
			if(document.getElementById('saveorload').checked){
				console.log("checked");
				document.cookie ="chk=checked; expires=Thu, 01 Jan 2020 00:00:00 GMT";
				document.cookie ="wthr="+WeatherCook+"; expires=Thu, 01 Jan 2020 00:00:00 GMT";
				document.cookie ="ssn="+SeasonCook+"; expires=Thu, 01 Jan 2020 00:00:00 GMT";
				document.cookie ="presNum="+option+"; expires=Thu, 01 Jan 2020 00:00:00 GMT";
			}else{
				console.log("unchecked");
				document.cookie ="chk=unchecked; expires=Thu, 01 Jan 2020 00:00:00 GMT";
				document.cookie ="presNum="+option+"; expires=Thu, 01 Jan 2020 00:00:00 GMT";
				document.cookie ="wthr="+WeatherCook+"; expires=Thu, 01 Jan 2020 00:00:00 GMT";
				document.cookie ="ssn="+SeasonCook+"; expires=Thu, 01 Jan 2020 00:00:00 GMT";
			}

			$.ajax({
               	url: '../cgi-bin/PresetsSave.py',  // lecture 8 script to query the pizza database

               	data: {                       // the data to send

                   	usr: user
               	},

               	type: "POST",                  // GET or POST

               	dataType: "text",             // html format

               	success: function(response) {   // function to execute upon a successful request
               		console.log("success for database!");
               		if(!(document.getElementById('saveorload').checked)){
                   		console.log("Fetching Cookies");
                   		ssncook = getCookie("ssn");
						ssncook = ssncook.split("\"")[1];
                   		console.log(ssncook);
                   		wthrcook = getCookie("wthr");
						wthrcook = wthrcook.split("\"")[1];
                   		console.log(wthrcook);
	  					document.body.style.backgroundImage = ssncook;
	  					document.getElementById("OverlayImage").style.backgroundImage =wthrcook;
                   	}
               	},

               	error: function(request) {   // function to call when the request fails
                   	console.log("error for database!");
                   	console.log(request);

               	}
           	});
		}
		function changeSeason(SeasonKey) {
	  		var SeasonImage=0;
			SeasonImage = "url(" + SeasonKey + ")";
			SeasonCook='url(\'' + SeasonKey + '\')';
			console.log(SeasonImage);
			console.log(SeasonCook);
	  		document.body.style.backgroundImage = SeasonImage;

	  	}

	  	function changeWeather(WeatherKey) {
			var WeatherImage=0;
			WeatherImage = 'url(\'' + WeatherKey + '\')';
			WeatherCook = 'url(\'' + WeatherKey + '\')';
	  		console.log(WeatherImage);
			document.getElementById("OverlayImage").style.backgroundImage = String(WeatherImage);
	  	}

			


    </script>




	</head>
	<!--Body section, set to run the checkCookie() function when the page loads-->
	<body onload="checkCookie();">

		<div id="banner">
			<div id="logo">
        	<h1>
			<span style="color: #003399">U</span><span style="color: yellow">R</span><span style="color: #003399">pedia</span>
			</h1>
			</div>
		<div id="search">
			<form id="search_button" method="post" >
				<input type="text" name="search_box">
  				<input type="submit" name="Search" value="Search">
  			</form>
		</div>

	</div>

	<div id="background_box1">
		<div id="trending">
		<h2>Trending</h2>


	<?php


	$num1=rand(1,1500);
	$num2=rand(1,1500);
	$num3=rand(1,1500);
	$num4=rand(1,1500);
	$num5=rand(1,1500);

	$server = mysql_connect("localhost","jshang5","iEXDfQqe");
	$db =  mysql_select_db("jshang5",$server);
	$query1 = mysql_query("select title from Article where id=$num1");
	$query2 = mysql_query("select title from Article where id=$num2");
	$query3 = mysql_query("select title from Article where id=$num3");
	$query4 = mysql_query("select title from Article where id=$num4");
	$query5 = mysql_query("select title from Article where id=$num5");


	$row1=mysql_fetch_array($query1);
       

    $row2=mysql_fetch_array($query2);
       
           
    $row3=mysql_fetch_array($query3);
       
           

    $row4=mysql_fetch_array($query4);
       
           
    $row5=mysql_fetch_array($query5);
       


	?>


	<form id="article" method="post" action="mainscreen2.php" >
  			<input type="submit" name="Article" value="<?php echo $row1['title'] ?>">
  		</form>
  	<br>
    <form id="article" method="post" action="mainscreen2.php" >
  			<input type="submit" name="Article" value="<?php echo $row2['title'] ?>">
  		</form>
  	<br>
    <form id="article" method="post" action="mainscreen2.php" >
  			<input type="submit" name="Article" value="<?php echo $row3['title'] ?>">
  		</form>
  	<br>
  	<form id="article" method="post" action="mainscreen2.php" >
  			<input type="submit" name="Article" value="<?php echo $row4['title'] ?>">
  		</form>
  	<br>
  	<form id="article" method="post" action="mainscreen2.php" >
  			<input type="submit" name="Article" value="<?php echo $row5['title'] ?>">
  		</form>
		
		
		
		</div>
		<br>
		


		<div id="categories">
		<h2>Categories</h2>

	<?php



	$server = mysql_connect("localhost","jshang5","iEXDfQqe");
	$db =  mysql_select_db("jshang5",$server);
	$query_field = mysql_query("select field from Field limit 5");


	$f1=mysql_fetch_array($query_field);
    
    
    $f2=mysql_fetch_array($query_field);
    
   

    $f3=mysql_fetch_array($query_field);
    
      

    $f4=mysql_fetch_array($query_field);
    
    

    $f5=mysql_fetch_array($query_field);
    
    

	?>



		<form id="article" method="post" action="show_article_algebra.php" >
  			<input type="submit" name="Article" value="<?php echo $f1['field'] ?>">
  		</form>
		<br>
		
		<form id="article" method="post" action="show_article_analysis.php" >
  			<input type="submit" name="Article" value="<?php echo $f2['field'] ?>">
  		</form>
		<br>
	
		<form id="article" method="post" action="show_article_chemistry.php" >
  			<input type="submit" name="Article" value="<?php echo $f3['field'] ?>">
  		</form>
  		<br>
		

		<form id="article" method="post" action="show_article_complex_analysis.php" >
  			<input type="submit" name="Article" value="<?php echo $f4['field'] ?>">
  		</form>
  		<br>
		

		<form id="article" method="post" action="show_article_computer_science.php" >
  			<input type="submit" name="Article" value="<?php echo $f5['field'] ?>">
  		</form>
  		<br>

  		
  		<form id="article" method="post" action="show_field.php" >
  			<input type="submit" name="Article" value="Show All Categories">
  		</form>

		
		</div>

	



	<div id="background_box2">
		<h2>Article</h2>
		<br>

	</div>


	  <!--Div for account-related buttons: window preset settings and logout button-->
	  <div id="AccountFunctions">
		<form id="login" method="post" action="Login.html" >
  			<input type="submit" onclick="logOut()" name="Logout" value="Log Out">
  		</form>
	  </div>
	</body>
</html>

