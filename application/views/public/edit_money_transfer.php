<?= $default_assets;?>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/style-grid.css" />
    <noscript>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/fallback.css" />
  </noscript>
    <script type="text/javascript" src="<?= base_url();?>assets/public/js/modernizr.custom.26633.js"></script>
    <style type="text/css">
    .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #000;z-index: 17;}
    @media (max-width:1030px){
    .goToTop{height:auto;position:relative;}
    }
    @media (max-width:767px){
        .goToTop {
        position: relative;
        top: 0;
        left: 0;
        z-index: 10;
          background-color: #1a4794;
      }
    }
    .form-control1{
      display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 13px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);}

        .mblmny
        {width: 300px;
margin:auto;
padding: 20px;
border: 1px solid #ccc}

  </style>
</head>
<body>
<!--===========header end here ========================-->
<?= $header;?>
 <header>
      <div class="container-fluid" >
      </div>
      </div>
    </div>
  </div>
</header>
<!--===========header end here ========================-->
<div class="clear"></div>
</div>
<section class="top_pad20 botm_pad20">
  <div class="container tp_mar20">
    <div class="mblmny">
      <h5>Jaazzo Easy Transfer</h5>
      <div class="logn_frrmbx">
        <form name="transfer_form" method="post" id="transfer_form" action="<?php echo base_url();?>user/Money_transfer/transfer_amount">
          Select Your Wallet :
          <select id="wallet_ids" name="transfer_type" class="form-control" style="width: 95%">
                <option value="">please select</option>
                <?php 
                  foreach ($wallet as $key => $wal) { 
                    if($wal['wallet_type_id']!='3'){
                ?>
                <option value="<?php echo $wal['wallet_type_id'] ?>">
                  <?php echo $wal['title'] ?></option>
                <?php }} ?>
                <!-- <option value="<?php echo $vallet_type['reward_id'] ?>">
                  <?php echo $vallet_type['reward_name'] ?></option>
                <option value="<?php echo $vallet_type['mywallt_id'] ?>">
                  <?php echo $vallet_type['mywallet_name'] ?>
                </option>
                <?php if($session_array2['type']=='club_member'){?>
                <option value="<?php echo $vallet_type['club_id'] ?>">
                  <?php echo $vallet_type['club_name'] ?>
                </option>
                <?php } ?> -->
          </select>
          <br>
          <div style="display: none" id="wallet_value">
            Wallet Amount  :
            <input class="txt_bg3" name="wallet" id="wallet" type="text" value="" />
          </div>
          <div class="logn_frrmbx">
Enter Mobile :  <input class="txt_bg3" name="transfer_mobile" type="number"  onKeyPress="return isNumberKey(event)" placeholder="Mobile" style="width: 96%;"/>
            <br>
            Enter Amount :  <input class="txt_bg3 edit1" id="transfer_amount" name="transfer_amount" type="text" placeholder="Amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width: 96%;"/>
            <input type="submit" name="transfer_submit" id="transfer_submit" class="button_submit3 continue_login" value="Continue">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $(".gototop").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });
    });
</script> 
<?php echo $footer; ?>
</body>
</html>