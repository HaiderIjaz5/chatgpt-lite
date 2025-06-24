<?php
session_start();

if (!isset($_SESSION['chat_history']) || empty($_SESSION['chat_history'])) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "⚠️ No chat history to download."]);
    exit;
}

$chatHistory = $_SESSION['chat_history'];
$chatText = "";

foreach ($chatHistory as $entry) {
    $chatText .= strtoupper($entry['role']) . ": " . $entry['content'] . "\n\n";
}

header('Content-Type: application/json');
echo json_encode(["status" => "success", "content" => $chatText]);
exit;
?>
