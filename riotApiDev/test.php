<?php
	$list = array(
	'assists' => 'Assistances',
	'baronKills' => 'Baron nashor tué',
	'bountyLevel' => 'Niveau de prime d\'élimination maximale',
	'champExperience' => 'Expérience du champion',
	'champLevel' => 'Niveau du champion',
	'championName' => 'Nom du champion',
	'consumablesPurchased' => 'Consommables achetés',
	'damageDealtToBuildings' => 'Dégâts infligés aux batiments',
	'damageDealtToObjectives' => 'Dégâts infligés aux objectifs',
	'damageDealtToTurrets' => 'Dégâts infligés aux tours',
	'damageSelfMitigated' => 'Dégats réduis sur soi',
	'deaths' => 'Morts',
	'detectorWardsPlaced' => 'detectorWardPlaced',
	'doubleKills' => 'Doublé',
	'dragonKills' => 'Dragons tués',
	'firstBloodAssist' => 'Assistance sur le premier sang',
	'firstBloodKill' => 'Premier sang',
	'firstTowerAssist' => 'Assistance destruction première tour',
	'firstTowerKill' => 'Destruction première tour',
	'gameEndedInEarlySurrender' => 'Rédition anticipée',
	'gameEndedInSurrender' => 'Rédition',
	'goldEarned' => 'Or gagné',
	'goldSpent' => 'Or dépensées' ,
	'individualPosition' => 'Poste',
	'inhibitorKills' => 'Inhibiteur détruit',
	'inhibitorsLost' => 'Inhibiteur perdu',
	'item0' => 'Objet 1',
	'item1' => 'Objet 2',
	'item2' => 'Objet 3',
	'item3' => 'Objet 4',
	'item4' => 'Objet 5',
	'item5' => 'Objet 6',
	'item6' => 'Relique',
	'itemsPurchased' => 'Objets achetés',
	'killingSprees' => 'Série d\'éliminations',
	'kills' => 'Éliminations',
	'lane' => 'Voie',
	'largestCriticalStrike' => 'Coup critique maximale',
	'largestKillingSpree' => 'Plus grosse série d\'éliminations',
	'largestMultiKill' => 'Plus grosse élimination multiple',
	'longestTimeSpentLiving' => 'Temps le plus long en vie',
	'magicDamageDealt' => 'Dégâts magiques infligés',
	'magicDamageDealtToChampions' => 'Dégâts magiques aux champions',
	'magicDamageTaken' => 'Dégâts magiques subis',
	'neutralMinionsKilled' => 'Monstres tués',
	'nexusKills' => 'Destruction du nexus',
	'nexusLost' => 'Nexus perdu',
	'objectivesStolen' => 'Objectifs volés',
	'objectivesStolenAssists' => 'Assistance sur un objectif volé',
	'pentaKills' => 'Quintuplé',
	'physicalDamageDealt' => 'Dégâts physiques infligés',
	'physicalDamageDealtToChampions' => 'Dégâts physiques aux champions',
	'physicalDamageTaken' => 'Dégâts physiques subis',
	'quadraKills' => 'Quadruplé',
	'role' => 'Rôle',
	'spell1Casts' => 'Sort 1 lancé',
	'spell2Casts' => 'Sort 2 lancé',
	'spell3Casts' => 'Sort 3 lancé',
	'spell4Casts' => 'Sort 4 lancé',
	'summoner1Casts' => 'Sort d\'invocateur 1 lancé',
	'summoner1Id' => 'Id sort d\invocateur 1',
	'summoner2Casts' => 'Sort d\'invocateur 2 lancé',
	'summoner2Id' => 'Id sort d\invocateur 2',
	'summonerLevel' => 'Niveau d\'invocateur',
	'summonerName' => 'Nom d\'invocateur',
	'teamEarlySurrendered' => 'Rédition anticipée de l\'équipe',
	'teamPosition' => 'Rôle d\'équipe',
	'timeCCingOthers' => 'Score de contrôle de foule',
	'timePlayed' => 'Temps de jeu',
	'totalDamageDealt' => 'Dégats totaux infligés',
	'totalDamageDealtToChampions' => 'Dégats totaux aux champions',
	'totalDamageShieldedOnTeammates' => 'Dégats réduit par les boucliers',
	'totalDamageTaken' => 'Dégats totaux subis',
	'totalHeal' => 'Soin totaux',
	'totalHealsOnTeammates' => 'Total des soins sur les alliés',
	'totalMinionsKilled' => 'Sbires tué',
	'totalTimeCCDealt' => 'Durée total des contrôles de foules',
	'totalTimeSpentDead' => 'Total du temps passé mort',
	'totalUnitsHealed' => 'Alliés soignés',
	'tripleKills' => 'Triplé',
	'trueDamageDealt' => 'Dégats brut infligés',
	'trueDamageDealtToChampions' => 'Dégats brut totaux aux champions',
	'trueDamageTaken' => 'Dégats brut subis',
	'turretKills' => 'Tourelles Détruits',
	'turretsLost' => 'Tours perdus',
	'unrealKills' => 'Éliminations multiple',
	'visionScore' => 'Score de vision',
	'visionWardsBoughtInGame' => 'Balise de contrôle achetés',
	'wardsKilled' => 'Balise détruite',
	'wardsPlaced' => 'Balise placée',
	'win' => 'Victoire', 
	'matchId' => 'matchId',
	'gameDuration' => 'Durée de la partie',
	'gameStartTimestamp' => 'Unix timestamp du début de la partie',
	'gameEndTimestamp' => 'Unix timestamp de la fin de la partie'
);

file_put_contents('list.json', json_encode($list));
?>