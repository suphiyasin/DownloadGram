<?php
class downloadgram{
	public $BotToken;
	public $text;
	public $username;
	public $chatid;
	public $messageId;
	public $ustype;
	public $jsonFilePath = 'users.json';
	
	private function setHeader(){
		$header = [
			'authority: www.instagram.com',
			'accept: */*',
			'accept-language: en-US,en;q=0.9',
			'content-type: application/x-www-form-urlencoded',
			'dpr: 1.25',
			'origin: https://www.instagram.com',
			'referer: https://www.instagram.com/reel/',
			'sec-ch-prefers-color-scheme: light',
			'sec-ch-ua: "Not A(Brand";v="99", "Google Chrome";v="121", "Chromium";v="121"',
			'sec-ch-ua-full-version-list: "Not A(Brand";v="99.0.0.0", "Google Chrome";v="121.0.6167.85", "Chromium";v="121.0.6167.85"',
			'sec-ch-ua-mobile: ?0',
			'sec-ch-ua-model: ""',
			'sec-ch-ua-platform: "Windows"',
			'sec-ch-ua-platform-version: "15.0.0"',
			'sec-fetch-dest: empty',
			'sec-fetch-mode: cors',
			'sec-fetch-site: same-origin',
			'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
			'viewport-width: 1536',
			'x-asbd-id: 129477',
			'x-csrftoken: t3e1g4dNDh7FgFWsG7Mk_b',
			'x-fb-friendly-name: PolarisPostActionLoadPostQueryQuery',
			'x-fb-lsd: AVprzzL2A3o',
			'x-ig-app-id: 936619743392459',
			'accept-encoding: identity',
			'Cookie: YOUR COOKIE',
		];
		return $header;
	}
	
	
	public function checkCommandFrequency($userId) {
    $jsonFilePath = $this->jsonFilePath;
    $currentTime = time();

    $allowedFrequency = 60; 

    $userData = json_decode(file_get_contents($jsonFilePath), true);

    if (isset($userData[$userId])) {
        $lastCommandTime = $userData[$userId]['last_command_time'];

        if ($currentTime - $lastCommandTime < $allowedFrequency) {
            return false;
        }
    }

    $userData[$userId]['last_command_time'] = $currentTime;
    $currentHourMinute = date('H:i');
   $userData[$userId]['last_command_hour_minute'] = date('Y-m-d H:i:s');
    $userData[$userId]['username'] = $this->username;
    file_put_contents($jsonFilePath, json_encode($userData, JSON_PRETTY_PRINT));
    
    return true;
}
	
	public function DownloadVideo($url, $id){
		$step1 = file_get_contents($url);
		$step2 = file_put_contents("./videos/$id.mp4", $step1);
		$sendRespone = '{"status": "ok"}';
		return $sendRespone;
	}
	
	public function getCheck($text){
	if(strpos($text, "https://www.instagram.com/reel/") === 0){
		$step1 = explode("/", $text);
		$id = $step1[4];
		$userId = $this->chatid;
		if ($this->checkCommandFrequency($userId)) {

		$go = $this->getInfo($id);
} else {
    	$this->sendMessage("Please wait a moment before trying again...");
		$go = 'go';
	
}
	
		return $go;
	}else{
		return 'no way';
	}	
	}
	
