<?php
session_start();
header("Content-Type: application/json");

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);
$prompt = $data['message'] ?? '';

if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

$_SESSION['chat_history'][] = ["role" => "user", "content" => $prompt];

$apiKey = "Your-API-Key";
$url = "https://openrouter.ai/api/v1/chat/completions";
$model = "openai/gpt-3.5-turbo";

$postData = [
    "model" => $model,
    "messages" => $_SESSION['chat_history']
];

$options = [
    "http" => [
        "method" => "POST",
        "header" => "Authorization: Bearer $apiKey\r\nContent-Type: application/json\r\n",
        "content" => json_encode($postData)
    ]
];

$context = stream_context_create($options);
$result = @file_get_contents($url, false, $context);

if ($result === false) {
    echo json_encode(["reply" => "❌ Failed to get a response from the API."]);
    exit;
}

$response = json_decode($result, true);
$reply = $response['choices'][0]['message']['content'] ?? '❌ No reply received.';

$_SESSION['chat_history'][] = ["role" => "assistant", "content" => $reply];

echo json_encode(["reply" => $reply]);
