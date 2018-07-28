<?php echo $header; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/admin/css/buttons.dataTables.min.css" rel="stylesheet">
</head>
<?php echo $sidebar; ?>
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."></div>
            </h3>
          </div>
          <div class="title_right"> </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2 id="tittle">Branch<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
               

                  <li>

                       <a href="<?php echo base_url();?>add_branch" data-original-title="Add new" class="btn btn-success" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                    </li>
                   <li>
                                <a type="button" class="btn btn-primary fllft del_btn btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                  <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>

                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="tbleovrscroll">


                    <table id="example" class="display table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr class="tablbg">
                            <th>No</th>
                            <th >Branch Type</th>
                            <th>Branch</th>
                            <th >Phone</th>
                            <th >Email</th>
                            <th >Address</th>
                            <th >City</th>
                            <th >State</th>
                            <th >Country</th>
                            <th >Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($branch as $key=> $br) { ?>
                            <tr>
                                <td><?php echo $key+1; ?>
                                    <input type="hidden" class="vendor_id" value="<?php echo $br['id']; ?>"></td>
                                <td><?php echo $br['type_name']; ?></td>
                                <td><?php echo $br['branch']; ?></td>
                                <td><?php echo $br['contact']; ?></td>
                                <td><?php echo $br['email']; ?></td>
                                <td><?php echo $br['adds']; ?></td>
                                <td><?php echo $br['city']; ?></td>
                                <td><?php echo $br['state']; ?></td>
                                <td><?php echo $br['country']; ?></td>

                                <td>
                                    <a type="button" href="<?php echo base_url();?>updatebranch/<?php echo $br['id']; ?>" class="btn btn-primary fllft edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                    <input type="checkbox" name="" value="<?php echo $br['id'];?>" class="chck_grp_item"></td>

                            </tr>
                            <?php  } ?>

                        </tbody>
                    </table>


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
<div id="notifications"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    var table = $('#example').DataTable( {
        fixedHeader: {
            header: true,
            footer: true,
        }
        });

});



       $(document).on('click','.del_btn',function(){
            var cur=$(this);
            var itemgrps = [];
            $('.chck_grp_item').each(function () {
                var cur_this = $(this);
                var cur_val = $(this).val();
                if(cur_this.is(":checked")){
                    itemgrps.push(cur_val);
                }

            });
           
            if(itemgrps.length > 0){
                $('body').alertBox({
                title: 'Are You Sure?',
                lTxt: 'Back',
                lCallback: function(){
                  
                },
                rTxt: 'Okey',
                rCallback: function(){
                    $('.body_blur').show();
                            $.post('<?php echo base_url();?>hr/branch/deletebranch/',{itemgrps:itemgrps}, function(data){
                                $('.body_blur').hide();
                if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Deleted </div></div>';
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
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
                            },'json');
                    }
                })
            }
        });





</script>
</body>
</html>