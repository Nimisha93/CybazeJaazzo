<?= $default_assets;?>
<style type="text/css">
    .req{
        font-size: x-large;
        color: red;
    }
    .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #ccc;z-index: 17;    background-color: #000;}

    @media (max-width:1030px){

        .goToTop{height:auto;position:relative;}


    }
    @media (max-width:767px){

        .goToTop {
            position: static;
            top: 0;
            left: 0;
            z-index: 10;
            background-color: #1a4794;z-index: 17;
        }
    }
    
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    .plan li{
        display: inline-flex;
        padding: 4px;
    }
</style>
</head>
<body>
<!--===========header end here ========================-->
<?= $header;?>
<header>
    <div class="container-fluid" >
    </div>
    </div>
    </div>
    </div>
</header>
<!--===========header end here ========================-->
<div class="clear"></div>
</div>

<div class="slidbg_clubmbr">
    <div class="clbmnmberadd">
        <div id="slctpackage" class="">
            <?php
            $session_array1 = $this->session->userdata('logged_in_user');
            $session_array2 = $this->session->userdata('logged_in_club_member');
            if($session_array1){ ?>
                <form id="club_registration" action="<?= base_url();?>register/be_club_member" method="POST">
                    <h3>Be a Club Member</h3>
                    <label>Type</label>
                    <input name="type" type="checkbox" class="type"  value="UNLIMITED">&nbsp;Unlimited
                    <!-- <input name="type" type="checkbox" class="type" value="FIXED">&nbsp;Fixed                     -->
                    <br><br>
                    <ul class="plan">

                    </ul>
                    <div class="login_ckbx">
                        <input type="checkbox" name="agree" id="clbmembrshp2">
                        <label for="clbmembrshp2"><span class="checkbox">I Agree to the <a href="<?= base_url();?>Term_condition" target="_blank">T &amp; C</a></span></label>
                    </div>
                    <button type="submit" class="clu_sbmit club_submit">Submit</button>
                </form>
            <?php } else{ ?>
                <form id="become_club" action="<?= base_url();?>register/upgrade_clubmembership" method="post">
                    <h3 class="text-left bm_mar10">Select a Package & Upgrade Club Membership </h3>
                    <!--<div class="underline2"></div>-->
                    <label>Type</label>
                    <input name="ctype" type="checkbox" class="type"  value="UNLIMITED" <?php $ctype = isset($ctype)?$ctype:'';
                    echo ($ctype=='UNLIMITED')?'checked':''?>>&nbsp;Unlimited
                    <!-- <input name="ctype" type="checkbox" class="type" value="FIXED" <?php echo ($ctype=='FIXED')?'checked':(($session_array2['fixed_club_type_id']!=0)?'checked':'');?>>&nbsp;Fixed   -->                  
                    <br><br>
                    <input type="hidden" name="cplan" id="cplan" value="<?php echo $session_array2['club_type_id'];?>">
                    <input type="hidden" name="fixed_plan" id="fixed_plan" value="<?php echo $session_array2['fixed_club_type_id'];?>">
                    <ul class="cplan">
                        <?php 
                        if($session_array2['club_type_id']!=0){
                            echo "<div>Unlimited</div>";
                            $cur_pakage = $ctype_data['amount'];
                                foreach ($club_types as $key => $club) { 
                                    if($club['amount']>=$cur_pakage){
                        ?>
                        <li class="lst1">
                            <input type="radio"  value="<?php echo $club['id'];?>" <?php echo ($session_array2['club_type_id']==$club['id'])?'checked':''?> name="club_plan"><a href="#<?php echo strtolower($club['title']);?>">
                            <label for="f-option"><?php echo ucwords($club['title']);?><span class="slvr">( <span class="rupee">RS</span> <?php echo $club['amount'];?> )</span></label>
                            <div class="check">
                                <div class="inside"></div>
                            </div> </a>
                        </li>
                        <?php 
                                    }
                                }
                        } 
                        ?>
                    </ul>

                    <button type="submit" class="clu_sbmit club_pay_now">Pay Now</button>
                </form>
            <?php } ?>
        </div>
    </div>
