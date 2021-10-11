<?php
require_once '../model/modelRiotApi.php';

//liste des erreurs pour les getter vers l'API riot la liste est sur le site developer.riotgames.com dans "RESPONSE ERRORS"
//liste des erreurs pour les getter vers DDragon : 404 si le serveur ne répond pas (pas encore arriver) et 403 si les paramètres sont incorrect (l'image ou les données demandés sont introuvables)
//(https://ddragon.leagueoflegends.com/cdn/11.19.1/img/item/456.png <-- renvoie 403)
//https://ddragon.leagueoflegends.com/cdn/11.20.1/img/item/1001.png <-- paramètres correct renvoie 200


//en cas d'erreurs 404 php affiche quand meme une erreur mais celle ci est traité quand meme, il faudra juste desactive l'affichage des erreurs lors de la livraison au client

//vers API Riot
public static function getChampRotationbyServer($server){
	try {
		$retour = modelRiotApi::getChampRotationbyServer($server);
		return $retour;
	} catch (Exception $e) {
		$errorCode = $e->getMessage();
		if($errorCode == "404"){
			$error = "une erreur est survenue lors de la récupération des données"
		}elseif($errorCode == "403"){
			$error = "les argupment passé sont incorect"
		}elseif($errorCode == "429"){
			$error = "Rate Limit exceded" //survient lorsque trop la limite de requetes vers l'api est atteinte, parfois il suffit de relancer la requete
		}elseif($errorCode == "503"){
			$error "le service est temporairement indisponible"
		}
		require '../view/error.php' //affichage de l'erreur
	}
}
//vers DDragon/image
public static function getItemAsset($version, $itemID){
	try {
		$image = modelRiotApi::getRankedEmblems("platinum","OKIBI");
		echo '<img src="data:image/jpeg;base64,'.$image.'">';
	} catch (Exception $e) {
		$errorCode = $e->getMessage();
		if($errorCode == "404"){
			$error = "service indisponible";
		}elseif($errorCode == "403"){
			$errorCode "l'image n'existe pas";
		}
		require '../view/error.php';
	}
}
//pour getRunesAsset 403 n'existe pas