<!-- hridya -->


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
    <h2>Club Type  Report<small></small></h2>
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
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Cash_Limit</th>
                                    <th>Pooling_Commision</th>
<th>Date & time</th>
                                   
                                  <!-- <th>Action</th> -->

                                </tr>
                                 <tr class="filters">
                                    <th></th>
                                     <th class="input-filter">Name</th>
                                    <th class="input-filter">Description</th>
                                    <th class="input-filter">Amount</th>
                                    <th class="input-filter">Cash_Limit</th>
                                    <th class="input-filter">Pooling_Commision</th>
                                     <th class="date-filter">Date & time</th>
                                    
                                </tr>

                                </thead>
                                <tbody>
                                <?php  foreach ($club as $key => $vechiles) { ?>
                                <tr>
                                    <td><?= $key+1;?></td>
                                    <td><?= $vechiles['title'];?></td>
                                    <td>
                                        <input type="hidden" name="servicet_id" class="servicet_id" value="<?= $vechiles['id'];?>">

                                        <?= $vechiles['description'];?></td>
                                    <td><?= $vechiles['amount'];?></td>

                                    
                                    <td><?= $vechiles['cash_limit'];?></td>
                                    <td><?= $vechiles['pooling_commision'];?></td>
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
                        </div>
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
<div class="box-body" id="sample" style="display:none;">                            
                            <div>
                                <p data-dismiss="alert">
                            </div>
                           
                            <table id="purchase_table" class="table table-bordered table-striped">
                                <thead>

                                <tr class="filters">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>description</th>
                                    <th>amount</th>
                                    <th>cash_limit</th>
                                    <th>pooling_commision</th>

                                   
                                  <!-- <th>Action</th> -->

                                </tr>
                                

                                </thead>
                                <tbody>
                                <?php  foreach ($club as $key => $vechiles) { ?>
                                <tr>
                                    <td><?= $key+1;?></td>
                                    <td><?= $vechiles['title'];?></td>
                                    <td>
                                        <input type="hidden" name="servicet_id" class="servicet_id" value="<?= $vechiles['id'];?>">

                                        <?= $vechiles['description'];?></td>
                                    <td><?= $vechiles['amount'];?></td>

                                    
                                    <td><?= $vechiles['cash_limit'];?></td>
                                    <td><?= $vechiles['pooling_commision'];?></td>

                                   
                                    


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
                        </div>

<!-- Datatables -->

<!--============new customer popup start here=================-->


</body>
</html>





























