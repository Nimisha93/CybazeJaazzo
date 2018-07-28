   <?php echo $header; ?>

<body>
<div class="wrapper">

   <?php echo $sidebar; ?>

<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-sm-offset-7 col-sm-3">
    <label class="pull-right">Search:</label>
</div>
<div class="col-sm-2">
    <input type="text" class="form-control search" name="search" id="search" placeholder="" style="margin-top: -20px">
</div>
</div><br>
<div class="col-md-12">
<div class="card">
<div class="card-header card-header-icon" data-background-color="purple">
   Clubmember Refered Channel Partner

</div><br><br>
<div class="card-content">
<!--    <h4 class="card-title">Commision</h4>-->
<div class="toolbar">
    <!--        Here you can write extra buttons/actions for the toolbar              -->
</div>
<div class="material-datatables">
<table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead>
<tr>
    <th>No</th>
    <th>Name</th>
    <th>Email</th>
    <th>Contact No</th>
    <th>Owner</th>
    <th>PAN No</th>
    
    <th class="disabled-sorting text-right">Actions</th>
</tr>
</thead>
<!-- <tfoot>
<tr>
    <th>No</th>
    <th>Name</th>
    <th>Email</th>
    <th>Contact No</th>
    <th>Contact Person</th>
    <th>Contact Person Email</th>
    <th>Contact Person No</th>
    <th class="text-right">Actions</th>
</tr>
</tfoot> -->
<tbody>
<!-- <?php
/*print_r($partner['partner']);exit();*/

 foreach($partner['partner'] as $key=>$type){
 
    ?>
<tr>
    <td><?php echo $key+1;?></td>
    <td><?php echo $type['name'];?></td>
    <td><?php echo $type['email'];?></td>
    <td><?php echo $type['phone'];?></td>
    <td><?php echo $type['cname'];?></td>
    <td><?php echo $type['c_email'];?></td>
    <td><?php echo $type['c_mobile'];?></td>
    
    <td class="text-right">


        <a href="<?php echo base_url();?>admin/executives/refer_cp_add/<?php echo $type['cp_id']; ?>" class="btn btn-simple btn-info btn-icon edit"><i class="fa fa-user-plus"></i></a>
         <input type="checkbox" name="" value="<?php echo $type['cp_id'];?>" class="chck_grp_item">
    </td>
<?php } ?> -->



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
 <script src="<?php echo base_url(); ?>assets/admin/js/paging.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){

                    var base_url = "<?php echo base_url(); ?>";
                    function load_demo(index) {
                        index = index || 0;
                        var search = $('#search').val();
                        $.post(base_url + "club_member_channel_partner/" + index, { ajax: true,search:search}, function(data) {
                            $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';
                           
                            if(data.status){
                                var data1 = data.data;
                                var data2 =data1.partner;
                               
                                for(var i = 0; i< data2.length; i++){
                                    var cur_index=parseInt(index);
                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                                    tr += '<tr>'+
                                    '<input type="hidden" name="id" class="id" value="'+data2[i].id+'">'+
                                        '<td>'+sl_no+'</td>'+
                                      
                                        '<td>'+data2[i].name+'</td>'+
                                        '<td>'+data2[i].email+'</td>'+

                                       
                                        
                                        '<td>'+data2[i].phone+'</td>'+
                                        '<td>'+data2[i].owner_name+'</td>'+
                                        '<td>'+data2[i].pan+'</td>'+
                                        
                                       '<td>' +'<a href="<?php echo base_url();?>admin/executives/refer_cp_add/'+data2[i].cp_id+'" class="btn btn-simple btn-warning btn-icon add"><i class="material-icons">add</i></a></td>'+
                                        '</tr>';
                                }


                                $('tbody').html(tr);
                                $('#search').val(data.search);
                                // pagination
                                $('#pagination').html(data.pagination);

                            }else{
                                 tr += '<tr>'+
                                        '<td colspan="4" style="text-align:center">No Data Found</td>'+
                                        '</tr>';
                                $('tbody').html(tr);
                            }
                        }, "json");
                    }
                    //calling the function
                    load_demo();
                    //pagination update
                    $('#pagination').on('click', '.page_test a', function(e) {
                        e.preventDefault();
                        //grab the last paramter from url
                        var link = $(this).attr("href").split(/\//g).pop();
                        load_demo(link);
                        return false;
                    });
                    $("#search").keyup(function(){
                        load_demo();
                    });
                });








                
            </script>

</body>

</html>