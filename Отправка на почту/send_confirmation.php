<?php


session_start();
require_once 'config.php';

// Подключаем библиотеку TCPDF
require_once __DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php';

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

if (empty($name)) $errors[] = 'Укажите имя';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Укажите корректный email';
if (empty($phone)) $errors[] = 'Укажите телефон';
if (empty($date)) $errors[] = 'Укажите дату';
if (empty($time)) $errors[] = 'Укажите время';
if (empty($class_type)) $errors[] = 'Укажите тип занятия';

if (!empty($errors)) {
    $_SESSION['error'] = implode('<br>', $errors);
    header('Location: booking.php');
    exit;
}

// Форматируем дату
$formatted_date = date('d.m.Y', strtotime($date));

// Создаем PDF подтверждение
class MYPDF extends TCPDF
{
    public function Header()
    {
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'Студия пилатес "Moment"', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Спасибо за выбор нашей студии!', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Создаем новый PDF документ
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Устанавливаем информацию о документе
$pdf->SetCreator('Moment Pilates Studio');
$pdf->SetAuthor('Moment');
$pdf->SetTitle('Подтверждение записи');
$pdf->SetSubject('Подтверждение записи на занятие');

// Убираем отступы
$pdf->SetMargins(15, 30, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

// Добавляем страницу
$pdf->AddPage();

// Содержимое PDF
$html = '
<h1 style="text-align: center; color: #9b8b7a;">Подтверждение записи</h1>
<br>
<p style="font-size: 12pt;">Уважаемая(ый) <strong>' . $name . '</strong>,</p>
<p style="font-size: 12pt;">Вы успешно записаны на занятие в студию пилатес "Moment".</p>
<br>
<h3>Детали записи:</h3>
<table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <tr>
        <td style="background-color: #f5f5f5; width: 30%;"><strong>Дата:</strong></td>
        <td>' . $formatted_date . '</td>
    </tr>
    <tr>
        <td style="background-color: #f5f5f5;"><strong>Время:</strong></td>
        <td>' . $time . '</td>
    </tr>
    <tr>
        <td style="background-color: #f5f5f5;"><strong>Тип занятия:</strong></td>
        <td>' . $class_type . '</td>
    </tr>
    <tr>
        <td style="background-color: #f5f5f5;"><strong>Имя:</strong></td>
        <td>' . $name . '</td>
    </tr>
    <tr>
        <td style="background-color: #f5f5f5;"><strong>Телефон:</strong></td>
        <td>' . $phone . '</td>
    </tr>
    <tr>
        <td style="background-color: #f5f5f5;"><strong>Email:</strong></td>
        <td>' . $email . '</td>
    </tr>';

if (!empty($comment)) {
    $html .= '
    <tr>
        <td style="background-color: #f5f5f5;"><strong>Комментарий:</strong></td>
        <td>' . $comment . '</td>
    </tr>';
}

$html .= '
</table>
<br><br>
<h3>Важная информация:</h3>
<ul>
    <li>Приходите за 10 минут до начала занятия</li>
    <li>Возьмите с собой удобную одежду и воду</li>
    <li>При отмене занятия, пожалуйста, предупредите нас за 24 часа</li>
</ul>
<br>
<p style="text-align: center; font-size: 10pt;">Если у вас возникли вопросы, звоните нам: +7 (999) 123-45-67</p>
';

// Выводим HTML в PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Сохраняем PDF во временный файл
$pdf_filename = 'booking_confirmation_' . time() . '_' . uniqid() . '.pdf';
$pdf_path = PDF_TEMP_DIR . $pdf_filename;
$pdf->Output($pdf_path, 'F');

// Отправка email
$to = $email;
$subject = 'Подтверждение записи - Студия пилатес Moment';

// HTML версия письма
$message = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #9b8b7a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #f9f9f9; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .details { background-color: white; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .details table { width: 100%; }
        .details td { padding: 8px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #9b8b7a; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Студия пилатес "Moment"</h1>
        </div>
        <div class="content">
            <h2>Здравствуйте, ' . $name . '!</h2>
            <p>Благодарим вас за запись на занятие. Мы рады видеть вас в нашей студии!</p>
            
            <div class="details">
                <h3>Детали вашей записи:</h3>
                <table>
                    <tr><td><strong>Дата:</strong></td><td>' . $formatted_date . '</td></tr>
                    <tr><td><strong>Время:</strong></td><td>' . $time . '</td></tr>
                    <tr><td><strong>Тип занятия:</strong></td><td>' . $class_type . '</td></tr>
                    <tr><td><strong>Имя:</strong></td><td>' . $name . '</td></tr>
                    <tr><td><strong>Телефон:</strong></td><td>' . $phone . '</td></tr>
                    <tr><td><strong>Email:</strong></td><td>' . $email . '</td></tr>
                </table>
            </div>
            
            <p><strong>Адрес студии:</strong> ул. Пилатесная, 15</p>
            <p><strong>Телефон:</strong> +7 (999) 123-45-67</p>
            
            <p>К письму прикреплен файл с подтверждением записи. Сохраните его, пожалуйста.</p>
            
            <p>С уважением,<br>Команда студии пилатес "Moment"</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Студия пилатес Moment. Все права защищены.</p>
        </div>
    </div>
</body>
</html>
';

// Заголовки письма
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
$headers .= "From: " . SITE_NAME . " <" . SITE_EMAIL . ">" . "\r\n";
$headers .= "Reply-To: " . SITE_EMAIL . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Добавляем вложение
$boundary = md5(time());
$headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";

// Формируем тело письма с вложением
$body = "--" . $boundary . "\r\n";
$body .= "Content-Type: text/html; charset=utf-8\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= chunk_split(base64_encode($message)) . "\r\n";

$body .= "--" . $boundary . "\r\n";
$body .= "Content-Type: application/pdf; name=\"" . $pdf_filename . "\"\r\n";
$body .= "Content-Disposition: attachment; filename=\"" . $pdf_filename . "\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= chunk_split(base64_encode(file_get_contents($pdf_path))) . "\r\n";
$body .= "--" . $boundary . "--";

// Отправляем письмо
$mail_sent = mail($to, $subject, $body, $headers);

// Также отправляем копию администратору
$admin_subject = 'Новая запись - ' . $name;
$admin_message = "Новая запись на занятие:\n\n";
$admin_message .= "Имя: $name\n";
$admin_message .= "Email: $email\n";
$admin_message .= "Телефон: $phone\n";
$admin_message .= "Дата: $formatted_date\n";
$admin_message .= "Время: $time\n";
$admin_message .= "Тип: $class_type\n";
$admin_message .= "Комментарий: $comment\n";

$admin_headers = "From: " . SITE_EMAIL . "\r\n";
mail(ADMIN_EMAIL, $admin_subject, $admin_message, $admin_headers);

// Удаляем временный PDF файл
unlink($pdf_path);

// Сохраняем в базу данных (опционально)
$pdo = getDB();
if ($pdo) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO bookings (name, email, phone, booking_date, booking_time, class_type, comment, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$name, $email, $phone, $date, $time, $class_type, $comment]);
    } catch (PDOException $e) {
        // Логируем ошибку, но не прерываем выполнение
        error_log("DB Error: " . $e->getMessage());
    }
}

// Устанавливаем сообщение об успехе
if ($mail_sent) {
    $_SESSION['success'] = 'Вы успешно записаны! Подтверждение отправлено на ваш email.';
} else {
    $_SESSION['success'] = 'Вы успешно записаны! (Письмо с подтверждением не может быть отправлено, но мы свяжемся с вами)';
}

// Перенаправляем обратно
header('Location: booking.php');
exit;

