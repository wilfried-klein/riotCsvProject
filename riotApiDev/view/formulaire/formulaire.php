<main>
    <form method="get" action="index.php">
        <fieldset>
            <label for="summonerName_id"> Entre ton nom d'invocateur : </label>
            <input type="text" placeholder="ex: Faker" name="summonerName" id="summonerName_id" required/>
            <input type="hidden" name="action" value="profile">
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