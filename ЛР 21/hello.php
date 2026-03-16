<?php
/**
 * Файл: hello.php
 * Назначение: Вывод приветствия и информации о разработчике
 * Разработчик: Иванов Иван Иванович
 * Дата создания: 15.03.2024
 */

// Установка кодировки для корректного отображения русских символов
header('Content-Type: text/html; charset=utf-8');

// Определение информации о разработчике
$developer = [
    'name' => 'Иванов Иван Иванович',
    'group' => 'ИСП-21',
    'university' => 'Технический университет',
    'faculty' => 'Факультет информационных технологий',
    'course' => '3 курс',
    'email' => 'ivanov@university.edu',
    'phone' => '+7 (123) 456-78-90'
];

// Начало HTML-документа
?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Приветствие и информация о разработчике</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                line-height: 1.6;
                background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }

            .container {
                max-width: 800px;
                width: 100%;
                background: white;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            }

            .header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 40px;
                text-align: center;
            }

            .greeting {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 20px;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }

            .subtitle {
                font-size: 1.2rem;
                opacity: 0.9;
            }

            .content {
                padding: 40px;
            }

            .section {
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eee;
            }

            .section:last-child {
                border-bottom: none;
            }

            .section-title {
                color: #667eea;
                font-size: 1.5rem;
                margin-bottom: 15px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .section-title::before {
                content: '▸';
                color: #764ba2;
            }

            .info-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 20px;
            }

            .info-card {
                background: #f8f9ff;
                padding: 20px;
                border-radius: 10px;
                border-left: 4px solid #667eea;
            }

            .info-card h4 {
                color: #333;
                margin-bottom: 10px;
                font-size: 1.1rem;
            }

            .info-card p {
                color: #666;
                font-size: 1rem;
            }

            .skills {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 10px;
            }

            .skill-tag {
                background: #667eea;
                color: white;
                padding: 5px 15px;
                border-radius: 20px;
                font-size: 0.9rem;
            }

            .footer {
                text-align: center;
                padding: 20px;
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

            /* Анимация появления */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate {
                animation: fadeIn 0.8s ease-out;
            }

            .delay-1 { animation-delay: 0.2s; }
            .delay-2 { animation-delay: 0.4s; }
            .delay-3 { animation-delay: 0.6s; }

            @media (max-width: 768px) {
                .greeting {
                    font-size: 2.5rem;
                }

                .content {
                    padding: 20px;
                }

                .info-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>
    <body>
    <div class="container animate">
        <div class="header">
            <div class="greeting">Привет всем!!!</div>
            <p class="subtitle">Страница разработчика PHP-скриптов</p>
        </div>

        <div class="content">
            <div class="section animate delay-1">
                <h2 class="section-title">О разработчике</h2>
                <div class="info-grid">
                    <div class="info-card">
                        <h4>ФИО</h4>
                        <p><?php echo htmlspecialchars($developer['name']); ?></p>
                    </div>
                    <div class="info-card">
                        <h4>Группа</h4>
                        <p><?php echo htmlspecialchars($developer['group']); ?></p>
                    </div>
                    <div class="info-card">
                        <h4>Учебное заведение</h4>
                        <p><?php echo htmlspecialchars($developer['university']); ?></p>
                    </div>
                    <div class="info-card">
                        <h4>Факультет</h4>
                        <p><?php echo htmlspecialchars($developer['faculty']); ?></p>
                    </div>
                    <div class="info-card">
                        <h4>Курс</h4>
                        <p><?php echo htmlspecialchars($developer['course']); ?></p>
                    </div>
                    <div class="info-card">
                        <h4>Контактная информация</h4>
                        <p>Email: <?php echo htmlspecialchars($developer['email']); ?></p>
                        <p>Телефон: <?php echo htmlspecialchars($developer['phone']); ?></p>
                    </div>
                </div>
            </div>

            <div class="section animate delay-2">
                <h2 class="section-title">Навыки и технологии</h2>
                <div class="skills">
                    <span class="skill-tag">PHP</span>
                    <span class="skill-tag">HTML/CSS</span>
                    <span class="skill-tag">JavaScript</span>
                    <span class="skill-tag">MySQL</span>
                    <span class="skill-tag">Apache</span>
                    <span class="skill-tag">Git</span>
                    <span class="skill-tag">OpenServer</span>
                </div>
            </div>

            <div class="section animate delay-3">
                <h2 class="section-title">О скрипте</h2>
                <div class="info-card">
                    <p>Данный скрипт демонстрирует:</p>
                    <ul style="margin-top: 10px; padding-left: 20px; color: #666;">
                        <li>Основы синтаксиса PHP</li>
                        <li>Работу с переменными и массивами</li>
                        <li>Вывод данных в HTML-страницу</li>
                        <li>Использование CSS для стилизации</li>
                        <li>Обработку и отображение текста на русском языке</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer">
            <a href="../index.html" class="back-link">← Вернуться на главную страницу</a>
        </div>
    </div>
    </body>
    </html>
<?php
// Конец скрипта
?>