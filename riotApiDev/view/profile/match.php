<tr>
	<td>
		<?php
		if($value['result'] == true){
			echo '<h3 style="color: #1217C0;">VICTOIRE</h3>';
		}else{
			echo '<h3 style="color: #C01712;">DÉFAITE</h3>';
		}
		?>
		<div>
			<img src="<?php echo $value['championIcon']?>" alt="<?php echo $value['championName'] ?>"/>
			<div>
				<img src="<?php echo $value['summonerSpell1']?>"/>
				<img src="<?php echo $value['summonerSpell2']?>"/>
			</div>
		</div>
		<div>
			<?php echo $value['championName'];?>
			<img src="<?php echo $value['rune1Icon']?>"/>
			<img src="<?php echo $value['rune2Icon']?>"/>
		</div>
	</td>
	<td>
		<p> <?php echo $value['gameDurationMin'] . " Min " . $value['gameDurationSeconde']?> </p>
		<p><?php echo $value['matchType'] ?></p>
		<p> Le <?php echo $value['matchDate']['mday'] . "/" . $value['matchDate']['mon'] . "/" . $value['matchDate']['year']?></p>
	</td>
	<td>
		<p><?php echo $value['kills'] . "/" . $value['deaths'] . "/" . $value['assists'] ?></p>
		<p><?php echo $value['creepScore']?> Cs</p>
		<p>Score de vision : <?php echo $value['visionScore'] ?></p>
	</td>
	<td>
		<?php
		for ($i=0; $i < 7; $i++) {
			if(array_key_exists($i,$value['itemsIcon'])){
				echo '<img src="'. $value['itemsIcon'][$i].'">';
			}
		};
		?>
	</td>
	<td>
		<?php 
		for ($g=0; $g < 5; $g++) {
			echo "<div>";
			echo $value['summonerNameList'][$g] . '<img src="'. $value['summonerIconList'][$g].'">' . '<img src="'. $value['summonerIconList'][$g+5].'">' . $value['summonerNameList'][$g+5];
			echo "</div>";
		}
		?>
	</td>
</tr>