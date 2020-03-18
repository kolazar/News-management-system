<?php


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
			require('connection.php');
			$sql = "SELECT id_event,title_event,descr_event,date_event,keywords_event FROM events WHERE (FIND_IN_SET(?, keywords_event))  ORDER BY date_event DESC  ";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($eid, $title, $descr, $date, $key);



					if ($stmt->num_rows > 0) {	
					while($stmt->fetch()){
		echo "<div class='jumbotron '>"."<h2>" . $title. "</h2> ".'<span id="myspan"  style="color: blue;text-decoration: underline;cursor: pointer;">Show more...</span>'
					.'<div id="myform" class="display-none">'. "<h5>".$descr."</h5>"."<h6>".$date."</h6>"."<p>"
					.$key."</p>".'</div>'					
					.'<form action="Event.php" method="post">'
					.'<input type="hidden"  name="test" value="'.$eid.'"></input>'
					.'<button  "class="button-modal" name = "go_to_event" style="width:auto;background:#785964;color:white;">Go to event</button>'.'</form>'					
					."<br>"."</div>";
					}
					}
					else{ // if there is no matching rows do following
            echo "<h3>No results</h3>";
			}
					$stmt->close();
					
?>		


