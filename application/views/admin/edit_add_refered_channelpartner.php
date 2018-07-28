<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
<?php echo $map['js']; ?>
<script type="text/javascript">
    function getPosition(newLat, newLng)
    {
        $('#lat').val(newLat);
        $('#long').val(newLng);
    }
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57 ))
            return false;
        return true;
    }
</script>
</head>
<?php echo $sidebar; ?>
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
                <div class="row">
                    <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>admin/Home/add_refered_partner" enctype="multipart/form-data">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Channel Details<small></small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="">
                                        <div class="">
                                            <div class="col-md-12">
                                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                    <label>Channel Name</label><label style="color:red;">(Mandatory)</label>
                                                    <input type="hidden" name="id" value="<?= $cp['id'];?>">
                                                    <input type="text" placeholder="Name of the Organization" name="name" value="<?= $cp['name'];?>" class="form-control" data-rule-required="true">
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                    <label>Module</label><label style="color:red;">(Mandatory)</label>
                                                    <select name="module" class="form-control search-box-open-up search-box" id="module" data-rule-required="true">
                                                        <option value="">Please Select</option>
                                                        <?php foreach ($modules['type'] as $type) { ?>
                                                        <option value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                    <label>Channel Partner Type</label><label style="color:red;">(Mandatory)</label>
                                                     <select id="channel_type" class="form-control search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" onchange="console.log($(this).val())" data-rule-required="true">
                                                        <?php foreach($category['type'] as $type){ ?>
                                                                                            
                                                                                           
                                                                                            <optgroup label="<?php echo $type['title'];?>">
                                                                                            <?php $pid=$type['id']; foreach($subcategory['type'] as $stype){ if($stype['parent']==$pid){ ?>

                                                            <option class="subc" value="<?php echo $stype['id'];?>"><?php echo $stype['title'];?></option>

                                                            <?php } ?> </optgroup> <?php } } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <label>Profile Image</label>
                                                    <div class="input-group">
                                                        <label class="input-group-btn">
                                                            <span class="btn btn-primary">
                                                                Browse&hellip; <input type="file" name="pro" id="pro" class="form-control" data-rule-required="true" style="display: none;" multiple >
                                                            </span>
                                                        </label>
                                                        <input type="text" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                    <label>Brand Image</label>
                                                    <div class="input-group">
                                                        <label class="input-group-btn">
                                                            <span class="btn btn-primary">
                                                                Browse&hellip; <input type="file" name="bri" data-rule-required="true" class="form-control" id="bri" style="display: none;" multiple>
                                                            </span>
                                                        </label>
                                                        <input type="text" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Contact Details<small></small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Email(Username)</label><label style="color:red;">(Mandatory)</label>
                                    <input type="email" name="email" class="form-control email" id="email" data-rule-required="true" data-rule-email="true" value="<?=$cp['email'];?>">
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Contact Number</label><label style="color:red;">(Mandatory)</label>
                                    <input type="number"  onKeyPress="return isNumberKey(event)" placeholder="Phone" name="phone" id="phone" class="form-control" data-rule-required="true" data-rule-number="true" value="<?=$cp['phone'];?>">
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Alternative Contact Number</label>
                                    <input type="number"  onKeyPress="return isNumberKey(event)" placeholder="Phone" name="phone2" class="form-control" data-rule-required="true" data-rule-number="true">
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Contact Person</label>
                                    <input type="text" placeholder="Contact Person" name="cname" class="form-control" data-rule-required="true" value="<?=$cp['cname'];?>">
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Contact Email</label>
                                    <input type="text" name="c_email" class="form-control c_email" id="c_email" data-rule-required="true" data-rule-email="true" placeholder="Contact Email" value="<?=$cp['c_email'];?>">
                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Contact Mobile</label>
                                    <input type="number"  onKeyPress="return isNumberKey(event)" name="c_mobile" class="form-control c_mobile" id="c_mobile" data-rule-required="true" data-rule-number="true"  placeholder="Contact Mobile"  value="<?=$cp['c_mobile'];?>">
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Alternative Contact Person</label>
                                    <input type="text" placeholder="Contact Person" name="acname" class="form-control" data-rule-required="true">
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Alternative Contact Email</label>
                                    <input type="text" name="ac_email" class="form-control ac_email" id="ac_email" data-rule-required="true" data-rule-email="true" placeholder="Contact Email">
                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Alternative Contact Mobile</label>
                                    <input type="number"  onKeyPress="return isNumberKey(event)" name="ac_mobile" class="form-control ac_mobile" id="ac_mobile" data-rule-required="true" data-rule-number="true" placeholder="Contact Mobile">
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Owner Contact Person</label><label style="color:red;">(Mandatory)</label>
                                    <input type="text" placeholder="Contact Person" name="ocname" class="form-control" value="<?=$cp['owner_name'];?>" data-rule-required="true">
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Owner Contact Email</label><label style="color:red;">(Mandatory)</label>
                                    <input type="text" name="oc_email" class="form-control oc_email" id="oc_email" data-rule-required="true" value="<?=$cp['owner_email'];?>" data-rule-email="true" placeholder="Contact Email">
                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>Owner Contact Mobile</label><label style="color:red;">(Mandatory)</label>
                                    <input type="number"  onKeyPress="return isNumberKey(event)" name="oc_mobile" class="form-control oc_mobile" id="oc_mobile" data-rule-required="true" data-rule-number="true"  placeholder="Contact Mobile" value="<?=$cp['owner_mobile'];?>">
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                    <label>Country</label><label style="color:red;">(Mandatory)</label>
                                    <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country" data-rule-required="true">
                                        <option value="">Please Select</option>
                                        <?php foreach ($countries as $key => $country) { ?>
                                        <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                    <label>State</label><label style="color:red;">(Mandatory)</label>
                                    <select name="state" class="form-control sel_state select_box_sel" id="sel_state" data-rule-required="true">
                                        <option value="">Please Select</option>
                                    </select>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                    <label>Town</label><label style="color:red;">(Mandatory)</label>
                                    
                                     <select name="town" class="form-control town" id="town" data-rule-required="true">
                                        <option value="">Please Select</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                    <label>Area </label> <label style="color:red;">(Mandatory)</label>
                                    <input type="text" placeholder="Area" name="area" class="form-control" data-rule-required="true" value="<?=$cp['area'];?>">
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" title="Address" name="address" rows="3" placeholder="Address" class="form-control" data-rule-required="true"><?=$cp['address'];?></textarea>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label>Latitude</label><label style="color:red;">(Mandatory)</label>
                                    <input type="text" placeholder="Latitude" id="lat" name="latt" class="form-control" data-rule-required="true">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label>Longitude</label><label style="color:red;">(Mandatory)</label>
                                    <input type="text" placeholder="Longitude" id="long" name="long" class="form-control" data-rule-required="true">
                                </div>

                                <div class="col-md-12">
                                    <?php echo $map['html']; ?>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Verification Details<small></small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="">
                                        <div class="">
                                            <div class="col-md-12">
                                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                    <label>Pan Number</label> <label style="color:red;">(Mandatory)</label>
                                                    <input type="text" placeholder="Pan Number of Company" name="pan" class="form-control" data-rule-required="true" id="pan" value="">
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                    <label>Gst Number</label>
                                                    <input type="text" name="gst" class="form-control" id="gst" placeholder="Gst Number" value="">
                                                </div>
                                                
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                  <label>Company Registration Document</label>
                                                  <div class="input-group">
                                                      <label class="input-group-btn">
                                                          <span class="btn btn-primary">
                                                              Browse&hellip; <input type="file" name="company_registration" id="company_registration" class="form-control" style="display: none;" >
                                                          </span>
                                                      </label>
                                                      <input type="text" class="form-control" readonly>
                                                  </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                  <label>Corporation/Panchayath/Muncipality License</label>
                                                  <div class="input-group">
                                                      <label class="input-group-btn">
                                                          <span class="btn btn-primary">
                                                              Browse&hellip; <input type="file" name="license" id="license" class="form-control" style="display: none;" >
                                                          </span>
                                                      </label>
                                                      <input type="text" class="form-control" readonly>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Bank Details<small></small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="">
                                        <div class="">
                                            <div class="col-md-12">
                                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                    <label>Bank Name</label>
                                                    <input type="text" name="bank_name" class="form-control" id="bank_name" >
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                    <label>Account Number</label>
                                                    <input type="text" name="ac_number" class="form-control" id="ac_number" >
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                    <label>Account Holder Name</label>
                                                    <input type="text" name="ac_holder_name" class="form-control" id="ac_holder_name">
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                    <label>IFSC Number</label>
                                                    <input type="text" name="ifsc" class="form-control" id="ifsc" >
                                                </div>
                                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                    <label>Branch Name</label>
                                                    <input type="text" name="branch" class="form-control" id="branch" >
                                                </div>
                                                <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                                    <!-- <div class="checkbox">
                                                        <label> <input type="checkbox"  name="isagree" data-rule-required="true" id="checkbox1" class="">
                                                            <p type="" class="" data-toggle="modal" data-target="#agree1"> Agree Terms and Condition</p> </label>
                                                    </div> -->

                                                    <div id="agree1" class="modal fade" role="dialog">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">X</button>
                                                                    <h4 class="modal-title">Modal Header</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                                                        <div class="panel">
                                                                            <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="color:#000">
                                                                                <h4 class="panel-title">Collapsible Group Items #1</h4>
                                                                            </a>
                                                                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                                                                <div class="panel-body">
                                                                                    <table class="table table-bordered">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th>#</th>
                                                                                            <th>First Name</th>
                                                                                            <th>Last Name</th>
                                                                                            <th>Username</th>
                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <th scope="row">1</th>
                                                                                            <td>Mark</td>
                                                                                            <td>Otto</td>
                                                                                            <td>@mdo</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">2</th>
                                                                                            <td>Jacob</td>
                                                                                            <td>Thornton</td>
                                                                                            <td>@fat</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">3</th>
                                                                                            <td>Larry</td>
                                                                                            <td>the Bird</td>
                                                                                            <td>@twitter</td>
                                                                                        </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="panel">
                                                                            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  style="color:#000">
                                                                                <h4 class="panel-title">Collapsible Group Items #2</h4>
                                                                            </a>
                                                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                                                                <div class="panel-body">
                                                                                    <p><strong>Collapsible Item 2 data</strong>
                                                                                    </p>
                                                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="panel">
                                                                            <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"  style="color:#000">
                                                                                <h4 class="panel-title">Collapsible Group Items #3</h4>
                                                                            </a>
                                                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                                                                                <div class="panel-body">
                                                                                    <p><strong>Collapsible Item 3 data</strong>
                                                                                    </p>
                                                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary antosubmit">Agree</button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                <input type="submit" class="btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit" value="Save">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
</div>
<?php echo $footer; ?>
<script type="text/javascript">
    $(document).ready(function () {
        var v = jQuery("#channel_form").validate({

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

                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added channel partner </div></div>';
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
                        }
                    }
                });
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).on('change', '#sel_country',function(){
        var cur = $(this);
        var country = cur.val();
        $('.body_blur').show();
        $('#sel_state')[0].sumo.unload();
        $.post('<?php echo base_url();?>admin/Home/get_state_by_id/'+country, function(data){
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
                
            }
            $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
        },'json');
    });
    $(document).on('change', '#sel_state',function(){
        var cur = $(this);
        var state = cur.val();
        $('.body_blur').show();
        $('#town')[0].sumo.unload();
        $.post('<?php echo base_url();?>admin/Home/get_town_by_id/'+state, function(data){
            $('.body_blur').hide();
            if(data.status)
            {
                var data = data.data;
                var option ='';
                option += '<option value="">Please Select</option>';
                for(var i=0; i<data.length; i++){
                    option += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }
                $('.town').html(option);
            } else{
                
            }
            $('#town').SumoSelect({search: true, placeholder: 'select state'});
        },'json');
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#email').focusout(function(){
            var mail = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/Home/mail_exists/',{mail :mail},
                    function(data)
                    {
                        if(data.status)
                        {
                            var regex = /(<([^>]+)>)/ig;
                            var body = "Mail Id Already Exists";
                            var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });

                            cur.val("");

                        }else{

                        }
                    },'json');
        });
        $('#phone').focusout(function(){
            var mob = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/Home/mobile_exists/',{mob :mob},
                    function(data)
                    {
                        if(data.status)
                        {

                            var regex = /(<([^>]+)>)/ig;
                            var body = "Mobile Number Already Exists";
                            var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });
                            cur.val("");
                        }else{

                        }
                    },'json');
        });
    });
</script>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>

<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<script type="text/javascript">
    $(document).ready(function () {
        //$('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,});
        $('#module').SumoSelect();
        $('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,triggerChangeCombined: false});
        $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
        $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
        $('#town').SumoSelect({search: true, placeholder: 'select city'});
    });
</script>
<script>
    $(document).ready(function() {
        //set initial state.
        $('#textbox1').val($(this).is(':checked'));

        $('#checkbox1').change(function() {
            $('#textbox1').val($(this).is(':checked'));
        });
        $(document).on('click','#checkbox1',function(){
            var cur=$(this);

            $('body').alertBox({
                title: 'Are You Sure?',
                lTxt: 'Back',
                lCallback: function(){

                },
                rTxt: 'Okey',
                rCallback: function(){


                }
            })
        });
        // $(".SumoSelect li").bind('click.check', function(event) {
        //         alert($(this).hasClass('selected'));
        // })


    });
</script>
<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>
<script>
    $(function() {
        $(document).on('change', ':file', function() {
            var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        $(document).ready( function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                        log = numFiles > 1 ? numFiles + ' files selected' : label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });
        });

    });
</script>
</body>
</html>