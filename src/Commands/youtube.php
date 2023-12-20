<?php

$youtube = function (int $who, array $message, int $type) {

    $bot = xatbot\API\ActionAPI::getBot();

    if (!$bot->minrank($who, 'youtube')) {
        return $bot->network->sendMessageAutoDetection($who, $bot->botlang('not.enough.rank'), $type);
    }

    if (empty($message[1]) || !isset($message[1])) {
        return $bot->network->sendMessageAutoDetection($who, 'Usage: !youtube [search]', $type, true);
    }

    $key = xatbot\Bot\XatVariables::getAPIKeys()['youtube'];

    if (empty($key)) {
        return $bot->network->sendMessageAutoDetection($who, "Youtube API Key needs to be setup", $type);
    }

    unset($message[0]);
    $message = implode(' ', $message);

    $response = json_decode(
        file_get_contents(
            'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' .
                urlencode($message) . '&key=' . $key . '&type=video&maxResults=3'
        ),
        true
    );

    if (isset($response['error'])) {
        return $bot->network->sendMessageAutoDetection(
            $who,
            $bot->botlang('cmd.youtube.cantsearch'),
            $type
        );
    }

    if ($response['pageInfo']['totalResults'] < 1) {
        return $bot->network->sendMessageAutoDetection(
            $who,
            $bot->botlang('cmd.youtube.nothingfound'),
            $type
        );
    }

    $count = 0;
    foreach ($response['items'] as $result) {
        if ($count >= 3) {
            break;
        }
        $count++;

        $videoId = $result['id']['videoId'];
        $title = $result['snippet']['title'];

        $videoInfo = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails%2Cstatistics&id={$videoId}&key={$key}"), true);

        if (isset($videoInfo['items'][0]['contentDetails']['duration'])) {
			preg_match_all('/(\d+)/', $videoInfo['items'][0]['contentDetails']['duration'], $matches);
			$duration = sprintf('%02d:%02d', $matches[0][0], $matches[0][1]);
		} else {
			$duration = 'N/A';
		}

        if (isset($videoInfo['items'][0]['statistics']['viewCount'])) {
            $views = number_format($videoInfo['items'][0]['statistics']['viewCount']);
        } else {
            $views = 'N/A';
        }

        $newMessage = "[{$duration}] {$title} - https://youtube.com/watch?v={$videoId} - {$views} views";

        if (sizeof($bot->packetsinqueue) > 0) {
            $bot->packetsinqueue[max(array_keys($bot->packetsinqueue)) + 1000] = [
                'who' => $who,
                'message' => $newMessage,
                'type' => $type
            ];
        } else {
            $bot->packetsinqueue[round(microtime(true) * 1000) + 1000] = [
                'who' => $who,
                'message' => $newMessage,
                'type' => $type
            ];
        }
    }
};
