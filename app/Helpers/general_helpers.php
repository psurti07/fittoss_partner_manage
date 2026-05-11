<?php

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

if (! function_exists('get_category')) {
    function get_category()
    {
        return [
            1 => 'weight gain',
            2 => 'weight loss',
        ];
    }
}

if (! function_exists('otp_code')) {
    function otp_code($length = 6)
    {
        $chars = '0123456789';
        $code = substr(str_shuffle($chars), 0, $length);

        return $code;
    }
}

if (! function_exists('get_contNo')) {
    function get_contNo()
    {
        return "+91 97242 06519";
    }
}

if (! function_exists('get_contAddress')) {
    function get_contAddress()
    {
        return "129, Green Elina, 1st Floor, Anand Mahal Road, Adajan, Surat, Gujarat, India - 395009";
    }
}

if (!function_exists('get_email')) {
    function get_email()
    {
        return 'info@fittoss.com';
    }
}

if (!function_exists('displayDate')) {
    function displayDate($date)
    {
        if ($date == "0000-00-00") {
            $dis_date = "-";
        } else {
            $dis_date = date("d/m/Y", strtotime($date));
        }
        return $dis_date;
    }
}


if (!function_exists('DateFormatDisplay')) {
    function DateFormatDisplay($date)
    {
        if ($date == "0000-00-00" || $date == "") {
            $dis_date = "-";
        } else {
            $dis_date = date("d/m/Y H:i", strtotime($date));
        }
        return $dis_date;
    }
}


if (!function_exists('formatePriceIndia')) {
    function formatePriceIndia($num, $decimal = 1)
    {
        $explrestunits = "";
        $num = preg_replace('/,+/', '', $num);
        $words = explode(".", $num);
        $des = "00";

        if (count($words) <= 2) {
            $num = $words[0];
            if (count($words) >= 2) {
                $des = $words[1];
            }
            if (strlen($des) < 2) {
                $des = "$des";
            } else {
                $des = substr($des, 0, 2);
            }
        }
        if (strlen($num) > 3) {
            $lastthree = substr($num, strlen($num) - 3, strlen($num));
            $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
            $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for ($i = 0; $i < sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if ($i == 0) {
                    $explrestunits .= (int)$expunit[$i] . ","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i] . ",";
                }
            }
            $thecash = $explrestunits . $lastthree;
        } else {
            $thecash = $num;
        }

        if ($decimal == 0) {
            return $thecash;
        } else {
            return $thecash . "." . $des;
        }
    }
}


if (!function_exists('getStateOption')) {
    function getStateOption($selected_state = '')
    {
        $states = array(
            "Andaman and Nicobar Islands" => "Andaman and Nicobar Islands",
            "Andhra Pradesh" => "Andhra Pradesh",
            "Arunachal Pradesh" => "Arunachal Pradesh",
            "Assam" => "Assam",
            "Bihar" => "Bihar",
            "Chandigarh" => "Chandigarh",
            "Chhattisgarh" => "Chhattisgarh",
            "Dadra and Nagar Haveli" => "Dadra and Nagar Haveli",
            "Daman and Diu" => "Daman and Diu",
            "Delhi" => "Delhi",
            "Goa" => "Goa",
            "Gujarat" => "Gujarat",
            "Haryana" => "Haryana",
            "Himachal Pradesh" => "Himachal Pradesh",
            "Jammu and Kashmir" => "Jammu and Kashmir",
            "Jharkhand" => "Jharkhand",
            "Karnataka" => "Karnataka",
            "Kerala" => "Kerala",
            "Ladakh" => "Ladakh",
            "Lakshadweep" => "Lakshadweep",
            "Madhya Pradesh" => "Madhya Pradesh",
            "Maharashtra" => "Maharashtra",
            "Manipur" => "Manipur",
            "Meghalaya" => "Meghalaya",
            "Mizoram" => "Mizoram",
            "Nagaland" => "Nagaland",
            "Odisha" => "Odisha",
            "Puducherry" => "Puducherry",
            "Punjab" => "Punjab",
            "Rajasthan" => "Rajasthan",
            "Sikkim" => "Sikkim",
            "Tamil Nadu" => "Tamil Nadu",
            "Telangana" => "Telangana",
            "Tripura" => "Tripura",
            "Uttar Pradesh" => "Uttar Pradesh",
            "Uttarakhand" => "Uttarakhand",
            "West Bengal" => "West Bengal"
        );
        $option = '';
        foreach ($states as $key => $value) {
            $option .= "<option ";
            $option .= " value=\"" . $value . "\"";
            if ($selected_state == $value) {
                $option .= " selected";
            }
            $option .= " >";
            $option .= $key;
            $option .= "</option>";
        }
        return $option;
    }
}


