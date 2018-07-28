<?= $header; ?>
<style type="text/css">
    .card img {
    width: 100px;
    height: auto;
}
</style>
<body>
<div class="wrapper">

<?= $sidebar; ?>

<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header card-header-icon" data-background-color="purple">
    View Products
</div>
<div class="card-content">
<br><br>
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
<table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead>

<tr>
<th>No</th>
    <th>Category</th>
    <th>Product</th>
    <th>Description</th>
    
    <th>Model</th>
    <th>Actual Cost</th>
    <th>Special Price</th>
    <th class="disabled-sorting text-right">Actions</th>
</tr>
</thead>

<tbody>


</tbody>
<tfoot>
                                        <td colspan="6">
                                            <div class="pull-right" id="pagination"></div>
                                        </td>
                                    </tfoot>
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
<?= $footer; ?>



<script src="<?php echo base_url(); ?>assets/admin/js/paging.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            $.post(base_url + "cp_product_list/" + index, { ajax: true,search:search}, function(data) {
                console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                var tr = '';
                if(data.status){
                    var data11 = data.data;

                    var data1=data11.produ;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        tr += '<tr>'+
        '<input type="hidden" value="'+data1[i].id+'" class="hiddentype_id">'+

                            '<td>'+sl_no+'</td>'+
                           '<td>'+data1[i].title+'</td>'+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].description+'</td>'+

                           
                            
                            '<td>'+data1[i].model+'</td>'+
                            '<td>'+data1[i].actual_cost+'</td>'+
                            '<td>'+data1[i].special_prize+'</td>'+
                            '<td><a href="<?php echo base_url();?>admin/Channel_partner/get_product_byid/'+data1[i].id+'" class="btn btn-simple btn-info btn-icon edit"><i class="material-icons">edit</i><div class="ripple-container"></div></a><a href="#" class="btn btn-simple btn-danger btn-icon remove"><i class="material-icons">close</i></a></td>'+
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


<script type="text/javascript">
    $(document).ready(function() {
       

        // Delete a record
        $(document).on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            var cur=$(this);
            var hiddentypeid=cur.parent().parent().find('.hiddentype_id').val();
            $('.body_blur').show();
            $.post('<?php echo base_url();?>admin/Channel_partner/delete_productbyid/'+hiddentypeid, function(data){
                $('.body_blur').hide();
                if(data.status){
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted product </div></div>';
                            var effect='zoomIn';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                    table.row($tr).remove().draw();
                    
                }else{
                   var regex = /(<([^>]+)>)/ig;
                        var body = data.reason;
                        var result = body.replace(regex, "");
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                        var effect='fadeInRight';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        $('.close').click(function(){
                                    $(this).parent().fadeOut(1000);
                        });
                }
            },'json');
            
            e.preventDefault();
        });

        
        $('.card .material-datatables label').addClass('form-group');

        $(document).on('click','.type_delete',function(){
            var cur=$(this);
            var hiddentypeid=cur.parent().parent().find('.hiddentype_id').val();
            noty({
                text: 'Do you want to continue?',
                type: 'warning',
                buttons: [
                    {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                        // this = button element
                        // $noty = $noty element

                        $noty.close();
                        $('.body_blur').show();
                        $.post('<?php echo base_url();?>admin/Product/delete_productbyid/'+hiddentypeid, function(data){
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

        })
    });
</script>
</body>

</html>