<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">

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
                        <h2>Commission<small></small></h2>
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
                                    <th>Channel Partner Type</th>
                                    <th>Direct Commmission</th>
                                    <th>Company Commission</th>

                                    <th></th>


                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Channel Partner Type</th>
                                    <th>Direct Commmission</th>
                                    <th>Company Commission</th>

                                    <th></th>

                                </tr>
                                </tfoot>
                                <tbody style=" height:100px;overflow:scroll">
                                <?php foreach($commission['commission'] as $commi){?>
                                <tr><input type="hidden" value="<?php echo $commi['id'];?>" class="hiddentype_id">
                                    <td class="titleclass"><?php echo $commi['title'];?></td>
                                    <td class="direct_commi"> <?php echo $commi['direct_commission'];?></td>
                                    <td class="pooling_commi"><?php echo $commi['pooling_commission'];?></td>
                                    <td><button type="button" class="type_sub" class="btn btn-primary type_sub" data-toggle="modal" data-target="#agree1">Edit </button>
                                        <button type="button" class="btn btn-danger commission_delete">Delete </button></td>

                                </tr>
                                    <?php }?>
                                <div id="agree1" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">X</button>
                                                <h4 class="modal-title">Edit Commission</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel">


                                                    </div>
                                                    <form method="post" id="commission_forms" class="commission_forms" name="commission_forms">
                                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                                            <label>Channel Partner Type</label>
                                                            <input type="hidden" placeholder="Last Name" class="form-control" id="hiddentype" name="hiddentype">
                                                            <select id="channel_type" class="form-control validate[required]" name="channel_type">
                                                                <?php foreach($partner_type['type'] as $type){?>
                                                                <option value="<?php echo $type['conid'];?>"><?php echo $type['title'];?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                                            <label>Company Commission</label>
                                                            <input type="text" placeholder="Company Commission" class="form-control validate[required]" id="company_commi" name="company_commi">
                                                        </div>
                                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                                            <label>Direcy Commission</label>
                                                            <input type="text" placeholder="Direct Commission" class="form-control validate[required]" id="direct_commi" name="direct_commi">
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary editsub" id="editsub">Submit</button>
                                            </div>
                                            </form>
                                        </div>



                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function(){
                                        $(document).on('click','.type_sub',function(){
                                            var cur=$(this);
                                            var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
                                            var title=cur.parent().parent().find('.titleclass').text();
                                            var direct=cur.parent().parent().find('.direct_commi').text();
                                            var pooling=cur.parent().parent().find('.pooling_commi').text();
                                            $(document).find('#title').val(title);
                                            $(document).find('#company_commi').val(pooling);
                                            $(document).find('#direct_commi').val(direct);
                                            $(document).find('#hiddentype').val(hiddentype_id);

                                        });
                                        $("#editsub").click(function(e){
                                            e.preventDefault();
                                            var str = $("#commission_forms").validationEngine("validate");
                                            if(str==true){

                                                var data=$("#commission_forms").serializeArray();
                                                console.log(data);
                                                $('.body_blur').show();
                                                $.post("<?php echo base_url();?>admin/pooling/edit_pooling_byid", data, function(data){
                                                    $('.body_blur').hide();
                                                    if(data.status){
                                                        noty({text:"Successfully updated",type: 'success',layout: 'top', timeout: 3000});
                                                        $('#commission_forms')[0].reset();
                                                        window.location="<?php echo base_url();?>channel_pooling";
                                                    }
                                                    else{
                                                        noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                                                        $('#commission_forms')[0].reset();
                                                    }
                                                },'json');
                                            }
                                            else{

                                            }

                                        })
                                        $(document).on('click','.commission_delete',function(){
                                            var cur=$(this);
                                            var hiddentypeid=cur.parent().parent().find('.hiddentype_id').val();
                                            noty({
                                                text: 'Do you want to continue?',
                                                type: 'warning',
                                                buttons: [
                                                    {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                                                        // this = button element
                                                        // $noty = $noty element

                                                        $noty.close();
                                                        $('.body_blur').show();
                                                        $.post('<?php echo base_url();?>admin/Pooling/delete_commissionbyid/'+hiddentypeid, function(data){
                                                            $('.body_blur').hide();
                                                            if(data.status){
                                                                noty({text: 'Deleted Succesfully', type: 'success', timeout:1000});
                                                                cur.parent().parent().remove();
                                                            }else{
                                                                noty({text: 'Database Error', type: 'error'});
                                                            }
                                                        },'json');
                                                    }
                                                    },
                                                    {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                                                        $noty.close();

                                                    }
                                                    }
                                                ]
                                            });

                                        })
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

</script>


<!-- Datatables -->

<!--============new customer popup start here=================-->

<div id="newcstomr" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">X</button>
    <h4 class="modal-title">New Customer</h4>
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
