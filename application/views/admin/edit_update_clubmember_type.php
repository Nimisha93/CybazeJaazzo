<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
<script type="text/javascript">
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
  }
</script>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Update Club Member Type<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="">
                            <form method="post" name="Club_member_type" id="Club_member_type" action="<?php echo base_url();?>admin/Clubmember/update_club_member_type/<?= $details['id'];?>">
                                <div class="">
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <input type="hidden" name="id" value="<?= $details['id'];?>">
                                        <label>Club Name</label>
                                        <input type="text" placeholder="Club Name" name="clubname" id="clubname" class="form-control" value="<?= $details['title'];?>" data-rule-required="true" data-msg-required="Please enter club name field.">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Amount</label>
                                        <input type="number"  onKeyPress="return isNumberKey(event)" placeholder="Amount" name="amount" id="amount" value="<?= $details['amount'];?>" class="form-control" data-rule-required="true"  data-msg-required="Please enter amount field.">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>No of Years<!-- 1 Year Usage Limit --></label>
                                        <input type="number"  onKeyPress="return isNumberKey(event)" name="ussage_limit" id="ussage_limit" placeholder="No of Years" class="form-control" value="<?= $details['cash_limit'];?>" data-rule-required="true"  data-msg-required="Please enter no of years field.">
                                    </div>
                                </div>
                                <div class="">
                                    <div class="col-md-8 col-sm-8 col-xs-12 form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" title="Description" name="description" id="description" rows="4" placeholder="Description" class="form-control" data-rule-required="true"  data-msg-required="Please enter description field."><?= $details['description'];?></textarea>
                                    </div>
                                </div>
                                <?php
                                $chk1 = ($details['type']==='FIXED')?"checked":"";
                                $chk2 = ($details['type']==='UNLIMITED')?"checked":"";
                                $chk3 = ($details['type']==='INVESTOR')?"checked":"";

                                ?>
                                <div class="">
                                    <div class="col-md-12 col-sm-4 col-xs-12 form-group">
                                        <label>Type</label><br />
                                        <div style="margin-top: 10px">
                                            <label><input name="type" type="radio" class="type" value="FIXED" <?= $chk1; ?>>&nbsp;Fixed </label>
                                           <label> <input name="type" type="radio" class="type" value="UNLIMITED" <?= $chk2; ?>>&nbsp;Unlimited </label>
                                           <label> <input name="type" type="radio" class="type" value="INVESTOR" <?= $chk3; ?>>&nbsp;Team Lead Club  </label>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6 col-sm-6 col-xs-12 form-group benefit bde_benfit">
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>BDE Benefit</label><br />
                                        </div>
                                        <div class="col-md-9 col-sm-6 col-xs-12 form-group">
                                            <input type="number" name="bde_benfit" class="form-control"  onKeyPress="return isNumberKey(event)">
                                        </div>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group tl_benefit">
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>TL Benefit</label><br />
                                        </div>
                                        <div class="col-md-9 col-sm-6 col-xs-12 form-group">
                                            <input type="number" name="tl_benfit" class="form-control" value="<?php echo $details['tl_benefit'];?>" onKeyPress="return isNumberKey(event)">
                                        </div>
                                    </div>
                                </div>
                                <?php
                                   $cp_status= ($details['cp_status']==1)?"checked=checked":"";
                                ?>
                                <div class="">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group cp">
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Add Channel Partner Facility</label><br />
                                            <input name="channel_partner_fecility" type="checkbox" class="channel_partner_fecility" <?php echo $cp_status; ?>>
                                        </div>
                                        <div class="col-md-9 col-sm-6 col-xs-12 form-group cp_limit">
                                            <label>Channel Partner Limit</label><br />
                                            <input type="number" name="cp_limit" class="form-control" value="<?php echo $details['cp_limit']; ?>"  onKeyPress="return isNumberKey(event)">
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group reward_per_cp">
                                            <label>Reward Per Channel Partner </label><br />
                                            <input type="number" name="reward_per_cp" class="form-control" value="<?php echo $details['reward_per_cp']; ?>" onKeyPress="return isNumberKey(event)">
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group bde_benfit">
                                       
                                            <label>BDE Benefit</label><br />                  
                                            <input type="number" name="bde_benfit" class="form-control" value="<?php echo $details['bde_benefit']; ?>"  onKeyPress="return isNumberKey(event)">
                                       
                                    </div>
                                    </div>
                                    <?php
                                       $ref_cp_status= ($details['ref_cp_status']==1)?"checked=checked":"";
                                    ?>
                                    <!-- CLASS=ref_cp -->
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group ">
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group ref_cp_fecility">
                                            <label>Refer Channel Partner Facility</label><br />
                                            <input name="ref_channel_partner_fecility" type="checkbox" class="ref_channel_partner_fecility" <?php echo $ref_cp_status;?>>
                                        </div>
                                        <div class="col-md-9 col-sm-6 col-xs-12 form-group ref_cp_limit">
                                            <label>Refer Channel Partner Limit</label><br />
                                            <input type="number" name="ref_cp_limit" class="form-control"  onKeyPress="return isNumberKey(event)" value="<?php echo $details['ref_cp_limit']; ?>">
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group reward_per_ref_cp">
                                            <label>Reward Per Refer Channel Partner </label><br />
                                            <input type="number" name="ref_reward_per_cp" class="form-control"  onKeyPress="return isNumberKey(event)" value="<?php echo $details['ref_reward_per_cp']; ?>">
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group ref_cp_bde_benefit">
                                            <label>Refer BDE Benefit</label><br />
                                            <input type="number" name="ref_cp_bde_benefit" value="<?php echo $details['ref_bde_benefit']; ?>" class="form-control"  onKeyPress="return isNumberKey(event)">
                                        </div>
                                    </div>
                                    <?php
                                       $ca_status= ($details['club_agent_status']==1)?"checked=checked":"";
                                    ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group ca">
                                        <style>
                                            .toggle.android { border-radius: 0px;}
                                            .toggle.android .toggle-handle { border-radius: 0px; }
                                        </style>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Add Club Agent Facility</label><br />
                                            <input name="club_agent_fecility" type="checkbox" class="club_agent_fecility" <?= $ca_status;?>>
                                        </div>
                                        <div class="col-md-9 col-sm-6 col-xs-12 form-group ca_limit">
                                            <label>Club Agent Limit</label><br />
                                            <input type="number" name="ca_limit" class="form-control" value="<?= $details['ca_limit']; ?>" onKeyPress="return isNumberKey(event)">
                                        </div>
                                    </div>   
                                    <?php $user_status = ($details['user_status']==1)?"checked=checked":"";?> 
                                    <div class="col-md-6 col-md-6 col-sm-6 col-xs-12 form-group users">
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Add Individual Friend Facility</label><br />
                                            <input name="user_fecility" type="checkbox" class="user_fecility" <?php echo $user_status; ?>>
                                        </div>
                                        <div class="col-md-9 col-sm-6 col-xs-12 form-group user_limit">
                                            <label>Individual Friends Limit</label><br />
                                            <input type="number" name="user_limit" class="form-control"  onKeyPress="return isNumberKey(event)" value="<?php echo $details['user_limit']; ?>">
                                        </div>
                                    </div>
                                    <?php $ba_status = ($details['ba_status']==1)?"checked=checked":""; ?> 
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group ba">
                                        <style>
                                            .toggle.android { border-radius: 0px;}
                                            .toggle.android .toggle-handle { border-radius: 0px; }
                                        </style>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Add Jaazzo Store Facility</label><br />
                                            <input name="ba_fecility" type="checkbox" class="ba_fecility" <?php echo $ba_status;?>>
                                        </div>
                                        <div class="col-md-9 col-sm-6 col-xs-12 form-group ba_limit">
                                            <label>Jaazzo Store Limit</label><br />
                                            <input type="number" name="ba_limit" class="form-control" value="<?php echo $details['ba_limit'];?>"  onKeyPress="return isNumberKey(event)">
                                        </div>
                                    </div>
                                    <?php $bde_status = ($details['bde_status']==1)?"checked=checked":""; ?>
                                    <div class="col-md-6 col-md-6 col-sm-6 col-xs-12 form-group bde">
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Add BDE Facility</label><br />
                                            <input name="bde_fecility" type="checkbox" class="bde_fecility" <?php echo $bde_status; ?>>
                                        </div>
                                        <div class="col-md-9 col-sm-6 col-xs-12 form-group bde_limit">
                                            <label>BDE Limit</label><br />
                                            <input type="number" name="bde_limit" class="form-control"  onKeyPress="return isNumberKey(event)" value="<?php echo $details['bde_limit']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <button type="submit" class="btn btn-primary channelsubmit" name="add_club_member" id="add_club_member">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="notifications"></div><input type="hidden" id="position" value="center">
        </div>
    </div>
