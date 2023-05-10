<?php
/**
 * Created by PhpStorm.
 * User: aoen
 * Date: 15.02.17
 * Time: 15:48
 */
require_once __DIR__.'/Boat.php';

$Bob = new Boat();

$Bob->Name='Росич';
$Bob->SailNumber='UKR 05';
$Bob->mast->D=0.05;
$Bob->mast->D1=0.05;
$Bob->mast->d=0.01;

$Bob->AL=4.5;
$Bob->WC=85;
$Bob->WS=55;

//Main
$Bob->sails['Main']->P=5.16;
$Bob->sails['Main']->B=4.68;
$Bob->sails['Main']->E=1.82;
$Bob->sails['Main']->HP=0.05;
$Bob->sails['Main']->HB=0.85;
$Bob->sails['Main']->HE=0.05;
$Bob->sails['Main']->VLM=5.16;

//Jib
$Bob->sails['Jib']->P=0;
$Bob->sails['Jib']->B=0;
$Bob->sails['Jib']->E=0;
$Bob->sails['Jib']->HP=0;
$Bob->sails['Jib']->HB=0;
$Bob->sails['Jib']->HE=0;
$Bob->sails['Jib']->VLM=0;

//Spinaker
$Bob->sails['Spinaker']->P=4.2;
$Bob->sails['Spinaker']->B=4.2;
$Bob->sails['Spinaker']->E=2.92;
$Bob->sails['Spinaker']->HP=0;
$Bob->sails['Spinaker']->HB=0;
$Bob->sails['Spinaker']->HE=0;
$Bob->sails['Spinaker']->VLM=3.3;

echo 'Bob='.$Bob->solveGB();

echo PHP_EOL;

$N9 = new Boat();

$N9->Name='L&K';
$N9->SailNumber='N9';
$N9->mast->D=0.06;
$N9->mast->D1=0.085;
$N9->mast->d=0.012;

$N9->AL=5.7;
$N9->WC=145;
$N9->WS=130;

//Main
$N9->sails['Main']->P=5.6;
$N9->sails['Main']->B=5.87;
$N9->sails['Main']->E=1.75;
$N9->sails['Main']->HP=0.0;
$N9->sails['Main']->HB=0.78;
$N9->sails['Main']->HE=0.05;
$N9->sails['Main']->VLM=5.6;

//Jib
$N9->sails['Jib']->P=3.48;
$N9->sails['Jib']->B=3.28;
$N9->sails['Jib']->E=1.06;
$N9->sails['Jib']->HP=0;
$N9->sails['Jib']->HB=-0.04;
$N9->sails['Jib']->HE=0.05;
$N9->sails['Jib']->VLM=3.34;

//Spinaker
$N9->sails['Spinaker']->P=5.9;
$N9->sails['Spinaker']->B=5.3;
$N9->sails['Spinaker']->E=2.6;
$N9->sails['Spinaker']->HP=0;
$N9->sails['Spinaker']->HB=0;
$N9->sails['Spinaker']->HE=0;
$N9->sails['Spinaker']->VLM=0;

echo 'N9='.$N9->solveGB();
