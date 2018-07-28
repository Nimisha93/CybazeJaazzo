<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>Jaazzo | rewards unlimitted</title>
    <link rel="stylesheet" href="<?= base_url();?>assets/public/css/su-stylesheet.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?= base_url();?>assets/public/css/su-stylesheet2.css" type="text/css" media="screen" />
    <style type="text/css">
        .modal-content {
            position: relative;
            margin: 30px 20px;
            background-color: #fff;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            border: 1px solid #999;
            border: 1px solid rgba(0,0,0,.2);
                border-top-width: 1px;
                border-top-style: solid;
                border-top-color: rgba(0, 0, 0, 0.2);
            border-top: none;
            border-radius: 0px;
            outline: 0;
            -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
            box-shadow: 0 3px 9px rgba(0,0,0,.5);
        }

        .modal-dialog {
            width: 1000px;
            margin: 30px auto;
        }

        .modal-header {
            padding: 15px;
            border-bottom: 1px solid #e5e5e5;
            background-color: #f5f5f5;
        }

        .modal-title {
            color: #1d2231;
            font-family: 'robotolight';
            font-weight: normal;
        }
        .modal-body {
            position: relative;
            padding: 15px;
        }

        .notice {
            padding: 15px;
            background-color: #fafafa;
            border-left: 6px solid #7f7f84;
            margin-bottom: 10px;
            -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
               -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
                    box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
        }
        .notice-sm {
            padding: 10px;
            font-size: 100%;
        }
    </style>
</head>
<html>
    <body>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: 600">
                    Club Member Type :: <?= $details['title']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="notice notice-sm">
                        <strong>Amount :</strong><?= $details['amount']; ?>
                    </div>
                     <div class="notice notice-sm">
                        <strong>No. of years :</strong><?= $details['cash_limit']; ?>
                    </div>
                     <div class="notice notice-sm">
                        <strong>Type :</strong><?= $details['type']; ?>
                    </div>
                    <div class="notice notice-sm">
                        <strong>Description :</strong><?= $details['description']; ?>
                    </div>
                    <div class="notice notice-sm">
                        <strong>BDE Benefit :</strong><?= $details['bde_benefit']; ?>
                    </div>
                    <div class="notice notice-sm">
                        <strong>TL Benefit :</strong><?= $details['tl_benefit']; ?>
                    </div>
                    <?php if($details['cp_status']==1) {?>
                    <div class="notice notice-sm">
                        <strong>Channel Partner Facility :</strong><?= $details['cp_limit']; ?>
                    </div>
                    <?php } ?>
                    <?php if($details['club_agent_status']==1) {?>
                    <div class="notice notice-sm">
                        <strong>Club Agent Facility :</strong><?= $details['ca_limit']; ?>
                    </div>
                    <?php } ?>
                    <?php if($details['user_status']==1) {?>
                    <div class="notice notice-sm">
                        <strong>Individual Friend Facility :</strong><?= $details['user_limit']; ?>
                    </div>
                    <?php } ?>
                    <?php if($details['ba_status']==1) {?>
                    <div class="notice notice-sm">
                        <strong>Jaazzo Store Facility :</strong><?= $details['ba_limit']; ?>
                    </div>
                    <?php } ?>
                    <?php if($details['bde_status']==1) {?>
                    <div class="notice notice-sm">
                        <strong>BDE Facility :</strong><?= $details['bde_limit']; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </body>
</html>