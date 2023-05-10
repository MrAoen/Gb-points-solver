<?php

require_once ('./Boat.php');

echo '<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="UTF-8">

    <title>Обчислення гандікапного балу човна</title>
</head>
<body>
<script src="./js/jquery-3.1.1.js"></script>
<script src="./js/svg.js"></script>';

$cBoat = new Boat();
$cBoat->Name = 'Сферичний човен у морі';

foreach ($cBoat->sails as $key=>$val){
    echo '<div>'.$cBoat->sails[$key]->getTemplate().'</div>';
}


