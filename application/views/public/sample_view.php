<?php echo $header; ?>
<style>
  

   .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #ccc;z-index: 17;    background-color: #d88909;}

    @media (max-width:1030px){

        .goToTop{height:auto;position:relative;}


    }
    @media (max-width:767px){

        .goToTop {
            position: relative;
            top: 0;
            left: 0;
            z-index: 10;
            background-color: #d88909;
        }
    }
    
    .prdctarea {
        margin-top: 25px;
        margin-left: 0px;
    }
   
    .ftrd_hding{padding:8px 13px;width: 99%;
       }

    .prdctbx1 {
      
        margin-left: -1px;
  
    }


</style>

</head>
<body>
<?php echo $side_bar; ?>
<div class="container">
<div class="row content">

<?php echo $category; ?>
<div class="clearfix"></div>
<!-- *********************************************************************************-->
<div class="rightbx_inner">
<div>

<!--**********************************************************************-->
<div class="">
<div class="strchbx">
<div class="prdctarea">
    <?php
if(empty($data['results'])){

    ?>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 category-right">

        <div class="cart-empty-icon">   <i class="fa fa-shopping-cart" aria-hidden="true"></i>

        </div>
        <h3>No Product Found</h3>

    </div>
  <?php } else{?>
<div class="col-md-3 col-sm-5 col-xs-12 cartbxright strchbxchild2 flt">
   <div class="" id="cart-block">
    </div>
</div>


<div class="col-md-9 col-sm-7 col-xs-12 " id="all_product">

 <div class="col-lg-12 border-hd">

                        <div class="col-lg-6">
                          
                        </div>
                        <div class="col-lg-6"  style="margin-top:12px;">
                            <select data-rule="" class="form-control sort" name="sort" id="sort" data-valid="">
                                <option value="popularity|desc">Popularity</option>
                                <option value="whatsnew|desc" selected="">New Arrivals</option>
                                <option value="price|desc">Price: High to Low</option>
                                <option value="price|asc">Price: Low to High</option>
                            </select>
                        </div>
 </div>
 <div class="clearfix"></div>
    <div class="">
 <?php $cat = $cat_id ?>

<div class="ftrd_hding"> <?php echo $cat_name;?>&nbsp; <?php echo $no_prdcts;?> Products </div>
<div class="lodmr ">






   
</div>
 <div id="pagination"></div>
</div>

</div>

 
  <?php } ?>

</div>
</div> </div>

</div>
</div>
</div>
<!-- *********************************************************************************-->

<div class="clear"></div>

</div>
</div>

<?php echo $footer; ?>

<script type="text/javascript">

    $(document).ready(function(){

        $(document).on('click', '.add_cart', function () {


            var product_id = $(this).data("productid");
            var product_name = $(this).data("productname");
            var price = $(this).data('price');
            var product_price = $(this).data("spl_price");
            var sh_charge = $(this).data("sh_charge");
            var seller = $(this).data("seller");
            var image = $(this).data("img");

            var option = $(this).data("option");
            var option_val = $(this).data("option_val");
            var option_name = $(this).data("option_name");
            var pr_quantity    =$(this).data("quantity");
            //var quantity = $('#' + product_id).val();
            var qtys = $(this).parent().parent().find('.qty').val();

            if(qtys=='')
            {
                swal({
                            title: "Plese Enter Quantity Of The Product",
                            text: "You Can,t Add The Product In Cart",
                            type: "warning",
                            confirmButtonColor: "#00B08F",
                            confirmButtonText: "Ok!",
                            closeOnConfirm: true
                        },
                        function()
                        {

                        });
            }
            else
            {
                qty=qtys;
                $.post('<?= base_url(); ?>public/Checkout/check_product_qty/'+option,{},function(data)
                {

                    if(data.status==true)
                    {
                        $.ajax({
                            url:"<?php echo base_url(); ?>public/shopping_cart/add",
                            method:"POST",
                            data:{product_id:product_id, product_name:product_name,qty:qty, product_price:product_price, image:image, price:price, option_name:option_name, option:option, option_val:option_val, sh_charge:sh_charge, seller:seller,quantity:pr_quantity},
                            success:function (data) {
                                $().toastmessage('showToast', {text: 'Item Added To Cart', position: 'top-right', type: 'success'});
                                window.scrollTo(0, 0);
                                $('#cart-block').html(data);
                                $('#' + product_id).val('');

                            }
                        });
                    }
                    else
                    {
                        swal({
                                    title: "Product is out of stock",
                                    text: "You can't add the product in cart",
                                    type: "warning",
                                    confirmButtonColor: "#00B08F",
                                    confirmButtonText: "Ok!",
                                    closeOnConfirm: true
                                },
                                function()
                                {

                                });
                    }

                },'json')
            }




        });
    });

   
      

