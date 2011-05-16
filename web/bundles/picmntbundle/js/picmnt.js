$(document).ready(function() {

    //open a fancybox like a new iframe
    $("#fBIframe").fancybox({
	'width': '50%',
	'height': '50%',
	'autoScale': false,
	'transitionIn': 'none',
	'transitionOut': 'none',
	'type': 'iframe'
    });

    //submit the upload form and close de fancybox iframe
    $('#upload_form').submit(function(){
	
	$.ajax({
	    
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
   
            success: function(data) {
		parent.$.fancybox.close();
	    }
	    
	});
	
	return false;
	
    });
});