</div>
<div class="clearfix"></div>
<!--************************row  end******************************************************************* -->
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ouelsr0cp0wd709qu42eo2a1fcw8iibuwekc5ntce4juh12z"></script>
<script>
    tinymce.init({
        selector: 'textarea',

        height: 80,
        theme: 'modern',
        file_browser_callback_types: 'file image media',
        automatic_uploads: true,
        images_upload_url: '',
        images_reuse_filename: true,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],

        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]

    });
</script>
</div>
<?php echo $footer; ?>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var type=$(document).find("input[name='type']:checked"). val();
        if(type==='FIXED'){
            if ($(document).find('[class="channel_partner_fecility"]').is(':checked')) {
                $(".cp_limit").show();
                $(".reward_per_cp").show();
                $(".bde_benfit").show();
            }else{
                $(".cp_limit").hide();
                $(".reward_per_cp").hide();
                $(".bde_benfit").hide();
            }
            if ($(document).find('[class="ref_channel_partner_fecility"]').is(':checked')) {
                $(".ref_cp_limit").show();
                $(".reward_per_ref_cp").show();
                $(".ref_cp_bde_benefit").show();
            }else{
                $(".ref_cp_limit").hide();
                $(".reward_per_ref_cp").hide();
                $(".ref_cp_bde_benefit").hide();
            }
          /*  $(".channel_partner_fecility").show();
            $(".cp_limit").show();
            $(".reward_per_cp").show();
            $(".ref_cp_fecility").show();
            $(".ref_channel_partner_fecility").show();
            $(".ref_cp_limit").show();
            $(".reward_per_ref_cp").show();
            $(".ref_cp_bde_benefit").show();
            $(".bde_benfit").show();*/
            $(".tl_benefit").hide();
            $(".bde").hide();
            // $(".bde_limit").hide();
            $(".ba").hide();
            // $(".ba_limit").hide();
            $(".ca").hide();
            // $(".ca_limit").hide();
            $(".users").hide();
            // $(".user_limit").hide();
        }else if(type==='INVESTOR'){
            if ($(document).find('[class="channel_partner_fecility"]').is(':checked')) {
                $(".cp_limit").show();
                $(".reward_per_cp").hide();
            }else{
                $(".cp_limit").hide();
                $(".reward_per_cp").hide();
            }
            /*$(".channel_partner_fecility").show();
            $(".cp_limit").show();
            $(".reward_per_cp").show();*/
            $(".ref_cp_fecility").hide();
            $(".ref_channel_partner_fecility").hide();
            $(".ref_cp_limit").hide();
            $(".reward_per_ref_cp").hide();
            $(".ref_cp_bde_benefit").hide();
            $(".bde_benfit").hide();
            $(".tl_benefit").hide();
            $(".bde").show();
            // $(".bde_limit").hide();
            $(".ba").show();
            // $(".ba_limit").hide();
            $(".ca").show();
            // $(".ca_limit").hide();
            $(".users").show();
            // $(".user_limit").hide();
        }else{
            if ($(document).find('[class="channel_partner_fecility"]').is(':checked')) {
                $(".cp_limit").show();
                $(".reward_per_cp").hide();
            }else{
                $(".cp_limit").hide();
                $(".reward_per_cp").hide();
            }
            /*$(".channel_partner_fecility").show();
            $(".cp_limit").show();
            $(".reward_per_cp").hide();*/
            $(".ref_channel_partner_fecility").hide();
            $(".ref_cp_fecility").hide();
            $(".ref_cp_limit").hide();
            $(".reward_per_ref_cp").hide();
            $(".ref_cp_bde_benefit").hide();
            $(".bde_benfit").show();
            $(".tl_benefit").show();
            $(".bde").hide();            
            // $(".bde_limit").hide();
            $(".ba").show();
            // $(".ba_limit").hide();
            $(".ca").show();
            // $(".ca_limit").hide();
            $(".users").show();
            // $(".user_limit").hide();
        }
        // if ($(document).find('[class="club_agent_fecility"]').is(':checked')) {
        //     $(".ca_limit").toggle( "slow");
        // }else{
        //     $(".ca_limit").hide();
        // }

        // if ($(document).find('[class="channel_partner_fecility"]').is(':checked')) {
        //     $(".cp_limit").toggle( "fast");
        //     $(".reward_per_cp").toggle( "slow");
        //     $(".bde_benfit").toggle("slow");
        // }else{
        //     $(".cp_limit").hide();
        //     $(".reward_per_cp").hide();
        //     $(".bde_benfit").hide();
        // }
        // if ($(document).find('[class="ref_channel_partner_fecility"]').is(':checked')) {
        //     $(".ref_cp_limit").toggle( "fast");
        //     $(".reward_per_ref_cp").toggle( "slow");
        //     $(".ref_cp_bde_benefit").toggle("slow");
        // }else{
        //     $(".ref_cp_limit").hide();
        //     $(".reward_per_ref_cp").hide();
        //     $(".ref_cp_bde_benefit").hide();
        // }

        // if ($(document).find('[class="user_fecility"]').is(':checked')) {
        //     $(".users").show();
        // }else{
        //     $(".users").hide();
        // }

        // if ($(document).find('[class="ba_fecility"]').is(':checked')) {
        //     $(".ba").show();
        // }else{
        //     $(".ba").hide();
        // }

        // if ($(document).find('[class="bde_fecility"]').is(':checked')) {
        //    $( ".bde" ).show();
        // }else{
        //     $(".bde" ).hide();
        // }
    });

    $('input:radio[name="type"]').change(
        function()
        {
            var type =$(this).val();
            if(type=='FIXED'){
                if ($(document).find('[class="channel_partner_fecility"]').is(':checked')) {
                    $(".cp_limit").show();
                    $(".reward_per_cp").show();
                    $(".bde_benfit").show();
                }else{
                    $(".channel_partner_fecility").show();
                    $(".cp_limit").hide();
                    $(".reward_per_cp").hide();
                    $(".bde_benfit").hide();
                }
                if ($(document).find('[class="ref_channel_partner_fecility"]').is(':checked')) {
                    $(".ref_cp_limit").show();
                    $(".reward_per_ref_cp").show();
                    $(".ref_cp_bde_benefit").show();
                }else{
                    $(".ref_channel_partner_fecility").show();
                    $(".ref_cp_fecility").show();
                    $(".ref_cp_limit").hide();
                    $(".reward_per_ref_cp").hide();
                    $(".ref_cp_bde_benefit").hide();
                }
                /*$(".channel_partner_fecility").show();
                $(".cp_limit").show();
                $(".reward_per_cp").show();
                $(".ref_cp_fecility").show();$(".ref_cp").show();
                $(".ref_channel_partner_fecility").show();
                $(".ref_cp_limit").show();
                $(".reward_per_ref_cp").show();
                $(".ref_cp_bde_benefit").show();
                $(".bde_benfit").show();*/
                $(".tl_benefit").hide();
                $(".bde").hide();
                // $(".bde_limit").hide();
                $(".ba").hide();
                // $(".ba_limit").hide();
                $(".ca").hide();
                // $(".ca_limit").hide();
                $(".users").hide();
                // $(".user_limit").hide();
            }else if(type=='INVESTOR'){
                /*$(".channel_partner_fecility").show();
                $(".cp_limit").show();
                $(".reward_per_cp").hide();
               */ 
                if ($(document).find('[class="channel_partner_fecility"]').is(':checked')) {
                    $(".cp_limit").show();
                    $(".reward_per_cp").hide();
                }else{
                    $(".channel_partner_fecility").show();
                    $(".cp_limit").hide();
                    $(".reward_per_cp").hide();
                }
                $(".ref_cp_fecility").hide();
                $(".ref_channel_partner_fecility").hide();
                $(".ref_cp_limit").hide();
                $(".reward_per_ref_cp").hide();
                $(".ref_cp_bde_benefit").hide();
                $(".bde_benfit").hide();
                $(".tl_benefit").hide();
                $(".bde").show();
                // $(".bde_limit").hide();
                $(".ba").show();
                // $(".ba_limit").hide();
                $(".ca").show();
                // $(".ca_limit").hide();
                $(".users").show();
                // $(".user_limit").hide();
            }else{
                if ($(document).find('[class="channel_partner_fecility"]').is(':checked')) {
                    $(".cp_limit").show();
                    $(".reward_per_cp").hide();
                }else{
                    $(".channel_partner_fecility").show();
                    $(".cp_limit").hide();
                    $(".reward_per_cp").hide();
                }
                /*$(".channel_partner_fecility").show();
                $(".cp_limit").show();
                $(".reward_per_cp").hide();*/
                $(".ref_cp_fecility").hide();
                $(".ref_channel_partner_fecility").hide();
                $(".ref_cp_limit").hide();
                $(".reward_per_ref_cp").hide();
                $(".ref_cp").hide();
                $(".ref_cp_bde_benefit").hide();
                $(".bde_benfit").show();
                $(".tl_benefit").show();
                $(".bde").hide();            
                // $(".bde_limit").hide();
                $(".ba").show();
                // $(".ba_limit").hide();
                $(".ca").show();
                // $(".ca_limit").hide();
                $(".users").show();
                // $(".user_limit").hide();
            }
        }
    );

    $('[name="club_agent_fecility"]').change(function()
      {
        if ($(this).is(':checked')) {
            $(".ca_limit").toggle( "slow");
        }else{
            $(".ca_limit").hide();
        }
      });
    $('[name="channel_partner_fecility"]').change(function()
    {
        /*if ($(this).is(':checked')) {
            $(".cp_limit").toggle( "fast");
            $(".reward_per_cp").toggle( "slow");
            $(".bde_benfit").toggle("slow");
        }else{
            $(".cp_limit").hide();
            $(".reward_per_cp").hide();
            $(".bde_benfit").hide();
        }*/
        if ($(this).is(':checked')) {
           $(".cp_limit").toggle( "fast");
           $(".bde_benfit").show();
           if($('input:radio[name="type"]:checked').val()=='UNLIMITED'){
                $(".reward_per_cp").hide();
            }else{
                $(".reward_per_cp").toggle( "slow");
            }
        }else{
            $(".cp_limit").hide();
            $(".reward_per_cp").hide();
            if($('input:radio[name="type"]:checked').val()=='UNLIMITED'){
                $(".bde_benfit").show();
            }else{
                $(".bde_benfit").hide();
            }
        }
    });
    $('[name="ref_channel_partner_fecility"]').change(function()
    {
        if ($(this).is(':checked')) {
            $(".ref_cp_limit").toggle( "fast");
            $(".reward_per_ref_cp").toggle( "slow");
            $(".ref_cp_bde_benefit").toggle("slow");
        }else{
            $(".ref_cp_limit").hide();
            $(".reward_per_ref_cp").hide();
            $(".ref_cp_bde_benefit").hide();
        }
    });
      
    $('[name="user_fecility"]').change(function()
    {
        if ($(this).is(':checked')) {
            $(".user_limit").show();//.toggle( "slow");
        }else{
            $(".user_limit").hide();
        }
    });
    $('[name="ba_fecility"]').change(function()
    {
        if ($(this).is(':checked')) {
            $(".ba_limit").show();//.toggle( "slow");
        }else{
            $(".ba_limit").hide();
        }
    });
    $('[name="bde_fecility"]').change(function()
    {
        if ($(this).is(':checked')) {
            $(".bde_limit").show();///.toggle( "slow");
        }else{
            $(".bde_limit").hide();
        }
    });

