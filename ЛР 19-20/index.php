<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moment - Студия пилатес</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
        }

        body {
            background: #fef9f0;
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

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #5a4a3a;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #9b8b7a;
        }

        .hero {
            height: 85vh;
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), 
                        url('https://images.unsplash.com/photo-1518611012118-696072aa579e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .btn-primary {
            display: inline-block;
            padding: 1rem 2.5rem;
            background-color: #9b8b7a;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s;
            font-size: 1.1rem;
            font-weight: 600;
            border: 2px solid transparent;
        }

        .btn-primary:hover {
            background-color: #7a6b5c;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -8px #5a4a3a;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        h2 {
            font-size: 2.2rem;
            font-weight: 400;
            border-left: 7px solid #c9a87c;
            padding-left: 1.2rem;
            margin-bottom: 3rem;
            color: #5a4a3a;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            border-radius: 30px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 15px 30px -10px rgba(90, 70, 50, 0.15);
            border: 1px solid #e5d5c8;
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            color: #5a4a3a;
            margin-bottom: 0.5rem;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .schedule-item {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid #e5d5c8;
        }

        .schedule-item h4 {
            color: #9b8b7a;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }

        .footer {
            background: #2c3e2f;
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .footer-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 2rem;
        }

        .footer h3 {
            color: #d4c0b0;
            margin-bottom: 1rem;
        }

        .footer a {
            color: #d4c0b0;
            text-decoration: none;
        }

        .copyright {
            border-top: 1px solid #5a4a3a;
            padding-top: 2rem;
            color: #b7a18e;
        }
    </style>
</head>
<body>
    <div class="header">
        <span class="logo">🧘‍♀️ Moment · студия пилатес</span>
        <div class="nav-links">
            <a href="#about">О нас</a>
            <a href="#schedule">Расписание</a>
            <a href="#pricing">Цены</a>
            <a href="#contacts">Контакты</a>
        </div>
    </div>

    <section class="hero">
        <div class="hero-content">
            <h1>Найди свой момент гармонии</h1>
            <p>Пилатес для здоровья, грации и внутреннего баланса</p>
            <a href="booking.php" class="btn-primary">Записаться на занятие</a>
        </div>
    </section>

    <section id="about" class="container">
        <h2>✨ О студии Moment</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🧘</div>
                <h3>Опытные инструкторы</h3>
                <p>Сертифицированные тренеры с международными дипломами</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌟</div>
                <h3>Индивидуальный подход</h3>
                <p>Программы для любого уровня подготовки</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏆</div>
                <h3>Современное оборудование</h3>
                <p>Реформеры, тренажеры и аксессуары премиум-класса</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌿</div>
                <h3>Уютная атмосфера</h3>
                <p>Пространство для полного расслабления и восстановления</p>
            </div>
        </div>
    </section>

    <section id="schedule" class="container">
        <h2>📅 Расписание занятий</h2>
        <div class="schedule-grid">
            <div class="schedule-item">
                <h4>Понедельник</h4>
                <p>09:00 - Утро</p>
                <p>18:00 - Вечер</p>
                <p>19:30 - Вечер</p>
            </div>
            <div class="schedule-item">
                <h4>Среда</h4>
                <p>10:00 - Утро</p>
                <p>17:00 - Вечер</p>
                <p>18:30 - Вечер</p>
            </div>
            <div class="schedule-item">
                <h4>Пятница</h4>
                <p>09:00 - Утро</p>
                <p>17:00 - Вечер</p>
                <p>18:30 - Вечер</p>
            </div>
            <div class="schedule-item">
                <h4>Суббота</h4>
                <p>10:00 - Утро</p>
                <p>12:00 - День</p>
            </div>
        </div>
    </section>

    <section id="contacts" class="footer">
        <div class="footer-info">
            <div>
                <h3>📍 Адрес</h3>
                <p>ул. Пилатесная, 15</p>
                <p>Москва, 123456</p>
            </div>
            <div>
                <h3>📞 Контакты</h3>
                <p>+7 (999) 123-45-67</p>
                <p>info@moment-pilates.ru</p>
            </div>
            <div>
                <h3>🕒 Часы работы</h3>
                <p>Пн-Пт: 8:00 - 22:00</p>
                <p>Сб: 9:00 - 18:00</p>
                <p>Вс: выходной</p>
            </div>
        </div>
        <div class="copyright">
            <p>© 2024 Студия пилатес Moment. Все права защищены.</p>
        </div>
    </section>
</body>
</html>