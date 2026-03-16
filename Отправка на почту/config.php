<?php

// Настройки сайта
define('SITE_NAME', 'Moment');
define('SITE_EMAIL', 'info@moment-pilates.ru');
define('ADMIN_EMAIL', 'admin@moment-pilates.ru');

// Настройки SMTP (для отправки почты)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('SMTP_SECURE', 'tls');

// Настройки базы данных (если нужна)
define('DB_HOST', 'localhost');
define('DB_NAME', 'pilates_moment');
define('DB_USER', 'root');
define('DB_PASS', '');

// Папка для временных PDF файлов
define('PDF_TEMP_DIR', __DIR__ . '/pdf/');

// Создаем папку для PDF, если её нет
if (!file_exists(PDF_TEMP_DIR)) {
    mkdir(PDF_TEMP_DIR, 0777, true);
}

// Функция для подключения к БД (опционально)
function getDB()
{
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        return null;
    }
}
