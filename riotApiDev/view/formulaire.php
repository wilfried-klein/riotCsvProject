<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Data Displayer</title>
</head>
<body>
	<h2> Renvoie vos statistiques de votre dernier match </h2>
	<form method="post" action="../controller/controllerTest.php">
		<fieldset>
			<input type="text" placeholder="Nom d'invocateur" name="summonerName" id="summonerName_id" required/>
			<select name="server" id="server_id">
				<option value="br1">BR</option>
				<option value="eun1">EUNE</option>
				<option value="euw1">EUW</option>
				<option value="jp1">JP</option>
				<option value="kr">KR</option>
				<option value="la1">LAN</option>
				<option value="la2">LAS</option>
				<option value="na1">NA</option>
				<option value="oc1">OCE</option>
				<option value="ru">RU</option>
				<option value="tr1">TR</option>
			</select>
			<input type="submit">
		</fieldset> 
	</form>
</body>
</html>