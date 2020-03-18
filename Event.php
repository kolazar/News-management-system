<?php
define("id_event_frvr", $_POST['test'], true);
include("auth.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Event</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <style>
	.display {
	display:block;
  }
  .display-none{
	  display:none;
  }
#search1 {
  width: 150px;
  -webkit-transition: width 0.4s ease-in-out;
  transition: width 0.4s ease-in-out;
	}

/* When the input field gets focus, change its width to 100% */
#search1:focus {
  width: 70%;
	}
  </style>
  
</head>
<body>


<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
	<button onclick="location.href = 'Home.php';" class="button-modal" style="width:auto; color:white;"><font size="4"><b>Home</b></font></button>
	<button onclick="document.getElementById('id01').style.display='block'" class="button-modal" style="width:auto;">Add media</button>
	<button onclick="document.getElementById('id03').style.display='block'" class="button-modal" style="width:auto;">Statistic</button>
	<button onclick="location.href = 'Logout.php';" class="button-modal" style="width:auto;">Logout</button>  
	<input type="text" id="search1" name="search" placeholder="Search.." onkeyup="showHint(this.value)">
</nav>

<div  id="id02" class="modal">
	 	<div class="modal-dialog">
			<div class="modal-content"> 
				<div class="modal-header">
				<h4 class="modal-title">Notification</h4>
				</div>
					<div class="modal-body">
					New media was created successfully!
					</div>
					<div class="modal-footer">
				<button type="button" class="btn" onclick="closeModal()">Ok</button>
					</div>
			</div>
		</div>
	</div>
	<script>
function closeModal() {
  document.getElementById("id02").style.display = "none";
}
function showHint(str) {
	var id_event_frvr = document.getElementById("test").value;
  if (str.length == 0) { 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
		
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
	xmlhttp.open("GET", "allMedia.php?id_event_frvr="+id_event_frvr, true);
    xmlhttp.send();
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "getMedia.php?q=" + str+ "&id_event_frvr="+id_event_frvr, true);
    xmlhttp.send();
  }
}
</script>
	 <div id="txtHint" class="col-sm-10 col-lg-8 mx-auto ml-auto mr-auto ml-2 mt-2 text-center ">
	
<?php
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require('connection.php');


 $id_event_frvr=id_event_frvr;

