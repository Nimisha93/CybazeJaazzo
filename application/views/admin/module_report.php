<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/datatables/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/datatables/daterangepicker.js"></script>
<script src="<?php echo base_url();?>assets/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/dataTables.bootstrap.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/datatable_daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/datatables/style_datatable.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/buttons.bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/jszip.min.js">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/pdfmake.min.js">
</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/vfs_fonts.js">
  </script>
  <script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/buttons.html5.min.js"></script>
  <script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/buttons.print.min.js"></script>
  <script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/buttons.colVis.min.js"></script>


 <link href="<?php echo base_url();?>assets/jqui/jq_jquery-ui.css" rel="stylesheet">
  <script src="<?php echo base_url();?>assets/jqui/jquery-ui.js" type="text/javascript" charset="utf-8"></script>

<style type="text/css">
  .ui-datepicker-prev.ui-corner-all {
    background-color: #FFF;
    color: #000;
}
.ui-datepicker-next.ui-corner-all {
  background-color: #FFF;
    color: #000;
}
</style>
<style type="text/css" media="print">
        @page 
        {
            size: auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }
    </style>
<script type="text/javascript">


            function printDiv(divName)
            {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
   
     
    </script>
 <script type="text/javascript">
      $(document).ready(function () {
   
$('#purchase_table thead tr.filters th').each(function () {
           var title = $(this).text();
           if ($(this).hasClass("input-filter")) {
               $(this).html('<input name ="' + $.trim(title).replace(/ /g, '') + '" type="text" class = "form-control" placeholder="Search ' + $.trim(title) + '" />');
           }
           else if ($(this).hasClass("date-filter")) {

               $(this).html('<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span><input type="text" style="width: 200px" name="' + $.trim(title).replace(/ /g, '') + '"  placeholder="Search ' + $.trim(title) + '" class="form-control daterange"/></div>');

           }

       });

        var table = $("#purchase_table").DataTable({           
            dom: "rBftlip",

            buttons: [
            {
                extend: 'collection',
                text: 'Export',
                buttons:
                    [
                               
                        {
                            extend: "copy",
                            exportOptions: { columns: ':visible:not(:last-child)' }, //last column has the action types detail/edit/delete
                            footer:true
                        },
                        {
                            extend: "csv",
                            exportOptions: { columns: ':visible:not(:last-child)' },
                            footer: true
                        },
                        {
                            extend: "excel",
                            exportOptions: { columns: ':visible:not(:last-child)' },
                            footer:true
                        },
                        {
                            extend: "pdf",
                            exportOptions: { columns: ':visible:not(:last-child)' },
                            footer:true
                        },
                        {
                            extend: "print",
                            exportOptions: { columns: ':visible:not(:last-child)' },
                            footer: true
                        }

                    ]
            }
            ],
           
            responsive: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            orderCellsTop: true,
            scrollX: true,
            colReorder: false,

                    

            language: {
                search: '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>',
                searchPlaceholder: 'Search all columns',
                lengthMenu: '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-menu-hamburger"></span></span>_MENU_</div>',
                processing: ""
            },
                   
            processing: true,


            "initComplete": function (settings, json) {
                //  $("#mytable_processing").css("visibility", "hidden");
                $('#purchase_table').fadeIn();
            },
                

          
            "footerCallback": function( tfoot, data, start, end, display ) {
                var info = $('#purchase_table').DataTable().page.info();
                $(tfoot).find('td').eq(0).html("Total Count: " + info.recordsDisplay);

                     
            }
        });

        new $.fn.dataTable.Buttons(table, {
            buttons: [
              {
                  extend: 'colvis',
                  text: 'Show/Hide Columns'

              }

            ]
        });

        //add button to top
        table.buttons(0, null).container().prependTo(
              table.table().container()
          );
                

        //remove class from search filter
        ($("#purchase_table_filter input").removeClass("input-sm"));



      

       //instantiate datepicker and choose your format of the dates
    $('.daterange').daterangepicker({
        ranges: {
            "Today": [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 last days': [moment().subtract(6, 'days'), moment()],
            '30 last days': [moment().subtract(29, 'days'), moment()],
            'This month': [moment().startOf('month'), moment().endOf('month')],
            'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Blank date': [moment("0001-01-01"), moment("0001-01-01")]
        }
        ,
        autoUpdateInput: false,
        opens: "left",
        locale: {
            cancelLabel: 'Clear',
            format: 'DD-MMM-YYYY'
        }
    });

    var startDate;
    var endDate;
    var dataIdx;  //current data column to work with


    $("#purchase_table_wrapper thead").on("mousedown", "th", function (event) {
        var visIdx = $(this).parent().children().index($(this));
        dataIdx = table.column.index('fromVisible', visIdx);
    });




    // Function for converting a dd/mmm/yyyy date value into a numeric string for comparison (example 01-Dec-2010 becomes 20101201
    function parseDateValue(rawDate) {

        var d = moment(rawDate, "DD-MMM-YYYY").format('DD-MM-YYYY');
        var dateArray = d.split("-");
        var parsedDate = dateArray[2] + dateArray[1] + dateArray[0];
        return parsedDate;
    }





    //filter on daterange
    $(".daterange").on('apply.daterangepicker', function (ev, picker) {

        ev.preventDefault();



        //if blank date option was selected
        if ((picker.startDate.format('DD-MMM-YYYY') == "01-Jan-0001") && (picker.endDate.format('DD-MMM-YYYY')) == "01-Jan-0001") {
            $(this).val('Blank');


            val = "^$";

            table.column(dataIdx)
               .search(val, true, false, true)
               .draw();

        }
        else {
            //set field value
            $(this).val(picker.startDate.format('DD-MMM-YYYY') + ' to ' + picker.endDate.format('DD-MMM-YYYY'));



            //run date filter
            startDate = picker.startDate.format('DD-MMM-YYYY');
            endDate = picker.endDate.format('DD-MMM-YYYY');

            var dateStart = parseDateValue(startDate);
            var dateEnd = parseDateValue(endDate);

            var filteredData = table
                    .column(dataIdx)
                    .data()
                    .filter(function (value, index) {

                        var evalDate = value === "" ? 0 : parseDateValue(value);
                        if ((isNaN(dateStart) && isNaN(dateEnd)) || (evalDate >= dateStart && evalDate <= dateEnd)) {

                            return true;
                        }
                        return false;
                    });


            var val = "";
            for (var count = 0; count < filteredData.length; count++) {

                val += filteredData[count] + "|";
            }

            val = val.slice(0, -1);


            table.column(dataIdx)
                  .search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true)
                  .draw();
        }


       

    });


    $(".daterange").on('cancel.daterangepicker', function (ev, picker) {
        ev.preventDefault();
        $(this).val('');
        table.column(dataIdx)
              .search("")
              .draw();

     



    });
       
           
        

        // Apply the search
        $.each($('.input-filter', table.table().header()), function () {
            var column = table.column($(this).index());
            //onsole.log(column);
            $('input', this).on('keyup change', function () {
                if (column.search() !== this.value) {
                    column
                        .search(this.value)
                        .draw();
                }
            });
        });

        //hide unnecessary columns
        var column = table.columns($('.HideColumn'));
        // Toggle the visibility
        column.visible(!column.visible());

      });
    </script>
    
      
</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
<div class="">
<div class="page-title">
    <div class="title_left">
        <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."><i class="fa fa-info-circle" aria-hidden="true"></i></div>
        </h3>
    </div>
    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
                </span> </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
    <h2>Module Report <small></small></h2>
    <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
    </ul>
    <div class="clearfix"></div>
</div>
<div class="x_content">
<div class="">
  <div class="box-body">
                            <?php if($this->session->flashdata('msg')){ ?>
                            <div class="alert alert-info alert-dismissible">
                                <p data-dismiss="alert"><?php echo $this->session->flashdata('msg'); ?></p>
                            </div>
                            <?php  } ?>
                            <table id="purchase_table" class="table table-bordered table-striped">
                                <thead>

                                <tr class="filters">
                                   <th>No</th>
                                    <th> Module Name</th>
                                    <th>Description</th>
                                    <th>Email</th>
                                    <th>Image</th>
                                     <th>Date & time</th>
                                   

                                  <!-- <th>Action</th> -->

                                </tr>
                                 <tr class="filters">
                                    <th></th>
                                    <th class="input-filter"> Module Name</th>
                                    <th class="input-filter">Description</th>
                                    <th class="input-filter">Email</th>
                                    <th class="input-filter">Image</th>
                                    <th class="date-filter">Date & time</th>
                                    
                                </tr>

                                </thead>
                                <tbody>
                                <?php  foreach ($module as $key => $vechiles) { ?>
                                <tr>
                                    <td><?= $key+1;?></td>
                                    <td><?= $vechiles['module_name'];?></td>
                                    <td>
                                        <input type="hidden" name="servicet_id" class="servicet_id" value="<?= $vechiles['id'];?>">

                                        <?= $vechiles['description'];?></td>
                                    <td><?= $vechiles['email'];?></td>

                                    
                                    <td><?= $vechiles['image'];?></td>
                                    <td><?= $vechiles['date_time'];?></td>
                                    
                                    


                                   <!-- <td><a class="btn btn-app" href="#"> <i class="fa fa-edit"></i> Edit</a>
                                        <a class="btn btn-app del_service"><i class="fa fa-trash"></i> Delete</a></td> -->

                                </tr>
                                    <?php   } ?>



                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                            <br>

                          
                            <button class="btn btn-success pull-right" style="margin-right:20px;" onclick="printDiv('sample')" >Print</button>
                        </div>
<script>
    $(document).ready(function(){
        $(document).on('click','.type_sub',function(){
            var cur=$(this);
            var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
            var title=cur.parent().parent().find('.titleclass').text();
            var descrip=cur.parent().parent().find('.descrip').text();
            $(document).find('#title').val(title);
            $(document).find('#descriptext').val(descrip);
            $(document).find('#hiddentype').val(hiddentype_id);

 
        $("#editsub").click(function(e){
            e.preventDefault();
            var str = $("#type_forms").validationEngine("validate");
            if(str==true){

                var data=$("#type_forms").serializeArray();
                $('.body_blur').show();
                $.post("<?php echo base_url();?>admin/Channel_partner/edit_partnertype_byid", data, function(data){
                    $('.body_blur').hide();
                    if(data.status){
                        noty({text:"Successfully updated",type: 'success',layout: 'top', timeout: 3000});
                        $('#type_forms')[0].reset();
                    }
                    else{
                        noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                        $('#type_forms')[0].reset();
                    }
                },'json');
            }
            else{

            }

        })
        $(document).on('click','.type_delete',function(){
            var cur=$(this);
            var hiddentypeid=cur.parent().parent().find('.hiddentype_id').val();
            noty({
                text: 'Do you want to continue?',
                type: 'warning',
                buttons: [
                    {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                        // this = button element
                        // $noty = $noty element

                        $noty.close();
                        $('.body_blur').show();
                        $.post('<?php echo base_url();?>admin/Channel_partner/delete_partnertype/'+hiddentypeid, function(data){
                            $('.body_blur').hide();
                            if(data.status){
                                noty({text: 'Deleted Succesfully', type: 'success', timeout:1000});
                                cur.parent().parent().remove();
                            }else{
                                noty({text: 'Database Error', type: 'error'});
                            }
                        },'json');
                    }
                    },
                    {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                        $noty.close();

                    }
                    }
                ]
            });

        })
    });
</script>
</tbody>
</table>
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
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>


<script>

    $(document).ready(function() {
        var table = $('#example').DataTable( {
            fixedHeader: {
                header: true,
                footer: true,

            }
        } );

    } );

</script>


<!-- Datatables -->
 
//printing
<div class="box-body" id="sample" style="display:none;">
                         
                            
                            <div>
                                
                            </div>
                           
                            <table id="purchase_table" class="table table-bordered table-striped">
                                <thead>

                                <tr class="filters">
                                   <th>No</th>
                                    <th> Module Name</th>
                                    <th>Description</th>
                                    <th>email</th>
                                    
                                   

                                  <!-- <th>Action</th> -->

                                </tr>
                                 

                                </thead>
                                <tbody>
                                <?php  foreach ($module as $key => $vechiles) { ?>
                                <tr>
                                    <td><?= $key+1;?></td>
                                    <td><?= $vechiles['module_name'];?></td>
                                    <td>
                                        <input type="hidden" name="servicet_id" class="servicet_id" value="<?= $vechiles['id'];?>">

                                        <?= $vechiles['description'];?></td>
                                    <td><?= $vechiles['email'];?></td>

                                    
                                    
                                    
                                    


                                   <!-- <td><a class="btn btn-app" href="#"> <i class="fa fa-edit"></i> Edit</a>
                                        <a class="btn btn-app del_service"><i class="fa fa-trash"></i> Delete</a></td> -->

                                </tr>
                                    <?php   } ?>



                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                            <br>

                          
                            
                        </div>
<!--============new customer popup start here=================-->

<div id="newcstomr" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">X</button>
    <h4 class="modal-title">New Cutomer</h4>
</div>
<div class="modal-body">
<div id="testmodal" style="padding: 5px 20px;">
<form id="antoform" class="form-horizontal Calendar" role="form">
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <select id="heard" class="form-control" required="">
            <option value="">Saluation</option>
            <option value="press">Mr.</option>
            <option value="press">Mrs.</option>
            <option value="press">Ms.</option>
            <option value="press">Miss.</option>
            <option value="press">Dr.</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="First Name" class="form-control">
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="Last Name" class="form-control">
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="company name" class="form-control">
    </div>
    <div class="col-md-5 col-sm-11 col-xs-11 form-group">
        <input type="text" placeholder="company display name" class="form-control">
    </div>
    <div class="col-md-1 col-sm-1 col-xs-1">
        <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."><i class="fa fa-info-circle" aria-hidden="true"></i></div>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="Work Phone" class="form-control">
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="Mobile" class="form-control">
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group"> <a data-toggle="collapse" data-target="#morefield" class="lnht1">Add More Field</a> </div>
    <div class="clear"></div>
    <div id="morefield" class="collapse">
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <input type="text" placeholder="Skype Name/ No." class="form-control">
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <input type="text" placeholder="Designation" class="form-control">
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <input type="text" placeholder="Department" class="form-control">
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 form-group clear">
        <input type="text" placeholder="Website" class="form-control">
    </div>
</form>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_content">
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">other Details</a> </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Address</a> </li>
                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Custom Field</a> </li>
                    <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Reporting Tags</a> </li>
                    <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Remarks</a> </li>
                </ul>
                <div id="myTabContent" class="tab-content sclbr mdltab">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <select id="heard" class="form-control" required="">
                                <option value="">Saluation</option>
                                <option value="press">Mr.</option>
                                <option value="press">Mrs.</option>
                                <option value="press">Ms.</option>
                                <option value="press">Miss.</option>
                                <option value="press">Dr.</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <select id="heard" class="form-control" required="">
                                <option value="">Saluation</option>
                                <option value="press">Mr.</option>
                                <option value="press">Mrs.</option>
                                <option value="press">Ms.</option>
                                <option value="press">Miss.</option>
                                <option value="press">Dr.</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Allow portal access for this contact </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <select id="heard" class="form-control" required="">
                                <option value="">Portal Language</option>
                                <option value="press">Mr.</option>
                                <option value="press">Mrs.</option>
                                <option value="press">Ms.</option>
                                <option value="press">Miss.</option>
                                <option value="press">Dr.</option>
                            </select>
                        </div>
                        <div class="clear"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Facebook">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Twitter">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span> </div>
                    </div>

                    <!--======================tab_content1 end ==========================-->

                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="tblttle">BILLING ADDRESS</h3>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Attention" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <textarea class="form-control" rows="3" placeholder="Street"></textarea>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="City" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="State" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Zip code" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <select id="heard" class="form-control" required="">
                                    <option value="">Country</option>
                                    <option value="press">Mr.</option>
                                    <option value="press">Mrs.</option>
                                    <option value="press">Ms.</option>
                                    <option value="press">Miss.</option>
                                    <option value="press">Dr.</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Fax" class="form-control">
                            </div>
                        </div>

                        <!--++++++++++++++++SHIPPING ADDRESS end +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="tblttle">SHIPPING ADDRESS</h3>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Attention" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <textarea class="form-control" rows="3" placeholder="Street"></textarea>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="City" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="State" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Zip code" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <select id="heard" class="form-control" required="">
                                    <option value="">Country</option>
                                    <option value="press">Mr.</option>
                                    <option value="press">Mrs.</option>
                                    <option value="press">Ms.</option>
                                    <option value="press">Miss.</option>
                                    <option value="press">Dr.</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="text" placeholder="Fax" class="form-control">
                            </div>
                        </div>

                        <!--++++++++++++++++SHIPPING ADDRESS end +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

                        <div class="col-md-12 col-sm-12 col-xs-12 form-group"> <strong>Note:</strong> You can add and manage additional addresses from contact details section. </div>
                    </div>
                    <!--======================tab_content2 end ==========================-->

                    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                        <p class="tabtxt">Start adding custom fields for your contacts by going to More Settings <strong> > </strong> Preferences <strong>></strong> Contacts. You can add as many as Ten extra fields, as well as refine the address format of your contacts from there. </p>
                    </div>
                    <!--======================tab_content3 end ==========================-->

                    <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                        <p class="tabtxt">You've not created any Reporting Tags.
                            Start creating reporting tags by going to More Settings <strong> > </strong> Reporting Tags </p>
                    </div>
                    <!--======================tab_content3 end ==========================-->

                    <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group"> <strong>Remarks </strong>(For Internal Use)
                            <textarea class="form-control" rows="5" placeholder="Street"></textarea>
                        </div>
                    </div>
                    <!--======================tab_content3 end ==========================-->

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary antosubmit">Save</button>
</div>
</div>
</div>
</div>
</body>
</html>





























