<?php
declare(strict_types=1);

// includes/Mailer.php

/**
 * Отправка писем через SMTP Gmail без внешних библиотек.
 */
function send_gmail_smtp(
    string $toEmail,
    string $toName,
    string $subject,
    string $bodyText,
    ?string $bodyHtml = null
): bool {
    $configPath = __DIR__ . '/../config/mail.php';
    if (!is_file($configPath)) {
        error_log("Mail config file not found: " . $configPath);
        return false;
    }

    /** @var array<string,mixed> $cfg */
    $cfg = require $configPath;

    $host      = (string)($cfg['host'] ?? 'smtp.gmail.com');
    $port      = (int)($cfg['port'] ?? 587);
    $username  = (string)($cfg['username'] ?? '');
    $password  = (string)($cfg['password'] ?? '');
    $fromEmail = (string)($cfg['from_email'] ?? $username);
    $fromName  = (string)($cfg['from_name'] ?? 'Moment Pilates');

    if ($username === '' || $password === '' || $fromEmail === '') {
        error_log("SMTP credentials not configured");
        return false;
    }

    $errno  = 0;
    $errstr = '';
    $socket = @stream_socket_client(
        "tcp://{$host}:{$port}",
        $errno,
        $errstr,
        15,
        STREAM_CLIENT_CONNECT
    );

    if (!$socket) {
        error_log("SMTP connection failed: $errstr ($errno)");
        return false;
    }

    $readLine = static function () use ($socket): string {
        $line = '';
        while (!feof($socket)) {
            $chunk = fgets($socket, 512);
            if ($chunk === false) {
                break;
            }
            $line .= $chunk;
            if (strlen($chunk) < 4 || isset($chunk[3]) && $chunk[3] === ' ') {
                break;
            }
        }
        return $line;
    };

    $writeLine = static function (string $data) use ($socket): void {
        fwrite($socket, $data . "\r\n");
    };

    // Читаем приветствие сервера
    $readLine(); // 220

    $writeLine('EHLO localhost');
    $readLine();

    $writeLine('STARTTLS');
    $line = $readLine();
    if (strpos($line, '220') !== 0) {
        error_log("STARTTLS failed: $line");
        fclose($socket);
        return false;
    }

    if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
        error_log("Failed to enable TLS");
        fclose($socket);
        return false;
    }

    $writeLine('EHLO localhost');
    $readLine();

    $writeLine('AUTH LOGIN');
    $readLine();
    $writeLine(base64_encode($username));
    $readLine();
    $writeLine(base64_encode($password));
    $authResponse = $readLine();
    if (strpos($authResponse, '235') !== 0) {
        error_log("Authentication failed: $authResponse");
        fclose($socket);
        return false;
    }

    $writeLine('MAIL FROM: <' . $fromEmail . '>');
    $readLine();

    $writeLine('RCPT TO: <' . $toEmail . '>');
    $readLine();

    $writeLine('DATA');
    $readLine();

    if ($bodyHtml === null) {
        $bodyHtml = nl2br($bodyText, false);
    }

    $boundary   = 'b' . bin2hex(random_bytes(8));
    $subjectEnc = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $fromNameEnc = '=?UTF-8?B?' . base64_encode($fromName) . '?=';

    $headers   = [];
    $headers[] = 'From: ' . $fromNameEnc . ' <' . $fromEmail . '>';
    $headers[] = 'To: <' . $toEmail . '>';
    $headers[] = 'Subject: ' . $subjectEnc;
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';

    $message  = implode("\r\n", $headers) . "\r\n\r\n";
    $message .= '--' . $boundary . "\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
    $message .= $bodyText . "\r\n\r\n";
    $message .= '--' . $boundary . "\r\n";
    $message .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
    $message .= $bodyHtml . "\r\n\r\n";
    $message .= '--' . $boundary . "--\r\n.";

    $writeLine($message);
    $readLine();
    $writeLine('QUIT');
    fclose($socket);

    return true;
}

/**
 * Отправка подтверждения записи на пилатес
 */
