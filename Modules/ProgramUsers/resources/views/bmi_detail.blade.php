<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Fittoss BMI Report - {{ $userData->first_name }} {{ $userData->last_name }}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #f3f4f6;
            padding: 20px;
        }


        .report {

            background: #fff;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
        }


        .report .title {
            text-align: start;
            border-bottom: 2px solid #144835;
            padding-bottom: 15px;
        }

        .report .title h1 {
            color: #144835;
            letter-spacing: 2px;
            font-size: 24px;
            text-align: center;
            margin-bottom: 10px;
        }

        .report .title h2 {
            color: #FEAE00;
            font-size: 24px;
            text-align: center;
            margin-top: 0;
        }



        .report .section-title {
            color: #144835;
            font-size: 13px;
            margin-bottom: 15px;
            letter-spacing: 1px;
            margin-top: 30px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .report .section-title-01 {
            color: #ffb300;
            font-size: 13px;
            margin-bottom: 15px;
            letter-spacing: 1px;
            margin-top: 30px;
            margin-bottom: 15px;
            font-weight: bold;

        }

        .report .card {
            background: #f9fafb;
            padding: 15px;
            margin: 1%;
            border-radius: 12px;
            vertical-align: top;
        }

        .report .card p {
            margin: 0;
        }

        .report .label {
            font-size: 12px;
            color: #9ca3af;
            font-weight: 900;
        }

        .report .value {
            font-size: 18px;
            font-weight: bold;
            color: #144835;
            margin-top: 5px !important;
        }

        .report .value-label {
            color: #FEAE00;
            font-size: 18px;
            font-weight: bold;
        }

        .report .value-number {
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            margin-top: 5px !important;
        }


        .report .bmi-card {
            background: #144835;
            color: #fff;
        }


        .report .result {
            background: #111827;
            color: #fff;
            padding: 20px;
            border-radius: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
            height: 60px;
        }

        .report .result h3 {
            margin-bottom: 5px;
            color: #FEAE00;
            margin-top: 0;
            text-transform: uppercase;
        }

        .report .result h2 {
            margin-top: 5px;
        }

        .report .result span {
            color: #FEAE00;
        }


        .report .btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background: #144835;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .report {
            width: 850px;
            margin: auto;
        }


        .report .row {
            position: relative;
            margin-bottom: 30px;
        }

        .report .title {
            font-size: 14px;
            font-weight: bold;
            color: #144835;
            letter-spacing: 2px;
        }

        .report .range {
            vertical-align: top;
            float: right;
            color: #9ca3af;
            font-weight: 600;
        }


        .report .scale-wrapper {
            position: relative;
            margin-top: 30px;
        }


        .report .scale {
            height: 22px;
            border-radius: 30px;
            overflow: hidden;
            background: linear-gradient(to right,
                    #3b82f6 0% 16.66%,
                    #144835 16.66% 33.32%,
                    #facc15 33.32% 49.98%,
                    #f97316 49.98% 66.64%,
                    #ef4444 66.64% 83.3%,
                    #b91c1c 83.3% 100%);
        }



        .report .seg {
            display: inline-block;
            height: 100%;
        }

        .report .seg1 {
            width: 14.28%;
            background: #3b82f6;
        }
        .report .seg2 {
            width: 14.28%;
            background: #2b6cff;
        }

        .report .seg3 {
            width: 14.28%;
            background: #144835;
        }

        .report .seg4 {
            width: 14.28%;
            background: #facc15;
        }

        .report .seg5 {
            width: 14.28%;
            background: #f97316;
        }

        .report .seg6 {
            width: 14.28%;
            background: #ef4444;
        }

        .report .seg7 {
            width: 14.32%;
            background: #b91c1c;
        }


        .report .pointer {
            position: absolute;
            top: -34px;
            /* left: 51%; */
            /* transform: translateX(-50%); */
            text-align: center;

        }

        .report .pointer-line {
            width: 4px;
            height: 55px;
            background: #144835;
            margin: auto;
            border-radius: 2px;
        }

        .report .you {
            display: inline-block;
            margin-top: 8px;
            background: #144835;
            color: #facc15;
            padding: 6px 14px;
            font-size: 12px;
            border-radius: 20px;
            font-weight: bold;
        }


        .report .btn {
            display: block;
            margin: 20px auto;
            padding: 10px 25px;
            background: #144835;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .report .wrapper-top {
            margin-top: 40px;
            border-radius: 6px;
        }


        .report .box {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }

        .report .box:first-child {
            margin-right: 3%;
        }


        .report .title-wrapper {
            font-weight: bold;
            color: #0b5c52;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .report .icon {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: inline-block;
            text-align: center;
            line-height: 22px;
            margin-right: 8px;
            font-size: 13px;
            font-weight: bold;
        }


        .report .yellow {
            background: #fff3cd;
            color: #f4a100;
        }



        .report .wrapper .box p {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.7;
            font-weight: 600;
        }




        .report .table-box {
            background: #fff;
            border-radius: 10px;
            overflow-x: auto;
        }


        .report table {
            width: 100%;
            border-collapse: collapse;
        }


        .report thead {
            background: #144835;
            color: #fff;
        }

        .report thead th {
            padding: 14px;
            text-align: left;
            font-size: 13px;
        }


        .report tbody td {
            padding: 12px;
            font-size: 13px;
            color: #000;
            border-bottom: 1px solid #eee;
        }


        .report tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .report .blue {
            color: #2b6cff;
            font-weight: bold;
        }

        .report .green {
            color: #28a745;
            font-weight: bold;
        }

        .report .orange {
            color: #ff9800;
            font-weight: bold;
        }

        .report .red {
            color: #e53935;
            font-weight: bold;
        }


        .report .wrapper {
            width: 100%;
        }


        .report .left-box {
            width: 48%;
            display: inline-block;
            background: #e9efee;
            border-radius: 15px;
            padding: 25px;
            box-sizing: border-box;
        }


        .report .right-box {
            width: 48%;
            float: right;
            padding: 10px;
            box-sizing: border-box;
        }


        .report .title {
            font-weight: bold;
            color: #1c3b2f;
            font-size: 18px;
            margin-bottom: 10px;
        }


        .report .text {
            color: #2e4d3c;
            line-height: 1.6;
        }

        .report .right-title {
            font-weight: bold;
            font-size: 20px;
            color: #1c3b2f;
            margin-bottom: 20px;
        }


        .report .list-item {
            margin-bottom: 12px;
            color: #1c3b2f;
            font-weight: 600;
        }


        .report .icon {
            display: inline-block;
            width: 18px;
            height: 18px;
            background: #1c3b2f;
            color: white;
            text-align: center;
            line-height: 18px;
            border-radius: 50%;
            font-size: 12px;
            margin-right: 8px;
        }


        .report .card-wrapper {
            width: 100%;
            margin: auto;
            background: linear-gradient(135deg, #0b3b2e, #0f5132);
            border-radius: 40px;
            padding: 40px;
            color: #fff;
            box-sizing: border-box;
        }


        .report .left {
            width: 55%;
            float: left;
        }

        .report .right {
            width: 40%;
            float: right;
            text-align: right;
        }


        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .report .badge {
            display: inline-block;
            background: #e53935;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }


        .report .title {
            font-size: 24px;
            font-weight: bold;
            margin: 15px 0 10px;
            color: #fff;
            text-align: start;
        }

        .report .subtitle {
            color: #cde3d9;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .report .section {
            margin-top: 10px;
        }


        .report .item {
            margin: 10px 0;
            font-size: 14px;
        }


        .report .icon {
            display: inline-block;
            width: 18px;
            height: 18px;
            background: #ffb300;
            color: #000;
            border-radius: 50%;
            text-align: center;
            line-height: 18px;
            margin-right: 8px;
            font-size: 12px;
        }


        .report .old-price {
            text-decoration: line-through;
            color: #bdbdbd;
            font-size: 14px;
        }

        .report .new-price {
            font-size: 36px;
            color: #ffb300;
            font-weight: bold;
        }


        .report .box-wrap-01 {
            width: 47%;
            display: inline-block;
            vertical-align: top;
            padding: 40px 0 0 0;
            margin: 0 20px 0 0;
        }

        .report .price-box {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 20px;
            margin-top: 50px;
            text-align: left;

        }


        .report .row {
            margin: 10px 0;
            font-size: 14px;
        }

        .report .row span {
            float: right;
        }


        .report .btn {
            background: #ffb300;
            color: #000;
            padding: 18px;
            border-radius: 30px;
            text-align: center;
            margin-top: 25px;
            font-weight: bold;
            cursor: pointer;
        }

        .report .footer {
            text-align: center;
            margin-top: 15px;
            color: #cde3d9;
            font-size: 12px;
        }

        .report .footer-bottom {
            text-align: center;
            margin-top: 15px;
            color: #000;
            font-size: 12px;
            margin-top: 40px;
        }

        .report .result-01 {
            float: left;
            margin-right: 20px;
            display: inline-block;
            width: 38%;
        }

        .report .result-02 {

            width: 59%;
            display: inline-block;
        }

        @media (max-width:991px) {
            .report .box-wrap-01 {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .report .pointer {
                transform: none !important;
            }

            .table-box table tr td {
                display: table-cell;
            }

            .report tbody td {
                width: auto;
                display: block;
            }

            .report .result-01 {
                width: 100%;
            }

            .report .result-02 {
                width: 100%;
            }

            .report {
                width: auto;
                padding: 15px;
            }

            .report .card-wrapper {
                padding: 20px;
            }


            .report .card {
                width: auto;
                margin: 10px 0;
                display: block;
            }


            .report .box-wrap-01 {
                width: 100%;
                display: block;
                margin: 0 0 20px 0;
            }


            .report .left-box,
            .report .right-box {
                width: 100%;
                display: block;
                float: none;
                margin-bottom: 20px;
            }

            .report .left,
            .report .right {
                width: 100%;
                float: none;
                text-align: left;
            }


            .report .right {
                margin-top: 20px;
            }


            .table-box {
                overflow-x: scroll;
            }

            .report .title h1,
            .report .title h2 {
                font-size: 18px;
                text-align: center;
            }


            .report .scale {
                height: 18px;
            }

            .report .pointer-line {
                height: 40px;
            }

            .report .you {
                font-size: 10px;
                padding: 5px 10px;
            }


            .report .btn {
                width: auto;
            }
        }



        @media (max-width: 480px) {

            .report .title h1 {
                font-size: 16px;
            }

            .report .title h2 {
                font-size: 16px;
            }

            .report .value {
                font-size: 16px;
            }

            .report .new-price {
                font-size: 28px;
            }

            .report .row {
                font-size: 12px;
            }

        }
    </style>
</head>

<body>
@php
    $bmi = $personalDetails->bmi;
    if($bmi > 0 && $bmi < 18){
        $degree_p = "-720";
        $left_p = "5";
        $bmiCategory ="Malnutrition 2";
        $bmiCategoryColor ="#7CFC00";
        $healthRisks = "Anorexia, Bulimua, Low Blood Pressure, Osteoporosis and Break dow of muscle mass etc.";
    }elseif($bmi >= 18 && $bmi <= 20){
        $degree_p = "-515";
        $left_p = "19";
        $bmiCategory ="Malnutrition 1";
        $bmiCategoryColor ="#7CFC00";
        $healthRisks = "Digestive problems, Weakness, Chronic Fatigue, Stress, Anxiety, Reproductive/ Hormonal Dysfunction.";
    }elseif ($bmi >= 20.1 && $bmi <= 23) {
        $degree_p = "-285";
        $left_p = "33";
        $bmiCategory ="Normal";
        $bmiCategoryColor ="#32CD32";
        $healthRisks = "Normal Menstruation Can handle Stress Good Energy Levels, Vitality, Resistance to illness, Good Physical Condition etc.";
    }elseif ($bmi >= 23.1 && $bmi <= 25) {
        $degree_p = "-60";
        $left_p = "48";
        $bmiCategory ="Overweight";
        $bmiCategoryColor ="#FFD700";
        $healthRisks = "Fatigue, Digestive Problems, Circulation Problems, Varicose Veins, etc.";
    }elseif ($bmi >= 25.1 && $bmi <= 28 ) {
        $degree_p = "185";
        $left_p = "63";
        $bmiCategory ="Obesity Grade 1";
        $bmiCategoryColor ="#FFA500";
        $healthRisks = "Diabetes, High Blood Pressure, Cardiovascular Diseases, Blood Clots, Stroke, Join Problems arthritis, Spine etc.";
    }elseif ($bmi >= 28.1 && $bmi <= 30 ) {
        $degree_p = "415";
        $left_p = "77";
        $bmiCategory ="Obesity Grade 2";
        $bmiCategoryColor ="#FF4500";
        $healthRisks = "Diabetes, Cancer, Angina, Heart Attacks, Phlebitis, Arterial Sclerosis & Stroke etc.";
    }else{
        $degree_p = "620";
        $left_p = "91";
        $bmiCategory ="Obesity Grade 3";
        $bmiCategoryColor ="#fF0000";
        $healthRisks = "Maximum Risk of Diabetes, Cancer, Hear Disease, Premature Deth.";
    }
@endphp
    <div style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <button onclick="downloadPDF()" style="padding:10px 15px; margin-right:10px; background:#144835; color:#fff; border:none; border-radius:6px; cursor:pointer;">
            Download PDF
        </button>
    {{-- <button onclick="printReport()" style="padding:10px 15px; background:#ffb300; color:#000; border:none; border-radius:6px; cursor:pointer;">
            Print
        </button> --}}
    </div>
    <div class="report" id="report">
        <div class="title">
            <h1 style="text-transform: uppercase;">{{config('constant.COMPANY_NAME')}}</h1>
            <h2>COMPREHENSIVE BMI REPORT</h2>
        </div>

        <div class="section-title">YOUR DETAILS</div>

        <table width="100%">
            <tr>
                <td width="33%">
                    <div class="card">
                        <p class="label">Name</p>
                        <p class="value">{{ $userData->first_name }} {{ $userData->last_name }}</p>
                    </div>
                </td>
                <td width="33%">
                    <div class="card">
                        <p class="label">Age</p>
                        <p class="value">{{ $personalDetails->age ?? 'N/A' }}</p>
                    </div>
                </td>
                <td width="33%">
                     <div class="card">
                        <p class="label">Gender</p>
                        <p class="value">
                             {{
                            match($personalDetails->gender) {
                                1 => 'Male',
                                2 => 'Female',
                                3 => 'Other',
                                default => 'N/A'
                            }
                        }}
                        </p>
                    </div>
                </td>
            </tr>
        </table>
         <table width="100%">
            <tr>
                <td width="33%">
                    <div class="card">
                        <p class="label">Height</p>
                        <p class="value">{{ $personalDetails->height ?? 'N/A' }}</p>
                    </div>
                </td>
                <td width="33%">
                    <div class="card">
                        <p class="label">Weight</p>
                        <p class="value">{{ $personalDetails->weight ?? 'N/A' }}</p>
                     </div>  
                </td>
                <td width="33%">
                     <div class="card bmi-card">
                        <p class="value-label">BMI Value</p>
                        <p class="value-number">{{ $personalDetails->bmi ?? 'N/A' }}</p>
                    </div>
                </td>
            </tr>
        </table>
     
        <div class="result">
            <div class="result-01">
                <h3>BMI RESULT</h3>
                <h2>Category: <span>{{ $bmiCategory }}</span></h2>
            </div>
            {{-- <div class="result-02">
                <h3>Health Implications / Risks</h3>
                <span style="margin-top: 5px;font-size: 13px;color: #fff;">{{ $healthRisks }}</span>
            </div> --}}
        </div>
        <div>
            <span class="section-title">BMI SCALE</span>
            <span class="range">Range: 0 — 45+</span>
        </div>
        <div class="scale-wrapper">
            <div class="pointer" style="left: {{ $left_p }}%;">
                <div class="pointer-line"></div>
                <div class="you">YOU</div>
            </div>
            <div class="scale">
                <div class="seg seg1"></div>
                <div class="seg seg2"></div>
                <div class="seg seg3"></div>
                <div class="seg seg4"></div>
                <div class="seg seg5"></div>
                <div class="seg seg6"></div>
                <div class="seg seg7"></div>
            </div>
        </div>

        <div class="wrapper-top">
            <div class="title-wrapper">⚡ DETAILED BMI CLASSIFICATION & HEALTH RISKS</div>

            <div class="table-box">
                <table>
                    <thead>
                        <tr>
                            <th>BMI Range</th>
                            <th>Category</th>
                            <th>Health Implications / Risks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="{{ ($bmi > 0 && $bmi < 18) ? 'background-color: #16503b;' : '' }}">
                            <td>Below 18</td>
                            <td class="blue">Malnutrition 2</td>
                            <td>Anorexia, Bulimua, Low Blood Pressure, Osteoporosis and Break dow of muscle mass etc.</td>
                        </tr>
                        <tr style="{{ ($bmi >= 18 && $bmi <= 20) ? 'background-color: #16503b;' : '' }}">
                            <td>18 - 20</td>
                            <td class="blue">Malnutrition 1</td>
                            <td>Digestive problems, Weakness, Chronic Fatigue, Stress, Anxiety, Reproductive/ Hormonal Dysfunction.</td>
                        </tr>
                        <tr style="{{ ($bmi > 20.1 && $bmi <= 23) ? 'background-color: #16503b;' : '' }}">
                            <td>20.1 – 23.0</td>
                            <td class="green">Normal</td>
                            <td>Normal Menstruation Can handle Stress Good Energy Levels, Vitality, Resistance to illness, Good Physical Condition etc.</td>
                        </tr>
                        <tr style="{{ ($bmi > 23.1 && $bmi <= 25) ? 'background-color: #16503b;' : '' }}">
                            <td>23.1 – 25.0</td>
                            <td class="orange">Overweight</td>
                            <td>Fatigue, Digestive Problems, Circulation Problems, Varicose Veins, etc.</td>
                        </tr>
                        <tr style="{{ ($bmi > 25.1 && $bmi <= 28) ? 'background-color: #16503b;' : '' }}">
                            <td>25.1 – 28.0</td>
                            <td class="orange">Obesity Grade 1</td>
                            <td>Diabetes, High Blood Pressure, Cardiovascular Diseases, Blood Clots, Stroke, Join Problems arthritis, Spine etc.</td>
                        </tr>
                        <tr style="{{ ($bmi > 28.1 && $bmi <= 30) ? 'background-color: #16503b;' : '' }}">
                            <td>28.1 – 30.0</td>
                            <td class="red">Obesity Grade 2</td>
                            <td>Diabetes, Cancer, Angina, Heart Attacks, Phlebitis, Arterial Sclerosis & Stroke etc.</td>
                        </tr>
                        <tr style="{{ ($bmi > 30) ? 'background-color: #16503b;' : '' }}">
                            <td>Over 30.0</td>
                            <td class="red">Obesity Grade 3</td>
                            <td>Maximum Risk of Diabetes, Cancer, Hear Disease, Premature Deth.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="wrapper-top">

            <div class="box-wrap-01">
                <div class="title-wrapper">
                    <span class="icon yellow">i</span>
                    WHAT IS BMI?
                </div>
                <p>
                    Body Mass Index (BMI) is a widely used health indicator that helps evaluate whether a person’s body
                    weight is appropriate for their height. It provides a quick way to classify individuals into
                    categories such as underweight, normal weight, overweight, or obese, and is often used by health
                    professionals to assess potential health risks related to weight.
                </p>
            </div>

            <div class="box-wrap-01">
                <div class="title-wrapper">
                    <span class="icon green">✔</span>
                    HEALTH IMPLICATIONS
                </div>
                <p>
                    An unhealthy BMI may increase the risk of various health conditions such as diabetes, heart disease,
                    thyroid imbalance, and metabolic disorders. Maintaining a balanced BMI is essential for overall
                    wellness and longevity.
                </p>
            </div>

        </div>        

        <div class="wrapper-top">
            <div class="left-box">
                <div class="title-wrapper">✨ EXPERT RECOMMENDATION</div>
                <div class="text">
                    <strong>Based on your BMI analysis, it is strongly recommended to follow a personalized nutrition and
                        lifestyle
                        plan.
                        Fittoss Wellness provides customized diet plans, expert guidance, and continuous monitoring to help you
                        achieve sustainable weight management.</strong>
                </div>
            </div>


            <div class="right-box">
                <div class="right-title">WHY CHOOSE FITTOSS?</div>
                <div class="list-item">
                    <span class="icon">✓</span>
                    Personalized Diet Plans
                </div>
                <div class="list-item">
                    <span class="icon">✓</span>
                    Focus on Root Cause (Hormones, Metabolism)
                </div>

                <div class="list-item">
                    <span class="icon">✓</span>
                    Sustainable Weight Loss / Gain
                </div>

                <div class="list-item">
                    <span class="icon">✓</span>
                    Expert Support & Monitoring
                </div>
            </div>

        </div>
        <div class="wrapper-top">
            <div id="pdfContent" class="card-wrapper clearfix">
                <div class="left">
                    <div class="badge">HURRY, OFFER ENDS SOON</div>
                    <div class="title">{{ $product->productname ?? 'Weight Loss Program' }}</div>
                    <div class="subtitle">
                        We're all set to start your weight loss and body transformation!
                    </div>

                    <div class="section">
                        <div class="section-title-01">PROGRAM BENEFITS</div>
                        <div class="item"><span class="icon">✓</span>Fat-loss Plan by Expert</div>
                        <div class="item"><span class="icon">✓</span>Personalized diet plan</div>
                        <div class="item"><span class="icon">✓</span>Dedicated health coach</div>
                        <div class="item"><span class="icon">✓</span>Weight tracking & monitoring</div>
                        <div class="item"><span class="icon">✓</span>Nutrition & detox guidance</div>
                        <div class="item"><span class="icon">✓</span>Afresh Detox Drink</div>
                        <div class="item"><span class="icon">✓</span>Habit correction for best results</div>
                        <div class="item"><span class="icon">✓</span>Access to Health Talk session</div>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="right">
                    <div class="old-price">₹{{ number_format($product->amount, 2) }}</div>
                    <div class="new-price">₹{{ number_format($product->offeramount, 2) }}</div>
                    <div class="label">OFFER AMOUNT</div>
                    <div class="price-box clearfix">
                        <div class="row">Program Amount <span>₹{{ number_format($product->amount, 2) }}</span></div>
                        <div class="row">Discount <span style="color:red;">-₹{{ number_format(($product->amount - $product->offeramount), 2) }}</span></div>
                        <div class="row">GST <span>+₹{{ number_format(($product->offeramount) * 0.18, 2) }}</span></div>
                        <hr>
                        <div class="row"><b>Total (Inc. GST)</b> <span><b>₹{{ number_format(($product->offeramount) * 1.18, 2) }}</b></span></div>
                    </div>
                    <a style="text-decoration: none;" target="_blank" href="{{ $url }}">
                        <div class="btn">PURCHASE NOW →</div>
                    </a>
                    <div class="footer">30-Day Money-back Guarantee</div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <strong>Disclaimer:</strong> This report is for informational purposes only and does not replace professional
            medical advice. Consult a healthcare provider for medical concerns.
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    // function printReport() {
    //     window.print();
    // }

    async function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const element = document.getElementById('report');

        const canvas = await html2canvas(element, { scale: 2 });
        const imgData = canvas.toDataURL('image/png');

        const pdf = new jsPDF('p', 'mm', 'a4');

        const imgWidth = 210;
        const pageHeight = 295;
        const imgHeight = canvas.height * imgWidth / canvas.width;

        let heightLeft = imgHeight;
        let position = 0;

        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        // Handle multi-page
        while (heightLeft > 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }
        // pdf.link(x, y, width, height)
        // x	left position
        // y	top position
        // width	clickable area width
        // height	clickable area height
        pdf.setPage(2);
        pdf.link(130, 180, 60, 18, {
            url: "{{ $url }}"
        });

        pdf.save('BMI_Report.pdf');
    }
</script>
</body>
</html>
