function calculateFunction123() {
    try {
        // Получаем значения из полей ввода
        const x = parseFloat(document.getElementById('x').value);

        // Проверка на корректность ввода
        if (isNaN(x)) {
            throw new Error("Все поля должны содержать числовые значения");
        }

        // Вычисляем значение функции
        const result = calculateMathFunction(x);

        // Выводим результат
        document.getElementById('functionValue').textContent =
            `Значение функции при  x = ${x}: ${result}`;
    } catch (error) {
        // Обработка ошибок
        alert(`Ошибка: ${error.message}`);
    }
}

function calculateMathFunction(x) {
    

    // Вычисление по заданным условиям
    if (x < 0) {
        // Формула: 3*x^2-x
        return (3 * Math.pow(x, 2) - x);
    } else if (x >= 0 && x <= 5) {
        // Формула:крнень(7-х)
        // Проверка нахождения корня из отрицательного
        if (7 - x < 0) {
            throw new Error("Корень из отрицательного числа при X<7");
        }


        return Math.sqrt(7 - x);;
    } else {
        // Формула: 8*x-3
        return 8 * x - 3;
    }
}