// script.js
document
  .getElementById("registrationForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Предотвращаем отправку формы по умолчанию

    // Получаем значения полей
    const body = document.body;
    const name = document.getElementById("name").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const email = document.getElementById("email").value.trim();
    const agreement = document.getElementById("agreement").checked;

    // Валидация имени
    if (!name) {
      alert("Пожалуйста, введите ваше имя.");
      return;
    }

    // Валидация телефона
    if (!phone) {
      alert(
        "Пожалуйста, введите корректный номер телефона в формате +7XXXXXXXXXX."
      );
      return;
    }

    // Валидация email
    if (
      email &&
      !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)
    ) {
      alert("Пожалуйста, введите корректный email.");
      return;
    }

    // Валидация согласия
    if (!agreement) {
      alert("Пожалуйста, подтвердите согласие с пользовательским соглашением.");
      return;
    }

    // Если все поля прошли валидацию, показываем модальное окно
    const modal = document.getElementById("modal");
    modal.style.display = "flex"; // Показываем модальное окно
    body.classList.add("lock");

    // Очищаем поля формы
    this.reset(); // Сбрасываем все поля формы
  });

// script.js

// Закрытие модального окна
document.getElementById("closeModal").addEventListener("click", function () {
  const modal = document.getElementById("modal");
  const body = document.body;
  body.classList.remove("lock");
  modal.style.display = "none"; // Скрываем модальное окно
});

document.querySelector('.rectangle').addEventListener('click', function (event) {
  event.preventDefault(); // Предотвращаем действие по умолчанию

  const body = document.body;
  const name = document.getElementById("name")?.value.trim();
  const phone = document.getElementById("phone")?.value.trim();
  const email = document.getElementById("email")?.value.trim();
  const agreement = document.getElementById("agreement")?.checked;

  // Валидация полей
  if (!name) return alert("Пожалуйста, введите ваше имя.");
  if (!phone || !/^\+7\d{10}$/.test(phone)) {
    return alert("Номер телефона должен быть в формате +7XXXXXXXXXX");
  }
  if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    return alert("Пожалуйста, введите корректный email.");
  }
  if (!agreement) return alert("Необходимо подтвердить согласие");

  // Показ модального окна
  const modal = document.getElementById("modal");
  if (modal) {
    modal.style.display = "flex";
    body.classList.add("lock");
  }

  // Сброс формы
  const form = document.getElementById("registrationForm");
  form?.reset();
});

// Закрытие модального окна
document.getElementById("closeModal")?.addEventListener('click', function () {
  document.body.classList.remove("lock");
  document.getElementById("modal").style.display = "none";
});

document.querySelector('.social-media').addEventListener('click', function () {
  window.open('https://t.me/kidsstory_club', '_blank');
});

document.addEventListener('DOMContentLoaded', function () {
  const callbackButton = document.getElementById('callback');

  callbackButton.addEventListener('click', function () {
    alert('Для заказа позвоните +375 29 763-21-54');
  });
});

document.addEventListener('DOMContentLoaded', function () {
  // Находим элемент логотипа
  const logo = document.querySelector('.logo');

  // Добавляем обработчик клика
  logo.addEventListener('click', function () {
    // Перезагружаем страницу
    location.reload(true);
  });

  // Опционально: добавляем стиль курсора для индикации кликабельности
  logo.style.cursor = 'pointer';
});

document.addEventListener('DOMContentLoaded', function () {
  const logo = document.querySelector('.logo-d0');

  if (logo) {
    logo.style.cursor = 'pointer';

    logo.addEventListener('click', function (e) {
      e.preventDefault();

      // Плавная прокрутка к началу страницы
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });

      // Альтернативный вариант с анимацией
      // scrollToTop(600);
    });
  }
});

document.querySelector('.photos-videos').addEventListener('click', function (e) {
  e.preventDefault();

  const targetElement = document.querySelector('.you-can-see-how-our-weekdays-go');

  if (targetElement) {
    // Плавная прокрутка к заголовку галереи
    targetElement.scrollIntoView({
      behavior: 'smooth',
      block: 'start' // Можно изменить на 'center' или 'end'
    });

    // Визуальное выделение заголовка
    targetElement.style.transition = 'all 0.3s';
    targetElement.style.backgroundColor = 'rgba(255,235,0,0.2)';
    setTimeout(() => {
      targetElement.style.backgroundColor = '';
    }, 2000);
  }
});

