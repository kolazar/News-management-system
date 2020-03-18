<?php

include("auth.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>News site</title>
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


<div class="jumbotron jumbotron-fluid text-center" style="margin-bottom:0;background:#82A7A6;">
  <h1>News</h1>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
	<button onclick="location.href = 'Home.php';" class="button-modal" style="width:auto; color:white;"><font size="4"><b>Home</b></font></button>
	<button onclick="document.getElementById('id01').style.display='block'" class="button-modal" style="width:auto;">Add event</button>
	<button onclick="location.href = 'Logout.php';" class="button-modal" style="width:auto;">Logout</button>  
	<input type="text" id="search1" name="search" placeholder="Search.." onkeyup="showHint(this.value)">
	<label class="ml-auto mr-4 " style ="color:#D3D3D3;"> <i>Hello </i> <?php $username = $_SESSION['username'];echo "<b>".$username."</b>";?></label>
</nav>


<div  id="id02" class="modal">
	 	<div class="modal-dialog">
			<div class="modal-content"> 
				<div class="modal-header">
				<h4 class="modal-title">Notification</h4>
				</div>
					<div class="modal-body">
					New event was created successfully!
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
</script>
	
<?php

require('connection.php');

if(isset($_POST['submit'])){ // Fetching variables of the form which travels in URL
$title = $_POST['eHeader'];
$descr = $_POST['eDescr'];
$keywords = $_POST['eKeywords'];
date_default_timezone_set('Europe/Ljubljana');
$date = date('Y-m-d H:i:s', time());
$sql = "INSERT INTO events ( title_event, date_event,descr_event,keywords_event)
VALUES ('$title','$date','$descr','$keywords')";
if ($conn->query($sql) === TRUE) {
    echo '<script language="javascript">';
echo 'document.getElementById("id02").style.display="block"';
echo '</script>';
} else {
echo 'Error' . $sql . "<br>" . $conn->error;
}
$conn->close();
}
?>


<div id="id01" class="modal">
  
  <form class="modal-content animate" action="Home.php" method="post">
    
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    

    <div class="container">
      <label for="eHeader"><b>Event header</b></label>
      <input type="text" placeholder="Enter header" name="eHeader" required>

      <div class="form-group">
	<label for="eDescr">Description:</label>
	<textarea class="form-control" rows="3" id="eDescr" name="eDescr"></textarea>
	</div>
	<div class="form-group">
	<label for="eKeywords">Keywords:</label>
	<textarea class="form-control" rows="2" id="eKeywords" name="eKeywords"></textarea>
	</div>
        
    <input class="button-modal" name="submit" type="submit" value="Add">

    </div>
  </form>
</div>

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

<script>
function showHint(str) {
  if (str.length == 0) { 
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "allEvents.php", true);
    xmlhttp.send();
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "getEvent.php?q=" + str, true);
    xmlhttp.send();
  }
}
</script>

    <div id="txtHint" class="col-sm-10 col-lg-8 mx-auto ml-auto mr-auto ml-2 mt-2 text-center ">
	
		<?php
			require('connection.php');

			$sql = "SELECT id_event,title_event,descr_event,date_event,keywords_event FROM events ORDER BY date_event DESC";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo "<div class='jumbotron '>"."<h2>" . $row["title_event"]. "</h2> ".'<span id="myspan"  style="color: blue;text-decoration: underline;cursor: pointer;">Show more...</span>'
					.'<div id="myform" class="display-none">'. "<h5>".$row["descr_event"]."</h5>"."<h6>".$row["date_event"]."</h6>"."<p>"
					.$row["keywords_event"]."</p>".'</div>'
					
					.'<form action="Event.php" method="post">'
					.'<input type="hidden"  name="test" value="'.$row["id_event"].'"></input>'
					.'<button  "class="button-modal" name = "go_to_event" style="width:auto;background:#785964;color:white;">Go to event</button>'.'</form>'					
					."<br>"."</div>";
				}
			} 
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

<div class="jumbotron text-center" style="margin-bottom:0">
  <p>(c)Mykola's Lazarenko news site</p>
</div>

</body>
</html>
