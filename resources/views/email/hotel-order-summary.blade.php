<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
                        <td class="alert alert-warning"
                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #000; margin: 0; padding: 20px;"
                            align="center" bgcolor="#7FFFD4" valign="top">
                            Please find below a summary of orders for {{$hotel->name}} over the next 7 days
                        </td>
                    </tr>
                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        @if(count($orders) > 0)
                                            <table style="width: 100%; border-collapse: collapse">
                                                <thead>
                                                <tr style="text-align: left; background-color: #EFEFEF">
                                                    <th style="padding: 8px" class="p-2">Booking Ref</th>
                                                    <th style="padding: 8px" class="p-2">Date Requested</th>
                                                    <th style="padding: 8px" class="p-2">Name</th>
                                                    <th style="padding: 8px" class="p-2">Items</th>
                                                    <th style="padding: 8px" class="p-2 ">Status</th>
                                                </tr>
                                                </thead>
                                                @foreach($orders as $order)

                                                    <tr style="border-width: 1px; border-color: #000000; border-style: solid">
                                                        <td style="padding: 8px">{{$order['booking_ref']}}</td>
                                                        <td style="padding: 8px">{{date_create_from_format('Y-m-d', $order['arrival_date'])->format('d/m/Y')}}</td>
                                                        <td style="padding: 8px">{{$order['name']}}</td>
                                                        {{--                                        <td class="p-2">{{$order->created_at}}</td>--}}
                                                        <td style="padding: 8px">
                                                            @foreach($order['items'] as $item)
                                                                {{$item['quantity']}} x
                                                                {{$item['name']}}
                                                                @if($item['product_type'] == 'variable')
                                                                    <br><span class="text-sm">{{$item['variation_name']}}</span>
                                                                @endif
                                                                <br>
                                                            @endforeach
                                                        </td>
                                                        <td style="padding: 8px; background-color:
                                        @if($order['status'] == 'cancelled')
                                        #FF0000;
@elseif($order['status'] == 'fulfilled')
                                       #D4F6D1;
@elseif($order['status'] == 'pending')
                                        #F5D6E1;
                                        @endif
                                        ">


                                                            {{$order['status']}}
                                                        </td>
                                                    </tr>

                                                @endforeach
                                            </table>
                                            @else
                                            <p>No orders for the next 7 days</p>
                                        @endif
                                    </td>
                                </tr>
                                {{--                                @if(isset($link))--}}
                                {{--                                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">--}}
                                {{--                                        <td class="content-block"--}}
                                {{--                                            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"--}}
                                {{--                                            valign="top">--}}
                                {{--                                            <a href="{{$link}}" class="btn-primary"--}}
                                {{--                                               style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">--}}
                                {{--                                                {{$linkText}}</a>--}}
                                {{--                                        </td>--}}
                                {{--                                    </tr>--}}
                                {{--                                @endif--}}
                            </table>
                        </td>
                    </tr>
                </table>
                {{--                <div class="footer"--}}
                {{--                     style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">--}}
                {{--                    <table width="100%"--}}
                {{--                           style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">--}}
                {{--                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">--}}
                {{--                            <td class="aligncenter content-block"--}}
                {{--                                style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"--}}
                {{--                                align="center" valign="top"><a href="http://www.mailgun.com"--}}
                {{--                                                               style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">Unsubscribe</a>--}}
                {{--                                from these alerts.--}}
                {{--                            </td>--}}
                {{--                        </tr>--}}
                {{--                    </table>--}}
                {{--                </div>--}}
            </div>
        </td>
        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>
</body>
</html>











