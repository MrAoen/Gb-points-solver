<?php
/**
 * Created by PhpStorm.
 * User: aoen
 * Date: 14.02.17
 * Time: 10:56
 */

function init_page()
{
    $MR_elements = array(
        'MR_GrevNumber' => 0,
        'MR_crewWeight' => 0,
        'MR_Weight' => 0,
        'MR_Length' => 0,
        'MR_Machta_PPD' => 0,
        'MR_Machta_PRD' => 0,
        'MR_Liktros' => 0,
        'MR_Grot_P' => 0,
        'MR_Grot_B' => 0,
        'MR_Grot_E' => 0,
        'MR_Grot_HP' => 0,
        'MR_Grot_HB' => 0,
        'MR_Grot_HE' => 0,
        'MR_Grot_VLM' => 0,
        'MR_Staksel_P' => 0,
        'MR_Staksel_B' => 0,
        'MR_Staksel_E' => 0,
        'MR_Staksel_HP' => 0,
        'MR_Staksel_HB' => 0,
        'MR_Staksel_HE' => 0,
        'MR_Staksel_VLM' => 0,
        'MR_Kliver_P' => 0,
        'MR_Kliver_B' => 0,
        'MR_Kliver_E' => 0,
        'MR_Kliver_HP' => 0,
        'MR_Kliver_HB' => 0,
        'MR_Kliver_HE' => 0,
        'MR_Kliver_VLM' => 0,
        'MR_Spinaker_P' => 0,
        'MR_Spinaker_B' => 0,
        'MR_Spinaker_E' => 0,
        'MR_Spinaker_SMW' => 0
    );

    $Gb_elements = array(
        'MR_Area_Grot' => 0,
        'MR_Area_Staksel' => 0,
        'MR_Area_Kliver' => 0,
        'MR_Area_Spinaker' => 0,
        'MR_Spinaker_SMW_E' => 0,
        'MR_Main_Sail' => 0,
        'MR_Spinaker_MainSail' => 0,
        'MR_GB' => 0,
        'MR_GB_Spinaker' => 0,
        'MR_GB_CrewWeight' => 0,
        'MR_GB_CrewWeight_Spinaker' => 0
    );


    echo '<!DOCTYPE html>' .
        '<html lang="uk">' .
        '<head>
    <meta charset="UTF-8">
    <script src="./js/jquery-3.1.1.js"></script>
    <script src="./js/main.js"></script>
    <link rel="stylesheet" type="text/css" href="./js/main.css">
    <title>Розрахунок гандікапа вітрильних човнів</title>
</head>
<body>' .
        buildTable($MR_elements)
        . '<button type="submit">Розрахувати<button/>"'
        . '</body>
</html>';
}

function buildTable($array)
{

    $result = '<table>';
    foreach ($array as $key => $val) {
        $result .= '<tr>' .
            '<th>' . $key . '</th>' .
            '<th><input name="' . $key . '"/>' . $val . '</th>'
            . '</tr>';
    }
    $result .= '</table>';
    return $result;
}
