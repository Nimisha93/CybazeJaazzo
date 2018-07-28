<?= $header; ?>
<body>
<div class="wrapper">

<?= $sidebar; ?>

<div class="content">
<div class="container-fluid">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-text" data-background-color="orange">
                <h4 class="card-title"> Add Deals </h4>

            </div>
            <div class="card-content">

                 <form method="post" action="<?php echo base_url();?>admin/Deal/new_deal_add" name="product_form" id="product_form" enctype="multipart/form-data">
                    <div class="col-md-6 col-sm-6">
                    <div class="form-group label-floating is-empty">
                    <input type="hidden" name="deal_id" value="<?= $deal_id; ?>">
                    <input type="hidden" name="duration" value="<?= $duration; ?>">
                        <label class="control-label">Channel Partner Type</label>
                        <select class="form-control pro_category" name="pro_category" id="pro_category" data-rule-required="true">
                            <option value="0"></option>
                            <?php foreach($cp['type'] as $type){ ?>
                             
                              <optgroup label="<?php echo $type['title'];?>">
                                 <?php foreach($type['sub'] as $sub){ ?>
                                    <option value="<?php echo $sub['id'];?>-<?php echo $sub['con_id'];?>"><?php echo $sub['title'];?></option>
                                    <?php } ?>
                              </optgroup>      
                            <?php  } ?>       
                        </select>

                    </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Channel Partner Sub Types</label>
                            <select class="form-control" name="sub_type" id="sub_type" data-rule-required="true">
                                <option></option>
                                
                            </select>

                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                    <div class="form-group label-floating is-empty">
                    
                        <label class="control-label">Brands</label>
                        <select class="form-control brand" name="brand" id="brand" data-rule-required="true">
                            <option value="0"></option>
                             <?php foreach($brands as $br){ ?>
                              <option value="<?php echo $br['id'];?>"><?php echo $br['name'];?></option>
                             <?php } ?>      
                        </select>

                    </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" name="pro_name" data-rule-required="true">
                            <span class="material-input"></span><span class="material-input"></span></div>

                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Model</label>
                            <input type="text" class="form-control" name="pro_model">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Quantity</label>
                            <input type="text" class="form-control" name="pro_quantity" id="pro_quantity" onKeyPress="return isNumberKey(event)" data-rule-required="true">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Actual Cost</label>
                            <input type="text" class="form-control" name="pro_actualcost" id="pro_actualcost" onKeyPress="return isFloatKey(event)" data-rule-required="true">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Special Price</label>
                            <input type="text" class="form-control" name="special_prize" id="special_prize" onKeyPress="return isFloatKey(event)" data-rule-required="true">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label>Total Cost</label>
                            <input type="text" class="form-control" name="pro_cost" id="pro_cost" onKeyPress="return isFloatKey(event)" readonly="">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Coupon %</label>
                            <input type="text" class="form-control" name="coupon" id="coupon" onKeyPress="return isFloatKey(event)" data-rule-required="true" data-rule-max="100">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Coupon Validity</label>
                            <input type="text" class="form-control" name="coupon_validity" id="coupon_validity"  data-rule-required="true" >
                            <span class="material-input"></span><span class="material-input"></span>
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


                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill btn-rose prosubmit" name="prosubmit" id="prosubmit">Submit</button>

                    </div>
                </form>
            </div>
        </div>
    </div>




</div>

<?= $footer; ?>
<div id="notifications"></div><input type="hidden" id="position" value="center">

<!--************************row  end******************************************************************* -->
</div>

</body>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
       
        $('#coupon_validity').datetimepicker(
                {format: 'DD-MM-YYYY'}
        );
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pro_category').SumoSelect({search: true, placeholder: 'Select Category'});
        $('#sub_type').SumoSelect();
    });
</script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
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
                            console.log(data1);
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
                            noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                        }
                       $('#sub_type').SumoSelect({search:true,placeholder:'select sub types'});
                    },'json');

            });

        });
</script>
<script type="text/javascript">
        $(document).ready(function() {
   
            $('#pro_quantity').on('input',function() {
                calculte_cost();
            });
            $('#special_prize').on('input',function() {
                // isFloatKey(event);
                calculte_cost();
            });
        });
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
        function calculte_cost(){
            var quantity = isNaN(parseInt($('#pro_quantity').val())) ? 0 : parseInt($('#pro_quantity').val());
            var actualcost = isNaN(parseInt($('#special_prize').val())) ? 0 : parseInt($('#special_prize').val());
            var sal_one_day = quantity * actualcost;
            $("#product_form").find('#pro_cost').val(parseInt(sal_one_day));
            // var test = inWords(actualcost);
            // console.log(test);
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
               

                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added deal product</div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                setTimeout(function(){

                                   window.location = "<?php echo base_url();?>view_deal/0";
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