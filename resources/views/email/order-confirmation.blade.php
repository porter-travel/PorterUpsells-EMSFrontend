@php use App\Helpers\Money; @endphp
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
          rel="stylesheet">
    <title>Order Summary</title>


    <style type="text/css">
        img {
            max-width: 100%;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            line-height: 1.6em;
        }

        body {
            background-color: #f6f6f6;
        }

        *, p {
            font-family: 'Open Sans', sans-serif !important;
        }

        @media only screen and (max-width: 640px) {
            body {
                padding: 0 !important;
            }

            h1 {
                font-weight: 800 !important;
                margin: 20px 0 5px !important;
            }

            h2 {
                font-weight: 800 !important;
                margin: 20px 0 5px !important;
            }

            h3 {
                font-weight: 800 !important;
                margin: 20px 0 5px !important;
            }

            h4 {
                font-weight: 800 !important;
                margin: 20px 0 5px !important;
            }

            h1 {
                font-size: 22px !important;
            }

            h2 {
                font-size: 18px !important;
            }

            h3 {
                font-size: 16px !important;
            }

            .container {
                padding: 0 !important;
                width: 100% !important;
            }

            .content {
                padding: 0 !important;
            }

            .content-wrap {
                padding: 10px !important;
            }

            .invoice {
                width: 100% !important;
            }


        }
    </style>
</head>
<body itemscope itemtype="http://schema.org/EmailMessage"
      style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;"
      bgcolor="#f6f6f6">

<table class="body-wrap"
       style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"
       bgcolor="#f6f6f6">
    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
        <td class="container" width="800"
            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 800px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 800px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td
                            background="{{$hotel->featured_image}}"
                            class=""
                            style="background:url({{$hotel->featured_image}}) no-repeat center center / cover; height: 250px;"
                            align="center" bgcolor="" valign="top">
                            <table
                                style="width: 100%; background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 100%);">
                                <tr>
                                    <td style="height: 150px">

                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; padding: 16px">
                                        <table>
                                            <tr>
                                                <td>
                                                    <img src="{{$hotel->logo}}" alt="hotel"
                                                         style="width: 100px; height: auto; border-radius: 4px; object-fit: contain"/>

                                                </td>
                                                <td>
                                                    <p
                                                        style="color: white; font-size: 24px; font-weight: bold; margin-left: 16px">{{$hotel->name}}</p>

                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="color: black; font-size: 20px; font-weight: bold; padding: 16px">Order Summary</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 16px">
                            @foreach(json_decode($order['items'], true) as $key => $item)
                                @if(isset($item['image']))
                                    <table>
                                        <tr>
                                            <td>
                                                <div
                                                    style="width: 156px; height: 156px; position: relative; overflow: hidden;">
                                                    <img src="{{$item['image']}}" alt="{{$item['variation_name']}}"
                                                         style="width: 100%; height: 100%; display: block; object-fit: cover;"
                                                         class="w-full">
                                                </div>
                                            </td>
                                            <td style="padding-left: 5px">
                                                <p><strong>{{$item['product_name']}}</strong></p>
                                                <p>
                                                    @if($item['variation_name'])
                                                        Options: {{$item['variation_name']}}<br/>
                                                    @endif
                                                    Date: {{ \Carbon\Carbon::parse($item['date'])->format('jS M') }}
                                                    @if(isset($item['arrival_time']) && $item['arrival_time'])
                                                        <br/>Time: {{$item['arrival_time']}}
                                                    @endif
                                                </p>
                                                <p>
                                                    <x-money-display :amount="$item['price']"
                                                                     :currency="$order->hotel->user->currency"></x-money-display>

                                                </p>

                                            </td>
                                        </tr>
                                    </table>

                                @endif
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>
</body>
</html>