</script>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3, captionFormatAllSelected: "Yeah, OK, so everything." });
        window.test = $('.testsel').SumoSelect({okCancelInMulti:true, captionFormatAllSelected: "Yeah, OK, so everything." });
        window.testSelAll = $('.testSelAll').SumoSelect({okCancelInMulti:true, selectAll:true });
        window.testSelAlld = $('.SlectBox-grp').SumoSelect({okCancelInMulti:true, selectAll:true });

        window.testSelAll2 = $('.testSelAll2').SumoSelect({selectAll:true });


        window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.' });
        window.searchSelAll = $('.search-box-sel-all').SumoSelect({ csvDispCount: 3, selectAll:true, search: true, searchText:'Enter here.', okCancelInMulti:true });
        window.searchSelAll = $('.search-box-open-up').SumoSelect({ csvDispCount: 3, selectAll:true, search: false, searchText:'Enter here.', up:true });

        window.groups_eg_g = $('.groups_eg_g').SumoSelect({selectAll:true, search:true });
    });
    $(document).ready(function()
    {
        //add club member type
        var v = $("#Club_member_type").validate({
            submitHandler: function(datas) {
            $('.body_blur').show();
            tinyMCE.triggerSave();
                $(datas).ajaxSubmit({
                    dataType : "json",
                    success  :    function(data)
                    {
                        $('.body_blur').hide();
                        if(data.status)
                        {
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully updated club member type </div></div>';
                            var effect='zoomIn';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                        }
                        else
                        {
                            var regex = /(<([^>]+)>)/ig;
                            var body = data.reason;
                            var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });
                        }
                    }
                });
            }
        });
    });
</script>
