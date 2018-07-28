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
                        <h4 class="card-title">Edit Channel Partner </h4>

                    </div>
                    <div class="card-content">

                        <!-- <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>admin/executives/update_channel_partner_id" enctype="multipart/form-data"> -->
                        <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>admin/executives/update_cp_details" enctype="multipart/form-data">
                            <div class="col-md-12 col-sm-6 ">
                               <!-- <div class="form-group label-floating is-empty main">-->
                               
                                <div class="form-group">
                                    
                                <!--     <label class="control-label">Module</label> -->
                                
                                <label class="">Club Member </label>  <label style="color:red;">(Mandatory)</label>
                                
                                
                                
                                
                                <input type="hidden" name="hiddenid" class="form-control" value="<?php echo $partner['partner']['id'];?>" readonly="">
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
                                    
                                    
                                    <label class="">Club Type </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    
                                    
                                  <select name="club_type" class="form-control club_type" id="club_type" data-rule-required="true">
                                  <option value="">Please Select Club Type</option>
                                  <option <?php echo $cl_type['club'] == $partner['partner']['club_type'] ? "selected" : '';?>  value="<?php echo $cl_type['club'];?>"><?php echo $cl_type['club'];?></option>
                                  <option  <?php echo $cl_type['fixed'] == $partner['partner']['club_type'] ? "selected" : '';?> value="<?php echo $cl_type['fixed'];?>"><?php echo $cl_type['fixed'];?></option>
                                   
                                  
                                  </select>
                                </div>
                              </div>





                            <div class="col-md-4 col-sm-6">
                                <!--<div class="form-group label-floating is-empty">-->
                                
                                <div class="form-group">
                                    
                                    
                                    <label class="">Module </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                <!--     <label class="control-label">Module</label> -->
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
                                
                                
                                
                                <label class="">Channel Partner Type </label>  <label style="color:red;">(Mandatory)</label>
                                
                                
                                
                                         <!--   <label class="control-label">&nbsp;</label> 
 -->
                                            <select id="channel_type" data-rule-required="true" class="testSelAll form-control  search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" onchange="console.log($(this).children
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
                                            </select>
                                        </div>

                            <div class="col-md-4 col-sm-6">
                                <!--<div class="form-group label-floating is-empty">-->
                                
                                
                                   <div class="form-group">
                                    
                                    <label>Name of the Organization </label>  <label style="color:red;">(Mandatory)</label>
                                  
                                    
                                    
                                    
                                    <input type="text" name="name" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['name'];?>">
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>
                            <div class="col-md-4 col-sm-6">
                                <!--<div class="form-group label-floating is-empty">-->
                                    
                                    <div class="form-group">
                                    
                                    <label >Email </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    
                                    
                                    <input type="text" name="email" class="form-control" value="<?php echo $partner['partner']['email'];?>" readonly="">
                                    <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <!--<div class="form-group label-floating is-empty">-->
                                
                                <div class="form-group">
                                    
                                    
                                    <label >Contact Number </label>   <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    
                                    <input type="number" name="phone" id="phone" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['phone'];?>">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>

                         <!-- <div class="col-md-4 col-sm-6 col-xs-12 ">
                             <div class="form-group label-floating is-empty">
                                    <label >Alternative Contact Number</label>
                                            <input type="number" name="phone2" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['phone2'];?>">
                                            <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                        </div>
                                        </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Contact Person</label>
                                    <input type="text" name="cname" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['cname'];?>">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>

                                <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Contact Person Email</label>
                                    <input type="text" name="c_email" class="form-control" value="<?php echo $partner['partner']['c_email'];?>">
                                    <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12 ">
                             <div class="form-group label-floating is-empty">
                                    <label> Contact Number</label>
                                            <input type="number" name="c_mobile" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['c_mobile'];?>">
                                            <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                        </div>
                                        </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label>Alternative Contact Person</label>
                                    <input type="text" name="acname" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['alt_c_name'];?>">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>


                            <div class="col-md-4 col-sm-6 col-xs-12 ">
                             <div class="form-group label-floating is-empty">
                                    <label  >Alternative Contact Number</label>
                                            <input type="number" name="ac_mobile" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['alt_c_mobile'];?>" >
                                            <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                        </div>
                                        </div>
                                <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Alternative Contact Person Email</label>
                                    <input type="text" name="ac_email" class="form-control" value="<?php echo $partner['partner']['alt_c_email'];?>">
                                    <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                </div>
                            </div> -->
                            <div class="col-md-4 col-sm-6">
                                
                                
                                <div class="form-group">
                                    
                                    
                                    <label >Owner Name </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    <input type="text" name="ocname" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['owner_name'];?>">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                
                                
                                <div class="form-group">
                                    
                                    <label >Owner Email </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    
                                    <input type="text" name="oc_email" class="form-control" value="<?php echo $partner['partner']['owner_email'];?>">
                                    <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12 ">
                                
                                
                             <div class="form-group">
                                 
                                    <label>Owner Contact Number </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                            <input type="number" name="oc_mobile" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['owner_mobile'];?>">
                                            <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                        </div>
                                        </div>

                            <div class="col-md-4 col-sm-6">
                                
                                
                                <div class="form-group">
                                    <label >Country</label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country" data-rule-required="true">
                                       <option value="">Please Select</option>
                                        <?php foreach ($countries as $key => $country) { ?>
                                        <option <?= $partner['partner']['country'] == $country['id'] ? "selected" : "" ; ?> value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                        <?php } ?>
                                            </select>
                                </div>
                            </div>


                            <div class="col-md-4 col-sm-6">
                                
                                
                                <div class="form-group">
                                    
                                    <label >State </label>  <label style="color:red;">(Mandatory)</label>
                                   
                                   
                                     <select name="state" class=" form-control sel_state select_box_sel" id="states" data-rule-required="true">
                                        <option value="">Please Select</option>
                                        <?php foreach ($states as $st) { ?>
                                        <option <?= $partner['partner']['state'] == $st['id'] ? "selected" : "" ; ?> value="<?php echo $st['id'];?>"><?php echo $st['name'];?></option>
                                         <?php } ?>                                        
                                            </select>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                
                                
                                <div class="form-group">
                                    
                                    <label >City</label>  <label style="color:red;">(Mandatory)</label>
                                   
                                   
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
                                <!--<div class="form-group label-floating is-empty">-->
                                
                                <div class="form-group">
                                
                                
                                    <label class="">Area </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    <input type="text" placeholder="Area" name="area" class="form-control" value="<?php echo $partner['partner']['area'];?>" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input"></span></div>
 
                            </div>
                            
                            
                            
                            
                            
                            
                            

                       <!--      <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Town</label>
                                    <input type="text" data-rule-required="true" name="town" class="form-control" id="town" value="<?php echo $partner['partner']['town'];?>">

                                </div>
                            </div> -->
                            <!-- <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Bank Name</label>
                                    <input type="text" data-rule-required="true" name="bank_name" class="form-control" id="bank_name" value="<?php echo $partner['partner']['bank_name'];?>">

                                </div>
                            </div>
                      
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Account Number</label>
                                    <input type="text" data-rule-required="true" name="ac_number" class="form-control" id="ac_number" value="<?php echo $partner['partner']['account_no'];?>">

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Account Holder Name</label>
                                    <input type="text" data-rule-required="true" name="ac_holder_name" class="form-control" id="ac_holder_name" value="<?php echo $partner['partner']['account_holder_name'];?>">

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >IFSC Number</label>
                                    <input type="text" data-rule-required="true" name="ifsc" class="form-control" id="ifsc" value="<?php echo $partner['partner']['ifsc'];?>">

                                </div>
                            </div> -->

