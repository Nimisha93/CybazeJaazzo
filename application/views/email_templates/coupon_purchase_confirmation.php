<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />

    <title>jaazzo-coupon</title>
    <style type="text/css">
        body {
            width: 100% !important;
            margin: 0;
            padding: 0;
          
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            font-family: arial;
        }
        .aBn {
              border-bottom: none;
          }
        td {
            vertical-align: top
        }
        .li a[href] {
            color: #a9abad;
            text-decoration: none;
        }
        .bgimage {
            width: 481px;
            height: 226px;
            background: url("<?= base_url(); ?>assets/admin/images/bgimage.jpg") no-repeat;
        }
    </style>

</head>

<body>

<table class="bgimage">
    <tr>
        <td style="width: 180px;height: 83px;padding-left: 63px;">
            <table>
                <tr>

                    <td style="color: #02a99b;font-size: 30px;font-weight: bold;padding-top: 17px">
                        VOUCHER
                    </td>
                </tr>
                <tr>

                    <td style="font-size: 11px;color: #c9c3c3;line-height: 14px;">
                       <!--  In publishing and graphic design, lorem ipsum is a filler -->
                    </td>
                </tr>
            </table>

        </td>

        <td style="width: 118px;">
            <table>
                <tr>

                    <td style="color: #fff;font-size: 12px;padding-left: 14px;padding-top: 34px">
                        Coupon No.
                    </td>
                </tr>
                <tr>

                    <td style="font-size: 20px;color: #fff;font-weight: bold;padding-left: 11px; line-height: 17px;">
                        JZ<?= $coupon_code ?>
                    </td>
                </tr>
            </table>

        </td>
        <td style="width: 120px;">

        </td>
    </tr>

    <tr>
        <td style="width: 180px;padding-left: 63px;">
            <table>
                <tr>

                    <td style="color: #e3e3e3;font-size: 20px;">
                        VALUE
                    </td>
                </tr>
                <tr>

                    <td style="color: #02a99b;font-size: 30px;font-weight: bold;padding-top: 5px">
                        <img src="<?= base_url(); ?>assets/admin/images/rupees.png" style="float: left"> <span style="font-size: 40px;line-height:30px"> <?= $price; ?>/ </span>

                    </td>

                </tr>
            </table>

        </td>

        <td style="width: 118px;font-size: 11.5px;color: #afb0b4;padding-top: 50px;text-align: center;font-weight:
        lighter">
           <?= $name; ?>
        </td>
        <td style="width: 120px;font-size: 11.5px;color: #afb0b4;padding-top: 50px;text-align: center;font-weight:
        lighter;padding-right: 5px">

            <?= $address; ?>,<?= $city; ?>,<br> <?= $state; ?>,<?= $country; ?>
        </td>
    </tr>

    <tr>
        <td style="width: 180px;text-align: center;">
            <table>
                <tr>
                    <td style="font-size: 11px;color: #c9c3c3;line-height: 14px;border-bottom: none;">
                    Coupon valid till <?= $coupon_validity; ?>
                        
                    </td>
                </tr>
            </table>
        </td>

        <td colspan="2" style="font-size: 11px;color: #afb0b4;line-height: 14px;padding-left: 65px;font-weight: lighter">
            Keep this coupon with you while purchasing.
        </td>

    </tr>

</table>
</body>

</html>