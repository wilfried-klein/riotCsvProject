<?php
header('Content-Type: text/csv Content-Disposition: attachment; filename="test.csv"');
header('Content-Disposition: attachment; filename="gameData.csv"');
echo $csvContent;
?>