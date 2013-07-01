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

$(function(){
    $.contextMenu({
        selector: 'html', 
        callback: function(key,options) { dostuff(key,options); },
        items: {
            "lfs": {name: "Launch Fullscreen"}
        }
    });
});

function dostuff(key, options) {
	if (key == 'lfs') {
		launchFullScreen(document.documentElement);
	}
}