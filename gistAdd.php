<?php

$host = "https://api.github.com/gists";

$data = [
    'public' => false,
    'files' => [
        'temp1.txt' => [
            'content' => getenv('POPCLIP_TEXT'),
        ],
    ],
];
$json_data = json_encode($data);

$ch = curl_init($host);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json_data),
    'Authorization: token ' . getenv('POPCLIP_OPTION_ACCESSTOKEN'),
    'User-Agent: ' . getenv('POPCLIP_OPTION_USERNAME')
]);
$response = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($code == 200) {
	exit(0); // success
}  
elseif ($code == 403) {
	exit(2); // bad auth
}
else {
	exit(1); // other error
}