if(isset($_POST['media-submit'])){ // Fetching variables of the form which travels in URL
	$title = $_POST['mHeader'];
	$descr = $_POST['mDescr'];
	$keywords = $_POST['mKeywords'];
	$link = $_POST['mLink'];
	$publisher = $_POST['mPublisher'];
	$type = $_POST['mType'];
	$text = $_POST['mText'];
	date_default_timezone_set('Europe/Ljubljana');
	$date = date('Y-m-d H:i:s', time());
		$name = $_FILES['fileToUpload']['name'];  
		$targetDir = "uploads/";
		$targetFilePath = $targetDir . $name;
		$temp_name  = $_FILES['fileToUpload']['tmp_name'];  
        $location = 'uploads/';      
        move_uploaded_file($temp_name, $location.$name);

	$sql = "INSERT INTO media ( title_media, date_media,descr_media,link_media,publisher_media,type_media,keywords_media,text_media,path_media,fk_event)
	VALUES ('$title','$date','$descr','$link','$publisher','$type','$keywords','$text','$targetFilePath','$id_event_frvr')";

if ($conn->query($sql) === TRUE) {
    echo '<script language="javascript">';
	echo 'document.getElementById("id02").style.display="block"';
	echo '</script>';
} else {
echo 'Error' . $sql . "<br>" . $conn->error;
}
}
			$sql = "SELECT distinct title_media,descr_media,date_media,keywords_media,link_media,publisher_media,type_media,text_media,path_media,fk_event FROM media WHERE fk_event=$id_event_frvr ORDER BY date_media DESC";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					
		$allowTypes = array('jpg','png','jpeg','gif','pdf');
		$allowTypes1 = array('mp4','webm','ogg');
		$allowTypes2 = array('mp3','wav','ogg');
		$fileType = pathinfo($row["path_media"],PATHINFO_EXTENSION);
		if(in_array($fileType, $allowTypes)){
					echo "<div class='jumbotron'>"."<h2>" . $row["title_media"]. "</h2> ".'<span id="myspan"  style="color: blue;text-decoration: underline;cursor: pointer;">Show more...</span>'
					.'<div id="myform" class="display-none">'. "<h5>Description:</h5><p>".$row["descr_media"]."</p>"."<h6>".$row["date_media"]."</h6>"."<p><b>Keywords:</b>"
					.$row["keywords_media"]."</p>"."<h5>Link:</h5>".'<a href="'.$row["link_media"].'"target="_blank">'.$row["link_media"].'</a>'."<h6> Publisher:".$row["publisher_media"]."</h6>"."<h6>Type:".$row["type_media"]."</h6>"."<p>".$row["text_media"]."</p>".'<img src="'.$row["path_media"].'" style="width:700px;height:500px;" alt="Broken file">'
					.'</div>'."<br>"
					."<br>"."</div>";
				}
				
		else if(in_array($fileType, $allowTypes1)){
					echo "<div class='jumbotron'>"."<h2>" . $row["title_media"]. "</h2> ".'<span id="myspan"  style="color: blue;text-decoration: underline;cursor: pointer;">Show more...</span>'
					.'<div id="myform" class="display-none">'. "<h5>Description:</h5><p>".$row["descr_media"]."</p>"."<h6>".$row["date_media"]."</h6>"."<p><b>Keywords:</b>"
					.$row["keywords_media"]."</p>"."<h5>Link:</h5>".'<a href="'.$row["link_media"].'"target="_blank">'.$row["link_media"].'</a>'."<h6>Publisher:".$row["publisher_media"]."</h6>"."<h6>Type:".$row["type_media"]."</h6>"."<p>".$row["text_media"]."</p>".'<video width="700px" height="400px" controls> <source src="'.$row["path_media"].'" >'.'Your browser does not support the video tag.
</video>'
					.'</div>'."<br>"
					."<br>"."</div>";
				}
					
		else if(in_array($fileType, $allowTypes2)){
					echo "<div class='jumbotron'>"."<h2>" . $row["title_media"]. "</h2> ".'<span id="myspan"  style="color: blue;text-decoration: underline;cursor: pointer;">Show more...</span>'
					.'<div id="myform" class="display-none">'. "<h5>Description:</h5><p>".$row["descr_media"]."</p>"."<h6>".$row["date_media"]."</h6>"."<p><b>Keywords:</b>"
					.$row["keywords_media"]."</p>"."<h5>Link:</h5>".'<a href="'.$row["link_media"].'"target="_blank">'.$row["link_media"].'</a>'."<h6>Publisher:".$row["publisher_media"]."</h6>"."<h6>Type:".$row["type_media"]."</h6>"."<p>".$row["text_media"]."</p>".'<audio controls> <source src="'.$row["path_media"].'" >'.'Your browser does not support the audio element.
</audio>'
					.'</div>'."<br>"
					."<br>"."</div>";
				}
				
				else {

					echo "<div class='jumbotron'>"."<h2>" . $row["title_media"]. "</h2> ".'<span id="myspan"  style="color: blue;text-decoration: underline;cursor: pointer;">Show more...</span>'
					.'<div id="myform" class="display-none">'. "<h5>Description:</h5><p>".$row["descr_media"]."</p>"."<h6>".$row["date_media"]."</h6>"."<p><b>Keywords:</b>"
					.$row["keywords_media"]."</p>"."<h5>Link:</h5>".'<a href="'.$row["link_media"].'"target="_blank">'.$row["link_media"].'</a>'
					."<h6>Publisher:".$row["publisher_media"]."</h6>"."<h6>Type:".$row["type_media"]."</h6>"."<p>".$row["text_media"]."</p>".'</div>'."<br>"
					."<br>"."</div>";
					
				}	
		}} 
else{ // if there is no matching rows do following
            echo "<h3>No results</h3>";
			}
			$conn->close();

?>
</div>

<script>

  $(document).on('click','span',(function() {
  $(this).next('#myform').each(function(){
	  $(this).toggleClass(" display-none display");
  });
  }));

</script>

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="Event.php" method="post" enctype="multipart/form-data">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <label for="mHeader"><b>Media header</b></label>
      <input type="text" placeholder="Enter header" name="mHeader" required>
	
		<div class="form-group">
			<label for="mDescr">Description:</label>
			<textarea class="form-control" rows="3" id="mDescr" name="mDescr"></textarea>
		</div>
		<div class="form-group">
			<label for="mKeywords">Keywords:</label>
			<textarea class="form-control" rows="3" id="mKeywords" name="mKeywords"></textarea>
		</div>
		<label for="mLink">Link:</label>
		<input type="text" name="mLink" >
		<label for="mPublisher">Publisher:</label>
		<input type="text" name="mPublisher" >
		<div class="form-group">
			  <label for="mType">Select type:</label>
			  <select class="form-control" id="mType" name="mType">
				<option>Text</option>
				<option>Image</option>
				<option>Video</option>
				<option>Audio</option>
			  </select>
		</div>
		<div class="form-group">
			<label for="mText">Text:</label>
			<textarea class="form-control" rows="5" id="mText" name="mText"></textarea>
		</div>
		<label for="fileToUpload">File to Upload:</label>
		<input type="file" name="fileToUpload" id="fileToUpload">
        <input type="hidden" name="test"  value="<?php echo(int) $_POST['test'];?>"></input>
		<button type="submit" name="media-submit">Add</button>

    </div>
  </form>

	
