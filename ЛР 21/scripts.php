<?php
/**
 * Файл: phpinfo.php
 * Назначение: Вывод полной информации о конфигурации PHP
 * Разработчик: Иванов Иван Иванович
 * Дата создания: 15.03.2024
 */

// Установка кодировки для корректного отображения русских символов
header('Content-Type: text/html; charset=utf-8');

// Начало HTML-документа
?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Информация о PHP</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 20px;
                background: #f4f4f4;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .header {
                text-align: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid #007bff;
            }
            .header h1 {
                color: #007bff;
                margin-bottom: 10px;
            }
            .info {
                background: #e9f7fe;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 20px;
            }
            .back-link {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background: #007bff;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                transition: background 0.3s;
            }
            .back-link:hover {
                background: #0056b3;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            table, th, td {
                border: 1px solid #ddd;
            }
            th, td {
                padding: 12px;
                text-align: left;
            }
            th {
                background-color: #007bff;
                color: white;
            }
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            .phpinfo table {
                margin: 1em 0;
            }
            .phpinfo td, .phpinfo th {
                border: 1px solid #666;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <div class="header">
            <h1>Информация о конфигурации PHP</h1>
            <p><strong>Разработчик:</strong> Иванов Иван Иванович</p>
            <p><strong>Дата:</strong> <?php echo date('d.m.Y H:i:s'); ?></p>
        </div>

        <div class="info">
            <p><strong>Задание:</strong> Получение информации о настройках PHP с помощью функции phpinfo()</p>
            <p><strong>Функция:</strong> phpinfo() - выводит подробную информацию о текущей конфигурации PHP</p>
            <p><strong>Параметры:</strong> phpinfo(INFO_ALL) - выводит всю доступную информацию</p>
        </div>

        <div class="phpinfo">
            <?php
            // Вывод полной информации о PHP
            // INFO_ALL включает все доступные разделы информации
            phpinfo(INFO_ALL);
            ?>
        </div>

        <a href="../index.html" class="back-link">← Вернуться на главную страницу</a>
    </div>
    </body>
    </html>
<?php
// Конец скрипта
?>