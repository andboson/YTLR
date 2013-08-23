<?php
function youtubeData($ido){
global $ids;
$content = file_get_contents("http://www.youtube.com/watch?v=".$ido);
 preg_match('~\"t\":\s*\"([^\"]*)\"~',$content,$videoTicketMatches);
	$ticket=$videoTicketMatches[1];
 preg_match("/\"fmt_url_map\":\s*\"([^\"]*)\"/",$content,$formatmatches);
 $videoFormats=($formatmatches!=null)?$formatmatches[1]:"";
 $sep1="%2C";
 $sep2="%7C";
  if (stripos($videoFormats,",")>-1) { // new UI
    $sep1=",";
    $sep2="|";
  }
  $videoFile="";
  $vfmt=Array();
  $videoFormatsGroup=explode($sep1,$videoFormats);
  for ($i=0;$i<count($videoFormatsGroup);$i++){
    $videoFormatsElem=explode($sep2,$videoFormatsGroup[$i]);
  	$videoUrl=preg_replace("~\\\/~", "/", $videoFormatsElem[1]);
switch($videoFormatsElem[0]){
  case "18":
 		if (!in_array(35, $vfmt)) $videoFile.= '<a href="'.$videoUrl.'" vod>[view]</a>';
 		$vfmt[]=18;
		$ids[]=$videoUrl;
 		break;
 case "35":
 		if (!in_array(18, $vfmt)) $videoFile.= '<a href="'.$videoUrl.'" vod>[view]</a>';
 		$vfmt[]=35;
 		break;
 case "22":
 		$videoFile.= '<a href="'.$videoUrl.'" vod>[view in 720p]</a>';
 		break;
 case "37":
 		$videoFile.= '<a href="'.$videoUrl.'" vod>[view in 1080p]</a>';
 		break;
 default:
    //$videoFile.= '<a href="http://youtube.com/get_video?video_id='.$ido.'&t='. $ticket.'&asv=&fmt=18" vod>[view]</a>';
 }
 }
return $videoFile;
}

////////////////////////////////  viewCount
//$xml = simplexml_load_file('http://gdata.youtube.com/feeds/api/videos?vq=sand&search_sort=video_avg_rating&racy=include&max-results=5');
//////////////////////////////////////

function echoVideoList($searchstring)
{   global $files,$ids;
	$output='<table cellspacing=0>';
    $output.='<tbody width="100%">';
    $plurl="?plist=yes&ids=";
    $files=Array();

$xml = simplexml_load_file($searchstring);
$result=$xml->entry;

 foreach ($result as $entry) {
	$i++;
 	$VideoId=substr($entry->id,42);
 	$Title=$entry->title;

 	 $media = $entry->children('http://search.yahoo.com/mrss/');
 	 $attrs = $media->group->thumbnail->attributes();
     $Thumnail= $attrs['url'][0];

      // get feed URL for related videos
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.related']");
      if (count($nodeset) > 0) $relatedURL = $nodeset[0]['href'];

     $yt = $media->children('http://gdata.youtube.com/schemas/2007');
     $attrs = $yt->duration->attributes();
     $seconds = (double)$attrs['seconds'];
     $time_m=floor($seconds/60);
     $time_s =fmod($seconds,60);

     $Time=$time_m.":".$time_s;

     $yt=$entry->children('http://gdata.youtube.com/schemas/2007');
     $attrs = $yt->statistics->attributes();
     $viewCount = $attrs['viewCount'];
     $gd = $entry->children('http://schemas.google.com/g/2005');

      if ($gd->rating) {
        $attrs = $gd->rating->attributes();
        $rating = sprintf("%01.2f", $attrs['average']);
      } else {
        $rating = 0;
      }
     $url=youtubeData($VideoId);
     if (strlen($url)<3) continue;
     $plurl.=$VideoId.":";
     $relurl="[<a href='index.php?rel=yes&vid=".$VideoId."'>related</a>]";
       $output.=<<<END
        <tr >
        <td width="150px"><img src="${Thumnail}"/></td>
        <td width="500px" >
        ${Title}&nbsp;(${Time})
        <p class="videoDescription">
            <h3>${url}${relurl}</h3>
            Views:&nbsp;${viewCount}&nbsp;&nbsp;Rating:&nbsp;${rating}
        </td>
        </tr>
        <tr><td colspan=2><hr style="border-color:#007F0E;"></td></tr>
END;
    }
    $output.='</table>';
	echo "<h4><center><a href=\"playlist.jsp\" vod=\"playlist\" >[Play all on this Page]</a></center></h4></br></br>";
	echo $output;
	echo "<h4><center><a href=\"playlist.jsp\" vod=\"playlist\" >[Play all on this Page]</a></center></h4></br></br>";

//////////save playlist
   	if (!$handle = fopen("playlist.jsp", 'w+')) {
         echo "unable to open file for write";
         exit;
    }
   foreach ($ids as $id){
    // $url=youtubeDatalist($id);
    if(strlen($id)>3) $w=$id."|0|0|".$id."|\n\r\n";
        if (fwrite($handle, $w) === FALSE) {
        echo "unable write";
        exit;
    }
   }
  fclose($handle);
//////// end save playlist
}
//http://www.ibm.com/developerworks/xml/library/x-youtubeapi/
//error_reporting(E_ALL);
?>