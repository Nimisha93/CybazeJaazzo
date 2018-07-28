<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta mame="description" content=" " />
<meta content="ALL" name="ROBOTS"/>
<meta content="FOLLOW" name="ROBOTS"/>
<meta content="" name="copyright"/>
<meta name="distribution" content="Global" />
<title>Jaazzo | rewards unlimitted</title>
<link rel="shortcut icon" href="<?= base_url();?>assets/public/favicon/favicon.png">
<?= $default_assets;?>

 <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick.css">
 <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick-theme.css">

<link rel="stylesheet" href="<?= base_url();?>assets/public/css/flexslider.css" type="text/css" media="screen" />

    <style type="text/css">

        .row{margin:0;}
        .goToTop{position:fixed;border-bottom:1px solid #ccc;z-index: 17;    background-color: #000;}

        @media (max-width:1030px){

            .goToTop{height:auto;position:relative;}


        }
        @media (max-width:767px){

            .goToTop {
                position: relative;
                top: 0;
                left: 0;
                z-index: 10;
                background-color: #000;
            }
        }
    </style>
</head>

<body>

<!--===========header end here ========================-->


  <?= $header;?>
   
 <section>

    <!-- ====================================================================-->

    <div class="">
        <div class="container-fluid">
            <div class="su_box95_marauoto">
                <div class="su_mnulist">


                    <div class="flexslider carousel">
                        <ul class="slides">
                            <?php foreach ($submenu as $key => $submenu) {
                            $id = $submenu['id'];?>


                            <li>

                                <a href="<?php echo base_url(); ?>Home/module_single/<?php echo $id ?>" target="_blank">
                                    <div class="mnuht">
                                        <i class="fa fa-trello clear2" aria-hidden="true"></i>

                                        <?php echo $submenu['module_name'];?>


                                    </div>
                                    <div class="bordrmnu"><div class="bordrmnu_sub"></div></div>

                                </a>

                            </li>

                            <?php }?>

                        </ul>
                    </div>
                    <!-- ============================================================================================-->
                </div>
            </div>


        </div>
    </div>

    </div>
</section>  

   
  


<div class="clear"></div>

<!--===========main end here ========================-->
<main>
 
  
  <!--===========section end here ========================-->
  
 
    <!--===========section end here ========================-->
  <div class="clear"></div>
  
  

  <div class="bgoff ">
  <div class="container-fluid hover15 ">
  
  <div class=""><!-- strchbxctgry -->
  <div class="rr">
  <?php if(!empty($data['category']) && !empty($data['brands'])){ ?>
  <div class="col-md-3 col-sm-12  br strchbxchild">
      <div class="navbar-header " style="float: none;">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
              <h2 class="ctgry" style="text-align: left">CATEGORIES</h2>
      </div>
      <div class="clearfix">
          <div class="navbar-collapse collapse" id="myNavbar" aria-expanded="false" style="height: 1px;">
              <ul class="nav navbar-nav" style="    display: block !important;">
                  <div class="category-right borright">


                    <?php if(!empty($data['category'])){ ?>
                      <!--- Categories -->
                      <div class="panel-group" id="accordion1">
                          <div class="panel panel-default">
                              <div class="panel-heading panel-head">
                                  <h4 class="panel-title">

                                      <a class="collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse1" aria-expanded="false"> Category <i class="fa fa-angle-down float-right light-font" aria-hidden="true"></i></a>

                                  </h4>
                              </div>
                              <div class="clearfix"></div>
                              <div id="collapse1" class="panel-collapse ovr collapse in" aria-expanded="true" style="">
                                  <div class="panel-body panelbody" style="margin-top:5px;">
                                   <?php foreach($data['category'] as $key1=> $cat){ ?>
                                      <div class="checkbox1 checkbox-primary" style="">
                                        <input class="myCheckboxes1[]" value="<?= $cat['id']; ?>" name="category" id="checkbox<?= $cat['id']; ?>" type="checkbox">
                                          <label style="font-weight: 100;
    text-transform: lowercase;" for="checkbox<?= $cat['id']; ?>"><?= $cat['title']; ?><span class="number-of-items" id=""></span></label>
                                     </div>
                                  <?php } ?>
                                  </div>
                              </div>
                          </div>

                      </div>
                      <!-- Categories -->
                      <?php } ?>
                      <?php if(!empty($data['brands'])){ ?>
                      <!--- brands -->
                      <div class="panel-group" id="accordion2">
                          <div class="panel panel-default">
                              <div class="panel-heading panel-head">
                                  <h4 class="panel-title">

                                      <a class="" data-toggle="collapse" data-parent="#accordion2" href="#collapse2"> Brands <i class="fa fa-angle-down float-right light-font" aria-hidden="true"></i></a>

                                  </h4>
                              </div>
                              <div class="clearfix"></div>
                              <div id="collapse2" class="panel-collapse collapse in ovr">
                                  <div class="panel-body panelbody" style="margin-top:5px;">
                                      <form class="" id="">

                                         <div class="clearfix autobox">
                                         <?php foreach($data['brands'] as $key2=> $br){ ?>
                                          <div class="checkbox1 checkbox-primary" style="">
                                          <input class="myCheckboxes1[]" value="<?= $br['id']; ?>" name="brand" id="checkbox<?= $br['id']; ?>" type="checkbox">
                                          <label style="font-weight: 100;text-transform: lowercase;" for="checkbox<?= $br['id']; ?>"><?= $br['name']; ?><span class="number-of-items" id=""></span></label> </div>

                                         <?php } ?>

                                         </div>

                                      </form>
                              </div>
                          </div> </div>

                      </div>

                      <!-- brands -->
                     <?php } ?>

                  </div>
              </ul>
          </div>
      </div>
  </div>

<?php } ?>






     <!--===========col-md-3 end here ========================-->
 <div class="col-md-9 col-sm-12 col-xs-12 bgclr7 tp50mr" style="margin-bottom: 50px;padding-top: 15px;text-align: center;padding-bottom: 25px" id="product_details">

     <div class="fltrbxmain">
 <h2 class="prttlename">All Products</h2>

     <div class="fltrbx">

       
                 <div class="clearfix"></div>
                
                       <select data-rule="" class="form-control sort" name="sort" id="sort" data-valid="" style="border: none;outline: none;box-shadow: none;">
                         
                          <option value="whatsnew|desc" selected="">New Arrivals</option>
                          <option value="price|desc">Price: High to Low</option>
                          <option value="price|asc">Price: Low to High</option>
                          <option value="popular|desc">Popular</option>
                      </select>


                    
             </div>

     <div class="clearfix"></div>

 <div class="line2 bm_mar10"></div>
 <div class="load_pro hover15" style="text-align: left">
    
    <!-- products -->
      
 </div>
 

<div id="pagination"></div>
  
     <!--===========blk end here ========================-->
 
  
 </div>
      <!--===========col-md-9 end here ========================-->


 </div>
 </div>


  </div>


  </div>

  </div>
</main>
<?php echo $footer; ?>

<script src="<?= base_url();?>assets/public/js/slick.js" type="text/javascript" charset="utf-8"></script> 

<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/public/custom_js/show_all_product.js"></script> -->

<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
        $(".gototop").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });
    });
