   $(function () {
     


       $('#mytable thead tr.filters th').each(function () {
           var title = $(this).text();


           if ($(this).hasClass("input-filter")) {


               $(this).html('<input name ="' + $.trim(title).replace(/ /g, '') + '" type="text" class = "form-control" placeholder="Search ' + $.trim(title) + '" />');
           }
           else if ($(this).hasClass("date-filter")) {

               $(this).html('<div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span><input type="text" style="width: 200px" name="' + $.trim(title).replace(/ /g, '') + '"  placeholder="Search ' + $.trim(title) + '" class="form-control daterange"/></div>');

           }

       });

           

        // DataTable
        var table = $("#mytable").DataTable({
                     
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
                $('#mytable').fadeIn();
            },
                

          
            "footerCallback": function( tfoot, data, start, end, display ) {
                var info = $('#mytable').DataTable().page.info();
                $(tfoot).find('td').eq(0).html("Total Count: " + info.recordsDisplay);

                     
            },
          
        });

        new $.fn.dataTable.Buttons(table, {
            buttons: [
              {
                  extend: 'colvis',
                  text: 'Show/Hide Columns'

              },

            ]
        });

        //add button to top
        table.buttons(0, null).container().prependTo(
              table.table().container()
          );
                

        //remove class from search filter
        ($("#mytable_filter input").removeClass("input-sm"));



      

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


    $("#mytable_wrapper thead").on("mousedown", "th", function (event) {
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
       
           
        //hide unnecessary columns
        var column = table.columns($('.HideColumn'));
        // Toggle the visibility
        column.visible(!column.visible());

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
       

    
         

    }); /////////////////////// end of Datatable function
