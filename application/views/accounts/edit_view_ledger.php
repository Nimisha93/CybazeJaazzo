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
                        <h2>Ledger<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
<!--                            <li>-->
<!--                                <a href="--><?php //echo base_url();?><!--admin/entries/add_entries/" type="button" class="btn btn-primary fllft " style="background-color:#162b52"><i class="fa fa-plus" aria-hidden="true"></i></a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a type="button" class="btn btn-primary fllft del_btn" style="background-color:#162b52"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
<!--                            </li>-->
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>


                    <div class="col-md-6">
                        <table class="table table-bordered table-striped responsive-utilities">

                            <tr>
                                <td><strong>Group</strong></td>
                                <?php //var_dump(json_encode($ledgers));exit;?>
                                <td colspan="2"><?= $ledgers['ledger'][0]['gp_name'];?></td>
                            </tr>
                            <tr>
                                <td><strong>Ledger</strong></td>
                                <?php //var_dump(json_encode($ledgers));exit;?>
                                <td colspan="2"><?= $ledgers['ledger'][0]['ld_name'];?></td>
                            </tr>
                            <tr>
                                <td><strong>Note</strong></td>
                                <?php //var_dump(json_encode($ledgers));exit;?>
                                <td colspan="2"><?= $ledgers['ledger'][0]['note'];?></td>
                            </tr>
                            <tr>
                                <td><strong>Opening Balance</strong></td>
                                <td  colspan="2"><?= $ledgers['ledger'][0]['opening_balance'];?></td>
                            </tr>
                            <tr>
                                <td><strong>Closing Balance</strong></td>
                                <?php

                                if($ledgers['closing_bal'] > 0){ ?>
                                    <td  colspan="2">Dr <?= abs($ledgers['closing_bal']);?></td>
                                    <?php } else{ ?>
                                    <td  colspan="2">Cr <?= abs($ledgers['closing_bal']);?></td>
                                    <?php }
                                ?>


                            </tr>
                        </table>
                    </div>

                     <div class="x_content">

                     <div class="row">
                                <div class="col-sm-offset-7 col-sm-3">
                                    <label class="pull-right">Search:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                </div>
                            </div><br>
                        <div class="tbleovrscroll">
                            <table id="example" class="display table-bordered table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>Date</th>
                                    <th>Number</th>
                                    <th>Type</th>
                                    <th>Debit Amount</th>
                                    <th>Credit Amount</th>
                                </tr>
                                </thead>
                                <tbody class="tbody1">
           

                                </tbody>

                                
                                
                                 <tfoot>
                                        <td colspan="6">
                                            <div class="pull-right" id="pagination"></div>
                                        </td>
                                    </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12 text-center">
                            <ul class="pagination pagination-lg pager" id="myPager"></ul>
                        </div>
                    </div>

<!-- 
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
                            <div class="box-body">
                                <table id="purchase_table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr class="filters">

                                    <th>Date</th>
                                    <th>Number</th>
                                    <th>Type</th>
                                    <th>Debit Amount</th>
                                    <th>Credit Amount</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                             

                                </tbody>
                                    <tfoot>
                                        <td colspan="4">
                                            <div class="pull-right" id="pagination"></div>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                            
                        </div>
                    </div> -->


                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div id="add" class="modal fade" role="dialog">
    <div class="modal-dialog" style="max-width:600px">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="item_group_form" method="post" action="<?php echo base_url();?>admin/items/addItemGroup">
                <div class="modal-body">
                    <p>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">

                            <label>Group Name</label>
                            <input type="text" name="groupname" placeholder="Group Name" class="form-control validate[required] groupname">
                        </div> </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit_itemgroup" class="btn btn-default">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>




<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.buttons.min.js" type="text/javascript"></script>


<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>

<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( );
    } );
</script> -->

    <script type="text/javascript">
                $(document).ready(function(){

                  
                    var base_url = "<?php echo base_url(); ?>";
                     var cat_id = "<?php echo $led_id; ?>";
                    function load_demo(index) 
                    {
                        index = index || 0;
                        var search = $('#search').val();
                        $.post(base_url + "accounts/accounts/view_ledger_entry/"+cat_id+"/" + index, { ajax: true,search:search}, function(data) {
                           // console.log(data);
                           $('.tbody1').html(tr);
                            $('.body_blur').hide();
                            var tr = '';
                            if(data.status){
                                var data_l = data.data;
                            var data1 = data_l.ledger;

  
                                for(var i = 0; i< data1.length; i++){

                                    var cur_index=parseInt(index);
                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);


                           //console.log(data1[i].cr_amount);




                                    var num=data1[i].number;
                                    if(num!=null)
                                    {
                             tr += '<tr>'+

                                    
                            '<td>'+data1[i].ld_date+'</td>'+
                            '<td>'+data1[i].number+'</td>'+
                            '<td>'+data1[i].en_type+'</td>'+
                            '<td>'+data1[i].dr_balance+'</td>'+
                            '<td>'+data1[i].cr_balance+'</td>'+

                            '</tr>';
                                    }
                                    else
                                    {

                                        tr += '<tr>'+
                                        '<td colspan="4" style="text-align:center">No Data Found</td>'+
                                        '</tr>';

                                    }











   
                                }
                               $('.tbody1').html(tr);
                                $('#search').val(data.search);
                                // pagination
                                $('#pagination').html(data.pagination);

                            }else{
                                 tr += '<tr>'+
                                        '<td colspan="4" style="text-align:center">No Data Found</td>'+
                                        '</tr>';
                                $('.tbody1').html(tr);
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