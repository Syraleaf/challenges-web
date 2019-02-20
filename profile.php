<?php

//ob_start();
session_start();

require_once 'inc.php';


// ------------------------------


// Start of Page with some functions

html_head("Profile Page");

navbar('bgimg_index_logged');
HelpButton();


// ------------------------------


// If User isn't logged => Access denied | else show the code

if( !isset($_SESSION['user']) ) {
access();
} else {


pageFade();


// ------------------------------


// Connection to DB and selecting profiles table by UserID

$conn = connect_db();

$sql = "SELECT * FROM `profiles` WHERE id_user=". $_SESSION['user'];
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

mysqli_close($conn);


$date = new DateTime();
$date_user = date_create(date('Y-m-d H:i:s', strtotime($row['date'])));
$date_now = date_create(date('Y-m-d H:i:s', strtotime("now")));

$ago = date_diff($date_now, $date_user);

// ------------------------------


if($row['clanbg'] == 0) $clanBg = "background-color: #532d2d;";
else $clanBg = "background-image: url('". getClanBg($row['clanbg']) ."');";


// Start of HTML Code with PHP array variables from the Select Query

?>

<script>
function ProfileBadge() {
    $('div[id="ProfileNotes"]').fadeOut(1);
    $('div[id="ProfileBadge"]').fadeIn();
	$('div[id="ProfileStats"]').fadeOut(1);
}

function ProfileNotes() {
    $('div[id="ProfileNotes"]').fadeIn();
    $('div[id="ProfileBadge"]').fadeOut(1);
	$('div[id="ProfileStats"]').fadeOut(1);
}

function ProfileStats() {
    $('div[id="ProfileNotes"]').fadeOut(1);
    $('div[id="ProfileBadge"]').fadeOut(1);
	$('div[id="ProfileStats"]').fadeIn();
}
</script>


<div class="ProfileBox w3-display-middle w3-container w3-row">

<div class='w3-col l3 w3-center'>
	<div class="badgeBg" style="<?php echo $clanBg; ?>">
		<img  class="w3-padding" id="badge" src="images/shield.png" alt="Shield" style="width: 70%;">
	</div>

	<p class='ProfileName w3-padding w3-card-2 PasseroOne' style="color: <?php echo $row['color']; ?>;"><?php echo getUser($row['id_user']); ?> [<?php if($row['id_guild'] != 0) echo getGuild($row['id_guild']); else echo "No Guild"; ?>]</p>
	<p class='ProfileTitle w3-padding w3-card-4 PasseroOne'><?php if($row['id_title'] == 0) echo "None"; else echo getTitle($row['id_title']); ?></p>

	<p class="w3-tooltip" style="margin-top: 20%; font-size: 1.25vw; position: relative"><span class="brand-dark-blue w3-round-xxlarge w3-animate-opacity w3-padding w3-text w3-tag" style="font-size: 1vw; position: absolute; bottom: 100%; right: 8%;"><i>Since <?php echo date('F jS, Y \a\t h:mA', strtotime($row['date'])); ?></i></span>Member for <u><?php echo $ago->format("%m months and %d days"); ?></u></p>
</div>

<div class="w3-col l7" id="ProfileNotes" style="margin: auto;">
	<div class='w3-right ProfileNote w3-border w3-border-black w3-round-xxlarge'>
	  <p class="w3-padding-large" style="font-size: 1.5vw; word-break: break;"><?php if($row['note'] != "") echo nl2br($row['note']); else echo "No description!"; ?></p>
	</div>
</div>

<div class="w3-col l7" id="ProfileBadge" style="margin: auto; padding-left: 10%; margin-top: 8%;" hidden>
	<?php
        $exp = ($row['exp'] / getBadgeEXP($row['id_badge']))*100;
        echo "<span style='font-size: 1.25vw;'>Current EXP: &nbsp ". $row['exp'] ." / ". getBadgeEXP($row["id_badge"]) ." (". round($exp, 1) ."%)</span>";
    ?>
	<div class="w3-ligh-grey w3-opacity w3-border w3-border-black w3-round-xlarge">
        <div class="w3-container w3-round-xlarge" style="background-color: #570099; height: 1.75rem; width:<?php echo $exp; ?>%; max-width: 100%;"></div>
    </div>
    
	<div class="w3-row" style="margin-top: 5%;">
		<div class="w3-half">
			<img src="<?php echo getBadgeImage($row['id_badge']); ?>" width="80%" style="margin-top: 10%;" />
		</div>
		<div class="w3-half w3-center PasseroOne" style="font-size: 1.25vw; margin-left: -15%; margin-top: 2%; padding: auto; width: 60%;">
		<p><?php if($row['id_badge'] != 0) { ?>----------------------------------------<br /><?php echo getBadgeDesc($row['id_badge']); ?><br />----------------------------------------</p>
		<?php } else echo "No Badge T^T"; ?>
		</div>
	</div>

</div>

<div class="w3-col l7" id="ProfileStats" style="margin: auto; padding-left: 10%; margin-top: 8%; font-size: 1.5vw;" hidden>
<div class="w3-row">
<div class="w3-half">
    <p>Most Recent Challenge: &nbsp; <span style="font-size: 1.75vw;"><br /><?php echo getChallenge($row['id_challenge']); ?></span></p>
    <p style="margin-top: 5%;">Completed Challenges: &nbsp; <span style="font-size: 1.75vw;"><?php echo $row['ch_done']; ?></span></p>
    <p>Speedruns on Board: &nbsp; <span style="font-size: 1.75vw;"><?php echo $row['sp_board']; ?></span></p>
</div>

<div class='w3-half w3-center' style="font-size: 1.5vw;">
    <p>Favourite Weapon: <br /> <span style="font-size: 1.75vw;"><?php if($row['id_weapon'] != 0) echo getWeapon($row['id_weapon']); else echo "None"; ?></span></p>
</div>
</div>
</div>

<div class="w3-col l2 w3-center" style="margin: auto; margin-top: 13%;">
	<button class="w3-btn ProfileBtn hvr-forward w3-indigo w3-padding-large w3-margin-top" style="outline: none;" onclick="ProfileNotes()">Main Tab</button>
	<button class="w3-btn ProfileBtn hvr-forward w3-deep-purple w3-padding-large w3-margin-top" style="outline: none;" onclick="ProfileBadge()">Badge</button>
	<button class="w3-btn ProfileBtn hvr-forward w3-pink w3-padding-large w3-margin-top" style="outline: none;" onclick="ProfileStats()">Statistics</button>

	<form method="post" action="profile-edit.php">
	<input type="hidden" name="id" value="<?php echo $_SESSION['user']; ?>">
	<input type="submit" class="w3-btn ProfileBtn hvr-forward w3-teal w3-padding-large" style="outline: none; margin-top: 70%;" value="Edit Profile" name="Edit" />
	</form>
</div>

</div>

<?php } ?>
</body>
</html>