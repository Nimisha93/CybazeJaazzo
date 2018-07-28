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
Pending Club Member
    
</div><br><br>
<div class="card-content">
<!--    <h4 class="card-title">Commision</h4>-->
<div class="toolbar">
    <!--        Here you can write extra buttons/actions for the toolbar              -->
</div>
<div class="material-datatables">
 <div class="col-sm-offset-7 col-sm-3">
                                    <label class="pull-right">Search:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control search" name="search" id="search" placeholder="" style="margin-top: -20px">
                                </div>
                            </div><br>
<a type="button" class="btn btn-primary fllft del_btn" style="background-color:#bf0b0b ;float:right;color: #fff; padding: 10px;" ><i class="fa fa-trash" aria-hidden="true"></i></a>
<table id="" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead>
<tr>
<th>No</th>
    <th>Name</th>
    <th>Email</th>
    <th>Club Type</th>
    <th>Contact No</th>
    
    <th class="disabled-sorting text-right">Actions</th>
</tr>
</thead>

<tbody>

<!-- <?php
/*print_r($partner['partner']);exit();*/

 foreach($member['member'] as $key=>$type){
 
    ?>
<tr>
    <td><?php echo $type['name'];?></td>
    <td><?php echo $type['email'];?></td>
   <td><?php echo $type['un'];?>,<?php echo $type['fix'];?></td>
    <td><?php echo $type['phone'];?></td>
    <td class="text-right">
<?php $status=$type['status'];

if($status=='notapproved'){?>
        <a href="<?php echo base_url();?>admin/executives/update_club_member/<?php echo $type['id']; ?>" class="btn btn-simple btn-info btn-icon edit"><i class="material-icons">edit</i></a>
         <input type="checkbox" name="" value="<?php echo $type['id'];?>" class="chck_grp_item">
   
    </td>
<?php }
} ?> -->

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


 <script src="<?php echo base_url(); ?>assets/admin/js/paging.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    var base_url = "<?php echo base_url(); ?>";
                    function load_demo(index) {
                        index = index || 0;
                        var search = $('#search').val();
                        $.post(base_url + "view_club_member/" + index, { ajax: true,search:search}, function(data) {
                            
                            $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';
                            if(data.status){
                                var data1 = data.data;
                                var data2 =data1.member;
                               
                                for(var i = 0; i< data2.length; i++){
                                    var cur_index=parseInt(index);

                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                                    tr += '<tr>'+
                                    '<input type="hidden" name="id" class="id" value="'+data2[i].id+'">'+
                                        '<td>'+sl_no+'</td>'+
                                      
                                        '<td>'+data2[i].name+'</td>'+
                                        '<td>'+data2[i].email+'</td>'+

                                       
                                        
                                        '<td>'+data2[i].un+',' +data2[i].fix+'</td>'+
                                        '<td>'+data2[i].phone+'</td>'+
                                        '<td>';
                                       if(data2[i].status=='notapproved'){
                                        tr +='<a href="<?php echo base_url();?>admin/executives/update_club_member/'+data2[i].id+'" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a><input type="checkbox" name="" value="<?php echo $type['id'];?>" class="chck_grp_item"></td>';
                                        } 
                                        tr +='</tr>';
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
                        $.post('<?php echo base_url();?>admin/executives/delete_club_member',{itemgrps:itemgrps}, function(data){
                            $('.body_blur').hide();
                            if(data.status){
                              
                                     swal("Success!", "Club Agent Delete Successfully.", "success",{timer: 1500});
                                     setTimeout(function(){
                                    location.reload();
                                    }, 1500);
                                   

                                }else{
                                    var regex = /(<([^>]+)>)/ig;
                                    var body = data.reason;
                                    var result = body.replace(regex, "");
                                    swal("Warning!", result, "error");
                                }
                        },'json');
                }
            })
        }
    });        

</script>

</body>

</html>