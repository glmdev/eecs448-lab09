<?php

require_once './configuration.php';

$page = new CommonPage();

$page->title('EECS 448 - Lab 9')
    ->header('EECS 448 - Lab 9 - Garrett Mills')
    ->writes('
        <ul>
            <li><a href="' . system_url('exercise1') . '">Exercise 1</a></li>
            <li><a href="' . system_url('exercise2/Quiz.html') . '">Exercise 2</a></li>
            <li><a href="' . system_url('exercise3') . '">Exercise 3</a></li>
        </ul>
    ');

$page->write();
