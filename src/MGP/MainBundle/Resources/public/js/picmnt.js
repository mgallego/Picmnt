$(document).ready(function() {



    $('#load-more-thumbs').click(function(event) {
	event.preventDefault();

	route = Routing.generate('ajax_img_get_more', {'option': option, "page": ++page, "category": category, "username": username});
	console.log(route);
	$.ajax({
	    url: route,
	    async: false,
	    dataType: 'json'
	}).success(function(images) {
	    console.log('b');
	    for (i in images)
	    {
		image = images[i];

		htmlText = "<li class='span3'>\
                       <div class='thumbnail'>\
                       <a href='"+  image['imageViewUrl'] +"'><img src='" +  image['url'] + "' alt='" + image["title"] + "'/></a>\
                       <div class='thumb-info'>\
                       <span><a href='"+  image['imageViewUrl'] +"'><h5>" + image["title"] + "</h5></a></span>\
                       <p>\
                       " + image['authorLabel'] + ": <a href='"+ image['userUrl'] +"'>\
                       "+ image["username"] +"\
                       </a>\
                       </p>\
                       </div>\
                       </li>";

		$('.thumbnails').append(htmlText);
	    }
	})

    });


    $('#category-select').change(function() {
	window.location = route = Routing.generate('show_thumbnails', {'option': option, 'cat': $('#category-select option:selected').text().toLowerCase() });
    });

});

