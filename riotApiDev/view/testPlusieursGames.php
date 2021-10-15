<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Résultat de la dernière partie</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../controller/css/style.css">
    <link rel="icon" type="image/png" href="../controller/img/logo-site2.png" />
</head>

<body>
    <header>
        <img src="../controller/img/logo_lol.png" alt="logo de lol">
        <div id="bordureLogo"></div>
    </header>
    <main>
        <div class="top">
            <div class="summonerInfo">
                <?php echo '<img src="data:image/jpeg;base64,'.$summonerIcon.'"style="width:100px;height:100px;">'; ?>
                <p id="summonerName"><?php echo $summonerName ?></p>
            </div>
        </div>
        <div class="middle">
            <div class="leftSide">
                <div class="rankInfo">
                    <?php echo '<img src="data:image/jpeg;base64,'.$rankedEmblems.'"style="width:100px;height:100px;">'; ?>
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
                        <?php
                        foreach ($Matches10 as $value){
                            if($value['result'] == true){
                                echo '<h3 style="color: #1217C0;">VICTOIRE</h3>';
                            }else{
                                echo '<h3 style="color: #C01712;">DÉFAITE</h3>';
                            }
                            echo "champion :";
                            echo $value['championName'];
                            echo '<img src="data:image/jpeg;base64,'. $value['championIcon'].'"style="width:75px;height:75px;">';
                            echo "<br>";
                            echo "<p>Objet de la partie :</p>";
                            echo "<table>";
                            for($j=0; $j<7; $j++){
                                if(array_key_exists($j, $value)){
                                    echo "<td>";
                                    echo '<img src="data:image/jpeg;base64,'.$value[$j].'">';
                                    echo "<td>";
                                }
                            }
                            echo "</table>";
                        }
                        ?>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>
</html>