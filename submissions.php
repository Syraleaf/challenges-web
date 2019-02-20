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

 $conn = connect_db();
 $sql = "SELECT * FROM `users` WHERE id_user=".$_SESSION['user'];
 $res = mysqli_query($conn, $sql);
 $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
 mysqli_close($conn);

 if($userRow['permission'] != 1) {
  header("Location: tavern.php");
  echo "<meta http-equiv='refresh' content='0; url=tavern.php'>";
  exit;
 }


// ------------------------------


// Start of Page with some functions

html_head("Submissions");

navbar('bgimg_index_logged');
pageFade();
HelpButton();


$conn = connect_db();
$sql = "SELECT * FROM `userchallenges` WHERE state=1";
$result_ch = mysqli_query($conn, $sql);
mysqli_close($conn);


?>

<script>
function SubmitChallenge(x, y, proof)
{
swal({
  title: 'Challenge has been submitted!!',
  type: 'question',
  showConfirmButton: false,
  allowOutsideClick: true,
  showCloseButton: true,
  html: '<p style="margin-bottom: 10%; font-size: 1vw;">Proof:<br /><a class="w3-text-indigo" style="text-decoration: none;" href="' + proof + '" target="_blank">' + proof + '</a></p>' +
		'<div class="w3-row"><div class="w3-half"><form action="submit-approve.php" method="post"><input type="hidden" name="user" value="' + y + '" /><button class="w3-btn w3-large w3-padding-large w3-round-large w3-text-white" name="challenge" value="' + x + '" style="background-color: #006666;">Accept!!</button></form></div>' +
		'<div class="w3-half"><form action="submit-remove.php" method="post"><input type="hidden" name="user" value="' + y + '" /><button class="w3-btn w3-large w3-padding-large w3-round-large w3-text-white" name="challenge" value="' + x + '" style="background-color: #d33;">Remove!!</button></form></div></div>'
});
}
</script>



<div class="w3-display-middle w3-center w3-text-light-grey Oswald" style="margin-top: -15%;">
	<p class="animation-target w3-border-bottom w3-center" style="font-size: 1.5vw;">Submissions</p>
</div>

	<div class="w3-row" style="margin-top: 5%; margin-left: 12%;">
	<?php
		while($challengesRow = mysqli_fetch_array($result_ch, MYSQLI_ASSOC)) {
		
		  /*$date_end = date_create(date('Y-m-d H:i:s', strtotime($challengesRow['date_end'])));
		  $date_start = date_create(date('Y-m-d H:i:s', strtotime($challengesRow['date_set'])));
		  $date_now = date_create(date('Y-m-d H:i:s', strtotime("now")));

	      if(($date_end > $date_now) && ($date_start < $date_now)) {*/
		  
		  SubmitChallengeButton($challengesRow);
		  //} else echo "";
		}
	?>
   </div>


</body>
</html>