</div>
<!--===========main end here ========================-->
<main class="bgclr6">
<section>
    <div class="bgclr3">
        <div class="container clubwraper  cr" style="border-top:none">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="carousel fdi-Carousel slide" id="myCarousel">
              <div class="carousel fdi-Carousel slide" id="eventCarousel" data-interval="0">
                    <div class="carousel-inner onebyone-carosel">
                        <?php  foreach($ul_club_types as $key=>$typ){?>
                        <div class="item <?php echo($key==0)?'active':''?> ">
                           <div class="pckge_clbmbr_sub">    
                                    <div class="clbmbrimgbx">
                                        <img src="<?php echo base_url();?>assets/public/images/bronze.png">
                                    </div>
                                    <h3><?php echo $typ['title'];?></h3>
                                    <a data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#<?php echo strtolower($typ['title']);?>"><?php echo implode(' ', array_slice(explode(' ',htmlspecialchars_decode(stripslashes($typ['description']))), 0, 50)).'...';?> </a>
                            </div>
                        </div>
                        <?php } ?>

                                <!-- <div class="item  ">
                                    <div class="pckge_clbmbr_sub">
                                    <div class="clbmbrimgbx">
                                        <img src="<?php echo base_url();?>assets/public/images/silver.png">
                                    </div>
                                    <h3>silver</h3>
                                    <a data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#silver">Below  RS 8000 psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso,  </a>
                                </div> </div>

                               <div class="item ">
                                <div class="pckge_clbmbr_sub">
                                    <div class="clbmbrimgbx">
                                        <img src="<?php echo base_url();?>assets/public/images/gold.png">
                                    </div>
                                    <h3>Gold</h3>
                                    <a data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#gold">Below  RS 8000 psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso,  </a>
                               </div> </div>

                                <div class="item  ">
                                    <div class="pckge_clbmbr_sub">
                                    <div class="clbmbrimgbx">
                                        <img src="<?php echo base_url();?>assets/public/images/platnm.png">
                                    </div>
                                    <h3>Platinum</h3>
                                    <a data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#platinum">Below  RS 8000 psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso,  </a>
                                </div> </div> -->
                            </ul>
                        </div>
                      
                        </div>
                    </div>
                    <ul class="control-box pager">
                        <li><a data-slide="prev" href="#myCarousel" class="" style="height: 35px;"><i class="glyphicon glyphicon-chevron-left"></i></a></li>
                        <li><a data-slide="next" href="#myCarousel" class=""  style="height: 35px;"><i class="glyphicon glyphicon-chevron-right"></i></a></li>
                    </ul>
                </div> 
            </div> 

        <div class="clear"></div>
        <div class="clbline"></div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#myCarousel').carousel({
                    interval: 10000,
                    
                })
                $('.fdi-Carousel .item').each(function () {
                    var next = $(this).next();
                    if (!next.length) {
                        next = $(this).siblings(':first');
                    }
                    next.children(':first-child').clone().appendTo($(this));

                    if (next.next().length > 0) {
                        next.next().children(':first-child').clone().appendTo($(this));
                    }
                    else {
                        $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
                    }
                });
            });
        </script>

        <style type="text/css">
            .carousel-inner.onebyone-carosel { margin: auto; width: 100%; }
            .onebyone-carosel .active.left { left: -25%; }
            .onebyone-carosel .active.right { left: 25%; }
            .onebyone-carosel .next { left: 25%; }
            .onebyone-carosel .prev { left: -25%; }

        /* Carousel Control */
        .control-box {
            text-align: right;
            width: 100%;
            height: 50px;
        }
        .carousel-control{
            background: #666;
            border: 0px;
            border-radius: 0px;
            display: inline-block;
            font-size: 34px;
            font-weight: 200;
            line-height: 18px;
            opacity: 0.5;
            padding: 4px 10px 0px;
            position: static;
            height: 30px;
            width: 15px;
        }
        .cr .nav{display: block;}

        </style>


        <div class="container">

            <div class="col-md-12 col-sm-12 col-xs-12 tp_mar20">
                <?php  foreach($ul_club_types as $key=>$typ){?>
                <div class="col-md-6 tp_mar20" id="<?php echo strtolower($typ['title']);?>">

                    <h3 class="clbpackghd"><?php echo $key+1;?>, <?php echo $typ['title'];?> ( RS.<?php echo $typ['amount'];?> )</h3>
                    <?php echo htmlspecialchars_decode($typ['description']);?>
                </div>
                <?php } ?>
                <!-- <div class="col-md-6 tp_mar20" id="silver">

                    <h3 class="clbpackghd">2, Silver ( RS.8000 )</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
                    </p>
                    <ul class="pcg">
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>it amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>

                        <li>ipiscing elit. Estne, quaeso, inquam</li>
                    </ul>
                </div>


                <div class="clear"></div>


                <div class="col-md-6 tp_mar20" id="gold">

                    <h3 class="clbpackghd">3, Gold ( RS.15000  )</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
                    </p>
                    <ul class="pcg">
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>it amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>

                        <li>ipiscing elit. Estne, quaeso, inquam</li>
                    </ul>
                </div>

                <div class="col-md-6 tp_mar20" id="platinum">

                    <h3 class="clbpackghd">4, Platinum ( RS.25000 )</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
                    </p>
                    <ul class="pcg">
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>it amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>

                        <li>ipiscing elit. Estne, quaeso, inquam</li>
                    </ul>
                </div> -->
            </div>
        </div>
    </div>
    </div>
</section>
<div class="clear"></div>


