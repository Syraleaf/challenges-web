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

html_head("Weapon Adding");

navbar('bgimg_index_logged');

HelpButton();
pageFade();


if( isset($_POST['Send']) ) {
	$conn = connect_db();

		$sql = "INSERT INTO `weapons` (name,img,note) VALUES ('". $_POST['name'] ."', '". $_POST['image'] ."', '". htmlspecialchars($_POST['note']) ."')";
		$res = mysqli_query($conn, $sql);

if ($res) {
	echo '<script>
	swal({
	 title: "Successfully added!!",
	text: "Weapon has been added without any problem!",
	type: "success",
	showConfirmButton: false,
	timer: 1990
	});
	</script>';

	echo "<meta http-equiv='refresh' content='2; url=weapons-add.php'>";

   } else {
    mysqli_error($conn);
   }

	mysqli_close($conn);
}


?>

<script>

	$(function() {
		$source=$("#name");
		$output=$("#result");
		$source.keyup(function() {
			$output.text($source.val());
		});
	});

</script>



<div class="w3-row w3-text-light-grey Oswald">

<p class="w3-center" style="margin-top: -4%; font-size: 5vw;">Weapon Adding</p>

<form method="post" action="">
	
	<div style="margin-top: -2%;">

	<div class="w3-half" style="padding-left: 25%;">
	<b><label for="name" style="font-size: 1.5vw;">Weapon Name: </label></b>
	<input type="text" class="w3-input w3-animate-input w3-transparent w3-text-light-grey w3-center w3-margin-top" placeholder="Fill in the Name..." name="name" id="name" style="width: 70%; max-width: 90%; font-size: 1.25vw;" required />

	<br /><br />
	<b><label for="image" style="font-size: 1.5vw;">Image Link: </label></b>
	<input type="text" class="w3-input w3-animate-input w3-transparent w3-text-light-grey w3-center w3-margin-top" placeholder="Fill in the Image Link..." name="image" id="image" style="width: 70%; max-width: 90%; font-size: 1.25vw;" />
	</div>
	
	<div class="w3-half" style="padding-left: 5%;">
	<b><label for="note" class="w3-text-light-grey" style="font-size: 2vw;">Weapon Description: </label></b><br />
	<textarea class="w3-transparent w3-text-light-grey w3-border-0 w3-leftbar" onKeyDown="limitText(this.form.note,this.form.countdown,255);" 
onKeyUp="limitText(this.form.note,this.form.countdown,255);" name="note" id="note" style="width: 50%; resize: none; height: 14rem; padding-left: 2%; font-size: 1vw;"></textarea>
	<input class="w3-input w3-transparent w3-text-light-grey w3-center" name="countdown" value="255" style="width: 10%;" /> characters left
	</div>


	<div class='w3-center' style='margin-top: 4%; font-size: 1.5vw;'>
		<input type='submit' value='Add' name='Send' class='w3-btn w3-transparent w3-text-lime w3-border w3-border-lime w3-padding-large' />
        <input type='reset' value='Reset' class='w3-btn w3-transparent w3-text-red w3-border w3-border-red w3-padding-large' style='margin-left: 5%;' />
	</div>

	</div>

</form>

</div>


</body>
</html>