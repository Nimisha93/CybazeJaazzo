<?php echo $default_assets; ?>


</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">



        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Financial Year<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                                                
                            </li>
        
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <form id="item_form" class="form-horizontal Calendar" method="post" action="<?php echo base_url();?>accounts/accounts/update_financial_year" role="form">

                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Company Name</label>
                                   <input type="text" name="ledger" placeholder="Company Name" class="form-control validate[required]"  data-rule-required="true" value="Jaazzo">

                                </div>
                               
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Start Date</label>

                                            <?php 
                                            $start_y=$fin_year['start_year'];
                                            $start=convert_ui_date($start_y);


                                            ?>

                                            <input type="text" id="opening_date" name="f_start" class="form-control opening_date" value="<?php echo $start;?>">

                                            <input type="hidden" id="ddd" name="id" class="form-control id" value="<?php echo $fin_year['id'];?>">
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>End Date</label>

                                            <?php 
                                            $end_y=$fin_year['end_year'];
                                            $end_y1=convert_ui_date($end_y);


                                            ?>
                                            <input type="text" id="opening_date" name="f_end" class="form-control opening_date" value="<?php echo $end_y1;?>">
                                        </div>

                                    </div>
                                    


                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <button type="submit" class="btn btn-primary pull-right antosubmit">Submit</button>
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
            <form id="group_form" method="post" action="<?php echo base_url();?>accounts/accounts/addGroup">
                <div class="modal-body">
                    <p>
                    <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                        <label>Account Type</label>
                    <select class="form-control validate[required] sel_typee" name="sel_typee" id="sel_typee"  data-rule-required="true">

                        <option value="">Please Select</option>
                        <?php foreach($groups['type'] as $key => $acc_type) { ?>
                        <option value="<?= $acc_type['id'];?>"><?= $acc_type['name'];?></option>
                        <?php } ?>
                    </select>
                        </div>

                    <div class="col-md-6 col-sm-12 col-xs-12 form-group">

                            <label>Group Name</label>
                            <input type="text" name="groupname" placeholder="Group Name" class="form-control validate[required] groupname" data-rule-required="true">
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
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/bootstrap-datetimepicker.min.css" />

<script type="text/javascript">
    $(document).ready(function () {
        $('.selectBox').SumoSelect({okCancelInMulti:true, selectAll:true });
        $('.select2').select2();
        $('#group_name').SumoSelect({search: true, placeholder: 'Select group'});


    });
</script>

<script type="text/javascript">
    $(function () {
        $('.opening_date').datetimepicker(
            {
                format: 'DD-MM-YYYY'
            }
        );
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
//                       

                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Financial Year Updated successfully</div></div>';
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

        $(document).on('click', '.btn_add',function (e) {
            e.preventDefault();
            $('#add').modal('show');
            $('#add').find('.modal-title').text('Add  Group');
          //  $('#item_group_form').find('.groupname').val('');
            $('#item_group_form').find('#submit_itemgroup').text('Save');
            $('#submit_itemgroup').addClass('add_item_group');
           // $('#submit_itemgroup').removeClass('update_item_group');
            var up_form = '<?= base_url();?>accounts/accounts/addGroup';
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
                            if(data.result=='add'){
                                var msg='New Ledger added successfully';
                            }else{
                                 var msg=' Ledger updated successfully';
                            }
                            




                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+msg+'</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();
                    setTimeout(function(){
                        $('#group_form')[0].reset();
                                $('#group_form').hide();

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



$('#group_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
      
      }          
    });

    });


</script>
<!--***************************sumo select end******************************-->


</body>
</html>