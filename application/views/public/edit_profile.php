<?= $default_assets;?>
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }

.man label.error
{
  position: absolute;
    top: 34px;
    left: 0;
}
.main label.error
{
  position: absolute;
    top: 34px;
    left: 0;
}

label.error {
    color: red;
    /* font-style: italic; */
    position: absolute;
    top: 52px;
}

.mnadres label.error
{
  position: absolute;
        top: 90px;
    left: 13px;
  }


</style>
<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<link href="<?php echo base_url();?>assets/public/css/dashboard.css" rel="stylesheet" type="text/css" /> 
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" /> 
<script src="<?php echo base_url();?>assets/public/js/jquery-ui.min.js"></script> 
<script src="<?php echo base_url();?>assets/public/js/angular.min.js"></script> 


<script type="text/javascript">
$(function () {
    $("#date").datepicker({
      dateFormat: 'dd/mm/yy'
    });$("#dt_from").datepicker({
      dateFormat: 'dd/mm/yy'
    });$("#dt_to").datepicker({
      dateFormat: 'dd/mm/yy'
    });
});
angular.module("date", [])
    .directive("datepicker", function () {
    return {
        restrict: "A",
        link: function (scope, el, attr) {
            el.datepicker({
                            dateFormat: 'dd/mm/yy'
                        });
        }
    };
}).controller("dateCtrl", function ($scope) {
});
angular.module("date2", [])
    .directive("datepicker", function () {
    return {
        restrict: "A",
        link: function (scope, el, attr) {
            el.datepicker({
                            dateFormat: 'dd/mm/yy'
                        });
        }
    };
}).controller("dateCtrl2", function ($scope) {
});
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57 ))
        return false;
    return true;
  }
</script>
<?php  
  $datas = getLoginId();
  $lid = $datas['login_id'];
  $club_type_id = $datas['club_type_id'];
  $investor = isset($datas['investor_type_id'])?$datas['investor_type_id']:0;
  //$fixed = isset($datas['fixed_type_id'])?$datas['fixed_type_id']:0;
  $fixed = isset($datas['fixed_club_type_id'])?$datas['fixed_club_type_id']:0;
  $session_array1 = $this->session->userdata('logged_in_user');
  $session_array2 = $this->session->userdata('logged_in_club_member');
  $session_array3 = $this->session->userdata('logged_in_club_agent');
        
  if(isset($session_array1)){
    $type= $session_array1['type'];
  }
  if(isset($session_array2)){
    $type= $session_array2['type'];
  echo $map['js']; ?>
  <script type="text/javascript">
    function getPosition(newLat, newLng)
    {
      $('#lat').val(newLat);
      $('#long').val(newLng);
    }
  </script>   
<?php  }
  if(isset($session_array3)){
    $type= $session_array3['type'];
  }
?>

<div id="uplodimage" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">X</button>
        <h4 class="modal-title">Upload Your Profile Image</h4>
      </div>
      <form method="post" name="profile_img" id="profile_img" action="<?php echo base_url();?>Home/update_profile_pic" enctype="multipart/form-data">
        <div class="modal-body">
          <div>
            <div class="fileUpload btn btn-primary">
              <span>Upload</span>
              <input id="fileupload" type="file" class="upload" id="fileupload" name="userfile" />
            </div>
            <hr />
            <b>Live Preview</b>
            <br />
            <br />
            <div id="dvPreview">
            </div>
          </div>
          <input type="submit" name="upload" class="btn btn-danger" value="Save" style="margin-top:10px;margin-left:10px;">
  <!--    <button type="button" class="btn btn-danger" style="margin-top:10px;">Save</button>-->
        </div>
       </form>
    </div>
  </div>
</div>

<link rel="stylesheet" href="<?php echo base_url();?>assets/public/css/easy-responsive-tabs.css">

