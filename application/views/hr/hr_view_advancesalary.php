<?php echo $header; ?>
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>


</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
       
        <div class="clearfix"></div>
        <div class="row">
             
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Advance Salary<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            

                                <li>

                       <a href="<?php echo base_url();?>add_advance_salary" data-original-title="Add new" class="btn btn-success" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                    </li>

                    <li>
                                <a class="btn btn-primary pull-right fllft del_btn btn-danger" style=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                            <!-- <li>
                               <a class="btn btn-success pull-right" href="<?php echo base_url(); ?>hr/Payroll/add_advance"><i class="fa fa-plus"></i></a>
                            </li> -->
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>

                            
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                  <div class="x_content">
                        <div class="tbleovrscroll">
                          <table id="example" class="display table-bordered table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                        <th>No</th>
                                        <th>Employee</th>
                                       
                                        <th > Date</th>
                                        <th> Amount</th>
                                       
                                        <th>Action</th>


                                    </tr>
                                  
                                    </thead>
                                    
                                 
                                    
                                    
                                    <tbody>

                                     <?php foreach ($advance['advance'] as $key => $request) { ?>
                                        <tr>
                                            <input type="hidden" id="advance_hidden" name="advance_hidden" class="advance_hidden" value="<?= $request['id'];?>">

                                            <td><?= $key+1;?></td>
                                            <td><?= $request['empname'];?>(<?= $request['code'];?>)</td>
<!--                                            <td>--><?//= $request['forward'];?><!--(--><?//= $request['fcode'];?><!--)</td>-->
                                            
                                            <td><?= $request['salary_date'];?></td>

                                            <td><?= $request['amount'];?></td>
                                          
                                            <td><a class="btn btn-primary" href="<?php echo base_url();?>hr/Payroll/get_advance_by_id/<?php echo $request['id'];?>"> <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                     <input type="hidden" id="advance_hidden" name="emp_hidden" class="emp_hidden" value="<?= $request['emp_id'];?>">
<a class="btn btn-info view_sal"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                               
                                                <input type="checkbox" name="" value="<?php echo $request['id'];?>" class="chck_grp_item">
                                                
                                            </td>

                                        </tr>
                                    <?php   } ?>
                                    </tbody>
                                   
                                </table>
                                <br>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<div class="clearfix"></div>

<div id="salary_box" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >X</button>
                <h4 class="modal-title">Advance Salary</h4>
            </div>
            <div class="modal-body div_salary_table">
                <table id="salary_table" class="table display salary_table table-bordered table-striped responsive-utilities">
                    <thead class="the_clss" ">
                    <tr>
                        <th >Date</th>
                        <th >Total</th>
                     
                    </tr>

                    </thead>

                    <tbody id="td_salary" >

                    </tbody>

                    <tfoot>

                    </tfoot>
                </table>
            </div>
         

          
                    </div>
                </div>
<div class="clearfix"></div>
             
     

    </div>
</div>

<!--************************row  end******************************************************************* -->

</div>
</div>
</div>
</div>
</div>
<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
 <script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<script>

$(document).ready(function() {
    var table = $('#example').DataTable( {
        fixedHeader: {
            header: true,
            footer: true
			
        }
    } );
	
} );

</script>
<script>

$(document).ready(function() {
    var table = $('#salary_table').DataTable( {
        fixedHeader: {
            header: true,
            footer: true
			
        }
    } );
	
} );

</script>
<script type="text/javascript">


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
                            $.post('<?php echo base_url();?>hr/Payroll/delete_advance/',{itemgrps:itemgrps}, function(data){
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
    
    // $(document).on('click','.del_btn',function(){
    
    //     var cur=$(this);

    //     var itemgrps = [];
    //     $('.chck_grp_item').each(function () {
    //         var cur_this = $(this);
    //         var cur_val = $(this).val();
    //         if(cur_this.is(":checked")){
    //             itemgrps.push(cur_val);
    //         }

    //     });
       
    //     if(itemgrps.length > 0){
    //         noty({
    //         text: 'Do you want to continue?',
    //         type: 'warning',
    //         buttons: [
    //             {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

    //                 $noty.close();


    //                     $('.body_blur').show();
    //                     $.post('<?php echo base_url();?>hr/Payroll/delete_advance/',{itemgrps:itemgrps}, function(data){
    //                         $('.body_blur').hide();
    //                         if(data.status){
    //                             $.toast('Deleted successfully', {'width': 500});

    //                             setTimeout(function(){
    //                                 location.reload();
    //                             }, 1000);



    //                             }else{
    //                                 $.toast(data.reason, {'width': 500});
    //                             }
    //                     },'json');
    //                 }


    //             },
    //             {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
    //                 $noty.close();

    //             }
    //             }
    //         ]
    //     });
    //     }
    // });    
</script>
<script>
    $(document).ready(function(){

        $(document).on('click','.view_sal', function(){
        var cur = $(this);
$('#salary_box').modal('show');
$('#td_salary').empty();
        var employee = cur.parent().find('.emp_hidden').val();

        var data = {employee:employee};
        $('.body_blur').show();
        $.post('<?= base_url();?>hr/payroll/advance_salary_by_emp_id', data, function(data){
            $('.body_blur').hide();
                        // console.log(data);
                        if(data.status){
                            var data = data.data;
                            var datas = data.data;
                            // console.log(data.length);
 
                            var tr = '';
                            var table = $('#salary_table').DataTable();


        table
                .clear()
                .draw();
                            for(var i=0; i<data.length; i++){
                                var date=data[i].fdate;
                                var dateAr = date.split('-');
                                    var amnt = data[i].amount;
                                    if(i==(data.length-1))
                                    {
                                        var amnt = data[i].amount;
                                    }else{
                                        var amnt = data[i].amount-data[i+1].amount;
                                        // amnt=amnt.toString().replace('-', '')+""; 
                                    }
                                   var amntValue = amnt.toString(); 

                                    if( amntValue.startsWith('-') ) {
                                        amnt=amnt.toString().replace('-', '')+"[Paid]";  
                                        table.row.add($(
                                            '<tr>'+
                                            '<td>'+date+'</td>'+
                                            '<td>'+data[i].amount+"[Received]"+'</td>'+
                                            '</tr>'
                                        )).draw(false);
                                    }else{
                                        amnt=amnt.toString().replace('-', '')+"[Received]";      
                                    }
                                var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0].slice(-4);
                                table.row.add($(
                                    '<tr>'+
                                    '<td>'+date+'</td>'+
                                    '<td>'+amnt+'</td>'+
                                    '</tr>'
                                )).draw(false);
                               
                       
                            }
                        }
                        else{


                        }

        },'json');
    });

    });

</script>
</body>
</html>
