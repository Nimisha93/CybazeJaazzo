<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />

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
                        <h2>Add Channel Partner<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" name="channel_form" id="channel_form"  action="<?php echo base_url();?>admin/Channel_partner/new_partner"  enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <!-- <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Channel Partner Type</label>
                                            <select id="channel_type" class="form-control validate[required] search-box-open-up search-box-sel-all" name="channel_type[]" multiple="multiple" onchange="console.log($(this).val())">
                                            <?php foreach($partner_type['type'] as $type){?>
                                            <option value="<?php echo $type['id'];?>"><?php echo $type['title'];?></option>
                                            <?php } ?>
                                            </select>
                                        </div> -->
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Module</label>
                                            <select name="module" class="form-control search-box-open-up search-box" id="module">
                                            <option value="">Please Select</option>
                                            <?php foreach ($modules['type'] as $type) { ?>
                                            <option value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Channel Partner Type</label> 
                                            <select id="channel_type" class="form-control  search-box-open-up search-box-sel-all testSelAll2" name="channel_type[]" multiple="multiple" onchange="console.log($(this).val())">
                                            <?php foreach($category['type'] as $type){ ?>
                                            
                                            <option value="<?php echo $type['id'];?>"><?php echo $type['title'];?></option>
                                            
                                            <?php $pid=$type['id']; foreach($subcategory['type'] as $stype){ if($stype['parent']==$pid){ ?>

                                            <option class="subc" value="<?php echo $stype['id'];?>"><?php echo $stype['title'];?></option>
                                            
                                            <?php } } } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Name</label>
                                            <input type="text" placeholder="Name" name="name" class="form-control ">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Contact Person</label>
                                            <input type="text" placeholder="Name" name="cname" class="form-control ">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Contact Number</label>
                                            <input type="text" placeholder="Phone" name="phone" id="phone" class="form-control ">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Alternative Contact Number</label>
                                            <input type="text" placeholder="Phone" name="phone2" class="form-control">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" class="form-control  email" id="email">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Country</label>
                                            <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country">
                                            <option value="">Please Select</option>
                                            <?php foreach ($countries as $key => $country) { ?>
                                            <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>State</label>
                                            <select name="state" class=" form-control sel_state select_box_sel" id="sel_state">
                                             <option value="">Please Select</option>                                       
                                            </select>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Town</label>
                                            <input type="text" name="town" class="form-control " id="town">
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                            <label>Profile Image</label>
                                            <input type="file" name="pro" class="form-control " id="pro">
                                        </div>

                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                            <label>Brand Image</label>
                                            <input type="file" name="bri" class="form-control " id="bri">
                                        </div>

                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                            <label>new image</label>
                                            <input type="file" name="sda" >
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" title="Address" name="address" rows="3" placeholder="Address" class="form-control "></textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label>Latitude*</label>
                                            <input type="text" placeholder="Latitude" id="lat" name="latt" class="form-control ">
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label>Longitude*</label>
                                            <input type="text" placeholder="Longitude" id="long" name="long" class="form-control ">
                                        </div>

                                        <div class="col-md-12">
                                        <?php echo $map['html']; ?>
                                        <br>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <div class="checkbox">
                                                        <label> <input type="checkbox"  name="isagree" id="checkbox1" class="validate[required]">
                                                        <a type="button" class="" data-toggle="modal" data-target="#agree1"> Agree Terms and Condition</a> </label>
                                            </div>
                                            
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
                                                                    <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
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
                                                                    <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
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
                                                                    <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
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
                                            <!-- <button type="button" class="btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit">Save</button> -->
                                             <input type="submit" class="btn btn-primary prosubmit" name="prosubmit" id="prosubmit" value="Save">
                                        </div>
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
          $.post('<?php echo base_url();?>admin/Channel_partner/get_state_by_id/'+country, function(data){
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
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            // $('#channelsubmit').click(function(e){
            //     e.preventDefault();
            //     var sta = $("#channel_form").validationEngine("validate");
            //     if(sta== true){

            //         var cur= $(this);
            //         var data=$("#channel_form").serializeArray();
            //          var file_data = $('#pro').prop('files')[0];
                     
            //          data.append('file', file_data);
            //          console.log(data);
            //          console.log(file_data);
            //         $('.body_blur').show();

            //         $.post('<?php echo base_url();?>admin/Channel_partner/new_partner', data, function(data){
            //             $('.body_blur').hide();

            //             if(data.status){
            //                 noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
            //                 $('#channel_form')[0].reset();
            //             }
            //             else{
            //                 noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            //             }

            //         },'json');
            //     }

            // });

       // bind form using ajaxForm
            $('#channel_form').ajaxForm({
                  // alert("hi");
                // dataType identifies the expected content type of the server response
                dataType:  'json',

                // success identifies the function to invoke when the server response
                // has been received
                success:   function(data){
                    if(data.status){

                        noty({text: 'Product Added', type: 'success', timeout: 1000 });
                        window.location = "<?php echo base_url();?>product";
                    } else {
                        noty({text: data.reason, type: 'error', timeout: 1000 });
                    }

                }
            });
        $('#email').focusout(function(){
            var mail = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/channel_partner/mail_exists/',{mail :mail},
                   function(data)
                    {
                        if(data.status)
                        {
                            noty({text:"Mailid Already Exists",type: 'error',layout: 'top', timeout: 3000});
//                                    cur.next().text("Mailid Already Exists").css('color', 'red');
                            $("#channelsubmit").hide();
                        }else{
                            cur.next().remove();
                            $("#channelsubmit").show();
                        }
                    },'json');
        });
        $('#phone').focusout(function(){
            var mob = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/channel_partner/mobile_exists/',{mob :mob},
                    function(data)
                    {
                        if(data.status)
                        {
                            noty({text:"Mobile Number Already Exists",type: 'error',layout: 'top', timeout: 3000});
//                                    cur.next().text("Mailid Already Exists").css('color', 'red');
                            $("#channelsubmit").hide();
                        }else{
                            cur.next().remove();
                            $("#channelsubmit").show();
                        }
                    },'json');
        });
      });
    </script>


</div>
</div>
</div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
       // window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3, captionFormatAllSelected: "Yeah, OK, so everything." });
     //   window.test = $('.testsel').SumoSelect({okCancelInMulti:true, captionFormatAllSelected: "Yeah, OK, so everything." });
      //  window.testSelAll = $('.testSelAll').SumoSelect({okCancelInMulti:true, selectAll:true });
      //  window.testSelAlld = $('.SlectBox-grp').SumoSelect({okCancelInMulti:true, selectAll:true });

        window.testSelAll2 = $('.testSelAll2').SumoSelect({selectAll:true });


       // window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.' });
       // window.searchSelAll = $('.search-box-sel-all').SumoSelect({ csvDispCount: 3, selectAll:true, search: true, searchText:'Enter here.', okCancelInMulti:true });
       //window.searchSelAll = $('.search-box-open-up').SumoSelect({ csvDispCount: 3, selectAll:true, search: false, searchText:'Enter here.', up:true });

     //   window.groups_eg_g = $('.groups_eg_g').SumoSelect({selectAll:true, search:true });
    });
</script>
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
<?php echo $footer; ?>