</div>

<div id="id03" class="modal">
<div class="modal-content animate">
<div class="imgcontainer">
      <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>
	
 <div class="modal-header">
 <h4 class="modal-title">Statistic</h4>
      </div>
	  <div class="modal-body">
   
	<p ><i><b>Publishers:</b></i></p>
	<?php
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require('connection.php');


 $id_event_frvr=id_event_frvr;


			$sql = "SELECT distinct publisher_media FROM media WHERE fk_event=$id_event_frvr ";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				
				while($row = $result->fetch_assoc()) {
					
					echo "<p>" . $row["publisher_media"]. "</p> ";
					
			}
			
			} 
			
else{ // if there is no matching rows do following
            echo "<h6>No publishers</h6>";
			}
			$conn->close();

?>
		<p ><i><b>The best publisher:</b></i></p>
		<?php
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require('connection.php');


 $id_event_frvr=id_event_frvr;

			$sql = "SELECT publisher_media
FROM media where fk_event=$id_event_frvr GROUP BY publisher_media 
HAVING COUNT(publisher_media)=( SELECT MAX(mycount) 
FROM (SELECT publisher_media,COUNT(publisher_media) AS mycount 
FROM media where fk_event=$id_event_frvr GROUP BY publisher_media) as whatever) ";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				
				while($row = $result->fetch_assoc()) {
					
					echo "<p>" . $row["publisher_media"]. "</p> ";
					
			}
			
			} 
			
else{ // if there is no matching rows do following
            echo "<h6>No publishers</h6>";
			}
			$conn->close();

?>
		<p ><i><b>Average length of post:</b></i></p>
		<?php
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require('connection.php');


 $id_event_frvr=id_event_frvr;

			$sql = "SELECT AVG(LENGTH(text_media)) AS TEXTFieldSize from media where fk_event=$id_event_frvr ";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				
				while($row = $result->fetch_assoc()) {
					
					echo "<p>" . $row["TEXTFieldSize"]. "</p> ";
					if (is_null($row["TEXTFieldSize"])){
						echo "<h6>No media reports yet</h6>";	
					}			
				}
			} 
			$conn->close();

?>
	<p ><i><b>The longest article:</b></i></p>
	<?php
  
require('connection.php');


 $id_event_frvr=id_event_frvr;

			$sql = "select m1.title_media,
					MAX(LENGTH(m1.text_media)) as TEXTFieldSize
					from media m1
					where LENGTH(m1.text_media) = (
					select MAX(LENGTH(m2.text_media)) 
					from media m2
					where m1.fk_event=m2.fk_event
					) AND m1.fk_event= $id_event_frvr
					GROUP BY m1.title_media";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				 
				while($row = $result->fetch_assoc()) {
					
					echo "<p>" . $row["title_media"]. "</p> ";
					if (is_null($row["TEXTFieldSize"])){
						echo "<h6>No media reports yet</h6>";	
					}			
				}
			} 
			$conn->close();

?>
<p ><i><b>The shortest article:</b></i></p>
	<?php
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require('connection.php');


 $id_event_frvr=id_event_frvr;

			$sql = "select m1.title_media,
					MIN(LENGTH(m1.text_media)) as TEXTFieldSize
					from media m1
					where LENGTH(m1.text_media) = (
					select MIN(LENGTH(m2.text_media)) 
					from media m2
					where m1.fk_event=m2.fk_event
					) AND m1.fk_event= $id_event_frvr
					GROUP BY m1.title_media";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				
				while($row = $result->fetch_assoc()) {
					
					echo "<p>" . $row["title_media"]. "</p> ";
					if (is_null($row["TEXTFieldSize"])){
						echo "<h6>No media reports yet</h6>";	
					}			
				}
			} 
			$conn->close();

?>
		</div>
		
		
	  </div>
	  </div>
    	
	<script>
function closeModal1() {
  document.getElementById("id03").style.display = "none";
}
</script>
<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


<div class="jumbotron text-center" style="margin-bottom:0">
<?php
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require('connection.php');
$sql = "SELECT distinct fk_event FROM media WHERE fk_event=$id_event_frvr ";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo '<input id="test" type="hidden" name="test" value="'.$row["fk_event"].'"></input>';
				}
			}
			?>
  <p>(c)Mykola's Lazarenko news site</p>
</div>

</body>
</html>