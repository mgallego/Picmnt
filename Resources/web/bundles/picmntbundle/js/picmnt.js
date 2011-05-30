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
/*
    function applyFilter(){
	
	var vBrightness = $( "#sBrightness" ).slider( "value" );
	var vContrast = $( "#sContrast" ).slider( "value" );
	var vSaturation = $( "#sSaturation" ).slider( "value" );

	Caman.remoteProxy = "../CamanJS/proxies/caman_proxy.php";

	Caman("#image-id", function () {
	    $( "#render-in-progress" ).show();
	    this.revert(function(){
		this.brightness(vBrightness).contrast(vContrast).saturation(vSaturation).render();
		$( "#render-in-progress" ).hide();
	    });
	    
	});
    };
*/
    function showValue(){

	$( "#bAmount" ).val( $( "#sBrightness").slider( "value"));
	$( "#cAmount" ).val( $( "#sContrast").slider( "value"));
	$( "#aSaturation" ).val( $( "#sSaturation").slider( "value"));
	$( "#aExposure" ).val( $( "#sExposure").slider( "value"));

    };
    
    $(function() {
	$( "#sBrightness , #sContrast, #sSaturation, #sExposure" ).slider({
	    min: -100,
	    max: 100,
	    step: 1,
	    slide: showValue,
	    change: applyFilter
	});
	$( "#bAmount" ).val( $( "#sBrightness" ).slider( "value" ));
	$( "#cAmount" ).val( $( "#sContrast" ).slider( "value" ));
        $( "#aSaturation" ).val( $( "#sSaturation" ).slider( "value" ));
	$( "#aExposure" ).val( $( "#sExposure" ).slider( "value" ));
		
    });
    
    $(function() {
	$( "#accordion" ).accordion({
	    autoHeight:false,
	    collapsible:true,
	    active:false
	});
    });

    
});
