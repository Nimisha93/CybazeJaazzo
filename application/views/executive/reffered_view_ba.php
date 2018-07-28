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
View Jaazzo Store
    
</div><br><br>
<div class="card-content">
<!--    <h4 class="card-title">Commision</h4>-->
<div class="toolbar">
    <!--        Here you can write extra buttons/actions for the toolbar              -->
</div>
 <a type="button" class="btn btn-danger fllft del_btn" style="background-color:#bf0b0b ;float:right;color: #fff; padding: 10px;"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    
<div class="material-datatables">                   
<table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead>
<tr>
    <th>No</th>
    <th>Name</th>
    <th>Email</th>
    <th>Mobile No</th>

   <th style="width: 80px">Action</th> 
</tr>
</tfoot>
<tbody>

<?php
/*print_r($partner['partner']);exit();*/

 foreach($viewba as $key=>$type){
 
    ?>
<tr>
    <td><?php echo $key+1;?></td>
    <td><?php echo $type['name'];?></td>
    <td><?php echo $type['email'];?></td>

    <td><?php echo $type['mobil_no'];?></td>

   
    <td class="text-right">

        <a href="<?php echo base_url();?>admin/Executives/exec_get_refer_ba_byid/<?php echo $type['id'];?>" class="btn btn-simple btn-info btn-icon edit" style="    padding: 3px;" ><i class="fa fa-user-plus"></i></a>
         <input type="checkbox" name="" value="<?php echo $type['id'];?>" class="chck_grp_item">
    </td>
</tr>
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

 <?php echo $footer; ?>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.datatables.js"></script>

<script>
     
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
                            $.post('<?php echo base_url();?>admin/executives/delete_exectives',{itemgrps:itemgrps}, function(data){
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