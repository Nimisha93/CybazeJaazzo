<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<style type="text/css">
    span.help-inline-error{
        color: red;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            </div>
            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">

                        <h2>Transaction History</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          
                           <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>

                        </ul>
                        <div class="clearfix"></div>
                        
                    </div>
                    <div class="x_content">
                        <div class="">

                           <div class="row">
                                    <div class="col-sm-3">
                                      <input type="text" id="from" name="from" class="fromdate form-control">
                                    </div>
                                    <div class="col-sm-3">
                                       <input type="text"  id="to" name="to" class="todate form-control" />
                                    </div> 
                                    <div class="col-sm-1">
                                        <button class="btn btn-info" id="btn_search">Go</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="pull-right">Search:</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                    </div>
                                </div><br>
                            <table id="example" class="display table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="tablbg">
                                        <th style="width: 45px">Slno</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Mode of Payment</th>
                                        <th>Transaction Date</th>
                                        <th>Transaction Status</th>
                                    </tr>
                                </thead>
                                <tbody style=" height:100px;overflow:scroll">
                                    
                                </tbody>
                                <tfoot id ="foot">
                                    <td colspan="10">
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
</div>



<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
         $(document).on('keyup', '.fromdate', function(e) {
           e.preventDefault();
            load_demo();
            });
            $(document).on('change', '.todate', function(e) {
                    e.preventDefault();
                   
                    load_demo();
            });
            $(document).on('click', '#btn_search', function () {
                    load_demo();
            });
        var base_url = "<?php echo base_url(); ?>";

        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            var from = $('.fromdate').val();
            var to = $('.todate').val();
            $.post(base_url + "cp_transaction_history/" + index, { ajax: true,search:search,from:from,to:to}, function(data) {
                
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.data.length>0){
                  console.log(data);
                    var tr = '';
                     var j = 0; 
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        
                        if(data1[i].mode=='cheque'){
                            var detail = ' Payment Via : Cheque'+'<br>';
                            detail +='Name of the Bank :'+data1[i].bank_name+'<br>';
                            detail +='Cheque No :'+data1[i].cheque_number+'<br>';
                            detail +='Cheque Date :'+data1[i].cheque_date;
                        }else{
                           var detail = ' Payment Via : '+data1[i].mode;
                          
                        }
                        var status = (data1[i].status == 1)? "Approved":"Pending" ;
                        if(data1[i].from!="" && data1[i].to!="" && data1[i].transaction_amount!=""){
                          var sl_no=index!=0?(cur_index+(j + 1)):(j + 1);
                            tr += '<tr>'+

                                '<td class="slno">'+sl_no+'</td>'+                                                   
                                '<td class="cp_name"><input type="hidden" value="'+data1[i].id+'" class="hiddentype_id">'+data1[i].from+'</td>'+
                                '<td class="total_amount">'+data1[i].to+'</td>'+
                                '<td class="total_amount">'+data1[i].transaction_amount+'</td>'+
                                '<td class="total_amount">'+data1[i].narration+'</td>'+
                                '<td class="total_amount">'+detail+'</td>'+
                                '<td class="total_amount">'+data1[i].trans_date+'</td>'+
                                '<td class="total_amount">'+status+'</td>'+
                                
                                '</tr>';
                            j++;
                        }
                    }
                    
                    $('#search').val(data.search);
                
                        $('#pagination').html(data.pagination);
                    

                }else{
                     tr += '<tr><td colspan="10">No data found</td></tr>';
                   
                }
               
                $('tbody').html(tr);
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
    
    $(function () {
        $('.fromdate').datetimepicker(
            {
                format: 'DD-MM-YYYY H:mm:ss',
                
            }
        );
        $('.todate').datetimepicker(
            {
                format: 'DD-MM-YYYY H:mm:ss',

            }
        );
    });
</script>