<!--<section>
<div class="container tp_mar50 bm_mar50 bgpackage botm_pad40">
<h1 class="tp_mar20 text-center text-uppercase">Packages</h1>
<div class="col-md-12">

<div id="silver" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tp_mar30 ">
<div class="bgsilver">
<h2 class="text-left bgsilver_sub1 text-center">Silver</h2>
<h3 class="text-left bgsilver_sub2 text-center"><span class="rupee"> RS </span>1000 </h3>
<div class="su_box90_marauoto">

<p class="tp_mar20">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
</p>

<a class="morspcfcn" data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#slctpackage">
<div class="select_pkg bgsilver_sub2">Select a Package</div></a>

</div>
</div></div>




<div id="gold" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tp_mar30 ">
<div class="bggold">
<h2 class="text-left bggold_sub1 text-center">Gold</h2>
<h3 class="text-left bggold_sub2 text-center"><span class="rupee"> RS </span>1000 - <span class="rupee"> RS </span>100000 </h3>
<div class="su_box90_marauoto">

<p class="tp_mar20">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
</p>

 <a class="morspcfcn" data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#slctpackage">
 <div class="select_pkg select_pkg bggold_sub2">Select a Package</div></a>

</div>
</div></div>




<div id="platinum" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tp_mar30 ">
<div class="bgplatinum">
<h2 class="text-left platinum_sub1 text-center">Platinum</h2>
<h3 class="text-left platinum_sub2 text-center">Abve<span class="rupee"> RS </span>10000 </h3>
<div class="su_box90_marauoto">

<p class="tp_mar20">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
</p>

<a class="morspcfcn" data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#slctpackage"><div class="select_pkg platinum_sub2">Select a Package</div></a>
</div>
</div></div>

</div>
</div>

</section>-->


<!--===========section end here ========================-->
<div class="clear"></div>

</main>
<?php echo $footer; ?>

<script type="text/javascript">
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        $('input[name="type"]').click(function(){
            new_obj = {}
            $('input[name="type"]:checked').each(function(i,j) {
                if(this.value=='FIXED'){
                    new_obj[this.name+'2'] = this.value;  
                }else{
                    new_obj[this.name+(i+1)] = this.value;  
                }  
            });

            $(".plan").html('');
            $.post('<?php echo base_url();?>get_club_plans_by_type',new_obj, function(data){
                if(data.status){
                    $(".plan").append(data.data);$(".plan").show();
                }else{
                    swal("Warning!", "Please try to select a type", "error");
                }
            },'json');
        });
        $('input[name="ctype"]').click(function(){
            new_obj = {}
            $('input[name="ctype"]:checked').each(function(i,j) {
                if(this.value=='FIXED'){
                    new_obj['type2'] = this.value;  
                }else{
                    new_obj['type'+(i+1)] = this.value;  
                }  
            });

            $(".cplan").html('');
            var cplan = $('#cplan').val();
            var fixed_plan = $('#fixed_plan').val();
            $.post('<?php echo base_url();?>get_club_plans_by_type',new_obj, function(data){

                if(data.status){
                    $(".cplan").append(data.data);$(".cplan").show();
                    $('input[name="club_plan"][value="' + cplan.toString() + '"]').prop("checked", true);
                    $('input[name="club_plan2"][value="' + fixed_plan.toString() + '"]').prop("checked", true);
                }else{
                    swal("Warning!", "Please try to select a type", "error");
                }
            },'json');
        });
        /* $('input:radio[name="type"]').change(
            function(){
                if ($(this).val() == 'FIXED') {
                    var type='FIXED';
                }else {
                    var type='UNLIMITED';
                }
                $(".plan").html('');
                $.post('<?php echo base_url();?>get_club_plans_by_type',{type:type}, function(data){
                    console.log(data);
                    if(data.status){
                        $(".plan").append(data.data);$(".plan").show();
                    }else{
                        
                    }
                },'json');
            });
        
        $('input:radio[name="ctype"]').change(
            function(){
                if ($(this).val() == 'FIXED') {
                    var type='FIXED';
                }else {
                    var type='UNLIMITED';
                }
                $(".cplan").html('');
                $.post('<?php echo base_url();?>get_club_plans_by_type',{type:type}, function(data){
                    console.log(data);
                    if(data.status){
                        $(".cplan").append(data.data);$(".cplan").show();
                        var value = <?php echo isset($session_array2['club_type_id'])?$session_array2['club_type_id']:'0';?>;
                        if(value!='0'){$('input:radio[name="club_plan"][value="' + value + '"]').attr('checked', 'checked');}
                    }else{
                        
                    }
                },'json');
            });*/
    });
</script>

<script src="<?= base_url();?>assets/public/js/smooth-scroll.js"></script>
<script>
    smoothScroll.init();

</script>
<!--=======================================slider right==============================================-->




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