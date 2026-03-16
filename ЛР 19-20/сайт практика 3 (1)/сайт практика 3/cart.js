// cart.js - Функционал каталога и корзины

document.addEventListener('DOMContentLoaded', function() {
  // Элементы DOM
  const catalogContainer = document.getElementById('catalogContainer');
  const cartContainer = document.getElementById('cartContainer');
  const cartCount = document.getElementById('cartCount');
  const cartTotal = document.getElementById('cartTotal');
  const checkoutBtn = document.getElementById('checkoutBtn');
  const clearCartBtn = document.getElementById('clearCartBtn');
  
  // Данные корзины из LocalStorage или пустой массив
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  
  // Загрузка каталога из JSON
  async function loadCatalog() {
    try {
      const response = await fetch('services.json');
      const services = await response.json();
      renderCatalog(services);
      updateCartUI();
    } catch (error) {
      console.error('Ошибка загрузки каталога:', error);
      catalogContainer.innerHTML = '<p class="error">Не удалось загрузить каталог услуг</p>';
    }
  }
  
  // Отображение каталога
  function renderCatalog(services) {
    catalogContainer.innerHTML = '';
    
    services.forEach(service => {
      const isInCart = cart.some(item => item.id === service.id);
      
      const serviceCard = document.createElement('div');
      serviceCard.className = 'service-card';
      serviceCard.innerHTML = `
        <img src="${service.image}" alt="${service.title}" class="service-image">
        <h3 class="service-title">${service.title}</h3>
        <p class="service-description">${service.description}</p>
        <div class="service-details">
          <span class="service-age">Возраст: ${service.age}</span>
          <span>${service.duration}</span>
        </div>
        <div class="service-price">${service.price} руб.</div>
        <button class="add-to-cart-btn" data-id="${service.id}" ${isInCart ? 'disabled' : ''}>
          ${isInCart ? 'Добавлено в корзину' : 'Добавить в корзину'}
        </button>
      `;
      
      catalogContainer.appendChild(serviceCard);
    });
    
    // Добавляем обработчики для кнопок
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const serviceId = parseInt(this.dataset.id);
        addToCart(serviceId, services);
      });
    });
  }
  
  // Добавление в корзину
  function addToCart(serviceId, services) {
    const service = services.find(s => s.id === serviceId);
    
    if (!service) return;
    
    // Проверяем, есть ли уже в корзине
    const existingItem = cart.find(item => item.id === serviceId);
    
    if (existingItem) {
      existingItem.quantity += 1;
    } else {
      cart.push({
        ...service,
        quantity: 1
      });
    }
    
    // Сохраняем в LocalStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Обновляем UI
    updateCartUI();
    
    // Обновляем кнопки в каталоге
    const addBtn = document.querySelector(`.add-to-cart-btn[data-id="${serviceId}"]`);
    if (addBtn) {
      addBtn.textContent = 'Добавлено в корзину';
      addBtn.disabled = true;
    }
    
    // Показываем уведомление
    showNotification(`${service.title} добавлен в корзину!`);
  }
  
  // Обновление корзины
  function updateCartUI() {
    // Обновляем счетчик
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
    
    // Обновляем общую сумму
    const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    cartTotal.textContent = totalPrice;
    
    // Отображаем товары в корзине
    renderCart();
  }
  
  // Отображение корзины
  function renderCart() {
    if (cart.length === 0) {
      cartContainer.innerHTML = '<p class="empty-cart">Корзина пуста</p>';
      return;
    }
    
    cartContainer.innerHTML = '';
    
    cart.forEach((item, index) => {
      const cartItem = document.createElement('div');
      cartItem.className = 'cart-item';
      cartItem.innerHTML = `
        <div class="cart-item-info">
          <h4>${item.title}</h4>
          <p>${item.description}</p>
          <p>Возраст: ${item.age}</p>
        </div>
        <div class="cart-item-actions">
          <div class="quantity-control">
            <button class="quantity-btn minus-btn" data-index="${index}">-</button>
            <span class="quantity">${item.quantity}</span>
            <button class="quantity-btn plus-btn" data-index="${index}">+</button>
          </div>
          <div class="cart-item-price">${item.price * item.quantity} руб.</div>
          <button class="remove-btn" data-index="${index}">Удалить</button>
        </div>
      `;
      
      cartContainer.appendChild(cartItem);
    });
    
    // Добавляем обработчики
    document.querySelectorAll('.minus-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const index = parseInt(this.dataset.index);
        updateQuantity(index, -1);
      });
    });
    
    document.querySelectorAll('.plus-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const index = parseInt(this.dataset.index);
        updateQuantity(index, 1);
      });
    });
    
    document.querySelectorAll('.remove-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const index = parseInt(this.dataset.index);
        removeFromCart(index);
      });
    });
  }
  
  // Изменение количества
  function updateQuantity(index, change) {
    if (index < 0 || index >= cart.length) return;
    
    cart[index].quantity += change;
    
    if (cart[index].quantity <= 0) {
      cart.splice(index, 1);
    }
    
    // Сохраняем изменения
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartUI();
    
    // Обновляем кнопки в каталоге
    updateCatalogButtons();
  }
  
  // Удаление из корзины
  function removeFromCart(index) {
    if (index < 0 || index >= cart.length) return;
    
    const removedItem = cart.splice(index, 1)[0];
    
    // Сохраняем изменения
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartUI();
    
    // Обновляем кнопки в каталоге
    updateCatalogButtons();
    
    showNotification(`${removedItem.title} удален из корзины`);
  }
  
  // Обновление кнопок в каталоге
  function updateCatalogButtons() {
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
      const serviceId = parseInt(btn.dataset.id);
      const isInCart = cart.some(item => item.id === serviceId);
      
      btn.disabled = isInCart;
      btn.textContent = isInCart ? 'Добавлено в корзину' : 'Добавить в корзину';
    });
  }
  
  // Очистка корзины
  function clearCart() {
    if (cart.length === 0) return;
    
    if (confirm('Вы уверены, что хотите очистить корзину?')) {
      cart = [];
      localStorage.removeItem('cart');
      updateCartUI();
      updateCatalogButtons();
      showNotification('Корзина очищена');
    }
  }
  
  // Оформление заказа
  function checkout() {
    if (cart.length === 0) {
      alert('Корзина пуста. Добавьте услуги в корзину.');
      return;
    }
    
    const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const servicesList = cart.map(item => `${item.title} (x${item.quantity})`).join(', ');
    
    // Показываем модальное окно с формой
    showCheckoutModal(servicesList, totalPrice);
  }
  
  // Показать модальное окно оформления заказа
  function showCheckoutModal(services, total) {
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.id = 'checkoutModal';
    
    modal.innerHTML = `
      <div class="modal-content">
        <h3>Оформление заявки на услуги</h3>
        <p>Выбранные услуги: ${services}</p>
        <p>Общая сумма: <strong>${total} руб.</strong></p>
        
        <form id="checkoutForm">
          <div class="form-group">
            <input type="text" id="checkoutName" placeholder="Ваше имя" required>
          </div>
          <div class="form-group">
            <input type="tel" id="checkoutPhone" placeholder="Номер телефона" required>
          </div>
          <div class="form-group">
            <input type="email" id="checkoutEmail" placeholder="Email" required>
          </div>
          <div class="form-group">
            <textarea id="checkoutComment" placeholder="Комментарий (необязательно)" rows="3"></textarea>
          </div>
          
          <div class="modal-buttons">
            <button type="submit" class="submit-btn">Отправить заявку</button>
            <button type="button" class="cancel-btn">Отмена</button>
          </div>
        </form>
      </div>
    `;
    
    document.body.appendChild(modal);
    modal.style.display = 'flex';
    
    // Обработка отправки формы
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = {
        name: document.getElementById('checkoutName').value,
        phone: document.getElementById('checkoutPhone').value,
        email: document.getElementById('checkoutEmail').value,
        comment: document.getElementById('checkoutComment').value,
        services: cart,
        total: total
      };
      
      // В реальном приложении здесь была бы отправка на сервер
      console.log('Заявка отправлена:', formData);
      
      alert('Спасибо! Ваша заявка принята. Мы свяжемся с вами в течение часа.');
      
      // Очищаем корзину после оформления
      cart = [];
      localStorage.removeItem('cart');
      updateCartUI();
      updateCatalogButtons();
      
      // Закрываем модальное окно
      modal.remove();
    });
    
    // Кнопка отмены
    modal.querySelector('.cancel-btn').addEventListener('click', function() {
      modal.remove();
    });
    
    // Закрытие по клику вне окна
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        modal.remove();
      }
    });
  }
  
  // Всплывающее уведомление
  function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    notification.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      background: #8081bd;
      color: white;
      padding: 15px 25px;
      border-radius: 10px;
      z-index: 10000;
      font-family: Montserrat, sans-serif;
      animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.style.animation = 'slideOut 0.3s ease';
      setTimeout(() => notification.remove(), 300);
    }, 3000);
  }
  
  // Добавляем CSS анимации
  const style = document.createElement('style');
  style.textContent = `
    @keyframes slideIn {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
    
    @keyframes slideOut {
      from {
        transform: translateX(0);
        opacity: 1;
      }
      to {
        transform: translateX(100%);
        opacity: 0;
      }
    }
    
    #checkoutModal .modal-content {
      max-width: 500px;
      padding: 30px;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-family: Montserrat, sans-serif;
      font-size: 16px;
    }
    
    .modal-buttons {
      display: flex;
      gap: 15px;
      margin-top: 25px;
    }
    
    .submit-btn {
      background: #8081bd;
      color: white;
      border: none;
      padding: 15px 30px;
      border-radius: 8px;
      font-family: Montserrat, sans-serif;
      font-size: 16px;
      cursor: pointer;
      flex: 1;
    }
    
    .cancel-btn {
      background: #f0f0f0;
      color: #334055;
      border: none;
      padding: 15px 30px;
      border-radius: 8px;
      font-family: Montserrat, sans-serif;
      font-size: 16px;
      cursor: pointer;
      flex: 1;
    }
  `;
  document.head.appendChild(style);
  
  // Назначаем обработчики кнопкам
  checkoutBtn.addEventListener('click', checkout);
  clearCartBtn.addEventListener('click', clearCart);
  
  // Загружаем каталог
  loadCatalog();
});