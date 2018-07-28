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
View Reffered Executives
    
</div><br><br>
<div class="card-content">
<!--    <h4 class="card-title">Commision</h4>-->
<div class="toolbar">
    <!--        Here you can write extra buttons/actions for the toolbar              -->
</div>
 
                      <a type="button" class="btn btn-danger fllft del_btn" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                    
<div class="material-datatables"> 
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
        <th>Name</th>
    <th>Email</th>
    <th>Designation</th>

    <th>phone</th>
    <th>address</th>
     <th>Action</th>
    
   
</tr>
</thead>
<tbody style=" height:100px;overflow:scroll">
                                    
                        </tbody>
                        <tfoot>
                            <td colspan="8">
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

 <?php echo $footer; ?>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.datatables.js"></script>

<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
</script> -->
    <script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            $.post(base_url + "tm_exec_reffered_view/" + index, { ajax: true,search:search}, function(data) {
                console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].email+'</td>'+
                            '<td>'+data1[i].designation+'</td>'+
                            
                            
                            '<td>'+data1[i].phone+'</td>'+
                            '<td>'+data1[i].address+'</td>'+
                            '<td><a  href="'+base_url+"admin/executives/tm_update_executive/"+data1[i].id+'" class="btn btn-primary fllft edit_btn"><i class="material-icons">edit</i></a><input type="checkbox" name="" value="'+data1[i].id+'" class="chck_grp_item"></td>'+
                            '</tr>';
                    }
                    $('tbody').html(tr);
                    $('#search').val(data.search);
                    // pagination
                    $('#pagination').html(data.pagination);

                }else{

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
<script>
        /*$(document).ready(function() {
            var table = $('#example').DataTable( {
                fixedHeader: {
                    header: true,
                    footer: true,
                }
            });
        });*/
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