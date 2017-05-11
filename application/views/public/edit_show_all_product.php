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
<title>Greenindia</title>
<link rel="shortcut icon" href="<?= base_url();?>assets/public/favicon/favicon.png">
<?= $default_assets;?>

 <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick-theme.css">


  
  
   
   
<style type="text/css">

.row{margin:0;}
.goToTop{position:fixed;background-color:#1268b3;border-bottom:1px solid #000;z-index: 17;}




@media (max-width:1000px){
  
.goToTop{height:auto;position:relative;background-color:#fff;}
  
  
}
@media (max-width:767px){
  
  .goToTop {
  position: static;
  top: 0;
  left: 0;
  height: 210px;
  z-index: 10;
}
.row{margin:0;}
}
</style>





    
<style>
.row{margin-left:0; margin-right:0;}

.goToTop{height:50px;position:fixed;background-color:#fff;border-bottom:1px solid #000}
@media (max-width:1000px){
  
.goToTop{height:auto;position:relative;background-color:#fff;}
  
  
}

</style>
</head>

<body>

<!--===========header end here ========================-->


  <?= $header;?>
   
   

   
  


<div class="clear"></div>

<!--===========main end here ========================-->
<main>
 
  
  <!--===========section end here ========================-->
  
 
    <!--===========section end here ========================-->
  <div class="clear"></div>
  
  
 
  <div class="bgclr6">
  <div class="container-fluid ">
 <div class="col-md-3 col-sm-3 hidtab">
 <div class="su_box95_marauoto border_right1 bgclr2 top_pad50">
 <div class="deal_ctgry">
<h3> Categories</h3>

 <!-- <ul> -->
 <select name="catgery" id="catgery" class="catgery form-control">
  <!-- <option value="0">Please Select</option> -->
<?php foreach ($get_category['category'] as $key => $category) { ?>
 
  <option value="<?php echo $category['id'];?>"><?php echo $category['title'];?></option>
    <?php foreach ($category['subcat'] as $key => $subcategory) { ?>
     
      <option style="margin-left: 20px ;" value="<?php echo $subcategory['id'];?>"><?php echo $subcategory['title'];?></option>
  <?php  }
  } ?>
   </select>
 <!-- </ul> -->
 </div>

             <div class="deal_ctgry brands_division">
<h3> Brands</h3>
<select name="brands" id="brands" class="brands form-control">
  <!-- <option value="0">Please Select</option> -->

  <?php foreach ($get_brand as $key => $brand) { ?>
  <option value="<?php echo $brand['id'];?>"><?php echo $brand['name'];?></option>
  <?php } ?>
</select>



 </div>
 </div>
 </div>

 <div class="dropdown drp8">
              <button class="dropbtn"><i class="fa fa-sort" aria-hidden="true"></i><span class="pd1">CATEGORIES:</span></button>
              <div class="dropdown-content"> 
           <?php foreach ($get_category['category'] as $key => $category) { ?>
  
   <a href="#"><?php echo $category['title'];?></a> 
    <?php foreach ($category['subcat'] as $key => $subcategory) { ?>
    <a href="#"><?php echo $subcategory['title'];?></a> 
     
  <?php  }
  } ?>

                
              </div>
            </div>


     <!--===========col-md-3 end here ========================-->
 <div class="col-md-9 col-sm-12 col-xs-12 bgclr7 top_pad50">
 
 <h2 class="text-left">All Products</h2>
 <div class="line2 bm_mar10"></div>
 <div class="load_pro">
   
 </div>
 

<div id="pagination"></div>
  
     <!--===========blk end here ========================-->
 
  
 </div>
      <!--===========col-md-9 end here ========================-->


 </div></div>
 
 
 
 
  
</main>
<?php echo $footer; ?>
<!-- <script src="<?= base_url();?>assets/public/js/cbpHorizontalMenu.min.js"></script>
<script>
      $(function() {
        cbpHorizontalMenu.init();
      });
    </script> -->


<!--=======================================slider right==============================================--> 

<script src="<?= base_url();?>assets/public/js/slick.js" type="text/javascript" charset="utf-8"></script>

  
 



<script type="text/javascript" src="<?php echo base_url();?>assets/public/custom_js/show_all_product.js"></script>

<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
        $(".gototop").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });
    });
</script> 

</body>
</html>