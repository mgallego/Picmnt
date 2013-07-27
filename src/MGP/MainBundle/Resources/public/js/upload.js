$(document).ready(function(){
    function handleFileSelect(evt) {
	var files = evt.target.files; // FileList object

	// Loop through the FileList and render image files as thumbnails.
	for (var i = 0, f; f = files[i]; i++) {

	    // Only process image files.
	    if (!f.type.match('image.*')) {
		continue;
	    }

	    var reader = new FileReader();

	    // Closure to capture the file information.
	    reader.onload = (function(theFile) {
		return function(e) {

		    // Render thumbnail.
		    var span = document.createElement('span');
		    span.innerHTML = ['<li><img class="thumbnail" src="', e.target.result,
				      '" title="', escape(theFile.name), '"/></li>'].join('');

		    $('#thumbs').html(span);
		};
	    })(f);

	    // Read in the image file as a data URL.
	    reader.readAsDataURL(f);
	}
    }

    document.getElementById('picmnt_image_imageuptype_dataFile').addEventListener('change', handleFileSelect, false);
});
