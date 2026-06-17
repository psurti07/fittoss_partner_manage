<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="" />
    <title>{{ config('constant.COMPANY_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/invoice.css') }}" />
    <style></style>
</head>

<body>
    <div class="tm_container">
        <div class="tm_invoice_wrap">
            <div class="tm_invoice tm_style2 tm_type1 tm_accent_border tm_radius_0 tm_small_border" id="tm_download_section">
                <div class="tm_invoice_in">
                    <div class="tm_invoice_head tm_mb20 tm_m0_md">
                        <div class="tm_invoice_left">
                            <div class="tm_logo logo-width"><img src="data:image/png;base64,{{ base64_encode(file_get_contents("https://fittoss.com/public/storage/images/logo/fittoss-logo.png")) }}" alt="Fittoss" /></div>
                        </div>
                        <div class="tm_invoice_right" style="width:70%;margin-left:10px;">
                            <div class="tm_grid_row tm_col_12">
                                <div class="tm_f14">
                                    <b>{{ config('constant.COMPANY_NAME') }}</b><br />
                                    {!! config('constant.COMPANY_ADDRESS_INVOICE') !!}
                                </div>
                            </div>
                        </div>
                        <div class="tm_shape_bg tm_accent_bg_10 tm_border tm_accent_border_20"></div>
                    </div>
                    <div class="tm_invoice_info tm_mb30 tm_align_center">
                        <div class="tm_invoice_left" style="width:30%;">
                            <div class="tm_f14">
                                <p class="tm_mb0">
                                    <b class="tm_primary_color">Invoice No: </b>{{ $invoice->inv_prefix.$invoice->inv_number }} <br />
                                    <b class="tm_primary_color">Invoice Date: </b>{{ displayDate($invoice->inv_date) }}
                                </p>
                            </div>
                        </div>
                        <div class="tm_invoice_left" style="width:30%;">
                            <div class="tm_f14">
                                <p class="tm_mb0">
                                    <b class="tm_primary_color">Mobile: </b> {{ config('constant.COMPANY_MOBILE') }}<br />
                                    <b class="tm_primary_color">Email: </b> {{ config('constant.COMPANY_INFO_EMAIL') }}
                                </p>
                            </div>
                        </div>
                        <div class="tm_invoice_right" style="width:40%;">
                            <div class="tm_f14">
                                <p class="tm_mb0">
                                    <b class="tm_primary_color">CIN No: </b> {{ config('constant.CIN_NUMBER') }}<br />
                                    <b class="tm_primary_color">GST No: </b> {{ config('constant.GST_NUMBER') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="tm_f16 tm_section_heading tm_accent_border_20 tm_mb0">
                    <span class="tm_accent_bg_10 tm_radius_0 tm_curve_35 tm_border tm_accent_border_20 tm_border_bottom_0 tm_accent_color tm_f14 tm_semi_bold"><span>Invoice To</span></span>
                </h2>
                <div class="tm_table tm_style1 tm_mb30">
                    <div class="tm_border tm_accent_border_20 tm_border_top_0">
                        <div class="tm_table_responsive">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="tm_width_6 tm_border_top_0 tm_f14"><b class="tm_primary_color tm_medium">Name: </b>{{ $user->first_name .' '.$user->last_name }}</td>
                                        <td class="tm_width_6 tm_border_top_0 tm_border_left tm_accent_border_20 tm_f14"><b class="tm_primary_color tm_medium">Phone: </b> {{ $user->mobile_no }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tm_width_6 tm_accent_border_20 tm_f14"><b class="tm_primary_color tm_medium">Email: </b>{{ $user->email }}</td>
                                        <td class="tm_width_6 tm_border_left tm_accent_border_20 tm_f14"><b class="tm_primary_color tm_medium">Address: </b>{{ $user->city != '' || $user->city != null ? $user->city : 'N/A' }},{{ $user->state != '' || $user->state != null ? $user->state : 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tm_table tm_style1">
                    <div class="tm_border tm_accent_border_20">
                        <div class="tm_table_responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="tm_width_3 tm_semi_bold tm_accent_color tm_accent_bg_10 tm_f14">Event</th>
                                        <th class="tm_width_2 tm_semi_bold tm_accent_color tm_accent_bg_10 tm_text_right tm_f14">Amount(&#8377;)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="tm_width_2 tm_accent_border_20 tm_f14">{{ $event_title }}</td>
                                        <td class="tm_width_2 tm_accent_border_20 tm_text_right tm_f14">{{ formatePriceIndia($invoice->inv_price) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tm_invoice_footer tm_mb15 tm_m0_md">
                        <div class="tm_right_footer" style="width: 100%;">
                            <table class="tm_mb15 tm_m0_md">
                                <tbody>
                                    <tr>
                                        <td class="tm_width_3 tm_primary_color tm_border_none tm_medium tm_f14">Subtotal</td>
                                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_medium tm_f14">&#8377;{{ formatePriceIndia($invoice->inv_price) }}</td>
                                    </tr>
                                    @if($invoice->inv_cgst > 0)
                                    <tr>
                                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0 tm_f14">+ 9% CGST</td>
                                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_f14 tm_pt0">&#8377;{{ formatePriceIndia($invoice->inv_cgst) }}</td>
                                    </tr>
                                    @endif
                                    @if($invoice->inv_sgst > 0)
                                    <tr>
                                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0 tm_f14">+ 9% SGST</td>
                                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_f14 tm_pt0">&#8377;{{ formatePriceIndia($invoice->inv_sgst) }}</td>
                                    </tr>
                                    @endif
                                    @if($invoice->inv_igst > 0)
                                    <tr>
                                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0 tm_f14">+ 18% IGST</td>
                                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_f14 tm_pt0">&#8377;{{ formatePriceIndia($invoice->inv_igst) }}</td>
                                    </tr>
                                    @endif
                                    <tr class="tm_accent_border_20 tm_border">
                                        <td class="tm_width_3 tm_bold tm_f16 tm_border_top_0 tm_accent_color tm_accent_bg_10">Grand Total</td>
                                        <td class="tm_width_3 tm_bold tm_f16 tm_border_top_0 tm_accent_color tm_text_right tm_accent_bg_10">&#8377;{{ formatePriceIndia($invoice->inv_grandtotal) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="tm_left_footer tm_note">
                                            <p class="tm_mb2"><b class="tm_primary_color">Payment Details</b></p>
                                            <p class="tm_m0 tm_f12">
                                                Payment Method: Online Payment <br />
                                                {{-- Payment Id: --}}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;">
                                        <div class="tm_left_footer">
                                            <p class="tm_mb2"><b class="tm_primary_color">Note</b></p>
                                            <p class="tm_m0 tm_f12">
                                                Payment is refundable only in accordance with the company's <br />
                                                Cancellation & Refund Policy.
                                            </p>
                                        </div>
                                    </td>
                                    <td style="width: 50%;">
                                        <div class="tm_right_footer cust_authorized">
                                            <div class="tm_sign tm_text_center">
                                                <br />
                                                <br />
                                                <p class="tm_m0 tm_12 tm_primary_color">{{ config('constant.COMPANY_NAME') }}</p>
                                                <p class="tm_m0 tm_ternary_color">Authorized Person</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tm_bottom_invoice tm_accent_border_20">
                        <div class="tm_bottom_invoice_center">
                            <p class="tm_m0 tm_f12">This is Computer generated Invoice. Does not require any signature.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tm_invoice_btns tm_hide_print">
                <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path>
                            <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></rect>
                            <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path>
                            <circle cx="392" cy="184" r="24" fill="currentColor"></circle>
                        </svg>
                    </span>
                    <span class="tm_btn_text">Print</span>
                </a>
                {{--<button id="tm_download_btn" class="tm_invoice_btn tm_color2">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path
                                d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03"
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="32"
                            ></path>
                        </svg>
                    </span>
                <span class="tm_btn_text">Download</span>
            </button>--}}
            </div>
        </div>
</body>
</html>
