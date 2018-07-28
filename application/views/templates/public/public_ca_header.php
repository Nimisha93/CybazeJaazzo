<div class="body_blur" style="display: none"></div>
<header>
  <section>
    <div class="pos3">
      <div class="container-fluid">
        <div class="bgclr2 navbar navbar-inverse">
          <div class="row topbar">
            <div class="android2"> <a href="#" class="fnt1 border2"><i class="fa fa-android" aria-hidden="true"></i></a> <a href="#" class="fnt1"><i class="fa fa-apple" aria-hidden="true"></i></a></div>
            <div class="su_listnav">
              
            </div>
          </div>
        </div>
        <div class="">
         
        </div>
        <div class="clear"></div>
        <div class="row headerbgclr">
        <div class="col-md-offset-5 col-md-3 col-sm-4 col-xs-8"> <a href="<?= base_url();?>"> <img src="<?= base_url();?>assets/public/images/online-portal-logo.png" alt="Jaazzo logo"> </a> </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
        <!--  <form class="">
           <input type="button" value="" class="indxsearch">
           <input type="search" class="txsrch" placeholder="Search for a product, Brand, or Category">
         </form> -->
       <!-- <form class="serchjazzo" id="">

            <input type="search" id="search_data" class="txsrch" name="search_data" placeholder="Search for a product"  onkeyup="ajaxSearch();">
            <input type="button" value="" class="indxsearch">
        </form>-->

        <div class="drop_down search_dropdown">
            <div class="col-lg-12">
                <div class="col-lg-12 col-sm-12 col-xs-12">

                    <!-- <h4 style="color: #042f6d;">Recent Searches</h4>
                    <div class="options">
                                          <div id="suggestions">
                                          <div id="autoSuggestionsList">
                                          </div>
                                          </div>
                    </div> -->
                    <div id="suggestions">
                        <div id="autoSuggestionsList">
                        </div>
                    </div>

                    <!-- <h4 style="color: #042f6d;">Popular Search</h4>
                    <div class="options">
                                         <div id="suggestions2">
                                         <div id="autoSuggestionsList2">
                                         </div>
                                         </div>
                    </div> -->
                    <div id="suggestions2">
                        <div id="autoSuggestionsList2">
                        </div>
                    </div>

                    <!--chanel partner sedarch  list -->
                    <div id="suggestions3">
                        <div id="autoSuggestionsList3">
                        </div>
                    </div>

                </div>
                <!--<div class="col-lg-6  col-sm-12 col-xs-12">

                                              <div id="suggestions1">
                                              <div id="autoSuggestionsList1">
                                              </div>
                                              </div>
                </div>-->
                <div class="col-lg-12">

                    <a href="get_all_delears/">
                        <h4 style="color: #042f6d; text-align: left;">View All Dealers</h4></a>



                </div>
            </div>
        </div>
        <style>
              .options{
                  background-color:; margin:0px 0px;font-size:14px;
              }
              .options p{
                  margin:0px;
              }
              .drop_down{
                  height:500px;overflow:auto; width:92%; background-color:#fff; float:left; z-index: 9999; position: absolute; padding: 10px 0px 15px; border-top: 1px solid #ccc;    box-shadow: 1px 15px 25px -9px;display:none;
              }
              .brdr_rght{
                  border-right:1px solid #ccc;
              }
              .cart-entry{
                  border-bottom:1px solid #f5f5f5;    padding: 5px;
              }
              .dsnone{display:none;}
              @media (max-width:768px)
              {
                  .drop_down{
                      height:300px;
                  }
              }
            </style>

            <script type="text/javascript">
              function ajaxSearch()
              {
                var input_data = $('#search_data').val();
                if (input_data.length === 0 )
                {
                  var post_data = {
                    'search_data': input_data,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                  };
                  $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>search/search_recent/",
                    data: post_data,
                    success: function (data) {
                        // return success
                      if (data.length > 0) {
                         $('.drop_down').show();
                          $('#suggestions').show();
                          $('#autoSuggestionsList').addClass('auto_list');
                          $('#autoSuggestionsList').html(data);
                      }
                    }
                  });
                    // $('#suggestions').hide();
                }else {
                  var post_data = {
                    'search_data': input_data,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                  };
                  $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>search/search_category/",
                    data: post_data,
                    success: function (data) {
                        // return success
                      if (data.length > 0) {
                         $('.drop_down').show();
                        $('#suggestions3').show();
                        $('#autoSuggestionsList').addClass('auto_list');
                        $('#autoSuggestionsList').html(data);
                      }
                    }
                  });
                }

                var input_data = $('#search_data').val();

                if (input_data.length === 0)
                {
                    var post_data = {
                      'search_data': input_data,
                      '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    };
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url(); ?>search/search_popular1/",
                      data: post_data,
                      success: function (data) {
                          // return success
                        if (data.length > 0) {
                           $('.drop_down').show();
                          $('#suggestions2').show();
                          $('#autoSuggestionsList2').addClass('auto_list');
                          $('#autoSuggestionsList2').html(data);
                        }
                      }
                    });
                    // $('#suggestions1').hide();
                }else {
                  var post_data = {
                    'search_data': input_data,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                  };
                  $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>search/search_products1/",
                    data: post_data,
                    success: function (data) {
                        // return success
                      if (data.length > 0) {
                         $('.drop_down').show();
                        $('#suggestions2').show();
                        $('#autoSuggestionsList2').addClass('auto_list');
                        $('#autoSuggestionsList2').html(data);
                      }
                    }
                  });
                }


                var input_data = $('#search_data').val();

                if (input_data.length === 0)
                {
                    var post_data = {
                      'search_data': input_data,
                      '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    };
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url(); ?>search/search_popular_deals/",
                      data: post_data,
                      success: function (data) {
                          // return success
                        if (data.length > 0) {
                           $('.drop_down').show();
                          $('#suggestions4').show();
                          $('#autoSuggestionsList4').addClass('auto_list');
                          $('#autoSuggestionsList4').html(data);
                        }
                      }
                    });
                    // $('#suggestions1').hide();
                }else {
                  var post_data = {
                    'search_data': input_data,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                  };
                  $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>search/search_deals/",
                    data: post_data,
                    success: function (data) {
                        // return success
                      if (data.length > 0) {
                         $('.drop_down').show();
                        $('#suggestions4').show();
                        $('#autoSuggestionsList4').addClass('auto_list');
                        $('#autoSuggestionsList4').html(data);
                      }
                    }
                  });
                }
              }

                $(document).on('click',function(){
                  $('.drop_down').hide();
                })
            </script>

        </div>
        </div>
      </div>
    </div>
  </section>