if (!function_exists('random_code_num')) {
    function random_code_num($length = 6)
    {
        $chars = "01234567890123456789";
        $code = substr(str_shuffle($chars), 0, $length);
        return $code;
    }
}

if (!function_exists('random_code')) {
    function random_code($length = 6)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890123456789abcdefghijklmnopqrstuvwxyz";
        $code = substr(str_shuffle($chars), 0, $length);
        return $code;
    }
}

if (!function_exists('getMessageWhatsappSettings')) {
    function getMessageWhatsappSettings($name)
    {
        switch ($name) {
            case 'sa-wp-remarketing':
                $message = 'Whatsapp Remarketing field updated successfully!';
                break;
            case 'sa-wp-getoffer':
                $message = 'Whatsapp Get Offer field updated successfully!';
                break;
            case 'sa-wp-payment-success':
                $message = 'Whatsapp Payment Success field updated successfully!';
                break;
            case 'sa-wp-username-password':
                $message = 'Whatsapp Username Password field updated successfully!';
                break;
            default:
                $message = 'Something went wrong';
                break;
        }
        return $message;
    }
}

function getPostalDetailsByPincode($pincode)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://geoloc.in/api/pincode',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "pincode": "' . $pincode . '"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . env('GEOLOCATION_API_KEY')
        ),
    ));

    $response = curl_exec($curl);
    $error    = curl_error($curl);
    curl_close($curl);
    if ($error) {
        Log::error('Postal Details CURL Error', ['error' => $error]);
    }
    $result = json_decode($response, true);
    if (isset($result['error'])) {
        return ['error' => $result['error']['message']];
    }
    return $result['data'][0] ?? [];
}

if (!function_exists('sendSingleSMS')) {
    function sendSingleSMS($mobile, $message, $sender_id = NULL)
    {
        try {
            $sms_text = urlencode($message);
            $username = config('services.sms.obb.username');
            $password = config('services.sms.obb.password');
            if (!$sender_id) {
                $sender_id = config('services.sms.obb.sender_id');
            }

            $api_url = "http://m.onlinebusinessbazaar.in/sendsms.jsp?user={$username}&password={$password}&senderid={$sender_id}&mobiles={$mobile}&sms={$sms_text}";
            $response = Http::get($api_url);
            if ($response->failed()) {
                Log::warning('SMS sending failed', [
                    'mobile' => $mobile,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
            return [
                'status_code' => $response->status(),
                'body' => $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error('SMS Exception', [
                'mobile' => $mobile,
                'error'  => $e->getMessage(),
            ]);

            return [
                'status_code' => 500,
                'body'        => 'SMS sending failed',
            ];
        }
    }
}

if (!function_exists('sendBrevoHtmlMail')) {
    function sendBrevoHtmlMail($maildata, $subject = '', $message = '', $sendmail = '', $attachmentPath = '')
    {
        $data['sender']['name'] = env('APP_NAME');
        $data["sender"]["email"] = 'info@fittoss.com';

        $user_res["name"] = $maildata["fullname"];
        $user_res["email"] = $maildata["email"];
        $userdata[] = $user_res;
        $data["to"] = $userdata;

        $data["subject"] = $subject;
        $data["htmlContent"] = $message;
        if ($attachmentPath && file_exists($attachmentPath)) {
            $fileData = file_get_contents($attachmentPath);
            $fileName = basename($attachmentPath);
            $base64File = base64_encode($fileData);

            $data["attachment"] = [
                [
                    "content" => $base64File,
                    "name" => $fileName
                ]
            ];
        }

        // Turn Data to JSON
        $data_json = json_encode($data);

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => "https://api.brevo.com/v3/smtp/email",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data_json,
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    "Content-Type: application/json",
                    "api-key: " . env('BREVO_API_KEY')
                ],
            )
        );
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        Log::info($response);
        return true;
    }
}

function sendBrevoHtmlMail2(array $maildata, string $subject = '', string $htmlContent = '', array $attachments = [])
{
    try {
        $payload = [
            "sender" => [
                "name"  => env('APP_NAME'),
                "email" => 'info@fittoss.com'
            ],
            "to" => [[
                "name"  => $maildata['fullname'] ?? '',
                "email" => $maildata['email'] ?? ''
            ]],
            "subject"     => $subject,
            "htmlContent" => $htmlContent
        ];

        // Attachment handling (correct base64 encoding)
        if (!empty($attachments)) {
            // $payload["attachment"] = [[
            //     "content" => base64_encode(file_get_contents($attachmentPath)),
            //     "name"    => basename($attachmentPath)
            // ]];
            $payload['attachment'] = $attachments;
        }

        $ch = curl_init(config('services.brevo.endpoint'));

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json',
                'Content-Type: application/json',
                'api-key: ' . config('services.brevo.api_key')
            ],
            CURLOPT_TIMEOUT => 20,
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error('Brevo Mail CURL Error', ['error' => $error]);
            return false;
        }
        return true;
    } catch (\Throwable $e) {
        Log::error('Brevo Mail Exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return false;
    }
}

