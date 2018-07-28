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
                        <h2>Transaction<small></small></h2>
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
                                    <th>Name</th>
                                    <th>Requested Amount</th>
                                    <th>Action</th>


                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Requested Amount</th>
                                    <td>Action</td>

                                </tr>
                                </tfoot>
                                <tbody style=" height:100px;overflow:scroll">
                                <?php foreach($cp_details as $cpdetai){?>
                                <tr>
                                    <td class="walletid">
                                    <input type="hidden" value="<?php echo $cpdetai['id'];?>" id="hiddenid">
                                    <input type="hidden" value="<?php echo $cpdetai['wallet_id'];?>" id="wallet_hiddenid">
                                        <input type="hidden" value="<?php echo $cpdetai['total_value'];?>" id="total_value">
                                        <?php echo $cpdetai['name'];?></td>
                                    <td class="total_amount"><?php echo $cpdetai['transaction_amount'];?></td>
                                    <td>
                                        <a id="pay" class="btn btn-danger" href="#"> Pay </a>
                                    </td>

                                </tr>
                                    <?php }?>

                                </tbody>
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
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>




<script>

    $(document).ready(function() {
        var table = $('#example').DataTable( {
            fixedHeader: {
                header: true,
                footer: true,

            }
        } );

    } );
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        // DataTable
        var table = $('#example').DataTable();

        // Apply the search
        table.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                            .search( this.value )
                            .draw();
                }
            } );
        } );

        $(document).on('click','#pay',function(e)
        {
            e.preventDefault();
            var amount= $("#total_amount").text();
            var wid= $("#wallet_hiddenid").val();
            var id= $("#hiddenid").val();
            var total_value= $("#total_value").val();
            $.post('<?= base_url(); ?>/admin/Cp_transaction/approve_transaction_request',{id:id , amount:amount, total_value:total_value ,wid:wid},function(data)
            {
                if(data.status)
                {
                    alert("success");
                    // noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                    // $('#allow_persantage').val('');
                    // $('#no_of_levels').val('');
                    // $('#pool_name').val('');

                   

                }
                else
                {
                    alert("failure");
                   // noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }

            },'json');

        });

    } );
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





























