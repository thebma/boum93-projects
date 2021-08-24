<!DOCTYPE html>
<html lang="en">

	<head>

	    <title>Leerlijnen 2</title>
	    <?php $this->assets->addCss('css/leerlijnen2.css');
		$this->assets->addCss('css/jquery-ui.css');
		$this->assets->outputCss()

		?>
		<meta name=viewport content="width=device-width, initial-scale=1">
	</head>

	<body>
		
		<div class="container">

			<div class="header">
				<h1>Veilig en milieubewust werken</h1>
				<span>Denk aan: Verwerken van afvalmateriaal</span><span id="special"> Let op gevaar, ook voor anderen</span>
			</div>

			<div class="schans">
				<div id="black"></div>
				<div id="white">
					<span id="left">Van onbewust</span>
					<span id="right">Naar bewust</span>
				</div>
			</div>
			<div class="slider">
				<input type="range" id="myRange" oninput="getValue(value)">
			</div>

			<div class="col-md-6 gedrag">
				<h2>Beginnergedrag</h2>
				<p>
					<ul>
						<li>Ik zie geen gevaar en let niet op de omgeving</li>
						<li>Ik heb mijn eigen regels en denk er niet bij na</li>
						<li>Ik neem altijd meer materiaal dan ik nodig heb</li>
						<li>Ik laat mijn spullen overal liggen (rondslingeren)</li>
						<li>Ik merk in de praktijk wel waar ik gevaar loop</li>
						<li>Ik gebruik nooit een veiligheidsbril, gehoorbescherming, overall of werkschoenen</li>
						<li>Ik gooi afvalmateriaal zomaar weg</li>
						<li>Ik heb een koptelefoon(of oortje) met muziek op</li>
						<li>Ik waarschuw nooit andere mensen als die zich in een onveilige situatie bevinden</li>
					</ul>
				</p>
			</div>

			<div class="col-md-6 gedrag">
				<h2>Expertgedrag</h2>
				<p>
					<ul>
						<li>Ik weet waar en wanneer ik gevaar loop</li>
						<li>Ik volg de richtlijnen voor veilig werken nauwkeurig</li>
						<li>Ik ga zuinig om met het materiaal</li>
						<li>Ik houd mijn werkplek overzichtelijk</li>
						<li>Ik ga veilig met gereedschap en apparatuur om en kan uitleggen wanneer en hoe ik beschermingsmaterialen moet gebruiken</li>
						<li>Ik sorteer afvalmateriaal en voert dit af volgens de geldende voorschriften</li>
						<li>Als andere mensen zich in een onveilige situatie bevinden, dan spreek ik ze hier op aan</li>
					</ul>
				</p>
			</div>

			<?php

			use Phalcon\Forms\Form;
			use Phalcon\Forms\Element\Text;
			use Phalcon\Forms\Element\Select;

			$form = new Form();

			$form->add(new Text("name"));

			$form->add(new Text("telephone"));

			$form->add(new Select("telephoneType", array(
				'H' => 'Home',
				'C' => 'Cell'
			)));

			?>

			<form class="" action="upload.php" method="post" autocomplete="off">

				<div class="col-md-6">
					<div class="situatie inputs">
						<h2>Situatie: (KBS)</h2>
						<textarea name="situatie"></textarea>
					</div>
				</div>

				<div class="col-md-6 cursist_height">
					<div class="cursist inputs">
						<h2>Cursist: </h2>
						<input type="text" name="cursist">
					</div>
				</div>

				<div class="col-md-6">
					<div class="motivering inputs">
						<h2>Motivering (goed, verbeterpunten, tips): </h2>
						<input type="text" name="motivering">
					</div>
				</div>

				<div class="col-md-6">
					<div class="datum inputs">
						<h2>Datum: </h2>
						<input type="date" id="datepicker" name="datum">
					</div>
				</div>

				<div class="col-md-6">
					<div class="beoordelaar inputs">
						<h2>Beoordelaar: </h2>
						<select name="beoordelaar">
							<option value="b1">Beoordelaar 1</option>
							<option value="b2">Beoordelaar 2</option>
							<option value="b3">Beoordelaar 3</option>
						</select>
					</div>
				</div>

				<div class="col-md-6">
					<div class="bedrijf_functie inputs">
						<h2>Bedrijf / functie: </h2>
						<input type="text" name="bedrijf">
					</div>
				</div>

				<div class="col-md-6">
					<div class="handtekening inputs">
						<h2>Handtekening: </h2>
						<input type="file" name="handtekening">
					</div>
				</div>

				<div class="col-md-6 save_button">
					<button>Opslaan</button>
				</div>

			</form>

		</div><!-- /container -->



		<?php
		$this->assets->addJs('js/jquery-ui.js');
		$this->assets->addJs('js/leerlijnen2.js');
		$this->assets->outputJs() ?>
	</body>

</html>