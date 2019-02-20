<?php

//ob_start();
session_start();


// If User is logged => redirect to tavern.php and announce it

 if ( !isset($_SESSION['user']) ) {
  $_SESSION['logged'] = 1;
  header("Location: tavern.php");
  echo "<meta http-equiv='refresh' content='0; url=tavern.php'>";
  exit;
 }

require_once 'inc.php';


// ------------------------------


// Start of Page with some functions

html_head("Challenge User Assign");

navbar('bgimg_challenges');
pageFade();


$id = $_POST['challenge'];



if(($id != "") || ($id != 0)) {

$date_now = date("Y-m-d H:i:s");

$conn = connect_db();

$sql = "INSERT INTO userchallenges (id_challenge, id_user, date_started) VALUES (". $id .", ". $_SESSION['user'] .", '". $date_now ."')";
$res = mysqli_query($conn, $sql);

if ($res) {
	
	echo '
	<script>
	swal({
	title: "Successfully assigned!!",
	text: "Challenge has been assigned to you without any problem!",
	type: "success",
	showConfirmButton: false,
	timer: 1990
	});
	</script>';

	echo "<meta http-equiv='refresh' content='2; url=public-challenges.php'>";

   } else mysqli_error($conn);

} else {
	echo '
	<script>
	swal({
	title: "No challenge on route!!",
	text: "You will be redirected to the Public Challenges!",
	type: "warning",
	showConfirmButton: false,
	timer: 1990
	});
	</script>';

	echo "<meta http-equiv='refresh' content='2; url=public-challenges.php'>";
}

mysqli_close($conn);

?>

</body>
</html>