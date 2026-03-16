<?php
/**
 * Файл: developer.php
 * Назначение: Вывод ФИО разработчика с заданным цветом и размером
 * Разработчик: Иванов Иван Иванович
 * Дата создания: 15.03.2024
 */

// Установка кодировки для корректного отображения русских символов
header('Content-Type: text/html; charset=utf-8');

// Определение переменных
$color = '#3498db';  // Синий цвет
$size = '48px';      // Размер шрифта
$developer_name = 'Иванов Иван Иванович';

// Альтернативные значения для демонстрации
$alternative_colors = [
    '#e74c3c',  // Красный
    '#2ecc71',  // Зеленый
    '#f39c12',  // Оранжевый
    '#9b59b6',  // Фиолетовый
    '#1abc9c'   // Бирюзовый
];

$alternative_sizes = ['24px', '32px', '48px', '64px', '72px'];

// Начало HTML-документа
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форматированный текст ФИО</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .main-content {
            padding: 40px;
        }

        .demo-section {
            text-align: center;
            margin-bottom: 50px;
            padding: 30px;
            background: #f8f9ff;
            border-radius: 15px;
            border: 2px dashed #667eea;
        }

        .developer-name {
            font-family: 'Montserrat', 'Arial', sans-serif;
            font-weight: 700;
            margin: 30px 0;
            padding: 20px;
            background: white;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .developer-name:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .variables-info {
            background: #e9f7fe;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .code-block {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 1rem;
            margin: 20px 0;
            overflow-x: auto;
        }

        .code-comment {
            color: #95a5a6;
            font-style: italic;
        }

        .code-variable {
            color: #3498db;
        }

        .code-string {
            color: #2ecc71;
        }

        .code-value {
            color: #e74c3c;
        }

        .alternatives {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .alternative-item {
            padding: 20px;
            border-radius: 10px;
            color: white;
            text-align: center;
            font-weight: 600;
            transition: transform 0.3s ease;
        }

        .alternative-item:hover {
            transform: translateY(-5px);
        }

        .controls {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .control-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            background: #667eea;
            color: white;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .control-btn:hover {
            background: #764ba2;
            transform: scale(1.05);
        }

        .info-section {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 10px;
            margin-top: 40px;
        }

        .info-section h3 {
            color: #667eea;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-section h3::before {
            content: 'ℹ️';
        }

        .footer {
            text-align: center;
            padding: 25px;
            background: #f8f9ff;
            border-top: 1px solid #eee;
        }

        .back-link {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .back-link:hover {
            background: transparent;
            border-color: #667eea;
            color: #667eea;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .main-content {
                padding: 20px;
            }

            .alternatives {
                grid-template-columns: 1fr;
            }

            .controls {
                flex-direction: column;
            }

            .control-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Форматированный текст ФИО разработчика</h1>
        <p>Демонстрация работы с переменными PHP для стилизации текста</p>
    </div>

    <div class="main-content">
        <div class="demo-section">
            <h2>ФИО разработчика с заданными параметрами:</h2>

            <!-- Основной вывод ФИО с заданными цветом и размером -->
            <div class="developer-name" style="color: <?php echo $color; ?>; font-size: <?php echo $size; ?>;">
                <?php echo htmlspecialchars($developer_name); ?>
            </div>

            <div class="variables-info">
                <p><strong>Используемые переменные:</strong></p>
                <p>Цвет (переменная <code>$color</code>): <span style="color: <?php echo $color; ?>; font-weight: bold;">