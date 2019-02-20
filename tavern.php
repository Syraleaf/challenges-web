<?php

//ob_start();
session_start();

require_once 'inc.php';


// ------------------------------


// Start of Page with some functions

html_head("Challenges Crossroads");

navbar('bgimg_index_logged');
HelpButton();


// ------------------------------


// If User is logged => get his name an announce it as pop-up

if( !isset($_SESSION['user']) ) {
access();
} else {
// select loggedin users detail
 $conn = connect_db();
 $sql = "SELECT * FROM `users` WHERE id_user=".$_SESSION['user'];
 $res = mysqli_query($conn, $sql);
 $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
 mysqli_close($conn);

pageFade();

// Pop up |
//        V
    
if($_SESSION['log'] == 1)
{
?>
<script>
swal({
  title: "Greetings, <?php echo $userRow['name']; ?>!",
  text: "Everything is ready and up for work!",
  type: "success",
  position: "top-end",
  showConfirmButton: false,
  timer: 2000
});
</script>
<?php
$_SESSION['log'] = 0;
}


// ------------------------------


// Start of HTML Code with Javascript function on Admin Features


?>

<div class="w3-row mySlides">

<div class="TavernBox w3-quarter w3-container" style="font-size: 1.75vw;">
<p class='w3-center'>Welcome <?php echo $userRow['name']; ?>!</p>

<a href="public-challenges.php" class="w3-btn w3-transparent w3-round-large w3-text-black" style="padding: 0 25%; margin-left: 1%; outline: none;">- Challenges</a>

<p>- Speedrunning UwU</p>

<a href="profile.php" class="w3-btn w3-transparent w3-round-large w3-text-black" style="padding: 0 22%; margin-left: 2%; outline: none;">- Profile Page</a>

<p>- Leaderboard</p>
</div>


<div class="w3-quarter w3-center w3-text-white" style="margin-left: 4%;">
	<p style="font-size: 1.25vw;"><u>Notifications</u></p>

	<?php
	if(isset($_SESSION['challenge_approved'])) {
		$conn = connect_db();
		$sql = "SELECT * FROM notifications WHERE id_user=". $_SESSION['user'];
		$res_n = mysqli_query($conn, $sql);
		mysqli_close($conn);

		if(isset($_POST['id'])) {
			$conn = connect_db();
			$sql = "DELETE FROM notifications WHERE id_user=". $_SESSION['user'] ." AND id_challenge=". $_POST['id'];
			$res = mysqli_query($conn, $sql);
		}

	while($notificationRow = mysqli_fetch_array($res_n, MYSQLI_ASSOC)) {
	?>
	<form action="" method="post" class="Oswald hvr-hang">
	<?php if($notificationRow['decision'] == 1)
		echo '<button class="w3-btn w3-panel w3-display-container w3-card-2 w3-round-xlarge w3-row w3-center toast_success" value="'. $notificationRow['id_challenge'] .'" name="id" onclick="this.parentElement.style.display=none">
			<p style="font-size: 0.9vw;"><span class="fa fa-calendar-check-o" style="font-size: 1.25vw;"></span> &nbsp; Your challenge: <b>'. getChallenge($notificationRow['id_challenge']) .'</b> has been approved and counted for you :3</p>
		</button>';
	  else 
		echo '<button class="w3-btn w3-panel w3-display-container w3-card-2 w3-round-xlarge w3-row w3-center toast_deny" value="'. $notificationRow['id_challenge'] .'" name="id" onclick="this.parentElement.style.display=none">
			<p style="font-size: 0.9vw;"><span class="fa fa-calendar-check-o" style="font-size: 1.25vw;"></span> &nbsp; Your challenge: <b>'. getChallenge($notificationRow['id_challenge']) .'</b> has been denied and resetted for submission :C</p>
		</button>';
	?>
	</form>
	<?php } } ?>
</div>


<div class="w3-half w3-card-4 w3-round-xlarge w3-right midnight-blue" style="position: relative; width: 30%; margin-right: 10%; margin-left: 5%;">
	<img src="http://ecard.enter-media.org/upload/iblock/9dc/9dc8991684a93b20ef0586d6afff3d5d.png" alt="Ribbon Banner" style="width: 100%; position:absolute;" />

	<div class="w3-padding-large w3-center" style="margin-top: 8%; font-size: 0.8vw;">
		<p class="animation-target PasseroOne" style="margin-top: 2%; font-size: 1vw;">Update v1.0.0</p>
		<p style="margin-top: 2%;"><br />IT'S HERE, FIRST VERSION FOR TESTING IS UP!!!!<br /><br />Added some cool features ya know, explore them :P<br />They are  basically all around the site so what are you waiting for xD</p>
	</div>
</div>



<?php if($userRow['permission'] == 1) { ?>
<div class='w3-display-right w3-xxxlarge w3-text-white'>
    <button class='fa fa-chevron-right w3-btn w3-transparent' onclick="plusDivs(1);"></button>
</div>
<?php } ?>

</div>

<?php if($userRow['permission'] == 1) { ?>
<div class="w3-container mySlides w3-text-white Oswald" style="display: none;">
    <div class='w3-display-left w3-xxxlarge'>
    <button class='fa fa-chevron-left w3-btn w3-transparent' onclick="plusDivs(-1);"></button>
    </div>
    
    <div id="Panel">
    <p class="animation-target w3-center" style="margin-top: -2%; font-size: 2vw;">Admin Panel</p>
    
    <div class="w3-row" style="margin-top: 4%;">
        <p class="w3-col l2"> </p>
        <?php
            AdminButton("titles");
            AdminButton("runs");
            AdminButton("parties");
        ?>
    </div>
    <div class="w3-row" style="margin-top: 4%;">
        <p class="w3-col l2"> </p>
        <?php
            AdminButton("difficulties");
            AdminButton("guilds");
            AdminButton("weapons");
        ?>
    </div>
    <div class="w3-row" style="margin-top: 4%;">
        <p class="w3-col l2"> </p>
        <a href="challenges-set.php" class="w3-col l2 w3-btn w3-transparent w3-round-large w3-border w3-border-white w3-padding-large w3-hover-teal" style="font-size: 2vw;">Challenges</a>
        <p class="w3-col l1"> </p>
		<?php AdminButton("behemoths"); ?>
        <a href="#" class="w3-col l2 w3-btn w3-transparent w3-round-large w3-border w3-border-white w3-padding-large w3-hover-teal" style="font-size: 2vw;">Profiles</a>
        <p class="w3-col l1"> </p>
    </div>
    </div>
    
    <?php 
        AdminCat("titles");
        AdminCat("runs");
        AdminCat("parties");
        AdminCat("difficulties");
        AdminCat("guilds");
        AdminCat("weapons");
		AdminCat("behemoths");
    ?>
    
</div>


<?php } } ?>
</body>
</html>