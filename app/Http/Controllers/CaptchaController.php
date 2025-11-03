<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    /**
     * Generate simple math captcha question
     * Returns question and stores answer in session
     */
    public static function generateMathQuestion()
    {
        // Generate two random numbers from 1 to 10 only (easy multiplication)
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        
        // Only multiplication operator
        $operator = '×';
        
        // Calculate answer
        $answer = $num1 * $num2;
        
        // Create question
        $question = $num1 . ' ' . $operator . ' ' . $num2 . ' = ?';
        
        // Store answer in session
        session(['captcha_answer' => $answer]);
        
        return $question;
    }
    
    /**
     * Validate captcha answer
     */
    public static function validate($userAnswer)
    {
        $correctAnswer = session('captcha_answer');
        
        if (!$correctAnswer) {
            return false;
        }
        
        return (int)$userAnswer === (int)$correctAnswer;
    }
}