<!--                             <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Branch Name</label>
                                    <input type="text" data-rule-required="true" name="branch" class="form-control" id="branch" value="<?php echo $partner['partner']['branch_name'];?>">

                                </div>
                            </div> -->
                                    
                           <!--  <div class="col-md-12 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label>Address</label>
                                    <textarea type="text" name="address" class="form-control" data-rule-required="true"><?php echo $partner['partner']['address'];?></textarea>
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div> -->


                            <!-- <div class="col-md-4 col-sm-6">
                        <div id="imagePreview" style="overflow:hidden;">
                          <img src="<?php echo base_url()?>/<?php echo $partner['partner']['profile_image']?>" style="max-width:100%;height:160px;">
                        </div>
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                                    <span class="btn btn-rose btn-round btn-file crsor">
                                                        <span class="fileinput-new crsor">Select Profile image</span>
                                                    <span class="fileinput-exists">Change</span> -->
 <!-- <input type="file" class="crsor" name=""> -->
                                                   <!--  <input type="file" name="pro" id="pro" class="crsor" >
                                                    </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div> -->


                           <!--  <div class="col-md-4 col-sm-6">
                           <div id="imagePreview" style="overflow:hidden;">
                           <img src="<?php echo base_url()?>/<?php echo $partner['partner']['brand_image']?>" style="max-width:100%;height:160px;">
                           </div>
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                    <span class="btn btn-rose btn-round btn-file crsor">
                                    <span class="fileinput-new crsor">Select Brand image</span>
                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="bri"  class="crsor" multiple>
                                                    </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-4 col-sm-6">
                                
                                
                                <div class="form-group">
                                    
                                    <label>PAN Number </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    <input type="text" name="pan" class="form-control" data-rule-required="true" id="pan" value="<?php echo $partner['partner']['pan'];?>">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label>GST Number</label>
                                    <input type="text" name="gst" class="form-control" id="gst"  value="<?php echo $partner['partner']['gst'];?>">
                                    <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                </div>
                            </div>
                            
                            
                            
                            <!--<div style="padding-top: 30px;" class="col-md-4 col-sm-6 manerr2">-->
                            <div class="col-md-4 col-sm-6 manerr2">
                                
                                
                                
                                
                                
                                
                                          <?php if($partner['partner']['company_registration']){ ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                               <?php
                                $keywords = explode('cp_docs/', $partner['partner']['company_registration']);
                                $ext = pathinfo($keywords[1], PATHINFO_EXTENSION);
                                    if($ext=='docx'){
                                ?>
                                        <iframe class="doc" src="http://docs.google.com/gview?url=<?php echo base_url().$partner['partner']['company_registration']?>&embedded=true" style="width:60%" data-title="docs"></iframe>

                                        <br>
                                        
                                        
                                        <!--<a href="#" class="btn btn-sm btn-danger btn_del" data-id="<?php echo $details['id'];?>"><i class="fa fa-trash"></i></a>-->
                                        
                                        
                                <?php
                                    }else if($ext=='pdf'|| $ext=='jpg'|| $ext=='png'|| $ext=='jpeg' ){
                                ?>
                                        <a href="<?php echo base_url().$partner['partner']['company_registration']?>"><i class="btn btn-sm btn-primary fa fa-file" target="_blank" data-title="pdf"></i><?= $keywords[1] ?></a>

                                        <br>
                                        <!--<a href="#" class="btn btn-sm btn-danger btn_del" data-id="<?php echo $partner['partner']['id'];?>"><i class="fa fa-trash"></i></a>-->
                                <?php
                                    }else{
                                        echo "No Docs";
                                    }
                                ?>
                            </div>
                            <?php } ?>
                                
                                
                                
                                

                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                                    <span class="btn btn-rose btn-round btn-file crsor" style="overflow: visible;">
                                                        <span class="fileinput-new crsor">Company Registration Document</span>
                                                    <span class="fileinput-exists">Change</span>
