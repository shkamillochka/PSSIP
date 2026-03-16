// ==================== БАЗОВЫЙ КЛАСС (АБСТРАКЦИЯ) ====================
// Все игровые объекты наследуются от этого класса.
class GameObject {
    constructor(x, y, width, height, color) {
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.color = color;
    }

    // Методы draw и update будут переопределены в дочерних классах (ПОЛИМОРФИЗМ)
    draw(ctx) {
        // Базовая реализация отрисовки прямоугольника
        ctx.fillStyle = this.color;
        ctx.fillRect(this.x, this.y, this.width, this.height);
    }

    update() {
        // Базовая логика обновления состояния объекта (пустая)
    }
}

// ==================== КЛАСС ПЛАТФОРМЫ (ИНКАПСУЛЯЦИЯ) ====================
class Paddle extends GameObject {
    constructor(x, y, width, height, color, canvasWidth) {
        super(x, y, width, height, color);
        // Инкапсулируем логику скорости и ограничения движения внутри класса
        this.speed = 10;
        this.canvasWidth = canvasWidth;
        // Обработка событий клавиатуры тоже инкапсулирована здесь
        this.isMovingLeft = false;
        this.isMovingRight = false;

        this.setupEventListeners();
    }

    // Приватный метод для настройки слушателей событий (Инкапсуляция деталей)
    setupEventListeners() {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') this.isMovingLeft = true;
            if (e.key === 'ArrowRight') this.isMovingRight = true;
        });
        document.addEventListener('keyup', (e) => {
            if (e.key === 'ArrowLeft') this.isMovingLeft = false;
            if (e.key === 'ArrowRight') this.isMovingRight = false;
        });
    }

    // Переопределяем метод update (Полиморфизм)
    update() {
        // Двигаем платформу в зависимости от состояния флагов
        if (this.isMovingLeft) {
            this.x -= this.speed;
        }
        if (this.isMovingRight) {
            this.x += this.speed;
        }

        // Ограничиваем движение платформы границами холста
        // Логика "не выйти за границы" инкапсулирована здесь
        if (this.x < 0) this.x = 0;
        if (this.x + this.width > this.canvasWidth) this.x = this.canvasWidth - this.width;
    }
}

// ==================== КЛАСС МЯЧА ====================
class Ball extends GameObject {
    constructor(x, y, radius, color, speed) {
        // Для круга используем radius, но наследуем x, y, color
        super(x, y, radius * 2, radius * 2, color);
        this.radius = radius;
        // Инкапсулируем вектор скорости
        this.dx = speed;
        this.dy = -speed; // Начинаем с движения вверх
    }

    // Переопределяем draw для отрисовки круга (Полиморфизм)
    draw(ctx) {
        ctx.beginPath();
        ctx.arc(this.x + this.radius, this.y + this.radius, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.fill();
        ctx.closePath();
    }

    update() {
        // Обновляем позицию на основе скорости
        this.x += this.dx;
        this.y += this.dy;
    }

    // Публичный метод для обработки столкновений со стенами
    handleWallCollision(canvasWidth, canvasHeight) {
        // Левая и правая стена
        if (this.x < 0 || this.x + this.width > canvasWidth) {
            this.dx = -this.dx;
        }
        // Верхняя стена
        if (this.y < 0) {
            this.dy = -this.dy;
        }
        // Нижняя стена (промах) обрабатывается в основном игровом цикле
    }

    // Публичный метод для сброса позиции мяча
    reset(x, y, speed) {
        this.x = x;
        this.y = y;
        this.dx = speed;
        this.dy = -speed;
    }
}

// ==================== КЛАСС КИРПИЧА ====================
class Brick extends GameObject {
    constructor(x, y, width, height, color, points) {
        super(x, y, width, height, color);
        // Инкапсулируем очки и состояние кирпича
        this.points = points;
        this.status = 1; // 1 - активен, 0 - разрушен
    }

    // Переопределяем draw: рисуем только если кирпич активен
    draw(ctx) {
        if (this.status === 1) {
            super.draw(ctx); // Используем реализацию родительского класса
            // Можно добавить обводку для красоты
            ctx.strokeStyle = '#555';
            ctx.strokeRect(this.x, this.y, this.width, this.height);
        }
    }
}

// ==================== КЛАСС ИГРЫ (ГЛАВНЫЙ КООРДИНАТОР) ====================
// Этот класс инкапсулирует всю игровую логику и связывает все объекты вместе.
class Game {
    constructor() {
        this.canvas = document.getElementById('gameCanvas');
        this.ctx = this.canvas.getContext('2d');
        this.scoreElement = document.getElementById('score');
        this.score = 0;
        this.gameOver = false;
        this.bricks = [];

        this.setup();
        this.gameLoop();
    }

