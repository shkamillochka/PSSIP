<?php
// Задание 5: Строки
$s1 = 'Я люблю Гродно';
$s2 = 'Я учусь в Политехническом колледже';

echo '<div class="result">';
echo '<p><strong>S1:</strong> ' . $s1 . '</p>';
echo '<p><strong>S2:</strong> ' . $s2 . '</p>';

// 1. Длина строки S2
echo '<p><strong>1. Длина строки S2:</strong> ' . mb_strlen($s2) . ' символов</p>';

// 2. Выделить N-ый символ в строке S1 (N=19)
$n = N;
// Проверка, чтобы не выйти за границы строки
$s1_length = strlen($s1);
if ($n <= $s1_length) {
    $char = $s1[$n-1]; // нумерация с 0
    echo '<p><strong>2. ' . $n . '-й символ в S1:</strong> "' . $char . '" (ASCII-код: ' . ord($char) . ')</p>';
} else {
    echo '<p class="error">2. Ошибка: в строке S1 нет ' . $n . '-го символа (длина строки ' . $s1_length . ')</p>';
}

// 3. Замена слова "Гродно" на "Беларусь"
$s1_new = str_replace('Гродно', 'Беларусь', $s1);
echo '<p><strong>3. После замены:</strong> ' . $s1_new . '</p>';

echo '</div>';
?>