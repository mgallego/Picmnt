$(document).ready(function() {

    $(function() {
	$( ".slider" ).slider(
	    {
		min: -100,
		max:100,
		value: 0,
		step: 1,
		slide: showValues,
		change: applyFilter
	    }
	);
	showValues();
    });

    function showValues(){
	$( '#brightness-amount' ).val($( "#slider-brightness" ).slider( "value" ));
	$( '#contrast-amount' ).val($( "#slider-contrast" ).slider( "value" ));
	$( '#exposure-amount' ).val($( "#slider-exposure" ).slider( "value" ));
	$( '#saturation-amount' ).val($( "#slider-saturation" ).slider( "value" ));
    };

    $('.reset-retouch').click(function(event) {
	event.preventDefault();
	applyProposal(0, 0, 0, 0);
    });

});

function applyFilter(){
    Caman.remoteProxy = "/bundles/sfmpicmnt/libs/caman_proxy.php";
    Caman("#image-to-modify", function () {
	this.revert(function(){
	    this.brightness($( "#slider-brightness" ).slider( "value" ))
		.contrast($( "#slider-contrast" ).slider( "value" ))
		.saturation($( "#slider-saturation" ).slider( "value" ))
		.exposure($( "#slider-exposure" ).slider( "value" ))
		.render();
	});
    });
};


function applyProposal(brightness, contrast, exposure, saturation){


    $( "#brightness-amount" ).val(brightness);
    $( "#contrast-amount" ).val(contrast);
    $( "#exposure-amount" ).val(exposure);
    $( "#saturation-amount" ).val(saturation);

    $( "#slider-brightness , #slider-contrast, #slider-saturation, #slider-exposure" ).slider({
	change: null
    });

    $( "#slider-brightness" ).slider( "value", brightness );
    $( "#slider-contrast" ).slider( "value", contrast );
    $( "#slider-exposure" ).slider( "value", exposure );
    $( "#slider-saturation" ).slider( "value", saturation );

    $( ".slider" ).slider({
	change: applyFilter
    });


    applyFilter();

    document.location.href = '#TOP';

};

function seeOriginal() {
    applyProposal(0, 0, 0, 0);
    document.location.href = '#TOP';
}
