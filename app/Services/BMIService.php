<?php
namespace App\Services;

class BMIService
{
    public static function calculateBMI(
        float $heightCm,
        float $weightKg,
        int $gender = 1,
        int $age = 25
    ): array {
        $heightMeter = $heightCm / 100;

        // BMI formula
        $bmi = $weightKg / ($heightMeter * $heightMeter);

        // BMI category
        if ($bmi < 18.5) {
            $category = 'Underweight';
        } elseif ($bmi < 24.9) {
            $category = 'Normal weight';
        } elseif ($bmi < 29.9) {
            $category = 'Overweight';
        } else {
            $category = 'Obese';
        }

        // Healthy weight range (BMI based)
        $minWeight = 18.5 * ($heightMeter * $heightMeter);
        $maxWeight = 24.9 * ($heightMeter * $heightMeter);

        $heightInches = $heightCm / 2.54;
        $baseHeight = 60; // 5 feet

        if ($gender == 1) { // Male
            $baseWeight = 50;
            $perInch = 2.3;
            $genderText = 'Male';
        } else { // Female
            $baseWeight = 45.5;
            $perInch = 2.3;
            $genderText = 'Female';
        }

        if ($heightInches <= $baseHeight) {
            $idealWeight = $baseWeight;
        } else {
            $idealWeight = $baseWeight + ($heightInches - $baseHeight) * $perInch;
        }

        // Range ±5%
        $gap = 2.5;

        $idealMin = $idealWeight - $gap;
        $idealMax = $idealWeight + $gap;

        // -------------------------------
        // Notes
        // -------------------------------

        $idealNote = ($gender == 2)
            ? 'Women naturally have slightly higher body fat percentage'
            : 'Men typically have higher muscle mass';

        $ageNote = ($age > 50)
            ? 'For older adults, slightly higher BMI may be acceptable'
            : 'Standard BMI range applies';

        return [
            'bmi' => round($bmi, 2),
            'category' => $category,
            'healthyWeightRange' => round($minWeight) . ' - ' . round($maxWeight) . ' Kg',
            'healthyBmiRange' => '18.5 - 24.9',
            'idealWeight' => round($idealWeight) . ' Kg',
            'idealWeightRange' => round($idealMin) . ' - ' . round($idealMax) . ' Kg',
            'gender' => $genderText,
            'genderNote' => $idealNote,
            'ageNote' => $ageNote,
        ];
    }

    public static function calculateBMI_old(float $heightCm, float $weightKg): array
    {
        $heightMeter = $heightCm / 100;
        $bmi = round($weightKg / ($heightMeter * $heightMeter), 2);
        $minWeight = round(18.5 * $heightMeter * $heightMeter);
        $maxWeight = round(24.9 * $heightMeter * $heightMeter);

        return [
            'bmi' => $bmi,
            'healthyWeightRange' => "$minWeight - $maxWeight Kg",
            'healthyBmiRange' => '18.5 - 24.9',
        ];
    }

    public static function styleBMI(float $bmi): array
    {
        if ($bmi < 18.5) {
            $category = 'Underweight';
            $titleText = 'UNDERWEIGHT';
            $bgColor = "linear-gradient(180deg, rgba(220,234,255,1), rgba(255,255,255,1))";
            $titleColor = '#3b82f6';
            $message = 'Your body weight is below the recommended range.';
        } elseif ($bmi < 25) {
            $category = 'Normal';
            $titleText = 'GOOD JOB!';
            $bgColor = "linear-gradient(180deg, rgba(219,255,178,1), rgba(255,255,255,1))";
            $titleColor = '#65a30d';
            $message = "You're maintaining a healthy weight.";
        } elseif ($bmi < 30) {
            $category = 'Overweight';
            $titleText = 'OVERWEIGHT';
            $bgColor = "linear-gradient(180deg, rgba(255,213,122,1), rgba(255,255,255,1))";
            $titleColor = '#ca8a04';
            $message = 'You are overweight. Try regular exercise and a balanced diet.';
        } else {
            $category = 'Obese';
            $titleText = 'OBESITY';
            $bgColor = "linear-gradient(180deg, rgba(255,162,162,1), rgba(255,255,255,1))";
            $titleColor = '#ea580c';
            $message = 'Consult a healthcare provider for personalized advice.';
        }
        return [
            'bmi' => $bmi,
            'category' => $category, // Not used yet
            'titleText' => $titleText,
            'message' => $message,
            'bgColor' => $bgColor,
            'titleColor' => $titleColor,
        ];
    }
}