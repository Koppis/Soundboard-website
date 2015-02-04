<html>

<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="../jquery-ui/jquery-ui.min.css">

    <script src="../jquery-1.11.1.min.js"></script>
	<script src="../jquery-ui/jquery-ui.min.js"></script>
	<script src="../jquery.cookie.js"></script>
	<script type="text/javascript" src="ristinolla.js"></script>
</head>

<body>
<table>
<tr>
<td style="width:250px"> Sidebar <div id="gamestatus">Searching for opponent...</div> <button id="quitgame">SURRENDER</button></td>
<td> Gameboard 
<table id="board" cellspacing="0"><?php

for ($i=0;$i<40;$i++) {
    echo("<tr>");
    for ($j=0;$j<40;$j++) {
        echo('<td><button class="ruutu" style="width:20px;height:20px;padding:0"></button></td>');
    }
    echo("</tr>");
}
?>
</td>
</tr>
</table>
</table>
</body>

</html>
