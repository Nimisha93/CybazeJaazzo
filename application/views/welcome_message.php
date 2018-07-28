<?php echo $default_assets ?>
<?php
$user=$this->session->userdata('user');
// $re1=$this->session->userdata('branch_id');
$re1=$this->session->userdata('branch_id');

if (isset($user))
{
    if(isset($re1)){
        //   $this->load->view('templates/admin_sidebar_b');
    }
    $re=$this->session->userdata('user');
    if($re=='branch'){
        $this->load->view('templates/admin_sidebar_b');
    }
    else if($re=='admin'){
        $this->load->view('templates/admin_sidebar');

    }
    else if($re=='visa'){
        $this->load->view('templates/sidebar_visa');

    }
    else{

    }

}?>
</head>
<ul>
    <li style="top: 26px;position: absolute;right: 338px;list-style: none;"> <?php $this->load->view('admin/view-username');?></li>
</ul>
<?php //echo $sidebar_b ?>
<div class="right_col" role="main">
<div class="">
    <div class="page-title">
        <div class="title_left">
            </h3>
        </div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">

                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div
                class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Visa<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                        <!--li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li-->
                    </ul>


                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">


                        <form class="form-horizontal Calendar" method="post" action="<?php echo site_url('Branch/visaedit/'.$row->customer_id.'');?>">

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label>Agent</label>
                                    <select id="standard" name="agent_name" class="option3 form-control"  onchange="selctcity()" required>
                                        <?php foreach($visa as $row3){?>
                                        <option <?php echo $row->agent_id == $row3->agent_id ? 'selected="selected"' : '' ;?> value="<?php echo $row3->agent_id;?>"><?php echo $row3->agent_name;?>(<?php echo $row3->agent_mail;?>)</option>

                                        <?php }?>

                                    </select>
                                    <!--input type="text" placeholder="Branch Name" name="branch_name" id="branch_name"  class="validate[required] form-control"-->
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label>Passport</label>
                                    <input type="text" id="customer_passport" name="customer_passport" ng-model="myInput" class="form-control" value="<?php echo $row->customer_passport;?>" required="">
                                    <!--input type="text" placeholder="Manager Name" name="manager_name"  id="manager_name"    class="validate[required] form-control"-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label for="Contact Number">Contact Person</label>
                                    <input type="text" id="customer_name" name="customer_name" class="form-control" value="<?php echo $row->customer_name;?>" required="">
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label>Gender</label>
                                    <select id="customer_gender" name="customer_gender" class="form-control" required="">
                                        <option value="<?php echo $row->customer_gender;?>"><?php echo $row->customer_gender;?></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label> Visa Type</label>
                                    <select id="visa_visa" name="visa_visa" class="visa_ty option3 form-control" required="">
                                        <!--                                    <option value="--><?php //echo $row->type_id;?><!--">--><?php //echo $row->type_name;?><!--</option>-->
                                        <?php
                                        foreach($query1 as $row1)
                                        {
                                            ?>
                                            <option <?php echo $row->type_id == $row1->type_id ? 'selected="selected"' : '' ;?> value="<?php echo $row1->type_id;?>"><?php echo $row1->type_name;?></option>

                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--input type="text" placeholder="No of Employees" class="validate[required] form-control" id="no_employee" name="no_employee"-->
                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">

                                    <label for="exampleInputPassword1">  Visa category</label>
                                    <select name="visa_category" id="visa_category" class="option3 form-control" required="">
                                        <?php
                                        foreach($visa_cat as $cat){
                                            ?>
                                            <option <?php echo $cat['visa_category'] == $row->visa_category ? 'selected="selected"' : '' ;?> value="<?php echo $cat['visa_category'];?>"><?php echo $cat['visa_category'];?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>




                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label for="exampleInputPassword1"> Visa Cost</label>
                                    <input type="text" id="visa_cost" name="visa_cost" class="form-control visa_cost" value="<?php echo $row->visa_cost;?>" required="">
                                </div>
                            </div>

                            <style>
                                #listBox {
                                    display: none;
                                }
                            </style><script>
                            $(document).ready(
                                    function() {
                                        $("#listBox11").click(function() {
                                            $("#listBox").toggle();
                                            $("#listBox11").hide();
                                        });
                                    });
                        </script>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <div id="selection">
                                    </div>
                                    <label for="exampleInputPassword1">State</label>
                                    <select id="listBox" onchange='selct_district(this.value)' name="visa_state" ng-model="myInput" class="form-control" required=""></select>
                                    <input type="text" id="listBox11" name="visa_state1"  class="form-control" value="<?php echo $row->visa_state;?>">

                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label for="exampleInputPassword1"> District</label>
                                    <select id='secondlist' name="visa_district" ng-model="myInput" class="form-control" required>
                                        <option value="<?php echo $row->visa_district;?>"><?php echo $row->visa_district;?></option></select>


                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label for="exampleInputPassword1"> Date of Registration</label>
                                    <input type="text" id="mydate" name="visa_entrydate"  class="form-control" value="<?php echo $row->visa_entrydate;?>" required="" readonly>
                                </div>

                                <!--script>
                                    $("#mydate").datepicker().datepicker("setDate", new Date());
                                </script-->



                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label for="exampleInputPassword1">Visa Status</label>
                                    <select id="visa_status" name="visa_status" class="form-control">
                                        <option value="<?php echo $row->visa_status;?>"><?php echo $row->visa_status;?></option>
                                        <option value="Pending">Pending</option>
                                        <option value="Issued">Issued</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label for="exampleInputPassword1"> Selling Price</label>
                                    <input type="text" id="selling_price" name="selling_price" class="form-control selling_price" required="" value="<?php echo $row->selling_price;?>">
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                    <label for="exampleInputPassword1"> Profit</label>
                                    <input type="text" id="profit" name="profit" class="form-control profit" value="<?php echo $row->profit;?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="exampleInputPassword1">Visa Narration</label>
                                    <textarea id="visa_narration" name="visa_narration" rows="6" class="form-control" ><?php echo $row->visa_narration;?></textarea>
                                </div>

                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <button type="submit" id="agent_update" name="agent_update" valu='Submit' class="btn btn-primary antosubmit">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!--************************row  end******************************************************************* -->




</div>
</div>
</div>
</div>
</div>
<?php echo $footer ?>
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/jqui/jquery-ui.js"></script>
<link href="<?php echo base_url();?>assets/jqui/jq_jquery-ui.css" rel="stylesheet">
<script>
    $("#mydate").datepicker().datepicker();
</script>
<script>
    $(document).ready(function()
    {
        $("#visa_cost").keyup(function()
        {
            var visa_cost=$("#visa_cost").val();
            var sp=$("#selling_price").val();
            var net=sp-visa_cost;
            document.getElementById('profit').value=net;
        });
    });

</script>
<script>
    $(document).ready(function()
    {
        $("#selling_price").keyup(function()
        {
            var visa_cost=$("#visa_cost").val();
            var sp=$("#selling_price").val();
            var net=sp-visa_cost;
            document.getElementById('profit').value=net;
        });
    });

</script>
<script type="text/javascript">
    $(function() {
        $('.form-group').on('keydown', '.visa_cost', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
</script>
<script>

    $(document).ready(function(){
        $('.visa_ty').change(function(){
            //var visa_visa=$('#visa_visa').val();
            var visa_visa = $(this).val();
            $.post('<?php echo base_url();?>index.php/Branch/visa_type',
                    {
                        visa_visa:visa_visa

                    },
                    function(data)
                    {
                        $('#visa_category').html(data);
                    });
        });
    });
</script>
<script type="text/JavaScript" src='<?php echo base_url();?>style/js/state.js'></script>

<script src="<?php echo base_url();?>style/bootstrap/js/bootstrap.min.js"></script>


<script src="<?php echo base_url();?>style/dist/js/app.min.js"></script>

<!-- Datatables -->

<!--============new customer popup start here=================-->




</body>
</html>