$(document).ready(function() {

    $(function() {
	$( ".slider" ).slider(
	    {
		min: -100,
		max:100,
		value: 0,
		step: 1,
		slide: showValue,
		change: applyFilter
	    }
	);
    });


    function applyFilter(){
	
	var vBrightness = $( "#slider-brightness" ).slider( "value" );
	var vContrast = $( "#slider-contrast" ).slider( "value" );
	var vSaturation = $( "#slider-saturation" ).slider( "value" );
	var vExposure = $( "#slider-exposure" ).slider( "value" );
	
	Caman("#image-to-modify", function () {
	    this.revert(function(){
		this.brightness(vBrightness).contrast(vContrast).saturation(vSaturation).exposure(vExposure).render();
	    });
	});
    };




    function showValue(){
	console.log('entrando');

    	var vBrightness = $( "#slider-brightness" ).slider( "value" );
    	// var vContrast = $( "#slider-contrast" ).slider( "value" );
    	// var vSaturation = $( "#slider-saturation" ).slider( "value" );
    	// var vExposure = $( "#slider-exposure" ).slider( "value" );

    	console.log('Brightness: '.vBrightness);	
    	// console.log('Contrast: '.vContrast);
    	// console.log('Saturation: '.vSaturation);
    	// console.log('Exposure: '.vExposure);
    };

})
