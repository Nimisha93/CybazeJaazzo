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
                        <h2>Channel Partner<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Wallet Total</th>
                                    <th>Bill Total</th>
                                    <th></th>


                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Wallet Total</th>
                                    <th>Bill Total</th>
                                   <td></td>

                                </tr>
                                </tfoot>
                                <tbody style=" height:100px;overflow:scroll">
                                <?php foreach($notification as $noti){?>
                                <tr>
                                    <td class="titleclass">
                                        <input type="hidden" value="<?php echo $noti['noty_id'];?>" class="hiddentype_id">
                                        <?php echo $noti['name'];?></td>
                                    <td class="mobile"><?php echo $noti['phone'];?></td>
                                    <td class="email"><?php echo $noti['email'];?></td>
                                    <td><?php echo $noti['wallet_total'];?></td>
                                    <td><?php echo $noti['bill_total'];?></td>
                                    <td><button type="button" class="btn btn-primary approve">Approve </button></td>
                                    

                                </tr>
                                    <?php }?>
                                <script>
                                    $(document).ready(function(){
                                        $(document).on('click','.approve',function(){
                                           // $("#agree1").modal('show');

                                            var cur=$(this);
                                            var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
                                            var mobile=cur.parent().parent().find('.mobile').text();
                                            var emailll =cur.parent().parent().find('.email').text();
                                            $(document).find('#hiddenotp').val(hiddentype_id);
                                             $('.body_blur').show();
                                            $.post("<?php echo base_url();?>admin/Channel_partner/purchase_otp",{hiddentype_id : hiddentype_id,mobile : mobile, emailll:emailll},  function(data){
                                                $('.body_blur').hide();
                                                noty({text:"OTP sent to your registered mobile",type: 'success',layout: 'top', timeout: 3000});

                                                if(data.status){
                                                    $("#agree1").modal('show');
                                                    var purch_id = data.data;
                                                }
                                                else{
                                                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                                                }
                                            },'json');


                                        });
                                            $(document).on('click','.otp_sub',function(){
                                            var str = $("#otp_forms").validationEngine("validate");
                                            if(str==true){
                                                var data=$("#otp_forms").serializeArray();
                                                $('.body_blur').show();
                                                $.post("<?php echo base_url();?>admin/Channel_partner/purchase_approvel_byotp", data, function(data){
                                                    $('.body_blur').hide();
                                                    if(data.status){
                                                        noty({text:"successfully completed",type: 'success',layout: 'top', timeout: 3000});
                                                        $('#otp_forms')[0].reset();
                                                        $("#agree1").modal('hide');
                                                         $("#saled_cat_modal").modal('show');
                                                         var notyid = data.notyid;
                                                       var data = data.data;
                                                       console.log(data);
                                                       var div ='';
                                                      
                                                       $('#calc_percnt_form').find('#notyid').val(notyid);
                                                       for(var i =0; i<data.length; i++)
                                                       {
                                                         div += '<div class="modal-body"><div class="col-lg-12">'+
                                                         '<label style="float:left;width:20px;">'+data[i].category_title+'</label>'+
                                                         '<input type="hidden" name="percentage[]" class="form-control" value="'+data[i].channel_partner_main_commision+'">'+
                                                        
                                                                                                                 
                                                         
                                                         '<input type="text" placeholder="Enter No of Product" name="product_nos[]" class="col-lg-4" style="margin:0px 15px;">'+
                                                        
                                                          '<label>'+data[i].channel_partner_main_commision+'</label>'+
                                                         '</div></div>';
                                                    //     console.log(data[i].category_title);
                                                       }

                                                       $('.get_category').html(div);
                                                    }
                                                    else{
                                                        noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                                                        $('#otp_forms')[0].reset();
                                                    }
                                                },'json');
                                            }
                                            else{

                                            }

                                        });
                                            $('.make_payment').click(function(){
                                                var datas = $('#calc_percnt_form').serializeArray();
                                                //  $('.body_blur').show();
                                                $.post('<?php echo base_url();?>admin/Channel_partner/total_percentage', datas, function(data){
                                                    //  $('.body_blur').hide();
                                                    if(data.status)
                                                    {
                                            noty({text:'Transaction Completed',type: 'success',layout: 'top', timeout: 3000});
                                            $("#saled_cat_modal").modal('hide');
                                             $('#calc_percnt_form')[0].reset();
                                            location.reload();
                                                    } else{
                                                  noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});               
                                                    }
                                                },'json');
                                            });

                                    });
                                </script>
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
<!-- otp form -->
<div id="agree1" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content" style="width: 400px;margin-left: 30%;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">X</button>
                                                    <h4 class="modal-title">OTP</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                                        <div class="panel">
                                                            <!--                            <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">-->
                                                            <!--                                <h4 class="panel-title"></h4>-->
                                                            <!--                            </a>-->

                                                        </div>
                                                        <form method="post" id="otp_forms" class="otp_forms" name="otp_forms">
                                                            <div class="col-md-10 col-sm-12 col-xs-12">
                                                                <label>Enter the otp here</label>
                                                                <input type="hidden" placeholder="" class="form-control" id="hiddenotp" name="hiddenotp">
                                                                <input type="text" placeholder="OTP" class="form-control validate[required]" id="purchase_otp" name="purchase_otp">
                                                            </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary otp_sub" id="otp_sub">Submit</button>
                                                </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
<!-- otp form -->

    <div id="saled_cat_modal" class="modal fade" role="dialog" style="width:455px;margin-left:31%;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Categories</h4>
      </div>
      <form class="calc_percnt_form" id="calc_percnt_form">
      <div class="modal-body get_category">
       
      </div>
       <div class="modal-body" style="width:45%;">
       <input type="text" name="total_bill" class="form-control" placeholder="Total bill">
       <input type="hidden" name="notyid" id="notyid" class="form-control">
      </div>
      <div class="modal-footer" style="width:45%;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success make_payment">Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>




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


<!-- Datatables -->

<!--============new customer popup start here=================-->


</body>
</html>





























