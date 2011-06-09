<?php require("config.php"); ?><html>

	<head>
		<title>occupy.it; bringing together informations about political occupations around the UK</title>
		
		<base href="<?php echo $config['base']; ?>" />
		
		<link rel="stylesheet" href="style.css" />
		
		<script type="text/javascript" src="jquery-1.6.min.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&region=GB"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				var geocoder = new google.maps.Geocoder();
				var $map = $('#select_map').hide();
				var map = new google.maps.Map($map[0], {
					zoom: 12,
					center: new google.maps.LatLng(54.597528,-3.032227),
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});
				function findAddress(address) {
					geocoder.geocode( { 'address': address}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							map.panTo(results[0].geometry.location);
							//var marker = new google.maps.Marker({ map: map, position: results[0].geometry.location });
						}else{
							alert("Geocode was not successful for the following reason: " + status);
						}
					});
				}
				$('#search').click(function(){
					$map.slideDown(function(){
						google.maps.event.trigger(map, "resize");
						findAddress($('#address').val());
					});
				});
			});
		</script>
		
	</head>
	
	<body>
		
		<div id="content" class="centered">
		
			<h1>Apply for a profile</h1>

			<p>Until we work out a better way of doing it, we'll have to manually approve all applications. Fill in your information on the form below and we'll get in contact.</p>
			
			<form>

				<fieldset>
				
					<legend>Private Information</legend>
					
					<label for="email">Email address:</label>
					<input type="email" name="email" />
				
				</fieldset>

				<fieldset>
					
					<legend>Public Information</legend>
			
					<label for="title">Occupation title:</label>
					<input type="text" name="title" />
					
					<label for="short">Shortname:</label>
					<input type="text" name="short" />
					
					<label for="twitter">Twitter:</label>
					<input type="text" name="twitter" />	
					
					<label for="blog">Blog RSS:</label>
					<input type="text" name="blog" />	
					
					<label for="showmap">Show on map?:</label>
					<input type="checkbox" name="showmap" checked />
				
				</fieldset>
				
				<fieldset>
					
					<legend>Location</legend>
				
					<p>Find your location and click it on the map:</p>
				
					<input type="text" class="unrelated" id="address" />
					<button type="button" class="unrelated" id="search">Search</button>
					<div id="select_map"></div>
					
					<input type="hidden" name="lat" />
					<input type="hidden" name="lng" />
				
				</fieldset>
				
				<fieldset>
					
					<legend>Finish</legend>
				
					<button type="submit" class="submit">Apply!</button>
					
				</fieldset>
			
			</form>
			
			<p><a href="./">Back to the homepage</a></p>

		</div>

	</body>

</html>
