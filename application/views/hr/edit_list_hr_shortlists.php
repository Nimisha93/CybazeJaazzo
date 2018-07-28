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
                        <h2>Shortlists <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
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
                                      
                                        <th>job Name</th>
                                        <th>No: Posts</th>
                                        
                                        <th>Candid Name</th>
                                       

                                        <th class="HideColumn">Added On</th>
                                        <th>Status</th>
                                        <!-- <th>Change Status</th>  -->
                               </tr>
                                
                                    </thead>
                                    
                     
                                    
                                    <tbody>

                                    <?php foreach ($shortlists as $key => $shortlist) { ?>
                                        <tr>
                                            <input type="hidden" name="shl_id" class="shl_id" value="<?= $shortlist['cd_id'];?>">
                                            <input type="hidden" name="po_id" class="po_id" value="<?= $shortlist['po_id'];?>">
                                            <input type="hidden" name="posts" class="posts" value="<?= $shortlist['posts'];?>">
                                            <input type="hidden" name="shortlists_status" class="shortlists_status" value="<?= $shortlist['shortlists_status'];?>">
                                            <td><?= $key+1;?></td>
                                           
                                            <td><?= $shortlist['title'];?></td>
                                            <td><?= $shortlist['posts'];?></td>
                                         
                                            <td><?= $shortlist['name'];?></td>
                                            

                                            <td><?= date('d-M-Y',strtotime($shortlist['added_on']));?></td>
                                            <!-- <td><?php if($shortlist['status']==1){echo "Short Listed";} else{echo "Selected";} ?></td> -->

                                            <?php if($shortlist['shortlists_status']==1) { ?>
                                            
                                            <td><a class="btn btn-success pull-left select" > <i class="fa fa-edit"></i> Select</a></td>
                                            <?php } ?>

                                            <?php if($shortlist['shortlists_status']!=1) { ?><td><button type="button" name=""  class="btn btn-info  pull-left">Selected</button></td><?php } ?>

                                            
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
	// $(document).on('click','.change_status',function(e){

 
 //            e.preventDefault();
 
 //            var cur = $(this);
 //            var posts = cur.parent().parent().find('.posts').val();
 //            var shl_id = cur.parent().parent().find('.shl_id').val();
 //            var po_id = cur.parent().parent().find('.po_id').val();
 //            var shortlists = cur.parent().parent().find('.shortlists_status').val();
 //            $('.body_blur').show();
 //            $.post('<?php echo base_url();?>hr/Recruitment/candids_change_status/', {shl_id:shl_id,po_id:po_id,shortlists:shortlists,posts:posts}, function(data){
 //                $('.body_blur').hide();
 //                if(data.status){
 //                    $.toast("Successfully changed status", {'width' :500});
 //                   //location.reload();
 //                   setTimeout(function(){
 //                         location.reload();
 //                        },2000);
 //                } else{
 //                    $.toast(data.reason, {'width': 500});
                    
 //                }
 //            },'json');

 //        });
   $(document).on('click','.select',function(e){

 
            e.preventDefault();
 
            var cur = $(this);
            var shl_id = cur.parent().parent().find('.shl_id').val();
            var po_id = cur.parent().parent().find('.po_id').val();
            var posts = cur.parent().parent().find('.posts').val();
            $('.body_blur').show();
            $.post('<?php echo base_url();?>hr/Recruitment/candids_select/', {shl_id:shl_id,po_id:po_id,posts:posts}, function(data){
                $('.body_blur').hide();
                if(data.status){
                  



                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Selected  Candidate</div></div>';
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
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color: black;font-size=26px;"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();
                    
                }
            },'json');

        });

} );

</script>

  
</body>
</html>