if (!function_exists('getMessageSmsSettings')) {
    function getMessageSmsSettings($name)
    {
        switch ($name) {
            case 'common-sender-id':
                $message = 'Common Sender ID field updated successfully!';
                break;
            case 'remarketing-sender-id':
                $message = 'Remarketing Sender ID field updated successfully!';
                break;
            default:
                $message = 'Something went wrong';
                break;
        }
        return $message;
    }
}

/* get user data */
if (!function_exists('getUserData')) {
    function getUserData($userId, $table = 'customers')
    {
        return DB::table($table)->where('id', $userId)->first();
    }
}

function sendChangePasswordEmail($fullname, $email, $mobile, $password)
{
    if ($email != '') {
        $subject = "Your Password Has Been Changed Successfully";
        $emailContent = view('mail.changePassword', compact('fullname', 'mobile', 'password'))->render();
        if ($emailContent != '') {
            $maildata = array(
                'fullname' => $fullname,
                'email' => $email,
                'mobile' => $mobile
            );
            sendBrevoHtmlMail2($maildata, $subject, $emailContent);
        }
    }
    return true;
}

function generateOrderId($slug)
{
    // Remove '-program' from end
    $prefix = preg_replace('/-program$/', '', $slug);
    // Remove hyphens/spaces
    $prefix = str_replace(['-', ' '], '', $prefix);
    // Uppercase
    $prefix = substr(strtoupper($prefix), 0, 4);
    return $prefix . time() . rand(100, 999);
}

function generateRefCode($first_name)
{
    return strtoupper(substr($first_name, 0, 3)) . now()->format('His') . rand(10, 99);
}

function generateCompanyCode($name)
{
    return strtoupper(substr($name, 0, 3)) . now()->format('His') . rand(10, 99);
}

function interakt_message(array $postData)
{
    try {
        $url = config('services.interakt.endpoint');
        $api_key = config('services.interakt.api_key');

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($postData),
            CURLOPT_HTTPHEADER     => [
                "Authorization: Basic {$api_key}",
                "Content-Type: application/json"
            ],
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_MAXREDIRS      => 5,
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        Log::info('Interakt API Response', [$response]);
        if ($error) {
            Log::error('Interakt CURL Error', ['error' => $error]);
            return false;
        }

        if ($status >= 400) {
            Log::warning('Interakt API HTTP Error', ['status'   => $status, 'response' => $response]);
        }

        return json_decode($response, true);
    } catch (\Throwable $e) {
        Log::error('Interakt Message Exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

        return false;
    }
}

function encryptData($data)
{
    $key = "jvJ7RGlyfjm0jwaa";
    $iv = "@@@@&&&&####$$$$";

    $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptData($data)
{
    $key = "jvJ7RGlyfjm0jwaa";
    $data = base64_decode($data);

    $iv = substr($data, 0, 16);
    $encrypted = substr($data, 16);

    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
}
