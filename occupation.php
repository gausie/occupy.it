<?php

require("config.php");

$mysqli = new mysqli($config['hostname'],$config['username'],$config['password'],$config['database']);
//This is where we will query the database and pull using the cities/states SELECT statement
// If the result returns true
if ($result = $mysqli->query("SELECT * FROM occupation WHERE short='{$_GET['short']}' AND verified='1'")) {
	if($result->num_rows>0){
		$occ = $result->fetch_object();
		$title = $occ->title;
		$twitter = $occ->twitter;
		$blog = $occ->blog;
		$lat = $occ->lat;
		$lng = $occ->lng;
	}else{
		//handle occupation not found;
	}
} else {
	echo $mysqli->error;
}
$mysqli->close();

?><html>

	<head>
	
		<title><?php echo $title; ?> | occupy.it</title>
		
		<base href="<?php echo $config['base']; ?>" />
		
		<link rel="stylesheet" href="style.css" />
		
		<script type="text/javascript" src="jquery-1.6.min.js"></script>
		<script type="text/javascript" src="jquery.livetwitter.min.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		
		<script type="text/javascript">
			
			(function ($) {
				$.fn.loadRSS = function (url) {
					var $domNode = this;
					$domNode.empty().append("<div class='loading'><span>Loading...</span></div>");
					$.get("xs.php?u="+url, function(data){
						//Fairly messily done - attempts to guess RSS schema. Suggestions?
						$domNode.empty();
						var post_tag = ["item", "entry"]; var i = 0;
						while( (i<post_tag.length)){
							$articles = $(data).find(post_tag[i]);
							if($articles.size()>0){
								break;
							}
							i++;
						}
						$articles.each(function(){
							$article = $(this);
							var $content = $article.children("description");
							if($content.size()==0){
								$content = $article.children("content");
							}
							var $href = $article.children("link");
							var href = ($href.text()=='')?$href.attr('href'):$href.text();
							$domNode.append("<article><h2><a href='"+href+"'>"+$article.children('title').text()+"</a></h2>"+$content.text()+"</article>");
						});
					});
				}
			})(jQuery);

			$(document).ready(function(){
				$('#tweets').append("<div class='loading'><span>Loading...</span></div>").liveTwitter('<?php echo $twitter; ?>', {mode: 'user_timeline'});
				$('#blog').loadRSS('<?php echo $blog; ?>');
				var centre = new google.maps.LatLng(<?php echo $lat . ", " . $lng; ?>);
				var map = new google.maps.Map(document.getElementById("occupation_map"), {
					zoom: 15,
					mapTypeControl: false,
					streetViewControl: false,
					overviewMapControl: false,
					center: centre,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});
				var marker = new google.maps.Marker({
					position: centre, 
					map: map, 
					title: "<?php echo $title; ?>"
				});   
				google.maps.event.addListener(marker, 'click', function() {
					location.href = 'http://maps.google.co.uk/?q='+marker.getTitle()+'@'+centre.toUrlValue();
				});
			});
			
		</script>
	
	</head>
	
	<body>
	
		<aside>
			<h2>Twitter</h2>
			<div id="tweets"></div>
		</aside>
	
		<div id="content" class="with_aside">
	
			<header>
				<h1><?php echo $title; ?> <span>occupied</span></h1>
				<div id="occupation_map"></div>
				<div id="info"></div>
			</header>

			<section id="blog"></section>
			
		</div>
	
	</body>

</html>
