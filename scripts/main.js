var cardContent = ['1','2','3','4','5','6','7','8','9','10','1','2','3','4','5','6','7','8','9','10'];
var cardClicks = 0;

var firstSelection;
var secondSelection;
var previousCard;
var intervalTimer;
var gameStartTime;
var matchCount = 0;

var FB_TOKEN;
var URL = "https://broccolisys.com/webservices/";
var gameSession ="";

function openGame(){
	console.log("GAME");
	$('.game-container').show();
	$('.highscore-container').hide();
	$('#but-game').addClass("tab-active");
	$('#but-highscore').removeClass("tab-active");
}

function openHighscore(){
	console.log("HIGHSCORE");
	$('.game-container').hide();
	$('.highscore-container').show();
	$('#but-game').removeClass("tab-active");
	$('#but-highscore').addClass("tab-active");
}

function closeIntroPopin(){
	$(".intro-popin-container").fadeOut();
	initialise();
}

function initialise(){

	cardContent = shuffle(cardContent);
	// targeting container
	for(var i=0;i<20;i++){
		var card="<div class='flip-card'><div class='flip-card-inner' id='card"+i+"' onclick='selectCard("+i+","+cardContent[i]+")'><" +
			"div class='flip-card-front'></div><div class='flip-card-back' style='background-image: " +
			"url(img/card"+cardContent[i]+".png)'></div></div></div>";

		$(".card-container").append(card);

	}

	/*Kick it after 1000 ms. When we are addingall the cards dynamically, it will take a small lapse of time
	* before all the image are loaded. So it's a good thing that we put a small delay here so that the user have
	* some time before starting the game*/
	setTimeout(function(){startTimer(),1000})
}

function startTimer() {
	startGameServer();
	gameStartTime = new Date().getTime();
	intervalTimer = setInterval(incrementTime, 100);
}

/*This function are going to upda	// targeting containerte the container here the div with the timer container and update it with the time
* in terms of seconds minutes and milliseconds */
function incrementTime() {
	/*We are going to use the code once more once the game is over. */
	var currentTime = gameCounterTime();
	$(".timer").text(currentTime);

}
/*This function is going to return the time that has elapsed since the start of the game*/
function gameCounterTime() {
	var newTime = new Date().getTime();

	var difference = newTime - gameStartTime;

	// 73500 milliseconds
	// 73500 % 60.000 = 13500
	// 13500 / 1000 = 13.5
	// Floor = 13 seconds

	var seconds = Math.floor((difference % (1000 * 60)) / 1000);
	var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000*60));
	var milli = difference % 1000;

	seconds = ('0' + seconds).slice(-2);
	minutes = ('0' + minutes).slice(-2);

	var displayText = minutes + ":" + seconds + ":" + milli;

	return displayText;

}

function selectCard(id,current){
	console.log(id, current);
	var cardID = "#card"+id;

	if(!$(cardID).hasClass('rotate180' && cardClicks!=2) & cardClicks !=2){
		$(cardID).addClass('rotate180');

		cardClicks++;

		if (cardClicks==1){
			firstSelection = current;
			previousCard = cardID;
		}

		if (cardClicks==2){
			secondSelection = current;

			if(firstSelection == secondSelection){
				console.log('Match!!');

				matchCount++;
				if(matchCount ==2)	{
					clearInterval(intervalTimer);
					var currentTime = gameCounterTime();
					$(".timer").text(currentTime);

					setTimeout(function(){$(".game-finish").show()},1000);

					var newTime = new Date().getTime();
					var timeDifferenceMilli = newTime - gameStartTime;

					if(!FB_TOKEN){
						$('.save-message').show();
					}

					saveGame(timeDifferenceMilli, currentTime);
				}

				setTimeout(function(){
					cardClicks=0;
				},500)
			}else{
				setTimeout(function(){
					$(cardID).removeClass('rotate180');
					$(previousCard).removeClass('rotate180');
					cardClicks=0;
				},500)

			}

		}
	}

}


function saveGame(timeDifferenceMilli, currentTime) {

	console.log("SAVING GAME");

	$.ajax({
		type:"POST",
		data:{'session' : gameSession, 'millisec': timeDifferenceMilli, 'time':currentTime},
		url : "https://broccolisys.com/webservices/saveGame.php",
		// url: URL + "startGame.php",
		success : function(data){
			console.log(data);
		},
		error : function(data){
			console.log(data)
		}
	})
}

function savePlayer() {

	console.log("SAVING Player");

	$.ajax({
		type:"POST",
		data:{'session' : gameSession, 'token': FB_TOKEN},
		url : "https://broccolisys.com/webservices/savePlayer.php",
		// url: URL + "startGame.php",
		success : function(data){
			console.log(data);
		},
		error : function(data){
			console.log(data)
		}
	})
}

function startGameServer(){
	console.log("Starting game on Server");
	$.ajax({
		type:"POST",
		data:{'token' : FB_TOKEN},
		url : "https://broccolisys.com/webservices/startGame.php",
		// url: URL + "startGame.php",
		success : function(data){
			console.log(data);
			r = JSON.parse(data);
			gameSession = r[0].data;
			console.log("gameSession",gameSession);
		},
		error : function(data){
			console.log(data)
		}
	})
}

function shuffle(arra1) {
	var ctr = arra1.length, temp, index;

// While there are elements in the array
	while (ctr > 0) {
// Pick a random index
		index = Math.floor(Math.random() * ctr);
// Decrease ctr by 1
		ctr--;
// And swap the last element with it
		temp = arra1[ctr];
		arra1[ctr] = arra1[index];
		arra1[index] = temp;
	}
	return arra1;
}

// FACEBOOK CALLS 

function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
	console.log('statusChangeCallback');
	console.log(response);                   // The current login status of the person.
	if (response.status === 'connected') {   // Logged into your webpage and Facebook.
		FB_TOKEN = response.authResponse.accessToken;
		getUserDetails();
	} else {                                 // Not logged into your webpage or we are unable to tell.
		//document.getElementById('status').innerHTML = 'Please log ' +
		//	'into this webpage.';
	}
}


function checkLoginState() {               // Called when a person is finished with the Login Button.
	FB.getLoginStatus(function(response) {   // See the onlogin handler
		statusChangeCallback(response);
	});
}


window.fbAsyncInit = function() {
	FB.init({
		appId      : '3365000726849357',
		cookie     : true,                     // Enable cookies to allow the server to access the session.
		xfbml      : true,                     // Parse social plugins on this webpage.
		version    : 'v6.0'           // Use this Graph API version for this call.
	});


	FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
		statusChangeCallback(response);        // Returns the login status.
		FB.Event.subscribe('auth.statusChange',function(response){

		},true);
	});
};


(function(d, s, id) {                      // Load the SDK asynchronously
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "https://connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


function getUserDetails() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
	console.log('Welcome!  Fetching your information.... ');
	FB.api('/me', function(response) {
		console.log('Successful login for: ' + response.name);
		// document.getElementById('status').innerHTML =
		// 	'Thanks for logging in, ' + response.name + '!';
	});
}

function facebookLogin() {
	FB.login(function (response) {
		if (response.status === 'connected') {
			FB_TOKEN = response.autoResponse.accessToken;
			savePlayer();
			// Logged into your webpage and Facebook.
		} else {
			// The person is not logged into your webpage or we are unable to tell.
		}
	},{scope : 'public_profile, email'});
}
