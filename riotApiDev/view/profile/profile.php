<main>
	<div class="top">
		<div class="summonerInfo">
			<img src="<?php echo $summonerIcon?>" alt="logo de l'invocateur"/>
			<p id="summonerName"><?php echo $summonerName ?></p>
		</div>
	</div>
	<div class="middle">
		<div class="leftSide">
			<div class="rankInfo">
				<img src="<?php echo $rankedEmblems?>" alt="division de l'invocateur"/>
				<div class="rankData">
					<?php
					if($tier == "unranked"){
						echo "<p>" . $tier . "</p>";
					}else{
						echo "<p>" . $tier . "\n" . $rank . "</p>";
						echo "<p>" . $leaguePoints . "\nLP\n/\n" . $wins . "\nW\n-\n" . $loses ."\nL</p>";
						echo "<p>" . $winRatio . "% de winrate</p>";
					}
					?>
				</div>
			</div>  
		</div>
		<div class="main">
			<div class="matchList">
				<table>
					<?php
					foreach ($result as $value) {
						require 'match.php';
					}
					?>
				</table>
			</div>
		</div>
	</div>
</main>