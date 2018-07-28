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
                        <h2>Edit Product<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" action="<?php echo base_url();?>admin/product/edit_product_byid/<?= $products['produ']['id'];?>" name="product_form" id="product_form" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Channel Partner</label>
                                            <select name="channel_partner" class="form-control channel_partner" id="channel_partner" data-rule-required="true">
                                                <option value="0">Select</option>
                                                <?php foreach($channel_partner as $cp){ ?>
                                                <option <?= $products['produ']['channel_partner_id'] == $cp['id'] ? "selected" : ""; ?> value="<?php echo $cp['id'];?>"><?php echo $cp['name'];?></option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Channel Partner Types</label>
                                            <select id="pro_category" class="form-control" name="pro_category" data-rule-required="true">
                                                
                                                <?php foreach($products['produ']['types'] as $category){?>
                                                  <optgroup label="<?= $category['title'] ?>">
                                                    <?php foreach($category['sub'] as $sub){?>
                                                       <option <?= $products['produ']['category_id'] == $sub['id'] ? "selected" : ""; ?> value="<?= $sub['id'] ?>"><?= $sub['title'] ?></option>
                                                    <?php } ?>   
                                                  </optgroup> 
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Channel Partner Sub Types</label>
                                            <select name="sub_type"  class="form-control search-box-open-up search-box-sel-all sub_type vh" data-rule-required="true">
                                                <option value="0">Select</option>
                                                <?php foreach($subtype as $s){ ?>
                                                <option <?= $products['produ']['sub_cp_type_id'] == $s['id'] ? "selected" : ""; ?> value="<?php echo $s['id'];?>"><?php echo $s['title'];?></option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Name</label>
                                            <input type="text" placeholder="Name" name="pro_name" class="form-control" value="<?= $products['produ']['name']?>" data-rule-required="true">
                                        </div>
                                      
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Model</label>
                                            <input type="text" placeholder="Product Model" name="pro_model" class="form-control" value="<?= $products['produ']['model']?>">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Brands</label>
                                            <select name="brands" class="form-control brands" id="brands" data-rule-required="true">
                                                <option value="0">Select</option>
                                                <?php foreach($brands as $br){ ?>
                                                <option <?= $products['produ']['brand_id']==$br['id'] ? "selected" :"" ; ?> value="<?php echo $br['id'];?>"><?php echo $br['name'];?></option>
                                                <?php } ?> 
                                            </select>
                                           
                                        </div>
                                        
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Actual Cost</label>
                                            <input type="text" placeholder="Actual Cost" name="pro_actualcost" id="pro_actualcost" class="form-control" value="<?= $products['produ']['actual_cost']?>" onKeyPress="return isFloatKey(event)">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Special Price</label>
                                            <input type="text" placeholder="Special Prize" name="special_prize" id="special_prize" class="form-control" value="<?= $products['produ']['special_prize']?>" onKeyPress="return isFloatKey(event)">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group" id="re_category">
                                            <label>Rewards Category</label>
                                            <select name="reward_category" class="form-control reward_category" id="reward_category" data-rule-required="true">
                                                <option value="0">Select</option>
                                                <?php foreach($type['reward'] as $s){ ?>
                                                <option <?= $products['produ']['reward_cat_id'] == $s['id'] ? "selected" : ""; ?> value="<?php echo $s['id'];?>"><?php echo $s['category_title'].'('.$s['percentage'].'%)';?></option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                         <label>Description</label>
                                          <textarea id="textarea" data-rule-required="true" name="pro_description" class="form-control col-md-7 col-xs-12"  rows="5" style="overflow: hidden; word-wrap: break-word; resize: horizontal; "><?= $products['produ']['description']?></textarea>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                        <label>image</label><br>
                                        <?php foreach ($products['produ']['images'] as $value) { ?>
                                          <div id="imagePreview" style="overflow:hidden;">
                                             <input type="hidden" name="img_id" class="img_id" value="<?= $value['id'];?>">
                                             <img src="<?php echo base_url(). $value['p_image']?>" style="max-width:100%;height:160px;">
                                             <button class="btn btn-danger del_img delteimagrbtn"><i class="fa fa-times"></i> Remove</button>
                                          </div> 
                                          
                                        <?php } ?>
                                        
                                        <input id="uploadFile" type="file" name="pro_image[]" class="img btn btn-danger" />
                                        <div class="clear"></div>

                                         </div>
 
                                        <div class="col-md-12 col-sm-6">
                                          <div id="selectedFiles"></div></div>

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
<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // bind form using ajaxForm
            // $('#product_form').ajaxForm({
            //     // dataType identifies the expected content type of the server response
            //     dataType:  'json',

            //     // success identifies the function to invoke when the server response
            //     // has been received
            //     success:   function(data){
            //         if(data.status){
            //             var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Product updated successfully</div></div>';
            //                     var effect='zoomIn';
            //                     $("#notifications").append(center);
            //                     $("#notifications-full").addClass('animated ' + effect);
            //                     refresh_close();
            //                     setTimeout(function(){
            //                       window.location = "<?php echo base_url();?>product_list/0";
            //                     }, 1000);
                        
            //         } else {
            //                var regex = /(<([^>]+)>)/ig;
            //                     var body = data.reason;
            //                     var result = body.replace(regex, "");
            //                     var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
            //                     var effect='fadeInRight';
            //                     $("#notifications").append(center);
            //                     $("#notifications-full").addClass('animated ' + effect);
            //                     $('.close').click(function(){
            //                         $(this).parent().fadeOut(1000);
            //                     });
            //         }

            //     }
            // });


            /////image delete
            $(document).on('click', '.del_img', function(e){
                e.preventDefault();
                var cur = $(this);
                var img_id = cur.parent().find('.img_id').val();
                $('body').alertBox({
                    title: 'Are You Sure?',
                    lTxt: 'Back',
                    lCallback: function(){
                      
                    },
                    rTxt: 'Okey',
                    rCallback: function(){
                  
                                $.post('<?php echo base_url();?>admin/home/delete_product_image/'+img_id, function(data){
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
                    }       
                });
            });
        }); 
    </script>

<!-- Datatables -->
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>
<!--============new customer popup start here=================-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#channel_partner').SumoSelect({search: true, placeholder: 'select channel partner'});
        $('#brands').SumoSelect({search: true, placeholder: 'select brands'});
        $('#pro_category').SumoSelect();
        $('.vh').SumoSelect();
    });
</script>
<script type="text/javascript">

    $(document).ready(function(){

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
                        var data = data.data.type;
                        // console.log(data);
                        var selop='<option>Select</option>';
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
                        
                    }
                    else{
                        // alert("failure");
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
                        var selop='<option>Select</option>';
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
<script type="text/javascript">
// $(function() {
//     $("#uploadFile").on("change", function()
//     {
//         var files = !!this.files ? this.files : [];
//         if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
//         if (/^image/.test( files[0].type)){ // only image file
//             var reader = new FileReader(); // instance of the FileReader
//             reader.readAsDataURL(files[0]); // read the local file
 
//             reader.onloadend = function(){ // set image data as background of div
//                 $("#imagePreview").css("background-image", "url("+this.result+")");
//             }
//         }
//     });
// });

$(document).ready(function() {
  $("#uploadFile").on("change", handleFileSelect);
  selDiv = $("#selectedFiles");
  $("#product_form").on("submit", handleForm);
  $("body").on("click", ".selFile", removeFile);
});

// var selDiv = "";
var storedFiles = [];
function handleFileSelect(e) {

          $("#selectedFiles").html('');

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
      var html = "<div class='col-md-4'><img src=\"" + e.target.result + "\" data-file='" + f.name + "'  class='' style='   max-width: 100%;height: 160px;' /><span data-file='" + f.name + "' class='selFile'>Remove </span></div>";
      $("#selectedFiles").append(html);
    }
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
    formData.append('pro_image[]', storedFiles[i]);
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
               
 var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Product updated successfully</div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                setTimeout(function(){
                                  window.location = "<?php echo base_url();?>product_list/0";
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







  nput = $('#num_file').find(':text'),
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