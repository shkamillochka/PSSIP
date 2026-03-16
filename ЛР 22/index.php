<?php
// Файл: index.php
// Лабораторная работа №22 (Вариант 19)
// Объединение всех заданий через include

// Константа номера варианта
define('N', 19);

// Включаем стили
echo '<!DOCTYPE html>
<html>
<head>
    <title>Лабораторная работа №22 (Вариант 19)</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .task { background: white; margin: 20px 0; padding: 15px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .task h2 { background: #333; color: white; margin: -15px -15px 15px -15px; padding: 10px; border-radius: 10px 10px 0 0; }
        .result { background: #e3f2fd; padding: 10px; border-radius: 5px; margin-top: 10px; }
        .error { color: red; font-weight: bold; background: #ffebee; padding: 5px; border-radius: 3px; }
        code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>Лабораторная работа №22 (PHP)</h1>
    <p><strong>ФИО:</strong> Шикута Камилла Антоновна</p>
    <p><strong>Вариант:</strong> ' . N . '</p>';

// ===================== ЗАДАНИЕ 2: Дата и время =====================
echo '<div class="task">';
echo '<h2>Задание 2: Работа с датой и временем</h2>';
include 'task2_date.php';
echo '</div>';

// ===================== ЗАДАНИЕ 3: Циклы (do while) =====================
echo '<div class="task">';
echo '<h2>Задание 3: Цикл do while</h2>';
include 'task3_loop.php';
echo '</div>';

// ===================== ЗАДАНИЕ 4: Массивы =====================
echo '<div class="task">';
echo '<h2>Задание 4: Работа с массивами</h2>';
include 'task4_array.php';
echo '</div>';

// ===================== ЗАДАНИЕ 5: Строки =====================
echo '<div class="task">';
echo '<h2>Задание 5: Работа со строками</h2>';
include 'task5_strings.php';
echo '</div>';

// ===================== ЗАДАНИЕ 6: Пользовательская функция =====================
echo '<div class="task">';
echo '<h2>Задание 6: Пользовательская функция</h2>';
include 'task6_function.php';
echo '</div>';

echo '</body></html>';
?>