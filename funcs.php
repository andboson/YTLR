<?php

function googleCache($id,$token,$fmt){
	 $ytURL = "http://youtube.com/get_video?video_id=" . $id . "&t=" . $token. "&asv=&fmt=" . $fmt;
//	$ytURL = "http://www.youtube.com/get_video?t=vjVQa1PpcFNqEf7mGOw0Gk9PLbFvsqu0bV2adxLsaKQ=&noflv=1&fmt=34&el=detailpage&video_id=a4D1lIZSck8&asv=3";

	$headers = get_headers($ytURL,1);

//	print_r($headers);
	$status = explode(" ",$headers['1']);
	if($status[1] == "200"){
		if(!is_array($headers['Location'])) {
		$videoURL = $headers['Location'];
		}else{
			foreach($headers['Location'] as $header){
				if(strpos($header,"googlevideo.com") != false){
				$videoURL = $header;
				break;
				}
			}
		}
	return $videoURL;
	}else{
		return "";
	}
}

function youtubeData($ido){
$content = file_get_contents("http://www.youtube.com/watch?v=".$ido);

$one=stripos($content,'length_seconds');
$content=substr($content,$one);
$one2=stripos($content,'">');
parse_str($content);

//$videoFile= '<a href="index.php?mode=getvideo&id='.$id.'&token='.$t.'&fmt=18" vod>[view]</a>';
 // $videoFile="<a href=\"http://youtube.com/get_video?video_id=" . $ido . "&t=" . $t. "&asv=&fmt=18\" vod>[view]</a>";
//	$content = file_get_contents("http://youtube.com/get_video_info?video_id=".$id);
	if($t != ""){
	 $fmts=explode(",",$fmt_map,3);
	 $fmts[0]=substr($fmts[0],0,2);
	 $fmts[1]=substr($fmts[1],0,2);
	 $fmts[2]=substr($fmts[2],0,2);
    if($fmts[0]==37 or $fmts[0]=='37') {
	    if($fmts[2]==35 or $fmts[2]=='35') $videoFile.= '<a href="http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=18" vod>[view]</a>';
	    if($fmts[1]==22 or $fmts[1]=='22') $videoFile.= '<a href="http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=22" vod>[view in 720p]</a>';
	    if($fmts[0]==37  or $fmts[0]=='37') $videoFile.= '<a href="http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=37" vod>[view in 1080p]</a>';
	    return $videoFile;
	    }

    if($fmts[0]==22 or $fmts[0]=='22') {
	    if($fmts[1]==35 or $fmts[1]=='35') $videoFile.= '<a href="http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=18" vod>[view]</a>';
	    if($fmts[0]==22 or $fmts[0]=='22') $videoFile.= '<a href="http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=22" vod>[view in 720p]</a>';
	    return $videoFile;
	    }

    if($fmts[0]==35 or $fmts[0]=='35') $videoFile= '<a href="http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=18" vod>[view]</a>';
     // echo "<br>".$id."=".$fmts[0];

	 if($fmts[0]=='18' or $fmts[0]==18) $videoFile= '<a href="http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=18" vod>[view]</a>';

      if ($fmts[0]=='34' or $fmts[0]==34) {
      	$videoFile="";
      	return $videoFile;
      }
   	}  else if ($status=='failed') {
	$videoFile=""; //str_ireplace('+',' ',$reason);
} else {
	$videoFile= '<a href="http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=18" vod>[view]</a>';
}


return $videoFile;
}

function youtubeDatalist($ido){
$content = file_get_contents("http://www.youtube.com/watch?v=".$ido);
$one=stripos($content,'length_seconds');
$content=substr($content,$one);
$one2=stripos($content,'">');
parse_str($content);


	if($t != ""){
	 $fmts=explode(",",$fmt_map,3);
	 $fmts[0]=substr($fmts[0],0,2);
	 $fmts[1]=substr($fmts[1],0,2);
	 $fmts[2]=substr($fmts[2],0,2);
    if($fmts[0]==37 or $fmts[0]=='37') {
	    if($fmts[1]==22 or $fmts[1]=='22') $videoFile.= 'http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=22';
	    return $videoFile;
	    }

    if($fmts[0]==22 or $fmts[0]=='22') {
	    if($fmts[0]==22 or $fmts[0]=='22') $videoFile.= 'http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=22';
	    return $videoFile;
	    }

    if($fmts[0]==35 or $fmts[0]=='35') $videoFile= 'http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=18';
     // echo "<br>".$id."=".$fmts[0];

	 if($fmts[0]=='18' or $fmts[0]==18) $videoFile= 'http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=18';

      if ($fmts[0]=='34' or $fmts[0]==34) {
      	$videoFile="";
      	return $videoFile;
      }
   	}  else if ($status=='failed') {
	$videoFile="";
} else {
	$videoFile= 'http://youtube.com/get_video?video_id='.$ido.'&t='.$t.'&asv=&fmt=18';
}
	return $videoFile;
}

function echoPlaylist($ids, $getVideo){
	$ids = explode(":",$ids);
   		header("Content-Type: x-foo/x-bar");
		header('Content-Description: File Transfer');
		header('Content-Transfer-Encoding: binary');
		header('Content-Disposition: filename="playlist.jsp"');
		$output="";
   foreach ($ids as $id){
     $url=  "http://localhost:9999/YTLR_web/" . $getVideo . '?format=ipad&videoid=' . $id;
    if(strlen($id)>3) $output.=$id."|0|0|".$url."|\r\n";
   }
   echo $output;
}


function savePlaylist($ids, $getVideo){
	$ids = explode(":",$ids);
	$output="";
	foreach ($ids as $id){
		$url=  "http://localhost:9999/YTLR_web/" . $getVideo . '?format=ipad&videoid=' . $id;
		if(strlen($id)>3) $output.=$id."|0|0|".$url."|\r\n";
	}

	file_put_contents('playlist.jsp', $output);
}
////////////////////////////////
//$xml = simplexml_load_file('http://gdata.youtube.com/feeds/api/videos?vq=sand&search_sort=video_avg_rating&racy=include&max-results=5');
//////////////////////////////////////

function echoVideoList($searchstring)
{   global $files;
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
        $rating = $attrs['average'];
      } else {
        $rating = 0;
      }
     $url=youtubeData($VideoId);
     if (strlen($url)<3) continue;
     $plurl.=$VideoId.":";
       $output.=<<<END
        <tr >
        <td width="150px"><img src="${Thumnail}"/></td>
        <td width="500px" >
        ${Title}&nbsp;(${Time})
        <p class="videoDescription">
            <h3>${url}</h3>
            Views:&nbsp;${viewCount}&nbsp;&nbsp;Rating:&nbsp;${rating}
        </td>
        </tr>
        <tr><td colspan=2><hr style="border-color:#007F0E;"></td></tr>
END;
    }
    $output.='</table>';
	echo "<h4><center><a href=\"".$plurl."\" vod=\"playlist\" >[Play all on this Page]</a></center></h4></br></br>";
	echo $output;

}
//http://www.ibm.com/developerworks/xml/library/x-youtubeapi/
//include('keys.php');
//error_reporting(E_ALL);
?>