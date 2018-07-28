<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/select2/select2.css">

</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Privillage<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post"  name="priv_form" id="priv_form" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Group Name</label>
                                            <input type="text" placeholder="Group Name" name="group_name" id="group_name" class="form-control validate[required] group_name">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Access Permission</label>
                                            <select id="access_perm" class="form-control validate[required] search-box-open-up search-box-sel-all testSelAll" name="access_perm[]"  multiple="multiple" onchange="console.log($(this).val())">
                                                <?php foreach($privillage['privi'] as $priv){?>
                                                <option value="<?php echo $priv['id'];?>"><?php echo $priv['privilege'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Allow Permission</label>
                                            <select id="allow_perm" class="form-control validate[required] allow_perm" name="allow_perm[]" multiple="multiple">

                                            </select>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <input type="submit" class="btn btn-primary persubmit" name="persubmit" id="persubmit" value="Save">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.testSelAll').on('click', function() {
                    var obj = [],
                            items = '';
                    var opt='';
                    $('.testSelAll option:selected').each(function() {
                        obj.push($(this).val());
                        var optval=$(this).val();
                        var opttext=$(this).text();
                        opt+='<option value="'+optval+'">'+opttext+'</option>';

//                        $('.testSelAll')[0].sumo.unSelectItem(i);
                    });
//                    console.log(opt);
//                    for(var i=0;i<obj.length;i++) {items += ' ' + obj[i]};
                    $(".allow_perm").html(opt);


                });

                $('#persubmit').click(function(e){
                    e.preventDefault();
                    var sta = $("#priv_form").validationEngine("validate");
                    if(sta== true){

                        var cur= $(this);
                        var data=$("#priv_form").serializeArray();
                        $('.body_blur').show();

                        $.post('<?php echo base_url();?>admin/privillage/set_new_privillage', data, function(data){
                            $('.body_blur').hide();

                            if(data.status){
                                noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                                $('#priv_form')[0].reset();
                            }
                            else{
                                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                            }

                        },'json');
                    }

                });

                $('#group_name').focusout(function(){
                    var group_name = $(this).val();
                    var cur = $(this);
                    $.post('<?php echo base_url();?>admin/privillage/group_exists/',{group_name :group_name},
                            function(data)
                            {
                                if(data.status)
                                {
                                    noty({text:"Group Already Exists",type: 'error',layout: 'top', timeout: 3000});
//                                    cur.next().text("Mailid Already Exists").css('color', 'red');
                                    $("#persubmit").hide();
                                }else{
                                    cur.next().remove();
                                    $("#persubmit").show();
                                }
                            },'json');
                });

            });
        </script>


    </div>
    <div class="clearfix"></div>

    <!--************************row  end******************************************************************* -->


</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/select2/select2.full.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        window.testSelAll = $('.testSelAll').SumoSelect({okCancelInMulti:true, selectAll:true });

    });
</script>
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