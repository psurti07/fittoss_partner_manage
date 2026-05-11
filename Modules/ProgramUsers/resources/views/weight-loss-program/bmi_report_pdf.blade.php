<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BMI Report</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000" rel="stylesheet">
    <!-- jQuery CDN -->
    <style>
        body {
            font-family: "DM Sans", sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .bmi-report .logo-image {
            text-align: left;
            margin-top: 10px;
        }

        .bmi-report {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            padding: 30px 35px 45px;
        }


        .bmi-report .heading-section {
            margin-bottom: 10px;
        }

        .bmi-report .heading-section h4 {
            text-align: center;
            padding: 0;
            margin-bottom: 10px;
            color: #0D2B20;
        }


        .bmi-report .heading-section h3 {
            font-weight: 700;
            font-size: 26px;
            line-height: 36px;
            color: #144835;
            text-transform: capitalize;
            margin-bottom: 0;
            margin-top: 0;
        }


        .bmi-report table.sample-table {
            width: 100%;
            border-collapse: collapse;
            background: #f8fafc;
            border-radius: 16px;
            overflow: hidden;
            margin-top: 15px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);

        }

        .bmi-report table.sample-table,
        th,
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }



        .bmi-report .maintitle h4 {
            background: #2c7a4d;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 16px;
        }

        .bmi-report .title {
            text-align: left;
        }

        .bmi-report .title h4 {
            margin: 0 0 10px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .bmi-report .box-value h4 {
            margin-bottom: 10px;
        }

        .bmi-report .info-box p {
            color: #212529;
            text-align: left;
            margin: 0 0 5px 0;
        }


        .bmi-report .dietplan-benefits {
            text-align: left;
        }

        .bmi-report .categories-list p {
            position: relative;
            margin-left: 15px;
        }

        .bmi-report .categories-list p:before {
            content: '';
            position: absolute;
            background-color: #212529;
            width: 7px;
            height: 7px;
            border-radius: 100px;
            top: 7px;
            left: -15px;
        }


        .bmi-report .info-box {
            margin: 25px 0;
            border-left: 4px solid #2c7a4d;
            background: #fefefe;
            padding: 16px 20px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .bmi-report .info-box p {
            text-align: left;
        }

        .bmi-report #bmiValue {
            color: #212529;
            margin-bottom: 0;
            margin-top: 10px;
        }


        .bmi-report #bmiCategory {
            margin-bottom: 0;
            margin-top: 10px;
            font-size: 20px;
            font-weight: 600;
            color: #212529;
            /* background: #e6f7ef; */
            display: inline-block;
            padding: 4px 20px;
            border-radius: 40px;
        }

        .bmi-report .status-box {
            background: #e8f7ee;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #c2e8d1;
            margin-top: 20px;
        }

        .bmi-report .dietplan-benefits p .fas {
            margin-right: 5px;
        }

        .bmi-report #userInfo {
            text-align: left;
        }

        .bmi-report .bmi-scale {
            font-size: 0;
            padding: 0;
            white-space: nowrap;
            margin-top: 20px;
        }

        .bmi-report .bmi-scale .under,
        .bmi-report .bmi-scale .normal,
        .bmi-report .bmi-scale .over,
        .bmi-report .bmi-scale .ob1,
        .bmi-report .bmi-scale .ob2,
        .bmi-report .bmi-scale .ob3 {
            width: 14%;
            padding: 10px 5px;
            border-right: 1px solid #fff;
            display: inline-block;
            font-size: 13px;
            display: inline-block;
            margin: 0;
            text-align: center;
            vertical-align: top;
            box-sizing: border-box;
        }

        .bmi-report .you {
            width: 70px;
            margin: 0px auto;
            background: #6f8f3a;
            font-size: 13px;
            color: #fff;
            text-align: center;
            padding: 8px 0;
            font-weight: bold;
            position: relative;
        }

       .you-wrapper {
            position: relative;
            width: 70px;
            margin: 0px auto;
            text-align: center;
        }

        .arrow {
            width: 0;
            height: 0;
            margin: 0 auto;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 10px solid #6f8f3a;
        }

    </style>
</head>

<body>
    
