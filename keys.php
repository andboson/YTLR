<form action="index.php" method="GET" id="frm" name="frm">
    <input type="hidden" id="hdn" name="q" value="">
    <input type="hidden" id="maxResults" name="maxResults" value="<?=$maxResults?>">
    <table width="400px;" cellspacing="0" cellpadding="9"><tr>
            <td width="310px" height="40" background="img/2search.jpg" style="background-repeat:no-repeat;" padding="3px;"><p id="stitle" >&nbsp;</p></td><td align="left"><input type="image" src="img/btn.jpg" align="top"></td>
        </tr></table>
</form>

<?php
$wordsTxt = file_get_contents('hystory.txt');
$words =  array();

if(!empty($wordsTxt)) {
    $words = json_decode($wordsTxt, true);
    echo "<p>";
    foreach ($words as $word) {
        echo "<a class='hist' href=\"#\" onclick=\"stype('$word');\">$word</a>&nbsp;&nbsp;&nbsp;";
    }
    echo "</p>";
}

$new = $_GET['q'];
$words[] = $new;
$newWords = empty($words) ? array() : array_unique($words);
$newWords = array_slice($newWords, 0, 10);
file_put_contents('hystory.txt', json_encode($newWords));
?>

<table style="color:#A8BC5E;" cellspacing=0 cellpadding=0>
<tr><td colspan="2">
<a href="#" onclick="stype('1');">1</a>&nbsp;
<a href="#" onclick="stype('2');">2</a>&nbsp;&nbsp;
<a href="#" onclick="stype('3');">3</a>&nbsp;&nbsp;
<a href="#" onclick="stype('4');">4</a>&nbsp;&nbsp;
<a href="#" onclick="stype('5');">5</a>&nbsp;&nbsp;
<a href="#" onclick="stype('6');">6</a>&nbsp;&nbsp;
<a href="#" onclick="stype('7');">7</a>&nbsp;&nbsp;
<a href="#" onclick="stype('8');">8</a>&nbsp;&nbsp;
<a href="#" onclick="stype('9');">9</a>&nbsp;&nbsp;
<a href="#" onclick="stype('0');">0</a>&nbsp;&nbsp;
<!-- <a href="#" onclick="stype(' ');">&laquo;&nbsp;&raquo;</a>&nbsp;&nbsp;  -->
<a href="#" onclick="stype(' ');"><img src="img/space.jpg" border=0 /></a>
<a href="#" onclick="stype('+');">+</a>&nbsp;&nbsp;
<a href="#" onclick="stype('&ndash;');"><img src="img/minus.jpg" border=0 /></a>&nbsp;&nbsp;
<a href="#" onclick="stype('.');"><img src="img/dot.jpg" border=0 /></a>&nbsp;&nbsp;
<a href="#" onclick="stype(',');"><img src="img/coma.jpg" border=0 align="absbottom"/></a>&nbsp;&nbsp;
<a href="#" onclick="stype('!');">!</a>&nbsp;&nbsp;
<a href="#" onclick="stype('?');">?</a>&nbsp;&nbsp;
<a href="#" onclick="stype('&quot;');">&quot;</a>&nbsp;
&nbsp;&nbsp;<a style="font-size:20px;font-weight:bold;" href="#" onclick="dele();" TVID="CLEAR">&lt;</a>&nbsp;
&nbsp;&nbsp;<a style="font-size:20px;font-weight:bold;" href="#" onclick="document.getElementById('stitle').firstChild.nodeValue=' ';"><<</a>&nbsp;
<!-- &nbsp;&nbsp;<a style="font-size:20px;font-weight:bold;" href="#" onclick="dele();" TVID="CLEAR"><img src="del.jpg" border=0 /></a>&nbsp;
&nbsp;&nbsp;<a style="font-size:20px;font-weight:bold;" href="#" onclick="document.getElementById('stitle').firstChild.nodeValue=' ';"><img src="delall.jpg" border=0 /></a>&nbsp;
-->

