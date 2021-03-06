<?php echo $default_assets; ?>


</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">



        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update Ledger<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a href="" type="button" class="btn btn-primary fllft btn_add" style="background-color:#162b52;color: white;">New Group</a>
                            </li>
                          
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <form id="item_form" class="form-horizontal Calendar" method="post" action="<?php echo base_url();?>accounts/accounts/edit_ledegr_by_id/<?= $ledgers['id'];?>" role="form">

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label>Group Name</label>
                                    <select placeholder="Select Group" name="group_name" id="group_name" class="SlectBox form-control group_name   validate[required]"  data-rule-required="true">
                                        <option value="">Please select</option>

                                        <?php foreach ($groups['type'] as $key => $acc_type) 
                                        { ?>
                                        <optgroup  style="color: black;" label="<?=$acc_type['name'];?>"></optgroup>
                                        <?php foreach($acc_type['group'] as $key => $group)
                                        { ?>
                                            <option <?= $ledgers['group_id'] == $group['id'] ? 'selected' : '' ;?>      value="<?= $group['id'];?>"><?= $group['name'];?></option>
                                            <?php  
                                             }
                                    } 
                                    ?>
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label>Ledger Name</label>
                                    <input type="text" name="ledger" value="<?= $ledgers['name'];?>" placeholder="Ledger Name" class="form-control validate[required]"  data-rule-required="true">

                                </div>
                                <!--                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">-->
                                <!--                                    <label>Tax Types</label>-->
                                <!--                                    <select placeholder="Select Tax Types" name="tax_types[]" multiple="multiple" class="SlectBox form-control tax_types selectBox validate[required]">-->
                                <!---->
                                <!--                                        --><?php //foreach ($tax_types as $tax_type){ ?>
                                <!--                                        <option value="--><?php //echo $tax_type['id'];?><!--">--><?php //echo $tax_type['title'];?><!--</option>-->
                                <!--                                        --><?php //} ?>
                                <!--                                    </select>-->
                                <!--                                </div>-->


                                <div class="row" style="clear: both">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Opening Balance Dc.</label>
                                            <select id="ledgerOpBalanceDc" class="form-control" name="ledgerOpBalanceDc" >
                                                <option <?= $ledgers['op_balance_dc'] == 'Dr' ? 'selected' : '' ;?> value="Dr">Dr</option>
                                                <option <?= $ledgers['op_balance_dc'] == 'Cr' ? 'selected' : '' ;?> value="Cr">Cr</option>
                                            </select>                                        </div>
                                        <div class="col-md-8 col-sm-6 col-xs-12 form-group">
                                            <span class="help-block" style="margin-top: 15px;">Note : Assets / Expenses always have Dr balance and Liabilities / Incomes always have Cr balance.</span>
                                        </div>




                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <label>Opening Balance</label>
                                            <input type="text" id="openigbal" name="openigbal"  value="<?= $ledgers['opening_balance_amount'];?>" class="form-control openigbal">
                                        </div>


                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label>Note</label>
                                        <textarea id="textarea"  name="description" class="form-control col-md-6 col-xs-12 " rows="6" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 100px;"><?= $ledgers['note'];?></textarea>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <button type="submit" class="btn btn-primary pull-right antosubmit">Update</button>
                                    </div>
                            </form>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--************************row  end******************************************************************* -->



    <!--************************row  end******************************************************************* -->




</div>
<div class="clearfix"></div>

<!--************************row  end******************************************************************* -->

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
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="group_form" method="post" action="<?php echo base_url();?>admin/accounts/addGroup">
                <div class="modal-body">
                    <p>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                            <label>Account Type</label>
                            <select class="form-control validate[required] sel_typee" name="sel_typee" id="sel_typee"  required="">

                                <option value="">Please Select</option>
                                <?php foreach($groups['type'] as $key => $acc_type) { ?>
                                <option value="<?= $acc_type['id'];?>"><?= $acc_type['name'];?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">

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
<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>


<!--***************************sumo select******************************-->
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/admin/css/select2.css" rel="stylesheet">

<script src="<?php echo base_url();?>assets/admin/js/select2.full.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $('.selectBox').SumoSelect({okCancelInMulti:true, selectAll:true });
        $('.select2').select2();
                 $('#group_name').SumoSelect({search: true, placeholder: 'Select group'});

    });
</script>



<script type="text/javascript">
    $(document).ready(function() {


        var v = jQuery("#item_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#item_form').hide();
                            $('.body_blur').hide();
//                            if(data.result=='add'){
                                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text"> Ledger Updated Successfully</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        location.reload();
                    }, 1000);
                        }
                        else
                        {
                           $('.body_blur').hide();
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                        }
                    }
                });
            }
        });




  $('#item_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
      
      }          
    });




//        $('#item_form').validationEngine();
//        var options = {
//            dataType : "json",
//            success  :    function(data)
//            {
//                if(data.status == true)
//                {
//                    $('.body_blur').hide();
//                    $.toast('Ledger updated successfully', {'width': 500});
//
//                    setTimeout(function(){
//                        $('#item_form')[0].reset();
//                        $('#item_form').hide();
//
//                    }, 3000);
//                }
//                else
//                {
//                    $('.body_blur').hide();
//                    $.toast(data.reason, {'type': 'danger','width': 500,'duration': 500});
//                    return false;
//                }
//            }
//        };
//
//        $('#item_form').submit(function(e){
//            e.preventDefault();
//            $('.body_blur').show();
//            var st = $("#item_form").validationEngine("validate");
//
//            if(st ==true)
//            {
//                $(this).ajaxSubmit(options);
//                $('.body_blur').hide();
//            }
//            $('.body_blur').hide();
//        });

        $(document).on('click', '.btn_add',function (e) {
            e.preventDefault();
            $('#add').modal('show');
            $('#add').find('.modal-title').text('Add  Group');
            //  $('#item_group_form').find('.groupname').val('');
            $('#item_group_form').find('#submit_itemgroup').text('Save');
            $('#submit_itemgroup').addClass('add_item_group');
            // $('#submit_itemgroup').removeClass('update_item_group');
            var up_form = '<?= base_url();?>admin/accounts/addGroup';
            $("#item_group_form").attr("action", up_form);
        });
    });


    $(document).ready(function() {

        var v = jQuery("#group_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#group_form').hide();
                            $('.body_blur').hide();
//                            if(data.result=='add'){
                            $.toast('Group added  successfully', {'width': 500});
//                            }else{
//                                $.toast('Warehouse Updated successfully', {'width': 500});
//                            }
                            setTimeout(function(){

                                $('#group_form').hide();
                                location.reload();
                            }, 1000);
                        }
                        else
                        {
                            $('.body_blur').hide();
                            $.toast(data.reason, {'width': 500});
                            return false;
                        }
                    }
                });
            }
        });



    });


</script>
<!--***************************sumo select end******************************-->


</body>
</html>