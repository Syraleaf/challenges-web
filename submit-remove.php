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

html_head("Remove of Submitted Challenge");

navbar('bgimg_index_logged');
pageFade();
HelpButton();

$id = $_POST['challenge'];
$user = $_POST['user'];



if(($id != "") || ($id != 0)) {

$conn = connect_db();

$sql = "UPDATE userchallenges SET state=0, proof=' ', note=' '  WHERE id_challenge=". $id;
$res = mysqli_query($conn, $sql);

if ($res) {
	
	echo '
	<script>
	swal({
	title: "Successfully declined!!",
	text: "Challenge Submission has been removed without any problem!",
	type: "success",
	showConfirmButton: false,
	timer: 1990
	});
	</script>';

	$sql = "INSERT INTO notifications (id_user, id_challenge, decision) VALUES ('". $user ."', '". $id ."', 0)";
	$res_n = mysqli_query($conn, $sql);

	echo "<meta http-equiv='refresh' content='2; url=submissions.php'>";

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

	echo "<meta http-equiv='refresh' content='2; url=submissions.php'>";
}

mysqli_close($conn);

?>

</body>
</html>