<!--  <input type="file" class="crsor" name=""> -->
                                                    <input type="file" name="company_registration" id="company_registration" class="crsor"  >
                                                    </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div>
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                            <div class="col-md-4 col-sm-6 manerr2">
                            <!--<div style="padding-top: 30px;" class="col-md-4 col-sm-6 manerr2">-->
                                
                                
                                
                                
                                      <?php if($partner['partner']['license']){ ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
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
                                
                                
                                
                                
                                
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                                    <span class="btn btn-rose btn-round btn-file crsor" style="overflow: visible;">
                                                        <span class="fileinput-new crsor">Corporation/Panchayath/Muncipality License</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="license"  class="crsor">
                                                    </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div>
                      
                      
                      
                      
                      
                      
                      
                      
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <h4>Map Locator (Please choose channel location)</h4>
                        </div>
                      
                      
                      
                      
                      
                      
                            <div class="col-md-12">
                                <div class="col-md-6 col-sm-6">
                                    
                                    
                                    <div class="form-group">
                                        
                                        <label >Latitude* </label>  <label style="color:red;">(Mandatory)</label>
                                        
                                        
                                        <input type="text" data-rule-required="true" placeholder="Latitude" id="lat" name="latt" class="form-control " value="<?php echo $partner['partner']['lattitude'];?>">
                                        <span class="material-input"></span><span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    
                                    
                                    <div class="form-group">
                                        
                                        <label >Longitude* </label>  <label style="color:red;">(Mandatory)</label>
                                        
                                        
                                         <input type="text" data-rule-required="true" placeholder="Longitude" id="long" name="long" class="form-control" value="<?php echo $partner['partner']['longitude'];?>" >
                                        <span class="material-input"></span><span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin-top: 25px;">
                                   <?php echo $map['html']; ?>
                                </div>
<!--                                 <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <div class="checkbox">
                                                        <label> <input type="checkbox"  name="isagree" data-rule-required="true" id="checkbox1" class="" checked>
                                                        <p type="" class="" data-toggle="modal" data-target="#agree1"> Agree Terms and Condition</p> </label>
                                            </div>
                                     </div>   -->                                          
                                    


                            <div class="col-md-12">
                                <input type="submit" class="btn btn-fill btn-rose" value="Update">

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

       
$(document).ready(function () {

 var v = jQuery("#channel_form").validate({

    submitHandler: function(datas) {
    
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {

                if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated channel partner </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
                }
                else
                {
                   // $('#channel_form').hide();
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
            }
        });
    }
});
}); 
</script> 
<script type="text/javascript">
            $('#states').SumoSelect();
        $('#city').SumoSelect();
        $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
        $('#sel_country').change(function () {

            var cur = $(this);
            var country_id = cur.val();
            
            if (country_id != '') {

                $.get('<?= base_url();?>admin/executives/get_states_by_country', {country_id: country_id}, function (data) {
                    if (data.status) {
                        
                        $('#states')[0].sumo.unload();
                        var opt = '';
                        var data = data.data;
                        
                        opt += '<option value="">Please select</option>';
                        for (var i = 0; i < data.length; i++) {

                            opt += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }

                        //  $('#states')[0].sumo.unload();
                        $('#states').html(opt);
                        $('#states').SumoSelect({search: true, placeholder: 'select state'});
                    } else {
                        $.toast('No state found', {'width': 500});
                    }
                }, 'json');
            }
        });
        $('#states').change(function () {
            var cur = $(this);
            var state_id = cur.val();
          
            if (state_id != '') {

                $.get('<?= base_url();?>admin/executives/get_city_by_state', {state_id: state_id}, function (data) {
                    if (data.status) {
                       $('#city')[0].sumo.unload();
                        var opt = '';
                        var data = data.data;
                        for (var i = 0; i < data.length; i++) {
                            opt += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#city').html(opt);
                        $('#city').SumoSelect({search: true, placeholder: 'select state'});
                    } else {
                         var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+'No city found'+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });
                    }
                }, 'json');
            }

        });
    

