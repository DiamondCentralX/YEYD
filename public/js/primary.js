/*	php-site - Primary JS file
 *	Last updated: 12.07.2013
 */

/* clickerx - start */
function clickerx(){
	var audio = document.createElement("audio");
	audio.src = "/audio/clickerx.wav";
	audio.addEventListener("ended", function () {
		//document.removeChild(this);
	}, false);
	audio.play();
	$.ajax({
		url:"/ajax/addclick.php",
		success:function(result){
			$(".clicks").html(result);
		}
	});
}

$(document).bind('click', function() { clickerx(); });
/* clickerx - end */

/* load page stuff */
var loader = {
		loader: $('<div/>', { class: 'loader' }),
		container: $('#pagecont')
}

function loadPage(page) {
	$.ajax({
		url: page,
		beforeSend: function() {
			loader.container.append(loader.loader);
		},
		success: function(data) {
			loader.container.html(data);
		}
	});
}

var footerMoreState = false;
$('#footer-more-btn').on('click', function () {
	if (footerMoreState) {
		footerMoreState = false;
		$('#footer-more-btn').fadeOut(500, function () {
			$('#footer-more-btn').html('<i class="icon-expand-alt"></i>');
			$('#footer-more-btn').fadeIn(500);
		});
		$('#footer-more').fadeOut(1000);
	} else {
		footerMoreState = true;
		$('#footer-more-btn').fadeOut(500, function () {
			$('#footer-more-btn').html('<i class="icon-collapse-alt"></i>');
			$('#footer-more-btn').fadeIn(500);
		});
		$('#footer-more').fadeIn(1000);
	}
});

/*
$(document).keypress(function(event){
	switch (String.fromCharCode(event.which)) {
		case 'j':
			window.location = '?';
			break;
		case 'k':
			window.location = '?Sondre2B';
			break;
		case 'l':
			window.location = '?Sondre2L';
			break;
		case 'h':
			window.location = '?DWH';
			break;
		case 'f':
			launchFullScreen(document.documentElement);
			break;
		default:
			console.log(event.which);
	}
});*/

// Find the right method, call on correct element
function launchFullScreen(element) {
	if(element.requestFullScreen) {
		element.requestFullScreen();
	} else if(element.mozRequestFullScreen) {
		element.mozRequestFullScreen();
	} else if(element.webkitRequestFullScreen) {
		element.webkitRequestFullScreen();
	}
}

// Whack fullscreen
function cancelFullscreen() {
	if(document.cancelFullScreen) {
		document.cancelFullScreen();
	} else if(document.mozCancelFullScreen) {
		document.mozCancelFullScreen();
	} else if(document.webkitCancelFullScreen) {
		document.webkitCancelFullScreen();
	}
}