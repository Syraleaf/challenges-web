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

html_head("Public Challenges");

navbar('bgimg_challenges');
pageFade();
HelpButton();


$conn = connect_db();

 $sql = "SELECT * FROM `users` WHERE id_user=".$_SESSION['user'];
 $res = mysqli_query($conn, $sql);
 $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

 $sql = "SELECT * FROM `profiles` WHERE id_user=".$_SESSION['user'];
 $res = mysqli_query($conn, $sql);
 $profileRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

 $sql = "SELECT * FROM `challenges`";
 $result_ch = mysqli_query($conn, $sql);
 $result_ch2 = mysqli_query($conn, $sql);

mysqli_close($conn);


?>




<script>
function GetChallenge(x)
{
swal({
  title: 'Challenge accepted?',
  text: "Be wise or you'll be smacked by the Behemoth xD",
  type: 'question',
  showConfirmButton: false,
  allowOutsideClick: true,
  showCloseButton: true,
  html: '<p class="w3-margin-bottom">Rather submit your impressive run or abandon the Challenge with shame on your back xD</p>' +
		'<div class="w3-center"><form action="userchallenge-assign.php" method="post"><button class="w3-btn w3-large w3-padding-large w3-round-large w3-text-white" name="challenge" value="' + x + '" style="background-color: #007acc;">I am in!</button></form></div>'
});
}

function EditChallenge(x, y)
{
if(y == 1) y = "Re-Submit!!";
else y = "Submit!!";

swal({
  title: 'What to do now?',
  type: 'question',
  showConfirmButton: false,
  allowOutsideClick: true,
  showCloseButton: true,
  html: '<p class="w3-margin-bottom">Rather submit your impressive run or abandon the Challenge with shame on your back xD</p>' +
		'<div class="w3-row"><div class="w3-half"><form action="userchallenge-submit.php" method="post"><button class="w3-btn w3-large w3-padding-large w3-round-large w3-text-white" name="challenge" value="' + x + '" style="background-color: #006666;">' + y + '</button></form></div>' +
		'<div class="w3-half"><form action="userchallenge-remove.php" method="post"><button class="w3-btn w3-large w3-padding-large w3-round-large w3-text-white" name="challenge" value="' + x + '" style="background-color: #d33;">Abandon!!</button></form></div></div>'
});
}
</script>





<div class="mySlides">

<div class='w3-display-right w3-xxxlarge w3-text-white'>
    <button class='fa fa-chevron-right w3-btn w3-transparent' onclick="plusDivs(1);"></button>
</div>

<div class="w3-display-middle Oswald" style="margin-top: -15%;">
  <div>
	<p class="animation-target w3-border-bottom w3-border-black w3-center" style="font-size: 1.1vw; margin: 8% 15%;">ACTIVE CHALLENGES</p>

	<?php
        $exp = ($profileRow['exp'] / getBadgeEXP($profileRow['id_badge']))*100;
        echo "<span style='font-size: 1vw;'>Current EXP: &nbsp ". $profileRow['exp'] ." / ". getBadgeEXP($profileRow["id_badge"]) ." (". round($exp, 1) ."%)</span>";
    ?>
	<div class="w3-ligh-grey w3-border w3-border-black w3-round-xlarge">
        <div class="w3-container w3-round-xlarge" style="background-color: #570099; height: 1.25rem; width:<?php echo $exp; ?>%; max-width: 100%;"></div>
    </div>
  </div>
</div>


  <div class="w3-row" style="margin-top: 5%; margin-left: 12%;">
	<?php
		while($challengesRow = mysqli_fetch_array($result_ch, MYSQLI_ASSOC)) {
		
		  $date_end = date_create(date('Y-m-d H:i:s', strtotime($challengesRow['date_end'])));
		  $date_start = date_create(date('Y-m-d H:i:s', strtotime($challengesRow['date_set'])));
		  $date_now = date_create(date('Y-m-d H:i:s', strtotime("now")));

	      if(($date_end > $date_now) && ($date_start < $date_now)) {
		  
		  $conn = connect_db();
		  $sql = "SELECT * FROM `userchallenges` WHERE id_challenge=". $challengesRow['id_challenge'];
		  $result_uch = mysqli_query($conn, $sql);
		  $userchallengesCount = mysqli_num_rows($result_uch);
		  mysqli_close($conn);

		  if($userchallengesCount >= 1) echo "";
		   else ChallengeButton($challengesRow, "get");
		  } else echo "";
		}
	?>
   </div>
</div>


<div class="mySlides" style="display: none;">

<div class='w3-display-left w3-xxxlarge w3-text-white'>
	<button class='fa fa-chevron-left w3-btn w3-transparent' onclick="plusDivs(-1);"></button>
</div>

<div class="w3-display-middle Oswald" style="margin-top: -15%;">
  <div>
	<p class="animation-target w3-border-bottom w3-border-black w3-center" style="font-size: 1.1vw; margin: 8% 15%;">TAKEN CHALLENGES</p>

	<?php
        $exp = ($profileRow['exp'] / getBadgeEXP($profileRow['id_badge']))*100;
        echo "<span style='font-size: 1vw;'>Current EXP: &nbsp ". $profileRow['exp'] ." / ". getBadgeEXP($profileRow["id_badge"]) ." (". round($exp, 1) ."%)</span>";
    ?>
	<div class="w3-ligh-grey w3-border w3-border-black w3-round-xlarge">
        <div class="w3-container w3-round-xlarge" style="background-color: #570099; height: 1.25rem; width:<?php echo $exp; ?>%; max-width: 100%;"></div>
    </div>
  </div>
</div>

 <div class="w3-row" style="margin-top: 5%; margin-left: 12%;">
	<?php
		while($challengesRow = mysqli_fetch_array($result_ch2, MYSQLI_ASSOC)) {	
		
		  $date_end = date_create(date('Y-m-d H:i:s', strtotime($challengesRow['date_end'])));
		  $date_start = date_create(date('Y-m-d H:i:s', strtotime($challengesRow['date_set'])));
		  $date_now = date_create(date('Y-m-d H:i:s', strtotime("now")));

	      if(($date_end > $date_now) && ($date_start < $date_now)) {
		  
		  $conn = connect_db();
		  $sql = "SELECT * FROM `userchallenges` WHERE state<>2 AND id_challenge=". $challengesRow['id_challenge'];
		  $result_uch = mysqli_query($conn, $sql);
		  $userchallengesCount = mysqli_num_rows($result_uch);
		  mysqli_close($conn);

		  if($userchallengesCount < 1) echo "";
		   else ChallengeButton($challengesRow, "edit");
		  } else echo "";
		}
	?>
   </div>


</div>


</body>
</html>