<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
  .foo {
    float: left;
    width: 20px;
    height: 20px;
    margin: 5px;
    border: 1px solid rgba(0, 0, 0, .2);
  }

  .green {
    background:#aae6ab;
  }

  .red {
    background:#efc3c3;
  }

  .blue {
    background:#74b2d2;
  }
</style>
<script type="text/javascript">
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
  }
</script>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>All Club Member Type<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <!-- <li>Fixed <div class="foo green"></div></li>
                            <li>Unlimited <div class="foo red"></div></li>
                            <li>Team Lead Club <div class="foo blue"></div></li> -->
                    
                            <li><a type="button" class="btn btn-danger fllft del_btn" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>  </li>
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <table id="example" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>Club Name</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Cash limit(Per Year)</th>
                                    <!-- <th>Pooling Commision</th> -->
                                    <th>Club Agent Facility</th>
                                    <th>Channel Partner Facility</th>
                                    <th>Individual Friends Facility</th>
                                    <th>Jaazzo Store Facility</th>
                                    <th>BDE Facility</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody style=" height:100px;overflow:scroll">
                                <?php foreach($club_types as $club_type){
                                    if($club_type['type']=='FIXED'){ $st='style="background:#aae6ab"';}elseif($club_type['type']=='INVESTOR'){ $st='style="background:#74b2d2"'; }else{ $st='style="background:#efc3c3"';} 
                   ?>
                                <tr ><!-- <?php echo $st;?> -->
                                    <td class="titleclass"><?php echo $club_type['title'];?></td>
                                    <td class="descrip"><?php echo $club_type['amount'];?></td>
                                    <td class="descrip"><?php echo ($club_type['type']=='INVESTOR')?'Team Lead Club':$club_type['type'];?></td>
                                    <td class="descrip"><?php echo $club_type['description'];?></td>
                                    <td class="descrip"><?php echo $club_type['amount']/$club_type['cash_limit'];?></td>
                                   <!--  <td class="descrip"><?php echo $club_type['pooling_commision'];?></td> -->
                                    <td class="descrip"><?php echo ($club_type['club_agent_status']==1)?'Yes':'No';?></td>
                                    <td class="descrip"><?php echo ($club_type['cp_status']==1)?'Yes':'No';?></td>
                                    <td class="descrip"><?php echo ($club_type['user_status']==1)?'Yes':'No';?></td>
                                    <td class="descrip"><?php echo ($club_type['ba_status']==1)?'Yes':'No';?></td>
                                    <td class="descrip"><?php echo ($club_type['bde_status']==1)?'Yes':'No';?></td>
                                    <td>
                                        <a href="#" data-id="<?php echo $club_type['id'];?>" class="clbtn"><button type="button" class="btn btn-primary type_sub"><i class="fa fa-pencil"></i> </button></a>
                                        <input type="checkbox" name="" value="<?php echo $club_type['id'];?>" class="chck_item_id"> 
                                    </td>
                                    <div id="edit_<?php echo $club_type['id'];?>" class="edit_form modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">X</button>
                                                    <h4 class="modal-title">Edit Club Member Type</h4>
                                                </div>
                                                <form method="post" id="type_forms<?php echo $club_type['id'];?>" class="type_forms" name="type_forms" action="<?php echo base_url();?>admin/Clubmember/update_club_member_type">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                                <label>Club Name</label>
                                                                <input type="text" placeholder="Club Name" name="clubname" id="clubname" value="<?php echo $club_type['title'];?>" class="form-control" data-rule-required="true" data-msg-required="Please enter club name field.">
                                                                <input type="hidden" value="<?php echo $club_type['id'];?>" class="hiddentype_id" name="id">
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                                <label>Amount</label>
                                                                <input type="text" placeholder="Amount" name="amount" id="amount" class="form-control" value="<?php echo $club_type['amount'];?>" data-rule-required="true"  data-msg-required="Please enter amount field.">
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                                <label>No of Years<!-- 1 Year Usage Limit --></label>
                                                                <input type="text" name="ussage_limit" id="ussage_limit" placeholder="No of Years" class="form-control" data-rule-required="true" value="<?php echo $club_type['cash_limit'];?>" data-msg-required="Please enter usage limit field.">
                                                                <br> 
                                                                <label>Type</label>
                                                                <?php  $type = $club_type['type'];?>
                                                                <input name="type" type="radio" class="type" <?php echo ($type=='FIXED')?'checked':'';?> value="FIXED">&nbsp;Fixed
                                                                <input name="type" type="radio" class="type" <?php echo ($type=='UNLIMITED')?'checked':'';?> value="UNLIMITED">&nbsp;Unlimited
                                                                <input name="type" type="radio" class="type" <?php echo ($type=='INVESTOR')?'checked':'';?> value="INVESTOR">&nbsp;Team Lead Club 
                                                            </div>
                                                            
                                                            <!-- <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                                <label>Club Pooling Commision (%)</label>
                                                                <input type="text" name="club_pooling" id="club_pooling" placeholder="Club Pooling Commision %" value="<?php echo $club_type['pooling_commision'];?>" class="form-control" data-rule-required="true"  data-msg-required="Please enter club pooling commision field.">
                                                            </div> -->
                                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                                <label>Description</label>
                                                                <textarea class="form-control" title="Description" name="description" id="description" rows="4" placeholder="Description" class="form-control" data-rule-required="true"  data-msg-required="Please enter description field."><?php echo $club_type['description'];?></textarea>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group benefit bde_benfit">
                                                                <label>BDE Benefit</label>
                                                                <input type="number"  class="form-control" name="bde_benfit" value="<?php echo $club_type['bde_benefit'];?>" class="form-control"  onKeyPress="return isNumberKey(event)">
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group benefit">
                                                                <label>TL Benefit</label>
                                                                <input type="number"  class="form-control" name="tl_benfit" value="<?php echo $club_type['tl_benefit'];?>" class="form-control"  onKeyPress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group cp">
                                                                <div class="row">
                                                                <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                                                    <label>Channel Partner Facility</label><br />
                                                                    <input name="channel_partner_fecility" type="checkbox" class="channel_partner_fecility" <?php echo ($club_type['cp_status']==1)?'checked="checked"':''?>>
                                                                </div>
                                                                <div class="col-md-9 col-sm-6 col-xs-12 form-group cp_limit">
                                                                    <label>Channel Partner Limit</label><br />
                                                                    <input type="number" name="cp_limit" value="<?php echo $club_type['cp_limit'];?>" class="form-control"  onKeyPress="return isNumberKey(event)">
                                                                </div>
                                                                <div class="col-md-12 col-sm-6 col-xs-12 form-group reward_per_cp">
                                                                    <label>Reward Per Channel Partner </label><br />
                                                                    <input type="number" name="reward_per_cp" value="<?php echo $club_type['reward_per_cp'];?>" class="form-control"  onKeyPress="return isNumberKey(event)">
                                                                </div>
                                                            </div></div>
                                                            <div class="ca col-md-6 col-sm-6 col-xs-12 form-group" id="ca">
                                                                 <div class="row">
                                                                <style>
                                                                    .toggle.android { border-radius: 0px;}
                                                                    .toggle.android .toggle-handle { border-radius: 0px; }
                                                                </style>
                                                                <div class="ca_fai col-md-3 col-sm-6 col-xs-12 form-group">
                                                                    <label>Club Agent Facility</label><br />
                                                                    <input name="club_agent_fecility" type="checkbox" class="club_agent_fecility" <?php echo ($club_type['club_agent_status']==1)?'checked="checked"':''?>>
                                                                </div>
                                                                <div class="col-md-9 col-sm-6 col-xs-12 form-group ca_limit">
                                                                    <label>Club Agent Limit</label><br />
                                                                    <input type="number" name="ca_limit" class="form-control" value="<?php echo $club_type['ca_limit'];?>"  onKeyPress="return isNumberKey(event)">
                                                                </div>
                                                            </div></div>
                                                        </div>
                                                        <div class="row users">
                                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                                <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                                                    <label>Individual Friend Facility</label><br />
                                                                    <input name="user_fecility" type="checkbox" <?php echo ($club_type['user_status']==1)?'checked="checked"':''?> class="user_fecility">
                                                                </div>
                                                                <div class="col-md-9 col-sm-6 col-xs-12 form-group user_limit">
                                                                    <label>Individual Friends Limit</label><br />
                                                                    <input type="number" value="<?php echo $club_type['user_limit'];?>"  name="user_limit" class="form-control"  onKeyPress="return isNumberKey(event)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row ba">
                                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                                <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                                                    <label>Jaazzo Store Facility</label><br />
                                                                    <input name="ba_fecility" type="checkbox" <?php echo ($club_type['ba_status']==1)?'checked="checked"':''?> class="ba_fecility">
                                                                </div>
                                                                <div class="col-md-9 col-sm-6 col-xs-12 form-group ba_limit">
                                                                    <label>Jaazzo Store Limit</label><br />
                                                                    <input type="number" value="<?php echo $club_type['ba_limit'];?>"  name="ba_limit" class="form-control"  onKeyPress="return isNumberKey(event)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row bde">
                                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                                <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                                                    <label>BDE Facility</label><br />
                                                                    <input name="bde_fecility" type="checkbox" <?php echo ($club_type['bde_status']==1)?'checked="checked"':''?> class="bde_fecility">
                                                                </div>
                                                                <div class="col-md-9 col-sm-6 col-xs-12 form-group bde_limit">
                                                                    <label>BDE Limit</label><br />
                                                                    <input type="number" value="<?php echo $club_type['bde_limit'];?>"  name="bde_limit" class="form-control"  onKeyPress="return isNumberKey(event)">
                                                                </div>
                                                            </div>

                                                       </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="modal-footer">
                                                        <div class="col-md-12 form-group ">
                                                             <button type="button" class="btn btn-primary btn_save_club_type" id="editsub" data-id="<?php echo $club_type['id'];?>">Submit</button>

                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                        var type = '<?php  echo $club_type['type'];?>';//$("input[name='type']:checked"). val();;
                                                    </script>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div id="notifications" style="z-index: 999999;"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
    $('input:radio[name="type"]').change(
        function(){
            if ($(this).val() == 'FIXED') {
                $(".cp" ).show();
                $(".reward_per_cp" ).show();
                $(".bde_benfit" ).show();
                $(".ca" ).hide();
                $(".users" ).hide();
                $(".ba" ).hide();
                $(".bde" ).hide();
                $(".benefit").hide();
            }else if ($(this).val() == 'INVESTOR') {
                $(".cp" ).show();
                $(".reward_per_cp" ).hide();
                $(".ca" ).show();
                $(".users" ).show();
                $(".ba" ).show();
                $(".bde" ).show();
                $(".benefit").hide();
                $(".bde_benfit" ).hide();
            }else {
                $(".ca" ).show();$(".reward_per_cp" ).hide();
                $(".cp" ).show();
                $(".users" ).show();
                $(".ba" ).show();
                $(".bde" ).hide();
                $(".benefit").show();$(".bde_benfit" ).show();
            }
        }
    );
    $(function()
    {
      $('[name="club_agent_fecility"]').change(function()
      {
        if ($(this).is(':checked')) {
           $( ".ca_limit" ).toggle( "slow");
        }else{
            $(".ca_limit" ).hide();
        }
      });
      $('[name="channel_partner_fecility"]').change(function()
      {
        if ($(this).is(':checked')) {
           $( ".cp_limit" ).toggle( "slow");
        }else{
            $(".cp_limit" ).hide();
        }
      });
      $('[name="user_fecility"]').change(function()
      {
        if ($(this).is(':checked')) {
           $( ".user_limit" ).toggle( "slow");
        }else{
            $(".user_limit" ).hide();
        }
      });
      $('[name="ba_fecility"]').change(function()
      {
        if ($(this).is(':checked')) {
           $( ".ba_limit" ).toggle( "slow");
        }else{
            $(".ba_limit" ).hide();
        }
      });
      $('[name="bde_fecility"]').change(function()
      {
        if ($(this).is(':checked')) {
           $( ".bde_limit" ).toggle( "slow");
        }else{
            $(".bde_limit" ).hide();
        }
      });
      $(document).on('click', '.clbtn',function () {
            var cur = $(this);
            var id = cur.data('id');
            var mdl = "#edit_"+id;
            $(mdl).modal('show');
            var type=$(mdl).find("input[name='type']:checked"). val();

            if ($(mdl).find('[name="club_agent_fecility"]').is(':checked')) {
               $( ".ca_limit" ).show();
            }else{
                $(".ca_limit" ).hide();
            }

            if ($(mdl).find('[name="channel_partner_fecility"]').is(':checked')) {
               $( ".cp_limit" ).show();
            }else{
                $(".cp_limit" ).hide();
            }

            if ($(mdl).find('[name="user_fecility"]').is(':checked')) {
               $( ".user_limit" ).show();
            }else{
                $(".user_limit" ).hide();
            }

            if ($(mdl).find('[name="ba_fecility"]').is(':checked')) {
               $( ".ba_limit" ).show();
            }else{
                $(".ba_limit" ).hide();
            }

            if ($(mdl).find('[name="bde_fecility"]').is(':checked')) {
               $( ".bde_limit" ).show();
            }else{
                $(".bde_limit" ).hide();
            }
            if(type=='FIXED'){
                $(".ca" ).hide();
                $(".users" ).hide();
                $(".bde" ).hide();
                $(".ba" ).hide();
                $(".bde" ).hide();
                $(".cp" ).show();
                $(".benefit").hide();
                $(".reward_per_cp" ).show();
                $(".bde_benfit" ).show();
            }else if(type=='INVESTOR'){
                $(".ca" ).show();
                $(".cp" ).show();
                $(".users" ).show();
                $(".bde" ).show();
                $(".ba" ).show();
                $(".reward_per_cp" ).hide();
                $(".benefit").hide();
                $(".bde_benfit" ).hide();
            }else{
                $(".ca" ).show();
                $(".cp" ).show();
                $(".ba" ).show();
                $(".users" ).show();
                $(".reward_per_cp" ).hide();
                $(".bde" ).hide();
                $(".benefit").show();$(".bde_benfit" ).show();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // DataTable
        var table = $('#example').DataTable();
    });
    //Update Club Type
    $(document).on('click', '.btn_save_club_type', function(e){
        e.preventDefault();
        $('.body_blur').show();
        var cur = $(this);
        var id = cur.data('id');
        var va = "#type_forms"+id;
        var v = jQuery(va).validate();
        if (v.form()) {
            jQuery(va).ajaxSubmit({
                dataType : "json",
                success  :    function(data)
                {
                    var modl = "#edit_"+id;
                    
                    $('.body_blur').hide();
                    if(data.status)
                    {
                        $(modl).modal('hide');
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text"> Club member type updated Successfully</div></div>';
                        var effect='zoomIn';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        refresh_close();
                    }
                    else
                    {
                        var regex = /(<([^>]+)>)/ig;
                        var body = data.reason;
                        var result = body.replace(regex, "");
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                        var effect='fadeInRight';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        // refresh_close();
                        $('.close').click(function(){
                            $(this).parent().fadeOut(1000);
                        });
                    }
                }
            });
        }
    });

    //Delete Club type
    $(document).on('click','.del_btn',function(){
        var cur=$(this);
        var chck_item_id = [];
        $('.chck_item_id').each(function () {
            var cur_this = $(this);
            var cur_val = $(this).val();
            if(cur_this.is(":checked")){
                chck_item_id.push(cur_val);
            }
        });
        if(chck_item_id.length > 0){
            $('body').alertBox({
                title: 'Are You Sure?',
                lTxt: 'Back',
                lCallback: function(){
                  
                },
                rTxt: 'Okey',
                rCallback: function(){
                    $('.body_blur').show();
                    $.post('<?php echo base_url();?>delete_club_type/',{chck_item_id:chck_item_id}, function(data){
                        $('.body_blur').hide();
                        if(data.status){
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted </div></div>';
                            var effect='zoomIn';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                        }else{
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                        }
                    },'json');
                }
            })
        }else{
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Please select atleast one club member type</div></div>';
            var effect='zoomIn';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            refresh_close();
        }
    });

</script>
<style>


