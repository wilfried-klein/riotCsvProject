<html lang="fr">
<head>
	<meta charset="utf-8" />
	<title>Data Displayer</title>
</head>

<body>
	<h2>Player's Game Stats</h2>
	<table>
		<?php
		foreach ($playerMatchData as $key => $value) {
			if(gettype($value) != 'array'){
				echo '<tr>';
				echo '<th>';
				echo $key;
				echo '</th>';
				echo '<th>';
				echo $value;
				echo '</th>';
			}
		}
		?>
	</table>
</body>
</html>