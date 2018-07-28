<?= $default_assets;?>
<link href="<?php echo base_url();?>assets/public/css/dashboard.css" rel="stylesheet" type="text/css" /> 
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
<?php  
  $datas = getLoginId();
  $lid = $datas['login_id'];
  $club_type_id = $datas['club_type_id'];
  $investor = isset($datas['investor_type_id'])?$datas['investor_type_id']:0;
  $fixed = isset($datas['fixed_type_id'])?$datas['fixed_type_id']:0;
  $session_array1 = $this->session->userdata('logged_in_user');
  $session_array2 = $this->session->userdata('logged_in_club_member');
  $session_array3 = $this->session->userdata('logged_in_club_agent');
        
  if(isset($session_array1)){
    $type= $session_array1['type'];
  }
  if(isset($session_array2)){
    $type= $session_array2['type'];
  }
  if(isset($session_array3)){
    $type= $session_array3['type'];
  }
?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" /> 
<script src="<?php echo base_url();?>assets/public/js/jquery-ui.min.js"></script> 
<script src="<?php echo base_url();?>assets/public/js/angular.min.js"></script> 


<script type="text/javascript">
$(function () {
    $("#date").datepicker({
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
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57 ))
        return false;
    return true;
  }
</script>
<?php  
  $datas = getLoginId();
  $club_type_id = $datas['club_type_id'];
  $investor = isset($datas['investor_type_id'])?$datas['investor_type_id']:0;
  $fixed = isset($datas['fixed_type_id'])?$datas['fixed_type_id']:0;
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
<link href="<?php echo base_url();?>assets/public/sumo-select/sumoselect.css" rel="stylesheet" />
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
            <div class="panel panel-defaul" style="background: none">
              <ul>
                <li><a href="<?php echo base_url();?>user_profile"  style="color: #fff;"><i class="fa fa-tachometer marleft7" aria-hidden="true"></i>Dashboard</a></li>
                <li id="history2" class="resp-tab-item" aria-controls="tab_item-2" class="list-group-item">Benefit From Members</li>
              </ul>
              
            </div>
            <div class="hegtdiv"></div>
          </div> 

        </ul>
        <div class="resp-tabs-container">
          <div>
            <div class="row wlletbg_prfile">
                <?php 
                if((($type=='club_member') && (($club_type_id>0 || $investor>0) && $fixed==0  ))||$type=='club_agent'){

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
                              $fixed_cp_limit= !empty($det1['fixed_cp_limit'])?$det1['fixed_cp_limit']:0;
                              $fixed_cp_count = !empty($det1['fixed_cp_count'])?$det1['fixed_cp_count']:0;
                              $cp_limit= !empty($det1['cp_limit'])?$det1['cp_limit']:0;
                              $cp_count = !empty($det1['cp_count'])?$det1['cp_count']:0;
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
                             if($investor>0){
                                $url = "user_profile#oilfield12";
                             }else{
                              $url = "user_profile#oilfield13";
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
                if(($club_type_id>0 && $fixed==0) || $investor>0){ ?>
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
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row wlletbg_prfile">
                  <h1 class="profil_ttlt">
                    Rewards Through Channel Partners
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
                    <table class="col-md-12 table-bordered table-striped table-condensed">
                      <thead class="">
                        <tr>
                          <th width="65px;">Sl No.</th>
                          <th>Name of the Organization</th>
                          <th>Rewards</th>
                        </tr>
                      </thead>

                      <tbody id="tbody3" style=" height:100px;overflow:scroll">
                          
                      </tbody>
                      <tfoot>
                          <td colspan="3">
                              <div class="pull-right" id="pagination3"></div>
                          </td>
                      </tfoot>
                    </table>
                  </div>
                </div>         
              </div> 
          </div>
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
<div id="uplodimage" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">X</button>
        <h4 class="modal-title">Upload Your Profile Image</h4>
      </div>
      <?php echo form_open_multipart('Home/do_upload');?>
        <div class="modal-body">
          <div>
            <div class="fileUpload btn btn-primary">
              <span>Upload</span>
              <input id="fileupload" type="file" class="upload" id="fileupload" multiple="multiple" name="userfile[]" />
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
<script src="<?php echo base_url();?>assets/public/js/easyResponsiveTabs.js"></script> 
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>assets/public/sumo-select/jquery.sumoselect.js"></script>
<script src="<?php echo base_url();?>assets/public/custom_js/paging.js"></script>
<script>
  $('#oilfield').easyResponsiveTabs({
    type: 'vertical'
  });
</script> 
<!--=======================================slider right==============================================--> 
<script language="javascript" type="text/javascript">
  $(document).ready(function() {
    $(".gototop").click(function() {
        $("html, body").animate({"scrollTop": "0px"});
    });
  });
</script>
</body>
</html>
