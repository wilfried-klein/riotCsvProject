<tr>
	<td class="info1">
		<?php
		if($value['result'] == true){
			echo '<h3 style="color: #1217C0;">VICTOIRE</h3>';
		}else{
			echo '<h3 style="color: #C01712;">DÉFAITE</h3>';
		}
		?>
        <div class="info1Global">
            <div class="champEtSort">
                <div class="champ">
                    <img src="<?php echo $value['championIcon']?>" alt="<?php echo $value['championName'] ?>"/>
                    <p><?php echo $value['championName'];?></p>
                </div>
                <div class="summonerSpell">
                    <img src="<?php echo $value['summonerSpell1']?>"/>
                    <img src="<?php echo $value['summonerSpell2']?>"/>
                </div>
            </div>
            <div class="runes">
                <img src="<?php echo $value['rune1Icon']?>"/>
                <img src="<?php echo $value['rune2Icon']?>"/>
            </div>
        </div>
	</td>

	<td class="info2">
		<p> <?php echo $value['gameDurationMin'] . " Min " . $value['gameDurationSeconde']?> </p>
		<p><?php echo $value['matchType'] ?></p>
		<p> Le <?php echo $value['matchDate']['mday'] . "/" . $value['matchDate']['mon'] . "/" . $value['matchDate']['year']?></p>
	</td>

	<td class="info3">
		<p><?php echo $value['kills'] . "/" . $value['deaths'] . "/" . $value['assists'] ?></p>
		<p><?php echo $value['creepScore']?> Cs</p>
		<p>Score de vision : <?php echo $value['visionScore'] ?></p>
	</td>

	<td class="info4">
            <div class="objets">
                <?php
                for ($i=0; $i < 6; $i++) {
                    if(array_key_exists($i,$value['itemsIcon'])){
                        echo '<img src="'. $value['itemsIcon'][$i].'">';
                    }
                };
                ?>
            </div>
            <img class="ward" src="<?php echo $value['wardIcon']?>" alt="icone de la ward"/>
	</td>

	<td class="info5">
		<?php 
		for ($g=0; $g < 5; $g++) {
			echo "<div>";
			echo $value['summonerNameList'][$g] . '<img src="'. $value['summonerIconList'][$g].'">' . '<img src="'. $value['summonerIconList'][$g+5].'">' . $value['summonerNameList'][$g+5];
			echo "</div>";
		}
		?>
	</td>

    <td class="info6">
        <p>a</p> <!-- FAIRE BOUTON ICI -->
    </td>
</tr>