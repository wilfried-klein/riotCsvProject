<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Résultat de la dernière partie</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href="../controller/css/style.css">
    <link rel="icon" type="image/png" href="../controller/img/logo-site2.png" />
</head>

<body>
    <header>
        <a href="../view/formLastTenMatchs.php"><img src="../controller/img/logo_lol.png" alt="logo de lol"></a>
        <form method="post" action="../controller/controllerLast10GamesInfo.php">
            <fieldset>
                <label for="summonerName_id"></label>
                <input type="text" placeholder="ex: Faker" name="summonerName" id="summonerName_id" required/>
                <label for="server_id"> </label>
                <select name="server" id="server_id">
                    <option value="br1">BR</option>
                    <option value="eun1">EUNE</option>
                    <option value="euw1" selected>EUW</option>
                    <option value="jp1">JP</option>
                    <option value="kr">KR</option>
                    <option value="la1">LAN</option>
                    <option value="la2">LAS</option>
                    <option value="na1">NA</option>
                    <option value="oc1">OCE</option>
                    <option value="ru">RU</option>
                    <option value="tr1">TR</option>
                </select>
            </fieldset>
            <input type="submit" value="Envoyer" class="bouton">
        </form>
        <div id="bordureLogo"></div>
    </header>
    <main>
        <div class="top">
            <div class="summonerInfo">
                <?php echo '<img src="'.$summonerIcon.'">'; ?>
                <p id="summonerName"><?php echo $summonerName ?></p>
            </div>
        </div>
        <div class="middle">
            <div class="leftSide">
                <div class="rankInfo">
                    <?php echo '<img src="'.$rankedEmblems.'">'; ?>
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
                <div class="allInfos">
                    <div class="lastGameInfo">
                        <table>
                        <?php
                            foreach ($result as $value) {
                                echo "<tr>";
                                echo "<td>";
                                if($value['result'] == true){
                                    echo '<h3 style="color: #1217C0;">VICTOIRE</h3>';
                                }else{
                                    echo '<h3 style="color: #C01712;">DÉFAITE</h3>';
                                }
                                echo "<div>";
                                    echo '<img src="'. $value['championIcon'].'">';
                                    echo "<div>";
                                        echo '<img src="'. $value['summonerSpell1'].'">';
                                        echo '<img src="'. $value['summonerSpell2'].'">';
                                    echo "</div>";
                                echo "</div>";
                                echo "<div>";
                                    echo $value['championName'];
                                    echo '<img src="'. $value['rune1Icon'].'">';
                                    echo '<img src="'. $value['rune2Icon'].'">';
                                echo "</div>";
                                echo "</td>";
                                echo "<td>";
                                    echo round($value['gameDuration']/60) . " Min " . $value['gameDuration']%60;
                                    echo $value['matchType'];
                                    echo "Le " . $value['matchDate']['mday'] . "/" . $value['matchDate']['mon'] . "/" . $value['matchDate']['year'];
                                echo "</td>";
                                echo "<td>";
                                    echo $value['kills'] . "/" . $value['deaths'] . $value['assists'] ; 
                                    echo $value['creepScore'] . " CS";
                                    echo "Score de vision : " . $value['visionScore'];
                                echo "</td>";
                                echo "<td>";
                                    for ($i=0; $i < 7; $i++) {
                                        if(array_key_exists($i,$value['itemsIcon'])){
                                            echo '<img src="'. $value['itemsIcon'][$i].'">';
                                        }
                                        
                                    };
                                echo "</td>";
                                echo "<td>";
                                    for ($g=0; $g < 5; $g++) { 
                                        echo "<div>";
                                            echo $value['summonerNameList'][$g] . '<img src="'. $value['summonerIconList'][$g].'">' . '<img src="'. $value['summonerIconList'][$g+5].'">' . $value['summonerNameList'][$g+5];
                                        echo "</div>";
                                    }
                                echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>
</html>