<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet" />
<?php echo $map['js']; ?>
<script type="text/javascript">
    function getPosition(newLat, newLng)
    {
        $('#lat').val(newLat);
        $('#long').val(newLng);
    }
</script>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."><i class="fa fa-info-circle" aria-hidden="true"></i></div>
            </h3>
        </div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
                </span> </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>update Business Associate<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="table-responsive tabmargntp30">
                            <form method="post"  name="product_forms" action="" id="product_forms" enctype="multipart/form-data">
                                <div class="col-md-12">
                                    <!--                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">-->
                                    <!--                                            <label>Ctaegory</label>-->
                                    <!--                                            <select id="pro_category" class="form-control validate[required] " name="pro_category">-->
                                    <!--                                                --><?php //foreach($product_cate['category'] as $category){?>
                                    <!--                                                <option value="--><?php //echo $category['id'];?><!--">--><?php //echo $category['title'];?><!--</option>-->
                                    <!--                                                --><?php //} ?>
                                    <!--                                            </select>-->
                                    <!--                                        </div>-->

                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Name</label>
                                        <input type="hidden" placeholder="Name" name="hiddenid" id="hiddenid" class="form-control validate[required]" value="<?php echo $viewba['id'];?>">

                                        <input type="text" placeholder="Name" id="ba_name" name="ba_name" value="<?php echo $viewba['name'];?>" class="form-control validate[required]">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Mobile No</label>
                                        <input type="text" placeholder="Mobile" id="ba_mobile" name="ba_mobile" value="<?php echo $viewba['mobil_no'];?>" class="form-control validate[required]">
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Email ID</label>
                                        <input type="text" placeholder="Email" id="ba_email" name="ba_email" value="<?php echo $viewba['email'];?>" class="form-control validate[required]">
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Company Name</label>
                                        <input type="text" placeholder="Company Name" id="ba_company_Name" value="<?php echo $viewba['company_name'];?>" name="ba_company_Name" class="form-control validate[required]">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Office Phone</label>
                                        <input type="text" placeholder="Office Phone" id="office_phone" name="office_phone"value="<?php echo $viewba['office_phno'];?>" class="form-control validate[required]">
                                    </div>


                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Office Email Id</label>
                                        <input type="text" placeholder="Office Email Id" id="office_email_id" value="<?php echo $viewba['office_email'];?>" name="office_email_id" class="form-control validate[required]">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>company Location</label>
                                        <input type="text" placeholder="Company Location" name="company_location" value="<?php echo $viewba['company_location'];?>" id="company_location" class="form-control validate[required]">
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <label>Latitude*</label>
                                        <input type="text" placeholder="Latitude" id="lat" name="lat" value="<?php echo $viewba['lat'];?>" class="form-control validate[required]">
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <label>Longitude*</label>
                                        <input type="text" placeholder="Longitude" id="long" name="long" value="<?php echo $viewba['lon'];?>" class="form-control validate[required]">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>City /Twon</label>
                                        <input type="text" placeholder="City" value="<?php echo $viewba['city'];?>"  id="city" name="city" class="form-control validate[required]">
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12"> <div class="form-group">
                                        <label for="Contact Person">Country</label>

                                        <select name="sel_country" id="sel_country" class="form-control validate[required] sel_country select_box_sel" id="sel_country">
                                            <option value="">Please Select</option>
                                            <?php foreach ($countries as $key => $country) { ?>
                                            <option   <?=$country['id'] == $viewba['country_id'] ? 'selected' : '';?> value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                            <?php  } ?>

                                        </select>
                                    </div></div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label for="Contact Number">State</label>
                                            <select name="sel_state" id="sel_state" class="validate[required]  form-control sel_state select_box_sel" id="sel_state">
                                                <option value="">Please Select</option>
                                            </select>
                                        </div></div>


                                    <!--                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">-->
                                    <!--                                            <label>Image</label>-->
                                    <!--                                            <input type="file" placeholder="Image" name="pro_image" class="form-control">-->
                                    <!---->
                                    <!--                                        </div>-->

                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <input type="submit" class="btn btn-primary prosubmit" name="prosubmit" id="prosubmit" value="Save">
                                    </div>
                                    <?php echo $map['html']; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<div class="clearfix"></div>

