{{--<x-mail::message>--}}
{{-- Greeting --}}
{{--@if (! empty($greeting))--}}
{{--# {{ $greeting }}--}}
{{--@else--}}
{{--@if ($level === 'error')--}}
{{--# @lang('Whoops!')--}}
{{--@else--}}
{{--# @lang('Hello!')--}}
{{--@endif--}}
{{--@endif--}}

{{-- Intro Lines --}}
{{--@foreach ($introLines as $line)--}}
{{--{{ $line }}--}}

{{--@endforeach--}}

{{-- Action Button --}}
{{--@isset($actionText)--}}
{{--<?php--}}
{{--    $color = match ($level) {--}}
{{--        'success', 'error' => $level,--}}
{{--        default => 'primary',--}}
{{--    };--}}
{{--?>--}}
{{--<x-mail::button :url="$actionUrl" :color="$color">--}}
{{--{{ $actionText }}--}}
{{--</x-mail::button>--}}
{{--@endisset--}}

{{-- Outro Lines --}}
{{--@foreach ($outroLines as $line)--}}
{{--{{ $line }}--}}

{{--@endforeach--}}

{{-- Salutation --}}
{{--@if (! empty($salutation))--}}
{{--{{ $salutation }}--}}
{{--@else--}}
{{--@lang('Regards'),<br>--}}
{{--{{ config('app.name') }}--}}
{{--@endif--}}

{{-- Subcopy --}}
{{--@isset($actionText)--}}
{{--<x-slot:subcopy>--}}
{{--@lang(--}}
{{--    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".--}}
{{--    'into your web browser:',--}}
{{--    [--}}
{{--        'actionText' => $actionText,--}}
{{--    ]--}}
{{--) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>--}}
{{--</x-slot:subcopy>--}}
{{--@endisset--}}
{{--</x-mail::message>--}}



    <!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office" lang="ru">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />
    <title>Анистрой</title>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');

        table {
            border-spacing: 0;
            mso-cellspacing: 0;
            mso-padding-alt: 0;
        }

        td {
            padding: 0;
        }

        #outlook a {
            padding: 0;
        }

        a {
            text-decoration: none;
            font-size: 16px;
        }

        table,
        td {
            background-color: #fafdfe !important;
        }

        h1,
        h2,
        h3,
        p,
        td {
            color: #282828 !important;
        }

        span {
            display: block;
            color: #1061AB !important;
        }

        .light-logo {
            display: table-row;
        }

        .dark-logo {
            display: none;
        }

        /* Custom Dark Mode Colors */
        :root {
            color-scheme: light dark;
            supported-color-schemes: light dark;
        }

        @media (prefers-color-scheme: dark) {
            table,
            td {
                background-color: #282828 !important;
            }

            h1,
            h2,
            h3,
            p,
            td {
                color: #fafdfe !important;
            }

            span {
                display: block;
                color: #3595EC !important;
            }

            .light-logo {
                display: none;
            }

            .dark-logo {
                display: table-row;
            }
        }
    </style>

    <!--[if (gte mso 9)|(IE)]>
    <style type="text/css">
        table {border-collapse: collapse !important;}
    </style>
    <![endif]-->

    <!--[if (gte mso 9)|(IE)]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
</head>

<body style="Margin:0;padding:0;min-width:100%;background-color:#dde0e1;">

<!--[if (gte mso 9)|(IE)]>
<style type="text/css">
    body {background-color: #dde0e1!important;}
    body, table, td, p, a {font-family: sans-serif, Arial, Helvetica!important;}
</style>
<![endif]-->

<center style="width: 100%;table-layout:fixed;background-color: #dde0e1;padding-top: 40px;padding-bottom: 40px;">
    <div style="max-width: 600px;background-color: #fafdfe;box-shadow: 0 0 10px rgba(0, 0, 0, .2);">

        <!-- Preheader (remove comment) -->
        <div
            style="font-size: 0px;color: #fafdfe;line-height: 1px;mso-line-height-rule:exactly;display: none;max-width: 0px;max-height: 0px;opacity: 0;overflow: hidden;mso-hide:all;">
            Стартовое описание
        </div>
        <!-- End Preheader (remove comment) -->

        <!--[if (gte mso 9)|(IE)]>
        <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" role="presentation"
               style="color:#000000;">
            <tr>
                <td>
        <![endif]-->

        <table align="center" border="0" cellspacing="0" cellpadding="0" role="presentation"
               style="color:#000000;font-family: 'Inter',Helvetica,sans-serif, Arial, ;background: #fafdfe;Margin:0;padding:0;width: 100%;max-width: 600px;"
        >
            <!-- Logo -->
            <tr class="dark-logo">
                <td>
                    <table align="center" border="0" cellspacing="0" cellpadding="0" role="presentation">
                        <tr>
                            <td style="padding: 19px 0 19px 0;text-align: center;">
                                <a href="https://anistroy.ru" target="_blank">
                                    <img src="{{ $message->embed('images/logo-anistroy-2.png') }}" alt="Anistroy Logo" border="0" width="153" />
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="light-logo">
                <td>
                    <table align="center" border="0" cellspacing="0" cellpadding="0" role="presentation">
                        <tr>
                            <td style="padding: 19px 0 19px 0;text-align: center;">
                                <a href="https://anistroy.ru" target="_blank">
                                    <img src="{{ $message->embed('images/logo-anistroy-1.png') }}" alt="Anistroy Logo" border="0" width="153" />
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- End Logo -->

            <!-- Info -->
            <tr>
                <td style="padding: 0px 24px 25px 24px;">
                    <table border="0" cellspacing="0" cellpadding="0" role="presentation" style="width: 100%; max-width: 600px;">
                        <tr>
                            <td>
                                <div style="height: 1px; width: 100%;background-color:#f3f3f3;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0 50px 0;">
                                <p style="margin: 0;font-weight: 400;font-size: 16px;line-height: 25px; text-align: center;">
                                    Изменение пароля на сайте <a style="color: #1061AB; text-decoration: underline; font-weight: 700;" href="https://anistroy.ru" target="_blank">anistroy.ru</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td style="padding-top: 20px">
                                            <p style="margin: 0 0 20px; font-size: 14px;">
                                                Вы (или еще кто-то) запросили изменение пароля для входа в личный кабинет на сайте <a href="https://anistroy.ru">anistroy.ru</a>
                                            </p>
                                            <p style="margin: 0 0 20px; font-size: 14px;">
                                                Новый пароль вы можете получить здесь:<br>
                                                <a href="{{ $actionUrl }}">{{ $actionUrl }}</a>
                                            </p>
                                            <p style="margin: 0 0 20px; font-size: 14px;">
                                                Если запрос был отправлен не вами, просто проигнорируйте это письмо.
                                            </p>
                                            <p style="margin: 0 0 20px; font-size: 14px;">
                                                Спасибо!<br>
                                                Ваш Анистрой
                                            </p>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- End Info -->

        </table>

        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->

    </div>
</center>

</body>

</html>

