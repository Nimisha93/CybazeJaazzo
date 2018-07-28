<?php echo $default_assets; ?>

<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>

 <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
<style type="text/css">
    
   .slt {position: relative;} 
   .slt label.error{    position: absolute;
   left: 15px;
        bottom: -25px;}
</style>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">



        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Entries<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>

                            </li>
                           
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <form id="item_form" class="form-horizontal Calendar" method="post" action="<?php echo base_url();?>accounts/entries/add_new_entry" role="form">

                                <div class="col-md-4 col-sm-6 col-xs-12 form-group slt">
                                    <label>Entry Type</label>
                                    <select placeholder="Select Type" name="en_type" id="en_type" class="SlectBox form-control en_type   validate[required]"  data-rule-required="true">
                                        <option value="">Please select</option>


                                        <?php foreach($entries as $key => $entry){?>
                                        <option value="<?= $entry['id'];?>"><?= $entry['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Number</label>
                                    <input type="text" value="<?= $en_number;?>"  name="number" placeholder="Ledger Name" class="form-control validate[required]" readonly>


                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group" >

                                    <label>Entry Date</label>
                                    <div class='input-group date' id='datetimepicker6'>

                                        <input type='text' name="entry_date" class="form-control" placeholder="dd-mm-yyyy"   data-rule-required="true"/>
                <span class="input-group-addon"  style="height:28px">

                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                                    </div>

                                    <script type="text/javascript">
                                        $(function () {
                                            $('#datetimepicker6').datetimepicker({ format: 'DD-MM-YYYY'
//                                                startDate: today


                                            });
//                                            $('#datetimepicker7').datetimepicker({
//                                                useCurrent: false,format: 'DD/MM/YYYY' //Important! See issue #1075
//                                            });
//                                            $("#datetimepicker6").on("dp.change", function (e) {
//                                                $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
//                                            });

                                        });
                                    </script>



                                </div>







                                <div class="row">

                                    <div class="col-md-2"><div class="form-group">
                                        <label >Dr/Cr</label>

                                    </div></div>

                                    <div class="col-md-3"><div class="form-group">
                                        <label >Ledger</label>

                                    </div></div>

                                    <div class="col-md-2"><div class="form-group">
                                        <label >Dr Amount</label>

                                    </div></div>
                                    <div class="col-md-2"><div class="form-group">
                                        <label >Cr Amount</label>

                                    </div></div>



                                    <div class="col-md-2"><div class="form-group">
                                        <label >Current Bal</label>

                                    </div></div>
                                    <div class="col-md-1"><div class="form-group">
                                        <label >Action</label> <br>
                                    </div></div>
                                </div>

                                <div class="new_row">
                                    <div class="row">

                                        <div class="col-md-2"><div class="form-group">

                                            <select id="ledger_opening_type" class="form-control validate[required] ledger_opening_type" name="ledger_opening_type[]"  data-rule-required="true" >
                                                <option value="">Select</option>
                                                <option value="Dr">Dr</option>
                                                <option value="Cr">Cr</option>
                                            </select>

                                        </div></div>

                                        <div class="col-md-3 slt" ><div class="form-group">

                                            <select id="ledger_name" name="ledger_name[]" class=" form-control validate[required] select_box_sel select2  ledger_name" data-rule-required="true">
                                                <option value="">Select Ledger</option>
                                                <?php foreach ($groups['type'] as $key => $acc_type) { ?>
                                                <optgroup class="acc_type" label="<?=$acc_type['name'];?>"></optgroup>
                                                <?php foreach($acc_type['group'] as $key => $group){ ?>
                                                    <optgroup style="margin-left: 10px;" class="sub_group" label="<?= $group['name'];?>"></optgroup>
                                                    <?php foreach($group['ledger'] as $key => $ledger){ ?>
                                                        <option class="opt_ledger" value="<?= $ledger['id'];?>"><?= $ledger['name'];?></option>
                                                        <?php   }
                                                }
                                            } ?>
                                            </select>
                                        </div></div>

                                       
                                        <div class="col-md-2"><div class="form-group class_dr">

                                            <input type="text" name="amount_dr[]" class="form-control  amount_dr" id="amount_dr">

                                        </div></div>
                                        <div class="col-md-2"><div class="form-group class_cr">

                                            <input type="text" name="amount_cr[]" class="form-control   amount_cr" id="amount_cr">

                                        </div></div>

                                        <div class="col-md-2"><div class="form-group">

                                            <span class="cur_balance"></span>
                                        </div></div>
                                        <div class="col-md-1"><div class="form-group">

                                            <span class="btn btn-primary addrow mouse_pointer"><i class="glyphicon glyphicon-plus"></i></span>

                                        </div></div>
                                    </div>
                                </div>
                                <div class="row"  >

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label>Narration</label>
                                        <textarea class="form-control" name="narration"></textarea>
                                    </div><br>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input  id="add_journal_entry" type="submit"  value="Submit" class="btn btn-primary" >

                                </div>








<!--             



                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--************************row  end******************************************************************* -->



    <!--************************row  end******************************************************************* -->




</div>
</div>
<div class="clearfix"></div>



</div>
</div>
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
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />


<script type="text/javascript">
    $(document).ready(function () {
        $('.selectBox').SumoSelect({okCancelInMulti:true, selectAll:true });

         $('#en_type').SumoSelect({search: true, placeholder: 'Select type'});
         //$('#ledger_name').SumoSelect({search: true, placeholder: 'Select ledger'});

        $('.select2').select2();

    });
</script>




<script type="text/javascript">

$(document).ready(function(){
    var cur_type = $(document).find('#ledger_opening_type').val();
    var cur = $(this);
    // if(cur_type == 'Dr')
    //  {
    var tt = cur.parent().parent().parent().find('.ledger_name').text();

    cur.parent().parent().parent().find('.amount_cr').prop('readonly', true);
    $(document).find('#amount_cr').prop('readonly', true);
    //   cur.parent().parent().parent().find('.amount_dr').prop('enable',true);
    // } else{
    //   cur.parent().parent().parent().find('.amount_cr').prop('enable', true);
    //   cur.parent().parent().parent().find('.amount_dr').prop('disabled',true);
    // }

});
$(document).on('change', '.ledger_opening_type', function(){
    var cur = $(this);
    var openig_type = cur.val();

    if(openig_type == 'Dr')
    {
        cur.parent().parent().parent().find('.amount_cr').attr('readonly', 'readonly');
        cur.parent().parent().parent().find('.amount_cr').val('');

        cur.parent().parent().parent().find('.amount_dr').removeAttr('readonly', 'readonly');

    }
    if(openig_type == 'Cr')
    {
        cur.parent().parent().parent().find('.amount_dr').attr('readonly', 'readonly');
        cur.parent().parent().parent().find('.amount_dr').val('');

        cur.parent().parent().parent().find('.amount_cr').removeAttr('readonly', 'readonly');
    }
});


$(document).on('keypress',".amount_dr",function (e) {
    //if  theletter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
        return false;
    }
});
$(document).on('keypress',".amount_cr",function (e) {
    //if  theletter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
        return false;
    }
});

    $(document).on('click', '.addrow', function(){



        create_new_row();
    });

    function create_new_row()
    {
        var tr = '';
        var ledger = $("#ledger_name").html();
        var prop = $("#property_name").html();
        tr = '<div class="row newly_added_row">'+
                '<div class="col-md-2"><div class="form-group">'+
                '<select class="form-control ledger_opening_type" name="ledger_opening_type[]" required="">'+
                '<option value="">Select</option>'+
                '<option value="Dr">Dr</option>'+
                '<option value="Cr">Cr</option>'+
                '</select>'+
                '</div></div>'+
                '<div class="col-md-3"><div class="form-group">'+
                '<select name="ledger_name[]" class="validate[required] form-control ledger_name" required="">'+
                ledger+
                '</select>'+
                '</div></div>'+


                '<div class="col-md-2"><div class="form-group class_dr">'+
                '<input type="text" id="amount_dr" name="amount_dr[]" class="form-control amount_dr">'+
                '</div></div>'+
                '<div class="col-md-2"><div class="form-group class_cr">'+
                '<input type="text" name="amount_cr[]" readonly="readonly" class="form-control amount_cr">'+
                '</div></div>'+
                '<div class="col-md-2"><div class="form-group">'+
                '<span class="cur_balance"></span>'+
                '</div></div>'+
                '<div class="col-md-1"><div class="form-group">'+
                '<span class="btn btn-danger removerow mouse_pointer"><i class="glyphicon glyphicon-trash"></i></span>'+
                '</div></div>'+
                '</div>';
        $('.new_row').append(tr);
       $('.ledger_name').select2();
         // $('.ledger_name').SumoSelect({search: true, placeholder: 'Select ledger'});
    }

    $(document).on('click', '.removerow', function(){
        $(this).parent().parent().parent().remove();
    });

    $(document).ready(function() {

        var v = jQuery("#item_form").validate({
            submitHandler: function(datas) {
                var total_dr = 0;
                $('.class_dr').each(function(){
                    total_dr += +$(this).find('.amount_dr').val();

                });


                var total_cr = 0;
                $('.class_cr').each(function(){
                    total_cr += +$(this).find('.amount_cr').val();
                });

                if(total_cr == total_dr)
                {

                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#item_form').hide();
                            $('.body_blur').hide();

                           

                              var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">New Enrty Added Successfully </div></div>';
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
                       else{

            


              var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color:black;font-size:20px"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Total credit and debit must be same </div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                alert_close();
                                setTimeout(function(){

                                 
                                }, 1000);

            }
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
            var up_form = '<?= base_url();?>admin/accounts/addGroup';
            $("#item_group_form").attr("action", up_form);
        });
    });


    $(document).ready(function() {


        $(document).on('change', '.ledger_name', function() {




            var cur = $(this);
            var led_id = cur.val();


            var type_selected = cur.parent().parent().parent().find('.ledger_opening_type option:selected').val();

           
            $('.body_blur').show();
            $.post('<?= base_url();?>accounts/entries/get_cur_bal_ledger_by_id/'+led_id, function(data){
                $('.body_blur').hide();
                if(data.status)
                {
                    var led_bal = data.data;
                    if(led_bal > 0)
                    {


                        var bal = Math.abs(led_bal);
                        cur.parent().parent().parent().find('.cur_balance').text('Dr '+ bal);

                    }else{
                        var bal = Math.abs(led_bal);
                        cur.parent().parent().parent().find('.cur_balance').text('Cr '+ bal);
                    }

                }else{
                    var led_bal = data.data;
                    cur.parent().parent().parent().find('.cur_balance').text('Dr '+ led_bal);


                }
            },'json');

        });
    });


</script>
<!--***************************sumo select end******************************-->


</body>
</html>