document.querySelector('.menu-item.team').addEventListener('click', function (e) {
  e.preventDefault();

  const targetElement = document.querySelector('.span-our-team');

  if (targetElement) {
    // Плавная прокрутка к разделу
    targetElement.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    });

    // Визуальная индикация цели
    targetElement.style.transition = 'all 0.3s';
    targetElement.style.outline = '2px solid #4CAF50';
    targetElement.style.outlineOffset = '5px';

    // Убираем подсветку через 2 секунды
    setTimeout(() => {
      targetElement.style.outline = 'none';
    }, 2000);
  }
});

document.querySelector('.menu-item.about-us').addEventListener('click', function (e) {
  e.preventDefault();

  const targetElement = document.querySelector('.about-center');

  if (targetElement) {
    // Плавная прокрутка к разделу
    targetElement.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    });

    // Визуальная анимация подсветки
    targetElement.animate([
      { backgroundColor: 'rgba(255,228,0,0.3)' },
      { backgroundColor: 'transparent' }
    ], {
      duration: 1500,
      easing: 'ease-out'
    });
  }
});


document.querySelector('.send-button').addEventListener('click', function (e) {
  e.preventDefault();

  // Показываем системное диалоговое окно
  const isConfirmed = confirm("Ожидайте звонка в течение одного рабочего дня\n\nДля срочных вопросов звоните +375 29 763-21-54");

  // Дополнительные действия после подтверждения
  if (isConfirmed) {
    console.log("Пользователь подтвердил");
    // Здесь можно добавить отправку формы или другие действия
  }
});