</script>
    <script type="text/javascript">
        $(document).ready(function(){
            // $('#channelsubmit').click(function(e){
            //     e.preventDefault();
            //     var sta = $("#channel_form").validationEngine("validate");
            //     if(sta== true){

            //         var cur= $(this);
            //         var data=$("#channel_form").serializeArray();
            //         $('.body_blur').show();

            //         $.post('<?php echo base_url();?>admin/Channel_partner/new_partner', data, function(data){
            //             $('.body_blur').hide();

            //             if(data.status){
            //                 noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
            //                 $('#channel_form')[0].reset();
            //             }
            //             else{
            //                 noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            //             }

            //         },'json');
            //     }

            // });


        $('#email').focusout(function(){
            var mail = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/channel_partner/mail_exists/',{mail :mail},
                   function(data)
                    {
                        if(data.status)
                        {
                            noty({text:"Mailid Already Exists",type: 'error',layout: 'top', timeout: 3000});
//                                    cur.next().text("Mailid Already Exists").css('color', 'red');
                            $("#channelsubmit").hide();
                        }else{
                            cur.next().remove();
                            $("#channelsubmit").show();
                        }
                    },'json');
         });
        $('#phone').focusout(function(){
            var mob = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/channel_partner/mobile_exists/',{mob :mob},
                    function(data)
                    {
                        if(data.status)
                        {
                            noty({text:"Mobile Number Already Exists",type: 'error',layout: 'top', timeout: 3000});
//                                    cur.next().text("Mailid Already Exists").css('color', 'red');
                            $("#channelsubmit").hide();
                        }else{
                            cur.next().remove();
                            $("#channelsubmit").show();
                        }
                    },'json');
        });
     });
    </script>
  <!--   <script>
    $(document).ready(function() {
        //set initial state.
        $('#textbox1').val($(this).is(':checked'));

        $('#checkbox1').change(function() {
            $('#textbox1').val($(this).is(':checked'));
        });

        $('#checkbox1').click(function() {
            if ($(this).is(':checked')) {
                return confirm("Are you sure?");
            }
        });
        // $(".SumoSelect li").bind('click.check', function(event) {
        //         alert($(this).hasClass('selected'));
        // })
         $('.btnOk').on('click', function () {

        //debugger;
        var obj = [],
        items = '';
            $('.channel_type option:selected').each(function (i) {
                obj.push($(this).val());
               // $('.channel_type')[0].sumo.unSelectItem(i);
            });
            $.post('<?php echo base_url();?>admin/channel_partner/get_all_cptypes/',{obj :obj},
                    function(data)
                    {
                        
                        if(data.status)
                        {
                            var data = data.data;
                            var commissiongroup = "";
                           
                            for (var i = 0 ; i < data.length ; i++) {
                               
                                commissiongroup += '<div class="row"><div class="col-md-6"><input type="text" name="category[]"  class="form-control  category" value="'+data[i].title+'" readonly style="background-image:linear-gradient(#D2D2D2, #D2D2D2), linear-gradient(#D2D2D2, #D2D2D2)"></div><div class="col-md-6"><input type="text" name="commission[]" class="form-control commission"></div></div>';
                                
                            }
                           
                            $('.commissiongroup').html(commissiongroup);
                           // noty({text:"Mobile Number Already Exists",type: 'error',layout: 'top', timeout: 3000});
//                                    cur.next().text("Mailid Already Exists").css('color', 'red');
                           // $("#channelsubmit").hide();
                           // var regex = /(<([^>]+)>)/ig;
                           //  var body = "Mobile Number Already Exists";
                           //  var result = body.replace(regex, "");
                           //  var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                           //  var effect='fadeInRight';
                           //  $("#notifications").append(center);
                           //  $("#notifications-full").addClass('animated ' + effect);
                           //  refresh_close();
                           //  //cur.next().text("Mailid Already Exists").css('color', 'red');
                           //  cur.val("");
                        }else{
                            //cur.next().remove();
                            //$("#channelsubmit").show();
                        }
            },'json');
            // for (var i = 0; i < obj.length; i++) {
            //     items += ' ' + obj[i]
            // };
           // alert(items);
    });
       
    });