<style type="text/css">
.row{margin:0;}
.goToTop{position:fixed;border-bottom:1px solid #000;z-index: 17;}

.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.upld
{
      background-color: #f9f9f9;
    height: 40px;
    padding-left: 20px;
    -webkit-box-align: no;
    box-shadow: none;
    border: 1px solid #ccc;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
@media (max-width:980px){
.goToTop{height:40px;position:relative;}
}
@media (max-width:767px){
  .goToTop {
    position: relative;
    top: 0;
    left: 0;
    z-index: 10;
    background-color: #1a4794;
  }

.row{margin:0;}
}
.error{
  color: red;
}
</style>
</head>
<body>
<!--===========header end here ========================-->
<?= $header;?>
</div>
<div class="clear"></div>
<section>
  <div class="content">
    <div class=" strchbx">
      <div id="oilfield">
        <ul class="resp-tabs-list">
          <div class="strchbxchild2">
            <div class="profimagemain">
            <?php $img = (!empty($user['profile_image']))? $user['profile_image']:'profile.jpg';?>
              <img class="profleimge" src="<?php echo base_url();?>uploads/<?= $img;?>">
              <div class="prflname"><?php echo  $user['name']; ?></div>
              <div class="prflemail"><?php echo  $user['email']; ?></div>
            </div>
            <li><i class="fa fa-tachometer marleft7" aria-hidden="true"></i>Dashboard</li>
            <li><i class="fa fa fa-user-circle-o marleft7" aria-hidden="true"></i>About</li>
            <li><i class="fa fa-user marleft7" aria-hidden="true"></i>Update Account Info </li>
            <?php if($type=='normal_customer'||$type=='club_member'||$type=='club_agent') {?>
            <li><i class="fa fa-exchange marleft7" aria-hidden="true"></i>My Transactions</li>
            <?php 
            if((($type=='club_member') && (($club_type_id>0 || $investor>0) && $fixed==0  ))||$type=='club_agent'){
            ?>
            <li><a href="<?php echo base_url();?>get_reports" style="color: #b7b7b7;"><i class="fa fas fa-align-justify marleft7" aria-hidden="true"></i>Statements</a></li>
            <?php }
              }
            ?>
            <li><i class="fa fa-cog marleft7" aria-hidden="true"></i>Account Settings</li>
            <li><i class="fa  fa-inr marleft7" aria-hidden="true"></i>Wallet</li>

            <?php 
            if((($type=='club_member') && (($club_type_id>0 || $investor>0) && $fixed==0  ))||$type=='club_agent') {
            ?>
            <li><i class="fa fa-users marleft7" aria-hidden="true"></i>All Active <?php echo($type=='club_agent')?'Members':'Friends'?></li>
            <li><i class="fa fa-user-o marleft7" aria-hidden="true"></i>All Referred <?php echo($type=='club_agent')?'Members':'Friends'?></li>
            <?php
              if(($type=='club_member') && (($club_type_id>0 || $investor>0) || $fixed==0  ))
              {
            ?>
            <li><i class="fa fa-window-maximize marleft7" aria-hidden="true"></i>All Club Agents</li>
<?php }
            } 

              if($datas){
                $lid = $datas['login_id'];
                $userid = $datas['user_id'];
                $udetail = get_details_by_userid($userid);
                $dateString=$udetail['created_on'];
                $fixed_joind=$udetail['fixed_join_date'];
                $years = round((time()-strtotime($dateString))/(3600*24*365.25));
                $fix_years = round((time()-strtotime($fixed_joind))/(3600*24*365.25));

                $investor = isset($datas['investor_type_id'])?$datas['investor_type_id']:0;
                $club_type_id = $datas['club_type_id'];
              }  
              $det = get_cmfacility_by_id($lid);
              if($type=='club_member'){  
                $year_limit =  $det['year_limit'];
                $ul_cp_status = $det['cp_status'];
              }
              if($fixed>0){
                $fixed_plan = $udetail['fixed_club_type_id'];
                $fixed_details = getClubtypeById($fixed_plan);
                $fixed_amnt = $fixed_details['amount'];
                $ref_cp_status = $fixed_details['ref_cp_status'];
                $cp_status = $fixed_details['cp_status'];
                $reward_per_refer_cp = $fixed_details['ref_reward_per_cp'];
                $reward_per_cp = $fixed_details['reward_per_cp'];

                $fixed_wallet_used = get_wallet_used_by_member($lid,5);
                $fixed_wallet_details = get_fixed_wallet_details($lid);

                $expected_total1 = $fixed_wallet_details +$reward_per_refer_cp + $fixed_wallet_used;
                $expected_total2 = $fixed_wallet_details +$reward_per_cp + $fixed_wallet_used;
                $exp1 = $fixed_wallet_details+$fixed_wallet_used;
                $allow1 = '';
                $fix_year_exceed = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($fixed_joind)));

                if($exp1<$fixed_amnt){
                  $allow1 = 1 ;
                }
              }
             if(($type=='club_member') &&  ((($fixed>0) && ($ref_cp_status==1) && (date('Y-m-d H:i:s')<=$fix_year_exceed)&&(($expected_total1<=$fixed_amnt)|| ($allow1==1))) || (($club_type_id>0) && ($ul_cp_status==1) &&($year_limit>=$years)) || (($year_limit>=$years)&&($investor>0)&& ($ul_cp_status==1)))){ 
            
            //if(($type=='club_member') &&  (($investor==0) || (($fixed>0) && (($expected_total1<=$fixed_amnt)|| isset($allow1))) || ($club_type_id>0))){ 
            ?>
            <li><i class="fa fa-handshake-o marleft7" aria-hidden="true"></i>Refer Channel Partner</li>
            <?php
              }
            if($type=='club_member'){  
              $year_limit =  $det['year_limit'];
              if($datas['fixed_club_type_id']>0){
                $fixed_year_limit =  $det['fixed_year_limit'];
              }else{
                $fixed_year_limit =0;
              }
           // if((($year_limit>=$years)&&($det['cp_limit']>$det['cp_count'])) || ((($fixed_year_limit>=$fix_years))&&($det['fixed_cp_limit']>$det['fixed_cp_count']) && (($expected_total2<=$fixed_amnt)|| isset($allow1)))){
           if((($year_limit>=$years) && ($investor>0)&& ($ul_cp_status==1))||(($year_limit>=$years)&&($club_type_id>0)&& ($ul_cp_status==1)) || ( ($fixed>0) && ($cp_status==1) &&(date('Y-m-d H:i:s')<=$fix_year_exceed)&&($fixed_year_limit>=$fix_years)&& (($expected_total2<=$fixed_amnt)|| ($allow1==1)))){
            ?>
            <li><i class="fa fa-handshake-o marleft7" aria-hidden="true"></i>Add Channel Partner</li>
            <?php } 
            if((($investor>0)&& ($ul_cp_status==1))||
              (($club_type_id>0)&& ($ul_cp_status==1)) || 
              (($fixed>0) && ($cp_status==1))){ 
            ?>
            <li><i class="fa fa-handshake-o marleft7" aria-hidden="true"></i>All Channel Partners</li>
            <?php  
              }
             if(($year_limit>=$years) && ($det['ba_limit']>$det['ba_count'])){
            ?>
            <li><i class="fa fa-handshake-o marleft7" aria-hidden="true"></i>Add Jaazzo Store</li>
            <?php
             }
             if($club_type_id>0||$investor>0){
              if($club_type_id>0){
            ?>
            <li><i class="fa fa-window-maximize marleft7" aria-hidden="true"></i>Refer Jaazzo Store</li>
            <?php }?>
            <li><i class="fa fa-window-maximize marleft7" aria-hidden="true"></i>All Jaazzo Stores</li>
            <?php }
              if(($year_limit>=$years)&&($investor>0) && ($det['bde_limit']>$det['bde_count'])){
            ?>
             <li><i class="fa fa-window-maximize marleft7" aria-hidden="true"></i>Add Business Executives</li>
            <?php
              }
              if($investor>0){
            ?>
            <li><i class="fa fa-window-maximize marleft7" aria-hidden="true"></i>All Business Executives</li>
            <?php    
              }
            }
            if(($type=='club_member')||($type=='club_agent'))
            {
            ?>
            <li><i class="fa fa-commenting-o marleft7" aria-hidden="true"></i>Notifications</li>
            <?php
            }
            ?>

            <div class="hegtdiv"></div>
          </div> 
        </ul>
        <div class="resp-tabs-container">
          <div>
            <div class="row wlletbg_prfile">
                <?php 
                if((($type=='club_member') && (($club_type_id>0 || $investor>0) && $fixed==0)||($club_type_id>0))||$type=='club_agent'){

                  if($type=='club_agent'){
                    $det1 = get_ca_facility_by_id($lid);
                    $tit = 'Normal Members';
                  }else{
                    $det1 = get_cmfacility_by_id($lid);//get_cm_facility_by_id($lid);
                    $tit = 'Individual Friends';
                  }
                ?>
                <!-- NC -->
                <div class="col-lg-4 col-sm-6">
                    <div class="circle-tile">
                        <div class="circle-tile-heading orange" style="background-color: #242322;">
                          <i class="fa fa-users fa-fw fa-3x"></i>
                        </div>
                        <div class="circle-tile-content orange" style="background-color: #9194a2;">
                            <div class="circle-tile-description text-faded">
                                <?= $tit; ?>
                            </div>
                            <div class="circle-tile-number text-faded" style="font-size: 12px;">
                              Limit :<?= $det1['frnd_limit']?>
                            </div>
                            <div class="circle-tile-number text-faded" style="font-size: 12px;">
                              Total Count :<?= $det1['frnd_count']?>
                            </div>
                            <a href="<?php echo base_url();?>user_profile#oilfield8" class="circle-tile-footer" onclick="window.location.href='<?php echo base_url();?>user_profile#oilfield8';location.reload();">More Info <i class="fa fa-chevron-circle-right"></i></a>
                            <?php if($det1['frnd_count']>=$det1['frnd_limit']){?>
                            <br>
                            <h4>Your limit has been exceed !!</h4>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
                <?php 
                } 
                if($type=='club_member'){
                  if((($investor>0)&& ($ul_cp_status==1))||(($club_type_id>0)&& ($ul_cp_status==1)) || (($fixed>0) && ($cp_status==1))){
                ?>
                <!-- CP -->
                <div class="col-lg-4 col-sm-6">
                    <div class="circle-tile">
                        <div class="circle-tile-heading dark-blue" style="background-color: #242322;">
                              <i class="fa fa-handshake-o fa-fw fa-3x"></i>
                        </div>
                        <div class="circle-tile-content dark-blue" style="background-color: #9194a2;">
                            <div class="circle-tile-description text-faded">
                                Channel Partners
                            </div>
                            <div class="circle-tile-number text-faded" style="font-size: 12px;">
                            <?php 
                              $det1 = get_cmfacility_by_id($lid);
                              
                              $fixed_cp_limit= !empty($det1['fixed_cp_limit'])?$det1['fixed_cp_limit']:0;
                              $fixed_cp_count = !empty($det1['fixed_cp_count'])?$det1['fixed_cp_count']:0;
                              $cp_limit= (!empty($det1['cp_limit'])&&($club_type_id>0||$investor>0))?$det1['cp_limit']:0;
                              $cp_count = (!empty($det1['cp_count'])&&($club_type_id>0||$investor>0))?$det1['cp_count']:0;
                              $total_limit = $fixed_cp_limit+$cp_limit;
                              $total_count = $fixed_cp_count+$cp_count;
                            ?>
                                Limit :<?= $total_limit; ?>
                                <span id="sparklineA"></span>
                            </div>
                            <div class="circle-tile-number text-faded" style="font-size: 12px;">
                                Total Count :<?= $total_count; ?>
                                <span id="sparklineA"></span>
                            </div>
                            
                            <?php
                             if($investor>0 || ($fixed==0 && $club_type_id>0)){
                                $url = "user_profile#oilfield13";
                             }else if($fixed>0 && $club_type_id==0){
                                $url = "user_profile#oilfield8";
                             }else{
                                $url = "user_profile#oilfield9";
                             }
                            ?>
                            <a href="<?php echo $url; ?>" class="circle-tile-footer" onclick="window.location.href='<?php echo base_url().$url;?>';location.reload();">More Info <i class="fa fa-chevron-circle-right"></i></a>
                            <?php if($total_limit==$total_count){?>
                            <br>
                            <h4>Your limit has been exceed !!</h4>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
                <?php 
                  }
                if((($club_type_id>0 || $investor>0) && $fixed==0)||($club_type_id>0)){ ?>
                <!-- CA -->
                <div class="col-lg-4 col-sm-6">
                    <div class="circle-tile">
                        <div class="circle-tile-heading red" style="background-color: #242322;">
                            <i class="fa fa-wheelchair fa-fw fa-3x"></i>
                        </div>
                        <div class="circle-tile-content red" style="background-color: #9194a2;">
                            <div class="circle-tile-description text-faded">
                              Club Agents
                            </div>
                            <div class="circle-tile-number text-faded" style="font-size: 12px;">
                                Limit :<?= $det1['ca_limit'] ?>
                                <span id="sparklineC"></span>
                            </div>
                            <div class="circle-tile-number text-faded" style="font-size: 12px;">
                                Total Count :<?= $det1['ca_count']?>
                                <span id="sparklineC"></span>
                            </div>
                            <a href="<?php echo base_url();?>user_profile#oilfield10" class="circle-tile-footer"  onclick="window.location.href='<?php echo base_url();?>user_profile#oilfield10';location.reload();">More Info <i class="fa fa-chevron-circle-right"></i></a>
                            <?php if($det1['ca_limit']==$det1['ca_count']){?>
                            <br>
                            <h4>Your limit has been exceed !!</h4>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
                <!-- BA -->
                <div class="col-lg-4 col-sm-6">
                    <div class="circle-tile">
                        <div class="circle-tile-heading purple" style="background-color: #242322;">
                              <i class="fa fa-building fa-fw fa-3x"></i>
                        </div>
                        <div class="circle-tile-content purple" style="background-color: #9194a2;">
                            <div class="circle-tile-description text-faded">
                              Jaazzo Store
                            </div>
                            <div class="circle-tile-number text-faded" style="font-size: 12px;">
                              Limit :<?=  $det1['ba_limit'] ?>
                            </div>
                            <div class="circle-tile-number text-faded" style="font-size: 12px;">
                              Total Count :<?= $det1['ba_count'] ?>
                            </div>
                            <?php
                             if($investor>0){
                                $url2 = "user_profile#oilfield14";
                             }else{
                              $url2 = "user_profile#oilfield16";
                             }
                            ?>
                            <a href="<?php echo $url2; ?>" class="circle-tile-footer" onclick="window.location.href='<?php echo base_url().$url2;?>';location.reload();">More Info <i class="fa fa-chevron-circle-right"></i></a>
                            <?php if($det1['ba_limit']==$det1['ba_count']){?>
                            <br>
                            <h4>Your limit has been exceed !!</h4>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
                <?php 
                 }
                if($investor>0){ ?>
                <!-- BDE -->
                <div class="col-lg-4 col-sm-6">
                    <div class="circle-tile">
                        <div class="circle-tile-heading blue" style="background-color: #242322;">
                            <i class="fa fa-cogs fa-fw fa-3x"></i>
                        </div>
                        <div class="circle-tile-content blue" style="background-color: #9194a2;">
                            <div class="circle-tile-description text-faded">
                                Executives
                            </div>
                            <div class="circle-tile-number text-faded" style="font-size: 12px;">
                                Limit :<?= $det1['bde_limit']?>
                                <span id="sparklineB"></span>
                            </div>
                            <div class="circle-tile-number text-faded" style="font-size: 12px;">
                                Total Count :<?= $det1['bde_count']?>
                                <span id="sparklineB"></span>
                            </div>
                            <a href="<?php echo base_url();?>user_profile#oilfield16" class="circle-tile-footer" onclick="window.location.href='<?php echo base_url();?>user_profile#oilfield16';location.reload();">More Info <i class="fa fa-chevron-circle-right"></i></a>
                            <?php if($det1['bde_limit']==$det1['bde_count']){?>
                            <br>
                            <h4>Your limit has been exceed !!</h4>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
                <?php 
                    }                  
                }
                ?>
                <?php
                if($type=='normal_customer')
                  if($datas){
                       foreach ($wallet as $key => $wal) { 
                  ?>
                  <div class="col-md-4">
                    <div class="prflrwd_wllt">
                         <div class="hgsd"><img src="<?php echo base_url();?>assets/public/images/prfl_wlt.png"></div>
                         <div class="prfl_wltname"><?= $wal['title'];?></div>
                         <div class="prfl_wltname"><?= round_number($wal['total_value']);?></div>
                     </div>
                  </div>
                  <?php } } ?>
            </div>
          </div>
          <!--========================= tab 1 end here =============================================-->
          <div>
            <div class="row prfilebox">
              <div class="col-md-3 col-sm-4 col-xs-12 ">
                <div id="myCarousel2" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <!-- <?php  
                      foreach($user_image as $ky=> $row)
                      {
                        $cls = $ky==0 ? 'active' : '';
                    ?>
                    <div class="item <?= $cls;?>">
                     <img class="prfimanimage" src="<?php echo base_url();?>uploads/<?= $row['profile'];?>">
                    </div>
                    <?php
                       }
                    ?> -->
                  </div>
                  <img class="profleimge" src="<?php echo base_url();?>uploads/<?= $img;?>">
                  <div class="camera" style="margin:0px 140px">
                    <a class="" data-toggle="modal" data-target="#uplodimage"><i class="fa fa-camera" aria-hidden="true"></i></a>
                  </div>
                  <a class="left carousel-control" href="#myCarousel2" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel2" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                  </a>  <!-- Left and right controls -->
                </div>
              </div>
              <div class="col-md-9 col-sm-8 col-xs-12 prfilebox">
                <div class="su_prname"><?php echo  $user['name']; ?></div>
                <div class="su_prphone"><i class="fa fa-mobile prclr1" style="font-size: 27px !important" aria-hidden="true"></i> <?php echo $user['phone']; ?></div>
                <div class="su_prphone2"><i class="fa fa-whatsapp prclr2"   style="font-size: 19px !important" aria-hidden="true"></i> <?php echo $user['whatssup_no']; ?></div>
                <div class="su_whatsapp"><i class="fa fa-envelope-o prclr1"  aria-hidden="true"></i> 
                <?php echo $user['email']; ?></div>
                <div class="su_praddrs"><i class="fa fa-map-marker prclr2"  style="font-size: 23px !important" aria-hidden="true"></i>
                <?php echo $user['location']; ?></div>
                <div class="socialmediaicon" style="width: 91px;">
                  <ul>
                    <a href="<?php echo  $user['facebook_id']; ?>" target="_blank">
                    <li> <i class="fa fa-facebook" aria-hidden="true"></i></li>
                    </a> 
                    <a href="<?php echo  $user['google_plus']; ?>" target="_blank">
                    <li><i class="fa fa-google-plus" aria-hidden="true"></i></li>
                    </a>
                    <a href="<?php echo  $user['twitter']; ?>" target="_blank">
                    <li><i class="fa fa-twitter" aria-hidden="true"></i></li>
                    </a>
                  </ul>
                </div>
                <br>
                <button type="button" class="editsub " id="editsub" data-toggle="modal" data-target="#editprofile"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Info</button>
              </div>
            </div>
          </div>
          <!--========================= tab 1 end here =============================================-->
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                   EDIT PROFILE
                </h1>
                <div id="no-more-tables">
                  <form method="post" name="profile_form" id="profile_form" action="<?php echo base_url();?>Home/edit_normal_byid/<?php echo $user['id'];?>">
                    <div class="row">
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>First Name</label>
                        <input type="text" value="<?php echo  $user['name']; ?>"  placeholder="Name"   name="name"  class="form-control validate[required]" >
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Last Name</label>
                        <input type="text" value="<?php echo  $user['lastname']; ?>" name="lastname" class="form-control validate[required]" placeholder="Last Name">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Mobile No (1)</label>
                        <input type="number"  onKeyPress="return isNumberKey(event)" value="<?php echo  $user['phone']; ?>"  placeholder="Mobile No(1)"   name="phone"  class="form-control validate[required]" readonly='true'>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Mobile No (2)</label>
                        <input type="number"  onKeyPress="return isNumberKey(event)" value="<?php echo  $user['phone2']; ?>"  placeholder="Mobile No(2)"   name="phone2"  class="form-control validate[required]" >
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Whatsapp No</label>
                        <input value="<?php echo  $user['whatssup_no']; ?>" name="whatssup_no" class="form-control validate[required]" type="number"  onKeyPress="return isNumberKey(event)" placeholder="Whatsapp No">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Email</label>
                        <input type="email" value="<?php echo  $user['email']; ?>"  placeholder="Email"   name="email"  class="form-control validate[required]" data-rule-required="true" data-rule-email="true" readonly='true'>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Alternative Email</label>
                        <input type="email" value="<?php echo  $user['alt_email']; ?>" name="alt_email" class="form-control validate[required]" data-rule-email="true" placeholder="Alternate Email">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group ">
                        <label for="sel1">Select Country</label>
                        <select class="form-control sel_country" id="sel_country" name="country">
                          <?php foreach ($countries as $key => $country) { ?>
                          <option <?= $user['country']==$country['id']?"selected" : ""; ?> value="<?php echo $country['id'];?>"  ><?php echo $country['name'];?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label for="sel1">Select State</label>
                        <select class="form-control sel_state" id="sel2" name="state">
                            <?php foreach ($state as  $key => $st) { ?>
                            <option <?= $user['state']==$st['id']?"selected" : ""; ?> value="<?php echo $st['id'];?>"  ><?php echo $st['name'];?></option>
                            <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>District</label>
                        <input type="text" value="<?php echo  $user['district']; ?>"  name="district" class="form-control validate[required]" placeholder="District">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>City / Town</label>
                        <input type="text" value="<?php echo  $user['city']; ?>"  name="city" class="form-control validate[required]" placeholder="City / Town">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Location</label>
                        <input type="text" value="<?php echo  $user['location']; ?>" name="location" class="form-control validate[required]" placeholder="Location">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Area</label>
                        <input type="text" value="<?php echo  $user['area']; ?>"  name="area" class="form-control validate[required]" placeholder="Area">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Post Office</label>
                        <input type="text" value="<?php echo  $user['post_office']; ?>"  name="post_office" class="form-control validate[required]" placeholder="Post Office">
                      </div>
                      
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Road</label>
                        <input type="text" value="<?php echo  $user['road']; ?>"  name="road" class="form-control validate[required]" placeholder="Road">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Street</label>
                        <input type="text" value="<?php echo  $user['streat']; ?>"  name="streat" class="form-control validate[required]" placeholder="Street">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Apartment Name / House Name</label>
                        <input type="text" value="<?php echo  $user['house_name']; ?>" placeholder="Apartment Name / House Name" name="house_name" class="form-control validate[required]">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Apartment No / House No</label>
                        <input type="text" value="<?php echo  $user['house_no']; ?>"  name="house_no" class="form-control validate[required]" placeholder="Apartment No / House No">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Facebook</label>
                        <input type="text" value="<?php echo  $user['facebook_id']; ?>" placeholder="https://" name="facebook_id" class="form-control validate[required]">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Twitter</label>
                        <input type="text" value="<?php echo  $user['twitter']; ?>" placeholder="https://" name="twitter" class="form-control validate[required]">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Google plus</label>
                        <input type="text" value="<?php echo  $user['google_plus']; ?>" placeholder="https://" name="google_plus" class="form-control validate[required]">
                      </div>
                      <div class="clear"></div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="" id="">Update</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php if($type=='normal_customer'||$type=='club_member'||$type=='club_agent') {?>
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  My Transactions
                </h1>
                <div id="no-more-tables">
                  <div class="row">
                  <div ng-app="date">
                    <div ng-controller="dateCtrl">
                      
                      <div class="col-sm-3">
                          <input type="text" id="date" name="date" ng-model="date" class="fromdate form-control" placeholder="Select Start Date">
                      </div>
                      <div class="col-sm-3">
                           <input type="text" datepicker ng-model="date2" class="todate form-control" placeholder="Select End Date"/>
                      </div> 
                      <div class="col-sm-1">
                        <button class="btn btn-info" id="btn_search">Go</button>
                      </div>
                    </div>
                  </div>
                       
                      <div class="col-sm-3">
                          <label class="pull-right">Search:</label>
                      </div>
                      <div class="col-sm-2">
                          <input type="text" class="form-control search" name="search" id="search5" placeholder="">
                      </div>
                  </div><br>
                  <table id="example" class="col-md-12 table-bordered table-striped table-condensed cf table-fixed" width="100%">
                    <thead class="cf5">
                      <tr>
                        <th width="65px;">SI No.</th>
                        <th>Channel Partner</th>
                        <th>Purchased On</th>
                        <th>Total Bill</th>
                        <th>Rewards Gained</th>
                      </tr>
                    </thead>
                    <tbody id="tbody5" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="5">
                            <div class="pull-right" id="pagination5"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <?php 
            if((($type=='club_member') && (($club_type_id>0 || $investor>0) && $fixed==0  ))||$type=='club_agent'){
            ?>
          <div class="row">
          </div>
          <?php } ?>
          <!--========================= tab 2 end here =============================================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="prfl_trnsfr wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden">
                  <h1 class="bm_mar10">Change Your Password</h1>
                  <form name="chng_pwd" action="<?php echo base_url();?>Home/change_password" method="post" id="chng_pwd">
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Enter Old password" name="opassword" id="opassword">
                    </div>      
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Enter New password" name="npassword" id="npassword">
                    </div> 
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder=" Confirm password" name="cpassword" id="cpassword">
                    </div> 
                    <input type="hidden" value="<?php echo $lid; ?>" name="id">
                    <button class="button_submit3 btn_chang_pwd" style="width:100%"  type="submit">Save Changes</button>
                  </form>
                </div>
                <a class="desctvtbtn" data-toggle="collapse" data-target="#deactvte">  Deactivate your Account ? </a>
                <div id="deactvte" class="collapse">
                  <form name="deactivate_accunt" action="<?php echo base_url();?>Home/deactivate_account" method="post" id="deactivate_accunt">
                    <div class="col-md-4">Reason for leaving</div>
                    <div class="col-md-8">
                      <?php foreach($deactivate_reasons as $reason) {?>
                      <label class="radio-inline"><input type="radio" name="reason" value="<?php echo $reason['id']; ?>"><?php echo $reason['reason']; ?></label><br>
                      <?php } ?>
                    </div>
                    <br>
                    <div class="col-md-4">Please explain further</div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
                      </div>
                    </div>
                    <br>
                    <div class="col-md-4">Email opt out</div>
                    <div class="col-md-8">
                      <label class="checkbox-inline">
                      <input type="checkbox" value="1" name="mail_status">Opt out of receiving future emails from Jaazzo</label>
                    </div>
                    <button class="button_submit3" id="btn_deactivate" type="submit">Deactivate Account</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!--========================= tab 3 end here =============================================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
              <div class="col-sm-4 col-xs-12">
                <div class="wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden;">
                  <?php
                  if($datas){
                       foreach ($wallet as $key => $wal) { 
                  ?>
                     <div class="prflrwd_wllt">
                         <div class="hgsd"><img src="<?php echo base_url();?>assets/public/images/prfl_wlt.png"></div>
                         <div class="prfl_wltname"><?= $wal['title'];?></div>
                         <div class="prfl_wltname"><?= round_number($wal['total_value']);?></div>
                     </div>
                  <?php } } ?>
                </div>
              </div>
              <div class="col-md-8 col-sm-8 col-md-12">
                <div class="prfl_trnsfr wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden">
                  <h1 class="bm_mar10">Jaazzo Easy Transfer</h1>
                  <form name="transfer_form" method="post" id="transfer_form2" action="<?php echo base_url();?>user/Money_transfer/transfer_amount">
                    Select Your Wallet :
                    <select id="wallet_ids2" name="transfer_type" class="form-control" style="width: 95%">
                          <option value="">please select</option>
                          <?php foreach ($wallet as $key => $wal) {if($wal['wallet_type_id']!='3'){ ?>
                            <option value="<?php echo $wal['wallet_type_id'] ?>">
                              <?php echo $wal['title'] ?></option>
                            <?php } }?>
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
                    <div style="display: none" id="wallet_value2">
                      wallet amount  :
                      <input class="txt_bg3" name="wallet" id="wallet2" type="text" value="" />
                    </div>
                    <div class="logn_frrmbx">
                      Enter Mobile :  <input class="txt_bg3" name="transfer_mobile" type="number"  onKeyPress="return isNumberKey(event)" placeholder="Mobile" />
                      <br>
                      Enter Amount :  <input class="txt_bg3" id="transfer_amount2" name="transfer_amount" onKeyPress="return isNumberKey(event)" type="text" placeholder="Amount" />
                      <input type="submit" name="transfer_submit" id="transfer_submit" class="button_submit3 continue_login" value="continue">
                    </div>
                  </form>
                </div>
              </div> 
              <div class="col-md-12 col-sm-8 col-md-12">
                <div class="prfl_trnsfr wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden">
                  <h1 class="bm_mar10">Wallet Transfer Details</h1>
                  <div id="no-more-tables">
                    <div class="row">
                    <div ng-app="date2">
                    <div ng-controller="dateCtrl2">
                        <div class="col-sm-3 col-sm-3">
                          <input type="text" class="form-control" name="from" class="form-control dt_from" id="dt_from" ng-model="from">
                        </div>
                        <div class="col-sm-3 col-sm-3">
                          <input type="text" class="form-control" name="to" class="form-control dt_to" id="dt_to" ng-model="to">
                        </div>
                        <div class="col-sm-1 col-sm-3">
                            <button type="button" name="btn_serch" id="btn_serch" class="btn btn-primary">Go!</button>
                        </div>
                      </div>
                      </div>
                        <div class="col-sm-3 col-sm-3">
                            <label class="pull-right">Search:</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control search" name="search" id="search9" placeholder="">
                        </div>
                    </div><br>
                    <table id="tbl_transfer" class="col-md-12 table-bordered table-striped table-condensed cf table-fixed " width="100%">
                      <thead class="cf">
                        <tr>
                          <th width="65px;">SI No.</th>
                          <th>To</th>
                          <th>Amount</th>
                          <th>Wallet</th>
                          <th>Transfered On</th>
                        </tr>
                      </thead>
                      <tbody id="tbody9" style=" height:100px;overflow:scroll">
                          
                      </tbody>
                      <tfoot>
                          <td colspan="5">
                              <div class="pull-right" id="pagination9"></div>
                          </td>
                      </tfoot>
                    </table>
                    <br>
                    <br>
                    <br>
                    <br>
                    <table id="tbl_transfer" class="col-md-12 table-bordered table-striped table-condensed cf table-fixed " width="100%">
                      <thead class="cf">
                        <tr>
                          <th width="65px;">SI No.</th>
                          <th>From</th>
                          <th>Amount</th>
                          <th>Wallet</th>
                          <th>Transfered On</th>
                        </tr>
                      </thead>
                      <tbody id="tbody10" style=" height:100px;overflow:scroll">
                          
                      </tbody>
                      <tfoot>
                          <td colspan="5">
                              <div class="pull-right" id="pagination10"></div>
                          </td>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>            
            </div>  
          </div>
          <!--========================= tab 4 end here =============================================-->
          <?php if((($type=='club_member') && (($club_type_id>0 || $investor>0) && $fixed==0  ))||$type=='club_agent') {?>
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                    Active <?php echo($type=='club_agent')?'Members':'Friends'?>
                </h1>
                <div id="no-more-tables">
                  <div class="row">
                      <div class="col-sm-offset-7 col-sm-3">
                          <label class="pull-right">Search:</label>
                      </div>
                      <div class="col-sm-2">
                          <input type="text" class="form-control search" name="search" id="search1" placeholder="">
                      </div>
                  </div><br>
                  <table id="example" class="col-md-12 table-bordered table-striped table-condensed cf table-fixed" width="100%">
                    <thead class="cf">
                      <tr>
                        <th width="65px;">Sn No.</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th class="numeric">Image</th>
                        <th class="numeric">Location</th>
                        <th class="numeric">Status</th>
                      </tr>
                    </thead>
                    <tbody id="tbody1" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="6">
                            <div class="pull-right" id="pagination1"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--========================= tab 5 end here =============================================-->
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  All Referred <?php echo($type=='club_agent')?'Members':'Friends'?>
                </h1>
                <div id="no-more-tables2">
                  <div class="row">
                      <div class="col-sm-offset-7 col-sm-3">
                          <label class="pull-right">Search:</label>
                      </div>
                      <div class="col-sm-2">
                          <input type="text" class="form-control search" name="search" id="search2" placeholder="">
                      </div>
                  </div><br>
                  <table class="col-md-12 table-bordered table-striped table-condensed cf">
                    <thead class="cf">
                      <tr>
                        <th width="65px;">SI No.</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th class="">Location</th>
                        <th width="200px">Action</th>
                      </tr>
                    </thead>
                    <tbody id="tbody2" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="5">
                            <div class="pull-right" id="pagination2"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>         
            </div>  
          </div>
          <!--========================= tab 6 end here =============================================-->
          <?php

            if(($type=='club_member') && (($club_type_id>0 || $investor>0) || $fixed==0))
            {
          ?>
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  All Club Agents
                </h1>
                <div id="no-more-tables2">
                  <div class="row">
                      <div class="col-sm-offset-7 col-sm-3">
                          <label class="pull-right">Search:</label>
                      </div>
                      <div class="col-sm-2">
                          <input type="text" class="form-control search" name="search" id="search4" placeholder="">
                      </div>
                  </div><br>
                  <table class="col-md-12 table-bordered table-striped table-condensed cf">
                    <thead class="cf">
                      <tr>
                        <th width="65px;">SI No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>Docs</th>
                        <th>Status</th>
                        <th width="200px">Action</th>
                      </tr>
                    </thead>

                    <tbody id="tbody4" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="7">
                            <div class="pull-right" id="pagination4"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>         
            </div>  
          </div>
          <?php 
            }
          } 
          //checking
          if($datas){
              $lid = $datas['login_id'];
              $userid = $datas['user_id'];
              $udetail = get_details_by_userid($userid);
              $dateString=$udetail['created_on'];
              $fixed_joind=$udetail['fixed_join_date'];
              $years = round((time()-strtotime($dateString))/(3600*24*365.25));
              $fix_years = round((time()-strtotime($fixed_joind))/(3600*24*365.25));
            }
            $det = get_cmfacility_by_id($lid);
            if($type=='club_member'){  
              $year_limit =  $det['year_limit'];
              $ul_cp_status = $det['cp_status'];
            }
            if($fixed>0){
              $fixed_plan = $udetail['fixed_club_type_id'];
              $fixed_details = getClubtypeById($fixed_plan);
              $fixed_amnt = $fixed_details['amount'];
              $ref_cp_status = $fixed_details['ref_cp_status'];
              $cp_status = $fixed_details['cp_status'];
                
              $reward_per_cp = $fixed_details['reward_per_cp'];
              $reward_per_refer_cp = $fixed_details['ref_reward_per_cp'];
               
              $fixed_wallet_used = get_wallet_used_by_member($lid,5);
              $fixed_wallet_details = get_fixed_wallet_details($lid);

              $expected_total1 = $fixed_wallet_details +$reward_per_refer_cp +$fixed_wallet_used;
              $expected_total2 = $fixed_wallet_details +$reward_per_cp +$fixed_wallet_used;
              $exp1 = $fixed_wallet_details+$fixed_wallet_used;
              $fix_year_exceed = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($fixed_joind)));

              $allow1 = '';
              if($exp1<$fixed_amnt){
                $allow1 = 1 ;
              }
            }
           // if(($type=='club_member') &&  (($investor==0) || (($fixed>0) && (($expected_total1<=$fixed_amnt)|| isset($allow1))) || ($club_type_id>0))){ 
              if(($type=='club_member') &&  ((($fixed>0) && ($ref_cp_status==1) && (date('Y-m-d H:i:s')<=$fix_year_exceed) && (($expected_total1<=$fixed_amnt)|| ($allow1==1))) || (($club_type_id>0) && ($ul_cp_status==1) &&($year_limit>=$years)) || (($year_limit>=$years)&&($investor>0)&& ($ul_cp_status==1)))){ 
                $year_limit =  $det['year_limit'];
                if($datas['fixed_club_type_id']>0){
                    $fixed_year_limit =  $det['fixed_year_limit'];
                }else{
                  $fixed_year_limit =0;
                }
            ?> 
          <!--========================= tab 7 end here =============================================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
              <div class="prfl_trnsfr wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden">
                <h1 class="bm_mar10">Refer Channel Partner</h1>
                <form name="refer_cp" action="<?php echo base_url();?>user/Profile/refer_channel_partner" method="post" id="refer_cp">
                  <div class="col-md-6">
                    <label>Club Type</label> <label style="color:red;">(Mandatory)</label>
                    <div class="form-group">
                      <select name="club_type" class="form-control" id="club_type" data-rule-required="true">
                      <option value="">Please Select</option>
                      <?php 
                        if($session_array2['fixed_club_type_id']){
                          if(($fixed>0) &&  (date('Y-m-d H:i:s')<=$fix_year_exceed) && (($expected_total1<=$fixed_amnt)||isset($allow1))){
                      ?>
                        <option value="FIXED">Fixed</option>
                      <?php 
                          }
                        } if($session_array2['investor_type_id']){?>
                        <option value="INVESTOR" selected="selected">Team Lead Club</option>
                        <?php }if($session_array2['club_type_id']){ ?>
                        <option value="UNLIMITED">Unlimited</option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label>Name of the Channel Partner</label> <label style="color:red;">(Mandatory)</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Name of the Organization" name="name" id="name">
                    </div>     
                  </div>

                  <div class="col-md-6">
                    <label>Email</label> 
                    <div class="form-group">
                      <input type="email" class="form-control" placeholder="Email" name="email" id="cp_email">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Contact No</label> <label style="color:red;">(Mandatory)</label>
                    <div class="form-group">
                      <input type="number" onKeyPress="return isNumberKey(event)" class="form-control" placeholder="Contact" name="phone" id="cp_contact">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Owner</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Owner" name="oc_name" id="oc_name">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Owner Mobile</label> 
                    <div class="form-group">
                      <input type="number" onKeyPress="return isNumberKey(event)" class="form-control" placeholder="Owner Mobile" name="oc_mobile" id="oc_mobile">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Owner Email</label>
                    <div class="form-group">
                      <input type="email" class="form-control" placeholder="Owner Email" name="oc_email" id="oc_email">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Address</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Address" name="address" id="address">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Area</label> 
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Area" name="area" id="area">
                    </div>     
                  </div>
                  <div class="col-md-offset-5 col-md-3">
                    <button class="button_submit3 btn_add" type="submit" style="width: 70%;">Save </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!--========================= tab 8 end here =============================================-->
          <?php 
            }
            
            //echo json_encode(get_cmfacility_by_id($lid));
            if($type=='club_member'){  
             if((($year_limit>=$years) && ($investor>0)&& ($ul_cp_status==1))||(($year_limit>=$years)&&($club_type_id>0)&& ($ul_cp_status==1)) || (($fixed>0) && ($cp_status==1) && (date('Y-m-d H:i:s')<=$fix_year_exceed)&& (($expected_total2<=$fixed_amnt)|| ($allow1==1)))){
             //if((($year_limit>=$years)&&($det['cp_limit']>$det['cp_count'])) || ((($fixed_year_limit>=$fix_years))&&($det['fixed_cp_limit']>$det['fixed_cp_count']) && (($expected_total2<=$fixed_amnt)||isset($allow1)))){
          ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
                <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>new_partner" enctype="multipart/form-data">
                  <div class="col-md-12 wlletbg_prfile">
                    <div class="row">

                      <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                          <h4>Channel Details</h4>
                          <hr>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                        <label>Club Type</label> <label style="color:red;">(Mandatory)</label>



                        <select name="club_type" class="form-control" id="club_type" data-rule-required="true">
                        <option value="">Please Select</option>
                        <?php
                         if($session_array2['fixed_club_type_id']){
                            if(($fixed>0)&& (date('Y-m-d H:i:s')<=$fix_year_exceed) && (($expected_total2<$fixed_amnt)||isset($allow1))){
                        ?>
                        <option value="FIXED">Fixed</option>
                        <?php } } if($session_array2['investor_type_id']){?>
                        <option value="INVESTOR" selected="selected">Team Lead Club</option>
                        <?php } if($session_array2['club_type_id']){  ?>
                        <option value="UNLIMITED">Unlimited</option>
                        <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group man">



                        <label>Module</label> <label style="color:red;">(Mandatory)</label>



                        <select name="module" class="form-control search-box-open-up search-box" id="module" data-rule-required="true">
                        <option value="">Please Select</option>
                        <?php foreach ($modules['type'] as $type) { ?>
                        <option value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
                        <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group man">



                          <label>Channel Partner Type</label> <label style="color:red;">(Mandatory)</label>



                          <select id="channel_type" class="form-control search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" data-rule-required="true">
                              <?php foreach($category['type'] as $type){ ?>
                              
                              <!-- <option value="<?php echo $type['id'];?>"><?php echo $type['title'];?></option> -->
                              <optgroup label="<?php echo $type['title'];?>">
                              <?php $pid=$type['id']; foreach($subcategory['type'] as $stype){ if($stype['parent']==$pid){ ?>

                              <option class="subc" value="<?php echo $stype['id'];?>"><?php echo $stype['title'];?></option>
                              
                              <?php } ?> </optgroup> <?php } } ?>
                            </select>
                         
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                          <label>Channel Name (Company/Institution/Shop)</label> <label style="color:red;">(Mandatory)</label>



                          <input type="text" placeholder="Name of the Organization" name="name" class="form-control" data-rule-required="true">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                          <label>Email(Username)</label> <label style="color:red;">(Mandatory)</label>



                          <input type="text" placeholder="Email" name="email" class="form-control email" id="ch_email" data-rule-required="true" data-rule-email="true">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                        <label>Contact No</label> <label style="color:red;">(Mandatory)</label>



                        <input type="number" placeholder="Phone" name="phone" id="ch_phone" class="form-control" data-rule-required="true" data-rule-number="true" onKeyPress="return isNumberKey(event)">
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                          <h4>Contact Details</h4>
                          <hr>
                      </div>
                      
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                          <label>Owner Contact Person</label> <label style="color:red;">(Mandatory)</label>



                          <input type="text" placeholder="Owner Name" name="ocname" class="form-control" data-rule-required="true">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                          <label>Owner Contact Email</label> <label style="color:red;">(Mandatory)</label>



                          <input type="text" placeholder="Owner Email" name="oc_email" class="form-control oc_email" id="oc_email" data-rule-required="true"  data-rule-email="true" placeholder="Contact Email">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                          <label>Owner Contact Mobile</label> <label style="color:red;">(Mandatory)</label>



                          <input type="number" onKeyPress="return isNumberKey(event)" placeholder="Owner Mobile" name="oc_mobile" data-rule-required="true" class="form-control oc_mobile" id="oc_mobile" data-rule-number="true"  placeholder="Contact Mobile">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group man">



                          <label>Country</label> <label style="color:red;">(Mandatory)</label>



                          <select name="country" class="form-control search-box-open-up search-box-sel-all" id="ch_country" data-rule-required="true">
                          <option value="">Please Select</option>
                          <?php foreach ($countries as $key => $country) { ?>
                          <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                          <?php } ?>
                          </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group man">



                          <label>State</label> <label style="color:red;">(Mandatory)</label>



                          <select name="state" class="form-control sel_state select_box_sel" id="ch_state" data-rule-required="true">
                           <option value="">Please Select</option>                                       
                          </select>
                      </div>

                      <div class="col-md-4 col-sm-6 col-xs-12 form-group ">



                          <label>City</label> <label style="color:red;">(Mandatory)</label>
                          <!-- <input type="text" placeholder="Town" name="town" class="form-control" id="town" data-rule-required="true"> -->
                          <select name="town" class="form-control town" id="town" >
                              <option value="">Please Select</option>
                          </select>
                      </div>









                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                          <label>Area</label> <label style="color:red;">(Mandatory)</label>



                          <input type="text" placeholder="Area" name="area" class="form-control" data-rule-required="true">
                      </div>














                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5>Map Locator (Please choose channel location)</h5>
                        </div>





                      
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">



                          <label>Latitude*</label> <label style="color:red;">(Mandatory)</label>



                          <input type="text" placeholder="Latitude" id="lat" name="latt" class="form-control" data-rule-required="true">
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">



                          <label>Longitude*</label> <label style="color:red;">(Mandatory)</label>



                          <input type="text" placeholder="Longitude" id="long" name="long" class="form-control" data-rule-required="true">
                      </div>

                      <div class="col-md-12" style="margin-top: 15px">
                      <?php echo $map['html']; ?>
                      <br>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                          <h4>Verification Details</h4>
                          <hr>
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">



                          <label>PAN Number</label> <label style="color:red;">(Mandatory)</label>



                          <input type="text" placeholder="PAN Number" id="pan" name="pan" class="form-control" data-rule-required="true">
                      </div>
                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                          <label>GST Number</label>
                          <input type="text" placeholder="GST Number" id="gst" name="gst" class="form-control">
                      </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 main">
                          <label>Company Registration Document</label>
                          <div class="input-group">
                            <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  Browse&hellip; <input type="file" name="company_registration"  id="company_registration" style="display: none;" >
                              </span>
                            </label>
                            
                            
                             <input type="text" class="form-control" readonly>
                            
                           
                          </div>
                      </div>
                      
                    </div>
                    <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12 main">
                        <label>Corporation/Panchayath/Muncipality License</label>
                        <div class="input-group ">
                          <label class="input-group-btn">
                            <span class="btn btn-primary">
                                Browse&hellip; <input type="file" name="license" id="license"  style="display: none;">
                            </span>
                          </label>
                          
                          
                          <input type="text" class="form-control" readonly>
                          
                          
                         
                        </div>
                      </div>
                    </div>     
                    <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                        
                        <div id="agree1" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">X</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel">
                                                <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="color:#000">
                                                    <h4 class="panel-title">Collapsible Group Items #1</h4>
                                                </a>
                                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>Username</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <td>Mark</td>
                                                                <td>Otto</td>
                                                                <td>@mdo</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">2</th>
                                                                <td>Jacob</td>
                                                                <td>Thornton</td>
                                                                <td>@fat</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">3</th>
                                                                <td>Larry</td>
                                                                <td>the Bird</td>
                                                                <td>@twitter</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  style="color:#000">
                                                    <h4 class="panel-title">Collapsible Group Items #2</h4>
                                                </a>
                                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <p><strong>Collapsible Item 2 data</strong>
                                                        </p>
                                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"  style="color:#000">
                                                    <h4 class="panel-title">Collapsible Group Items #3</h4>
                                                </a>
                                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <p><strong>Collapsible Item 3 data</strong>
                                                        </p>
                                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary antosubmit">Agree</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                       <!--  <button type="button" class="btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit">Save</button> -->
                        <input type="submit" class="btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit" value="Save">
                    </div>
                  </div>
              </form>
            </div>  
          </div>
          <?php }  ?>
          <!--========================= tab 9 end here =============================================-->
          <?php 
          if((($investor>0)&& ($ul_cp_status==1))||
              (($club_type_id>0)&& ($ul_cp_status==1)) || 
              (($fixed>0) && ($cp_status==1))){
          ?>
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  All Channel Partners
                </h1>
                <div id="no-more-tables2">
                  <div class="row">
                    <div class="col-sm-offset-7 col-sm-3">
                        <label class="pull-right">Search:</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control search" name="search" id="search3" placeholder="">
                    </div>
                  </div><br>
                  <table class="col-md-12 table-bordered table-condensed cf">
                    <thead class="cf">
                      
                      <tr>
                        <th width="65px;">Sl No.</th>
                        <th>Name</th>
                        
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>PAN No</th>
                        <th>Owner</th>
                        <th>Status</th>
                        <th width="200px">Action</th>
                      </tr>
                    </thead>
                    <tbody id="tbody3" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="8">
                            <div class="pull-right" id="pagination3"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>         
            </div>  
          </div>
          <?php } ?>
          <!--========================= tab 10 end here =============================================-->
          <?php 
            if(($year_limit>=$years)&&($det['ba_limit']>$det['ba_count'])){
          ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
              <div class="prfl_trnsfr wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden">
                <h1 class="bm_mar10">Add Jaazzo Store</h1>
                <form name="add_ba" action="<?php echo base_url();?>user/Profile/add_ba" method="post" id="add_ba">
                  <div class="col-md-6">
                    <label>Name</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Name" name="name" id="name">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Contact No</label>
                    <div class="form-group">
                      <input type="number" onKeyPress="return isNumberKey(event)" class="form-control" placeholder="Contact" name="phone" id="contact">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Email</label>
                    <div class="form-group">
                      <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Company Name</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Company Person" name="c_name" id="contact_person">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Company Mobile</label>
                    <div class="form-group">
                      <input type="number" onKeyPress="return isNumberKey(event)" class="form-control" placeholder="Company Mobile" name="c_mobile" id="contact_mobile">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Company Email</label>
                    <div class="form-group">
                      <input type="email" class="form-control" placeholder="Company Email" name="c_email" id="contact_email">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Country</label>
                    <div class="form-group">
                      <select name="country" id="ba_country" class="form-control  sel_country select_box_sel"  data-rule-required="true" >
                        <option value="">Please Select</option>
                        <?php foreach ($countries as $key => $country) { ?>
                        <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                        <?php  } ?>
                    </select>
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>State</label>
                    <div class="form-group">
                      <select name="state" id="ba_states" class="form-control sel_state select_box_sel "  data-rule-required="true">
                                                
                      </select>
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>City / Town</label>
                    <div class="form-group">
                      <select name="city" id="ba_city" class="form-control"  data-rule-required="true">

                      </select>
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Address</label>
                    <div class="form-group">
                      <textarea class="form-control" name="address"></textarea>
                    </div>     
                  </div>
                  <div class="col-md-offset-5 col-md-3">
                    <button class="button_submit3 btn_add" type="submit" style="width: 70%;">Save </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!--========================= tab 11 end here =============================================-->
          <?php
            }
            if($club_type_id>0||$investor>0){
              if($club_type_id>0){
          ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
              <div class="prfl_trnsfr wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden">
                <h1 class="bm_mar10">Refer Jaazzo Store</h1>
                <form name="refer_ba" action="<?php echo base_url();?>user/Profile/refer_ba" method="post" id="refer_ba">
                  <div class="col-md-6">
                    <label>Name</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Name" name="name" id="name">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Contact No</label>
                    <div class="form-group">
                      <input type="number" onKeyPress="return isNumberKey(event)" class="form-control" placeholder="Contact" name="phone" id="contact">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Email</label>
                    <div class="form-group">
                      <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                    </div>     
                  </div>
                  
                  <div class="col-md-offset-5 col-md-3">
                    <button class="button_submit3 btn_add" type="submit" style="width: 70%;">Save </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php } ?>
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  All Jaazzo Stores
                </h1>
                <div id="no-more-tables2">
                  <div class="row">
                    <div class="col-sm-offset-7 col-sm-3">
                        <label class="pull-right">Search:</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control search" name="search" id="search6" placeholder="">
                    </div>
                  </div><br>
                  <table class="col-md-12 table-bordered table-condensed ">
                    <thead>
                      <tr>
                        <th width="65px;">SI No.</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Company Name</th>
                        <th>Company Contact No</th>
                        <th>Company Email</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="tbody6" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="8">
                            <div class="pull-right" id="pagination6"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>         
            </div>  
          </div>
          <?php }
             if(($year_limit>=$years)&&($investor>0) && $det['bde_limit']>$det['bde_count']){
          ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
              <div class="prfl_trnsfr wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden">
                <h1 class="bm_mar10">Add Business Executive</h1>
                <form name="add_bde" action="<?php echo base_url();?>user/Profile/add_bde" method="post" id="add_bde">
                  <div class="col-md-6">
                    <label>Name</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Name" name="name" id="name">
                    </div>     
                  </div>
                  <?php $desigs = getDesignations();?>
                  <div class="col-md-6">
                    <label>Designation</label>
                    <div class="form-group">
                      <select class="form-control" name="designation">
                      <option>Select Any</option>
                        <?php foreach($desigs as $key=>$dsg) { if($dsg['slug']=='bde'){?>
                        <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option>
                        <?php }}?>
                      </select>
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Contact No</label>
                    <div class="form-group">
                      <input type="number" onKeyPress="return isNumberKey(event)" class="form-control" placeholder="Contact" name="phone" id="contact">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Email</label>
                    <div class="form-group">
                      <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Country</label>
                    <div class="form-group">
                      <select name="country" id="bde_country" class="form-control  sel_country select_box_sel"  data-rule-required="true" >
                        <option value="">Please Select</option>
                        <?php foreach ($countries as $key => $country) { ?>
                        <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                        <?php  } ?>
                    </select>
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>State</label>
                    <div class="form-group">
                      <select name="state" id="bde_states" class="form-control sel_state select_box_sel "  data-rule-required="true">
                                                
                      </select>
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>City / Town</label>
                    <div class="form-group">
                      <select name="city" id="bde_city" class="form-control"  data-rule-required="true">

                      </select>
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Address</label>
                    <div class="form-group">
                    <textarea class="form-control" name="address" id="address"></textarea>
                    </div>     
                  </div>
                  
                  <div class="col-md-offset-5 col-md-3">
                    <button class="button_submit3 btn_add" type="submit" style="width: 70%;">Save </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php
              }
              if($investor>0){
          ?>
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  All Business Executives
                </h1>
                <div id="no-more-tables2">
                  <div class="row">
                    <div class="col-sm-offset-7 col-sm-3">
                        <label class="pull-right">Search:</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control search" name="search" id="search7" placeholder="">
                    </div>
                  </div><br>
                  <table class="col-md-12 table-bordered table-condensed ">
                    <thead>
                      <tr>
                        <th width="65px;">SI No.</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="tbody7" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="6">
                            <div class="pull-right" id="pagination7"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>         
            </div>  
          </div>
          <?php
              } 
            }
            if(($datas['type']=='club_member')||($datas['type']=='club_agent'))
            {
          ?>
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  Notifications
                </h1>
                <div id="no-more-tables2">
                  <div class="row">
                    <div class="col-sm-offset-7 col-sm-3">
                        <label class="pull-right">Search:</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control search" name="search" id="search8" placeholder="">
                    </div>
                  </div><br>
                  <table class="col-md-12 table-bordered table-condensed ">
                    <thead>
                      <tr>
                        <th width="65px;">SI No.</th>
                        <th>Notification From</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody id="tbody8" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="6">
                            <div class="pull-right" id="pagination8"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>         
            </div>  
          </div>
          <?php
            }
          ?>
        </div>
      </div>
    </div>
  </section>
</section>
</div>
<?php echo $footer; ?>
<div id="editprofile" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content editprfl">
      <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal">X</button>
        <h4 class="modal-title">EDIT PROFILE</h4>
      </div>
      <form method="post" name="profile_form" id="edit_profile_form" action="<?php echo base_url();?>Home/edit_profile_byid/<?php echo $user['id'];?>">
        <div class="modal-body" style="overflow-x:auto">
            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
              <label>First Name</label>
              <input type="text" value="<?php echo  $user['name']; ?>"  placeholder="Name"   name="name"  class="form-control validate[required]" >
            </div>
            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
              <label>Last Name</label>
              <input type="text" value="<?php echo  $user['lastname']; ?>" name="lastname" class="form-control validate[required]">
            </div>
            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
              <label>Location</label>
              <input type="text" value="<?php echo  $user['location']; ?>" name="location" class="form-control validate[required]">
            </div>
        </div>
        <div class="clear"></div>
        <div class="modal-footer">
          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="" id="">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Update refered friend details -->
<div id="addfrend_dtils" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">X</button>
        <h4 class="modal-title">Update Details</h4>
      </div>
      <form name="update_frnd_details" id="update_frnd_details" action="<?php echo base_url();?>user/Refer/update_refer" method="post">
      <div class="modal-body">
        <div class="prfl_trnsfr wlletbg_prfile tp_mar20 " style="overflow:hidden">
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" value="" name="name" id="name">
              <input type="hidden" name="row_id" id="row_id" value="">
            </div>      
            <div class="form-group">
              <label>Mobile Number</label>
              <input type="text"  name="mobile" class="form-control" value="" id="mobile">
            </div> 
            <div class="form-group">
              <label>Location</label>
              <input type="text" class="form-control" placeholder="Enter Your Location" name="location" id="location" value="">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <input class="button_submit3" data-toggle="modal" data-target="#success" type="submit" value="Upadate">
      </div>
      </form>
    </div>
  </div>
</div>

<script src="<?php echo base_url();?>assets/public/js/easyResponsiveTabs.js"></script> 
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script src="<?php echo base_url();?>assets/public/custom_js/datatable.js"></script>
<script>
  $('#oilfield').easyResponsiveTabs({
    type: 'vertical'
  });
</script> 
<!--=======================================slider right==============================================--> 
<script>
  $(function() {
    $(document).on('change', ':file', function() {
      var input = $(this),
          numFiles = input.get(0).files ? input.get(0).files.length : 1,
          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', [numFiles, label]);
    });
    $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;
        if( input.length ) {
          input.val(log);
        } else {
          if( log ); //alert(log);
        }
      });
      //Add
      
     
    });
  });
</script>



<script language="javascript" type="text/javascript">
  $(function () {
    $("#fileupload").change(function () {
      if (typeof (FileReader) != "undefined") {
        var dvPreview = $("#dvPreview");
        dvPreview.html("");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        $($(this)[0].files).each(function () {
          var file = $(this);
          if (regex.test(file[0].name.toLowerCase())) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  var img = $("<img />");
                  img.attr("style", "height:100px;width: 100px");
                  img.attr("src", e.target.result);
                  dvPreview.append(img);
              }
              reader.readAsDataURL(file[0]);
          } else {
              alert(file[0].name + " is not a valid image file.");
              dvPreview.html("");
              return false;
          }
        });
      } else {
          alert("This browser does not support HTML5 FileReader.");
      }
    });
  });
  $(document).ready(function () {
    var w = jQuery("#profile_form").validate({
      submitHandler: function(datas) {
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            dataType : "json",
            success  :    function(data)
            {
              $('.body_blur').hide();
              if(data.status){
                swal("Success!", "Profile updated successfully", "success");
                window.location = "<?php echo base_url();?>Home/profile";
              } else {
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                swal("Warning!", result, "error");
              }
            }
        });
      }
    });
    var v = jQuery("#channel_form").validate({
      submitHandler: function(datas) {
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            dataType : "json",
            success  :    function(data)
            {
              $('.body_blur').hide();
                if(data.status)
                {
                    swal("Success!", "Channel Partner added successfully", "success",{timer: 1500});
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
                else
                {
                  var regex = /(<([^>]+)>)/ig;
                  var body = data.reason;
                  var result = body.replace(regex, "");
                  swal("Warning!", result, "error");
                }
            }
        });
      }
    });

    $('#ch_email').focusout(function(){
      var cur = $(this);
      var mail = cur.val();

      $.post('<?php echo base_url();?>user/Profile/ch_mail_exists/',{mail :mail},function(data)
      {
        if(data.status)
        {
            var regex = /(<([^>]+)>)/ig;
            var body = "Mail Id Already Exists";
            var result = body.replace(regex, "");
            swal("Warning!", result, "error");
            cur.val("");
        }else{
        }
      },'json');
    });
    $('#ch_phone').focusout(function(){
      var cur = $(this);
      var mob = cur.val();
      $.post('<?php echo base_url();?>user/Profile/ch_mobile_exists/',{mob :mob},function(data)
      {
        if(data.status)
        {
          var regex = /(<([^>]+)>)/ig;
          var body = "Mobile Number Already Exists";
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
          cur.val("");
        }else{
        }
      },'json');
    });
  });
  $(document).ready(function () {
    $('#module').SumoSelect();
    $('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,triggerChangeCombined: false});
    $('#ch_country').SumoSelect({search: true, placeholder: 'select country'});
    $('#ch_state').SumoSelect({search: true, placeholder: 'select state'});
    $('#town').SumoSelect({search: true, placeholder: 'select city'});
  });
  $(document).ready(function() {
    //set initial state.
    $('#textbox1').val($(this).is(':checked'));

    $('#checkbox1').change(function() {
      $('#textbox1').val($(this).is(':checked'));
    });

    $('#checkbox1').click(function() {
      if ($(this).is(':checked')) {
       // return confirm("Are you sure?");
        var box= confirm("Are you sure you want to do this?");
        if (box==true)
            return true;
        else
             document.getElementById('checkbox1').checked = true;
      }
    });
  /*   $('.btnOk').on('click', function () {
        //debugger;
        var obj = [],
        items = '';
            $('.channel_type option:selected').each(function (i) {
              obj.push($(this).val());
            });
            $.post('<?php echo base_url();?>Home/get_all_cptypes/',{obj :obj},
            function(data)
            {
                console.log(data);
                if(data.status)
                {
                    var data = data.data;
                    var commissiongroup = "";
                    for (var i = 0 ; i < data.length ; i++) {
                      commissiongroup += '<div class="col-md-12"><div class="col-md-6"><input type="text" name="category[]" class="form-control category" value="'+data[i].title+'"></div><div class="col-md-6"><input type="text" name="commission[]" class="form-control commission"></div></div>';
                    }
                   
                    $('.commissiongroup').html(commissiongroup);
                }else{
                }
            },'json');
    });*/
  });
  $(document).ready(function() {
    $(".gototop").click(function() {
        $("html, body").animate({"scrollTop": "0px"});
    });
  });
  $(document).ready(function() {
    /*$('#profile_form').ajaxForm({
      dataType:  'json',
      success:   function(data){
        if(data.status){
            swal("Success!", "Profile updated successfully", "success");
            window.location = "<?php echo base_url();?>Home/profile";
        } else {
           var regex = /(<([^>]+)>)/ig;
            var body = data.reason;
            var result = body.replace(regex, "");
            swal("Warning!", result, "error");
        }
      }
    });*/
    $('#edit_profile_form').ajaxForm({
      dataType:  'json',
      success:   function(data){
        if(data.status){
            swal("Success!", "Profile updated successfully", "success");
            window.location = "<?php echo base_url();?>Home/profile";
        } else {
           var regex = /(<([^>]+)>)/ig;
            var body = data.reason;
            var result = body.replace(regex, "");
            swal("Warning!", result, "error");
        }
      }
    }); 
  });
  $(document).on('change', '#ch_country',function(){
    var cur = $(this);
    var country = cur.val();
    if(country!=''){
      $('.body_blur').show();
      $('#ch_state')[0].sumo.unload();
      $.post('<?php echo base_url();?>Register/get_state_by_id/'+country, function(data){
        $('.body_blur').hide();
        if(data.status)
        {
          var data = data.data;
          var option ='';
          option += '<option value="">Please Select</option>';
          for(var i=0; i<data.length; i++){
              option += '<option   value="'+data[i].id+'">'+data[i].name+'</option>';
          }
          $('#ch_state').html(option);
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
        $('#ch_state').SumoSelect({search: true, placeholder: 'select state'});
      },'json');
    }else{
      var count = $('#ch_state option').length;
      for(var i = 0; i < count; i++) {
          $('#ch_state')[0].sumo.remove(0);    
      }
      $('#ch_state').html('<option value="">Please Select</option>');
      $('#ch_state').SumoSelect({search: true, placeholder: 'select city'});

      var count1 = $('#town option').length;
      for(var j = 0; j < count1; j++) {
          $('#town')[0].sumo.remove(0);    
      }
      $('#town').html('<option value="">Please Select</option>');
      $('#town').SumoSelect({search: true, placeholder: 'select city'});
    }
  });
  $(document).on('change', '#ch_state',function(){
      var cur = $(this);
      var state = cur.val();
      if(state!=''){
        $('.body_blur').show(); 
        $('#town')[0].sumo.unload();
        $.post('<?php echo base_url();?>Register/get_city_by_id/'+state, function(data){
            $('.body_blur').hide();
            if(data.status)
            {
                var data = data.data;
                var option ='';
                option += '<option value="">Please Select</option>';
                for(var i=0; i<data.length; i++){
                    option += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }
                console.log(option);
                $('.town').html(option);
            } else{
                
            }
            $('#town').SumoSelect({search: true, placeholder: 'select state'});
        },'json');
      }else{
        var count1 = $('#town option').length;
        for(var j = 0; j < count1; j++) {
            $('#town')[0].sumo.remove(0);    
        }
        $('#town').html('<option value="">Please Select</option>');
        $('#town').SumoSelect({search: true, placeholder: 'select city'});
      }
  });
  $('#cp_email').focusout(function(){
      var cur = $(this);
      var mail = cur.val();

      $.post('<?php echo base_url();?>user/Profile/ch_mail_exists/',{mail :mail},function(data)
      {
        if(data.status)
        {
            var regex = /(<([^>]+)>)/ig;
            var body = "Mail Id Already Exists";
            var result = body.replace(regex, "");
            swal("Warning!", result, "error");
            cur.val("");
        }else{
        }
      },'json');
  });
  $('#cp_contact').focusout(function(){
    var cur = $(this);
    var mob = cur.val();
    $.post('<?php echo base_url();?>user/Profile/ch_mobile_exists/',{mob :mob},function(data)
    {
      if(data.status)
      {
        var regex = /(<([^>]+)>)/ig;
        var body = "Mobile Number Already Exists";
        var result = body.replace(regex, "");
        swal("Warning!", result, "error");
        cur.val("");
      }else{
      }
    },'json');
  });
  //Change Password Start
  $(document).ready(function(){
      var chng_pwd = $("#chng_pwd").validate({
        rules: {
          opassword: {
              required: true
          },
          npassword: {
              required: true,
              minlength: 6
          },
          cpassword: {
              required: true,
              minlength: 6,
              equalTo: "#npassword"
          }
        },
        errorElement: "label",
        errorClass: "error",
        messages: {
          opassword: "Enter Old Password",
          npassword: {
              required: "Enter a New Password",
              minlength: jQuery.format("Enter at least {0} characters")
          },
          cpassword: {
              required: "Enter Confirm Password",
              minlength: jQuery.format("Enter at least {0} characters"),
              equalTo: "Please enter the same password as above"
          }
        }
      });
      var datas17 = { 
        dataType : "json",
        success:   function(data){
          $('.body_blur').hide();
          if(data.status){
            swal("Success!", "Password changed successfully", "success",{timer: 500});
           setTimeout(function(){
              window.location.href="<?php echo base_url();?>Home/profile",true;
            }, 500);
          } else{
            
            swal("Warning!", common(data.reason), "error");
          }
        }
      };
      $('#chng_pwd').submit(function(e){     
        e.preventDefault();
        if (chng_pwd.form()) 
        {
          $('.body_blur').show();
          $(this).ajaxSubmit(datas17);  
        }          
      });
  });

  //Refered Friends Actions
  //delete
  $(document).on('click', '.del_refer_frnd', function () {
      var row_id = $(this).data('id');
      var cur = $(this);
      $.ajax({
          url:"<?php echo base_url(); ?>user/Refer/delete_refer",
          method:"POST",
          data:{row_id:row_id},
          success:function (data)
          {
              swal("Success!", "Referred Member Deleted Successfully.", "success",{timer: 1500});
              setTimeout(function(){
                  location.reload();
              }, 1500);
            
          }
      });
  });
  //update refer friend  Start
  $(document).on('click', '#update_frend_dtils', function () {
    var cur = $(this);
    var row_id = cur.data('id');
    var nam = cur.parent().parent().find('.nam').html();
    var mob = cur.parent().parent().find('.mob').html();
    var loc = cur.parent().parent().find('.loc').html();
    $('#addfrend_dtils').modal('show');
    $('#update_frnd_details').find('#name').val(nam);
    $('#update_frnd_details').find('#mobile').val(mob);
    $('#update_frnd_details').find('#location').val(loc);
    $('#update_frnd_details').find('#row_id').val(row_id);
    var up_form = '<?= base_url();?>user/Refer/update_refer';
    $("#update_frnd_details").attr("action", up_form);
  });
  var update_frnd_details = jQuery("#update_frnd_details").validate({
      rules: {
        mobile: {
            required: true
        }
      },
      messages: {
        mobile: {
            required: "Please provide mobile no. field"
        }
      },
      errorElement: "span",
      errorClass: "help-inline-error",
  });
  var datas17= { 
    dataType : "json",
    success:   function(data){
      $('.body_blur').hide();
      if(data.status){
        swal("Success!", "Updated successfully", "success",{timer: 1500});
        setTimeout(function(){
            location.reload();
        }, 1500);
      } else{
        
        swal("Warning!", common(data.reason), "error");
      }
    }
  };
  $('#update_frnd_details').submit(function(e){     
    e.preventDefault();
    if (update_frnd_details.form()) 
    {
      $('.body_blur').show();
      $(this).ajaxSubmit(datas17);  
    }          
  });
  //refer channel partner
  var refer_cp = jQuery("#refer_cp").validate({
      rules: {
        club_type: {
            required: true
        },
        name: {
            required: true
        },
        phone: {
            required: true
        }

      },
      messages: {
        club_type: {
            required: "Please provide  Club Type field"
        },
        name: {
            required: "Please provide  Channel Partner field"
        },
        phone: {
            required: "Please provide  Contact field"
        }
      },
      errorElement: "span",
      errorClass: "help-inline-error",
  });
  var datas18= { 
    dataType : "json",
    success:   function(data){
      $('.body_blur').hide();
      if(data.status){
        swal("Success!", "Channel Partner referred successfully", "success",{timer: 1500});
        setTimeout(function(){
            location.reload();
        }, 1500);
      } else{
        
        swal("Warning!", common(data.reason), "error");
      }
    }
  };
  $('#refer_cp').submit(function(e){     
    e.preventDefault();
    if (refer_cp.form()) 
    {
      $('.body_blur').show();
      $(this).ajaxSubmit(datas18);  
    }          
  });
  // Delete CA
  $(document).on('click', '.delet_ca', function () {
      var row_id = $(this).data('id');
      var cur = $(this);
      $.ajax({
          url:"<?php echo base_url(); ?>user/Profile/delete_ca",
          method:"POST",
          data:{row_id:row_id},
          success:function (data)
          {
              swal("Success!", "Club Agent Deleted Successfully.", "success",{timer: 1500});
              setTimeout(function(){
                  location.reload();
              }, 1500);
            
          }
      });
  });

  //Delete CP
  $(document).on('click', '.delet_cp', function () {
      var row_id = $(this).data('id');
      var cur = $(this);
      $.ajax({
          url:"<?php echo base_url(); ?>user/Profile/delete_cp",
          method:"POST",
          data:{row_id:row_id},
          success:function (data)
          {
              swal("Success!", "Channel Partner Deleted Successfully.", "success",{timer: 1500});
              setTimeout(function(){
                  location.reload();
              }, 1500);
            
          }
      });
  });

  $('#ba_country').change(function () {
      var cur = $(this);
      var country_id = cur.val();
      if (country_id != '') {
        $.get('<?= base_url();?>Register/get_states_by_country', {country_id: country_id}, function (data) {
            if (data.status) {
                $('#ba_states').html();
                var opt = '';
                var data = data.data;
                
                opt += '<option value="">Please select</option>';
                for (var i = 0; i < data.length; i++) {
                  opt += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                }
                //  $('#states')[0].sumo.unload();
                $('#ba_states').html(opt);
            } else {
                swal("Warning!", 'No State Found', "error");
            }
        }, 'json');
      }
  });
  $('#ba_states').change(function () {
      var cur = $(this);
      var state_id = cur.val();
      
      if (state_id != '') {

          $.get('<?= base_url();?>Register/get_city_by_state', {state_id: state_id}, function (data) {
              if (data.status) {
                 $('#ba_city').html();
                  var opt = '';
                  var data = data.data;
                  for (var i = 0; i < data.length; i++) {
                      opt += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                  }
                  $('#ba_city').html(opt);
              } else {
                swal("Warning!", 'No City Found', "error");
              }
          }, 'json');
      }
  });

  //Add BA
  var add_ba = jQuery("#add_ba").validate({
      rules: {
        name: {
            required: true
        },
        phone: {
            required: true
        },
        email:{
          required:true
        }

      },
      messages: {
        name: {
            required: "Please provide  Name field"
        },
        phone: {
            required: "Please provide  Contact field"
        },
        email: {
            required: "Please provide  Email field"
        }
      },
      errorElement: "span",
      errorClass: "help-inline-error",
  });
  var datas19= { 
    dataType : "json",
    success:   function(data){
      $('.body_blur').hide();
      if(data.status){
        swal("Success!", "Jaazzo Store added successfully", "success",{timer: 1500});
        setTimeout(function(){
            location.reload();
        }, 1500);
      } else{
        
        swal("Warning!", common(data.reason), "error");
      }
    }
  };
  $('#add_ba').submit(function(e){     
    e.preventDefault();
    if (add_ba.form()) 
    {
      $('.body_blur').show();
      $(this).ajaxSubmit(datas19);  
    }          
  });

  //Refer BA
  var refer_ba = jQuery("#refer_ba").validate({
      rules: {
        name: {
            required: true
        },
        phone: {
            required: true
        },
        email:{
          required:true
        }

      },
      messages: {
        name: {
            required: "Please provide  Name field"
        },
        phone: {
            required: "Please provide  Contact field"
        },
        email: {
            required: "Please provide  Email field"
        }
      },
      errorElement: "span",
      errorClass: "help-inline-error",
  });
  var datas21= { 
    dataType : "json",
    success:   function(data){
      $('.body_blur').hide();
      if(data.status){
        swal("Success!", "Jaazzo Store refered successfully", "success",{timer: 1500});
        setTimeout(function(){
            location.reload();
        }, 1500);
      } else{
        
        swal("Warning!", common(data.reason), "error");
      }
    }
  };
  $('#refer_ba').submit(function(e){     
    e.preventDefault();
    if (refer_ba.form()) 
    {
      $('.body_blur').show();
      $(this).ajaxSubmit(datas21);  
    }          
  });

  $('#bde_country').change(function () {
      var cur = $(this);
      var country_id = cur.val();
      if (country_id != '') {
        $.get('<?= base_url();?>Register/get_states_by_country', {country_id: country_id}, function (data) {
            if (data.status) {
                $('#bde_states').html();
                var opt = '';
                var data = data.data;
                
                opt += '<option value="">Please select</option>';
                for (var i = 0; i < data.length; i++) {
                  opt += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                }
                //  $('#states')[0].sumo.unload();
                $('#bde_states').html(opt);
            } else {
                swal("Warning!", 'No State Found', "error");
            }
        }, 'json');
      }
  });
  $('#bde_states').change(function () {
      var cur = $(this);
      var state_id = cur.val();
      
      if (state_id != '') {

          $.get('<?= base_url();?>Register/get_city_by_state', {state_id: state_id}, function (data) {
              if (data.status) {
                 $('#bde_city').html();
                  var opt = '';
                  var data = data.data;
                  for (var i = 0; i < data.length; i++) {
                      opt += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                  }
                  $('#bde_city').html(opt);
              } else {
                swal("Warning!", 'No City Found', "error");
              }
          }, 'json');
      }
  });
  
  //Add BDE
  var add_bde = jQuery("#add_bde").validate({
      rules: {
        name: {
            required: true
        },
        phone: {
            required: true
        },
        email:{
          required:true
        }

      },
      messages: {
        name: {
            required: "Please provide  Name field"
        },
        phone: {
            required: "Please provide  Contact field"
        },
        email: {
            required: "Please provide  Email field"
        }
      },
      errorElement: "span",
      errorClass: "help-inline-error",
  });
  var datas20= { 
    dataType : "json",
    success:   function(data){
      $('.body_blur').hide();
      if(data.status){
        swal("Success!", "BDE added successfully", "success",{timer: 1500});
        setTimeout(function(){
            location.reload();
        }, 1500);
      } else{
        
        swal("Warning!", common(data.reason), "error");
      }
    }
  };
  $('#add_bde').submit(function(e){     
    e.preventDefault();
    if (add_bde.form()) 
    {
      $('.body_blur').show();
      $(this).ajaxSubmit(datas20);  
    }          
  });

  var g = jQuery("#profile_img").validate({
      submitHandler: function(datas) {
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            dataType : "json",
            success  :    function(data)
            {
              $('.body_blur').hide();
                if(data.status)
                {
                    swal("Success!", "Profile Image updated successfully", "success",{timer: 1500});
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
                else
                {
                  var regex = /(<([^>]+)>)/ig;
                  var body = data.reason;
                  var result = body.replace(regex, "");
                  swal("Warning!", result, "error");
                }
            }
        });
      }
  });
  //pan validation
    $('#pan').change(function (event) {     
     var regExp = /[A-Z]{5}\d{4}[A-Z]{1}/; 
     var txtpan = $(this).val(); 
     if (txtpan.length == 10 ) { 
      if( txtpan.match(regExp) ){ 
      
      }
      else {
        var regex = /(<([^>]+)>)/ig;
        var body = 'Not a valid PAN number';
        var result = body.replace(regex, "");
        swal("Warning!", result, "error");
        
        $('#pan').val('');
       event.preventDefault(); 
      } 
     } 
     else { 
           
           
            var regex = /(<([^>]+)>)/ig;
            var body = 'Please enter 10 digits for a valid PAN number';
            var result = body.replace(regex, "");
            swal("Warning!", result, "error");
            event.preventDefault(); 
     } 

    });
    //end of pan validation
    //gst validation
      $(document).on('change',"#gst", function(){    
        var inputvalues = $(this).val();
        var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');

        if (gstinformat.test(inputvalues)) {
         return true;
        } else {
            var regex = /(<([^>]+)>)/ig;
            var body = "Please Enter Valid GST Number";
            var result = body.replace(regex, "");
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            $('.close').click(function(){
                $(this).parent().fadeOut(1000);
            });
            $("#gst").val('');
            $("#gst").focus();
        }

     });
    // end of gst validation
</script>
</body>
</html>
