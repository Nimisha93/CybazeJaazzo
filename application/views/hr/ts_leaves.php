<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>

<?php echo $sidebar; ?>
</head>

<div class="right_col" role="main">
    <div class="">
     
        <div class="clearfix"></div>
        <div class="row">
          
            

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Leaves
                           
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                        <li>
                         <a class="btn btn-success pull-right new_grp"><i class="fa fa-search" aria-hidden="true"></i></a>
                         </li>
                      


                             <li>

                       <a href="<?php echo base_url(); ?>add_leaves"  data-original-title="Add new" class="btn btn-success btn_add" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                    </li>
                            <li>
                                <a type="button" class="btn btn-primary fllft del_btn btn-danger" style=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <table id="example" class="table display table-bordered table-striped responsive-utilities">
                                    <thead>

                                   <tr class="tablbg">

                                       <th>No</th>

                                        <th>Employee </th>
                                        <!-- <th>lt_id</th> -->
                                        <th>Leave Name</th>
                                        <th>Reason</th>
                                        <th>Leave for</th>
                                       
                                        <th>Status</th>

                                        <th class="HideColumn">Action</th>


                                    </tr>

                                    </thead>



                                    <tbody>

                                    <?php foreach ($leaves as $key => $lev) { ?>
                                        <tr>
                                            <input type="hidden" name="lev_id" class="lev_id" value="<?= $lev['lr_id'];?>">
                                            <td><?= $key+1;?></td>

                                            <td><?= $lev['empname'];?>(<?= $lev['emp_code'];?>)</td>
                                            <!-- <td><?= $lev['lt_id'];?></td> -->
                                            <td><?= $lev['leavename'];?></td>
                                            <td><?= $lev['reason'];?></td>

                                            <td><?php 
                                                   $dater= $lev['levfrom'];
                                                  $date1=date('d-m-Y',strtotime($dater));
                                            echo $date1; 
                                            $to=" to "; 
                                            if($lev['levto']!=0){
                                                   $date2= $lev['levto'];
                                                  $date2=date('d-m-Y',strtotime($date2));
                                             echo $to,$date2; }?></td>
                                            
                                            <td><?php if($lev['status']=='1'){ echo "Approved"; } else
                                                {
                                                    echo "Pending" ;

                                                } ?></td>

                                            <td>
                                            <a type="button" href="<?php echo base_url();?>hr/timesheet/leavesbyid/<?php echo $lev['ep_id'];?>/<?php echo $lev['lr_id'];?>" class="btn btn-primary fllft edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <?php if($lev['status']!='1') { ?>

                                               
                                                    <a class="btn btn-primary approve" data-id="<?= $lev['lr_id'];?>"> <i class="fa fa-thumbs-up " aria-hidden="true"></i> Approve </a>
                                                <?php } ?>
                                               <input type="checkbox" name="" value="<?= $lev['lr_id'];?>" class="chck_grp_item"> </td>



                                        </tr>
                                    <?php   } ?>



                                    </tbody>
                                   
                                </table>
                                <br>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<div class="clearfix"></div>

<!--************************row  end******************************************************************* -->

</div>
</div>
</div>
</div>
</div>



<div class="row">
    <div id="grpmodel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="max-width:650px;margin:auto;height:231px;">
                <div class="modal-header">

                </div>
                <div class="modal-body">
                    <h4>Leaves of Employee</h4>
                    <form class="form-label-left" id="group_form"  method="post">
                       <div class="item form-group">

                            <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Employee</label>

                                <select class=" form-control emp  " name="emp" id="emp"  required="">

                                    <option value="">Please Select</option>
                                    <?php foreach($emp as $key => $att) { ?>
                                    <option value="<?= $att['id'];?>"><?= $att['name'];?></option>
                                    <?php } ?>
                                </select>

                                   </div>  </div>
                                   </div>

                        <div class="item form-group" style=" ">

                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Month</label>
                                <select class="form-control validate[required] sel_typee month" name="month" id="month"  required="">

                                    <option value="">Please Select</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                         <option value="3">Mar</option>

                                    <option value="4">Apr</option>

                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>

                                </select>
