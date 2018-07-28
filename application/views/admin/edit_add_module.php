<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet" />

<!-- Font awsome -->
<link href="<?php echo base_url();?>fontawsome/jquerysctipttop.css" rel="stylesheet" type="text/css">

<link href="<?php echo base_url();?>fontawsome/simple-iconpicker.min.css" rel='stylesheet' type='text/css' />

</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Service<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" name="privmodel_form" id="privmodel_form" enctype="multipart/form-data" action="<?php echo base_url();?>admin/privillage/new_permission_module/">
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Name</label>
                                                <input type="text" placeholder="Service Name" name="module" class="form-control" data-rule-required="true">
                                        </div>

                        
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <div class="">
                                            <label>Icon</label>
                                            <input type="text" placeholder="images"  name="images" readonly="readonly" class="form-control imagess input1 input" data-rule-required="true">
                                            </div>
                                        </div>
                                            
                                          
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" rows="3" placeholder="Service Details" name="module_descp"></textarea>
                                        </div></div>
                                        <div class="col-md-12">
                                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                                            <label>&nbsp; </label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="header_module" onclick="$(this).attr('value', this.checked ? 1 : 0)" value="0">
                                                    Display in Header </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                                            <label> &nbsp; </label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="module_content" onclick="$(this).attr('value', this.checked ? 1 : 0)" value="0">
                                                    Display in Footer</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                          
                                            <input type="submit" class="btn btn-primary privmodel_submit" name="privmodel_submit" id="privmodel_submit" value="Save">
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

  


</div>
</div>
</div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script type='text/javascript' src="<?php echo base_url();?>fontawsome/simple-iconpicker.min.js"></script>

<script>
    var v = jQuery("#privmodel_form").validate({

        submitHandler: function(datas) {
        $('.body_blur').show();
            jQuery(datas).ajaxSubmit({
                
                dataType : "json",
                success  :    function(data)
                {
                     $('.body_blur').hide();
                    if(data.status)
                    {

                       
                       
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added new service </div></div>';
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
                        //$.toast(data.reason, {'width': 500});
                       // return false;
                    }
                }
            });
        }
     });
    var whichInput = 0;
    $(document).ready(function(){
        $('.input1').iconpicker(".input1");
    });
</script>
  <script type="text/javascript">
        $(document).ready(function(){
            /*$("#privmodel_submit").click(function(e){
                e.preventDefault();
                
                    var cur=$(this);
                    var data=$("#privmodel_form").serializeArray();
                    $('.body_blur').show();
                    $.post('<?php echo base_url();?>admin/privillage/new_permission_module/', data , function(data){
                        $('.body_blur').hide();
                        if(data.status){
                        alert("Successfully created");
                            //noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                            $("#privmodel_form")[0].reset();
                        }
                        else{
                        alert(data.reason);
                            //noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                        }

                    },'json');
                

            });*/

          

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

<!-- Font awsome -->
<style>

    .page{
        border:1px solid #bbb;
        margin:20px;
        padding:20px;
    }

    .input{
        border:1px solid #ccc;
        background:#efefef;
        padding:10px;
        font-size: 14px;
        border-radius:3px;
        outline: none;
    }
    .input:focus{
        border-color:#4598ff;
    }

    .incode{
        background:#efefef;
        padding:3px;
        color:#920000;
        font-family: monospace;
    }
    code{
        background:#efefef;
        border: 1px solid #ccc;
        padding: 10px;
        display:block;
        line-height: 18px;
    }
</style>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
<!-- End -->



<!-- Datatables -->

<!--============new customer popup start here=================-->

</body>
</html>