function send_booking_confirmation(
    string $toEmail, 
    string $toName, 
    array $bookingData
): bool {
    $subject = 'Подтверждение записи - Студия пилатес Moment';

    // Формируем текстовую версию
    $bodyText = "Здравствуйте, {$toName}!\n\n"
        . "Благодарим за запись в студию пилатес \"Moment\".\n\n"
        . "Детали вашей записи:\n"
        . "📅 Дата: {$bookingData['date']}\n"
        . "⏰ Время: {$bookingData['time']}\n"
        . "🧘 Тип занятия: {$bookingData['class_type']}\n"
        . "👤 Имя: {$toName}\n"
        . "📞 Телефон: {$bookingData['phone']}\n"
        . "📧 Email: {$toEmail}\n";
    
    if (!empty($bookingData['comment'])) {
        $bodyText .= "💬 Комментарий: {$bookingData['comment']}\n";
    }
    
    $bodyText .= "\n📍 Важная информация:\n"
        . "• Адрес студии: ул. Пилатесная, 15\n"
        . "• Приходите за 10-15 минут до начала\n"
        . "• Возьмите удобную одежду, носки и воду\n"
        . "• При отмене предупредите за 12 часов\n\n"
        . "Ждем вас! 🌸\n"
        . "Студия пилатес \"Moment\"\n"
        . "тел. +7 (999) 123-45-67";

    // Формируем HTML версию
    $bodyHtml = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; background: #f9f9f9; border-radius: 15px; overflow: hidden; }
        .header { background: linear-gradient(135deg, #9b8b7a, #b7a18e); color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; background: white; }
        .details { background: #f8f4f0; border-radius: 10px; padding: 20px; margin: 20px 0; }
        .details table { width: 100%; }
        .details td { padding: 10px; border-bottom: 1px solid #e5d5c8; }
        .details td:first-child { font-weight: bold; color: #7a6b5c; width: 35%; }
        .info-box { background: #e8f0e9; border-left: 4px solid #9b8b7a; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .footer { background: #f8f4f0; padding: 20px; text-align: center; color: #7a6b5c; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🧘‍♀️ Студия пилатес "Moment"</h1>
        </div>
        <div class="content">
            <h2>Здравствуйте, ' . htmlspecialchars($toName, ENT_QUOTES, 'UTF-8') . '!</h2>
            <p>Благодарим за запись в нашу студию.</p>
            
            <div class="details">
                <h3>📋 Детали записи:</h3>
                <table>
                    <tr><td>📅 Дата:</td><td><strong>' . $bookingData['date'] . '</strong></td></tr>
                    <tr><td>⏰ Время:</td><td><strong>' . $bookingData['time'] . '</strong></td></tr>
                    <tr><td>🧘 Тип занятия:</td><td><strong>' . $bookingData['class_type'] . '</strong></td></tr>
                    <tr><td>👤 Имя:</td><td>' . htmlspecialchars($toName, ENT_QUOTES, 'UTF-8') . '</td></tr>
                    <tr><td>📞 Телефон:</td><td>' . $bookingData['phone'] . '</td></tr>
                    <tr><td>📧 Email:</td><td>' . $toEmail . '</td></tr>';
    
    if (!empty($bookingData['comment'])) {
        $bodyHtml .= '<tr><td>💬 Комментарий:</td><td><em>"' . htmlspecialchars($bookingData['comment'], ENT_QUOTES, 'UTF-8') . '"</em></td></tr>';
    }
    
    $bodyHtml .= '</table>
            </div>
            
            <div class="info-box">
                <h3>📍 Важная информация:</h3>
                <p>🏢 Адрес: ул. Пилатесная, 15<br>
                ⏱ Приходите за 10-15 минут до начала<br>
                🧦 Возьмите удобную одежду, носки и воду<br>
                ❌ Отмена занятия: за 12 часов</p>
            </div>
            
            <p style="text-align: center; font-size: 18px;">Ждем вас! 🌸</p>
        </div>
        <div class="footer">
            <p>Студия пилатес "Moment"<br>
            тел. +7 (999) 123-45-67<br>
            www.moment-pilates.ru</p>
        </div>
    </div>
</body>
</html>';

    return send_gmail_smtp($toEmail, $toName, $subject, $bodyText, $bodyHtml);
}

/**
 * Отправка уведомления администратору о новой записи
 */
function send_admin_notification(array $bookingData): bool {
    $configPath = __DIR__ . '/../config/mail.php';
    $cfg = require $configPath;
    
    $adminEmail = $cfg['admin_email'] ?? '';
    $adminName = $cfg['admin_name'] ?? 'Администратор';
    
    if (empty($adminEmail)) {
        return false;
    }
    
    $subject = 'Новая запись в студию - ' . $bookingData['name'];
    
    $bodyText = "Новая запись на пилатес:\n\n"
        . "👤 Имя: {$bookingData['name']}\n"
        . "📧 Email: {$bookingData['email']}\n"
        . "📞 Телефон: {$bookingData['phone']}\n"
        . "📅 Дата: {$bookingData['date']}\n"
        . "⏰ Время: {$bookingData['time']}\n"
        . "🧘 Тип: {$bookingData['class_type']}\n";
    
    if (!empty($bookingData['comment'])) {
        $bodyText .= "💬 Комментарий: {$bookingData['comment']}\n";
    }
    
    $bodyText .= "\nВремя записи: " . date('Y-m-d H:i:s');
    
    $bodyHtml = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; }
        .notification { background: #f0f0f0; padding: 20px; border-radius: 10px; max-width: 600px; }
        h2 { color: #9b8b7a; }
        .data { background: white; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .data p { margin: 8px 0; }
        .label { font-weight: bold; color: #7a6b5c; }
    </style>
</head>
<body>
    <div class="notification">
        <h2>📌 Новая запись на пилатес</h2>
        <div class="data">
            <p><span class="label">👤 Имя:</span> ' . htmlspecialchars($bookingData['name'], ENT_QUOTES, 'UTF-8') . '</p>
            <p><span class="label">📧 Email:</span> ' . $bookingData['email'] . '</p>
            <p><span class="label">📞 Телефон:</span> ' . $bookingData['phone'] . '</p>
            <p><span class="label">📅 Дата:</span> ' . $bookingData['date'] . '</p>
            <p><span class="label">⏰ Время:</span> ' . $bookingData['time'] . '</p>
            <p><span class="label">🧘 Тип:</span> ' . $bookingData['class_type'] . '</p>';
    
    if (!empty($bookingData['comment'])) {
        $bodyHtml .= '<p><span class="label">💬 Комментарий:</span> ' . htmlspecialchars($bookingData['comment'], ENT_QUOTES, 'UTF-8') . '</p>';
    }
    
    $bodyHtml .= '<p><span class="label">⏱ Время записи:</span> ' . date('Y-m-d H:i:s') . '</p>
        </div>
        <p><em>Письмо отправлено автоматически</em></p>
    </div>
</body>
</html>';
    
    return send_gmail_smtp($adminEmail, $adminName, $subject, $bodyText, $bodyHtml);
}