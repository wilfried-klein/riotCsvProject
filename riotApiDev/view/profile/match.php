<tr>
    <td class="info1">
        <div class="winOrLoose">
            <?php
            if($value['result'] == true){
                echo '<img src="img/Victory.png" alt="img victoire">';
            }else{
                echo '<img src="img/Defeat.png" alt="img defaite">';
            }
            ?>
        </div>
        <div class="info1Global">
            <div class="champEtSort">
                <div class="champ">
                    <img src="<?php echo $value['championIcon']?>" alt="<?php echo $value['championName'] ?>"/>
                    <p><?php echo $value['championName'];?></p>
                </div>
                <div class="summonerSpell">
                    <img src="<?php echo $value['summonerSpell1']?>" alt="img sort invocateur 1"/>
                    <img src="<?php echo $value['summonerSpell2']?>" alt="img sort invocateur 2"/>
                </div>
            </div>
            <div class="runes">
                <img class="primaryRune" src="<?php echo $value['rune1Icon']?>" alt="img rune 1"/>
                <img class="secondaryRune" src="<?php echo $value['rune2Icon']?>" alt="img rune 2"/>
            </div>
        </div>
    </td>

    <td class="info2">
        <p> <?php //echo $value['gameDurationMin'] . " Min " . $value['gameDurationSeconde']
            echo $value['gameDurationMinAndSec'] ?> </p>
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
                    echo '<img src="'. $value['itemsIcon'][$i].'" alt="img objet">';
                }
            };
            ?>
        </div>
        <img class="ward" src="<?php echo $value['wardIcon']?>" alt="icone de la ward"/>
    </td>

    <td class="info5">
        <div class="equipe1">
            <?php
            for ($g=0; $g < 5; $g++) {
                echo '<a href="index.php?action=profile&server=euw1&summonerName=' . $value['summonerNameList'][$g] . '"><div class="equipeDiv">';
                echo '<p class="summonerName">' . $value['summonerNameList'][$g] . '</p>' . '<img src="'. $value['summonerIconList'][$g].'" alt="icone du summoner">';
                echo "</div></a>";
            }
            ?>
        </div>
        <div class="equipe2">
            <?php
            for ($g=0; $g < 5; $g++) {
                echo '<a href="index.php?action=profile&server=euw1&summonerName=' . $value['summonerNameList'][$g+5] . '"><div class="equipeDiv">';
                echo '<img src="'. $value['summonerIconList'][$g+5] .'" alt="icone du summoner">' . '<p class="summonerName">' . $value['summonerNameList'][$g+5] . '</p>' ;
                echo "</div></a>";
            }
            ?>
        </div>
    </td>

    <td class="info6">
        <form id='formCsv1' name='formCsv1' method="get" action="index.php" >
            <div class="style7">
                <input type="hidden" name="action" value="getCsv">
                <input type="hidden" name="matchId" value="<?php echo $value['matchId'] ?>">
                <input type="hidden" name="summonerName" value="<?php echo $summonerName ?>">
                <input type="hidden" name="server" value="<?php echo $server ?>">
                <input class="downloaderCsvImage" type="image" name="submit" src="img/telecharger.png" alt="img bouton telecharger" />
            </div>
        </form>
    </td>
</tr>