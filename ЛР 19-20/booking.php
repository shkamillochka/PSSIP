<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moment - Запись на пилатес</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
        }

        body {
            background: #f8f4f0;
            color: #2c3e2f;
        }

        .header {
            background: #ffffffd9;
            backdrop-filter: blur(8px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.06);
            padding: 1.2rem 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #d4c0b0;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(130deg, #9b8b7a, #c7b09b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links a {
            text-decoration: none;
            color: #5a4a3a;
            margin-left: 2rem;
            font-weight: 500;
        }

        .container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        h1 {
            font-size: 2.2rem;
            font-weight: 400;
            border-left: 7px solid #c9a87c;
            padding-left: 1.2rem;
            margin-bottom: 2rem;
            color: #5a4a3a;
        }

        .booking-form {
            background: white;
            border-radius: 30px;
            padding: 3rem;
            box-shadow: 0 20px 40px -15px rgba(110, 80, 60, 0.2);
            border: 1px solid #e5d5c8;
        }

        .form-group {
            margin-bottom: 1.8rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 500;
            color: #5f4e3e;
            font-size: 1.1rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #eee2d9;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s;
            background: #fefcf9;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #bda892;
            box-shadow: 0 0 0 4px #f3e9e1;
        }

        .btn-submit {
            background: #9b8b7a;
            color: white;
            border: none;
            padding: 1.2rem 2.5rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .btn-submit:hover {
            background: #7a6b5c;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -8px #7a6b5c;
        }

        .alert {
            padding: 1.2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 500;
        }

        .alert.success {
            background: #e2f0e5;
            color: #2a5c3a;
            border: 2px solid #a5c9b0;
        }

        .alert.error {
            background: #ffe5e5;
            color: #b53b3b;
            border: 2px solid #ffb3b3;
        }

        .footer {
            text-align: center;
            padding: 2rem;
            color: #8b7a6a;
            border-top: 2px solid #e5d5c8;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <span class="logo">🧘‍♀️ Moment · студия пилатес</span>
        <div class="nav-links">
            <a href="index.php">Главная</a>
            <a href="#contact">Контакты</a>
        </div>
    </div>

    <div class="container">
        <h1>📅 Запись на занятие</h1>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert success">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert error">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form class="booking-form" action="send_booking.php" method="POST">
            <div class="form-group">
                <label for="name">Ваше имя *</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Телефон *</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="date">Дата занятия *</label>
                <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label for="time">Время *</label>
                <select id="time" name="time" required>
                    <option value="">Выберите время</option>
                    <option value="09:00">09:00</option>
                    <option value="10:30">10:30</option>
                    <option value="17:00">17:00</option>
                    <option value="18:30">18:30</option>
                    <option value="20:00">20:00</option>
                </select>
            </div>

            <div class="form-group">
                <label for="class_type">Тип занятия *</label>
                <select id="class_type" name="class_type" required>
                    <option value="">Выберите тип</option>
                    <option value="Групповое">Групповое (до 8 человек)</option>
                    <option value="Индивидуальное">Индивидуальное</option>
                    <option value="Парное">Парное (дуэт)</option>
                    <option value="Пробное">Пробное (для новичков)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="comment">Комментарий / пожелания</label>
                <textarea id="comment" name="comment" rows="4" placeholder="Напишите, если есть особые пожелания или вопросы..."></textarea>
            </div>

            <button type="submit" class="btn-submit">✅ Записаться на пилатес</button>
        </form>
    </div>

    <div class="footer">
        <p>© 2024 Студия пилатес Moment. Все права защищены.</p>
        <p style="font-size: 0.9rem; margin-top: 0.5rem;">ул. Пилатесная, 15 | +7 (999) 123-45-67</p>
    </div>
</body>
</html>