<!DOCTYPE html>
<html lang="en">
<head>

<!-- Syntax Highlighter -->
<!-- Demo CSS -->
<link rel="stylesheet" href="<?= base_url();?>assets/slider/flexslider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?= base_url();?>assets/public/css/easy-responsive-tabs.css">
<!-- Modernizr -->
<script src="<?= base_url();?>assets/slider/js/modernizr.js"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta mame="description" content=" " />
<META content="ALL" name="ROBOTS"/>
<META content="FOLLOW" name="ROBOTS"/>
<META content="" name="copyright"/>
<meta name="distribution" content="Global" />
<title>Greenindia</title>
<link rel="shortcut icon" href="<?= base_url();?>assets/public/favicon/favicon.png">
<?= $default_assets;?>
   
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
</head>

<body>

<!--===========header end here ========================-->

<?= $header;?>
<div class="container ">
  <section class="maincntnr fntclr">
  <div class="bgprflmain">
    <div id="sub">
      <ul class="resp-tabs-list bgprflsub">
        <li id="profile">
          <div class="prfltop padddeactiv"  style="margin-top:-10px;">
            <div class="col-lg-12 col-md-12 col-sm-12 whitfntclr text-center"> Welcome <?php echo  $user['name']; ?> </div>
          </div>
          <div class="bgprofile padddeactiv">

            <div class="col-lg-12 col-md-12 col-sm-12"> <img class="smalpr" src="<?php echo base_url();?>uploads\<?= $user['profile_image'];?>">
              <div class="whitfntclr"> <?php echo  $user['name']; ?> </div>
            </div>
          </div>
        </li>
       <!--  <li id="history"><i class="fa fa-inbox rght5" aria-hidden="true"></i> Notification
          <div class="rondcount pull-right">12</div>
        </li>
        <li id="md-statments"><i class="fa fa-inbox rght5" aria-hidden="true"></i> Wallet
          <div class="rondcount pull-right">12</div>
        </li>
        <li id="vision"><i class="fa fa-inbox rght5" aria-hidden="true"></i> Message
          <div class="rondcount pull-right">12</div>
        </li> -->
        <li id="md-statment"><i class="fa fa-inbox rght5" aria-hidden="true"></i>View  All Active Friends
          <!-- <div class="rondcount pull-right"></div> -->
        </li>
        <li id="vision"><i class="fa fa-inbox rght5" aria-hidden="true"></i>View  All Reffered Friends
          <!-- <div class="rondcount pull-right"></div> -->
        </li>
        <li id="csr"><i class="fa fa-inbox rght5" aria-hidden="true"></i> Account Settings </li>
      </ul>
      <div class="resp-tabs-container">
        <div>
          <div class="video clearfix"> </div>
          <div class="row">
            <div class="rowDetail">
              <div class="second">
                <div class="prf_pic">
                  <div id="container" class="cf">
                    <div id="main" role="main">
                      <div class="col-md-5 col-sm-6 col-xs-12">
                        <div id="slider" class="flexslider" style="background:none; border:none;max-width:300px;clear:both">
                          <ul class="slides">
                            <?php  foreach($user_image as $row)
   {
    ?>
                            <li>
                              <?php /*?><?php var_dump($user_image)?> <?php */?>
                            <img style="height:264px;width:188px" src="<?php echo base_url();?>uploads\<?= $row['profile'];?>"  />
                              <?php /*?><img src="<?php echo base_url();?>uploads/<?= $row['profile'];?>" style="max-height:260px;" /><?php */?>
                            </li>
                            <?php
      }
      ?>
                          </ul>
                        </div>
                        <div id="carousel" class="flexslider" style=" background:none; border:none; margin-left:10px;   margin-top:-50px;">
                          <ul class="slides">
                            <?php  foreach($user_image as $rows)
               {
                ?>
                            <li> 
                              <!-- <?php echo $user['user_id']?> --> 
                              
                              <img style="height:30px;width:30px" src="<?php echo base_url();?>uploads/<?= $rows['profile'];?>"> </li>
                            <?php
      }
      ?>
                          </ul>
                        </div>
                        <div id="wrapper">
                            <?php echo form_open_multipart('Home/do_upload');?>
                          <div class="fileUpload uplaodbuttn"> <span>Upload image</span>
                            <input id="fileUpload" multiple type="file" name="userfile[]" class="upload"/>

                          </div>
                            <input type="submit" name="upload" class="btn btn-success" value="Save">
                         </form>
                          <div id="image-holder"></div>
                        </div>

                      </div>

                      <div class="col-md-7 col-sm-6 col-xs-12">
                        <div class="prname"><?php echo  $user['name']; ?></div>
                        <div class="praddrs"><?php echo  $user['address']; ?></div>
                        <div class="prphone"><i class="fa fa-mobile prclr1" aria-hidden="true"></i> <?php echo  $user['phone']; ?></div>
                        <div class="prphone2"><i class="fa fa-mobile prclr2" aria-hidden="true"></i> <?php echo  $user['phone2']; ?></div>
                        <div class="prphone"><i class="fa fa-envelope-o prclr1" aria-hidden="true"></i> <?php echo  $user['email']; ?></div>
                        <div class="socialmediaicon">
                          <ul>
                            <a href="" target="_blank">
                            <li> <i class="fa fa-facebook" aria-hidden="true"></i></li>
                            </a> <a href="" target="_blank">
                            <li><i class="fa fa-google-plus" aria-hidden="true"></i></li>
                            </a> <a href="" target="_blank">
                            <li><i class="fa fa-twitter" aria-hidden="true"></i></li>
                            </a>
                          </ul>
                        </div>
                        <button type="button" class="editsub" id="editsub" data-toggle="modal" data-target="#myModal">Edit Info</button>
                        <?php echo form_open_multipart('Home/do_upload');?> </div>
                      </form>
                    </div>
                  </div>

                  <div class="clear"></div>
                  <ul class="nav nav-tabs prtp50">
                    <li class="active"><a data-toggle="tab" href="#active_friends">Active Friends</a></li>
                    <li><a data-toggle="tab" href="#menu1">Reffered Friend</a></li>
                  </ul>
                  <div class="tab-content">
                    <div id="active_friends" class="tab-pane fade in active">
                      <?php $limit=1; foreach($child as $key => $chi){ ?>

                      <div class="actvfrndbx"><?php if($chi['profile_image']!=0){ ?><img class="actfrdimag" src="<?php echo base_url();?>uploads/<?php echo $chi['profile_image']; ?>" />
                      <?php }else{ ?><img class="actfrdimag" src="<?php echo base_url();?>uploads/default.jpg" /><?php } ?>
                        <div class="acvtfrddescrption">
                          <div class="actfrdname"><?php echo $chi['name'];?></div>
                          <div class="actfrdphone"><i class="fa fa-mobile prclr2" aria-hidden="true"></i><?php echo $chi['mobile'];?></div>
                          <div class="actfrdphone"><i class="fa fa-envelope-o prclr2" aria-hidden="true"></i><?php echo $chi['email'];?></div>
                          <div class="vieprfl"><a class="" href="" target="_blank">View profile</a></div>
                        </div>
                      </div>
                      <?php if($limit==4){ break; } $limit=$limit+1; } ?>

                      </div>
                    
                    <!--//////////////////////////////////////////////////////////////////////////-->
                    
                    <div id="menu1" class="tab-pane fade">
                      <?php $limit=1; foreach($refer as $key => $ref){ ?>
                      <div class="actvfrndbx2">
                        <div class="actfrdname2"><?php echo $ref['name'];?></div>
                        <div class="actfrdphone"><i class="fa fa-mobile prclr" aria-hidden="true"></i><?php echo $ref['mobile'];?></div>
                        <div class="actfrdphone"><i class="fa fa-mobile prclr" aria-hidden="true"></i><?php echo $ref['altmobile'];?></div>
                        <div class="actfrdphone"><i class="fa fa-envelope-o prclr" aria-hidden="true"></i><?php echo $ref['email'];?></div>
                        <div class="actfrdphone"><i class="fa fa-envelope-o prclr" aria-hidden="true"></i><?php echo $ref['altemail'];?></div>
                      </div>
                      <?php if($limit==6){ break; } $limit=$limit+1; } ?>
                      
                    </div>
                  </div>
                  
                  <!-- jQuery --> 
                  <script src="<?php echo base_url();?>assets/public/js/jquery.1.10.2.min.js"></script> 
                  <script>window.jQuery || document.write('<script src="<?php echo base_url();?>assets/public/js/libs/jquery-1.7.min.js">\x3C/script>')</script> 
                  
                  <!-- FlexSlider --> 
                  <script defer src="<?php echo base_url();?>assets/slider/js/jquery.flexslider.js"></script> 
                  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 30,
        itemMargin: 5,
        asNavFor: '#slider'
      });

      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script> 
                  
                  <!-- Syntax Highlighter --> 
                 
                </div>
                
                <!--<div class="col-md-12 discription">
                  <div class="hello1">
                      Personal Information
                    </div>
                     <div class="line22"></div>
                   
                     <div class="nm">
                      <div class="lft_txt">
                          Name
                        </div>
                        <div class="right_txt">
                           <?php echo  $user['name']; ?>
                        </div>
                     </div>
                     
                     <div class="adrs">
                      <div class="lft_txt_1">
                          Address
                        </div>
                        <div class="right_txt">
                         <?php echo  $user['address']; ?>
                        </div>
                     </div>
                     <div class="ph1">
                      <div class="lft_txt_11">
                          Phone
                        </div>
                        <div class="right_txt">
                          <?php echo  $user['phone']; ?>
                        </div>
                     </div>
                     <div class="ph2">
                      <div class="lft_txt_11">
                          Phone
                        </div>
                        <div class="right_txt">
                          <?php echo  $user['phone2']; ?>
                        </div>
                     </div>
                      <div class="emil">
                      <div class="lft_txt_11">
                          Email
                        </div>
                        <div class="right_txt">
                         <?php echo  $user['email']; ?>
                        </div>
                     
                     </div>

               </div>--> 
                
                <!--  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                         <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">update</button>
                      </div> -->
                
                </form>
              </div>
            </div>
          </div>
        </div>
        
        <!-- tab 2-->
        
      <!--   <div class="row">
          <div class="rowDetail">
            <div class="prntfction">
              <div class="rondcount2">1</div>
              <p>For over a decade <strong>ASIss</strong> remained focused on delivering minute design solutions and high end interior projects. When it comes to professional and quality fit out we are unparalleled. </p>
            </div>
            
            
            
            <div class="prntfction">
              <div class="rondcount2">2</div>
              <p>For over a decade <strong>ASI</strong> remained focused on delivering minute design solutions and high end interior projects. When it comes to professional and quality fit out we are unparalleled. </p>
            </div>
            
            
            
            <div class="prntfction">
              <div class="rondcount2">3</div>
              <p>For over a decade <strong>ASI</strong> remained focused on delivering minute design solutions and high end interior projects. When it comes to professional and quality fit out we are unparalleled. </p>
            </div>
            
            
            
            <div class="prntfction">
              <div class="rondcount2">12</div>
              <p>For over a decade <strong>ASI</strong> remained focused on delivering minute design solutions and high end interior projects. When it comes to professional and quality fit out we are unparalleled. </p>
            </div>
            
            
            
          </div>
        </div> -->
        
        <!-- tab 3-->
       <!--  <div>
          <div class="row">
            <div class="rowpic"> </div>
            <div class="rowDetail">
              <div class="tp10">
                <div class="col-xs-12">
                 <p> We are committed to delivering world class interior spaces utilising the latest technological and manufacturing methods that that meet the unique needs and expectations of each client. </p>
                </div>

              </div>
            </div>
          </div>
        </div> -->
        
        <!-- tab 4-->
        
      <!--   <div>
          <div class="row">
            <div class="rowpic"> </div>
            <div class="rowDetail"> 
             
              <p> <strong>ASI</strong> forms the interior fit out arm of construction conglomerate Al Shafar General Contracting, which is the flagship company of Bin Shafar Holding. Here are all the subsidiaries falling under Bin Shafar Holding: </p>
              <div class="gorup"> </div>
              
           
              
            </div>
          </div>
        </div>
         -->
        <!-- tab 5-->
        
        <div>
          <div class="row">
            <div class="rowDetail">
              <div class="second">
                <div class="prf_pic">
                  <div class="clear"></div>
                  <li class="">Active Friends</li>
                  <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                      
                      <?php foreach($child as $key => $chi){ ?>

                      <div class="actvfrndbx"><?php if($chi['profile_image']!=0){ ?><img class="actfrdimag" src="<?php echo base_url();?>uploads/<?php echo $chi['profile_image']; ?>" />
                      <?php }else{ ?><img class="actfrdimag" src="<?php echo base_url();?>uploads/default.jpg" /><?php } ?>
                        <div class="acvtfrddescrption">
                          <div class="actfrdname"><?php echo $chi['name'];?></div>
                          <div class="actfrdphone"><i class="fa fa-mobile prclr2" aria-hidden="true"></i><?php echo $chi['mobile'];?></div>
                          <div class="actfrdphone"><i class="fa fa-envelope-o prclr2" aria-hidden="true"></i><?php echo $chi['email'];?></div>
                          <div class="vieprfl"><a class="" href="" target="_blank">View profile</a></div>
                        </div>
                      </div>
                      <?php } ?>

                      
                      
                      <!-- *******************--> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- tab 6-->
        <div>
          <div class="row">
            <div class="rowDetail">
              <div class="second">
                <div class="prf_pic">
                  <div class="clear"></div>
                  <ul class="nav ">
                    <li>Reffered Friends</li>
                  </ul>
                  <div class="tab-content">
                    <div id="" class="tab-pane fade in active">
                      
                       <?php foreach($refer as $key => $ref){ ?>
                      <div class="actvfrndbx2">
                        <div class="actfrdname2"><?php echo $ref['name'];?></div>
                        <div class="actfrdphone"><i class="fa fa-mobile prclr" aria-hidden="true"></i><?php echo $ref['mobile'];?></div>
                        <div class="actfrdphone"><i class="fa fa-mobile prclr" aria-hidden="true"></i><?php echo $ref['altmobile'];?></div>
                        <div class="actfrdphone"><i class="fa fa-envelope-o prclr" aria-hidden="true"></i><?php echo $ref['email'];?></div>
                        <div class="actfrdphone"><i class="fa fa-envelope-o prclr" aria-hidden="true"></i><?php echo $ref['altemail'];?></div>
                      </div>
                      <?php } ?>
                     
                      
                      <!-- *******************--> 
                      
                    </div>
                  </div>
                  
                  <!-- jQuery --> 
              
                </div>
           
              </div>
            </div>
          </div>
        </div>
        
       
        <div class="row">
          <div class="rowDetail">
            <div class="prntfction">
              <h2>Change password</h2>
              <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                       
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <div class="col-md-6">
                                    <form  class="form-horizontal Calendar" name="pass_form" id="pass_form" method="post" action="<?php echo base_url();?>Home/change_current_pass">
                                    <div class="col-md-8 col-sm-6 col-xs-12 form-group">
                                      
                                        
                                        <input type="password" placeholder="Current Password" name='old' ng-model="designation" id="old" class="form-control"><br>
                                        
                                        <input type="password" placeholder="New Password" name='new_pass' ng-model="designation" id="new_pass" class="form-control"><br>
                                        
                                        <input type="password" placeholder="Confirm Password" name='confirm_pass' ng-model="designation" id="confirm_pass" class="form-control"><br>
                                        
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <input type="submit" id="change" name="change" class="btn btn-primary antosubmit"></button>
                                    </div>
                                <form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>


            <script type="text/javascript">
             $("#change").click(function(e)
        {
           /// alert("dshgsh");
            e.preventDefault();

            var data= $("#pass_form").serializeArray();
            $.post('<?= base_url(); ?>/Home/change_current_pass',data,function(data)
            {
             if(data.status)
             {
              
                 noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                 

                 // window.location = '<?= base_url();?>admin/pooling/new_pool';

             }
                 else
             {
                 noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
             }

            },'json');

        });

    </script>


            
            <!--*********************-->
            
           <!--  <div class="prntfction">
              <div class="rondcount2">2</div>
              <p>For over a decade <strong>ASI</strong> remained focused on delivering minute design solutions and high end interior projects. When it comes to professional and quality fit out we are unparalleled. </p>
            </div> -->
            
            <!--*********************-->
            
           <!--  <div class="prntfction">
              <div class="rondcount2">3</div>
              <p>For over a decade <strong>ASI</strong> remained focused on delivering minute design solutions and high end interior projects. When it comes to professional and quality fit out we are unparalleled. </p>
            </div> -->
            
            <!--*********************-->
            
            <!-- <div class="prntfction">
              <div class="rondcount2">12</div>
              <p>For over a decade <strong>ASI</strong> remained focused on delivering minute design solutions and high end interior projects. When it comes to professional and quality fit out we are unparalleled. </p>
            </div> -->
            
            <!--*********************--> 
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
</div>
<?php echo $footer; ?>
<style>

