<?php echo $default_assets; ?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
<script type="text/javascript">
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
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
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Club Member Type<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <!-- <li>Fixed <div class="foo green"></div></li>
                            <li>Unlimited <div class="foo red"></div></li>
                            <li>Team Lead Club <div class="foo blue"></div></li> -->
                    
                            <li><a type="button" class="btn btn-danger fllft del_btn" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>  </li>
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="row">
                                <div class="col-sm-offset-7 col-sm-3">
                                    <label class="pull-right">Search:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                </div>
                            </div><br>
                            <table id="example" class="table" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>SI No.</th>
                                    <th>Club Name</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Cash limit(Per Year)</th>
                                    <!-- <th>Pooling Commision</th> -->
                                    <th>Club Agent Facility</th>
                                    <th>Channel Partner Facility</th>
                                    <th>Individual Friends Facility</th>
                                    <th>Jaazzo Store Facility</th>
                                    <th>BDE Facility</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <td colspan="12">
                                        <div class="pull-right" id="pagination"></div>
                                    </td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div id="notifications" style="z-index: 999999;"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ouelsr0cp0wd709qu42eo2a1fcw8iibuwekc5ntce4juh12z"></script>
<script>
</script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function stripHtml(html){
            // Create a new div element
            var temporalDivElement = document.createElement("div");
            // Set the HTML content with the providen
            temporalDivElement.innerHTML = html;
            // Retrieve the text property of the element (cross-browser support)
            return temporalDivElement.textContent || temporalDivElement.innerText || "";
        }

        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            if(search){
                $('.body_blur').hide();
            }else{
                $('.body_blur').show();
            }
            $.post(base_url + "all_club_types/" + index, { ajax: true,search:search}, function(data) {
                console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';var form ='';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cp_status = '';var club_agent_status ='';var user_status1='';var ba_status='';var bde_status='';var chk1='';var chk2='';var chk3='';
                        var typ = (data1[i].type=='INVESTOR')?'Team Lead Club':data1[i].type;
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        var ca =(data1[i].club_agent_status==1)?'Yes':'No';
                        var cp =(data1[i].cp_status==1)?'Yes':'No';
                        var ba =(data1[i].ba_status==1)?'Yes':'No';
                        var bde =(data1[i].bde_status==1)?'Yes':'No';
                        var user_status =(data1[i].user_status==1)?'Yes':'No';

                        var chk1 = (data1[i].type==='FIXED')?"checked":"";
                        var chk2 = (data1[i].type==='UNLIMITED')?"checked":"";
                        var chk3 = (data1[i].type==='INVESTOR')?"checked":"";

                        var cp_status= (data1[i].cp_status==1)?checked="checked":"";
                        var club_agent_status=(data1[i].club_agent_status==1)?checked="checked":"";
                        var user_status1=(data1[i].user_status==1)?checked="checked":"";
                        var ba_status =(data1[i].ba_status==1)?checked="checked":"" ;
                        var bde_status =(data1[i].bde_status==1)?checked="checked":"" ;
                        var form ='<div id="edit_'+data1[i].id+'" class="edit_form modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content">'+
                                                '<div class="modal-header"><button type="button" class="close" data-dismiss="modal">X</button><h4 class="modal-title">Edit Club Member Type</h4></div>'+
                                                '<form method="post" id="type_forms'+data1[i].id+'" class="type_forms" name="type_forms" action="<?php echo base_url();?>admin/Clubmember/update_club_member_type">'+
                                                    '<div class="modal-body">'+
                                                        '<div class="row">'+
                                                            '<div class="col-md-6 col-sm-6 col-xs-12 form-group">'+
                                                                '<label>Club Name</label>'+
                                                                '<input type="text" placeholder="Club Name" name="clubname" id="clubname" value="'+data1[i].title+'" class="form-control" data-rule-required="true" data-msg-required="Please enter club name field.">'+
                                                                '<input type="hidden" value="'+data1[i].id+'" class="hiddentype_id" name="id">'+
                                                            '</div>'+
                                                            '<div class="col-md-6 col-sm-6 col-xs-12 form-group">'+
                                                                '<label>Amount</label>'+
                                                                '<input type="text" placeholder="Amount" name="amount" id="amount" class="form-control" value="'+data1[i].amount+'" data-rule-required="true"  data-msg-required="Please enter amount field.">'+
                                                            '</div>'+
                                                            '<div class="row"><div class="col-md-6 col-sm-6 col-xs-12 form-group">'+
                                                                '<label>Description</label>'+
                                                                '<textarea class="form-control description_'+data1[i].id+'" title="Description" name="description" id="description" rows="4" placeholder="Description" class="form-control" data-rule-required="true"  data-msg-required="Please enter description field.">'+data1[i].description+'</textarea>'+
                                                            '</div>'+
                                                            '<div class="col-md-6 col-sm-6 col-xs-12 form-group">'+
                                                                '<label>No of Years</label>'+
                                                                '<input type="text" name="ussage_limit" id="ussage_limit" placeholder="No of Years" class="form-control" data-rule-required="true" value="'+data1[i].cash_limit+'" data-msg-required="Please enter usage limit field.">'+
                                                                '</div></div><div class="row"><br><div class="col-md-6 col-sm-6 col-xs-12 form-group"><label>Type</label>'+
                                                                '<input name="type" type="radio" class="type" '+chk1+' value="FIXED">&nbsp;Fixed'+
                                                                '<input name="type" type="radio" class="type" '+chk2+' value="UNLIMITED">&nbsp;Unlimited'+
                                                                '<input name="type" type="radio" class="type"  '+chk3+' value="INVESTOR">&nbsp;Team Lead Club'+ 
                                                            '</div></div>'+
                                                            '<div class="col-md-6 col-sm-6 col-xs-12 form-group benefit bde_benfit">'+
                                                                '<label>BDE Benefit</label>'+
                                                                '<input type="number"  class="form-control" name="bde_benfit" value="'+data1[i].bde_benefit+'" class="form-control"  onKeyPress="return isNumberKey(event)">'+
                                                            '</div>'+
                                                            '<div class="col-md-6 col-sm-6 col-xs-12 form-group benefit">'+
                                                                '<label>TL Benefit</label>'+
                                                                '<input type="number"  class="form-control" name="tl_benfit" value="'+data1[i].tl_benefit+'" class="form-control"  onKeyPress="return isNumberKey(event)">'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="row">'+
                                                            '<div class="col-md-6 col-sm-6 col-xs-12 form-group cp"><div class="row">'+
                                                                '<div class="col-md-3 col-sm-6 col-xs-12 form-group"><label>Channel Partner Facility</label><br />'+
                                                                    '<input name="channel_partner_fecility" type="checkbox" class="channel_partner_fecility" '+cp_status+' >'+
                                                                '</div>'+
                                                                '<div class="col-md-9 col-sm-6 col-xs-12 form-group cp_limit">'+
                                                                    '<label>Channel Partner Limit</label><br />'+
                                                                    '<input type="number" name="cp_limit" value="'+data1[i].cp_limit+'" class="form-control"  onKeyPress="return isNumberKey(event)">'+
                                                                '</div>'+
                                                                '<div class="col-md-12 col-sm-6 col-xs-12 form-group reward_per_cp">'+
                                                                    '<label>Reward Per Channel Partner </label><br />'+
                                                                    '<input type="number" name="reward_per_cp" value="'+data1[i].reward_per_cp+'" class="form-control"  onKeyPress="return isNumberKey(event)">'+
                                                                '</div>'+
                                                            '</div></div>'+
                                                            '<div class="ca col-md-6 col-sm-6 col-xs-12 form-group" id="ca">'+
                                                                '<div class="row">'+
                                                                '<style>.toggle.android { border-radius: 0px;}.toggle.android .toggle-handle { border-radius: 0px; }</style>'+
                                                                '<div class="ca_fai col-md-3 col-sm-6 col-xs-12 form-group">'+
                                                                    '<label>Club Agent Facility</label><br />'+
                                                                    '<input name="club_agent_fecility" type="checkbox" class="club_agent_fecility" '+club_agent_status+' >'+
                                                                '</div>'+
                                                                '<div class="col-md-9 col-sm-6 col-xs-12 form-group ca_limit">'+
                                                                    '<label>Club Agent Limit</label><br />'+
                                                                    '<input type="number" name="ca_limit" class="form-control" value="'+data1[i].ca_limit+'"  onKeyPress="return isNumberKey(event)">'+
                                                                '</div>'+
                                                            '</div></div>'+
                                                        '</div>'+
                                                        '<div class="row users">'+
                                                            '<div class="col-md-6 col-sm-6 col-xs-12 form-group">'+
                                                                '<div class="col-md-3 col-sm-6 col-xs-12 form-group">'+
                                                                    '<label>Individual Friend Facility</label><br />'+
                                                                    '<input name="user_fecility" type="checkbox"  '+user_status1+'  class="user_fecility">'+
                                                                '</div>'+
                                                                '<div class="col-md-9 col-sm-6 col-xs-12 form-group user_limit">'+
                                                                    '<label>Individual Friends Limit</label><br />'+
                                                                    '<input type="number" value="'+data1[i].user_limit+'"  name="user_limit" class="form-control"  onKeyPress="return isNumberKey(event)">'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="row ba">'+
                                                            '<div class="col-md-6 col-sm-6 col-xs-12 form-group">'+
                                                                '<div class="col-md-3 col-sm-6 col-xs-12 form-group"><label>Jaazzo Store Facility</label><br />'+
                                                                    '<input name="ba_fecility" type="checkbox" '+ba_status+' class="ba_fecility">'+
                                                                '</div>'+
                                                                '<div class="col-md-9 col-sm-6 col-xs-12 form-group ba_limit">'+
                                                                    '<label>Jaazzo Store Limit</label><br />'+
                                                                    '<input type="number" value="'+data1[i].ba_limit+'"  name="ba_limit" class="form-control"  onKeyPress="return isNumberKey(event)">'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="row bde">'+
                                                            '<div class="col-md-6 col-sm-6 col-xs-12 form-group">'+
                                                                '<div class="col-md-3 col-sm-6 col-xs-12 form-group"><label>BDE Facility</label><br />'+
                                                                    '<input name="bde_fecility" type="checkbox"  '+bde_status+' class="bde_fecility"></div>'+
                                                                '<div class="col-md-9 col-sm-6 col-xs-12 form-group bde_limit">'+
                                                                    '<label>BDE Limit</label><br />'+
                                                                    '<input type="number" value="'+data1[i].bde_limit+'"  name="bde_limit" class="form-control"  onKeyPress="return isNumberKey(event)">'+
                                                                '</div>'+
                                                            '</div> </div>'+
                                                    '</div>'+
                                                    '<div class="clearfix"></div>'+
                                                    '<div class="modal-footer">'+
                                                        '<div class="col-md-12 form-group ">'+
                                                            '<button type="button" class="btn btn-primary btn_save_club_type" id="editsub" data-id="'+data1[i].id+'">Submit</button></div>'+
                                                    '</div>'+
                                                '</form>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].title+'</td>'+
                            '<td>'+data1[i].amount+'</td>'+
                            '<td>'+typ+'</td>'+
                            '<td>'+stripHtml(data1[i].description)+'</td>'+
                            '<td>'+data1[i].amount/data1[i].cash_limit+'</td>'+
                            '<td>'+ca+'</td>'+
                            '<td>'+cp+'</td>'+
                            '<td>'+user_status+'</td>'+
                            '<td>'+ba+'</td>'+
                            '<td>'+bde+'</td>'+
                            '<td>'+form+'<a href="#" data-id="'+data1[i].id+'" class="clbtn"><button type="button" class="btn btn-primary type_sub"><i class="fa fa-pencil"></i> </button></a><input type="checkbox" name="" value="'+data1[i].id+'" class="chck_item_id"></td>'+
                            '</tr>';
                    }
                    $('tbody').html(tr);
                    $('#search').val(data.search);
                    // pagination
                    $('#pagination').html(data.pagination);

                }else{
                    tr += '<tr>'+
                            '<td colspan="12"> No data found</td>'+
                            '</tr>';
                    $('tbody').html(tr);
                }
            }, "json");
        }
        //calling the function
        load_demo();
        //pagination update
        $('#pagination').on('click', '.page_test a', function(e) {
            e.preventDefault();
            //grab the last paramter from url
            var link = $(this).attr("href").split(/\//g).pop();
            load_demo(link);
            return false;
        });
        $("#search").keyup(function(){
            load_demo();
        });
    });
    // $('input:radio[name="type"]').change(
    $(document).on('click','.type',function(){
        // function(){
           // alert("fghfgh");

            if ($(this).val() == 'FIXED') {
                $(".cp" ).show();
                $(".reward_per_cp" ).show();
                $(".bde_benfit" ).show();
                $(".ca" ).hide();
                $(".users" ).hide();
                $(".ba" ).hide();
                $(".bde" ).hide();
                $(".benefit").hide();
            }else if ($(this).val() == 'INVESTOR') {
                $(".cp" ).show();
                $(".reward_per_cp" ).hide();
                $(".ca" ).show();
                $(".users" ).show();
                $(".ba" ).show();
                $(".bde" ).show();
                $(".benefit").hide();
                $(".bde_benfit" ).hide();
            }else {
                $(".ca" ).show();$(".reward_per_cp" ).hide();
                $(".cp" ).show();
                $(".users" ).show();
                $(".ba" ).show();
                $(".bde" ).hide();
                $(".benefit").show();$(".bde_benfit" ).show();
            }
        }
    );
    $(function()
    {
 
      $(document).on('click','.club_agent_fecility',function()
      {
        if ($(this).is(':checked')) {
           $( ".ca_limit" ).toggle( "slow");
        }else{
            $(".ca_limit" ).hide();
        }
      });
      $(document).on('click','.channel_partner_fecility',function()
        //$('[name="channel_partner_fecility"]').change(function()
      {
        if ($(this).is(':checked')) {
           $( ".cp_limit" ).toggle( "slow");
        }else{
            $(".cp_limit" ).hide();
        }
      });
     $(document).on('click','.user_fecility',function()
      // $('[name="user_fecility"]').change(function()
      {
        if ($(this).is(':checked')) {
           $( ".user_limit" ).toggle( "slow");
        }else{
            $(".user_limit" ).hide();
        }
      });
      $(document).on('click','.ba_fecility',function()
      // $('[name="ba_fecility"]').change(function()
      {
        if ($(this).is(':checked')) {
           $( ".ba_limit" ).toggle( "slow");
        }else{
            $(".ba_limit" ).hide();
        }
      });
     $(document).on('click','.bde_fecility',function()
      //  $('[name="bde_fecility"]').change(function()
      {
        if ($(this).is(':checked')) {
           $( ".bde_limit" ).toggle( "slow");
        }else{
            $(".bde_limit" ).hide();
        }
      });
        $(document).on('click', '.clbtn',function () {
            var cur = $(this);
            var id = cur.data('id');
            var mdl = "#edit_"+id;
            $(mdl).modal('show');
            tinymce.init({
                selector: 'textarea.description_'+id,

                height: 80,
                theme: 'modern',
                file_browser_callback_types: 'file image media',
                automatic_uploads: true,
                images_upload_url: '',
                images_reuse_filename: true,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
                ],

                toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
                image_advtab: true,
                templates: [
                    { title: 'Test template 1', content: 'Test 1' },
                    { title: 'Test template 2', content: 'Test 2' }
                ],
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tinymce.com/css/codepen.min.css'
                ]
            });
            var type=$(mdl).find("input[name='type']:checked"). val();

            if ($(mdl).find('[class="club_agent_fecility"]').is(':checked')) {
               $( ".ca_limit" ).show();
            }else{
                $(".ca_limit" ).hide();
            }

            if ($(mdl).find('[class="channel_partner_fecility"]').is(':checked')) {
               $( ".cp_limit" ).show();
            }else{
                $(".cp_limit" ).hide();
            }

            if ($(mdl).find('[class="user_fecility"]').is(':checked')) {
               $( ".user_limit" ).show();
            }else{
                $(".user_limit" ).hide();
            }

            if ($(mdl).find('[class="ba_fecility"]').is(':checked')) {
               $( ".ba_limit" ).show();
            }else{
                $(".ba_limit" ).hide();
            }

            if ($(mdl).find('[class="bde_fecility"]').is(':checked')) {
               $( ".bde_limit" ).show();
            }else{
                $(".bde_limit" ).hide();
            }
            if(type=='FIXED'){
                $(".ca" ).hide();
                $(".users" ).hide();
                $(".bde" ).hide();
                $(".ba" ).hide();
                $(".bde" ).hide();
                $(".cp" ).show();
                $(".benefit").hide();
                $(".reward_per_cp" ).show();
                $(".bde_benfit" ).show();
            }else if(type=='INVESTOR'){
                $(".ca" ).show();
                $(".cp" ).show();
                $(".users" ).show();
                $(".bde" ).show();
                $(".ba" ).show();
                $(".reward_per_cp" ).hide();
                $(".benefit").hide();
                $(".bde_benfit" ).hide();
            }else{
                $(".ca" ).show();
                $(".cp" ).show();
                $(".ba" ).show();
                $(".users" ).show();
                $(".reward_per_cp" ).hide();
                $(".bde" ).hide();
                $(".benefit").show();$(".bde_benfit" ).show();
            }
        });
    });
