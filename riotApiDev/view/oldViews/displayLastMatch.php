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
                            <h2>Dernière Partie :</h2>
                            champion :
                            <?php
                            echo $championName;
                            echo '<img src="data:image/jpeg;base64,'.$championIcon.'"style="width:75px;height:75px;">';
                            echo "<br>";
                            echo "<p>Objet de la partie :</p>";
                            echo "<table>";
                            for ($i=0; $i < 7; $i++) {
                                if(array_key_exists($i, $itemsIcon)){
                                    echo "<td>";
                                    echo '<img src="data:image/jpeg;base64,'.$itemsIcon[$i].'">';
                                    echo "<td>";
                                }
                            }
                            echo "</table>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>

        </footer>
    </body>
</html>