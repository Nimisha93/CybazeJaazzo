  <?php echo $header; ?>
    <?php echo $map['js']; ?>
  <script type="text/javascript">
    function getPosition(newLat, newLng)
    {
      $('#lat').val(newLat);
      $('#long').val(newLng);
    }
  </script>
  <style type="text/css">
      .subc{margin-left: 31px;}


label.error {
    color: red;
    position: absolute;
    top: 60px;
    left: 0;
}

.main label.error
{
        top: 35px;
    text-transform: capitalize;
}


.main2 label.error {
    color: red;
    position: absolute;
    top: 60px;
    left: 0;
}

  </style>
<body>
<div class="wrapper">

   <?php echo $sidebar; ?>

    <div class="content">
        <div class="container-fluid">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title">Channel Partner Details</h4>

                    </div>
                    <div class="card-content">

                        <!-- <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>admin/executives/update_channel_partner_id" enctype="multipart/form-data"> -->
                        <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>admin/executives/update_cp_details" enctype="multipart/form-data">
                            <div class="col-md-12 col-sm-6 ">
                                <div class="form-group label-floating is-empty main">
                                <input type="hidden" name="hiddenid" class="form-control" value="<?php echo $partner['partner']['id'];?>" readonly="">
                                  <label>Club Member</label>

                                   <select name="club_member" class="form-control search-box-open-up search-box club_member" id="module" data-rule-required="true">
                                         <option value="">Please Select Club Member</option>
                                            <?php foreach ($member['member'] as $type) { ?>
                                            <option  <?php echo $partner['partner']['club_mem_id'] == $type['m_id'] ? 'selected' : '';?> value="<?php echo $type['m_id'];?>"><?php echo $type['name'];?></option>
                                            <?php } ?>
                                            </select>          
                                    </select>

                                </div>

                            <div class="channel" >
                            <div class="col-md-4 main">
                                
                                <div class="form-group">
                                  <label>Club Type</label>
                                  <select name="club_type" class="form-control club_type" id="club_type" data-rule-required="true">
                                  <option value="">Please Select Club Type</option>
                                  <option <?php echo $cl_type['club'] == $partner['partner']['club_type'] ? "selected" : '';?>  value="<?php echo $cl_type['club'];?>"><?php echo $cl_type['club'];?></option>
                                  <option  <?php echo $cl_type['fixed'] == $partner['partner']['club_type'] ? "selected" : '';?> value="<?php echo $cl_type['fixed'];?>"><?php echo $cl_type['fixed'];?></option>
                                   
                                  
                                  </select>
                                </div>
                              </div>





                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                <!--     <label class="control-label">Module</label> -->
                                <label>Service</label>
                                   <select name="module" class="form-control search-box-open-up search-box club_member" data-rule-required="true">
                                         <option value="">Please Select Module</option>
                                            <?php foreach ($modules['type'] as $type) { ?>
                                            <option <?= $partner['partner']['module']==$type['id'] ? "selected" : "" ; ?> value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
                                            <?php } ?>
                                            </select>          
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                         <!--   <label class="control-label">&nbsp;</label> 
 --><label>Type</label><?php $cat = $partner['grp_sel'];$typ=array();
                                foreach($category['type'] as $type){ $pid=$type['id'];
                                foreach($subcategory['type'] as $stype){ 
                                if($stype['parent']==$pid){ $stype_id = $stype['id'];
                                if(in_array($stype_id, $cat)){ array_push($typ,$stype['title']); } }  } } ?>
                                <textarea class="form-control">
                                <?php  foreach($typ as $typee){
                                    echo $typee.'&#13;&#10';
                                 } ?>
                                </textarea>
                                            <!-- <select id="channel_type" data-rule-required="true" class="testSelAll form-control  search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" onchange="console.log($(this).children
                                    (':selected')
                                    .length)">
                                    <optionb value="">Select Channel Partner Type</option>
                                    <?php
                                      $cat = $partner['grp_sel'];
                                     foreach($category['type'] as $type){ ?> 
                                    <optgroup label="<?php echo $type['title'];?>">
                                    <?php $pid=$type['id']; 
                                    foreach($subcategory['type'] as $stype){ if($stype['parent']==$pid){
                                       $stype_id = $stype['id'];
                                          if(in_array($stype_id, $cat)){
                                             $selcted = 'selected = "selected"';
                                          }else{
                                             $selcted = '';
                                          }
                                     ?>

                            <option <?= $selcted; ?> class="subc" value="<?php echo $stype['id'];?>"><?php echo $stype['title'];?></option>
                            
                                            
                                            <?php } ?>
                                            </optgroup>
                                            <?php } } ?>
                                            </select> -->
                                        </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label>Name of the Organization </label>
                                    <input type="text" name="name" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['name'];?>">
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Email</label>
                                    <input type="text" name="email" class="form-control" value="<?php echo $partner['partner']['email'];?>" readonly="">
                                    <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Contact Number</label>
                                    <input type="number" name="phone" id="phone" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['phone'];?>">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Owner Name</label>
                                    <input type="text" name="ocname" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['owner_name'];?>">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Owner Email</label>
                                    <input type="text" name="oc_email" class="form-control" value="<?php echo $partner['partner']['owner_email'];?>">
                                    <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12 ">
                             <div class="form-group label-floating is-empty">
                                    <label>Owner Contact Number</label>
                                            <input type="number" name="oc_mobile" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['owner_mobile'];?>">
                                            <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                        </div>
                                        </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >&nbsp;</label>
                                    <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country" data-rule-required="true">
                                       <option value="">Please Select</option>
                                        <?php foreach ($countries as $key => $country) { ?>
                                        <option <?= $partner['partner']['country'] == $country['id'] ? "selected" : "" ; ?> value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                        <?php } ?>
                                            </select>
                                </div>
                            </div>


                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                   <label >&nbsp;</label>
                                     <select name="state" class=" form-control sel_state select_box_sel" id="states" data-rule-required="true">
                                        <option value="">Please Select</option>
                                        <?php foreach ($states as $st) { ?>
                                        <option <?= $partner['partner']['state'] == $st['id'] ? "selected" : "" ; ?> value="<?php echo $st['id'];?>"><?php echo $st['name'];?></option>
                                         <?php } ?>                                        
                                            </select>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                   <label >&nbsp;</label>
                                            <select name="town" id="city" class="form-control">
                                             <option value="">Please Select</option>
                                             <?php foreach ($cities as $st) { ?>
                                        <option <?= $partner['partner']['town'] == $st['id'] ? "selected" : "" ; ?> value="<?php echo $st['id'];?>"><?php echo $st['name'];?></option>
                                         <?php } ?>  
                                            </select>
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label>PAN Number</label>
                                    <input type="text" name="pan" class="form-control" data-rule-required="true" id="pan" value="<?php echo $partner['partner']['pan'];?>">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label>GST Number</label>
                                    <input type="text" name="gst" class="form-control" id="gst" data-rule-required="true" value="<?php echo $partner['partner']['gst'];?>">
                                    <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                </div>
                            </div>
                            <?php if($partner['partner']['company_registration']){ ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Company Registration Document</label>
                               <?php
                                $keywords = explode('cp_docs/', $partner['partner']['company_registration']);
                                $ext = pathinfo($keywords[1], PATHINFO_EXTENSION);
                                    if($ext=='docx'){
                                ?>
                                        <iframe class="doc" src="http://docs.google.com/gview?url=<?php echo base_url().$partner['partner']['company_registration']?>&embedded=true" style="width:60%" data-title="docs"></iframe>
                                <?php
                                    }else if($ext=='pdf'|| $ext=='jpg'|| $ext=='png'|| $ext=='jpeg' ){
                                ?>
                                        <a href="<?php echo base_url().$partner['partner']['company_registration']?>"><i class="btn btn-sm btn-primary fa fa-file" target="_blank" data-title="pdf"></i><?= $keywords[1] ?></a>
                                <?php
                                    }else{
                                        echo "No Docs";
                                    }
                                ?>
                            </div>
                            <?php } ?>
                            <?php if($partner['partner']['license']){ ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Corporation/Panchayath/Muncipality License</label>
                               <?php
                                $keywords1 = explode('cp_docs/', $partner['partner']['license']);
                                
                                $ext1 = pathinfo($keywords1[1], PATHINFO_EXTENSION);
                                    if($ext1=='docx'){
                                ?>
                                        <iframe class="doc" src="http://docs.google.com/gview?url=<?php echo base_url().$partner['partner']['license']?>&embedded=true" style="width:60%" data-title="docs"></iframe>

                                        <br>
                                        
                                <?php
                                    }else if($ext1=='pdf'|| $ext1=='jpg'|| $ext1=='png'|| $ext1=='jpeg'){
                                ?>
                                        <a href="<?php echo base_url().$partner['partner']['license']?>"><i class="btn btn-sm btn-primary fa fa-file" target="_blank" data-title="pdf"></i><?= $keywords1[1] ?></a>

                                        <br>
                                      
                                <?php
                                    }else{
                                        echo "No Docs";
                                    }
                                ?>
                            </div>
                            <?php } ?>
                            <div class="col-md-12">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group label-floating is-empty">
                                        <label >Latitude*</label>
                                        <input type="text" data-rule-required="true" placeholder="Latitude" id="lat" name="latt" class="form-control " value="<?php echo $partner['partner']['lattitude'];?>">
                                        <span class="material-input"></span><span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group label-floating is-empty">
                                        <label >Longitude*</label>
                                         <input type="text" data-rule-required="true" placeholder="Longitude" id="long" name="long" class="form-control" value="<?php echo $partner['partner']['longitude'];?>" >
                                        <span class="material-input"></span><span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin-top: 25px;">
                                   <?php echo $map['html']; ?>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
</div>
</div>
<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/admin/sumo-select/sumoex.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/admin/js/sumoslct.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script type="text/javascript">
    $("#channel_form :input").prop("disabled", true);
    // $('#states').SumoSelect();
    // $('#city').SumoSelect();
    // $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
</script>
</body>

</html>