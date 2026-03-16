<?php
// Задание 4: Массивы
echo '<div class="result">';

// Исходный массив из 5 целых элементов
$numbers = [4, -2, 8, -6, 3];
echo '<p><strong>Исходный массив:</strong> [' . implode(', ', $numbers) . ']</p>';

// Сумма положительных элементов
$sum = 0;
foreach ($numbers as $num) {
    if ($num > 0) {
        $sum += $num;
    }
}
echo '<p><strong>Сумма положительных элементов:</strong> ' . $sum . '</p>';

// Сортировка по возрастанию
$sorted = $numbers;
sort($sorted);
echo '<p><strong>Массив после сортировки (по возрастанию):</strong> [' . implode(', ', $sorted) . ']</p>';

echo '</div>';
?>