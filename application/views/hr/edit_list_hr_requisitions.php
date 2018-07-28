<?php echo $header; ?>
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>


</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>
        <div class="row">
            
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="overflow-x: auto;">
                    <div class="x_title">
                        <h2>Requisitions<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">

                          <li>

                       <a href="<?php echo base_url();?>add_requisitions" data-original-title="Add new" class="btn btn-success" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                    </li>

                               <a type="button" class="btn btn-primary fllft del_btn" style="background-color:#162b52"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
 <table id="example" class="display table-bordered table-striped" cellspacing="0" width="100%">                                    <thead>

                                      <tr class="tablbg">

                                        <th>No</th>


                                        <th class="HideColumn">Branch</th>
                                        <th class="HideColumn">Department</th>
                                        <th>Title</th>

                                        <th>Posts</th>
                                        <th class="HideColumn">Location</th>
                                        <th class="HideColumn">Age Range</th>
                                        <th class="HideColumn">Salary Range</th>
                                        <th class="HideColumn">Qualification</th>
                                        <th class="HideColumn">Experience</th>
                                        <th class="HideColumn">Description</th>



                                        <th>Action</th>

                                        <!-- <th class="HideColumn">n4</th> -->

                                    </tr>
                                 
                                    </thead>

                                    <tbody>

                                    <?php $to=' to '; foreach ($requisitions as $key => $requisition) { ?>
                                        <tr>
                                            <input type="hidden" name="req_id" class="req_id" value="<?= $requisition['rq_id'];?>">
                                            <td><?= $key+1;?></td>
                                            <td><?= $requisition['st_name'];?></td>
                                            <td><?= $requisition['dep'];?></td>
                                            <td><?= $requisition['title'];?></td>

                                            <td><?= $requisition['posts'];?></td>
                                            <td><?= $requisition['location'];?></td>
                                            <td><?= $requisition['age_st']." ".$to." ".$requisition['age_en'];?></td>
                                            <td><?= $requisition['salary_st']." ".$to." ".$requisition['salary_en'];?></td>
                                            <td><?= $requisition['qualificationss'];?></td>
                                            <td><?= $requisition['exp'];?></td>
                                            <td><?= $requisition['desp'];?></td>

                                            <td>
                                                <a class="btn btn-primary" href="<?php echo base_url();?>copy_to_post/<?php echo $requisition['rq_id'];?>"> <i class="fa fa-clone"></i> Copy to Job Posts</a>
                                                <a class="btn btn-primary" href="<?php echo base_url();?>edit_requisition/<?php echo $requisition['rq_id'];?>"> <i class="fa fa-pencil"></i></a>
                                                <!-- <a class="btn btn-danger del_desig"><i class="fa fa-trash"></i>Delete</a> -->
                                                <input type="checkbox" name="" value="<?php echo $requisition['rq_id'];?>" class="chck_grp_item">

                                            </td>

                                            
                                        </tr>
                                    <?php   } ?>




                                  
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





<script>

$(document).ready(function() {
    var table = $('#example').DataTable( {
        fixedHeader: {
            header: true,
            footer: true,

        }
    } );

} );

</script>
<style>
tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
		background-color:#e6e6e6;
    }
	tfoot {background-color:#f1f1f1}
	</style>



<script type="text/javascript">
    $(document).on('click', '.del_desig', function(){
        var cur = $(this);
        var vendor_id  = cur.parent().parent().find('.req_id').val();

        noty({
            text: 'Do you want to continue?',
            type: 'warning',
            buttons: [
                {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                    // this = button element
                    // $noty = $noty element

                    $noty.close();
                    $('.body_blur').show();
                    $.post('<?php echo base_url();?>hr/hr/delete_req/'+vendor_id, function(data){
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
                            $.post('<?php echo base_url();?>hr/Recruitment/deleterequisition/',{itemgrps:itemgrps}, function(data){
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