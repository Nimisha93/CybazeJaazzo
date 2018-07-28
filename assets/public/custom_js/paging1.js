$(document).ready(function(){
    var base_url = $(document).find('#baseurl').val();
    ///Rewards through Members
    function load_demo1(index) {
        index = index || 0;
        var search = $('#search1').val();

        $.post(base_url + "rewards_by_members/" + index, { ajax: true,search:search}, function(data) {
            $('#tbody1').html("");
            $('.body_blur').hide();

            var tr = '';
            if(data.data){
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].name+'</td>'+
                        '<td>'+data1[i].rewards+'</td>'+
                        '<td>'+data1[i].purchase_date+'</td>'+
                        '</tr>';

                }
                $('#tbody1').html(tr);
                $('#search1').val(data.search);
                // pagination
                $('#pagination1').html(data.pagination);
            }else{
                tr += '<tr style="text-align:center">'+
                        '<td colspan="4">No Data Found</td>'+
                        '</tr>';
                $('#tbody1').html(tr);
            }
        }, "json");
    }
    //calling the function
    load_demo1();
    //pagination update
    $('#pagination1').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo1(link);
        return false;
    });
    $("#search1").keyup(function(){
        load_demo1();
    });

    ///Channel Partner
    function load_demo3(index) {
        index = index || 0;
        var search = $('#search3').val();

        $.post(base_url + "rewards_by_cp/" + index, { ajax: true,search:search}, function(data) {
            $('#tbody3').html("");
            $('.body_blur').hide();

            var tr = '';
            if(data.data){
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].name+'</td>'+
                        '<td>'+data1[i].amount+'</td>'+
                        '</tr>';

                }
                $('#tbody3').html(tr);
                $('#search3').val(data.search);
                // pagination
                $('#pagination3').html(data.pagination);
            }else{
                tr += '<tr style="text-align:center">'+
                        '<td colspan="3">No Data Found</td>'+
                        '</tr>';
                $('#tbody3').html(tr);
            }
        }, "json");
    }
    //calling the function
    load_demo3();
    //pagination update
    $('#pagination3').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo3(link);
        return false;
    });
    $("#search3").keyup(function(){
        load_demo3();
    });
    ///Club agents
    function load_demo4(index) {
        index = index || 0;
        var from = $('.fromdate').val();
        var to = $('.todate').val();
        var search = $('#search4').val();

        $.post(base_url + "rewards_by_clubagents/" + index, { ajax: true,search:search,from:from,to:to}, function(data) {
            $('#tbody4').html("");
            $('.body_blur').hide();

            var tr = '';
            if(data.data){
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].name+'</td>'+
                        '<td>'+data1[i].amount+'</td>'+
                        '<td>'+data1[i].purchase_date+'</td>'+
                        '<td>'+data1[i].by+'</td>'+
                        '</tr>';

                }
                $('#tbody4').html(tr);
                $('#search4').val(data.search);
                // pagination
                $('#pagination4').html(data.pagination);
            }else{
                tr += '<tr style="text-align:center">'+
                        '<td colspan="4">No Data Found</td>'+
                        '</tr>';
                $('#tbody4').html(tr);
            }
        }, "json");
    }
    //calling the function
    load_demo4();
    //pagination update
    $('#pagination4').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo4(link);
        return false;
    });
    $("#btn_serh").click(function(){
        load_demo4();
    });
});