.prf{ height:40px; width:40px; background-color:#fff; border-radius:100%; margin:13px 5px;    float: right;}

</style>
<style type="text/css">
.thumb-image{float:left;width:100px;position:relative;padding:5px;}
</style>
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog"> 
  
  <!-- Modal content-->
  <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"> X </button>
    <h4 class="modal-title">EDIT PROFILE</h4>
  </div>
  <form method="post" name="profile_form" id="profile_form" action="<?php echo base_url();?>Home/edit_normal_byid/<?php echo $user['id'];?>">
    <div class="modal-body">
      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
        <input type="text" value="<?php echo  $user['name']; ?>"  placeholder="Name"   name="name"  class="form-control validate[required]" >
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
        <input type="text" value="<?php echo  $user['address']; ?>"  placeholder="Address"   name="address"  class="form-control validate[required]" >
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
        <input type="text" value="<?php echo  $user['phone']; ?>"  placeholder="Mobile"   name="phone"  class="form-control validate[required]" >
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
        <input type="text" value="<?php echo  $user['phone2']; ?>"  placeholder="Alternate Mobile"   name="phone2"  class="form-control validate[required]" >
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <input type="text" value="<?php echo  $user['email']; ?>"  placeholder="Name"   name="email"  class="form-control validate[required]" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="" id="">Update</button>
      </div>
    </div>
    </div>
  </form>
</div>
<script type="text/javascript">
        $(document).ready(function() {


            // bind form using ajaxForm
            $('#profile_form').ajaxForm({

                // dataType identifies the expected content type of the server response
                dataType:  'json',

                // success identifies the function to invoke when the server response
                // has been received
                success:   function(data){

                    if(data.status){

                        noty({text: 'Updated profile', type: 'success', timeout: 1000 });
                        window.location = "<?php echo base_url();?>Home/profile";
                    } else {
                        noty({text: data.reason, type: 'error', timeout: 1000 });
                    }

                }
            });
           
        });
      

    </script> 


<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script> 
<script src="<?php echo base_url(); ?>assets/public/js/easyResponsiveTabs.js"></script> 
<script>
  $('#sub').easyResponsiveTabs({
    type: 'vertical'
  });
</script> 
<script>
$(document).ready(function() {
        $("#fileUpload").on('change', function() {
          //Get count of selected files
          var countFiles = $(this)[0].files.length;
          var imgPath = $(this)[0].value;
          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
          var image_holder = $("#image-holder");
          image_holder.empty();
          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
              //loop for each file selected for uploaded.
              for (var i = 0; i < countFiles; i++) 
              {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image"
                  }).appendTo(image_holder);
                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[i]);
              }
            } else {
              alert("This browser does not support FileReader.");
            }
          } else {
            alert("Pls select only images");
          }
        });
      });
</script>

</body>
</html>
