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
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Job Posts<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                         <!--    <li><a class="btn btn-success " href="<?php echo base_url(); ?>hr/Recruitment/new_posts" data-toggle="tooltip" title="" data-original-title="New Job Post"><i class="fa fa-user_plus"></i></a></li> -->




                          <li>

                       <a href="<?php echo base_url();?>new_post" data-original-title="Add new" class="btn btn-success" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
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
                                <table id="example" class="display table-bordered table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                        <th>No</th>
                                        <th>Job Title</th>
<!--                                         <th >Job Type</th>
 -->                                        <th>Closing Date</th>
                                        <th>No: Posts</th>

                                        <th class="HideColumn">Branch</th>
                                        <th class="HideColumn">Department</th>
                                        <th class="HideColumn">Age Range</th>
                                        <th class="HideColumn">Salary Range</th>
                                        <th>Qualification</th>
                                        <th >Experience</th>
                                       <!--  <th >Description</th> -->
                                       
                                        <th>Status</th>
                                       
                                       
                                        <th>Action</th>


                                    </thead>
                               
                                    
                                    <tbody>

                                   

                                    <?php $to=' to '; foreach ($posts as $key => $post) { ?>
                                        <tr>
                                            <input type="hidden" name="po_id" class="pos_id" value="<?= $post['po_id'];?>">
                                            <input type="hidden" name="status" class="status" value="<?= $post['status'];?>">
                                            <td><?= $key+1;?></td>
                                            <td><?= $post['title'];?></td>
                                           <!--  <td><?= $post['type'];?></td> -->
                                           
                                            <?php

                                            $close_date= $post['closing'];
                                          
                                            $date1=convert_ui_date($close_date);

                                           

                                            ?>
                                                

                                                <td><?= $date1;?></td>
                                           
                                            <td><?= $post['posts'];?></td>

                                            <td><?= $post['st_name'];?></td>
                                            <td><?= $post['dep'];?></td>
                                            <td><?= $post['age_st']." ".$to." ".$post['age_en'];?></td>
                                            <td><?= $post['salary_st']." ".$to." ".$post['salary_en'];?></td>
                                            <td><?= $post['qualification'];?></td>
                                            <td><?= $post['exp'];?></td>
                                            <!-- <td><?= $post['desp'];?></td> -->
                                           
                                            <td><?= $post['status'];?><a class="btn btn-info pull-right change_status" > <i class="fa fa-edit"></i> Change Status</a></td>
                                            
                                           
                                            <td>
                                                <a class="btn btn-primary pull-left" href="<?php echo base_url();?>posts_edit/<?php echo $post['po_id'];?>"> <i class="fa fa-pencil"></i></a>
                                              
                                               <input type="checkbox" name="" value="<?php echo $post['po_id'];?>" class="chck_grp_item">
                                            </td>
                                        </tr>
                                    <?php   } ?>
                                    <!-- </form> -->


                                    </tbody>
                                    <tfoot>

                                    </tfoot>
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
    
      $(document).on('click','.change_status',function(e){


            e.preventDefault();


            var cur = $(this);
            var pos_id = cur.parent().parent().find('.pos_id').val();
            var status = cur.parent().parent().find('.status').val()
            $('.body_blur').show();
            $.post('<?php echo base_url();?>hr/Recruitment/posts_status/', {pos_id:pos_id,status:status}, function(data){
                $('.body_blur').hide();
                if(data.status){
                  var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated Status</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        location.reload();
                    }, 2000);
                } else{
                    $('.body_blur').hide();
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    
                }
            },'json');

        });
    // $(document).on('click','.del_btn',function(){
    
    //     var cur=$(this);

    //     var itemgrps = [];
    //     $('.chck_grp_item').each(function () {
    //         var cur_this = $(this);
    //         var cur_val = $(this).val();
    //         if(cur_this.is(":checked")){
    //             itemgrps.push(cur_val);
    //         }

    //     });
       
    //     if(itemgrps.length > 0){
    //         noty({
    //         text: 'Do you want to continue?',
    //         type: 'warning',
    //         buttons: [
    //             {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

    //                 $noty.close();


    //                     $('.body_blur').show();
    //                     $.post('<?php echo base_url();?>hr/Recruitment/posts_delete/',{itemgrps:itemgrps}, function(data){
    //                         $('.body_blur').hide();
    //                         if(data.status){
    //                             $.toast('Deleted successfully', {'width': 500});

    //                             setTimeout(function(){
    //                                 location.reload();
    //                             }, 1000);



    //                             }else{
    //                                 $.toast(data.reason, {'width': 500});
    //                             }
    //                     },'json');
    //                 }


    //             },
    //             {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
    //                 $noty.close();

    //             }
    //             }
    //         ]
    //     });
    //     }
    // });  


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
                            $.post('<?php echo base_url();?>hr/Recruitment/posts_delete/',{itemgrps:itemgrps}, function(data){
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