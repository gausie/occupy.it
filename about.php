<?php require("config.php"); ?><html>

	<head>
		<title>occupy.it; bringing together informations about political occupations around the UK</title>
		
		<base href="<?php echo $config['base']; ?>" />
		
		<link rel="stylesheet" href="boilerplate.css" />
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
		
		<div id="content">
		
			<h1 class="centered">What is occupy<span>it</span>?</h1>

			<p>This is a (very much work-in-progress) aggregator for political occupations in the UK. I made it to grease the wheels of solidarity and (eventually) make it easy for someone to start an online presence for their ongoing political action without technical know-how or money.</p>
			
			<p>In the future I hope to:</p>
			
			<ul>
				<li>Provide shorturls for blogposts and tweets</li>
				<ul>
					<li>Generated automatically for every blogpost, or on demand if the user clicks "Copy shortlink" or something.</li>
				</ul>
				<li>Offer a wordpress package for every occupation (maybe on http://blog.occupy.it/ouroccupation, or something)</li>
				<li>Host information on how to occupy and other knowledge-sharing.</li>
				<li>Login for occupations to say they if they are in occupation or not and issue a call to arms when they need help</li>
				<ul>
					<li>Maybe allow control through hashtags</li>
				</ul>
				<li>Anything else anyone can think of.</li>
			</ul>
			
			<p>If you're interested in how the site works, I keep the code on Github. That means its "open source" and free (as in beer and as in speech) for you to peruse, use and abuse etc. <a href="https://github.com/gausie/occupy.it" class="gitforked-button gitforked-forks gitforked-watchers">Fork</a></p>
			
			<p>If you're interested in me, I was a student occupying UCL in winter 2010 and am one of the guys behind the <a href="http://snarlpowered.org">Snarl project</a> (famous for powering <a href="http://sukey.org" target="_blank">Sukey</a>).</p>
			
			<p><a href="./">Back to the homepage</a></p>

		</div>
		
		<script src="http://gitforked.com/api/1.1/button.js" type="text/javascript"></script>

	</body>

</html>
