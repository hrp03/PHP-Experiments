<?php

function hpGetYoutubeInfo($url, $youtube_api_key)
{
	$url = str_replace('https://www.youtube.com/watch?v=', '', $url);
	$video_id = str_replace("&feature=youtu.be", "", $url);

	$url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=" . $video_id . "&key=" . $youtube_api_key;

	$video_info = json_decode(file_get_contents($url), true);

	$video_title = $video_info["items"][0]["snippet"]["title"];
	$video_description = $video_info["items"][0]["snippet"]["description"];

	$video_thumbnail = "https://i.ytimg.com/vi/" . $video_id .  "/maxresdefault.jpg";

	if(isset($video_info["items"][0]["snippet"]["thumbnails"]["maxres"]))
	{
		$video_thumbnail = $video_info["items"][0]["snippet"]["thumbnails"]["maxres"]["url"];
	}
	else if(isset($video_info["items"][0]["snippet"]["thumbnails"]["standard"]))
	{
		$video_thumbnail = $video_info["items"][0]["snippet"]["thumbnails"]["standard"]["url"];
	}
	else if(isset($video_info["items"][0]["snippet"]["thumbnails"]["high"]))
	{
		$video_thumbnail = $video_info["items"][0]["snippet"]["thumbnails"]["high"]["url"];
	}
	else if(isset($video_info["items"][0]["snippet"]["thumbnails"]["medium"]))
	{
		$video_thumbnail = $video_info["items"][0]["snippet"]["thumbnails"]["medium"]["url"];
	}
	else
	{
		$video_thumbnail = $video_info["items"][0]["snippet"]["thumbnails"]["default"]["url"];
	}

	$video_time = $video_info["items"][0]["contentDetails"]["duration"];

	$date = new DateInterval($video_time);
	$video_time = $date -> format('H:i:s');

	$hh = sprintf('%02d',$date->h);
	$mm = sprintf('%02d',$date->i);
	$ss = sprintf('%02d',$date->s);

	if($hh == "00"){ $video_time =  $mm . ':' . $ss; }
	else{ $video_time =  $hh . ':' . $mm . ':' . $ss;}

	return array($video_id, $video_title, $video_description, $video_thumbnail, $video_time);
}

?>