</td>
</tr>
<tr>
<td >
<h4>
<!-- <a href="#" onclick="srchthat();">000&nbsp;  -->
<a href="#" onclick="stype('А');">А</a>&nbsp;
<a href="#" onclick="stype('Б');">Б</a>&nbsp;
<a href="#" onclick="stype('B');">В</a>&nbsp;
<a href="#" onclick="stype('Г');">Г</a>&nbsp;
<a href="#" onclick="stype('Д');">Д</a>&nbsp;
<a href="#" onclick="stype('E');">Е</a>&nbsp;
<a href="#" onclick="stype('Ж');">Ж</a>&nbsp;
<a href="#" onclick="stype('З');">З</a>&nbsp;
<a href="#" onclick="stype('И');">И</a>&nbsp;
<a href="#" onclick="stype('К');">К</a>&nbsp;
<a href="#" onclick="stype('Л');">Л</a>
<br>
<a href="#" onclick="stype('М');">М</a>&nbsp;
<a href="#" onclick="stype('Н');">Н</a>&nbsp;
<a href="#" onclick="stype('О');">О</a>&nbsp;
<a href="#" onclick="stype('П');">П</a>&nbsp;
<a href="#" onclick="stype('Р');">Р</a>&nbsp;
<a href="#" onclick="stype('С');">С</a>&nbsp;
<a href="#" onclick="stype('Т');">Т</a>&nbsp;
<a href="#" onclick="stype('У');">У</a>&nbsp;
<a href="#" onclick="stype('Ф');">Ф</a>&nbsp;
<a href="#" onclick="stype('Х');">Х</a>&nbsp;
<a href="#" onclick="stype('Ц');">Ц</a>
<br>
<a href="#" onclick="stype('Ч');">Ч</a>&nbsp;
<a href="#" onclick="stype('Ш');">Ш</a>&nbsp;
<a href="#" onclick="stype('Щ');">Щ</a>&nbsp;
<a href="#" onclick="stype('Й');">Й</a>&nbsp;
<a href="#" onclick="stype('Ы');">Ы</a>&nbsp;
<a href="#" onclick="stype('Ь');">Ь</a>&nbsp;
<a href="#" onclick="stype('Э');">Э</a>&nbsp;
<a href="#" onclick="stype('Ю');">Ю</a>&nbsp;
<a href="#" onclick="stype('Я');">Я</a>
</h4>
</td><td align="left">
<h4>
<!-- <a href="#" onclick="srchthat();">000</a>&nbsp;&nbsp;  -->
&nbsp;&nbsp;&nbsp;<a href="#" onclick="stype('A');" TVID="A">A</a>&nbsp;
<a href="#" onclick="stype('B');">B</a>&nbsp;
<a href="#" onclick="stype('C');">C</a>&nbsp;
<a href="#" onclick="stype('D');">D</a>&nbsp;
<a href="#" onclick="stype('E');">E</a>&nbsp;
<a href="#" onclick="stype('F');">F</a>&nbsp;
<a href="#" onclick="stype('G');">G</a>&nbsp;
<a href="#" onclick="stype('H');">H</a>&nbsp;
<a href="#" onclick="stype('I');">I</a>
<br>
&nbsp;&nbsp;&nbsp;<a href="#" onclick="stype('J');">J</a>&nbsp;
<a href="#" onclick="stype('K');">K</a>&nbsp;
<a href="#" onclick="stype('L');">L</a>&nbsp;
<a href="#" onclick="stype('M');">M</a>&nbsp;
<a href="#" onclick="stype('N');">N</a>&nbsp;
<a href="#" onclick="stype('O');">O</a>&nbsp;
<a href="#" onclick="stype('P');">P</a>&nbsp;
<a href="#" onclick="stype('Q');">Q</a>
<br>
&nbsp;&nbsp;&nbsp;<a href="#" onclick="stype('R');">R</a>&nbsp;
<a href="#" onclick="stype('S');">S</a>&nbsp;
<a href="#" onclick="stype('T');">T</a>&nbsp;
<a href="#" onclick="stype('U');">U</a>&nbsp;
<a href="#" onclick="stype('V');">V</a>&nbsp;
<a href="#" onclick="stype('W');">W</a>&nbsp;
<a href="#" onclick="stype('X');">X</a>&nbsp;
<a href="#" onclick="stype('Y');">Y</a>&nbsp;
<a href="#" onclick="stype('Z');">Z</a>
</h4>
</td><td>
</tr></table>


<script type="text/javascript">
    function stype(x){
        document.getElementById('stitle').firstChild.nodeValue=document.getElementById('stitle').firstChild.nodeValue+x.toString();
        var str=document.getElementById('stitle').firstChild.nodeValue;
        var ln=str.length;
        str=str.substr(1,ln-1);
        document.getElementById('hdn').setAttribute('value',str);
    }

    function dele(){
        var str=document.getElementById('stitle').firstChild.nodeValue;
        var ln=str.length;
        document.getElementById('stitle').firstChild.nodeValue=str.substr(0,ln-1);
    }


    function name(){
        document.getElementById('hdn').setAttribute('value','333333333333333333');
    }

</script>
