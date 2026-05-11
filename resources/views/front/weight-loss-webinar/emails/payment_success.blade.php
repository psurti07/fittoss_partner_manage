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
                                                                    <p>Hi <strong>{{ $name }}</strong>,</p>
                                                                    <h3 style="margin-top:10px;margin-bottom:15px;color:#222;">
                                                                        Welcome to Fittoss — Your Seat is Booked!
                                                                    </h3>
                                                                    <p>
                                                                        Congratulations and great choice! 😊 Your slot for the Fittoss Weight Loss Webinar has been officially confirmed.
                                                                    </p>
                                                                    <p>
                                                                        What happens next?
                                                                    </p>
                                                                    <p>Join the Fittoss WhatsApp Community 👉 https://kbzp.in/FITOSS/fvboj</p>
                                                                    <p>Get exclusive updates, webinar link and live session reminders — all in one place!</p>
                                                                    <p>
                                                                        Get ready to transform your life! 💪🔥
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
