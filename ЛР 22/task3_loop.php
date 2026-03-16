<?php
// Задание 3: Вывод фамилии и имени N+5 раз (N=19 → 24 раза)
$count = N + 5; // 19+5 = 24
$i = 0;

echo '<div class="result">';
echo '<p>Вывод фамилии и имени ' . $count . ' раз(а):</p>';
echo '<p>';

do {
    echo 'Шикута Камилла, ';
    $i++;
} while ($i < $count);

echo '</p>';
echo '</div>';
?>