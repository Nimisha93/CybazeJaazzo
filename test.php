var base_url = $(document).find('#baseurl').val();
function load_products(index) {
index = index || 0;
//  var filter = isNaN(parseInt($("#brands :checked").val())) ? 0 : parseInt($("#brands :checked").val());
//  var filter = $('.brands :checked').val();
var brand = $('#brands option:selected').val();
var catgery = $('#catgery option:selected').val();
//  alert(filter);


$('.body_blur').show();
$.post(base_url + "/home/get_all_products/" + index, {  ajax: true, brand: brand, catgery : catgery }, function(data) {

$('.body_blur').hide();
if(data.status){

var div = '';
var data1 = data.data;
console.log(data1);exit;

for(var i = 0; i< data1.length; i++){

var bal = data1[i].actual_cost - data1[i].cost;
var perc = (100 * bal)/data1[i].actual_cost;
div +=' <div class="blk tp_mar20">'+
    '<div class="deal"> <img src="'+base_url+'uploads/'+data1[i].image+'" class="indxprct">'+

        '<a href="'+base_url+'home/product_details/'+data1[i].id+'">'+
            '<div class="redmr2">Get this deal</div>'+
            '</a>'+
        '<div class="su_box100 dealbg1">'+
            '<h4><img src="'+base_url+'uploads/'+data1[i].partner_img+'" class="logoleft">Deal with '+data1[i].partner+'</h4>'+
            '</div>'+

        '<h3>'+data1[i].name+'</h3>'+
        '<div class="clear"></div>'+
        '<div class="">'+
            '<div class="su3bx">'+
                '<div class="oldrate1"><span class="rupee">RS</span>'+data1[i].actual_cost+'</div>'+
                '</div>'+
            '<div class="su3bx">'+
                '<div class="offferrate1"><span class="rupee">RS</span> '+data1[i].cost+' </div>'+
                '</div>'+

            '<div class="su3bx">'+
                '<div class="offferrate3">'+Math.round(perc)+'% Off </div>'+
                '</div>'+

            '</div>'+

        '<div class="clear"></div>'+
        '</div>'+

    '</div>';




}

$('.load_pro').html(div);


$('#pagination').html(data.pagination);

}else{

$('.load_pro').html('');


}



}, "json");
}

$(document).ready(function(){
//  alert("io");
$('#catgery').attr('size', $('#catgery option').size());
$('#brands').attr('size', $('#brands option').size());
load_products();
//pagination update
$('#pagination').on('click', '.page_test a', function(e) {
e.preventDefault();
//grab the last paramter from url
var link = $(this).attr("href").split(/\//g).pop();
console.log(link);
load_products(link);
return false;
});
$(document).on('change', '.brands', function(){

load_products();
});
$(document).on('change', '.catgery', function(){

load_products();
});
});
