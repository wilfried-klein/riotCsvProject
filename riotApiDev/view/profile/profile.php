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
			<div id="separateurLeftSide"></div>
			<div id="infoMoyenne">
				<h2>Stats moyenne utiles:</h2>
				<!-- METTRE STATS ICI -->

				<p><?php echo '<img src="img/KILLS.jpg" alt="img ward">' ;?>
				<?php echo "Nombres de kills : " . $average['averageKills'];?></p>

				<p><?php echo '<img src="img/DEATH.png" alt="img ward">' ;?>
				<?php echo "Nombre de morts : " . $average['averageDeaths'];?></p>

				<p><?php echo '<img src="img/WARD.jpg" alt="img ward">' ;?>
				<?php echo "Score de vision : " . $average['averageVision'];?></p>
			</div>
			<div id="separateurLeftSide"></div>
			<div id="csvDownloader">
				<p>Telecharger toutes vos données de vos dernier matchs</p>
				<form id='formCsv' name='formCsv' method="get" action="index.php" >
					<fieldset>
						<label for="game_number">Nombre de partie à exporter : </label>
						<select name="nbGames" id="game_number">
							<option value="10">10</option>
							<option value="20">20</option>
							<!--<option value="50">50</option>-->
							<!--<option value="100">100</option>-->
						</select required>
					</fieldset>
					<input type="hidden" name="action" value="getCsv">
					<input type="hidden" name="summonerName" value="<?php echo $summonerName ?>">
					<input type="hidden" name="server" value="<?php echo $server ?>">
					<input class="downloaderCsvImage" type="image" name="submit" src="img/telecharger.png" alt="img bouton telecharger" />
				</form>
			</div>
			<div id="separateurLeftSide"></div>
		</div>
		<div class="main">
			<div class="allInfos"> 
				<div class="lastGameInfo">
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
	</div>
</main>