function loadMoreThumbs() {

    $.ajax({
	url: '/app_dev.php/ajax/images/get_more?option='+option+'&page=' +  ++page +'&category='+category+'&username='+ username,
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

	    //document.location.href = '#load-more-thumbs';
	}

    });
}
