<?= $header; ?>
<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet" />

<style type="text/css">
    
   .slt {position: relative;} 
   .slt label.error{    position: absolute;
   left: 15px;
        bottom: -25px;}
</style>
<body>
<div class="wrapper">

<?= $sidebar; ?>

<div class="content">
<div class="container-fluid">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-text" data-background-color="orange">
                <h4 class="card-title"> Add Products </h4>

            </div>
            <div class="card-content">

                 <form method="post" action="<?php echo base_url();?>admin/Channel_partner/new_product_add" name="product_form" id="product_form" enctype="multipart/form-data">
                    <div class="col-md-6 col-sm-6 slt">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Channel Partner Type</label>
                        <select class="form-control pro_category" name="pro_category" id="pro_category"  data-rule-required="true">
                            <option ></option>
                            <?php foreach($cp['type'] as $type){ ?>
                             
                              <optgroup label="<?php echo $type['title'];?>">
                                 <?php foreach($type['sub'] as $sub){ ?>
                                    <option value="<?php echo $sub['id'];?>"><?php echo $sub['title'];?></option>
                                    <?php } ?>
                              </optgroup>      
                            <?php  } ?>       
                        </select>

                    </div>
                    </div>

                    <div class="col-md-6 col-sm-6 slt">
                        <div class="form-group label-floating is-empty" >
                            <label class="control-label">Channel Partner Sub Types</label>
                            <select class="form-control" name="sub_type" id="sub_type" data-rule-required="true">
                                <option></option>
                                
                            </select>

                        </div>
                    </div>


                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty"  style="margin-top: 25px">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" name="pro_name" data-rule-required="true">
                            <span class="material-input"></span><span class="material-input"></span></div>

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                     <div class="form-group label-floating is-empty" style="margin-top: -15px">
                        <label>Brands</label>
                        <select name="brands" class="form-control brands" id="brands" data-rule-required="true">
                            <option value="0">Select</option>
                            <?php foreach($brands as $br){ ?>
                            <option value="<?php echo $br['id'];?>"><?php echo $br['name'];?></option>
                            <?php } ?> 
                        </select>
                       </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Model</label>
                            <input type="text" class="form-control" name="pro_model" >
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Actual Cost</label>
                            <input type="text" class="form-control" name="pro_actualcost" id="pro_actualcost" data-rule-required="true" onKeyPress="return isFloatKey(event)">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Special Price</label>
                            <input type="text" class="form-control" name="special_prize" id="special_prize" data-rule-required="true" onKeyPress="return isFloatKey(event)">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                     <div class="form-group label-floating is-empty" style="margin-top: -15px">
                        <label>Rewards Category</label>
                        <select name="reward_category" class="form-control reward_category" id="reward_category" data-rule-required="true">
                            <option value="0">Select</option>
                            <?php foreach($category as $ct){ ?>
                            <option value="<?php echo $ct['id'];?>"><?php echo $ct['category_title'];?> (<?= $ct['percentage']; ?>%)</option>
                            <?php } ?> 
                        </select>
                       </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Description</label>
                            <textarea type="text" class="form-control" name="pro_description" data-rule-required="true"></textarea>
                            <span class="material-input"></span><span class="material-input"></span></div>

                    </div>

   <div class="col-md-4 col-sm-6 col-xs-12">
                                               <!--  <label>Images</label> -->
                                        <div class="input-group">
                                            <label class="input-group-btn">
                                                <span class="btn btn-primary" style="background-color: #3c4a7c;
    color: #ffffff;right: 9px;">
                                                    Select Image&hellip; <input type="file" style="display: none;" name="userfile[]" id="files"  multiple/>
                                                </span>
                                            </label>
                                            <!-- <input type="text" class="form-control" readonly> -->
                                        </div>
                                        </div>

<div class="col-md-12 col-sm-6">
  <div id="selectedFiles"></div></div>










 <!--  <div class="col-md-6 col-sm-6">

                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            <div>
                                                    <span class="btn btn-rose btn-round btn-file crsor">
                                                        <span class="fileinput-new crsor">Select image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" class="crsor" name="userfile[]" id="userfile"  multiple/>
                                                    </span>
                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                            </div>
                        </div>
                    </div> -->



                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill btn-rose prosubmit" name="prosubmit" id="prosubmit">Submit</button>

                    </div>
                </form>
            </div>
        </div>
    </div>




</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?= $footer; ?>


</body>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#pro_category').SumoSelect({search: true, placeholder: 'Select Category'});
        $('#sub_type').SumoSelect();
    });
</script>
<script type="text/javascript">
        $(document).ready(function(){

            $(document).on('change','#pro_category', function(e){
                e.preventDefault();
                
                var sta = $(this).val();
                var sta = sta.split("-");
                 $('#sub_type')[0].sumo.unload();
                var id = sta[0];
                //alert(id);
                    $('.body_blur').show();

                    $.post('<?php echo base_url();?>admin/Channel_partner/get_cp_sub_types', {id:id}, function(data){
                        $('.body_blur').hide();

                        if(data.status){
                            var data1 = data.data.type;
                          
                            var selop='<option value="0"></option>';
                            for (var j=0 ;j<data1.length;j++) {
                                selop +='<option value="'+data1[j].id+'">'+data1[j].title+'</option>';
                            }

                            var dd= '';
                            dd += ''+
                                    '<select class="form-control validate[required] select_box_sel select2 sub_type" name="sub_type">'+selop+'</select>'

                            $('#sub_type').html(dd);
                        }
                        else{
                           
                        }
                       $('#sub_type').SumoSelect({search:true,placeholder:'select sub types'});
                    },'json');
            });

        });
</script>
<script type="text/javascript">
      
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
                     


                  }

              });
          });
          
        });



       

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

<script type="text/javascript">



$(document).ready(function() {
  $("#files").on("change", handleFileSelect);
  selDiv = $("#selectedFiles");
  $("#product_form").on("submit", handleForm);
  $("body").on("click", ".selFile", removeFile);
});

// var selDiv = "";
var storedFiles = [];
function handleFileSelect(e) {
  var files = e.target.files;
  var filesArr = Array.prototype.slice.call(files);
  // var device = $(e.target).data("device");
  filesArr.forEach(function(f) {

    if (!f.type.match("image.*")) {
      return;
    }
    storedFiles.push(f);

    var reader = new FileReader();
    reader.onload = function(e) {
      var html = "<div class='col-md-4'><img src=\"" + e.target.result + "\" data-file='" + f.name + "'  class='' style='    width: 100%;height: 200px;' /><span data-file='" + f.name + "' class='selFile'>Remove </span></div>";
      $("#selectedFiles").append(html);
    }
    reader.readAsDataURL(f);


  });


}


 var m = $("#product_form").validate({

    
 });
function handleForm(e) {
  e.preventDefault();
  // var data = new FormData();

  // for (var i = 0, len = storedFiles.length; i < len; i++) {
  //   data.append('userfile', storedFiles[i]);
  // }

  
  //  e.preventDefault();

if(m.form())
{

 $('.body_blur').show();


      

        // }
 var formData = new FormData();
  for (var i = 0, len = storedFiles.length; i < len; i++) {
    formData.append('userfile[]', storedFiles[i]);
  }


         // console.log(formData);

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
//console.log(data.status);


                if(data.status === true)
                            {
               

                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Product added successfully</div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                setTimeout(function(){

                                    location.reload();
                                }, 1000);
                            }
                            else{
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
 //$('#landlord_form_p')[0].reset();
                                // $('#contact_form').hide();
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
  $(this).parent().remove();
  $('#files').val('');
}


</script>
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
</html>