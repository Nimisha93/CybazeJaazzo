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
                        <h2>Last Transaction Details<small></small></h2>
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
                                    <th style="width: 45px">Slno</th>
                                    <th>Amount</th>
                                    <th>transaction_date</th>
                                    <th>Mode of Payment</th>
                                </tr>
                                </thead>
                                
                                <tbody style=" height:100px;overflow:scroll">
                                <?php foreach($transaction as $key => $cpdetai){?>
                                <tr>
                                    <td><?= $key+1; ?></td>
                                    <td><?= $cpdetai['transaction_amount'];?></td>
                                    <td><?= date('d-m-Y g:i a',strtotime($cpdetai['transaction_date']));?></td>
                                    <td><?= $cpdetai['mode'];?></td>
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
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script type="text/javascript">
                              
    $(document).ready(function () {
       
        var v = jQuery("#transaction_form").validate({
          
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
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully completed transaction</div></div>';
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
<script>
    $(document).ready(function () {
        $("#details").hide();
        $('input:radio[name="payment_mode"]').change(
            function(){
                if ($(this).val() == 'cheque') {
                   $("#details").show();
                }
                else{
                   $("#details").hide(); 
                }
        });
    });    
    $(document).ready(function(){
        $(document).on('click','.paid_trans',function(){
            var cur=$(this);
            var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
            var wal_id=cur.parent().parent().find('.wallet_hiddenid').val();
            var amount=cur.parent().parent().find('.total_amount').text();
            var cpid=cur.parent().parent().find('.cp_hiddenid').val();
            $(document).find('#wallet_hiddenid').val(wal_id);
            $(document).find('#total_amtvalue').val(amount);
            $(document).find('#cp_hiddenid').val(cpid);

        });
    });
</script>

<script type="text/javascript">
                              
    $(document).ready(function () {
       // alert("sd");
        var v = jQuery("#wal_amountsub").validate({

        submitHandler: function(datas) {
            //alert("sd");
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                 $('.body_blur').hide();
                if(data.status)
                {

                    //$('#channel_form').hide();
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added channel partner </div></div>';
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





























