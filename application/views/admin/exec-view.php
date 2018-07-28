<?php echo $default_assets; ?>
<!-- <link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet"> -->
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
<div class="page-title">
    <div class="title_left">
        <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."></div>
    </div>   
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>All Executives <small></small></h2>
                 <ul class="nav navbar-right panel_toolbox">
                 <?php if (has_priv('add_exec') || has_priv('add_bde_des')) { ?>
                    <li>

                       <a href="<?php echo base_url();?>admin/Home/exec_add" data-original-title="Add new" class="btn btn-success" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                    </li>
                    <?php } ?>

                    <li>
                      <a type="button" class="btn btn-danger fllft del_btn"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </li>
                    <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
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
                    <table id="example" class="display table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr class="tablbg">
                                <th>slno</th>
                                <th>Email              </th>
                                <th>Designaton Name    </th>
                                <th>Name               </th>
                                <!-- <th>Last Promotion Date</th> -->
                                <th>Phone              </th>
                                <th>Address            </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style=" height:100px;overflow:scroll">
                                    
                        </tbody>
                        <tfoot>
                            <td colspan="8">
                                <div class="pull-right" id="pagination"></div>
                            </td>
                        </tfoot>
                        <!-- <tbody style=" height:100px;overflow:scroll">
                            <?php foreach($executives as $type){?>
                                <tr>
                                    <td class="titleclass"><input type="hidden" value="<?php echo $type['id'];?>" class="hiddentype_id"><?php echo $type['id'];?></td>

                                    <td class="email"><?php echo $type['email'];?></td>

                                    <td class="desig"><?php echo $type['designation'];?></td>

                                    <td class="name"><?php echo $type['name'];?></td>
                                    <td class="lpd"><?php echo $type['last_promotion_date'];?></td>

                                    <td class="phone"><?php echo $type['phone'];?></td>

                                    <td class="add"><?php echo $type['address'];?></td>

                                    <td><a type="button" href="<?php echo base_url();?>admin/executives/update_executive/<?php echo $type['id']; ?>" class="btn btn-primary fllft edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <input type="checkbox" name="" value="<?php echo $type['id'];?>" class="chck_grp_item"></td>
                                </tr>
                            <?php } ?>
                        </tbody> -->
                    </table>
                </div>
            </div>
    </div>
</div>
</div>
</div>
</div>
<div id="notifications"></div>
<input type="hidden" id="position" value="center">
    <?php echo $footer; ?>
    <!-- <script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url(); ?>assets/admin/js/alertBox.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/alertBox.css"> 
    <!-- <script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script> -->
    <script>
        /*$(document).ready(function() {
            var table = $('#example').DataTable( {
                fixedHeader: {
                    header: true,
                    footer: true,
                }
            });
        });*/
        $(document).on('click','.del_btn',function(){
            var cur=$(this);
            var itemgrps = [];
            $('.chck_grp_item').each(function () {
                var cur_this = $(this);
                var cur_val = $(this).val();
                if(cur_this.is(":checked")){
                    itemgrps.push(cur_val);
                }

            });
           
            if(itemgrps.length > 0){
                $('body').alertBox({
                title: 'Are You Sure?',
                lTxt: 'Back',
                lCallback: function(){
                  
                },
                rTxt: 'Okey',
                rCallback: function(){
                    $('.body_blur').show();
                            $.post('<?php echo base_url();?>admin/Home/delete_exectives',{itemgrps:itemgrps}, function(data){
                                $('.body_blur').hide();
                if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Deleted </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
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
                    refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
                            },'json');
                    }
                })
            }
        });        
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            $.post(base_url + "exe-view/" + index, { ajax: true,search:search}, function(data) {
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
                            '<td>'+data1[i].email+'</td>'+
                            '<td>'+data1[i].designation+'</td>'+
                            '<td>'+data1[i].name+'</td>'+
                            //'<td>'+data1[i].last_promotion_date+'</td>'+
                            '<td>'+data1[i].phone+'</td>'+
                            '<td>'+data1[i].address+'</td>'+
                            '<td><a type="button" href="'+base_url+"admin/Home/update_executive/"+data1[i].id+'" class="btn btn-primary fllft edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i></a><input type="checkbox" name="" value="'+data1[i].id+'" class="chck_grp_item"></td>'+
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
</body>
</html>





























