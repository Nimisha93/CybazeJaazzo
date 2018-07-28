 <?php echo $header; ?>

<body>
<div class="wrapper">

 <?php echo $sidebar; ?>

<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header card-header-icon" data-background-color="purple">
 Pending Channel Partner
    
</div><br><br>
<div class="card-content">
<!--    <h4 class="card-title">Commision</h4>-->
<div class="toolbar">
    <!--        Here you can write extra buttons/actions for the toolbar              -->
</div>
<div class="material-datatables">
<a type="button" class="btn btn-primary fllft del_btn" style="background-color:#bf0b0b ;float:right;color: #fff; padding: 10px;" ><i class="fa fa-trash" aria-hidden="true"></i></a>
<table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead>
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Contact No</th>
    <th>Alternative No</th>
    <th class="disabled-sorting text-right">Actions</th>
</tr>
</thead>
<tfoot>

<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Contact No</th>
    <th>Alternative No</th>
    <th class="text-right">Actions</th>
</tr>
</tfoot>
<tbody>

<?php
/*print_r($partner['partner']);exit();*/

 foreach($partner['partner'] as $key=>$type){
 
    ?>
<tr>
    <td><?php echo $type['name'];?></td>
    <td><?php echo $type['email'];?></td>
    <td><?php echo $type['phone'];?></td>
    <td><?php echo $type['phone2'];?></td>
    
    <td class="text-right">

        <a href="<?php echo base_url();?>admin/executives/update_channel_partner/<?php echo $type['cp_id']; ?>" class="btn btn-simple btn-info btn-icon edit"><i class="material-icons">edit</i></a>
         <input type="checkbox" name="" value="<?php echo $type['cp_id'];?>" class="chck_item_id">
    </td>
<?php } ?>

</tbody>
</table>
</div>
</div>
<!-- end content-->
</div>
<!--  end card  -->
</div>
<!-- end col-md-12 -->
</div>
<!-- end row -->
</div>


</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
 <?php echo $footer; ?>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.datatables.js"></script>
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
            console.log(chck_item_id);
            if(chck_item_id.length > 0){
                $('body').alertBox({
                    title: 'Are You Sure?',
                    lTxt: 'Back',
                    lCallback: function(){
                      
                    },
                    rTxt: 'Okey',
                    rCallback: function(){
                        $('.body_blur').show();
                        $.post('<?php echo base_url();?>admin/executives/delete_partnerbyid/',{chck_item_id:chck_item_id}, function(data){
                            $('.body_blur').hide();
                            if(data.status){
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted </div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
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


</body>

</html>