<!--                                <input id="name" class="form-control validate[required] col-md-7 col-xs-12 bodrnone"  name="group_name" value=""  type="text" required="">-->
                            </div> </div>

                        <div class="item form-group" style=" ">

                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <label>Total Leaves</label>
                            <input id="lev_no" class="form-control validate[required] col-md-7 col-xs-12 lev_no"  name="lev_no" value=""  type="text" >
                            </div> </div>


                        <div class="item form-group" style="    padding-top: 88px;">
                            <div class="col-md-12 col-sm-12 col-xs-12 tpmr15">
<!--                          <button id="send" name="sub" type="submit" class="btn btn-primary add_grp">  Submit</button>-->
                                <button type="button" class="btn btn-default btn_close" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>

<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.buttons.min.js" type="text/javascript"></script>


<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<!--***************************date picker******************************-->
   <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />
  <!--***************************date picker end******************************-->
  <link href="<?php echo base_url();?>assets/admin/css/select2.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/select2.full.js" type="text/javascript" charset="utf-8">
</script>
 <script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('.approve').click(function(e){
            e.preventDefault();
      
        var cur=$(this);
        var id=cur.data('id');
          // var id=$('.lev_id').val();
     
        $.post("<?php echo base_url();?>hr/timesheet/leaves_approve/"+id, function(data){
        if(data.status)
        {
                              


                                         var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Approved Successfully</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        location.reload();
                    }, 1000);
            }
      
        },'json');
        });
    });
</script>

<script>
$(document).ready(function(){
$(document).on('click','.btn_close',function(){
   
$('#group_form')[0].reset();

}) ;
}) ;
</script>
<script>

    $(document).ready(function(){
    $('.new_grp').click(function(){
        $('#grpmodel').modal('show');
    });


        $(document).on('change', '.month', function(){


            var cur = $(this);
            var data = $('#group_form').serializeArray();
            $('.body_blur').show();
            $.post('<?= base_url();?>hr/Timesheet/view_leaves_emp', data, function(data){
                $('.body_blur').hide();
                if(data.status){
                    var data = data.data;


                    var leve_no=data.leaves;


                  $('.lev_no').val(leve_no);



                } else{
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }
            },'json');


    });
});


    </script>
<!-- <script type="text/javascript">
    $(document).on('click', '.del_leave', function(){
        var cur = $(this);
        var lv_id  = cur.parent().parent().find('.lev_id').val();
//alert(lv_id);exit();
        noty({
            text: 'Do you want to continue?',
            type: 'warning',
            buttons: [
                {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                   
                    $noty.close();
                    $('.body_blur').show();
                    $.post('<?php echo base_url();?>hr/Timesheet/apply_leave_delete/'+lv_id, function(data){
                        $('.body_blur').hide();
                        if(data.status){
                            noty({text: 'Deleted Succesfully', type: 'success', timeout:1000});
                            cur.parent().parent().remove();
                        }else{
                            noty({text: 'Database Error', type: 'error'});
                        }
                    },'json');
                }
                },
                {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                    $noty.close();

                }
                }
            ]
        });


    });
</script>
 -->

<script>

$(document).ready(function() {
    var table = $('#example').DataTable( {
        fixedHeader: {
            header: true,
            footer: true
			
        }
    } );
	
} );



  $(document).on('click','.del_btn',function(){
            var cur=$(this);
            var itemgrps = [];
            $('.chck_grp_item').each(function () {
                var cur_this = $(this);
                var cur_val = $(this).val();
                if(cur_this.is(":checked")){
                    itemgrps.push(cur_val);
                }

            });
           
            if(itemgrps.length > 0){
                $('body').alertBox({
                title: 'Are You Sure?',
                lTxt: 'Back',
                lCallback: function(){
                  
                },
                rTxt: 'Okey',
                rCallback: function(){
                    $('.body_blur').show();
                            $.post('<?php echo base_url();?>hr/Timesheet/apply_leave_delete/',{itemgrps:itemgrps}, function(data){
                                $('.body_blur').hide();
                if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Deleted </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
                }
                else
                {
                   // $('#channel_form').hide();
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
                            },'json');
                    }
                })
            }
        });

</script>

    

</body>
</html>