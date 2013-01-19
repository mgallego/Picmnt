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

    function showValues(){
	$( '#brightness-amount' ).val($( "#slider-brightness" ).slider( "value" ));
	$( '#contrast-amount' ).val($( "#slider-contrast" ).slider( "value" ));
	$( '#exposure-amount' ).val($( "#slider-exposure" ).slider( "value" ));
	$( '#saturation-amount' ).val($( "#slider-saturation" ).slider( "value" ));
    };

})
