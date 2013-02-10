function getMore() {

    $.ajax({
	url: '/app_dev.php/ajax/images/get_more?option=recents&page=' +  ++page,
	async: false,
	dataType: 'json'
    }).success(function(images) {
	for (i in images)
	{
	    image = images[i];

	    htmlText = "<div class='thumbnail'>\
                       <div class='img-thumb'>\
                       <a href='"+  image['imageViewUrl'] +"'><img src='" +  image['url'] + "' alt='" + image["title"] + "'/></a>\
                       <div class='thumb-info'>\
                       <span>" + image["title"] + "</span>\
                       <p>\
                       " + image['authorLabel'] + ": <a href='"+ image['userUrl'] +"'>\
                       "+ image["username"] +"\
                       </a>\
                       </p>\
                       </div>\
                       </div>\
                       </div>";

            $('.img-thumbs').append(htmlText);

	    //goto last
	}

    });
}
