<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись на занятие - Moment</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">Moment</div>
        <ul class="nav-links">
            <li><a href="index.php">Главная</a></li>
            <li><a href="index.php#about">О нас</a></li>
            <li><a href="index.php#schedule">Расписание</a></li>
            <li><a href="index.php#contact">Контакты</a></li>
        </ul>
    </nav>
</header>

<section class="booking-section">
    <div class="container">
        <h1>Запись на занятие</h1>

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

        <form id="bookingForm" action="send_confirmation.php" method="POST" class="booking-form">
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
                <label for="time">Время занятия *</label>
                <select id="time" name="time" required>
                    <option value="">Выберите время</option>
                    <option value="09:00">09:00</option>
                    <option value="10:30">10:30</option>
                    <option value="18:00">18:00</option>
                    <option value="19:30">19:30</option>
                </select>
            </div>

            <div class="form-group">
                <label for="class_type">Тип занятия *</label>
                <select id="class_type" name="class_type" required>
                    <option value="">Выберите тип</option>
                    <option value="Групповое">Групповое занятие</option>
                    <option value="Индивидуальное">Индивидуальное занятие</option>
                    <option value="Пробное">Пробное занятие</option>
                </select>
            </div>

            <div class="form-group">
                <label for="comment">Комментарий</label>
                <textarea id="comment" name="comment" rows="4"></textarea>
            </div>

            <button type="submit" class="btn-primary btn-submit">Записаться</button>
        </form>
    </div>
</section>

<footer>
    <div class="container">
        <div class="copyright">
            <p>&copy; 2024 Студия пилатес Moment. Все права защищены.</p>
        </div>
    </div>
</footer>

<script src="js/script.js"></script>
</body>
</html>