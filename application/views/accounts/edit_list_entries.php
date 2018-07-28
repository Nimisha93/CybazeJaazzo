<?php echo $default_assets; ?>
<link href="<?php echo base_url() ?>assets/admin/css/select2.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
    <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Entries<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li> 
                                <a href="<?php echo base_url();?>add_entries" data-original-title="Add new" class="btn btn-success" style="background-color:#162b52"><i class="fa fa-plus"></i></a>
                            </li>
                            <li><a type="button" class="btn btn-danger fllft del_btn"><i class="fa fa-trash" aria-hidden="true"></i></a> 
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
                            <div class="box-body">
                                <table id="purchase_table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr class="tablbg">
                                              <th>Slno.</th>
                                    <th>Date</th>
                                    <th>Number</th>
                                    <th>Type</th>
                                    <th>Dr Amount</th>
                                    <th>Cr Amount</th>

                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  

                                    </tbody>
                                    <tfoot>
                                        <td colspan="7">
                                            <div class="pull-right" id="pagination"></div>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Modal content-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog pupwidth"> 
          <!-- Modal content-->
          <div class="modal-content">
            <form action="<?php echo base_url(); ?>admin/Privilleges/add_privilege" method="post" id="privilege_form" name="privilege_form" enctype="multipart/form-data">
              <div class="modal-header">
                <h2>Add Privilege<small></small></h2>
              </div>
              <div class="" id="master_file" style="margin-top: 20px;">
                <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Group Name</label><br>
                        <input type="text" name="group_name" class="form-control">
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <div style="height:52.2px">
        <label>Type</label><br>

        <label>       <input type="radio"    name="yesno" value="normal" id="yesCheck"> Normal  </label>
        <label>           <input type="radio"   name="yesno" value="design" id="noCheck"> Designation Wise</label>

    </div>

                      </div>

                      <div class="col-md-5 col-sm-6 col-xs-12 form-group norm_pr" id="norm_pr" style="display: none;">
                        <label>Access Permission</label>
                        <br>

                        <select id="1testSelAll" class="form-control select2 1testSelAll" name="access_perm[]"  multiple>
                          <option value="">--Select Any--</option>
                          <?php foreach($privilage['privilege'] as $pri) {  ?>
                            <option value="<?php echo $pri['id'] ?>"><?php echo $pri['privilege']; ?></option>
                          <?php } ?>
                        </select>

                      </div>


                        <div class="col-md-5 col-sm-6 col-xs-12 form-group des_pr" id="des_pr" style="display: none;">
                        <label>Access Permission</label>
                        <br>

                        <select id="1testSelAll1" class="form-control select2 1testSelAll1" name="access_perm[]"  multiple>
                          <option value="">--Select Any--</option>
                          <?php foreach($privilage_des['des'] as $pri1) {  ?>
                            <option value="<?php echo $pri1['id'] ?>"><?php echo $pri1['privilege']; ?></option>
                          <?php } ?>
                        </select>
                        
                      </div>



                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <input type="submit" value="Save" class="btn btn-primary antosubmit tpmr10">
                  <button type="button" class="btn btn-default tpmr10" data-dismiss="modal">Close</button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script type="text/javascript">
$(document).ready(function() {
  $('#1testSelAll').select2({ width: '100%' });
    $('#1testSelAll1').select2({ width: '100%' });

});
</script> 
<script src="<?php echo base_url() ?>assets/admin/js/select2.full.js"  type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js/paging.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){

                  
                    var base_url = "<?php echo base_url(); ?>";
                    function load_demo(index) {
                        index = index || 0;
                        var search = $('#search').val();
                        $.post(base_url + "entries/" + index, { ajax: true,search:search}, function(data) {
                            console.log(data);
                            $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';
                            if(data.status){
                                var data1 = data.data;
                                for(var i = 0; i< data1.length; i++){
                                    var cur_index=parseInt(index);
                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                                    tr += '<tr>'+
                                        '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].en_date+'</td>'+
                            '<td>'+data1[i].number+'</td>'+
                            '<td>'+data1[i].en_type+'</td>'+
                            //'<td>'+data1[i].last_promotion_date+'</td>'+
                            '<td>'+data1[i].dr_total+'</td>'+
                            '<td>'+data1[i].cr_total+'</td>'+
                                        '<td><a href="'+base_url+"accounts/entries/get_entry_by_id/"+data1[i].id+'"><button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i> </button></a><input type="checkbox" name="" value="'+data1[i].id+'" class="chck_item_id"></td>'+
                                        '</tr>';
                                }
                                $('tbody').html(tr);
                                $('#search').val(data.search);
                                // pagination
                                $('#pagination').html(data.pagination);

                            }else{
                                 tr += '<tr>'+
                                        '<td colspan="7" style="text-align:center">No Data Found</td>'+
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








                
            </script>


            <script type="text/javascript">
            $(document).ready(function(){
                  $('input:radio[name="yesno"]').change(
        function()
        {
            if ($(this).val() == 'normal') {
                $(".norm_pr" ).show();
                 $(".des_pr").hide();
            
            }else {
             
                                $(".norm_pr" ).hide();

                                $(".des_pr").show();

            }
        }
    );
              });
            </script>
            <script type="text/javascript">
                //Add Privilege
                $(document).ready(function() {
                    var datas = { 
                        dataType : "json",
                        success:   function(data){
                                $('.body_blur').hide();
                                if(data.status)
                                {
                                    $('#myModal').modal('hide');
                                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">New Privilege Added Successfully</div></div>';
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
                                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                                    var effect='fadeInRight';
                                    $("#notifications").append(center);
                                    $("#notifications-full").addClass('animated ' + effect);
                                    
                                }
                        }
                    };
                    $('#privilege_form').submit(function(e){     
                        e.preventDefault();
                        $('.body_blur').show();
                        $(this).ajaxSubmit(datas);            
                    });
                });
                //Delete Privilege
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
                                $.post('<?php echo base_url();?>delete_privilages/',{chck_item_id:chck_item_id}, function(data){
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
            </script> 
          </div>
        </div>
    </div>
 </div>
</body>
</html>