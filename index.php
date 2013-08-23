<?php
//////////////////////////////////////////
//                                      //
//  YouTube Lite Reloaded v.0.4.5       //
//  based on Mental idea (NMT forum)    //
//										//
//////////////////////////////////////////
define(ON_PAGE,10);
session_start();
require_once 'funcs.php';
?>
<html>
 <head>
  <meta SYABAS-FULLSCREEN>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>YouTube Lite Reloaded</title>
  <style type="text/css">
  * {color:green}
  a {text-decoration:none;color:green;}
  a:hover {text-decoration:underline}
 .btn {font-size:24px;color:#008000;text-shadow: 0px 1px 0px #e5e5ee;height:35px;width:100px;border:none;background:url('btn.gif') no-repeat -30px -26px;background-attachment:inherit;}
 .srch {width:205px;height:20px;padding:0px;font-size:16;border:1px green solid;margin-left:39px;BACKGROND-COLOR:#B2FFD7}
 .title{width:300px;font-size:20px;color:006B00;font-weight:bold;text-align:center;text-decoration:underline;}
 .title2{width:550px;font-size:15px;color:006B00;font-weight:bold;text-align:center;}
  #stitle{padding:10px;font-size:20px;color:006B00;font-weight:bold;}
  #srchf {height:22px;background:#AECA51;color:white}
  </style>
 </head>
<body marginwidth=20 marginheight=20 border=0 background="img/HJ021.jpg" FOCUSCOLOR="#FF4F38" FOCUSTEXT="#00000" bgcolor="#B2FFD7">
<script type="text/javascript">
function stype(x){
 document.getElementById('stitle').firstChild.nodeValue=document.getElementById('stitle').firstChild.nodeValue+x.toString();
	var str=document.getElementById('stitle').firstChild.nodeValue;
	var ln=str.length;
	str=str.substr(1,ln-1);
//document.getElementById('hdn').setAttribute('value',str);
document.getElementById('srchf').setAttribute('value',str);
}

function dele(){
  var str=document.getElementById('stitle').firstChild.nodeValue;
  var ln=str.length;
  document.getElementById('stitle').firstChild.nodeValue=str.substr(0,ln-1);
  document.getElementById('srchf').setAttribute('value',str);
}

function setval(){
	  var str=document.getElementById('stitle').firstChild.nodeValue;
  document.getElementById('srchf').setAttribute('value',str);
}

function show(){
	var str=document.getElementById('srchf').value;
	document.getElementById('stitle').firstChild.nodeValue=str;
	}
</script>
<center><h1 class="title" id="title"><a href="http://andboson.net/yt/">YouTube Lite Reloaded</a></h1></center>
<center><h2 class="title2">Finds video in default, 720p and 1080p. Onscreen keyboard. Play all on page</h2></center>
<form action="index.php" method="GET" id="frm" name="frm">
<input type="hidden" id="hdn" name="hdn" value="">
<table width="400px;" cellspacing="0" cellpadding="9"><tr>
<td width="310px" height="40" background="img/2search.jpg" style="background-repeat:no-repeat;" padding="3px;"><p id="stitle">&nbsp;</p></td><td align="left"><input type="image" src="img/btn.jpg" align="top"></td>
</tr><tr><td colspan="2"><input type="text" size="22" id="srchf" name="srchf" onkeypress="show();" onclick="show();" onchange="show();">&nbsp;&nbsp;<b>< keyboard input</b></td></tr></table>
</form>
<?php
include('keys.php');
    if ($_GET['rel']=="yes") {
       $vid=$_GET['vid'];
    	$searchstring='http://gdata.youtube.com/feeds/api/videos/'.$vid.'/related';
		echoVideoList($searchstring);
		exit;
		}
$stri=$_GET['hdn'];
if (strlen($stri)<2){
	if(isset($_GET['srchf'])) $stri=$_GET['srchf'];
}
if (strlen($stri)>1) {
 $searchTerm=(str_ireplace(" ","+",$stri));
 $maxResults=ON_PAGE;
	 if (isset($_GET['page'])) {
	 	 if ($_GET['page']=='next') $startIndex=$_GET['index']+ON_PAGE;
	  	 if ($_GET['page']=='prev') $startIndex=$_GET['index']-ON_PAGE;
	 } else  {
	 		$startIndex=1;
	 		}

 	$index=$startIndex;
	echo "<br><h4><center><a href='?hdn=".$searchTerm."&page=prev&index=".$index."'>[prev]</a>&nbsp;&nbsp;|&nbsp;<a href='?hdn=".$searchTerm."&page=next&index=".$index."'>[next]</a></center></h4>";
   	$searchstring='http://gdata.youtube.com/feeds/api/videos?vq='.$searchTerm.'&search_sort=viewCount&racy=include&max-results='.$maxResults.'&start-index='.$startIndex;  ?>
    <table width=100%>
    <tr><td>
	<?php echoVideoList($searchstring); ?>
	</td><td>
		</td>
      <!-- keys -->
		</tr>
	</table>

 <?php
	echo "<h4><center><a href='?hdn=".$searchTerm."&page=prev&index=".$index."'>[prev]</a>&nbsp;&nbsp;|&nbsp;<a href='?hdn=".$searchTerm."&page=next&index=".$index."'>[next]</a></center></h4>";
}
?>
</body>
</html>