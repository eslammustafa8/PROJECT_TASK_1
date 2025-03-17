<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone'])) {
    
    $phonePattern = '/^01[0-2,5]\d{8}$/';
    $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (!preg_match($phonePattern, $phone)) {
        header("Location: index.php?errorPhone=1");
        exit;
    }

    if (!preg_match($emailPattern, $email)) {
        header("Location: index.php?errorEmail=1");
        exit;
    }

    $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone
    ];

    
    $file = 'data.json';

    if (file_exists($file)) {
        $jsonData = json_decode(file_get_contents($file), true);
        if (!is_array($jsonData)) {
            $jsonData = [];
        }
    } else {
        $jsonData = [];
    }

    $jsonData[] = $data;

    file_put_contents($file, json_encode($jsonData, JSON_PRETTY_PRINT));

    header("Location: index.php?success=1");
    exit;
}
