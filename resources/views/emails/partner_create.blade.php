@include('emails.payment_email_header')

<td align="left" style="padding: 0px; margin: 0; line-height: 2rem;">
    <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0; table-layout: fixed !important; width: 100%;">
        <tbody>
            <tr>
                <td align="center" style="padding: 0; margin: 0;">
                    <table class="es-content-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0; background-color: transparent; width: 600px;">
                        <tbody>
                            <tr>
                                <td align="left" style="  margin: 0; padding-top: 10px; padding-bottom: 0px;border-radius: 15px;">
                                    <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: collapse; border-spacing: 0; float: left;">
                                        <tbody>
                                            <tr>
                                                <td class="es-m-p20b" align="left" style="padding: 0; margin: 0; width: 600px;">
                                                    <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff" style="mso-table-lspace: 0; mso-table-rspace: 0; border-collapse: separate; border-spacing: 0; background-color: #fff; border-radius: 15px;" role="presentation">
                                                        <tbody>
                                                            <tr>
                                                                <td align="left" style="padding: 20px; margin: 0; line-height: 2rem;">
                                                                    <p style="font-size:15px"><strong>Dear {{ $name }},</strong></p>
                                                                    <p style="font-size:15px">We wanted to inform you that your partner account has been successfully created.</p>
                                                                    <p style="font-size:15px">
                                                                        Here are your new login details:
                                                                    </p>
                                                                    <ul style="list-style: none;">
                                                                        <li style="font-size:15px">Company Code : <strong>{{ $company_code }}</strong></li>
                                                                        <li style="font-size:15px">Email : <strong>{{ $email }}</strong></li>
                                                                        <li style="font-size:15px">Password : <strong>{{ $password }}</strong></li>
                                                                    </ul>

                                                                    <p>Please visit Your Personalised Portal and login with your credentials:</p>
                                                                    
                                                                    <a href="{{ config('constant.PARTNER_PORTAL_URL') }}" style="display:inline-block;background:#2c2c2c;color:#fff;font-family:Ubuntu,Helvetica,Arial,sans-serif,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:17.5px;margin:0;text-decoration:none;text-transform:none;padding:9px 26px 9px 26px; margin:auto; display:block; width: fit-content; mso-padding-alt:0;border-radius:10px" target="_blank"><span><strong><span style="font-family:Poppins,sans-serif;font-size:14px">Click to Login</span></strong></span></a>
                                                                    <p style="font-size:13px">
                                                                        For security reasons, please keep this information confidential. If you did not request this password change, please contact our support team immediately.
                                                                    </p>
                                                                    <p>
                                                                        Warm regards, <br>
                                                                        <strong>Team Fittoss</strong>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    </p>
</td>

@include('emails.payment_email_footer')
