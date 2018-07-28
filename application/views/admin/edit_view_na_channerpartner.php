<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">

</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= $status; ?> CHANNEL PARTNERS<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                            <li><a class="btn btn-primary editsub"  style="background-color:#162b52"  href="<?php echo base_url();?>partner"><i class="fa fa-user-plus"></i></a> </li>
                            <li><a type="button" class="btn btn-danger fllft del_btn" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                           </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <table id="example" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    
                                    <th>Address</th>
                                    <th></th>
                                    <th></th>


                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                   
                                    <th>Address</th>
                                    <td></td>
                                    <td></td>

                                </tr>
                                </tfoot>
                                <tbody style=" height:100px;overflow:scroll">
                                <?php foreach($partner['partner'] as $partner){?>
                                <tr>
                                    <td class="titleclass"><input type="hidden" value="<?php echo $partner['cp_id'];?>" class="hiddentype_id">
                                        <input type="hidden" value="<?php echo $partner['email'];?>" class="email">
                                        <input type="hidden" value="<?php echo $partner['otp'];?>" class="otp"><?php echo $partner['name'];?></td>
                                    <td class="descrip"><?php echo $partner['phone'];?></td>
                                    <td class="descrip"><?php echo $partner['email'];?></td>
                                    
                                    <td class="descrip"><?php echo $partner['address'];?></td>
                                    
                                    <td>
                                    <?php
if (has_priv('approve_cp')) {                                     
                                     if($partner['status']=='NOT_APPROVED') { ?>
                                        <button type="button" class="btn btn-danger approve_cp">Approve </button>
                                     <?php  
                                     }
                                 }
                                     ?>   
                                    </td>
                                     <td><a href="<?php echo base_url();?>admin/home/get_channelpartner_byid/<?php echo $partner['cp_id'];?>"><button type="button" class="btn btn-primary type_sub"><i class="fa fa-pencil"></i> </button></a>
                                       
                                        <input type="checkbox" name="" value="<?php echo $partner['cp_id'];?>" class="chck_item_id">
                                     </td>
                                   

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

    <!--************************row  end******************************************************************* -->


<div id="notifications"></div>

</div>
</div>
</div>
</div>
</div>
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
 
    $(document).on('click','.approve_cp',function(){
        var cur=$(this);
        var hiddentypeid=cur.parent().parent().find('.hiddentype_id').val();
        var email=cur.parent().parent().find('.email').val();
        var otp=cur.parent().parent().find('.otp').val();
      
                    $('.body_blur').show();
                    $.post('<?php echo base_url();?>admin/Home/approve_cp/',{id:hiddentypeid,email:email,otp:otp}, function(data){
                        $('.body_blur').hide();
                        if(data.status){
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Approved Channel Partner </div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                        }else{
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Database Error</div></div>';
                                var effect='fadeInRight';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                                                    }
                    },'json');
                          

                })
            });
</script>
<script>
    $(document).ready(function(){
        
        
        

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
                        $.post('<?php echo base_url();?>admin/Home/delete_partnerbyid/',{chck_item_id:chck_item_id}, function(data){
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
                                //refresh_close();
                                $('.close').click(function(){
                                    $(this).parent().fadeOut(1000);
                                });
                            }
                        },'json');
                    }
                })
            }
        });
          
    });
    
</script>

<script>

$(document).ready(function() {
    var table = $('#example').DataTable( {
        fixedHeader: {
            header: true,
            footer: true,
			
        }
    } );
	
} );
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
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

<!-- Datatables -->

<!--============new customer popup start here=================-->


</body>
</html>





























