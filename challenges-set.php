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

html_head("Challenges Set");

navbar('bgimg_index_logged');

HelpButton();
pageFade();



$conn = connect_db();

	$sql = "SELECT * FROM challenges";
	$res = mysqli_query($conn, $sql);

mysqli_close($conn);


?>



<script>
function ChallengeSearch() {
    var input, filter, btn, div, i;
    input = document.getElementById("ChallengesSearch");
    filter = input.value.toUpperCase();
    div = document.getElementById("ChallengeDiv");
    btn = div.getElementsByTagName("button");
    for (i = 0; i < btn.length; i++) {
        if (btn[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
            btn[i].style.display = "";
        } else {
            btn[i].style.display = "none";
        }
    }
}
</script>


<div class="w3-text-light-grey Oswald">

	<div class="w3-container" style="margin: 0 10%; margin-bottom: 2%;">
		<a href="challenges-add.php" class="w3-btn w3-transparent w3-border w3-border-lime w3-text-lime w3-padding-large w3-round-xxlarge" style="font-size: 1.5vw;">Add Challenge</a>
		<span style="font-size: 2vw; vertical-align: middle;">&nbsp;&nbsp;&nbsp;&nbsp; or search &nbsp;</span>
		<input type="text" class="w3-right w3-input w3-transparent w3-text-light-grey w3-border-bottom w3-animate-input" id="ChallengesSearch" placeholder="Search for Challenge..." onkeyup="ChallengeSearch();	" style="width: 50%; max-width: 70%; margin-top: 0.5%; font-size: 1.5vw" />
	</div>

	<hr style="margin: auto; width: 95%; margin-bottom: 2%; border: 0; height: 4px; background-image: linear-gradient(to right, rgba(255,255,255, 0), rgba(255,255,255, 0.75), rgba(255,255,255, 0));" />

	<div class="w3-row" style="margin-left: 10%;" id="ChallengeDiv">
		<?php
		while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) ChallengeButton($row, "form");
		?>
	</div>

</div>


</body>
</html>