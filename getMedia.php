<?php
$q = $_REQUEST["id_event_frvr"];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
			require('connection.php');
			$sql = "SELECT * FROM media WHERE (FIND_IN_SET(?, keywords_media)) AND fk_event=$q  ORDER BY date_media DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($mid,$title, $descr, $date, $key,$link,$publisher,$type,$text,$path,$fk_event);



					if ($stmt->num_rows > 0) {	
					while($stmt->fetch()){
		$allowTypes = array('jpg','png','jpeg','gif','pdf');
		$allowTypes1 = array('mp4','webm','ogg');
		$allowTypes2 = array('mp3','wav','ogg');
		$fileType = pathinfo($path,PATHINFO_EXTENSION);
		if(in_array($fileType, $allowTypes)){
					echo "<div class='jumbotron'>"."<h2>" . $title. "</h2> ".
					'<span id="myspan"  style="color: blue;text-decoration: underline;cursor: pointer;">Show more...</span>'
					.'<div id="myform" class="display-none">'
					. "<h5>Description:</h5><p>".$descr."</p>"."<h6>".$date."</h6>"."<p><b>Keywords:</b>"
					.$key."</p>"."<h5>Link:</h5>".'<a href="'.$link.'"target="_blank">'.$link.'</a>'."<h6> Publisher:"
					.$publisher."</h6>"."<h6>Type:".$type."</h6>"."<p>".$text."</p>".'<img src="'
					.$path.'" style="width:700px;height:500px;" alt="Broken file">'.'</div>'
					."<br>"
					."<br>"."</div>";
				}
				
		else if(in_array($fileType, $allowTypes1)){
					echo "<div class='jumbotron'>"."<h2>" . $title. "</h2> ".'<span id="myspan"  style="color: blue;text-decoration: underline;cursor: pointer;">Show more...</span>'
					.'<div id="myform" class="display-none">'. "<h5>Description:</h5><p>".$descr."</p>"."<h6>".$date."</h6>"."<p><b>Keywords:</b>"
					.$key."</p>"."<h5>Link:</h5>".'<a href="'.$link.'"target="_blank">'.$link.'</a>'."<h6>Publisher:".$publisher."</h6>"."<h6>Type:".$type."</h6>"."<p>".$text."</p>".'<video width="700px" height="400px" controls> <source src="'.$path.'" >'.'Your browser does not support the video tag.
</video>'
					.'</div>'."<br>"
					."<br>"."</div>";
				}
					
		else if(in_array($fileType, $allowTypes2)){
					echo "<div class='jumbotron'>"."<h2>" . $title. "</h2> ".'<span id="myspan"  style="color: blue;text-decoration: underline;cursor: pointer;">Show more...</span>'
					.'<div id="myform" class="display-none">'. "<h5>Description:</h5><p>".$descr."</p>"."<h6>".$date."</h6>"."<p><b>Keywords:</b>"
					.$key."</p>"."<h5>Link:</h5>".'<a href="'.$link.'"target="_blank">'.$link.'</a>'."<h6>Publisher:".$publisher."</h6>"."<h6>Type:".$type."</h6>"."<p>".$text."</p>".'<audio controls> <source src="'.$path.'" >'.'Your browser does not support the audio element.
</audio>'
					.'</div>'."<br>"
					."<br>"."</div>";
				}
				
				else {

					echo "<div class='jumbotron'>"."<h2>" . $title. "</h2> ".'<span id="myspan"  style="color: blue;text-decoration: underline;cursor: pointer;">Show more...</span>'
					.'<div id="myform" class="display-none">'. "<h5>Description:</h5><p>".$descr."</p>"."<h6>".$date."</h6>"."<p><b>Keywords:</b>"
					.$key."</p>"."<h5>Link:</h5>".'<a href="'.$link.'"target="_blank">'.$link.'</a>'
					."<h6>Publisher:".$publisher."</h6>"."<h6>Type:".$type."</h6>"."<p>".$text."</p>".'</div>'."<br>"
					."<br>"."</div>";
					
					}}}	
					else{ // if there is no matching rows do following
            echo "<h3>No results</h3>";
			}
					$stmt->close();
					
?>		


