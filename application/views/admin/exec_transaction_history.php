<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">

</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>
        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-offset-7 col-sm-3">
                            <label class="pull-right">Search:</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control search" name="search" id="search" placeholder="">
                        </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Executive Transaction History<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <table id="example" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>No</th>
                                  
                                    <th>Executive Names</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                     <th>Mode Of Payment</th>
                                </tr>
                                </thead>
                                
                                <tbody style=" height:100px;overflow:scroll">
                              <!--   <?php foreach($cp_details as $key => $cpdetai){?>
                                <tr>
                                    <td><?= $key+1; ?></td>
                                 
                                    <td class="total_amount"><?= $cpdetai['name'];?></td> 
                                    <td class="total_amount"><?= $cpdetai['transaction_amount'];?></td>
                                    <td class="total_amount"><?= date('d-m-Y',strtotime($cpdetai['transaction_date']));?></td>
                                                                        <td class="desig"><?php echo $cpdetai['mode'];
                                    if( $cpdetai['mode']=='cheque'){?><br>
                                        <label>Cheque No:  </label><?php echo   $cpdetai['cheque_number'];?><br>
                                        <label>Date:  </label><?php echo convert_ui_date($cpdetai['cheque_date']);?><br>
                                        <label>Bank:</label><?php echo $cpdetai['bank_name'];?><br>
                                        <?php
                                        }?></td>
                                </tr>
                                    <?php }?> -->
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
 
</div>
</div>
</div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>


<script>


$(document).on('click','.approve_cp',function(){
    var cur=$(this);
    id = cur.parent().parent().find('.hiddentype_id').val();
        $('body').alertBox({
            title: 'Are You Sure?',
            lTxt: 'Back',
            lCallback: function(){
              
            },
            rTxt: 'Okey',
            rCallback: function(){
                $('.body_blur').show();
                $.post('<?php echo base_url();?>admin/home/approve_cp_transaction/',{id:id}, function(data){
                    $('.body_blur').hide();
                    if(data.status){
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully approved transaction</div></div>';
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
    });

</script>
    <script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();

            $.post(base_url + "executive_transaction_history/" + index, { ajax: true,search:search}, function(data) {
               
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){
                    
                    var tr = '';
                    var data1 = data.data;
                    var data2=data1.member;

                    for(var i = 0; i< data2.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                            if(data2[i].mode=='cheque'){
                            var detail = ' Payment Via : Cheque'+'<br>';
                            detail +='Name of the Bank :'+data2[i].bank_name+'<br>';
                            detail +='Cheque No :'+data2[i].cheque_number+'<br>';
                            detail +='Cheque Date :'+data2[i].cdate;
                        }else{
                           var detail = ' Payment Via : '+data2[i].mode
                           .charAt(0).toUpperCase() + data2[i].mode.slice(1);
                        }
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data2[i].name+'</td>'+
                            '<td>'+data2[i].transaction_amount+'</td>'+
                            '<td>'+data2[i].transaction_date+'</td>'+
                           
                            '<td>'+detail+
                          
                            '</td>'+

                         
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
<style>
tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
        background-color:#e6e6e6;
    }
    tfoot {background-color:#f1f1f1}
    </style>

</body>
</html>





























