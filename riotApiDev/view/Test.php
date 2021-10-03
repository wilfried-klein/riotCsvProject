<!DOCTYPE html>
<html>
<head>
	<title>Résultat de la dernière partie</title>
	<meta charset="utf-8">
	<style type="text/css">
		.summonerInfo{
			display: flex;
			flex-flow: column wrap;
		}
		.rankInfo{
			display: flex;
			flex-flow: row wrap;
		}
		#summonerName{;
			font-size: 25px;
			font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="summonerInfo">
		<?php echo '<img src="data:image/jpeg;base64,'.$summonerIcon.'"style="width:100px;height:100px;">'; ?>
		<p id="summonerName"><?php echo $summonerName ?></p>
	</div>
	<div class="rankInfo">
		<?php echo '<img src="data:image/jpeg;base64,'.$rankedEmblems.'"style="width:100px;height:100px;">'; ?>
		<div class="rankData">
			<p><?php echo $tier . "\n" . $rank ?></p>
			<p><?php echo $leaguePoints . "\nLP\n/\n" . $wins . "-" . $loses ?></p>
			<p><?php echo $winRatio . "% de winrate" ?></p>
		</div>
	</div>
</div>
<div class="lastGameInfo">
	<p>Dernière Partie :</p>
	<div>
		champion :
		<?php
		echo $championName;
		echo '<img src="data:image/jpeg;base64,'.$championIcon.'"style="width:75px;height:75px;">';
		echo "<br>";
		echo "<p>Objet de la partie :</p>";
		for ($i=0; $i < 6; $i++) { 
			echo '<img src="data:image/jpeg;base64,'.$itemsIcon[$i].'">';
		}
		?>
	</div>
</div>
</body>
</html>