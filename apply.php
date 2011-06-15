<?php require("config.php"); 

if(isset($_POST['title'])){
	
	if(
		empty($_POST['title']) ||
		empty($_POST['short']) ||
		empty($_POST['lat'])   ||
		empty($_POST['lng'])   ||
		empty($_POST['email'])
	){
		$result = "<span class='error'>Please fill in all the required fields</span>";
	}else{
	
		$_POST['showmap'] = ($_POST['showmap']=="on")?"1":"0";
		
		$query = "INSERT INTO occupation VALUES ('', '{$_POST['title']}', '{$_POST['short']}', '{$_POST['twitter']}', '{$_POST['blog']}', '{$_POST['lat']}', '{$_POST['lng']}', '{$_POST['showmap']}', '{$_POST['email']}', '0')";
		
		$mysqli = new mysqli($config['hostname'],$config['username'],$config['password'],$config['database']);
		if (!$result = $mysqli->query($query)) {
			$result = "<span class='error'>{$mysqli->error}</b>";
		}else{
			$result = "<span class='success'>Application submitted. Please check your emails for correspondance.</span>";
		}
		$mysqli->close();
		
		$message = "{$_POST['title']} has applied for an occupation profile.";
		$message = wordwrap($message, 70);
			mail($config['email'], 'OCCUPY.IT', $message);
		
	}
	
}

?><html>

	<head>
		<title>occupy.it; bringing together informations about political occupations around the UK</title>
		
		<base href="<?php echo $config['base']; ?>" />
		
		<link rel="stylesheet" href="boilerplate.css" />
		<link rel="stylesheet" href="style.css" />
		
		<script type="text/javascript" src="jquery-1.6.min.js"></script>
		<script type="text/javascript" src="jquery.color.min.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&region=GB"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				var geocoder = new google.maps.Geocoder();
				var $map = $('#select_map').hide();
				var marker;
				var map = new google.maps.Map($map[0], {
					zoom: 12,
					center: new google.maps.LatLng(54.597528,-3.032227),
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});
				google.maps.event.addListener(map, 'click', function(event) {
					placeMarker(event.latLng);
				});
				function placeMarker(location) {
					if(marker == undefined){
						marker = new google.maps.Marker({
							position: location, 
							map: map
						});
					}else{
						marker.setPosition(location);
					}
					map.panTo(location);
					$('input[name=lat]').val(location.lat());
					$('input[name=lng]').val(location.lng());
				}
				// event listener to update lng and lat on click
				function findAddress(address) {
					geocoder.geocode( { 'address': address+', UK' }, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							map.panTo(results[0].geometry.location);
							placeMarker(results[0].geometry.location);
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
				$('span.error, span.success').css({ backgroundColor: 'yellow' }).animate({ backgroundColor: 'transparent' }, 3000);
			});
		</script>
		
	</head>
	
	<body>
		
		<div id="content" class="centered">
		
			<h1>Apply for a profile</h1>

			<p>Until we work out a better way of doing it, we'll have to manually approve all applications. Fill in your information on the form below and we'll get in contact.</p>
			
			<?php if(isset($result)){ echo "<p>{$result}</p>"; } ?>
			
			<form action="apply/" method="POST">

				<fieldset>
				
					<legend>Private Information</legend>
					
					<label for="email">Email address *:</label>
					<input type="email" name="email" />
				
				</fieldset>

				<fieldset>
					
					<legend>Public Information</legend>
			
					<label for="title">Occupation title *:</label>
					<input type="text" name="title" />
					
					<label for="short">Shortname *:</label>
					<input type="text" name="short" />
					
					<label for="twitter">Twitter:</label>
					<input type="text" name="twitter" />	
					
					<label for="blog">Blog RSS:</label>
					<input type="text" name="blog" />	
					
					<label for="showmap">Show on map? *:</label>
					<input type="checkbox" name="showmap" checked />
				
				</fieldset>
				
				<fieldset>
					
					<legend>Location</legend>
				
					<p>Find your location and click it on the map (required):</p>
				
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