</script>

<script type="text/javascript">
        $(document).ready(function(){
            
            
            
             var base_url = "<?php echo base_url(); ?>";
            var cat_id = "<?php echo $cat_id; ?>";
            function load_demo(index) {
              index = index || 0;
              var cat_id = "<?php echo $cat_id; ?>";
              sort_order = $('#sort option:selected').val();
           
                $('.body_blur').show();
              $.post(base_url + "products/get_products/"+cat_id+'/page/' + index, {  ajax: true, sort_order : sort_order}, function(data) {
            
                  $('.body_blur').hide();
                if(data.status){
                    
                    var div = '';
                    var data1 = data.data;
                   
                    for(var i = 0; i< data1.length; i++){                            
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        var opts = ''; 
                       
                        var selcted = data1[i].selected_quantity;
                         var favrate = selcted.favorites_count == 0 ? 'fa fa-heart-o' : 'fa fa-heart'; 
                         if(selcted.availability == 'NOT_IN_STOCK'){ 
                                var out_ofstock = '<div class="out_stock"><p>Out of Stock</p> </div>';
                            }else{
                                var out_ofstock = '';
                            }
                        var options =  data1[i].quantities;  
                        for(var j = 0; j< options.length; j++){
                            opts += '<option value="'+options[j].pov_id+'">'+options[j].optionname+'</option>'
                        }
                      var pri = '';
                         if(selcted.actual_price!=selcted.specialprice){ 
                           var pri = '<div class="price"><i class="fa fa-inr" aria-hidden="true"></i> '+selcted.actual_price+'  </div>';
                        } 
                    div += '<div class="prdctbx1">'+out_ofstock+'<div class="product" data-price="5">'+
        '<input type="hidden" class="pr_id" value="'+selcted.pov_id+'">'+
        '<div class="imagbx1"> <a href="<?php echo base_url();?>products/view/'+data1[i].id+'" target="_blank"><img src="'+data1[i].productimage+'" alt="" class="img-responsive image"></a> </div>'+
        '<div class="title">'+ pri +
           
            '<div class="actlprc"><i class="fa fa-inr" aria-hidden="true"></i> '+selcted.specialprice+'</div>'+
            
            '<a class="wishlsticon" href=""><i class="'+favrate+' add_to_wishlist" aria-hidden="true"></i></a>'+
        '</div>'+
        '<div class="clearfix"></div><a href="<?php echo base_url();?>products/view/'+data1[i].id+'" target="_blank">'+
        '<div class="description"><p data-toggle="tooltip" title="' +data1[i].productname+' "> '+data1[i].productname+' </p></div></a>'+

        '<select class="soflow option" name="option">'+opts+'</select>'+
'<div class="qty_bx">'+
              
                '<input type="number" class="qtywdth product_qty quantity" placeholder="Qty" value="1" min="1">'+
            '</div>'+
            '<div class="clearfix"></div>'+
        '<div class="btnbxcrt">'+
        '<input type="hidden" name="product_id" value="'+data1[i].id+'" class="product_id">'+
            '</div>'+

'<input type="hidden" name="pov_val_id" class="pov_val_id" value="'+selcted.pov_id+'">'+
              '<input type="hidden" name="price" class="price1" value="'+selcted.actual_price+'">'+
               '<input type="hidden" name="splprice" class="splprice" value="'+selcted.specialprice+'">'+
               '<input type="hidden" name="option_name" class="option_name" value="'+selcted.opt+'">'+
               '<input type="hidden" name="option_val" class="option_val" value="'+selcted.optionname+'">'+
              '<div class="addcrttxt add_cart" data-img="'+data1[i].imag_prdct+'" data-product_optid="'+selcted.pov_id+'" data-option_name="'+selcted.opt+'"   data-price="'+selcted.actual_price+'" data-splprice="'+selcted.specialprice+'" data-option_val="'+selcted.optionname+'"  data-productname="'+data1[i].productname+'"><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</div>'+

       
    '</div>'+
'</div>';
                        
                    }
                    
                    $('.lodmr').html(div);
                    

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
            
          
             $(document).on('change', '.sort', function(e)
            {
                e.preventDefault();      
                load_demo();
            });
        });
        
    </script>


</body>
</html>