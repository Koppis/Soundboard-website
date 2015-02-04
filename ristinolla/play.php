<?php

require_once("myRistiDatabase.php");


$id = $_POST['id'];

$x = intval($_POST['x']);
$y = intval($_POST['y']);


$db = new myRistiDatabase();

$result = $db->query("SELECT board,p2,p1,turn FROM data WHERE (p1 = '$id' OR p2 = '$id')")[0];
$sign = "";
if (intval($result['turn']) % 2 == 0  && $result['p2'] == $id) {
    $sign = 'O';
}
if (intval($result['turn']) % 2 == 1  && $result['p1'] == $id) {
    $sign = 'X';
}
if ($sign != "") {



    $JSON = $result['board'];

    $board = json_decode($JSON,true);
    if (empty($board[$x][$y])) {
        $board[$x][$y] = $sign;

        $JSON = json_encode($board, JSON_NUMERIC_CHECK);

        $db->exec("UPDATE data SET board = '$JSON', turn = turn + 1 WHERE (p1 = '$id' OR p2 = '$id')");
    }

}