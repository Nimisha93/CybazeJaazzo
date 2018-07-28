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

                        <h2> Exit Employees<small></small></h2>

                        <ul class="nav navbar-right panel_toolbox">
                            


                              <li>

                       <a href="<?php echo base_url();?>add_employee_exit" data-original-title="Add new" class="btn btn-success" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
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

                                        <th style="min-width:130px">Employee</th>

                                        <th style="min-width:80px">Exit Date</th>

                                        <th  style="min-width:100px">Type Of Exit</th>

                                        <th class="HideColumn">Conduct Exit Interview</th>

                                        <th class="HideColumn">Exit Reason</th>

                                        <th>Action</th>

                                    </tr>

                              

                                    </thead>

                                    

                     

                                    

                                    <tbody>



                                    <?php foreach ($request['request'] as $key => $request) { ?>

                                        <tr>

                                            <input type="hidden" id="request_hidden" name="request_hidden" class="request_hidden" value="<?= $request['id'];?>">

                                            <td><?= $key+1;?></td>

                                            <td> <?= $request['name'];?>(<?= $request['employee_code'];?>)</td>

                                            <?php

                                            $dater= $request['exit_date'];

                                            $date1=convert_ui_date($dater);



                                            ?>



                                            <td> <?= $date1;?></td>

                                            <td><?= $request['type'];?></td>

                                            <td><?= $request['exit_interview'];?></td>

                                            <td><?= $request['exit_reason'];?></td>



                                            <td><a class="btn btn-primary" href="<?php echo base_url();?>update_exit/<?php echo $request['id'];?>"> <i class="fa fa-pencil"></i></a>

                                                <input type="checkbox" name="" value="<?php echo $request['id'];?>" class="chck_grp_item"></td>



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

<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.buttons.min.js" type="text/javascript"></script>
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
                            $.post('<?php echo base_url();?>hr/employee_exit/delete_exit',{itemgrps:itemgrps}, function(data){
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