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

                        <h2> Resignations <small></small></h2>

                        <ul class="nav navbar-right panel_toolbox">
                           <li>

                       <a href="<?php echo base_url();?>add_resignation" data-original-title="Add new" class="btn btn-success" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                    </li>
                            <li>
                                <a data-original-title="Delete" class="btn  del_btn btn-danger"><i class="fa fa-trash"></i></a>

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

                                        <th style="min-width:150px">Resigning Employee</th>



                                        <th  style="min-width:80px">Notice Date</th>

                                        <th  style="min-width:80px">Resignation Date</th>

                                        <th>Reason</th>


                                        <th class="HideColumn">Additional Information</th>
                                                                                <th>Status</th>


                                        <th>Action</th>





                                    </tr>


                                    </thead>

                                    

                                  

                                    

                                    <tbody>



                                    <?php foreach ($res as $key=>$value) { ?>



                                         <tr><!-- <input type="hidden" id="res_hidden" name="res_hidden" class="res_hidden" value="<?php echo $employee['employee_id'];?>"> -->

                                        <tr>

                                            <td><?php echo $key+1;?></td>

                                            <td><?php echo $value['name'];?>(<?php echo $value['employee_code'];?>)</td>

                                            <?php

                                            $dater= $value['notice_date'];

                                            $date1=convert_ui_date($dater);



                                            ?>

                                            <td><?= $date1;?></td>

                                            <?php

                                            $dateno= $value['resignation_date'];

                                            $date12=convert_ui_date($dateno);



                                            ?>

                                            <td><?= $date12;?></td>

                                            <td><?php echo $value['reason'];?></td>



                                            <td><?php echo $value['additional_info'];?></td>
                                                                          <td><?php echo $value['stat'];?></td>






                                            <td><input type="hidden" id="resig_hidden" name="resig_hidden" class="resig_hidden" value="<?php echo $value['id'];?>">

                                                <a class="btn btn-primary" href="<?php echo base_url();?>update_resignation/<?php echo $value['id'];?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                    <input type="checkbox" class="chck_grp_item" value="<?php echo $value['id'];?>">

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
                            $.post('<?php echo base_url();?>hr/Resignation/delete_resignations/',{itemgrps:itemgrps}, function(data){
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






<!-- 
<script type="text/javascript">

    $(document).on('click', '.del_resig', function(){

        var cur = $(this);

        var resi_id  = cur.parent().find('.resig_hidden').val();

        noty({

            text: 'Do you want to continue?',

            type: 'warning',

            buttons: [

                {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {



                    // this = button element

                    // $noty = $noty element



                    $noty.close();

                    $('.body_blur').show();

                    $.post('<?php echo base_url();?>hr/Resignation/delete_resignations/'+resi_id, function(data){

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

</script> -->

</body>

</html>