<!--************************row  end******************************************************************* -->

<script type="text/javascript">

    $(document).on('change', '#sel_country',function(){
        var cur = $(this);

        var country = cur.val();
        $('.body_blur').show();
        $.post('<?php echo base_url();?>admin/Executives/get_state_by_id/'+country, function(data){
            $('.body_blur').hide();
            if(data.status)
            {
                var data = data.data;

                var option ='';
                option += '<option value="">Please Select</option>';
                for(var i=0; i<data.length; i++){

                    option += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }

                $('.sel_state').html(option);
            } else{
                noty({text: data.reason, type:error, timeout:1000});
            }
        },'json');
    });
    $("#prosubmit").click(function(e){
        e.preventDefault();
        var str = $("#product_forms").validationEngine("validate");
        var hiddenid=$('#hiddenid').val();
        if(str==true){

            var data=$("#product_forms").serializeArray();
            $('.body_blur').show();

            $.post("<?php echo base_url();?>admin/Executives/edit_ba",data, function(data){
                $('.body_blur').hide();
                if(data.status){
                    noty({text:"Successfully updated",type: 'success',layout: 'top', timeout: 3000});
                    window.location = '<?=base_url();?>admin/Executives/ba_view';
                }
                else{
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                    $('#product_forms')[0].reset();
                }
            },'json');
        }
        else{

        }

    })
</script>




<script>
    $(document).ready(function() {

        $("#product_forms").validationEngine();

        var options = {
            dataType : "json",
            success  :    function(data)
            {
                if(data.status == true)
                {

                    noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                    $("#ba_name").val('');
                    $("#ba_mobile").val('');
                    $("#ba_email").val('');
                    $("#ba_company_Name").val('');
                    $("#office_phone").val('');
                    $("#office_email_id").val('');
                    $("#company_location").val('');
                    $("#city").val('');
                    $("#sel_country").val('');
                    $("#sel_state").val('');





                }
                else
                {
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                    return false;
                }
            }
        };
        $('#product_forms').submit(function(e){

            e.preventDefault();
            $('.body_blur').show();
            var st = $("#product_forms").validationEngine("validate");
            $('.body_blur').hide();
            if(st ==true)
            {

                $(this).ajaxSubmit(options);
                $('.body_blur').hide();

            }

        });


    });
</script>




</div>
</div>
</div>
</div>
</div>

<script>
    $(document).ready(function() {
        //set initial state.
        $('#textbox1').val($(this).is(':checked'));

        $('#checkbox1').change(function() {
            $('#textbox1').val($(this).is(':checked'));
        });

        $('#checkbox1').click(function() {
            if (!$(this).is(':checked')) {
                return confirm("Are you sure?");
            }
        });
    });
</script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>

<?php echo $footer; ?>


<!-- Datatables -->

<!--============new customer popup start here=================-->

<div id="newcstomr" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">X</button>
    <h4 class="modal-title">New Cutomer</h4>
</div>
<div class="modal-body">
<div id="testmodal" style="padding: 5px 20px;">
<form id="antoform" class="form-horizontal Calendar" role="form">
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <select id="heard" class="form-control" required="">
            <option value="">Saluation</option>
            <option value="press">Mr.</option>
            <option value="press">Mrs.</option>
            <option value="press">Ms.</option>
            <option value="press">Miss.</option>
            <option value="press">Dr.</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="First Name" class="form-control">
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="Last Name" class="form-control">
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="company name" class="form-control">
    </div>
    <div class="col-md-5 col-sm-11 col-xs-11 form-group">
        <input type="text" placeholder="company display name" class="form-control">
    </div>

    <div class="col-md-1 col-sm-1 col-xs-1">
        <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."><i class="fa fa-info-circle" aria-hidden="true"></i></div>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="Work Phone" class="form-control">
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="Mobile" class="form-control">
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group"> <a data-toggle="collapse" data-target="#morefield" class="lnht1">Add More Field</a> </div>
    <div class="clear"></div>
    <div id="morefield" class="collapse">
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <input type="text" placeholder="Skype Name/ No." class="form-control">
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <input type="text" placeholder="Designation" class="form-control">
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <input type="text" placeholder="Department" class="form-control">
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 form-group clear">
        <input type="text" placeholder="Website" class="form-control">
    </div>
