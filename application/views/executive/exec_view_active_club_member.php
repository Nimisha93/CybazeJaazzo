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
Active Club Member
    
</div><br><br>
<div class="card-content">
<!--    <h4 class="card-title">Commision</h4>-->
<div class="toolbar">
    <!--        Here you can write extra buttons/actions for the toolbar              -->
</div>
<div class="material-datatables">
<div class="row">
                                <div class="col-sm-offset-7 col-sm-3">
                                    <label class="pull-right">Search:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control search" name="search" id="search" placeholder="" style="margin-top: -20px">
                                </div>
                            </div><br>
<table id="" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead>
<tr>
 <th>No</th>

    <th>Name</th>
    <th>Email</th>
    <th>Club Type</th>
    <th>Contact No</th>
    
</tr>
</thead>

<tbody>
<!-- 
<?php
/*print_r($partner['partner']);exit();*/

 foreach($member['member'] as $key=>$type){
 
    ?>
<tr>
    <td><?php echo $type['name'];?></td>
    <td><?php echo $type['email'];?></td>

   <td><?php echo $type['un'];?>,<?php echo $type['fix'];?></td>
    <td><?php echo $type['phone'];?></td>
   
   </tr> 

<?php } ?>-->

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
            function ucwords(str,force){
              str=force ? str.toLowerCase() : str;  
              return str.replace(/(\b)([a-zA-Z])/g,
                       function(firstLetter){
                        return   firstLetter.toUpperCase();
               });
            }
                $(document).ready(function(){
                    var base_url = "<?php echo base_url(); ?>";
                    function load_demo(index) {
                        index = index || 0;
                        var search = $('#search').val();
                        $.post(base_url + "view_active_club_member/" + index, { ajax: true,search:search}, function(data) {
                            
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

                                        '<td>'+ucwords(data2[i].un,true)+'<br>'+ucwords(data2[i].fix,true)+'</td>'+
                                        
                                      
                                        '<td>'+data2[i].phone+'</td>'+
                                        
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