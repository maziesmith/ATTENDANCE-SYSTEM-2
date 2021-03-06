
<?php
session_start();
if (!isset($_SESSION['first_name']) && !isset($_SESSION['last_name']) && !isset($_SESSION['username']) 
&& !isset($_SESSION['password'])){
header("Location:error.php");
}

if ($_SESSION['role'] != 'teacher'){
	header("Location:error.php");
}
?>

<!doctype html>
<head>
	<title> Teacher Dashboard </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/uploaded_img.css">
	<style type="text/css">
		body{
			background-color: white;
			color: white;
			font-family: 'Raleway', sans-serif;
			font-size: 18px;
			background: url('images/15_LabKindergartenWEB_bys-1.jpg');
			background-size:cover;
		}
		#nav{
	width: 1200px;
	height: 200px;
	margin-left: 150px;
	margin-right: 60px;

	background-size:cover;
}

#nav_wrapper{
	width: 700px;
	height: 100px ;
	background-color: indigo;
	margin-left: auto;
	margin-right: auto;
	margin-top: 50px;
	
}
#nav_wrapper ul li{
	list-style: none;
	display: inline;
	padding: 10px;
	font-weight: bold;
}
#nav_wrapper a{
	color: white;
	text-decoration: none;
	margin-top: 20px;
	padding: 10px;
}
#nav_wrapper a:hover{
	color: red;
	transition: 0.4s;
}
#update{
float: left;
height: 30px;
}
	</style>
</head>

<body>
	<?php
require_once "connect.php";
//require_once "../validate_login.php";

$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
	?>

	<p> <center>Hey <?php echo "$first_name" ." ". "$last_name"?>, welcome!!<br><br>
		 This is your dashboard. Pls avail yourself as
		you please. </center></p>
		<br>
		<button id="logout" class="red button" style="float: right"> Log Out </button>

		<?php 
$pic = "SELECT file_path FROM users where username = '$username'";
$pic_query = mysqli_query($link, $pic);

if (mysqli_num_rows($pic_query) > 0){
	foreach($pic_query as $row) {
  $picture = $row['file_path'];
  //echo "<script document.getElementById('pic').innerText = $picture>";
  echo "<img src='$picture' alt='no pic' class='new_img' style='
    height: 200px;
	width: 200px;
	border-radius:65px;
	border-style: groove;
	border-width: medium;
	border-color: gray;
	clear: both;
	float: left;'>";
}
}
else {
	echo "No Pic";
}
?>
<button id="picChange" class="green button"> Update profile picture</button>

		<!--You have changed your background image to <?echo "$_COOKIE['image']";?>--></center></p>
<p> <center> Dashboard for Lecturers</center></p>

<div  id="nav">
	<div id="nav_wrapper">
	<ul>
		<li><button id="prompt">Update your profile</button></li>
		<li><a href="courses/courses.php"> Upload Lecture Notes </a></li>
		<li><a href=""> Upload Student Results</a></li>
</ul>
	</ol>
</div>
</div>


<form id="picForm" style="display: none;" action="" method="POST" enctype="multipart/form-data">
		<input type="file" id="actual_img" name="userFile">
		<!--<input type="text" id="text" name="text">-->
		<input type="submit" id="picture" value="Upload File">
	</form> 

<form id="update" style="display: none" action="update_details.php" method="POST">
	<!--<?php $first = "SELECT first_name from users where first_name = '$first_name'"?>-->

	First Name:<input type="text" name="first_name" id="fname" value="<?php echo $first_name ?>"><br/>
	 Last Name:<input type="text" name="last_name" id="lname" value="<?php echo $last_name ?>"><br>
	Username:<input type="text" name="username" id="usr" value="<?php echo $username ?>"> <br>
	Password:<input type="password" name="pwd" id="pwd" value="<?php echo $password ?>"><br>
	 <button type="submit" id="submit">Update Details</button> <br>
</form><br>

<button id="close" style="display: none"> close this window</button>
<p id="ajax"></p>


<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="js/teacher.js"></script>


</body>
<?php
if (isset($_FILES['userFile'])){
  $file_name = $_FILES['userFile']['name'];
  $file_type = $_FILES['userFile']['type'];
  $file_size = $_FILES['userFile']['size'];
  


  //echo $file_name." " . $file_type;

  $allowedFormats = array('image/jpg', 'image/png', 'image/gif');

  //if(!in_array($file_type, $allowedFormats)){ // || ( ||  'image/png')$file_type !='image/gif')){
  //echo "<script console.log('Pls use a valid image file!!')>";
  //	echo "Pls use a valid image file!!";
  //}

if($file_size > 500000){
echo "<script>"."alert('File size exceeds maximum. Acceptable size is 500kb or less')"."</script>";
  // Max File Size: 500KB
}

	if (file_exists("images/"."uploads/".$_FILES['userFile']['name'])){
  	$duplicate = $_FILES['userFile']['name'];
  	echo "<script>"."alert('This picture already exists!!')"."</script>";
  }

  else{
  	//if(in_array($file_type, $allowedFormats)){
	move_uploaded_file($_FILES['userFile']['tmp_name'], "images/"."uploads/".$_FILES['userFile']['name']);

if ($_FILES['userFile']['error'] = 'UPLOAD_ERR_OK'){
		$img = "images/"."uploads/".$_FILES['userFile']['name'];
		$query = "UPDATE users
		SET file_path = '$img'
		WHERE username = '$username'";

		$success = mysqli_query($link, $query);
        
        if ($success){
        	echo "<script> alert('Picture changed successfully, kindly refresh')</script>";
	      // echo "<img class='new_img' src=$img>";
        }
      else {
      	echo "<script alert('Upload failed!!')>";
      }
	//echo "<script> alert('Picture changed successfully')</script>";
	//echo "<img class='new_img' src=$img>"; 
	}
	
	else if ($_FILES['userFile']['error'] = 'UPLOAD_ERR_NO_FILE'){
		echo "<span style='color:red'>Error uploading file!!</span>";
	}

}
	

}

	


/**else{
	echo "<script> alert('File format not supported!!')"."</script>";
}
**/
?>

</html>