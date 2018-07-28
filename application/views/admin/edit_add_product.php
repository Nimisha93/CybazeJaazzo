<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet" />

</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Product<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" action="<?php echo base_url();?>admin/Product/new_product_add" name="product_form" id="product_form" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                       <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Channel Partner</label>
                                            <select name="channel_partner" class="form-control channel_partner" id="channel_partner" data-rule-required="true">
                                                <option value="0">Select</option>
                                                <?php foreach($channel_partner as $cp)
                                                { 
                                                    ?>
                                                <option value="<?php echo $cp['id'];?>"><?php echo $cp['name'];?></option>
                                                <?php } ?> 
                                            </select>
                                           
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Channel Partner Type</label>
                                            <select name="pro_category"  class="form-control search-box-open-up search-box-sel-all" id="pro_category" data-rule-required="true">
                                                
                                            </select>
                                           
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Channel Partner Sub Types</label>
                                            <select name="sub_type"  class="form-control search-box-open-up search-box-sel-all sub_type vh" data-rule-required="true">

                                            </select>

                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group" style="clear: both;">
                                            <label>Name</label>
                                            <input type="text" placeholder="Name" name="pro_name" class="form-control" data-rule-required="true">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Description</label>
                                            <input type="text" placeholder="Description" name="pro_description" class="form-control" data-rule-required="true">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Brands</label>
                                            <select name="brands" class="form-control brands" id="brands">
                                                <option>Please Select</option>
                                                <?php foreach($brands as $br){ ?>
                                                <option value="<?php echo $br['id'];?>"><?php echo $br['name'];?></option>
                                                <?php } ?> 
                                            </select>
                                           
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Model</label>
                                            <input type="text" placeholder="Product Model" name="pro_model" class="form-control">
                                        </div>
                                       
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Actual Cost</label>
                                            <input type="text" placeholder="Actual Cost" name="pro_actualcost" id="pro_actualcost" class="form-control"  onKeyPress="return isFloatKey(event)">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Special Price</label>
                                            <input type="text" placeholder="Special Prize" name="special_prize" id="special_prize" class="form-control" onKeyPress="return isFloatKey(event)">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group" id="re_category">
                                            <label>Rewards Category</label>
                                            <select name="reward_category" class="form-control reward_category" id="reward_category" data-rule-required="true">
                                                <option value="0">Select</option>
                                                
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                        <label>Images</label>
                                        <div class="input-group">
                                            <label class="input-group-btn">
                                                <span class="btn btn-primary">
                                                    Browse&hellip; <input type="file" style="display: none;" name="userfile[]" id="userfile"  multiple/>
                                                </span>
                                            </label>
                                            <input type="text" id="num_file" class="form-control" readonly >
                                        </div>
                                        </div>


                                        <div class="col-md-12 col-sm-6">
                                          <div id="selectedFiles"></div>
                                        </div>
                  

                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
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

    


</div>
</div>
</div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">

<!--************************row  end******************************************************************* -->
</div>
<?php echo $footer; ?>
<script type="text/javascript">
        $(document).ready(function(){
            // $('#re_category').hide();  
            $('#channel_partner').change(function(e){
                e.preventDefault();
                var id = $(this).val();
                if(id!=''){
                    $('.body_blur').show();
                    $('#pro_category')[0].sumo.unload();
                    $.post('<?php echo base_url();?>admin/product/get_cp_type', {id:id}, function(data){
                        $('.body_blur').hide();
                    
                        if(data){
                            var data1 = data.data.reward;
                            // console.log(data);
                            var data = data.data.type;
                            var selop='<option value="0">Select</option>';
                            if(data){
                                for (var j=0;j<data.length;j++) {
                                 var optgroup='';
                                    for (var i=0;i<data[j].sub.length;i++) {
                                        optgroup +='<option value="'+data[j].sub[i].id+'-'+data[j].sub[i].con_id+'">'+data[j].sub[i].title+'</option>';
                                    }
                                    selop +='<optgroup label="'+data[j].title+'">'+optgroup+'</optgroup>';
                                }
                                $('#pro_category').html(selop);
                            }else{
                                $('#pro_category').html(selop);
                            }

                            //rewards
                            var selopt='<option value="0">Select</option>';
                            if(data1){
                                var optz = '';
                                  for (var k=0;k<data1.length;k++) {
                                    selopt +='<option value="'+data1[k].id+'">'+data1[k].category_title+'('+data1[k].percentage+'%)</option>';
                                  }
                                 //alert(selopt);
                                $('#reward_category').html(selopt);
                            }else{
                                $('#reward_category').html(selopt);
                            }
                            // $('#re_category').show();
                        }
                        else{
                            // $('#re_category').hide();
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Something went wrong</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });
                        }
                      $('#pro_category').SumoSelect({search:true,placeholder:'select sub types'});
                    },'json');
                }else{
                    var selopt='<option value="0">Select</option>';
                    $('#reward_category').html(selopt);
                    // $('#re_category').hide();
                }

            });

            $('#pro_category').change(function(e){
                e.preventDefault();
                var sta = $(this).val();
                var sta = sta.split("-");
                
                var id = sta[0];
                $('.vh')[0].sumo.unload();
                    $('.body_blur').show();

                    $.post('<?php echo base_url();?>admin/product/get_cp_sub_types', {id:id}, function(data){
                        $('.body_blur').hide();

                        if(data.status){
                            var data1 = data.data.type;
                            console.log(data1);
                            var selop='<option value="0">Select</option>';
                            for (var j=0 ;j<data1.length;j++) {
                                selop +='<option value="'+data1[j].id+'">'+data1[j].title+'</option>';
                            }

                            var dd= '';
                            dd += ''+
                                    '<select class="form-control validate[required] select_box_sel select2 sub_type" name="sub_type">'+selop+'</select>'

                            $('.vh').html(dd);
                        }
                        else{
                            noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                        }
                    $('.vh').SumoSelect({search:true,placeholder:'select sub types'});
                    },'json');
            });

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
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>



