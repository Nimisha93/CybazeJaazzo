<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>


</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">

    <div class="">

       

        <div class="clearfix"></div>

        <div class="row">


            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                    <div class="x_title">

                        <h2> Warnings <small></small></h2>

                        <ul class="nav navbar-right panel_toolbox">

                            

                              <li>

                       <a href="<?php echo base_url(); ?>employee_warning"  data-original-title="Add new" class="btn btn-success btn_add" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                    </li>
                            <li>
                                <a type="button" class="btn btn-primary fllft del_btn btn-danger" style=""><i class="fa fa-trash" aria-hidden="true"></i></a>
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



                                <table id="example" class="table display table-bordered table-striped responsive-utilities jumbo_table">

                                    <thead>



                                     <tr class="tablbg">

                                        <th>No</th>

                                        <th style="min-width:170px">Warning To</th>



                                        <th style="min-width:170px">Warning By</th>

                                        <th style="min-width:100px">Date</th>

                                        <th>Subject</th>

                                        <th class="HideColumn">Description</th>

                                        <th>Action</th>





                                    </tr>

                                  
                                    </thead>

                                    

                                   

                                    <tbody>



                                    <?php foreach ($request['request'] as $key => $request) { ?>

                                        <tr>

                                            <input type="hidden" id="request_hidden" name="request_hidden" class="request_hidden" value="<?= $request['id'];?>">

                                            <td><?= $key+1;?></td>
                                            <?php if($request['status']=="Terminated" ||$request['status']=="Exit"){ ?>

                                            <td> <?= $request['name'];?>(<?= $request['employee_code'];?>) (<?= $request['status'];?>)</td>
<?php }

               else{ ?>

                   <td> <?= $request['name'];?>(<?= $request['employee_code'];?>)</td>

                   <?php

               }
                                            ?>


    <?php if($request['em_status']=="Terminated" ||$request['em_status']=="Exit" || $request['em_status']=="Resigned"){ ?>


                                            <td><?= $request['wnby'];?>(<?= $request['wanby'];?>) (<?= $request['em_status'];?>)</td>


                                            <?php }

                                        else{ ?>

                                            <td><?= $request['wnby'];?>(<?= $request['wanby'];?>) </td>
                                            <?php

                                        }


                                              ?>


                                            <?php

                                            $datenot= $request['date'];

                                            $date2 = date('d-m-Y',strtotime($datenot));



                                            ?>



                                            <td> <?= $date2;?></td>

                                            <td><?= $request['subject'];?></td>

                                            <td><?= $request['description'];?></td>



                                            <td><a class="btn btn-primary" href="<?php echo base_url();?>hr/Employee_warning/get_warning_by_id/<?php echo $request['id'];?>"> <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <input type="checkbox" name="" value="<?php echo $request['id'];?>" class="warn_ids">



                                            </td>



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
<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>



<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>

<!--***************************date picker******************************-->
   <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />
  <!--***************************date picker end******************************-->

  <script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>





<script>



$(document).ready(function() {

    var table = $('#example').DataTable( {

        fixedHeader: {

            header: true,

            footer: true

	        }

    } );

	

} );



</script>




<script type="text/javascript">









       $(document).on('click','.del_btn',function(){
            var cur=$(this);
            var warn_id = [];
            $('.warn_ids').each(function () {
                var cur_this = $(this);
                var cur_val = $(this).val();
                if(cur_this.is(":checked")){
                    warn_id.push(cur_val);
                }

            });
           
            if(warn_id.length > 0){
                $('body').alertBox({
                title: 'Are You Sure?',
                lTxt: 'Back',
                lCallback: function(){
                  
                },
                rTxt: 'Okey',
                rCallback: function(){
                    $('.body_blur').show();
                            $.post('<?php echo base_url();?>hr/employee_warning/delete_warning',{warn_id:warn_id}, function(data){
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