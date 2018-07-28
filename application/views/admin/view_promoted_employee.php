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
                <h2>Promoted Employees <small></small></h2>
                 <ul class="nav navbar-right panel_toolbox">
                 
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
                                <th>Employee    </th>
                                <th>Promoted To </th>
                                <th>Date        </th>
                              
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
                            <?php foreach($promoted_employee as $pr){?>
                                <tr>
                                    <td class="titleclass"><input type="hidden" value="<?php echo $pr['id'];?>" class="hiddentype_id"><?php echo $pr['id'];?></td>

                                    <td class="email"><?php echo $pr['name'];?></td>

                                    <td class="desig"><?php echo $pr['designation'];?></td>
                                
                                    <td class="desig"><?php echo $pr['date'];?></td>

                                </tr>
                            <?php } ?>
                        </tbody>  -->
                    </table>
                </div>
            </div>
    </div>
</div>
        <div id="notifications"></div>
        <input type="hidden" id="position" value="center">
</div>
    <?php echo $footer; ?>
    <!-- <script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url(); ?>assets/admin/js/alertBox.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/alertBox.css"> 
    <!-- <script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script> -->

<script type="text/javascript">
      $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            $.post(base_url + "promoted_employee/" + index, { ajax: true,search:search}, function(data) {
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
                            '<input type="hidden" value="'+data1[i].id+'" class="hiddentype_id">'+data1[i].id+''+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].designation+'</td>'+
                            '<td>'+data1[i].date+'</td>'+
                          
                           
                            '</tr>';
                    }
                    $('tbody').html(tr);

                    console.log(data.pagination);
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





























