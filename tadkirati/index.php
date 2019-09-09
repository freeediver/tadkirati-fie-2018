<?php
try {
    $bdd = new PDO('mysql:host=localhost;port=8889;dbname=tadkirati', 'root', 'root',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e){
    echo $e.getMessage();
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Tadkirati</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
<link href="css/calendar-eightysix-default.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/calendar-eightysix-osx-dashboard.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/calendar-eightysix-vista.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/mootools-1.2.4-core.js"></script>
<script type="text/javascript" src="js/mootools-1.2.4.2-more.js"></script>
<script type="text/javascript" src="js/calendar-eightysix-v1.0.1.js"></script>
<script type="text/javascript">
		window.addEvent('domready', function() {
			new CalendarEightysix('exampleI', 	 { 'offsetY': -4 });
			new CalendarEightysix('exampleII', 	 { 'startMonday': true, 'format': '%m.%d.%Y', 'slideTransition': Fx.Transitions.Back.easeOut, 'draggable': true, 'offsetY': -4 });
	});	
</script>

</head>
<body>
  <div class="header-top">
	<div class="wrap">
        <div class="logo">
			<a href="index.php"><img src="images/logo.png" alt=""/></a>
		</div>
		<div class="cssmenu">
		  <nav id="nav" role="navigation">
			<a href="#nav" title="Show navigation">Afficher</a>
			<a href="#" title="Hide navigation">Cacher</a>
			<ul class="clearfix">
				<li class="active"><a href="index.php">Accueil</a></li>
				<li><a href="#"><span>Commencer</span></a></li>
				<li><a href="#">Prix</a></li>
				<li><a href="#">Support</a></li>
				<div class="clear"></div>
			</ul>
		    </nav>
		  </div>
		  <div class="buttons">
				<div class="login_btn">
					<a href="../attendize/public/">Login</a>
				</div>
				<div class="get_btn">
					<a href="#">Être listé aujourd'hui</a>
				</div>
				<div class="clear"></div>
		   </div>
	     <div class="clear"></div>
		<h2 class="head">Trouvez le <span class="m_1">prochain événement </span>auquel vous voudrez  <span class="m_1">participer</span></h2>
     </div>
    </div>
     <div class="map">
     	<img src="images/map.jpg" alt=""/>
     </div>
     <div class="main">
     	<div class="wrap">
     	<?php
            $events = $bdd->query('SELECT e.id, e.title, e.description, e.start_date, i.image_path FROM events e LEFT JOIN event_images i ON e.id = i.event_id WHERE e.is_live = 1 ORDER BY start_date DESC');
        ?>
        <?php
        	$i = 0;
        	while ($event = $events->fetch()){
        		$i++;
        		if (($i-1) % 3 == 0){
        			echo "<div class='section group'>";
        		}
        ?>
     			<div class="col_1_of_3 span_1_of_3">
					<a href='../attendize/public/e/<?php echo $event["id"] . "/" . $event["title"]; ?>'><img src="../attendize/<?php echo $event['image_path']; ?>" alt="" style="width: 100%; height: 200px;"/></a>
					<ul class="m_fb">
						<li>
							<span class="m_22"><a href="#"><img src="images/fb.png" alt=""/></a></span><span class="middle"><?php echo $event['start_date']; ?></span>
						    <span class="m_23"><a href="#"><img src="images/heart.png" alt=""/></a></span>
						     <div class="clear"></div>
						</li>
					</ul>
					  <div class="desc" style="height: 150px;">
						<h3><a href='../attendize/public/e/<?php echo $event["id"] . "/" . $event["title"]; ?>'><?php echo $event['title']; ?></a></h3>
						<p><?php echo substr($event['description'], 0, 200); ?> ...</p>
					   </div>
				</div>
		<?php
				if ($i % 3 == 0){
					echo "<div class='clear'></div></div>";
				}
			}
		?>
				</div>
				<div class="clear"></div>
		</div>
     </div>
     <div class="footer">
     	<div class="wrap">
     	  <div class="footer-menu">
     		<ul>
				<li class="active"><a href="index.html">Home</a></li> 
				<li><a href="about.html">About eco</a></li> 
				<li><a href="work.html">How it works</a></li> 
				<li><a href="industries.html">Industries</a></li> 
				<li><a href="features.html">Features</a></li>
				<li><a href="pricing.html">Pricing</a></li>
				<li><a href="faq.html">Faq's</a></li>
				<li><a href="features.html">Privacy policy</a></li>
				<li><a href="blog.html">Blog</a></li>
				<li><a href="work.html">Terms of service</a></li>
				<div class="clear"></div>
			</ul>
     	  </div>
     	  <div class="footer-bottom">
     	  	<div class="copy">
			   <p>© 2018 <a href="http://w3layouts.com" target="_blank"> Tadkirati</a></p>
		    </div>
		    <div class="social">	
			   <ul>	
				  <li class="facebook"><a href="#"><span> </span></a></li>
				  <li class="twitter"><a href="#"><span> </span></a></li>
				  <li class="linked"><a href="#"><span> </span></a></li>	
				  <li class="arrow"><a href="#"><span> </span></a></li>	
				  <li class="dot"><a href="#"><span> </span></a></li>
				  <li class="rss"><a href="#"><span> </span></a></li>		
			   </ul>
		    </div>
		    <div class="clear"></div>
     	  </div>
       </div>
     </div>
</body>
</html>