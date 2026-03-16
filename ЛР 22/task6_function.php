<?php
// Задание 6: Пользовательская функция с обработкой ошибок

/**
 * Расчет функции y = f(x) с обработкой деления на ноль
 */
function calculateY($x) {
    // Проверка деления на ноль (знаменатель x^2 + x)
    $denominator = $x * $x + $x;
    
    if ($denominator == 0) {
        throw new Exception("Ошибка: деление на ноль при x = $x (знаменатель равен 0)");
    }
    
    if ($x >= 2) {
        $y = ($x * $x - 15) / $denominator;
    } elseif ($x > 0 && $x < 2) {
        $y = (2 * $x - 1) / $denominator;
    } elseif ($x < 0) {
        $y = 0 / $denominator; // 0 / любое = 0
    } else {
        // x = 0 (уже обработано выше)
        throw new Exception("Ошибка: x = 0 вызывает деление на ноль");
    }
    
    return $y;
}

echo '<div class="result">';
echo '<p><strong>Тестирование функции для разных x:</strong></p>';

// Массив тестовых значений
$testValues = [5, 1.5, -3, 0, 2, -1];

foreach ($testValues as $x) {
    try {
        $y = calculateY($x);
        echo "<p>f($x) = " . number_format($y, 4) . "</p>";
    } catch (Exception $e) {
        echo '<p class="error">' . $e->getMessage() . '</p>';
    }
}

echo '</div>';
?>