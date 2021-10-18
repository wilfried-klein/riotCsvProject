<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?php
        if ($controller=='formulaire') {
            echo '<link rel="stylesheet" type="text/css" href="css/styleFrom.css">';
        }else{
            echo'<link rel="stylesheet" type="text/css" href="css/style.css">';
        }
    ?>
    <link rel="icon" type="image/png" href="img/logo-site2.png" />
</head>
<body>
    <header>
        <?php
            if ($controller=='formulaire') {
                echo '<a href="index.php?action=formulaire"><img src="img/logo_lol.png" alt="logo de lol"></a>';
                echo'<div id="bordureLogo"></div>';
            }else{
                $filepath = File::build_path(array("view", "profile", "headerProfile.php"));
                require $filepath;
            }
        ?>
    </header>
    <?php
        $filepath = File::build_path(array("view", $controller, "$view.php"));
        require $filepath;
    ?>
    <footer>

    </footer>
</body>
</html>