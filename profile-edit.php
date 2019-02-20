<?php

//ob_start();
session_start();



require_once 'inc.php';

html_head("Profile Edit");

navbar('bgimg_index_logged');

HelpButton();


// If User is logged => get his name an announce it as pop-up

if( !isset($_SESSION['user']) ) {
access();
} else {

pageFade();









if( isset($_POST['ProfileEdit']) ) {
$conn = connect_db();

	$sql = "UPDATE `profiles` SET id_title='". $_POST['title'] ."', color='". $_POST['color'] ."', clanbg='". $_POST['clanbg'] ."' WHERE id_user=". $_POST['id'];
	$res = mysqli_query($conn, $sql);

	if ($res) {
	echo '<script>
	swal({
	 title: "Successfully edited!!",
	text: "Profile has been edited without any problem!",
	type: "success",
	showConfirmButton: false,
	timer: 1990
	});
	</script>';

	echo "<meta http-equiv='refresh' content='2; url=profile.php'>";

   } else {
    mysqli_error($conn);
   }
	mysqli_close($conn);
}




$_POST['title'] = 0;
$_POST['color'] = "";

$id = $_POST['id'];

$conn = connect_db();

	$sql = "SELECT * FROM profiles WHERE id_user=". $id;
	$res_p = mysqli_query($conn, $sql);
	$row_p = mysqli_fetch_array($res_p, MYSQLI_ASSOC);

	$sql = "SELECT * FROM usertitles WHERE id_user=". $id;
	$res_t = mysqli_query($conn, $sql);
	$count_t = mysqli_num_rows($res_t);

	$sql = "SELECT * FROM usercolors WHERE id_user=". $id;
	$res_c = mysqli_query($conn, $sql);
	$count_c = mysqli_num_rows($res_c);

	$sql = "SELECT * FROM userclanbacks WHERE id_user=". $id;
	$res_cb = mysqli_query($conn, $sql);
	$count_cb = mysqli_num_rows($res_cb);

mysqli_close($conn);


if($row_p['clanbg'] == 0) $clanBg = "background-color: #532d2d;";
else $clanBg = "background-image: url('". getClanBg($row_p['clanbg']) ."');";

?>

<div class="ProfileBox w3-card-4 w3-display-middle" style="font-size: 1.25vw; opacity: 0.9;">
  <p class="animation-target w3-center PasseroOne" style="font-size: 1.5vw;">Edit of your Profile</p>
	<form class="w3-row w3-container" method="post" action="">

		<input type="hidden" name="id" value="<?php echo $id; ?>">

		<div class="w3-col l4" style="margin-top: 2%;">
		<div style="padding-right: 30%; padding-left: 5%;">

		<label for="title">Choose your Title:</label>
		<select class="w3-select w3-center" name="title" id="title">
			<?php
			if($count_t < 1) echo "<option value=0>None</option>";
			else {
			echo "<option value=0>None</option>";
			while($row = mysqli_fetch_array($res_t, MYSQLI_ASSOC)) {
				if($row['id_title'] == $row_p['id_title']) echo "<option class='w3-text-black' value=". $row['id_title'] ." selected>". getTitle($row['id_title']) ."</option>";
				else echo "<option class='w3-text-black' value=". $row['id_title'] .">". getTitle($row['id_title']) ."</option>";
			}
			}
			?>
		</select>

		<div style="margin-top: 15%;">
		<label for="title">Choose your Name Color:</label>
		<select class="w3-select w3-center" name="color" id="color">
			<?php 
			if($count_c < 1) echo "<option value=''>Default</option>";
			else {
			echo "<option value=''>Default</option>";
			while($row = mysqli_fetch_array($res_c, MYSQLI_ASSOC)) {
				if($row['id_color'] == $row_p['color']) echo "<option class='w3-text-black' value='". $row['id_color'] ."' selected>". getColor($row['id_color']) ."</option>";
				else echo "<option class='w3-text-black' value='". $row['id_color'] ."'>". getColor($row['id_color']) ."</option>";
			}
			}
			?>
		</select>
		</div>

		<div style="margin-top: 15%;">
		<label for="title">Choose your Clan Background:</label>
		<select class="w3-select w3-center" name="clanbg" id="clanbg">
			<?php 
			if($count_cb < 1) echo "<option value=0>Default</option>";
			else {
			echo "<option value=0>Default</option>";
			while($row = mysqli_fetch_array($res_cb, MYSQLI_ASSOC)) {
				if($row['id_cb'] == $row_p['clanbg']) echo "<option class='w3-text-black' value='". $row['id_cb'] ."' selected>". getClanBgName($row['id_cb']) ."</option>";
				else echo "<option class='w3-text-black' value='". $row['id_cb'] ."'>". getClanBgName($row['id_cb']) ."</option>";
			}
			}
			?>
		</select>
		</div>

		</div>

		<div class='w3-col l12 w3-center' style='margin-top: 5%; margin-left: 100%; font-size: 1.5vw;'>
			<input type='submit' value='Edit' name='ProfileEdit' class='w3-btn w3-transparent w3-teal w3-padding-large w3-round-large' />
			<input type='reset' value='Reset' class='w3-btn w3-transparent w3-red w3-padding-large w3-round-large' style='margin-left: 5%;' />
		</div>

		</div>

	</form>

</div>

<div class="w3-display-bottommiddle" style="margin-bottom: 2%; font-size: 1.25vw;">
	<a href="profile.php" class="w3-btn w3-transparent w3-border w3-text-white w3-padding-large w3-round-large">Back</a>
</div>

<?php } ?>

</body>
</html>