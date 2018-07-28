<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
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
                        <h2>Deal<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                            <!-- <li><a class="btn btn-primary editsub"  style="background-color:#162b52"  href="<?php echo base_url();?>partner_type"><i class="fa fa-user-plus"></i></a> </li> -->
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="tabmargntp30">
                                <form method="post" action="<?php echo base_url();?>admin/home/add_new_deal" name="product_form" id="product_form">
                                    <div class="col-md-12">

                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Title</label>
                                            <input type="text" placeholder="Title" name="pro_name" class="form-control" value="" data-rule-required="true">
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Amount</label>
                                            <input type="text" placeholder="Amount" name="amount" class="form-control" value="" onKeyPress="return isFloatKey(event)">
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Duration(In Hours)</label>
                                            <input type="text" placeholder="Duration" name="duration" class="form-control duration" value="" data-rule-required="true" data-rule-number="true" onKeyPress="return isNumberKey(event)">
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Description</label>
                                            <input type="text" placeholder="Description" name="pro_description" class="form-control" value="" data-rule-required="true">
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
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>All Deals<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                            <li><a type="button" class="btn btn-danger fllft del_btn" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                           </li>
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
                        <table id="example" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr class="tablbg">
                                    <th style="width: 45px">Sl no.</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Duration</th>
                                    <th>Description</th>
                                    <th style="width: 80px">Action</th>
                                </tr>
                            </thead>
                            <tbody style=" height:100px;overflow:scroll">
                                    
                            </tbody>
                            <tfoot>
                                <td colspan="6">
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
</div>
</div>
</div>
</div>
<!--modal -->
<div id="deal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h4 class="modal-title">Edit Deal</h4>
            </div>
            <form method="post" id="update_deal" class="update_deal" name="update_deal" action="<?php echo base_url();?>admin/home/update_deal_by_id">
               
                <div class="modal-body"  style="overflow:hidden;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Title</label>
                        <input type="hidden" class="form-control hiddentype" id="hiddentype" name="hiddentype">
                        
                        <input type="text" placeholder="Title" class="form-control" id="title" name="title"  data-rule-required="true">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label>Amount</label>
                        <input type="text" placeholder="Amount" class="form-control" id="amount" name="amount"  onKeyPress="return isFloatKey(event)">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label>Duration(In Hours)</label>
                        <input type="text" placeholder="Duration" class="form-control" id="duration" name="duration"  data-rule-required="true" onKeyPress="return isNumberKey(event)">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label>Description</label>
                        <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description"  data-rule-required="true"></textarea>

                    </div>   
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                   <input type="submit" class="btn btn-primary amountsub" name="amountsub" id="amountsub" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal -->
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            if(search){
                $('.body_blur').hide();
            }else{
                $('.body_blur').show();
            }
            $.post(base_url + "deal_settings/" + index, { ajax: true,search:search}, function(data) {
                console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                      
                        tr += '<tr>'+
                            '<td class="slno">'+sl_no+'</td>'+
                            '<td class="name"><input type="hidden" value="'+data1[i].id+'" class="hiddentype_id">'+data1[i].name+'</td>'+
                            '<td class="amount">'+data1[i].amount+'</td>'+
                            '<td class="duration">'+data1[i].duration+'</td>'+
                            '<td class="description">'+data1[i].description+'</td>'+
                            '<td><button type="button" class="btn btn-primary type_sub" data-toggle="modal" data-target="#agree1"><i class="fa fa-pencil"></i></button><input type="checkbox" name="" value="'+data1[i].id+'" class="chck_item_id"></td>'+
                            '</tr>';

                    }
                    $('tbody').html(tr);
                    console.log($('tbody').html());
                    $('#search').val(data.search);
                    // pagination
                    $('#pagination').html(data.pagination);

                }else{

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
</script>
<script type="text/javascript">   
    $(document).ready(function () {
        var v = jQuery("#update_deal").validate({

            submitHandler: function(datas) {
            $('.body_blur').show();
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {
                         $('.body_blur').hide();
                        if(data.status)
                        {
                           
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Deal updated successfully</div></div>';
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


         $(document).on('click','.type_sub',function(){
            var cur=$(this);
            $('#deal').modal('show');
            var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
            var name=cur.parent().parent().find('.name').text();
            var amount=cur.parent().parent().find('.amount').text();
            var duration=cur.parent().parent().find('.duration').text();
            var description=cur.parent().parent().find('.description').text();
          
            $(document).find('#title').val(name);
            $(document).find('#amount').val(amount);
            $(document).find('#duration').val(duration);
            $(document).find('#description').val(description);
            $(document).find('#hiddentype').val(hiddentype_id);
        });

        var u = jQuery("#product_form").validate({

            submitHandler: function(datas) {
            $('.body_blur').show();
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {
                         $('.body_blur').hide();
                        if(data.status)
                        {

                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">New deal has been added </div></div>';
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
                        $.post('<?php echo base_url();?>admin/home/delete_deal/',{chck_item_id:chck_item_id}, function(data){
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
                                //refresh_close();
                                $('.close').click(function(){
                                    $(this).parent().fadeOut(1000);
                                });
                            }
                        },'json');
                    }
                })
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
</script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
</body>
</html>