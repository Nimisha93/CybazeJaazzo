<?= $header; ?>
<style type="text/css">
    .card img {
    width: 100px;s
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
    View Commissions
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
<th>SI no</th>
    <th>Category</th>
    <th>Commission(%)</th>
    <th>Requested Commission(%)</th>
    <th class="disabled-sorting text-right">Actions</th>
</tr>
</thead>

<tbody>
<!-- 
<?php foreach($data as $key => $cm){?>
    <tr>
        <input type="hidden" name="id" class="id" value="<?php echo $cm['id'];?>">
        <td class="title"><?php echo $cm['category_title'];?></td>
        <td class="percentage"><?php echo $cm['percentage'];?></td>
        <td class="r_percentage"><?php echo $cm['requested_commission'];?></td>
        <td class="text-right"><a href="#" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
        <a href="#" class="btn btn-simple btn-danger btn-icon remove"><i class="material-icons">close</i></a></td>
    </tr>
<?php }?> -->
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

<?= $footer; ?>
<div class="modal fade" id="agree" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-notice">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    <h5 class="modal-title" id="myModalLabel">Change Commission</h5>
                </div>
                <div class="modal-body">
                    <div class="instruction">
                        <div class="row">
                            <form method="post" id="amt_forms" class="amt_forms" name="amt_forms" action="<?php echo base_url();?>admin/Channel_partner/new_commission">


                                <div class="col-md-4">

                                    <div class="input-group">
                                           
                                        <div class="form-group label-floating">
                                            <label class="">Category <span class="cat"></span></label>
                                
                                           <input type="text" class="form-control" name="new_title" id="new_title" data-rule-required = "true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="input-group">
                                           
                                        <div class="form-group label-floating">
                                            <label class="">New commission <span class="cat"></span></label>
                                            <input type="hidden" placeholder="" class="form-control" id="hidden_id" name="hidden_id">
                                            <input type="text" class="form-control" name="new_commission" id="new_commission" onKeyPress="return isFloatKey(event)"  data-rule-max="100" data-rule-min="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- <input type="button" class="btn btn-fill btn-rose amt_sub" id="otp_sub" value="Submit"> -->
                                    <button type="submit" class="btn btn-fill btn-rose prosubmit" name="prosubmit" id="prosubmit">Submit</button>
                                   
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

<div id="notifications"></div><input type="hidden" id="position" value="center">











<script type="text/javascript">
    
     function isFloatKey(e){
     var charCode = (e.which) ? e.which : e.keyCode
    if ((charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)  && (charCode != 32) && (charCode != 0) && (charCode != 8)   )
        return false;
    return true;
  }

</script>












<script type="text/javascript">
    $(document).ready(function() {


        $(document).on('click','.edit',function(){
            var cur=$(this);
            var id = cur.parent().parent().find('.id').val();
            var percentage = cur.parent().parent().find('.percentage').text();
            var title = cur.parent().parent().find('.title').text();
            $("#agree").modal('show');
            $('#new_title').val(title);
            $('#hidden_id').val(id);
    });



        // $('#datatables').DataTable({
        //     "pagingType": "full_numbers",
        //     "lengthMenu": [
        //         [10, 25, 50, -1],
        //         [10, 25, 50, "All"]
        //     ],
        //     responsive: true,
        //     language: {
        //         search: "_INPUT_",
        //         searchPlaceholder: "Search records",
        //     }

        // });


        // var table = $('#datatables').DataTable();

        // // Edit record
        // table.on('click', '.edit', function() {
        //     $tr = $(this).closest('tr');

        //     var data = table.row($tr).data();
        //     //alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        // });

        // // Delete a record
       

        // //Like record
        // table.on('click', '.like', function() {
        //     alert('You clicked on Like button');
        // });

        $('.card .material-datatables label').addClass('form-group');
        var v = jQuery("#amt_forms").validate({

        submitHandler: function(datas) {

        $('.body_blur').show();
            jQuery(datas).ajaxSubmit({
                
                dataType : "json",
                success  :    function(data)
                {
                     $('.body_blur').hide();
                    if(data.status)
                    {

                        //$('#channel_form').hide();
                       
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully sent request </div></div>';
                        var effect='zoomIn';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        refresh_close();
                        setTimeout(function(){

                            $('#amt_forms').reset();
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
                        $('.close').click(function(){
                             $(this).parent().fadeOut(1000);
                         });
                        //$.toast(data.reason, {'width': 500});
                       // return false;
                    }
                }
            });
        }
     });
       

    });
</script>


 <script src="<?php echo base_url(); ?>assets/admin/js/paging.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    var base_url = "<?php echo base_url(); ?>";
                    function load_demo(index) {
                        index = index || 0;
                        var search = $('#search').val();
                        $.post(base_url + "set_commission/" + index, { ajax: true,search:search}, function(data) {
                            console.log(data);
                            $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';
                            if(data.status){
                                var data1 = data.data;
                                for(var i = 0; i< data1.length; i++){
                                    var cur_index=parseInt(index);
                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                                    var requested_commission = (data1[i].requested_commission==null) ? "" :data1[i].requested_commission;
                                    tr += '<tr>'+
                                    '<input type="hidden" name="id" class="id" value="'+data1[i].id+'">'+
                                        '<td>'+sl_no+'</td>'+
                                      
                                        '<td class="title">'+data1[i].category_title+'</td>'+
                                        '<td>'+data1[i].percentage+'</td>'+

                                       
                                        
                                        '<td>'+requested_commission+'</td>'+
                                        '<td><a href="#" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a></td>'+
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