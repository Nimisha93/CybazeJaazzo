<?= $header; ?>
<body>
<div class="wrapper">

<?= $sidebar; ?>

<div class="content">
<div class="container-fluid">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-text" data-background-color="orange">
                <h4 class="card-title"> Edit Products </h4>

            </div>
            <div class="card-content">

                 <form method="post" action="<?php echo base_url();?>admin/deal/edit_deal_byid/<?= $products['produ']['id'];?>" name="product_form" id="product_form" enctype="multipart/form-data">
                    <div class="col-md-6 col-sm-6">
                    <div class="form-group label-floating is-empty">
                        <label class="">Channel Partner Type</label>
                        
                        <select id="pro_category" class="form-control" name="pro_category" data-rule-required="true">
                            <?php foreach($product_cate['type'] as $type){ ?>
                            <optgroup label="<?php echo $type['title'];?>">
                            
                            <?php foreach($type['sub'] as $sub){ ?>
                                <option <?= $products['produ']['category_id']==$sub['id'] ? 'selected' : ''?> value="<?php echo $sub['id'];?>-<?php echo $sub['con_id'];?>"><?php echo $sub['title'];?></option>
                                <?php } ?>
                          </optgroup>      
                        <?php  } ?>
                        </select>

                    </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="">Channel Partner Sub Types</label>
                            <select class="form-control" name="sub_type" id="sub_type" data-rule-required="true">
                                 <?php foreach($products['produ']['types'] as $type1){?>
                                    <option <?= $products['produ']['sub_cp_type_id']==$type1['id'] ? 'selected' : ''?>  value="<?php echo $type1['id'];?>"><?php echo $type1['title'];?></option>
                                    <?php } ?>
                                
                            </select>

                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                    <div class="form-group label-floating is-empty">
                    
                        <label>Brands</label>
                        <select class="form-control brand" name="brand" id="brand">
                            <option value="0">Select</option>
                             <?php foreach($brands as $br){ ?>
                              <option <?= $products['produ']['brand_id']==$br['id'] ? 'selected' : ''?> value="<?php echo $br['id'];?>"><?php echo $br['name'];?></option>
                             <?php } ?>      
                        </select>

                    </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="">Name</label>
                            <input type="hidden" name="deal_id" class="form-control" value="<?= $products['produ']['type']?>">
                            <input type="text" name="pro_name" class="form-control" value="<?= $products['produ']['name']?>" data-rule-required="true">
                            
                            <span class="material-input"></span><span class="material-input"></span></div>

                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="">Model</label>
                            <input type="text" name="pro_model" class="form-control" value="<?= $products['produ']['model']?>">
                            
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label>Quantity</label>
                            <input type="text" class="form-control" name="pro_quantity" id="pro_quantity" value="<?= $products['produ']['quantity']?>" onKeyPress="return isNumberKey(event)">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="">Actual Cost</label>
                            
                            <input type="text" name="pro_actualcost" id="pro_actualcost" class="form-control" value="<?= $products['produ']['actual_cost']?>" data-rule-required="true" onKeyPress="return isFloatKey(event)">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="">Special Price</label>
                           
                            <input type="text" name="special_prize" id="special_prize" class="form-control" value="<?= $products['produ']['special_prize']?>" data-rule-required="true" onKeyPress="return isFloatKey(event)">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label>Total Cost</label>
                            <input type="text" class="form-control" name="pro_cost" id="pro_cost" value="<?= $products['produ']['special_prize'] * $products['produ']['quantity']?>" readonly="">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label>Coupon %</label>
                            <input type="text" class="form-control" name="coupon" id="coupon" value="<?= $products['produ']['coupon_percentage']?>" onKeyPress="return isFloatKey(event)">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="">Coupon Validity</label>
                            <input type="text" class="form-control" name="coupon_validity" id="coupon_validity"  data-rule-required="true" value="<?= $products['produ']['coupon_validity']?>">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group label-floating is-empty">
                            <label class="">Description</label>
                           
                             <textarea type="text" id="textarea" required="" name="pro_description" class="form-control" data-rule-required="true"><?= $products['produ']['description']?></textarea>
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
                        
                    <?php if(isset($products['produ']['images'])){ foreach ($products['produ']['images'] as $img_value) { ?>
                    <div class="img_div col-md-3 col-sm-6 col-xs-12">
                        <label>Choosed Image</label><br />
                        <div class="form-control" style="height:120px;">
                            <input type="hidden" name="img_id" class="img_id" value="<?= $img_value['id'];?>">

                            <img style="width: 105px; height: 105px;display:block;margin:auto"  src="<?php echo base_url().$img_value['p_image'];?>"><br><br>                                                   </div>
                        <button class="btn btn-danger del_img delteimagrbtn"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                    </div>
                    <?php } }?>   


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
    $(document).ready(function() {
       
        $('#coupon_validity').datetimepicker(
                {format: 'DD-MM-YYYY'}
        );
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
   
        //delete image
         $(document).on('click', '.del_img', function(e){
            e.preventDefault();
            var cur = $(this);
            var img_id = cur.parent().find('.img_id').val();
           
                        $.post('<?php echo base_url();?>admin/Channel_partner/delete_product_image/'+img_id, function(data){
                            if(data.status)
                            {
                                cur.parent().remove();
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted image</div></div>';
                            var effect='zoomIn';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
                            }else{
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
                        },'json');
                   
        });

         $('#pro_quantity').on('input',function() {
                calculte_cost();
            });
            $('#pro_actualcost').on('input',function() {
                calculte_cost();
            });

    });
   
</script>
<script type="text/javascript">
$(function() {
    $("#uploadFile").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                $("#imagePreview").css("background-image", "url("+this.result+")");
            }
        }
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
  function calculte_cost(){
            var quantity = isNaN(parseInt($('#pro_quantity').val())) ? 0 : parseInt($('#pro_quantity').val());
            var actualcost = isNaN(parseInt($('#pro_actualcost').val())) ? 0 : parseInt($('#pro_actualcost').val());
            var sal_one_day = quantity * actualcost;
            $("#product_form").find('#pro_cost').val(parseInt(sal_one_day));
            var test = inWords(cost);
            console.log(test);
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


if(m.form())
{

 $('.body_blur').show();


      

        // }
 var formData = new FormData();
  for (var i = 0, len = storedFiles.length; i < len; i++) {
    formData.append('pro_image[]', storedFiles[i]);
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
               

                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully updated deal</div></div>';
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