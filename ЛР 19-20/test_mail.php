<?php
// Тест отправки почты
$to = "test@localhost";
$subject = "Тест почты";
$message = "<h1>Тест</h1><p>Работает!</p>";
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n";
$headers .= "From: test@localhost\r\n";

if(mail($to, $subject, $message, $headers)) {
    echo "Письмо отправлено!";
} else {
    echo "Ошибка отправки. Проверьте настройки почты в php.ini";
}
?>