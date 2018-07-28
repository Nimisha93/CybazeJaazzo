$(document).ready(function(){
    var base_url = $(document).find('#baseurl').val();
    function load_demo(index) {
        index = index || 0;
        var search = $('#search1').val();

        $.post(base_url + "active_friends/" + index, { ajax: true,search:search}, function(data) {
            // console.log(data);
            $('#tbody1').html("");
            $('.body_blur').hide();

            var tr = '';
            if(data.data.length>0){

                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var cur_index=parseInt(index);
                    var imgg = (data1[i].profile_image==='')?'profile.jpg':data1[i].profile_image;
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    if(data1[i].type=='club_member'){ var st='Become Club  Member';}//' style="background:#aae6ab"';}
                    else if(data1[i].type=='normal_customer'){ var st='Member';}
                   
//console.log(data1[i].profile_image);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].name+'</td>'+
                        '<td>'+data1[i].mobile+'</td>'+
                        '<td><img class="profleimge" src="uploads/'+imgg+'" style="width: 70px;height: 70px;"></td>'+
                        '<td>'+data1[i].location+'</td>'+
                        '<td>'+st+'</td>'+
                        '</tr>';

                }
                $('#tbody1').html(tr);
                $('#search1').val(data.search);
                // pagination
                $('#pagination1').html(data.pagination);
            }else{
                tr += '<tr style="text-align:center">'+
                        '<td colspan="6">No Data Found</td>'+
                        '</tr>';
                $('#tbody1').html(tr);$('#pagination1').parent().parent().hide();
            }
        }, "json");
    }
    //calling the function
    load_demo();
    //pagination update
    $('#pagination1').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo(link);
        return false;
    });
    $("#search1").keyup(function(){
        load_demo();
    });

    /////////////////////////////////////////////////////////////
    function load_demo2(index) {
        index = index || 0;
        var search = $('#search2').val();

        $.post(base_url + "refered_friends/" + index, { ajax: true,search:search}, function(data) {
            //console.log(data);
            $('#tbody2').html("");
            $('.body_blur').hide();
            var tr = '';
            if(data.data.length>0){

                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);

                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td class="nam">'+data1[i].name+'</td>'+
                        '<td class="mob">'+data1[i].mobile+'</td>'+
                        '<td class="loc">'+data1[i].location+'</td>'+
                        '<td><button type="button" class="btn addprofiletab" id="update_frend_dtils" data-id="'+data1[i].id+'"><i class="fa fa-plus-circle" aria-hidden="true"></i> <span class="hidbtn_prfl">Update Details </span></button><button type="button" class="btn deletprofiletab del_refer_frnd" data-id="'+data1[i].id+'"><i class="fa fa-trash-o" aria-hidden="true"></i>  <span class="hidbtn_prfl">Delete </span></button></td>'+
                        '</tr>';

                }
                //console.log(tr);
                $('#tbody2').html(tr);
                $('#search2').val(data.search);
                // pagination
                $('#pagination2').html(data.pagination);
            }else{
                tr += '<tr>'+
                        '<td colspan="5" style="text-align:center">No Data Found</td>'+
                        '</tr>';
                $('#tbody2').html(tr);$('#pagination2').parent().parent().hide();
            }
        }, "json");
    }
    //calling the function
    load_demo2();
    //pagination update
    $('#pagination2').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo2(link);
        return false;
    });
    $("#search2").keyup(function(){
        load_demo2();
    });
    ////////////////////////////////////////////////////////////
    function load_demo3(index) {
        index = index || 0;
        var search = $('#search3').val();

        $.post(base_url + "my_channel_partners/" + index, { ajax: true,search:search}, function(data) {
            console.log(data);
            $('#tbody3').html("");
            $('.body_blur').hide();
            if(data.data.length>0){

                var tr = '';
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                     if(data1[i].status=='JOINED'){ var st='Joined';}//' style="background:#aae6ab"';}
                     else if(data1[i].status=='REFERED'){ var st='Refered';}//' style="background:#efc3c3"';}
                     else if(data1[i].status=='APPROVED'){ var st='Approved';}//' style="background:blue"';}
                     else if(data1[i].status=='NOT_APPROVED'){ var st='Not Approved';}//' style="background:grey"';}
                     if(data1[i].status=='REFERED'||data1[i].status=='NOT_APPROVED'){
                        var bt = '<button type="button" class="btn delet_cp" data-id="'+data1[i].id+'"><i class="fa fa-trash-o" aria-hidden="true"></i>  <span class="hidbtn_prfl">Delete </span></button>&nbsp;<a type="button" class="btn btn-primary" href="'+base_url+'edit_cp/'+data1[i].id+'"><i class="fa fa-pencil" aria-hidden="true"></i>  <span class="hidbtn_prfl"> Edit </span></a>';
                     }else{
                        var bt ='<a type="button" class="btn btn-primary" href="'+base_url+'view_cp/'+data1[i].id+'"><i class="fa fa-info" aria-hidden="true"></i>  <span class="hidbtn_prfl">View </span></a>';
                     }
                     tr += '<tr><td>'+sl_no+'</td>'+
                        '<td>'+data1[i].name+'</td>'+
                        // '<td><img src="'+base_url+data1[i].brand_image+'" style="width:25%;height:auto;"></td>'+
                        '<td>'+data1[i].phone+'</td>'+
                        '<td>'+data1[i].email+'</td>'+
                        '<td>'+data1[i].pan+'</td>'+
                        '<td>'+data1[i].owner_name+'</td>'+
                        '<td>'+st+'</td>'+
                        '<td>'+bt+'</td></tr>';
                    console.log(tr);    
                }
                //console.log(tr);
                $('#tbody3').html(tr);
                $('#search3').val(data.search);
                // pagination
                $('#pagination3').html(data.pagination);
            }else{
                    tr += '<tr>'+
                        '<td colspan="8" style="text-align:center">No Data Found</td>'+
                        '</tr>';
                $('#tbody3').html(tr);$('#pagination3').parent().parent().hide();
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
    ////////////////////////////////////////////////////////////
    function load_demo4(index) {
        index = index || 0;
        var search = $('#search4').val();

        $.post(base_url + "my_club_agents/" + index, { ajax: true,search:search}, function(data) {
            // console.log(data);
            $('#tbody4').html("");
            $('.body_blur').hide();
            if(data.data.length>0){

                var tr = '';
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var fileName = data1[i].ca_docs;
                    if(fileName!=null){var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1); }else{var fileExtension = ''; }
               
                    if((fileName!=null)&&fileExtension=='docx'){
                        var da='<iframe class="doc" src="http://docs.google.com/gview?url=<?= base_url();?>uploads/ca_docs/'+fileName+'&embedded=true" style="width:60%" data-title="docs"></iframe>';
             
                    }else if((fileName!=null)&&fileExtension=='pdf'){
                
                        var da='<a href="'+base_url+fileName+'" title="View Docs" target="_blank"><i class="btn btn-sm btn-primary fa fa-file" target="_blank" data-title="pdf"></i></a>';
                
                    }else{
                        var da="No Docs";
                    }
                    var status = (data1[i].status=='approved')?'Active':'Pending';
                    if(data1[i].status=='approved')
                    {
                        var btn ='';
                    }else{
                        var btn ='<button type="button" class="btn delet_ca" data-id="'+data1[i].id+'"><i class="fa fa-trash-o" aria-hidden="true"></i>  <span class="hidbtn_prfl">Delete </span></button';
                    }                    
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].name+'</td>'+
                        '<td>'+data1[i].email+'</td>'+
                        '<td>'+data1[i].mobile+'</td>'+
                        '<td>'+da+'</td>'+
                        '<td>'+status+'</td>'+
                        '<td>'+btn+'</td>'+
                        '</tr>';

                }
                //console.log(tr);
                $('#tbody4').html(tr);
                $('#search4').val(data.search);
                // pagination
                $('#pagination4').html(data.pagination);
            }else{
                tr += '<tr>'+
                        '<td colspan="7" style="text-align:center">No Data Found</td>'+
                        '</tr>';
                $('#tbody4').html(tr);$('#pagination4').parent().parent().hide();
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
    $("#search4").keyup(function(){
        load_demo4();
    });
    ///////////////////////////////////////////////////////////
    function load_demo5(index) {
        index = index || 0;
        var search = $('#search5').val();
        var from = $('.fromdate').val();
        var to = $('.todate').val();

        $.post(base_url + "my_transactions/" + index, { ajax: true,search:search,from:from,to:to}, function(data) {
            console.log(data);
            $('#tbody5').html("");
            $('.body_blur').hide();
            if(data.data.length>0){

                var tr = '';
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var purchased_on=$.datepicker.formatDate( "DD, d MM, yy", new Date(data1[i].purchased_on));
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].name+'</td>'+
                        '<td>'+purchased_on+'</td>'+
                        '<td>'+data1[i].bill_total+'</td>'+
                        '<td>'+data1[i].change_value+'</td>'+
                        '</tr>';

                }
                //console.log(tr);
                $('#tbody5').html(tr);
                $('#search5').val(data.search);
                // pagination
                $('#pagination5').html(data.pagination);
            }else{
                    tr += '<tr>'+
                        '<td colspan="5" style="text-align:center">No Data Found</td>'+
                        '</tr>';
                $('#tbody5').html(tr);$('#pagination5').parent().parent().hide();
            }
        }, "json");
    }
    //calling the function
    load_demo5();
    //pagination update
    $('#pagination5').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo5(link);
        return false;
    });
    $("#search5").keyup(function(){
        load_demo5();
    });
    $(document).on('click', '#btn_search', function () {
        $('.body_blur').show();
        load_demo5();
    });
    ///////////////////////////////////////////////////////////
    function load_demo6(index) {
        index = index || 0;
        var search = $('#search6').val();

        $.post(base_url + "get_my_ba/" + index, { ajax: true,search:search}, function(data) {
            console.log(data);
            $('#tbody6').html("");
            $('.body_blur').hide();
            if(data.data.length>0){

                var tr = '';
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].name+'</td>'+
                        '<td>'+data1[i].mobile+'</td>'+
                        '<td>'+data1[i].email+'</td>'+
                        '<td>'+data1[i].company_name+'</td>'+
                        '<td>'+data1[i].company_contact+'</td>'+
                        '<td>'+data1[i].company_email+'</td>'+
                        '<td>'+data1[i].status+'</td>'+
                        '</tr>';

                }
                //console.log(tr);
                $('#tbody6').html(tr);
                $('#search6').val(data.search);
                // pagination
                $('#pagination6').html(data.pagination);
            }else{
                    tr += '<tr>'+
                        '<td colspan="8" style="text-align:center">No Data Found</td>'+
                        '</tr>';
                $('#tbody6').html(tr);$('#pagination6').parent().parent().hide();
            }
        }, "json");
    }
    //calling the function
    load_demo6();
    //pagination update
    $('#pagination6').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo6(link);
        return false;
    });
    $("#search6").keyup(function(){
        load_demo6();
    });
 
    ///////////////////////////////////////////////////////////
    function load_demo7(index) {
        index = index || 0;
        var search = $('#search7').val();

        $.post(base_url + "get_my_bde/" + index, { ajax: true,search:search}, function(data) {
            console.log(data);
            $('#tbody7').html("");
            $('.body_blur').hide();
            if(data.data.length>0){
                var tr = '';
                var data1 = data.data;

                for(var i = 0; i< data1.length; i++){
                      if(data1[i].status=='NOT_APPROVED'){
                        var st='PENDING';
                      }else if(data1[i].status=='ACTIVE'){
                        var st='ACTIVE';
                      }
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].name+'</td>'+
                        '<td>'+data1[i].phone+'</td>'+
                        '<td>'+data1[i].email+'</td>'+
                        '<td>'+data1[i].designation+'</td>'+
                        '<td>'+st+'</td>'+
                        '</tr>';

                }
                //console.log(tr);
                $('#tbody7').html(tr);
                $('#search7').val(data.search);
                // pagination
                $('#pagination7').html(data.pagination);
            }else{
                    tr += '<tr>'+
                        '<td colspan="6" style="text-align:center">No Data Found</td>'+
                        '</tr>';
                $('#tbody7').html(tr);$('#pagination7').parent().parent().hide();
            }
        }, "json");
    }
    //calling the function
    load_demo7();
    //pagination update
    $('#pagination7').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo7(link);
        return false;
    });
    $("#search7").keyup(function(){
        load_demo7();
    });
    ///////////////////////////////////////////////////////////
    function load_demo8(index) {
        index = index || 0;
        var search = $('#search8').val();

        $.post(base_url + "get_notitfication/" + index, { ajax: true,search:search}, function(data) {
            console.log(data);
            $('#tbody8').html("");
            $('.body_blur').hide();
            if(data.data.length>0){
                var tr = '';
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    if(data1[i].is_read=='true'){
                        var st='Read';
                    }else if(data1[i].is_read=='false'){
                        var st='Unread';
                    }
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>Jaazzo</td>'+
                        '<td>'+data1[i].title+'</td>'+
                        '<td>'+data1[i].notification+'</td>'+
                        '<td>'+st+'</td>'+
                        '<td>'+data1[i].createdon+'</td>'+
                        '</tr>';

                }
                //console.log(tr);
                $('#tbody8').html(tr);
                $('#search8').val(data.search);
                // pagination
                $('#pagination8').html(data.pagination);
            }else{
                    tr += '<tr>'+
                        '<td colspan="6" style="text-align:center">No Data Found</td>'+
                        '</tr>';
                $('#tbody8').html(tr);$('#pagination8').parent().parent().hide();
            }
        }, "json");
    }
    //calling the function
    load_demo8();
    //pagination update
    $('#pagination8').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo8(link);
        return false;
    });
    $("#search8").keyup(function(){
        load_demo8();
    });
    ///////////////////////////////////////////////////////////
    function load_demo9(index) {
        index = index || 0;
        var search = $('#search9').val();
        var from = $('#dt_from').val();
        var to = $('#dt_to').val();
        $.post(base_url + "get_money_transfer/" + index, { ajax: true,search:search,from:from,to:to}, function(data) {
            console.log(data);
            $('#tbody9').html("");
            $('.body_blur').hide();
            if(data.data.length>0){
                var tr = '';
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].to+'</td>'+
                        '<td>'+data1[i].amount+'</td>'+
                        '<td>'+data1[i].wallet+'</td>'+
                        '<td>'+data1[i].tr_date+'</td>'+
                        '</tr>';

                }
                $('#tbody9').html(tr);
                $('#search9').val(data.search);
                // pagination
                $('#pagination9').html(data.pagination);
            }else{
                    tr += '<tr>'+
                        '<td colspan="5" style="text-align:center">No Data Found</td>'+
                        '</tr>';
                $('#tbody9').html(tr);$('#pagination9').parent().parent().hide();
            }
        }, "json");
    }
    //calling the function
    load_demo9();
    //pagination update
    $('#pagination9').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo9(link);
        return false;
    });
    $("#search9").keyup(function(){
        load_demo9();load_demo10();
    });
    $(document).on('click', '#btn_serch', function () {
        $('.body_blur').show();
        load_demo9();load_demo10();
    });
        ///////////////////////////////////////////////////////////
    function load_demo10(index) {
        index = index || 0;
        var search = $('#search9').val();
        var from = $('#dt_from').val();
        var to = $('#dt_to').val();
        $.post(base_url + "get_to_money_transfer/" + index, { ajax: true,search:search,from:from,to:to}, function(data) {
            console.log(data);
            $('#tbody10').html("");
            $('.body_blur').hide();
            if(data.data.length>0){
                var tr = '';
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var cur_index=parseInt(index);
                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].from+'</td>'+
                        '<td>'+data1[i].amount+'</td>'+
                        '<td>'+data1[i].wallet+'</td>'+
                        '<td>'+data1[i].tr_date+'</td>'+
                        '</tr>';

                }
                $('#tbody10').html(tr);
                $('#search10').val(data.search);
                // pagination
                $('#pagination10').html(data.pagination);
            }else{
                    tr += '<tr>'+
                        '<td colspan="5" style="text-align:center">No Data Found</td>'+
                        '</tr>';
                $('#tbody10').html(tr);//$('#pagination10').parent().parent().hide();
            }
        }, "json");
    }
    //calling the function
    load_demo10();
    //pagination update
    $('#pagination10').on('click', '.page_test a', function(e) {
        e.preventDefault();
        //grab the last paramter from url
        var link = $(this).attr("href").split(/\//g).pop();
        load_demo10(link);
        return false;
    });
});