</script>
<script>
    //Update Club Type
    $(document).on('click', '.btn_save_club_type', function(e){
        e.preventDefault();
        $('.body_blur').show();
        var cur = $(this);
        var id = cur.data('id');
        var va = "#type_forms"+id;
        var v = jQuery(va).validate();
        if (v.form()) {
            tinyMCE.triggerSave();
            jQuery(va).ajaxSubmit({
                dataType : "json",
                success  :    function(data)
                {
                    var modl = "#edit_"+id;
                    
                    $('.body_blur').hide();
                    if(data.status)
                    {
                        $(modl).modal('hide');
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text"> Club member type updated Successfully</div></div>';
                        var effect='zoomIn';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        refresh_close();
                    }
                    else
                    {
                        var regex = /(<([^>]+)>)/ig;
                        var body = data.reason;
                        var result = body.replace(regex, "");
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                        var effect='fadeInRight';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        // refresh_close();
                        $('.close').click(function(){
                            $(this).parent().fadeOut(1000);
                        });
                    }
                }
            });
        }
    });

    //Delete Club type
    $(document).on('click','.del_btn',function(){
        var cur=$(this);
        var chck_item_id = [];
        $('.chck_item_id').each(function () {
            var cur_this = $(this);
            var cur_val = $(this).val();
            if(cur_this.is(":checked")){
                chck_item_id.push(cur_val);
            }
        });
        if(chck_item_id.length > 0){
            $('body').alertBox({
                title: 'Are You Sure?',
                lTxt: 'Back',
                lCallback: function(){
                  
                },
                rTxt: 'Okey',
                rCallback: function(){
                    $('.body_blur').show();
                    $.post('<?php echo base_url();?>delete_club_type/',{chck_item_id:chck_item_id}, function(data){
                        $('.body_blur').hide();
                        if(data.status){
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted </div></div>';
                            var effect='zoomIn';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                        }else{
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                        }
                    },'json');
                }
            })
        }else{
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Please select atleast one club member type</div></div>';
            var effect='zoomIn';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            refresh_close();
        }
    });

</script>
<style>