document.querySelector('.send').addEventListener('click', function (e) {
  e.preventDefault();

  // Получаем элементы
  const phoneInput = document.getElementById('phone');
  const agreementCheckbox = document.getElementById('agreement');

  // Проверяем заполнение полей
  const phoneValue = phoneInput.value.trim();
  const isAgreementChecked = agreementCheckbox.checked;

  // Валидация телефона (минимум 11 цифр, включая +7)
  const phoneDigits = phoneValue.replace(/\D/g, '');
  const isPhoneValid = phoneDigits.length === 11 && phoneDigits.startsWith('7');

  // Если все правильно - показываем диалог
  const isConfirmed = confirm("Ожидайте звонка в течение одного рабочего дня\n\nДля срочных вопросов звоните +375 29 763-21-54");

  if (isConfirmed) {
    // Отправка формы
    this.closest('form').submit();
  }
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
let currentSlideIndex = 0; // Текущий индекс слайда
const teamSlides = document.querySelectorAll('.slide-item'); // Получаем все слайды команды
const totalTeamSlides = teamSlides.length; // Общее количество слайдов команды

// Определяем размер сдвига в зависимости от устройства
function determineSlideWidth() {
  if (window.innerWidth >= 1024) { // ПК версия
    return 315;
  } else if (window.innerWidth >= 480) { // Планшетная версия
    return 159;
  } else { // Мобильная версия
    return 120;
  }
}

function calculateTotalSlides() {
  if (window.innerWidth >= 1024) { // ПК версия
    return teamSlides.length - 4;
  } else if (window.innerWidth >= 480) { // Планшетная версия
    return teamSlides.length - 4;
  } else { // Мобильная версия
    return teamSlides.length;
  }
}

// Функция обновления карусели команды
function refreshCarousel(slideWidth) {
  const newTransformValue = -currentSlideIndex * slideWidth; // Вычисляем новое значение для трансформации
  document.querySelector('.menu_vidim_hid').style.transform = `translateX(${newTransformValue}px)`;// Исправлено: добавлены обратные кавычки
}

// Обработчик события для кнопки "вперед"
document.querySelector('.left').addEventListener('click', () => {
  const slideWidth = determineSlideWidth();
  currentSlideIndex = (currentSlideIndex + 1) % calculateTotalSlides(); // Переход к следующему слайду
  refreshCarousel(slideWidth);
});

// Обработчик события для кнопки "назад"
document.querySelector('.right').addEventListener('click', () => {
  const slideWidth = determineSlideWidth();
  currentSlideIndex = (currentSlideIndex - 1 + calculateTotalSlides()) % calculateTotalSlides(); // Переход к предыдущему слайду
  refreshCarousel(slideWidth);
});

// Автоматическая прокрутка
let autoScrollTimer = setInterval(() => {
  const slideWidth = determineSlideWidth();
  currentSlideIndex = (currentSlideIndex + 1) % calculateTotalSlides(); // Переход к следующему слайду
  refreshCarousel(slideWidth);
}, 3000); // Интервал в 3000 мс (3 секунды)

// Остановка автоматической прокрутки при наведении или касании
const carouselContainer = document.querySelector('.menu_vidim');

carouselContainer.addEventListener('mouseenter', () => {
  clearInterval(autoScrollTimer); // Остановка автоматической прокрутки
});

carouselContainer.addEventListener('mouseleave', () => {
  autoScrollTimer = setInterval(() => {
    const slideWidth = determineSlideWidth();
    currentSlideIndex = (currentSlideIndex + 1) % calculateTotalSlides(); // Переход к следующему слайду
    refreshCarousel(slideWidth);
  }, 3000); // Возобновление автоматической прокрутки
});

// Управление с помощью жестов на мобильных устройствах
let startTouchX = null;

carouselContainer.addEventListener('touchstart', (event) => {
  startTouchX = event.touches[0].clientX; // Запоминаем начальную позицию касания
  clearInterval(autoScrollTimer); // Остановка автоматической прокрутки при касании
});

carouselContainer.addEventListener('touchmove', (event) => {
  if (!startTouchX) return;

  const currentTouchX = event.touches[0].clientX;
  const diffX = startTouchX - currentTouchX;

  const slideWidth = determineSlideWidth(); // Получаем ширину слайда для мобильных устройств

  if (diffX > 50) { // Проведение влево
    currentSlideIndex = (currentSlideIndex + 1) % calculateTotalSlides(); // Переход к следующему слайду
    refreshCarousel(slideWidth);
    startTouchX = null; // Сбрасываем начальную позицию
  } else if (diffX < -50) { // Проведение вправо
    currentSlideIndex = (currentSlideIndex - 1 + calculateTotalSlides()) % calculateTotalSlides(); // Переход к предыдущему слайду
    refreshCarousel(slideWidth);
    startTouchX = null; // Сбрасываем начальную позицию
  }
});

// Восстановление автоматической прокрутки после завершения жеста
carouselContainer.addEventListener('touchend', () => {
  autoScrollTimer = setInterval(() => {
    const slideWidth = determineSlideWidth();
    currentSlideIndex = (currentSlideIndex + 1) % calculateTotalSlides(); // Переход к следующему слайду
    refreshCarousel(slideWidth);
  }, 3000); // Возобновление автоматической прокрутки
});

// В самом конце main.js добавляем
// Подключение функционала корзины
const cartScript = document.createElement('script');
cartScript.src = 'cart.js';
cartScript.defer = true;
document.head.appendChild(cartScript);

let cart = [];

// Загрузка данных из JSON
async function loadCatalog() {
    const response = await fetch('services.json');
    const services = await response.json();
    renderCatalog(services);
}

function renderCatalog(services) {
    const catalogContainer = document.querySelector('.flex-row-de'); // Используем существующий класс из HTML
    catalogContainer.innerHTML = services.map(item => `
        <div class="service-card">
            <span>${item.name}</span>
            <span>${item.price} руб.</span>
            <button onclick="addToCart(${item.id}, '${item.name}', ${item.price})">В корзину</button>
        </div>
    `).join('');
}

function addToCart(id, name, price) {
    cart.push({id, name, price});
    updateCartUI();
}

function updateCartUI() {
    console.log("Товаров в корзине:", cart.length);
    // Здесь можно добавить логику отображения списка в модальном окне
}

loadCatalog();

