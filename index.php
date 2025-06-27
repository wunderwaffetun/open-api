<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$api_key = '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';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['messages'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing messages']);
    exit;
}

$curl = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $api_key,
    'Content-Type: application/json'
]);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_TIMEOUT, 20);

$result = curl_exec($curl);
if (curl_errno($curl)) {
    http_response_code(500);
    echo json_encode(['error' => curl_error($curl)]);
    exit;
}
curl_close($curl);

echo $result;
