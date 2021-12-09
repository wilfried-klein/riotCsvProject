<main>
    <div class="top">
        <div class="summonerInfo">
            <img src="<?php echo $summonerIcon?>" alt="logo de l'invocateur"/>
            <span id="lvl"><?php echo $summonerLevel ?></span>
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
                <div class="stat">
                    <img src="img/KILLS.jpg" alt="img kill">
                    <p>Nombres de kills : <?php echo $average['averageKills'] ?> </p>
                </div>
                <div class="stat">
                    <img src="img/DEATH.png" alt="img mort">
                    <p>Nombres de morts : <?php echo $average['averageDeaths'] ?> </p>
                </div>
                <div class="stat">
                    <img src="img/WARD.jpg" alt="img ward">
                    <p>Score de vision : <?php echo $average['averageVision'] ?> </p>
                </div>
                <div class="stat">
                    <img src="img/GOLD.png" alt="img gold">
                    <p>Nombre de golds : <?php echo $average['averageGolds'] ?> </p>
                </div>
                <div class="stat">
                    <img src="img/TIME.jpg" alt="img time">
                    <p>Durée : <?php echo $average['averageDuration'] ?> </p>
                </div>
                <div class="stat">
                    <img src="img/ROLE.png" alt="img role">
                    <p>Rôle préféré : <?php echo  $favoriteRole; ?> </p>


                </div>
            </div>
            <div id="separateurLeftSide"></div>
            <div class="csvDownloader">
                <h2>Exporte tes données en CSV ici:</h2>
                <form id='formCsv' name='formCsv' method="get" action="index.php" >
                    <fieldset>
                        <select name="gameNumber" id="game_number">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                        </select required>
                        <select name="queue" id="game_number">
                            <option value="420">SoloQ</option>
                            <option value="440">FlexQ</option>
                            <option value="400">Normal Draft</option>
                            <option value="450">ARAM</option>
                        </select required>
                    </fieldset>
                    <input type="hidden" name="action" value="getCsv">
                    <input type="hidden" name="summonerPuuid" value="<?php echo $summonerPuuid ?>">
                    <input type="hidden" name="region" value="europe">
                    <input class="downloaderCsvImage" type="image" name="submit" src="img/telecharger.png" alt="img bouton telecharger" />
                </form>
            </div>
        </div>
        <div class="main">
            <div class="allInfos">
                <div class="lastGameInfo">
                    <table>
                        <?php
                        $kdapergame = array();
                        foreach ($result as $value) {
                            require 'match.php';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="separateurBas"></div>
        <h1 id="titre-graphs"> Graphiques :</h1>
        <div class="graphs">
            <div class="graphique1">
                <canvas id="graph1"></canvas>
                <?php require_once File::build_path(array("view","graph", "graph1.php")); ?>
            </div>
            <div class="graphique2">
                <canvas id="graph2"></canvas>
                <?php require_once File::build_path(array("view","graph", "graph2.php")); ?>
            </div>
            <div class="graphique3">
                <canvas id="graph3"></canvas>
                <?php require_once File::build_path(array("view","graph", "graph3.php")); ?>
            </div>
            <div class="graphique4">
                <canvas id="graph4"></canvas>
                <?php require_once File::build_path(array("view","graph", "graph4.php")); ?>
            </div>
            <div class="graphique5">
                <canvas id="graph5"></canvas>
                <?php require_once File::build_path(array("view","graph", "graph5.php")); ?>
            </div>
        </div>
    </div>
</main>
