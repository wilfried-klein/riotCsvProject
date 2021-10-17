<!DOCTYPE html>
<html lang="fr">

    <head>
        <title>Data Displayer</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../controller/css/styleFrom.css">
        <link rel="icon" type="image/png" href="../controller/img/logo-site2.png" />
    </head>

    <body>
        <header>
            <img src="../controller/img/logo_lol.png" alt="logo de lol" >
            <div id="bordureLogo"></div>
        </header>
        <main>
            <h2> Accède à tes stats ici: </h2>
            <form method="post" action="../controller/controllerLast10GamesInfo.php">
                <fieldset>
                    <label for="summonerName_id"> Entre ton nom d'invocateur : </label>
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
        </main>
        <footer>

        </footer>
    </body>
</html>