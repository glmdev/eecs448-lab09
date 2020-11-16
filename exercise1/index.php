<?php

include_once '../configuration.php';

// compute the multiplication table
$mult_table = [];

for ( $i = 0; $i <= 100; $i += 1 ) {
    for ( $j = 0; $j <= 100; $j += 1 ) {
        if ( $i == 0 && $j == 0 ) {
            $mult_table[0][0] = '';
        } else if ( $i == 0 ) {
            $mult_table[$i][$j] = $j;
        } else if ( $j == 0 ) {
            $mult_table[$i][$j] = $i;
        } else {
            $mult_table[$i][$j] = $i * $j;
        }
    }
}

// write it to the page
$page = new CommonPage();
$page->title('Exercise 1 - EECS 448 Lab 09')
    ->header()
    ->table($mult_table)
    ->write();
