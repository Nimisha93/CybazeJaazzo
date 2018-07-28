<?php echo $default_assets; ?>
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    span.help-inline-error{
        color: red;
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
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            </div>
            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Team Lead Club <!-- Investor Club Members --><small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                          
                            <li><a data-toggle="modal" class="btn btn-primary"  style="background-color:#162b52" data-target="#add_club_member" title="Add Club Member"><i class="fa fa-user-plus"></i></a> </li>
                            <li><a type="button" class="btn btn-danger fllft del_btn" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                           </li>
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
                            <table id="example" class="table table-bordered display" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th style="width: 50px">SI No.</th>
                                    <th>Name</th>
                                    <th>Club Plan</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th style="width: 90px">Action</th>
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

    <!--************************row  end******************************************************************* -->

<div id="add_club_member" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h4 class="modal-title">Add Team Lead Club <!-- Club Member --></h4>
            </div>
            <form name="cm_forms" method="post" id="cm_forms" enctype="multipart/form-data"  action="<?php echo base_url(); ?>new_investor_club_member">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <label>Name</label>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <input class="form-control" name="name" type="text" placeholder="Name" />
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <label>Email Id</label>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <input class="form-control validate[required,custom[email]]" name="email" type="email" placeholder="Email Id" />
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <label>Mobile No</label>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <input class="form-control validate[required,custom[integer]]" name="mobile" onKeyPress="return isNumberKey(event)"   type="number" placeholder="Mobile No" data-errormessage-custom-error="Mobile no should be numeric value" />
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <label>Team Lead Club Plan</label>
                    </div>
                    <?PHP foreach($club_plans as $plan) {?>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <input name="type" type="radio" class="type"  value="<?= $plan['id']; ?>">&nbsp;<?= $plan['title']; ?>                    
                    </div>
                    <?PHP } ?>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <label>Payment mode</label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <input name="payment_mode" type="radio" class="payment_mode"  value="cash">&nbsp;Cash                    
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <input name="payment_mode" type="radio" class="payment_mode" value="cheque">&nbsp;Cheque
                    </div>
                </div>
                <br>
                <div class="row details" style="display: none;">
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <label class="control-label">Cheque No</label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <input type="number" name="cheque" class="form-control">
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <label class="control-label">Cheque Date</label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <input type="text" name="cheque_date" id="cheque_date" class="form-control">
                    </div>
                </div>
                <br>
                <div class="row details" style="display: none;">
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <label class="control-label">Bank</label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <input type="text" name="bank" class="form-control">
                    </div>  
                 </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary editsub" id="editsub">Submit</button>
                <button type="button" class="btn btn-default editsub"  data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
    <div id="notifications"></div>
</div>


</div>

<?php echo $footer; ?>
<!--***************************date picker******************************-->
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />
<script type="text/javascript">
    $(function () {
        $('#cheque_date').datetimepicker(
                {
                 format: 'YYYY-MM-DD'
                }
        );
    });
</script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        $('input:radio[name="payment_mode"]').change(
            function(){
                if ($(this).val() == 'cheque') {
                   $(".details").show();
                }
                else{
                   $(".details").hide(); 
                }
        });
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            if(search){
                $('.body_blur').hide();
            }else{
                $('.body_blur').show();
            }
            $.post(base_url + "investor_club_members/" + index, { ajax: true,search:search}, function(data) {
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
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].club_plan+'</td>'+
                            '<td>'+data1[i].phone+'</td>'+
                            '<td>'+data1[i].email+'</td>'+
                            '<td><a href="'+base_url+"admin/Clubmember/get_investor_member_byid/"+data1[i].id+'"><button type="button" class="btn btn-primary type_sub"><i class="fa fa-pencil"></i> </button></a><input type="checkbox" name="" value="'+data1[i].id+'" class="chck_item_id"></td>'+
                            '</tr>';

                    }

                    $('tbody').html(tr);

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
<script>
    $(document).ready(function() {
        //Add member 
        var v = jQuery("#cm_forms").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    //required: true,
                    email: true//,
                },
                mobile: {
                    required: true,
                    minlength: 10
                },
                club_plan: {
                    required: true
                }

            },
            messages: {
                name: {
                    required: "Please provide a name field",
                    minlength: "Name field must be at least 3 characters long"
                },
                email: {
                    //required: "Please provide an email",
                    email: "Email is invalid"
                },
                mobile: {
                    required: "Please provide a mobile no",
                    minlength: "Mobile field must be at least 10 characters long"
                },
                club_plan: {
                    required: "Please provide a plan",
                }
            },
            errorElement: "span",
            errorClass: "help-inline-error",
        });

        var datas = { 
            dataType : "json",
            success:   function(data){
               $('.body_blur').hide();
              if(data.status){
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Team Lead Club Member Added Successfully </div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
              } else{
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                // refresh_close();
                $('.close').click(function(){
                    $(this).parent().fadeOut(1000);
                });
              }
          }
        };
        $('#cm_forms').submit(function(e){     
          e.preventDefault();
          if (v.form()) {
            $('.body_blur').show();
            $(this).ajaxSubmit(datas);  
          }          
        });
        //End

        //Delete Club Member
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
                        $.post('<?php echo base_url();?>delete_club_member',{chck_item_id:chck_item_id}, function(data){
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
    } );
</script>