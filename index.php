<?php
error_reporting(0);

$getVideo = "YT/getvideo.php";
$format = 'free';
$q = $_GET['q'];
$maxResults = 50;
$htmlBody = '';


require_once 'funcs.php';
if ($_GET['plist']=='yes') {
    echoPlaylist($_GET['ids'], $getVideo);
    exit;
}

// This code will execute if the user entered a search query in the form
// and submitted the form. Otherwise, the page displays the form above.
if ($_GET['q'] || !empty($_GET['playlistId'])) {
    // Call set_include_path() as needed to point to your client library.

    require_once realpath(dirname(__FILE__) . '/autoload.php');
    /*
     * Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
     * Google Developers Console <https://console.developers.google.com/>
     * Please ensure that you have enabled the YouTube Data API for your project.
     */
    $DEVELOPER_KEY = 'DEV_KEY';

    $client = new Google_Client();
    $client->setDeveloperKey($DEVELOPER_KEY);

    // Define an object that will be used to make all API requests.
    $youtube = new Google_Service_YouTube($client);

    try {
        if(!empty($_GET['playlistId'])) {
            $playlistId = $_GET['playlistId'];
            $searchResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
                'playlistId' => $playlistId,
                'maxResults' => $maxResults,
                'pageToken' => $_GET['pageToken'],
            ));

           // echo "<pre>";print_r($searchResponse);
        } else {
            $searchResponse = $youtube->search->listSearch('id,snippet', array(
                'q' => $_GET['q'],
                'maxResults' => $_GET['maxResults'],
                'pageToken' => $_GET['pageToken'],
            ));
        }


        $videos = '';
        $channels = '';
        $playlists = '';
        $plist = '';
        @$nextPage = $searchResponse['nextPageToken'];
        @$prevPage = $searchResponse['prevPageToken'];

        // Add each result to the appropriate list, and then display the lists of
        // matching videos, channels, and playlists.
        foreach ($searchResponse['items'] as $searchResult) {
            if(stristr($searchResult['snippet']['channelTitle'], 'VEVO')) continue;

            $selectType = empty($_GET['playlistId']) ? $searchResult['id']['kind'] : $searchResult['kind'];
            switch ($selectType) {
                case 'youtube#playlistItem':
                case 'youtube#video':
                    $videoId = empty($_GET['playlistId']) ? $searchResult['id']['videoId'] : $searchResult['snippet']['resourceId']['videoId'];
                    $plist .= $videoId . ':';
                    $videos .= "<li>";
                    $imageUrl = $searchResult['snippet']['thumbnails']['medium']['url'];
                    $imageUrl =  str_ireplace('https', 'http', $imageUrl);
                    $videos .= sprintf('<a class="item" vod href="%s?format=%s&videoid=%s">
                        <img class="img" src="img/transparent.png" onfocussrc="img/rounded_corners3.png" border="0">
                        <img src="%s" border="none" hspace="40" vspace="10"><br>
                        <span class="spacer"></span>&nbsp;&nbsp;&nbsp;%s</a><br><br></li>',
                        $getVideo,
                        $format,
                        $videoId,
                        $imageUrl,
                        $searchResult['snippet']['title']);
                    $videos .= "</li>";
                    break;
                case 'youtube#channel':
                    $channels .= sprintf('<li>%s (%s)</li>',
                        $searchResult['snippet']['title'], $searchResult['id']['channelId']);
                    break;
                case 'youtube#playlist':
                    $playlists .= "<li>";
                    $imageUrl = $searchResult['snippet']['thumbnails']['medium']['url'];
                    $imageUrl =  str_ireplace('https', 'http', $imageUrl);
                    $playlists .= sprintf('<a class="item" href="?playlistId=%s">
                        <img class="img" src="img/transparent.png" onfocussrc="img/rounded_corners3.png" border="0">
                        <img src="%s" border="none" hspace="40" vspace="10"><br>
                        <span class="spacer"></span>&nbsp;&nbsp;&nbsp;[PL]%s</a><br><br></li>',
                        $searchResult['id']['playlistId'],
                        $imageUrl,
                        $searchResult['snippet']['title']);
                    break;
            }
        }

        savePlaylist($plist, $getVideo);
        $htmlBody .= <<<END
    <h3>Videos</h3>
    <ul>$videos</ul>
    <h3>Playlists</h3>
    <ul>$playlists</ul>
END;
    } catch (Google_ServiceException $e) {
        $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
        $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
            htmlspecialchars($e->getMessage()));
    }
}
?>

<!doctype html>
<html>
<head>
    <meta SYABAS-FULLSCREEN>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>YouTube Search</title>
    <style type="text/css">
        .img {position: relative;height: 284px;width: 1120px;}
        a img{border: 3px; color: #fff;}
        table {font-size: 20px;}
        .hist{border-bottom:1px dashed; font-size: 20px;}
        h4 {font-size: 20px;}
        li {list-style: none;padding-bottom: 40px;}
        .item {display: block; border: 1px transparent solid;padding: 5px;font-size:25px}
        .item:hover {border-radius: 5px; border: 1px gray solid;}
        a {text-decoration:none;color:#002a80;}
        a:hover {text-decoration:underline}
        .spacer{width: 20px;}
        .btn {font-size:24px;color:#008000;text-shadow: 0px 1px 0px #e5e5ee;height:35px;width:100px;border:none;background:url('') no-repeat -30px -26px;background-attachment:inherit;}
        .srch {width:205px;height:20px;padding:0px;font-size:16px;border:1px green solid;margin-left:39px;BACKGROND-COLOR:#B2FFD7}
        .title{width:300px;font-size:20px;color:#006B00;font-weight:bold;text-align:center;text-decoration:underline;}
        .title2{width:550px;font-size:15px;color:#006B00;font-weight:bold;text-align:center;}
        #stitle{padding:10px;font-size:20px;color:#006B00;font-weight:bold;}
    </style>
</head>
<body marginwidth=20 marginheight=20 border=0 background="img/HJ021.jpg" FOCUSCOLOR="#006B00" FOCUSTEXT="#FFFFFF" bgcolor="#B2FFD7">
<?php
include('keys.php');
if(stristr($plist,':')) {
    echo "<h4><center><a href=\"playlist.jsp\" vod=\"playlist\" >[Play all on this Page]</a></center></h4></br>";
}

if(!empty($prevPage)){
    echo  "<a href=\"?q=$q&pageToken=$prevPage&maxResults=$maxResults&playlistId=$playlistId\"><< prev&nbsp;</a>";
}
if(!empty($nextPage)){
    echo  "<a href=\"?q=$q&pageToken=$nextPage&maxResults=$maxResults&playlistId=$playlistId\">&nbsp;next >></a>";
}
?>
<?=$htmlBody?>
<?php
if(stristr($plist,':')) {
    echo "<h4><center><a href=\"playlist.jsp\" vod=\"playlist\" >[Play all on this Page]</a></center></h4></br>";
}
?>
</body>
</html>