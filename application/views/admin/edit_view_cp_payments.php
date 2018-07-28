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
                        <h2> Coupen Purchased Users <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                            
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                         <div class="row">
                        <div class="col-sm-offset-7 col-sm-3">
                            <label class="pull-right">Search:</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control search" name="search" id="search" placeholder="">
                        </div>
                    </div><br>
                            <table id="example" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                <th>SI No</th>
                                    <th>Chanel Partner Name</th>
                                    <th>User Name</th>
                                    <th>Coupon Code</th>
                                    
                                    <th>Amount</th>
                                    <th>Payment Status</th>


                                </tr>
                                </thead>
                                <!-- <tfoot>
                                <tr>
                                                                <th>SI No</th>

                                     <th>Chanel Partner Name</th>
                                    <th>User Name</th>
                                    <th>Coupon Code</th>
                                    
                                    <th>Amount</th>
                                    

                                </tr>
                                </tfoot> -->
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
// $(document).ready(function(){
 
//     $(document).on('click','.approve_payment',function(){
//         var cur=$(this);
//         var hiddentypeid=cur.parent().parent().find('.p_id').val();
//         // var email=cur.parent().parent().find('.email').val();
//         // var otp=cur.parent().parent().find('.otp').val();
      
//                     $('.body_blur').show();
//                     $.post('<?php echo base_url();?>admin/Home/approve_cp_payment/',{id:hiddentypeid}, function(data){
//                         $('.body_blur').hide();
//                         if(data.status){
//                             var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Approved Channel Partner </div></div>';
//                                 var effect='zoomIn';
//                                 $("#notifications").append(center);
//                                 $("#notifications-full").addClass('animated ' + effect);
//                                 refresh_close();
//                         }else{
//                             var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Database Error</div></div>';
//                                 var effect='fadeInRight';
//                                 $("#notifications").append(center);
//                                 $("#notifications-full").addClass('animated ' + effect);
//                                 refresh_close();
//                                                                     }
//                     },'json');
                          

//                 })
//             });
</script>

<script type="text/javascript">
          $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            $.post(base_url + "pay_cp/" + index, { ajax: true,search:search}, function(data) {
                console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        var pay_status = (data1[i].is_paid=='1') ? 'paid' : 'pending';
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<input type="hidden" value="'+data1[i].id+'" class="p_id">'+data1[i].id+''+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].club_name+'</td>'+
                            '<td>'+data1[i].coupon_code+'</td>'+
                            '<td>'+data1[i].amount+'</td>'+
                            '<td>'+pay_status+'</td>'+
                            '</tr>';
                    }
                    $('tbody').html(tr);

                    console.log(data.pagination);
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

// $(document).ready(function() {
//     var table = $('#example').DataTable( {
//         fixedHeader: {
//             header: true,
//             footer: true,
			
//         }
//     } );
	
// } );
// $(document).ready(function() {
//     // Setup - add a text input to each footer cell
//     $('#example tfoot th').each( function () {
//         var title = $(this).text();
//         $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
//     } );
 
//     // DataTable
//     var table = $('#example').DataTable();
 
//     // Apply the search
//     table.columns().every( function () {
//         var that = this;
 
//         $( 'input', this.footer() ).on( 'keyup change', function () {
//             if ( that.search() !== this.value ) {
//                 that
//                     .search( this.value )
//                     .draw();
//             }
//         } );
//     } );
// } );
</script>
<!-- <style>
tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
		background-color:#e6e6e6;
    }
	tfoot {background-color:#f1f1f1;
        display:none;}
	</style> -->

<!-- Datatables -->

<!--============new customer popup start here=================-->


</body>
</html>





























