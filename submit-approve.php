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

html_head("Approval Submit of Challenge");

navbar('bgimg_index_logged');
pageFade();
HelpButton();



$id = $_POST['challenge'];
$user = $_POST['user'];

if(($id != "") || ($id != 0)) {

$conn = connect_db();

$sql = "SELECT * FROM challenges WHERE id_challenge=". $id;
$res = mysqli_query($conn, $sql);
$challengeRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

mysqli_close($conn);


$date_end = date_create(date('Y-m-d H:i:s', strtotime($challengeRow['date_end'])));
$date_start = date_create(date('Y-m-d H:i:s', strtotime($challengeRow['date_set'])));
$date_now = date_create(date('Y-m-d H:i:s', strtotime("now")));


if(($date_end < $date_now) || ($date_start > $date_now)) die();








$conn = connect_db();

$sql = "SELECT * FROM profiles WHERE id_user=". $user;
$res = mysqli_query($conn, $sql);
$profileRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

mysqli_close($conn);

$exp = $challengeRow['r_exp'] + $profileRow['exp'];
$money = $challengeRow['r_money'] + $profileRow['money'];
$now = date("Y-m-d");

$conn = connect_db();

$sql = "UPDATE userchallenges SET state=2, date_completed='". $now ."' WHERE id_challenge=". $id;
$res_uch = mysqli_query($conn, $sql);

$sql = "UPDATE profiles SET exp=". $exp .", money=". $money ." WHERE id_user=". $user;
$res_p = mysqli_query($conn, $sql);

if ($res_uch && $res_p) {
	
	echo '
	<script>
	swal({
	title: "Successfully approved!!",
	text: "Challenge Submission has been approved without any problem!",
	type: "success",
	showConfirmButton: false,
	timer: 1990
	});
	</script>';

	$sql = "INSERT INTO notifications (id_user, id_challenge, decision) VALUES ('". $user ."', '". $id ."', 1)";
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










echo "</body>
	  </html>";

?>