@php
$bmi = $personalDetails->bmi;
if($bmi > 0 && $bmi <= 18.5){
    $degree_p = "-360";
    $bmiCategory ="Underweight";
    $bmiCategoryColor ="#7CFC00";
}elseif ($bmi > 18.5 && $bmi <= 24.9) {
    $degree_p = "-215";
    $bmiCategory ="Normal";
    $bmiCategoryColor ="#32CD32";
}elseif ($bmi > 24.9 && $bmi <= 29.9) {
    $degree_p = "-70";
    $bmiCategory ="Overweight";
    $bmiCategoryColor ="#FFD700";
}elseif ($bmi > 29.9 && $bmi <= 34.9 ) {
    $degree_p = "70";
    $bmiCategory ="Obesity 1";
    $bmiCategoryColor ="#FFA500";
}elseif ($bmi > 34.9 && $bmi <= 39.9 ) {
    $degree_p = "215";
    $bmiCategory ="Obesity 2";
    $bmiCategoryColor ="#FF4500";
}else{
    $degree_p = "360";
    $bmiCategory ="Obesity 3";
    $bmiCategoryColor ="#fF0000";
}
@endphp
    <section class="bmi-report">
        <div class="container">
            <div class="logo-image">
                {{-- <img id="logo-header" src="data:image/png;base64,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" width="110" alt="fittoss"> --}}
                <img id="logo-header" src="data:image/png;base64,{{ base64_encode(file_get_contents("https://fittoss.com/public/storage/images/logo/fittoss-logo.png")) }}" width="110" alt="fittoss" />
            </div>
            <div class="heading-section">
                <h3>Comprehensive BMI Report</h3>
            </div>
            <div class="maintitle">
                <h4>Your Details</h4>
            </div>
            <table class="sample-table">
                <tr>
                    <td>Name</td>
                    <td>{{ $userData->first_name .' '. $userData->last_name }}</td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td>{{ $personalDetails->age }}</td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        {{
                            match($personalDetails->gender) {
                                1 => 'Male',
                                2 => 'Female',
                                3 => 'Other',
                                default => 'N/A'
                            }
                        }}
                    </td>
                </tr>
                <tr>
                    <td>Height (cm)</td>
                    <td>{{ $personalDetails->height }}</td>
                </tr>
                <tr>
                    <td>Weight (kg)</td>
                    <td>{{ $personalDetails->weight }}</td>
                </tr>
            </table>
            <div class="box-value">
                <h4>Your BMI Is</h4>
                <h1 id="bmiValue">{{ $personalDetails->bmi }}</h1>
                <h3 id="bmiCategory" style="background-color: {{ $bmiCategoryColor }}">{{ $bmiCategory }}</h3>
            </div>
            <div class="gauge-wrap">
                <div class="bmi-scale">
                    <div class="under" style="background: #7CFC00;">Underweight<br>
                        &lt; 18.5</div>
                    <div class="normal" style="background: #32CD32;">Normal<br>18.5–24.9</div>
                    <div class="over" style="background: #FFD700;">Overweight<br>25.0–29.9</div>
                    <div class="ob1" style="background: #FFA500;">Obesity 1<br>30–34.9</div>
                    <div class="ob2" style="background: #FF4500;">Obesity 2<br>35–39.9</div>
                    <div class="ob3" style="background: #FF0000;">Obesity 3<br>&gt; 40</div>
                </div>
                <div class="you-wrapper" style="transform: translateX({{ $degree_p }}%);">
                    <div class="arrow"></div>
                    <div class="you" id="category">Current Range</div>
                </div>
            </div>
            <div class="info-box">
                <div class="title">
                    <h4>What is BMI?</h4>
                </div>
                <p>Body Mass Index (BMI) is a simple calculation used to assess whether a person has a healthy body
                    weight for a given height. It is calculated using the formula: weight (kg) divided by height (m²).
                    BMI is widely used as a screening tool to categorize individuals into different weight categories.
                </p>
            </div>
            <div class="info-box">
                <div class="title">
                    <h4>BMI Categories</h4>
                </div>
                <div class="categories-list">
                    <p>Below 18.5 – Underweight</p>
                    <p>18.5 – 24.9 – Normal weight</p>
                    <p>25 – 29.9 – Overweight</p>
                    <p>30 and above – Obese</p>
                </div>
            </div>
            <div class="info-box">
                <div class="title">
                    <h4>Health Implications</h4>
                </div>
                <p>An unhealthy BMI may increase the risk of various health conditions such as diabetes, heart disease,
                    thyroid imbalance, and metabolic disorders. Maintaining a balanced BMI is essential for overall
                    wellness and longevity.</p>
            </div>
            <div class="info-box">
                <div class="title">
                    <h4>Fittoss Expert Recommendation</h4>
                </div>
                <p>Based on your BMI analysis, it is strongly recommended to follow a personalized nutrition and
                    lifestyle plan. Fittoss Wellness provides customized diet plans, expert guidance, and continuous
                    monitoring to help you achieve sustainable weight management.</p>
            </div>
            <div class="info-box">
                <div class="title">
                    <h4>Why choose Fittoss?</h4>
                </div>
                <div class="dietplan-benefits categories-list">
                    <p>Personalised Diet Plans</p>
                    <p>Focus on Root Cause (Hormones, Metabolism)</p>
                    <p>Sustainable Weight Loss / Gain</p>
                    <p>Expert Support & Monitoring</p>
                </div>
            </div>
            <div class="info-box">
                <div class="title">
                    <h4>Disclaimer</h4>
                </div>
                <p>This report is for informational purposes only and does not replace professional medical advice.
                    Consult a healthcare provider for medical concerns.</p>
            </div>
        </div>
    </section>
</body>
</html>