</header>
<div class="indxhdrmartop">
<div class="">
  <div class="fulwidth">
      <div class="indxhdrmartop">
          <div class="">
              <div class="fulwidth  btmbdr">

                  <div class="">
                      <nav class="navbar navbar-inverse">
                          <div class="navbar-header">
                              <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                                  <span class="sr-only">Toggle navigation</span>
                                  <span class="icon-bar">
                                    <?php $a=1; if($a==1){
                                    $session_array = $this->session->userdata('logged_in_user');
                                    if(isset($session_array)){
                                        $login_id = $session_array['id'];
                                        //print_r($login_id);
                                    } } ?>
                                  </span>
                                  <span class="icon-bar"></span>
                                  <span class="icon-bar"></span>
                              </button>

                          </div>
                          <div class="collapse navbar-collapse js-navbar-collapse">
                              <ul class="nav navbar-nav">

                                   <?php foreach ($get_menu['main_category'] as $key => $main_category){

                                          if($key=="8")
                                          {
                                            break;
                                          }
                                    ?> 
                                    <li class="dropdown mega-dropdown">
                                        <a href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $main_category['id']; ?>" target="_blank" class="dropdown-toggle" data-toggle="dropdown"><?php echo $main_category['title']; ?><span class="caret"></span></a>
                                        <ul class="dropdown-menu mega-dropdown-menu">

                                                <ul class="divsion">

                                                    <?php foreach ($main_category['category'] as $key => $category){ ?>
                                                        <li class="col-sm-3"><a class="dropdown-header" href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $category['cat_id']; ?>" target="_blank"><?php echo $category['cat_name']; ?></a>
                                                            <ul class="divsion">
                                                            <?php foreach ($category['sub_cat'] as $key => $sub_cat) {
                                                                ?>
                                                                    <li><a href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $sub_cat['sub_cat_id']; ?>" target="_blank"><?php echo $sub_cat['sub_cat_name']; ?></a></li>
                                                                <?php } ?>
                                                            </ul>
                                                        </li>
                                                        <?php } ?>
                                                </ul>

                                        </ul>
                                    </li>
                                   <?php } ?> 


                              </ul>
            <?php foreach ($get_menu['main_category'] as $key1 => $main_category){  


            }