	public function getInfo($id){
		
		
		$this->sendMessage("Downloading...");
		$ch = curl_init();
		$getHeader = $this->setHeader();
		$proxyIP = '';
		$proxyPort = ;
		$proxyUsername = '';
		$proxyPassword = '';
		// YOUR PROXY INFORMATIONS , IF YOU DONT HAVE PROXY DELETE LANES 
		curl_setopt($ch, CURLOPT_PROXY, $proxyIP);
		curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
		curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$proxyUsername:$proxyPassword");

		curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/api/graphql');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $getHeader);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'av=0&__d=www&__user=0&__a=1&__req=2&__hs=19750.HYP%3Ainstagram_web_pkg.2.1..0.0&dpr=1&__ccg=UNKNOWN&__rev=1011069798&__s=ux76qb%3Apubtm3%3Ac9o7p1&__hsi=7329082171152797718&__dyn=7xeUjG1mxu1syUbFp60DU98nwgU29zEdEc8co2qwJw5ux609vCwjE1xoswIwuo2awlU-cw5Mx62G3i1ywOwv89k2C1Fwc60AEC7U2czXwae4UaEW2G1NwwwNwKwHw8Xxm16wUwtEvw4JwJCwLyES1Twoob82ZwrUdUbGwmk1xwmo6O1FwlE6PhA6bxy4UjK5V8&__csr=gtneJ9lGF4HlRX-VHjmiWppWF4qDKKh7G8KUCgwDy8gDzVoO4emqFeLrW8EKFEhJ5zGmiiiUFpRum8zeQXx3y9pnCAgyiGHG6pbyoiwCKEsxx004LRG440qh00Nmw1jC0S8364i0bvw1aGt2p61rxK0a3CDgCl0c-0hW4Zw9y00FPE&__comet_req=7&lsd=AVprzzL2A3o&jazoest=2974&__spin_r=1011069798&__spin_b=trunk&__spin_t=1706434919&fb_api_caller_class=RelayModern&fb_api_req_friendly_name=PolarisPostActionLoadPostQueryQuery&variables=%7B%22shortcode%22%3A%22'.$id.'%22%2C%22fetch_comment_count%22%3A40%2C%22fetch_related_profile_media_count%22%3A3%2C%22parent_comment_count%22%3A24%2C%22child_comment_count%22%3A3%2C%22fetch_like_count%22%3A10%2C%22fetch_tagged_user_count%22%3Anull%2C%22fetch_preview_comment_count%22%3A2%2C%22has_threaded_comments%22%3Atrue%2C%22hoisted_comment_id%22%3Anull%2C%22hoisted_reply_id%22%3Anull%7D&server_timestamps=true&doc_id=10015901848480474');
		$response = curl_exec($ch);
		curl_close($ch);
		$parse = json_decode($response, true);
		$videoUrl = $parse["data"]["xdt_shortcode_media"]["video_url"];
		$totalComment = $parse["data"]["xdt_shortcode_media"]["edge_media_to_parent_comment"]["count"];
		$Comments = $parse["data"]["xdt_shortcode_media"]["edge_media_to_parent_comment"]["edges"];
		$Owner = $parse["data"]["xdt_shortcode_media"]["owner"]["username"];
		$totalView = $parse["data"]["xdt_shortcode_media"]["video_view_count"];
		$strowner = "[$Owner](https://instagram.com/$Owner)";
		$top5comment = "1-".$Comments[0]['node']['text']." \n 2-".$Comments[1]['node']['text']." \n 3-".$Comments[2]['node']['text']." \n 4-".$Comments[3]['node']['text']." \n 5-".$Comments[4]['node']['text'];
		$this->text = "---------------------------- \n Total Comments: $totalComment \n Total View: $totalView \n Owner: $strowner \n ---------------------------- \n RANDOM 5 COMMENTS \n ---------------------------- \n $top5comment \n ---------------------------- \n Requested by: ".$this->username."";
		$this->DownloadVideo($videoUrl, $id);
		$aga = $this->sendVideo($id);
		$sendRespone = '{"status": "ok", "responsefromtg": "'.addslashes($aga).'"}';
		return $sendRespone;
	}
	
	public function sendVideo($id, $chatid = null, $text = null, $mesid = null){
		$caption = $text ?? $this->text;
		$chatId = $chatid ?? $this->chatid;
		$mesid = $mesid ?? $this->messageId;
		$botToken = $this->BotToken;
		$videoPath = './videos/'.$id.'.mp4';
		$apiUrl = "https://api.telegram.org/bot{$botToken}/sendVideo";
		$postData = [
			'chat_id' => $chatId,
			'video' => new CURLFile($videoPath),
			'caption' => $caption,
			'parse_mode' => 'Markdown',
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
}

public function sendMessage($text){
	$BotToken = $this->BotToken;
	$ChatID = $this->chatid;
	$data = [
        'text' => $text,
        'chat_id' => $ChatID,
        'parse_mode' => 'Markdown',
    ];
	$url = "https://api.telegram.org/bot$BotToken/sendMessage";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
	
	
	
	
	
	
}
