$(document).ready(function() {

    //show the image in the comment section
    $('#show-image-to-comment').waypoint(function(event, direction) {
	if ('down' === direction) {
	    $('#image-to-comment').fadeIn();
	} else {
	    $('#image-to-comment').fadeOut();
	}
    });

});