if($key1>=9)
{
            ?>                 



              <ul class="nav navbar-nav navbar-right">

     <ul class="nav navbar-nav moremnu">

      
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" > <i class="fa fa-ellipsis-v" style="font-size:24px;margin-top: 8px"></i></a>
          <ul class="dropdown-menu">
            <?php foreach ($get_menu['main_category'] as $key => $main_category){
                                          if($key>=9)
                                          {
                                            ?>
                                                  <div class="panel-group" id="accordion<?php echo $main_category['id']; ?>">
        <div class="panel panel-default">
          <div class="panel-heading">
           
               <a  style=" font-size: 14px;color: #000; padding-left: 0px !important; line-height: 22px;text-transform: uppercase; font-weight: 600;" accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $main_category['id']; ?>" href="#accordion<?php echo $main_category['id']; ?>_1" href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $main_category['id']; ?>"><li><?php echo $main_category['title']; ?>  
                <i class="fa fa fa-caret-down pull-right" aria-hidden="true"></i></li></a>
          
          </div>
          <div id="accordion<?php echo $main_category['id']; ?>_1" class="panel-collapse collapse">
          <ul class="">

           <?php 

if($main_category['category']!=NULL)
{



           foreach ($main_category['category'] as $key => $category){ ?>
   <a  style=" font-size: 12px;color: #000; padding-left: 0px !important; line-height: 30px;text-transform: uppercase; font-weight: 600;"  href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $category['cat_id']; ?>"><li><?php echo $category['cat_name']; ?></li></a>


 <?php foreach ($category['sub_cat'] as $key => $sub_cat) {
                                                                ?>

<a  href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $sub_cat['sub_cat_id']; ?>"><li><?php echo $sub_cat['sub_cat_name']; ?></li></a>

<?php } ?>


            

                <?php }}

                else{ ?>
                  <a     href=""><li> &nbsp;&nbsp;&nbsp;No sub categories</li></a>

                <?php  } ?>
          </ul>
          </div>
        </div>
       
     
      </div>

            <li class="divider"></li><?php
                                          }



                                         
                                          

                                    ?>

        
            <?php } ?> 
          </ul>
        </li>
      </ul>
                              </ul>


                              <?php } ?>
                          </div><!-- /.nav-collapse -->
                      </nav>
                  </div>


              </div>
          </div>

      </div>
</div>
</div>
 <script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          $('#more').click(function(e){
              e.preventDefault();
             $('#more_div').show();
          });
        });

          //Add member agent
           var datas = { 
                    dataType : "json",
                    success:   function(data){
                      $('.body_blur').hide();
                      if(data.status){
                        swal("Success!", "Your Club Agent Added Successfully.", "success",{timer: 1500});
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                      } else{
                        var regex = /(<([^>]+)>)/ig;
                        var body = data.reason;
                        var result = body.replace(regex, "");
                        swal("Warning!", result, "error");
                      }
                  }
                };
            $('#ca_forms').submit(function(e){     
              e.preventDefault();
              var ca = $("#ca_forms").validationEngine("validate");
              if(ca == true)
              {
                $('.body_blur').show();
                $(this).ajaxSubmit(datas);  
              }          
            });
          //End
    </script>