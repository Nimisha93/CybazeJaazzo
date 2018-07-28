function open_popup(tt){
    var mywindow = window.open("", "_blank", "toolbar=no, scrollbars=no, resizable=no");   
    mywindow.document.write('<!DOCTYPE html> <html> <head>');
    
    mywindow.document.write('<style>.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {border: 1px solid #ddd;}.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 8px;line-height: 1.42857143;vertical-align: top; border-top: 1px solid #ddd;}.table-bordered {border: 1px solid #ddd;width: 100%; max-width: 100%;margin-bottom: 20px;background-color: transparent;border-spacing: 0;border-collapse: collapse;}</style>');
    mywindow.document.write("</head>");
    mywindow.document.write('<body class="nav-md"><div class="container body"><div class="main_container"');
    mywindow.document.write('<div class="right_col" role="main"><div class=""><div class="clearfix"></div><div class="row">');
    mywindow.document.write('<input id="printpagebutton" type="button" style="background-color: #3c8dbc; color: #FFF; height: 34px;" onclick="printDiv()" value="Print report!"/>');
    mywindow.document.write(tt);
    mywindow.document.write('</div></div></div>');
    mywindow.document.write("</body> </html>");  

    mywindow.document.close(); 
    //mywindow.print();
}
function PrintDiv(data) {
    var mywindow = window.open("", "_blank", "toolbar=no, scrollbars=no, resizable=no");
  //  var is_chrome = Boolean(mywindow.chrome);
    mywindow.document.write('<!DOCTYPE html> <html> <head>');
    
    mywindow.document.write('<style>.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {border: 1px solid #ddd;}.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 8px;line-height: 1.42857143;vertical-align: top; border-top: 1px solid #ddd;}.table-bordered {border: 1px solid #ddd;width: 100%; max-width: 100%;margin-bottom: 20px;background-color: transparent;border-spacing: 0;border-collapse: collapse;}</style>');
    mywindow.document.write("</head>");
    mywindow.document.write('<body class="nav-md"><div class="container body"><div class="main_container"');
    mywindow.document.write('<div class="right_col" role="main"><div class=""><div class="clearfix"></div><div class="row">');
    mywindow.document.write(data);
    mywindow.document.write('</div></div></div>');
    mywindow.document.write("</body> </html>");  
    if (Boolean(mywindow.chrome)) {
        setTimeout(function() { // wait until all resources loaded 
            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10
            mywindow.print(); // change window to winPrint
            mywindow.close(); // change window to winPrint
        }, 250);
    } else {
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();
    }
    return true;
}



