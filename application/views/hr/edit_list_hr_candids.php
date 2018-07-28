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
                <div class="x_panel" style="overflow-x: auto">
                    <div class="x_title">
                        <h2>Candidates <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                           


                          <li>

                       <a href="<?php echo base_url();?>add_candidates" data-original-title="Add new" class="btn btn-success" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                    </li>
                            <li>
                               <a type="button" class="btn  fllft del_btn btn-danger" style=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div  style="overflow-x: auto;min-width: 1200px">

                            <!-- ========================== calendar which hide previous date===================================================-->

                                <table id="example" class="table display table-bordered table-striped responsive-utilities">
                                    <thead>

                                      <tr class="tablbg">

                                        <th>No</th>
                                       
                                        <th>Name</th>
                                        <th style="width: 80px" class="HideColumn">DOB</th>
                                        <th class="HideColumn">Gender</th>
                                        
<!--  <th class="HideColumn">Address</th>
 --> 
<!--                                         <th class="HideColumn">Pin</th>
 -->                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th class="HideColumn">Qualification</th>
                                        <th class="HideColumn">Experience</th>
                                        <th>Quick Action</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                   

                                    </tr>
                                  
                                    </thead>
                                    
                            
                                    
                                    <tbody>

                                    <?php foreach ($candids as $key => $candid) { ?>
                                        <tr>
                                            <input type="hidden" name="cnd_id" class="cnd_id" value="<?= $candid['cd_id'];?>">
                                            <td><?= $key+1;?></td>
                                          
                                            <td><?= $candid['name'];?></td>
                                            <td><?= $candid['dob'];?></td>
                                            <td><?= $candid['gender'];?></td>
                                           
<!--   <td><?= $candid['address'];?></td>
 --><!--                                             <td><?= $candid['pin'];?></td>
 -->                                            <td><?= $candid['email'];?></td>
                                            <td><?= $candid['phone'];?></td>
                                            <td><?= $candid['qualification'];?></td>
                                            <td><?= $candid['exp'];?></td>

                                             <td>  <select name="status" class="form-control status"  id="status" >
                                            <option  <?php echo $candid['shortlists_status']==1 ? "selected": ""?> value="1">Shortlist</option>
                                            <option  <?php echo $candid['shortlists_status']==0 ? "selected": ""?> value="0">Pending</option>
                                            <option <?php echo $candid['shortlists_status']==4 ? "selected": ""?> value="4">Selected</option>
                                            </select>
                                        
                                            </td>
                                            <?php if($candid['shortlists_status']==0) { ?>
                                            
                                            <td><a class="btn btn-danger pull-right shortlist" > <i class="fa fa-edit"></i> Shortlist</a></td>
                                            <?php }
                                            else if($candid['shortlists_status']==1) { ?>
                                            <td><button type="button" name="" class="btn btn-info">Shortlisted</button></td><?php }
                                             else if($candid['shortlists_status']==4) { ?>          
                                            <td><button type="button" name="" class="btn btn-info">Selected</button></td><?php } ?>
                                            <td><a class="btn btn-primary" href="<?php echo base_url();?>hr/Recruitment/edit_candidate/<?php echo $candid['cd_id'];?>"> <i class="fa fa-pencil"></i></a>
                                              <input type="checkbox" name="" value="<?php echo $candid['cd_id'];?>" class="chck_grp_item">      
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



<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>


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
    function popIt(url) {
        var leftPos = screen.width - 720;
        ref = window.open(url,"thePop","menubar=1,resizable=1,scrollbars=1,status=1,height=400,width=710,left="+leftPos+",top=0")
        ref.focus();
    }

    function killPopUp() {
        if(!ref.closed) {
            ref.close();
        }
    }
</script>
<script type="text/javascript">
        $(document).on('click','.shortlist',function(e){


            e.preventDefault();
 
            var cur = $(this);
            var cnd_id = cur.parent().parent().find('.cnd_id').val();
           
            $('.body_blur').show();
            $.post('<?php echo base_url();?>hr/Recruitment/candids_shortlist/', {cnd_id:cnd_id}, function(data){
                $('.body_blur').hide();
                if(data.status){
                   


                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Candidate shortlisted successfully</div></div>';
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
         $(document).on('change', '.status', function(){
            var cur = $(this);
            var status = cur.val();
            var emp_id = cur.parent().parent().find('.cnd_id').val();
    
            $('.body_blur').show();
            $.post('<?= base_url();?>hr/Recruitment/update_status_candidates/'+emp_id, {status : status}, function(data){
                $('.body_blur').hide();
                if(data.status)
                {
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Candidate Status Updated Successfully</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        location.reload();
                    }, 2000);
           } else{


                 $('.body_blur').hide();
                    // var regex = /(<([^>]+)>)/ig;
                    // var body = data.reason;
                    // var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color: black;font-size=26px;"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Updating Status Failed</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();
               // alert(" Updating Status Failed");
                               }
                    },'json');
               
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
                            $.post('<?php echo base_url();?>hr/Recruitment/candids_delete/',{itemgrps:itemgrps}, function(data){
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