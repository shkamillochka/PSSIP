<?php
// Задание 2: Текущая дата и дата через неделю
echo '<div class="result">';
echo '<p><strong>Текущая дата и время:</strong> ' . date('d.m.Y H:i:s') . '</p>';
echo '<p><strong>Дата и время через неделю:</strong> ' . date('d.m.Y H:i:s', strtotime('+1 week')) . '</p>';
echo '</div>';
?>