<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#channel_partner').SumoSelect({search: true, placeholder: 'select channel partner'});
        $('#brands').SumoSelect({search: true, placeholder: 'select brands'});
        $('#pro_category').SumoSelect();
        $('.vh').SumoSelect();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
  $("#userfile").on("change", handleFileSelect);
  selDiv = $("#selectedFiles");
  $("#product_form").on("submit", handleForm);
  $("body").on("click", ".selFile", removeFile);
});

var storedFiles = [];
function handleFileSelect(e) {
   
  var files = e.target.files;
  var filesArr = Array.prototype.slice.call(files);
  // var device = $(e.target).data("device");
  //alert(filesArr.length);
  filesArr.forEach(function(f) {

    if (!f.type.match("image.*")) {
      return;
    }
    storedFiles.push(f);

    var reader = new FileReader();
    reader.onload = function(e) {
      var html = "<div class='col-md-4'><img src=\"" + e.target.result + "\" data-file='" + f.name + "'  class='' style='        max-width: 100%;height: 160px;' /><span data-file='" + f.name + "' class='selFile'>Remove </span></div>";
      $("#selectedFiles").append(html);
    }





// for (var i = 0; i < storedFiles.length; i++) {

// }



    reader.readAsDataURL(f);


  });



        log = storedFiles.length > 0 ? storedFiles.length + ' files selected' : '';

          if( storedFiles.length>0) {
    $('#num_file').val(log);
          } else {
              if( log ) alert(log);
                  $('#num_file').val('');

          }


}



var m = $("#product_form").validate({
 });


function handleForm(e)
 {
  e.preventDefault();


if(m.form())
{

 $('.body_blur').show();


      

        // }
 var formData = new FormData();
  for (var i = 0, len = storedFiles.length; i < len; i++) {
    formData.append('userfile[]', storedFiles[i]);
  }


       

            var other_data = $("#product_form").serializeArray();

 $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });

      


        $.ajax({
           
                    url: $(this).attr('action'),
                    data: formData,
            processData: false,
            contentType: false,
             dataType : "json",
            type: "POST",
            success: function (data) 
            {
            $('.body_blur').hide();   


                if(data.status === true)
                            {
               

                                 
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Product added successfully</div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                setTimeout(function(){

                                    //$('#channel_form').hide();
                                    location.reload();
                                }, 1000);
                            }
                            else{
                                var regex = /(<([^>]+)>)/ig;
                                var body = data.reason;
                                var result = body.replace(regex, "");    
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                $('.close').click(function(){
                                    $(this).parent().fadeOut(1000);
                                });
                                // setTimeout(function(){

                                //     //$('#channel_form').hide();
                                //     //location.reload();
                                // }, 1000);

                            }

            },

            error: function (data) 
            {
                $('.body_blur').hide();
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


        });
    

    }


}

function removeFile(e) {
  var file = $(this).data("file");
  for (var i = 0; i < storedFiles.length; i++) {
    if (storedFiles[i].name === file) {
      storedFiles.splice(i, 1);
      break;
    }
  }
 $('#files').val('');
  $(this).parent().remove();

        // label = $('#num_file').replace(/\\/g, '/').replace(/.*\//, '');



  // var input = $('#num_file').find(':text'),
            log = storedFiles.length > 0 ? storedFiles.length + ' files selected' : '';

          if( storedFiles.length>0) {
    $('#num_file').val(log);
          } else {
              if( log ) alert(log);
                  $('#num_file').val('');

          }



}


</script>
<script type="text/javascript">
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
  }
  function isFloatKey(e){
     var charCode = (e.which) ? e.which : e.keyCode
    if ((charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57))
        return false;
    return true;
  }
</script>
<!-- Datatables -->

<!--============new customer popup start here=================-->

<style type="text/css">
    .selFile {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
  width: 100%;
}
.selFile:hover {
  background: white;
  color: black;
</style>
</body>
</html>