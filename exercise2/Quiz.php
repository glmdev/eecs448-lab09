<?php

include_once '../configuration.php';

$request = CommonRequest::capture();

if ( !$request->input() ) {
    system_redirect('exercise2/Quiz.html');
}

$page = new CommonPage();
$page->title('Exercise 2 - EECS 448 Lab 9')
    ->header('Quiz Results');

$questions = require_system('exercise2/questions.php');

$total_points = sizeof($questions);
$scored_points = 0;

foreach ( $questions as $q_idx => $question ) {
    $page->div(function() use($q_idx, $page, $question, $request, &$scored_points) {
        $response = $request->input('question-' . $q_idx);
        $page->writes($question['question']);
        $page->writes('<div style="margin-left: 25px;">You answered: ' . $response . '</div>');

        $correct_answer = null;
        foreach ( $question['answers'] as $answer ) {
            if ( array_key_exists('correct', $answer) && $answer['correct'] ) {
                $correct_answer = $answer['display'];
            }
        }

        $page->writes('<div style="margin-left: 25px;">Correct answer: ' . $correct_answer . '</div>');

        if ( $correct_answer == $response ) {
            $scored_points += 1;
        }
    });
}

$page->div(function() use($page, $total_points, &$scored_points) {
    $page->writes('Scored points: ' . $scored_points);
    $page->line_break();
    $page->writes('Score: ' . round($scored_points / $total_points, 2) . '%');
});

$page->write();
