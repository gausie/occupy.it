<html>

	<head>
		<title>occupy.it; bringing together information about political occupations around the UK</title>
		
		<link rel="stylesheet" href="boilerplate.css" />
		<link rel="stylesheet" href="style.css" />
		
		<script type="text/javascript" src="jquery-1.6.min.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				var map = new google.maps.Map(document.getElementById("overall_map"), {
					//zoom: 15,
					//center: new google.maps.LatLng(51.508056, -0.128056),
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});
				var markers = [];
				var balloons = [];
				var last_balloon;
				var bounds = new google.maps.LatLngBounds();
				
<?php
				require("config.php");
				$mysqli = new mysqli($config['hostname'],$config['username'],$config['password'],$config['database']);
				if (!$result = $mysqli->query("SELECT id, title, short, lat, lng FROM occupation WHERE showmap='1' AND verified='1'")) {
					echo $mysqli->error;
				}

				while($row = $result->fetch_object()){
					echo "\t\t\t\tmarkers[{$row->id}] = new google.maps.Marker({\n";
					echo "\t\t\t\t\tposition: new google.maps.LatLng({$row->lat},{$row->lng}),\n";
					echo "\t\t\t\t\tmap: map,\n";
					echo "\t\t\t\t\ttitle: '{$row->title}'\n";
					echo "\t\t\t\t});\n";
					echo "\t\t\t\tballoons[{$row->id}] = new google.maps.InfoWindow({\n";
					echo "\t\t\t\t\tcontent: \"{$row->title}<br /><br /><a href='./{$row->short}/'>[profile]</a>\"\n";
					echo "\t\t\t\t});\n";
					echo "\t\t\t\tgoogle.maps.event.addListener(markers[{$row->id}], 'click', function() {\n";
					echo "\t\t\t\t\tif(last_balloon !== undefined) { last_balloon.close(); }\n";
					echo "\t\t\t\t\tballoons[{$row->id}].open(map,markers[{$row->id}]);\n";
					echo "\t\t\t\t\tlast_balloon = balloons[{$row->id}];\n";
					echo "\t\t\t\t});\n";
					echo "\t\t\t\tbounds.extend(markers[{$row->id}].getPosition());\n";
					echo "\n";
				}

				$mysqli->close();
				
?>
				map.fitBounds(bounds);
			});
		</script>
		
	</head>
	
	<body>
		
		<div id="content" class="centered">
		
			<h1>occupy<span>it</span> (&#914;)</h1>

			<p>Click on an occupation to see its profile.</p>
			
			<div id="overall_map"></div>
			
			<p>Gone into occupation? <a href="./apply/">Get a profile</a>.</p>
			
			<p><a href="./about/">What is <b>occupy</b>it?</a></p>
<?php if(!empty($config['twitter'])){ 
	echo "\t\t\t<p>Report bugs to <a href=\"http://twitter.com/{$config['twitter']}\">@{$config['twitter']}</a>.</p>";
} ?>

		</div>

	</body>

</html>
