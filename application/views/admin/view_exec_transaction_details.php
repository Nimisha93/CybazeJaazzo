<?php echo $default_assets; ?>
<!-- <link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet"> -->
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
<div class="page-title">
    <div class="title_left">
        <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."></div>
    </div>   
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Transaction Details<small></small></h2>
                 <ul class="nav navbar-right panel_toolbox">
                 
                    <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
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
                    <table id="example" class="display table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr class="tablbg">
                                <th>slno</th>
                                <th>Amount</th>
                                <th>Date </th>
                                <th>Description </th>
                              
                            </tr>
                        </thead>
                        <tbody style=" height:100px;overflow:scroll">
                                    
                        </tbody>
                        <tfoot>
                            <td colspan="8">
                                <div class="pull-right" id="pagination"></div>
                            </td>
                        </tfoot>
                        <tbody style=" height:100px;overflow:scroll">
                          <!--   <?php foreach($exec_details as $key=>$exec){?>
                                <tr>
                                    <td class="titleclass"><input type="hidden" value="<?php echo $exec['id'];?>" class="hiddentype_id"><?php echo $key+1;?></td>
                                    
                                    <td class="email"><?php echo $exec['transaction_amount'];?></td>

                                    <td class="desig"><?php echo  $exec['transaction_date'];?></td>
                                
                                    <td class="desig"><?php echo $exec['narration'];?></td>

                                </tr>
                            <?php } ?> -->
                        </tbody> 
                    </table>
                </div>
            </div>
    </div>
</div>
        <div id="notifications"></div>
        <input type="hidden" id="position" value="center">
</div>
    <?php echo $footer; ?>
    <!-- <script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url(); ?>assets/admin/js/alertBox.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/alertBox.css"> 
    <!-- <script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script> -->
    <script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();

            $.post(base_url + "transaction_executive/" + index, { ajax: true,search:search}, function(data) {
                //console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var data1 = data.data;
                   
                    var data2=data1.details;
                    console.log(data2);
                    for(var i = 0; i< data2.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data2[i].transaction_amount+'</td>'+
                            '<td>'+data2[i].transaction_date+'</td>'+
                            '<td>'+data2[i].narration+'</td>'+
                            
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

</body>
</html>




























