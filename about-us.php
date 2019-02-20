<?php

//ob_start();
session_start();

require_once 'inc.php';


// ------------------------------


// Start of Page with some functions

html_head("About Us");

navbar('bgimg_index_logged');

pageFade();
HelpButton();

?>

<div class="w3-row AboutBox w3-center" style="font-size: 1vw;">
	<p class="animation-target" style="font-size: 1.5vw;">About Us</p>
	<p style="font-size: 1.25vw; margin-bottom: 4%;">Meet the team that aims to challenge you!</p>

	<div class="w3-half w3-text-light-grey" style="margin-bottom: 2%;">
	<div class="w3-row w3-card-4 w3-light-grey w3-border w3-border-black hvr-buzz-out" style="padding: 0; width: 70%; margin: auto; border-radius: 100px; position: relative;">
	  <div class="w3-third">
	    <img src="images/Syra.jpg"	style="border-radius: 1000px; width: 90%; margin-left: -12%; border: 1px solid black;">
	  </div>

	  <div class="w3-twothird w3-right" style="padding-right: 10%;">
		<p style="margin: 1% 0;">Merlijn "Syraleaf" Eskens</p>
		<hr class="w3-border-black" style="margin: 0;" />
		<p style="font-size: 0.75vw; margin-top: 5%;"><br />I have no clue what to put here. I'll think about it at some point.<br /><br /></p>
	  </div>
	</div>
	</div>

	<div class="w3-half w3-text-light-grey" style="margin-bottom: 2%;">
	<div class="w3-row w3-card-4 brand-dark-blue w3-border w3-border-black hvr-float" style="padding: 0; width: 70%; margin: auto; border-radius: 100px; position: relative;">
	  <div class="w3-third">
	    <img src="images/Erii.jpg" style="border-radius: 1000px; width: 90%; margin-left: -12%; border: 1px solid black;">
	  </div>

	  <div class="w3-twothird w3-right" style="padding-right: 10%;">
		<p style="margin: 1% 0;">Josef "Erii" Zacek</p>
		<hr style="margin: 0;" />
		<p style="font-size: 0.75vw; margin-top: 5%;">~ Chief Programmer of the Website Development. ~<br /><br />I'm 18 years old student of Programming currently living in Czech Republic. Magnificent image, eh?</p>
	  </div>
	</div>
	</div>

	<div class="w3-half w3-text-light-grey" style="margin-bottom: 2%;">
	<div class="w3-row w3-card-4 w3-pink w3-border w3-border-black hvr-wobble-horizontal" style="padding: 0; width: 70%; margin: auto; border-radius: 100px; position: relative;">
	  <div class="w3-third">
	    <img src="https://i.imgur.com/udo32QT.png" style="border-radius: 1000px; width: 90%; margin-left: -12%; border: 1px solid black;">
	  </div>

	  <div class="w3-twothird w3-right" style="padding-right: 10%;">
		<p style="margin: 1% 0;">Gabriel "Photophobia" Portela</p>
		<hr style="margin: 0;" />
		<p style="font-size: 0.75vw; margin-top: 5%;">~ Graphic Designer ~<br />I'm 22 years old game designer.<br />Born, raised and stuck in Brazil :p<br />Thanks to me this website is poop emoji free.</p>
	  </div>
	</div>
	</div>

	<div class="w3-half w3-text-light-grey" style="margin-bottom: 2%;">
	<div class="w3-row w3-card-4 w3-green w3-border w3-border-black hvr-skew" style="padding: 0; width: 70%; margin: auto; border-radius: 100px; position: relative;">
	  <div class="w3-third">
	    <img src="https://data.whicdn.com/images/21333057/large.jpg" style="border-radius: 1000px; width: 90%; margin-left: -12%; border: 1px solid black;">
	  </div>

	  <div class="w3-twothird w3-right" style="padding-right: 10%;">
		<p style="margin: 1% 0;">Polished "TheRiddlex" Polish</p>
		<hr style="margin: 0;" />
		<p style="font-size: 0.75vw; margin-top: 5%;">IDK.</p>
	  </div>
	</div>
	</div>
</div>

</body>
</html>