<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="img/logo-site2.png" />
</head>
<body>
    <header>
        <a href="index.php?action=formulaire"><img src="img/logo_lol.png" alt="logo de lol"></a>
        <div id="bordureLogo"></div>
    </header>
    <?php
        $filepath = File::build_path(array("view", $controller, "$view.php"));
        require $filepath;
    ?>
<footer>

</footer>
</body>
</html>