</form>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_content">
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">other Details</a> </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Address</a> </li>
                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Custom Field</a> </li>
                    <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Reporting Tags</a> </li>
                    <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Remarks</a> </li>
                </ul>
                <div id="myTabContent" class="tab-content sclbr mdltab">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <select id="heard" class="form-control" required="">
                                <option value="">Saluation</option>
                                <option value="press">Mr.</option>
                                <option value="press">Mrs.</option>
                                <option value="press">Ms.</option>
                                <option value="press">Miss.</option>
                                <option value="press">Dr.</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <select id="heard" class="form-control" required="">
                                <option value="">Saluation</option>
                                <option value="press">Mr.</option>
                                <option value="press">Mrs.</option>
                                <option value="press">Ms.</option>
                                <option value="press">Miss.</option>
                                <option value="press">Dr.</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Allow portal access for this contact </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <select id="heard" class="form-control" required="">
                                <option value="">Portal Language</option>
                                <option value="press">Mr.</option>
                                <option value="press">Mrs.</option>
                                <option value="press">Ms.</option>
                                <option value="press">Miss.</option>
                                <option value="press">Dr.</option>
                            </select>
                        </div>
                        <div class="clear"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Facebook">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Twitter">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> </div>
                    </div>

                    <!--======================tab_content1 end ==========================-->

                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="tblttle">BILLING ADDRESS</h3>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Attention" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <textarea class="form-control" rows="3" placeholder="Street"></textarea>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="City" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="State" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Zip code" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <select id="heard" class="form-control" required="">
                                    <option value="">Country</option>
                                    <option value="press">Mr.</option>
                                    <option value="press">Mrs.</option>
                                    <option value="press">Ms.</option>
                                    <option value="press">Miss.</option>
                                    <option value="press">Dr.</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Fax" class="form-control">
                            </div>
                        </div>

                        <!--++++++++++++++++SHIPPING ADDRESS end +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="tblttle">SHIPPING ADDRESS</h3>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Attention" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <textarea class="form-control" rows="3" placeholder="Street"></textarea>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="City" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="State" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Zip code" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <select id="heard" class="form-control" required="">
                                    <option value="">Country</option>
                                    <option value="press">Mr.</option>
                                    <option value="press">Mrs.</option>
                                    <option value="press">Ms.</option>
                                    <option value="press">Miss.</option>
                                    <option value="press">Dr.</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Fax" class="form-control">
                            </div>
                        </div>

                        <!--++++++++++++++++SHIPPING ADDRESS end +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

                        <div class="col-md-12 col-sm-12 col-xs-12 form-group"> <strong>Note:</strong> You can add and manage additional addresses from contact details section. </div>
                    </div>
                    <!--======================tab_content2 end ==========================-->

                    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                        <p class="tabtxt">Start adding custom fields for your contacts by going to More Settings <strong> > </strong> Preferences <strong>></strong> Contacts. You can add as many as Ten extra fields, as well as refine the address format of your contacts from there. </p>
                    </div>
                    <!--======================tab_content3 end ==========================-->

                    <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                        <p class="tabtxt">You've not created any Reporting Tags.
                            Start creating reporting tags by going to More Settings <strong> > </strong> Reporting Tags </p>
                    </div>
                    <!--======================tab_content3 end ==========================-->

                    <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group"> <strong>Remarks </strong>(For Internal Use)
                            <textarea class="form-control" rows="5" placeholder="Street"></textarea>
                        </div>
                    </div>
                    <!--======================tab_content3 end ==========================-->

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary antosubmit">Save</button>
</div>
</div>
</div>
</div>
</body>
</html>