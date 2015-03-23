<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Flickr Search</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<style>
		#search-form {
			width: 300px;
		}
	</style>
	<script>
		var key = 'd21e5d3b7fc02304be47844136741e55';
		var base_url = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=" + key + "&format=json&nojsoncallback=1";

		$(document).ready(function () {
            //function that takes response from ajax and builds the url of img
			var displayPhotos = function (photos) {
                //checks if response is greater than 0
				if(photos.length > 0){
					$('#photo-list').html('');
                //no photos matched search
				}else{
					$('#photo-list').html('No Photos Found');
				}
                //loops through the responses and builds <img> tags for them then appends them to the body in the specified div
				for (var index in photos) {
					var photoObj = photos[index];
					var url = 'https://farm' + photoObj.farm + '.staticflickr.com/' + photoObj.server + '/' + photoObj.id + '_' + photoObj.secret + '.jpg'
					var img = $('<img/>').attr('src', url).width(250);
					$('#photo-list').append(img);
				}
			}
            //click handler to trigger the ajax call
			$('body').on('click', '#search-btn', function () {
				var val = $('#search').val();
				var search_url = base_url + "&text=" + val;
				var photos = [];
                //searching status message
				$('#photo-list').html('Searching');
                //ajax call
				$.ajax({
					url: search_url,
					dateType: 'json',
					crossDomain: true,
                    //add photo data into photo array then pass it to displayPhotos function
					success: function (response) {
						photos = response.photos.photo;
						displayPhotos(photos);
					},
                    //print error message if there was an error
					error: function (response) {
						console.error(response);
					}
				});


			});
		});
	</script>

</head>

<body>
	<div id="search-form">
		<div class="panel panel-default panel-primary">
			<div class="panel-heading">Search Flickr</div>
			<div class="panel-body">
				<div class="form-group">
					<div class="input-group input-group-lg">
						<span class="input-group-addon glyphicon glyphicon-search"></span>
						<input id="search" type="text" class="form-control" placeholder="Search" name="search" />
					</div>
				</div>
				<button id="search-btn" class="btn btn-lrg btn-default pull-right">Search</button>
			</div>
		</div>
	</div>
	<div id="photo-list">
	</div>
</body>

</html>