    // Настройка игровых объектов
    setup() {
        // Создаем платформу (Наследование от GameObject)
        const paddleWidth = 100;
        const paddleHeight = 20;
        const paddleX = (this.canvas.width - paddleWidth) / 2;
        this.paddle = new Paddle(paddleX, this.canvas.height - paddleHeight - 10, paddleWidth, paddleHeight, '#0095dd', this.canvas.width);

        // Создаем мяч (Наследование от GameObject)
        const ballRadius = 10;
        const ballX = this.canvas.width / 2;
        const ballY = this.canvas.height - 30;
        this.ball = new Ball(ballX, ballY, ballRadius, '#0095dd', 5);

        // Создаем сетку кирпичей (Наследование от GameObject)
        this.createBricks();
    }

    createBricks() {
        const brickRowCount = 5;
        const brickColumnCount = 9;
        const brickWidth = 75;
        const brickHeight = 20;
        const brickPadding = 10;
        const brickOffsetTop = 30;
        const brickOffsetLeft = 30;

        this.bricks = [];
        for (let c = 0; c < brickColumnCount; c++) {
            this.bricks[c] = [];
            for (let r = 0; r < brickRowCount; r++) {
                const brickX = c * (brickWidth + brickPadding) + brickOffsetLeft;
                const brickY = r * (brickHeight + brickPadding) + brickOffsetTop;
                // Используем разные цвета для каждого ряда
                const hue = 360 * r / brickRowCount;
                const brickColor = `hsl(${hue}, 70%, 60%)`;
                // Создаем новый объект кирпича и помещаем его в массив
                this.bricks[c][r] = new Brick(brickX, brickY, brickWidth, brickHeight, brickColor, 10);
            }
        }
    }

    // Метод для проверки столкновений (Абстракция сложной логики)
    collisionDetection() {
        // Проверяем столкновение мяча с кирпичами
        for (let c = 0; c < this.bricks.length; c++) {
            for (let r = 0; r < this.bricks[c].length; r++) {
                const brick = this.bricks[c][r];
                // Если кирпич активен, проверяем столкновение
                if (brick.status === 1) {
                    if (
                        this.ball.x + this.ball.radius > brick.x &&
                        this.ball.x - this.ball.radius < brick.x + brick.width &&
                        this.ball.y + this.ball.radius > brick.y &&
                        this.ball.y - this.ball.radius < brick.y + brick.height
                    ) {
                        // Если столкновение произошло, меняем направление мяча и "ломаем" кирпич
                        this.ball.dy = -this.ball.dy;
                        brick.status = 0;
                        this.score += brick.points;
                        this.scoreElement.textContent = `Счёт: ${this.score}`;
                    }
                }
            }
        }

        // Проверяем столкновение мяча с платформой
        if (
            this.ball.x + this.ball.radius > this.paddle.x &&
            this.ball.x - this.ball.radius < this.paddle.x + this.paddle.width &&
            this.ball.y + this.ball.radius > this.paddle.y &&
            this.ball.y - this.ball.radius < this.paddle.y + this.paddle.height
        ) {
            // Мяч отскакивает вверх при ударе о платформу
            this.ball.dy = -Math.abs(this.ball.dy); // Гарантируем, что dy всегда отрицательный (вверх)
            // Меняем горизонтальное направление в зависимости от того, в какую часть платформы попали
            const hitPos = (this.ball.x - this.paddle.x) / this.paddle.width;
            this.ball.dx = 10 * (hitPos - 0.5); // -5 to 5
        }
    }

    // Проверка на победу
    checkWin() {
        let allDestroyed = true;
        for (let c = 0; c < this.bricks.length; c++) {
            for (let r = 0; r < this.bricks[c].length; r++) {
                if (this.bricks[c][r].status === 1) {
                    allDestroyed = false;
                    break;
                }
            }
        }
        if (allDestroyed) {
            alert('ПОБЕДА! Ваш счёт: ' + this.score);
            document.location.reload();
        }
    }

    // Главный игровой цикл
    gameLoop() {
        // Очищаем холст
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // ОБНОВЛЕНИЕ СОСТОЯНИЯ (Вызываем update у всех активных объектов)
        this.paddle.update();
        this.ball.update();
        this.ball.handleWallCollision(this.canvas.width, this.canvas.height);

        // Проверяем столкновения
        this.collisionDetection();

        // ОТРИСОВКА (Вызываем draw у всех объектов)
        this.paddle.draw(this.ctx);
        this.ball.draw(this.ctx);
        for (let c = 0; c < this.bricks.length; c++) {
            for (let r = 0; r < this.bricks[c].length; r++) {
                this.bricks[c][r].draw(this.ctx);
            }
        }

        // Проверяем условия окончания игры
        if (this.ball.y + this.ball.radius > this.canvas.height) {
            alert('ИГРА ОКОНЧЕНА! Ваш счёт: ' + this.score);
            document.location.reload();
        }

        this.checkWin();

        // Запрашиваем следующий кадр анимации, если игра не окончена
        if (!this.gameOver) {
            requestAnimationFrame(() => this.gameLoop());
        }
    }
}

// Запускаем игру, когда страница загрузится
window.onload = function () {
    new Game();
};