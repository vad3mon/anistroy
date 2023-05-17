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
                      <img src="{{ $message->embed('images/logo-anistroy-2.png')  }}" alt="Anistroy Logo" border="0" width="153" />
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
                      <img src="{{ $message->embed('images/logo-anistroy-1.png')  }}" alt="Anistroy Logo" border="0" width="153" />
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
                      Вы оформили заказ на сайте <a style="color: #1061AB; text-decoration: underline; font-weight: 700;" href="https://anistroy.ru" target="_blank">anistroy.ru</a>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 0 0 25px 0;">
                    <h1 style="margin: 0;font-weight: 700;font-size: 30px;line-height: 1;color: #000000;">Заказ №{{ $mailData['id'] }}</h1>
                  </td>
                </tr>

                <tr>
                  <td>
                    <table border="0" cellspacing="0" cellpadding="0" role="presentation" style="width: 100%; max-width: 600px;">
                      <tr>
                        <td>
                          <span style="margin: 0 0 5px 0; color: #1061AB; font-size: 14px; font-weight: 700;">Дата</span>
                          <p style="margin: 0; font-size: 14px;">{{ $mailData['date'] }}</p>
                        </td>
{{--                        <td>--}}
{{--                          <span style="margin: 0 0 5px 0; color: #1061AB; font-size: 14px; font-weight: 700;">Статус</span>--}}
{{--                          <p style="margin: 0; font-size: 14px;">{{ $mailData['status'] }}</p>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                          <span style="margin: 0 0 5px 0; color: #1061AB; font-size: 14px; font-weight: 700;">Статус оплаты</span>--}}
{{--                          <p style="margin: 0; font-size: 14px;">{{ $mailData['payment_status'] }}</p>--}}
{{--                        </td>--}}
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table>
                      <tr>
                        <td style="padding-top: 20px">
                          <span style="margin: 0 0 5px 0; color: #1061AB; font-size: 14px; font-weight: 700;">Имя</span>
                          <p style="margin: 0; font-size: 14px;">{{ $mailData['name'] }}</p>
                        </td>
                      </tr>

                      <tr>
                        <td style="padding-top: 20px">
                          <span style="margin: 0 0 5px 0; color: #1061AB; font-size: 14px; font-weight: 700;">Телефон</span>
                          <p style="margin: 0; font-size: 14px;">{{ $mailData['phone'] }}</p>
                        </td>
                      </tr>

                      <tr>
                        <td style="padding-top: 20px">
                          <span style="margin: 0 0 5px 0; color: #1061AB; font-size: 14px; font-weight: 700;">Электронная почта</span>
                          <p style="margin: 0; font-size: 14px;">{{ $mailData['email'] }}</p>
                        </td>
                      </tr>

                        <tr>
                            <td style="padding-top: 20px">
                                <span style="margin: 0 0 5px 0; color: #1061AB; font-size: 14px; font-weight: 700;">Комментарий</span>
                                <p style="margin: 0; font-size: 14px;">{{ $mailData['comment'] }}</p>
                            </td>
                        </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- End Info -->

          <!-- Order -->
          <tr>
            <td style="padding: 40px 24px 0 24px;">
              <table border="0" cellspacing="0" cellpadding="0" role="presentation">
                <tr>
                  <td style="padding: 0 0 25px 0;text-align: center;">
                    <h2 style="margin: 0;font-weight: 700;font-size: 20px;line-height: 1;color: #000000;">Состав заказа</h2>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding: 0 14px 0 14px;">
              <div style="overflow-x: auto; max-width: 600px;">
                <table border="0" cellspacing="0" cellpadding="0" role="presentation" style="Margin:0;padding:0;width: 100%;font-size: 14px;">
                  @foreach($mailData['products'] as $product)
                  <tr>
                    <td style="padding: 10px 10px 10px 10px; width: 65px">
                      <img src="{{ $message->embed('images/products/' . $product['image']) }}" alt="product" border="0" width="552"
                        style="width: 65px; height: 65px; object-fit: cover" />
                    </td>
                    <td style="padding: 0 5px 0 5px; min-width: 250px;">{{ $product['name'] }}</td>
                      @if($product['price'] > 0)
                        <td style="padding: 0 5px 0 5px; text-align: center; min-width: 100px;">{{ $product['price'] }} руб. / {{ $product['unit'] }}</td>
                      @else
                          <td style="padding: 0 5px 0 5px; text-align: center; min-width: 100px;">Под заказ</td>
                      @endif
                    <td style="padding: 0 5px 0 5px; text-align: center; min-width: 60px;">{{ $product['quantity'] }}</td>
                      @if($product['cost'] > 0)
                          <td style="padding: 0 5px 0 5px; text-align: center; min-width: 100px;">{{ $product['cost']  }} руб. / {{ $product['unit'] }}</td>
                      @else
                          <td style="padding: 0 5px 0 5px; text-align: center; min-width: 100px;">Под заказ</td>
                      @endif

                  </tr>
                @endforeach

                </table>
              </div>
            </td>
          </tr>
          <tr>
            <td style="padding: 20px 20px 20px 20px">
              <div style="height: 1px; width: 100%;background-color:#f3f3f3;"></div>
            </td>
          </tr>
          <tr>
            <td>
                @if($mailData['amount'] > 0)
                  <table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" role="presentation">
                    <tr>
                      <td style="font-weight: 700; padding: 0 20px 50px 20px">Итого:</td>
                      <td style="font-weight: 700; text-align: right; white-space: nowrap; padding: 0 20px 50px 20px">{{ $mailData['amount'] }} руб.</td>
                    </tr>
                  </table>
                @endif
            </td>
          </tr>
          <!-- End Order -->
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