</script> 
<script type="text/javascript">
        $(document).ready(function(){    
             var base_url = "<?php echo base_url(); ?>";
            
            function load_demo(index) {
              var index = index || 0;
              
              var sort_order = $('#sort option:selected').val();
              var brands=[]; 
               $('input:checkbox[name=brand]:checked').each(function()
                  {
                      brands.push($(this).val());
                  });
               var categories=[]; 
               $('input:checkbox[name=category]:checked').each(function()
                  {
                      categories.push($(this).val());
                  });
                var location = ($('#hidden_location').val())? $('#hidden_location').val(): 0;
                $('.body_blur').show();
              $.post(base_url + "home/get_all_products/"+location+"/page/" + index, {  ajax: true, sort_order : sort_order, category:categories, brand:brands }, function(data) {
                console.log(data);
                  $('.body_blur').hide();

                if(data.status){
                    
                    var div = '';
                    var data1 = data.data.data;
                    console.log(data1.length);
                    for(var i = 0; i< data1.length; i++){                            
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        var opts = ''; 

                    var per = (!data1[i].reward_percentage)?0:data1[i].reward_percentage;
                        
                       
                    div += '<div class="blk tp_mar20"><a target="_blank" href="<?= base_url() ?>home/product_details/'+data1[i].id+'">'+
                           '<div class="deal"><div class="indxprct"> <img src="<?= base_url() ?>'+data1[i].image+'" class="" alt="profile"></div>'+
                           '<div class="su_box100 dealbg1">'+
                           '<h4><img src="<?= base_url() ?>'+data1[i].partner_img+'" class="logoleft" alt="logo"> '+data1[i].partner+'</h4></div>'+
                           '<h3>'+data1[i].name+'</h3>'+
                           '<div class="clear"></div>'+
                           '<div class="">'+
                           '<div class="su3bx">'+
                           '<div class="offferrate1"><span class="rupee">RS</span>'+data1[i].special_prize+'</div></div>'+
                         '<div class="su3bx">'+
                         // '<div class="offferrate3">'+per+'% Off </div>'+
                         '</div><br>'+
                        
                         '<div class="clear"></div></div></div></a></div>';
                       
                    }
                    
                    $('.load_pro').html(div);
                    

                         // pagination
                        $('#pagination').html(data.pagination);
                        
                    }else{
                        
                        
                      // div += '<div class="blk tp_mar20"><h3 style="font-size: 24px;line-height: 50px">No Product Found !!!</h3></div>';
                      //   $('#product_details').html(div);   
                       // $('#pagination').html(data.pagination);
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

           $('.checkbox1').on('change',function(e){

               e.preventDefault();  
                      
                load_demo();
            });
  
        });
        
    </script>


<script defer src="<?= base_url();?>assets/public/js/jquery.flexslider.js"></script>

<script type="text/javascript">

    (function() {

        // store the slider in a local variable
        var $window = $(window),
                flexslider = { vars:{} };

        // tiny helper function to add breakpoints
        function getGridSize() {

        }
        $window.load(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                autoplay: "false",
                animationSpeed: 400,
                animationLoop: false,
                itemWidth: 120,
                itemMargin: 5,
                minItems: getGridSize(), // use function to pull in initial value
                maxItems: getGridSize(), // use function to pull in initial value
                start: function(slider){
                    $('body').removeClass('loading');
                    flexslider = slider;
                }
            });
        });

        // check grid size on resize event
        $window.resize(function() {
            var gridSize = getGridSize();

            flexslider.vars.minItems = gridSize;
            flexslider.vars.maxItems = gridSize;
        });
    }());

</script>

</body>
</html>