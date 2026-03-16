<?php
session_start();

// Подключаем наш Mailer
require_once __DIR__ . '/includes/Mailer.php';

// Настройки
define('SITE_NAME', 'Moment Пилатес Студия');

// Проверяем, что форма отправлена
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: booking.php');
    exit;
}

// Получаем и очищаем данные
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$date = htmlspecialchars(trim($_POST['date'] ?? ''));
$time = htmlspecialchars(trim($_POST['time'] ?? ''));
$class_type = htmlspecialchars(trim($_POST['class_type'] ?? ''));
$comment = htmlspecialchars(trim($_POST['comment'] ?? ''));

// Валидация
$errors = [];

if (empty($name)) $errors[] = 'Укажите ваше имя';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Укажите корректный email';
if (empty($phone)) $errors[] = 'Укажите номер телефона';
if (empty($date)) $errors[] = 'Выберите дату занятия';
if (empty($time)) $errors[] = 'Выберите время';
if (empty($class_type)) $errors[] = 'Выберите тип занятия';

if (!empty($errors)) {
    $_SESSION['error'] = implode('<br>', $errors);
    header('Location: booking.php');
    exit;
}

// Форматируем дату
$formatted_date = date('d.m.Y', strtotime($date));

// Подготавливаем данные для отправки
$bookingData = [
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'date' => $formatted_date,
    'time' => $time,
    'class_type' => $class_type,
    'comment' => $comment
];

// Отправляем письмо клиенту
$client_mail_sent = send_booking_confirmation($email, $name, $bookingData);

// Отправляем уведомление администратору
$admin_mail_sent = send_admin_notification($bookingData);

// Сохраняем в файл для истории
$log_entry = date('Y-m-d H:i:s') . " | $name | $email | $phone | $formatted_date $time | $class_type\n";
file_put_contents('bookings.log', $log_entry, FILE_APPEND);

// Сохраняем в CSV
$csv_file = 'bookings.csv';
$is_new_file = !file_exists($csv_file);

$fp = fopen($csv_file, 'a');
if ($is_new_file) {
    fputcsv($fp, ['Дата', 'Время', 'Имя', 'Email', 'Телефон', 'Тип занятия', 'Комментарий', 'Дата записи']);
}
fputcsv($fp, [
    $formatted_date,
    $time,
    $name,
    $email,
    $phone,
    $class_type,
    $comment,
    date('Y-m-d H:i:s')
]);
fclose($fp);

// Результат
if ($client_mail_sent) {
    $_SESSION['success'] = '✅ Вы успешно записаны! Подтверждение отправлено на ваш email. Проверьте папку "Спам".';
} else {
    $_SESSION['success'] = '✅ Вы успешно записаны! (Письмо с подтверждением не может быть отправлено, но мы свяжемся с вами)';
}

// Перенаправляем обратно
header('Location: booking.php');
exit;
?>