</script> -->
<script type="text/javascript">
         $(document).on('change', '.club_member',function(){
          var cur = $(this); 
          var club_member= cur.val();
          $.post('<?php echo base_url();?>admin/executives/get_count_by_id/'+club_member, function(data){
           var data1 = data.data;
          
            if(data1['cp_limit']>data1['cp_count']){

              $(".channel").show();
            }
            else{
               $(".channel").hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Sorry!!...Channel Partner Limit Crossed </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
            }
         
           },'json');


          $('.body_blur').show();
          $.post('<?php echo base_url();?>admin/executives/get_club_details_id/'+club_member, function(data){
            $('.body_blur').hide();

           if(data.status)
            {
              var data = data.data;
              if(data.ty1 != null){
                
                var ty2=data.ty1;
                var option ='';
               option += '<option value="">Please Select</option>';
            // for(var i=0; i<data.length; i++){
                option += '<option value="'+data.club_type_id+'">'+data.ty+'</option>';

                 option += '<option value="'+data.fixed_club_type_id+'">'+ty2+'</option>';

                }
                else{
                   var option ='';
               option += '<option value="">Please Select</option>';
            // for(var i=0; i<data.length; i++){
                option += '<option value="'+data.club_type_id+'">'+data.ty+'</option>';

                 
                }
              //console.log(data);
               
                
            // }
              $('.club_type').html(option);
            } else{
              noty({text: data.reason, type:error, timeout:1000});
            }
          },'json');
          });   
</script>
<script>
    //pan validation
    $('#pan').change(function (event) {     
     var regExp = /[A-Z]{5}\d{4}[A-Z]{1}/; 
     var txtpan = $(this).val(); 
        if (txtpan.length == 10 ) { 
            if( txtpan.match(regExp) ){ 
      
            }else {
                var regex = /(<([^>]+)>)/ig;
                var body = "Not a valid PAN number";
                var result = body.replace(regex, "");
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                $('.close').click(function(){
                    $(this).parent().fadeOut(1000);
                });
                $('#pan').val('');
               event.preventDefault(); 
            } 
        }else { 
            var regex = /(<([^>]+)>)/ig;
            var body = "Please enter 10 digits for a valid PAN number";
            var result = body.replace(regex, "");
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            $('.close').click(function(){
                $(this).parent().fadeOut(1000);
            });

           event.preventDefault(); 
        } 
    });
    //end of pan validation
    //gst validation
    $(document).on('change',"#gst", function(){    
        var inputvalues = $(this).val();
        var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');

        if (gstinformat.test(inputvalues)) {
            return true;
        } else {
            var regex = /(<([^>]+)>)/ig;
            var body = "Please Enter Valid GST Number";
            var result = body.replace(regex, "");
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            $('.close').click(function(){
                $(this).parent().fadeOut(1000);
            });
            $("#gst").val('');
            $("#gst").focus();
        }
    });
    // end of gst validation
</script>
</body>

</html>