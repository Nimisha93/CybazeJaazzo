<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">

</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                </h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
                </span> </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Pool Stages <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>No</th>
                                    <th>Stage Name</th>
                                    <th>Description</th>
                                    <th>Created On</th>
                                    <th></th>


                                </tr>
                                </thead>
                               <!--  <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Stage Name</th>
                                    <th>Description</th>
                                    <th>Created On</th>
                                    <th></th>

                                </tr>
                                </tfoot> -->
                                <tbody style=" height:100px;overflow:scroll">
                                <?php foreach($all_stages as $key=>$stages){?>
                                <tr><input type="hidden" value="<?php echo $stages['id'];?>" class="hidden_id">
                                    <td class="titleclass"><?php echo $key+1?></td>
                                    <td class="stage"><?php echo $stages['stage_name'];?></td>
                                    <td class="descrip"> <?php echo $stages['description'];?></td>
                                  
                                    <td><button type="button" class="type_sub" class="btn btn-primary type_sub" data-toggle="modal" data-target="#agree1">Edit </button>
                                    <!-- <button type="button"  class="btn btn-primary type_sub edit_stage" >Edit </button> -->
                                        <button type="button" class="btn btn-danger commission_delete">Delete </button></td>

                                </tr>
                                    <?php }?>
                                <div id="agree1" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">X</button>
                                                <h4 class="modal-title">Edit Pool Stages</h4>
                                            </div>
                                            <div class="modal-body">
                                                
                                                    <form method="post" id="commission_forms" class="commission_forms" name="commission_forms">
                                                    <input type="hidden"  name='hiddentype'  id="hiddentype"  class="form-control" ng-model="hidden_id">
                                                       <div class="col-md-8 col-sm-6 col-xs-12 form-group">
                                                        <label>Stage Name</label>
                                                        <input type="text" placeholder="Stage Name" name="stage_name" ng-model="stage_name" 
                                                         id="stage_name" class="form-control stage_name">
                                                       </div>

                                                      <div class="col-md-8 col-sm-8 col-xs-8 form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control description" rows="3" name="description" id="description"  ng-model="description" placeholder="Description"></textarea>
                                                      </div>
                                                      <div class="col-md-8 col-sm-8 col-xs-8 form-group">
                                                        <button type="button" class="btn btn-primary editsub" id="editsub">Submit</button>
                                                      </div>
                                                      </form>
                                             </div>
                                              <!--   -->
                                            <div class="modal-footer">
                                             
                                            
                                           </div>

                                         </div>

                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function(){
                                        $(document).on('click','.type_sub',function(){
                                            var cur=$(this);
                                            var hiddentype_id=cur.parent().parent().find('.hidden_id').val();
                                            var title=cur.parent().parent().find('.stage').text();
                                            var pooling=cur.parent().parent().find('.descrip').text();
                                           
                                            $(document).find('#stage_name').val(title);
                                            $(document).find('#description').val(pooling);
                                          
                                            $(document).find('#hiddentype').val(hiddentype_id);
                                            // var cur=$(this);
                                            // var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
                                            // var title=cur.parent().parent().find('.titleclass').text();
                                            // var direct=cur.parent().parent().find('.direct_commi').text();
                                            // var pooling=cur.parent().parent().find('.pooling_commi').text();
                                            // $(document).find('#title').val(title);
                                            // $(document).find('#company_commi').val(pooling);
                                            // $(document).find('#direct_commi').val(direct);
                                            // $(document).find('#hiddentype').val(hiddentype_id);

                                        });
                                        $("#editsub").click(function(e){
                                            e.preventDefault();
                                            var str = $("#commission_forms").validationEngine("validate");
                                            if(str==true){

                                                var data=$("#commission_forms").serializeArray();
                                                console.log(data);
                                               
                                                $('.body_blur').show();
                                                $.post("<?php echo base_url();?>admin/pooling/edit_pooling_stage", data, function(data){
                                                    $('.body_blur').hide();
                                                    if(data.status){
                                                        noty({text:"Successfully updated",type: 'success',layout: 'top', timeout: 3000});
                                                        $('#commission_forms')[0].reset();
                                                      ///  window.location="<?php echo base_url();?>channel_pooling";
                                                    }
                                                    else{
                                                        noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                                                        $('#commission_forms')[0].reset();
                                                    }
                                                },'json');
                                            }
                                            else{

                                            }

                                        })
                                        $(document).on('click','.commission_delete',function(){
                                            var cur=$(this);
                                            var hiddentypeid=cur.parent().parent().find('.hiddentype_id').val();
                                            noty({
                                                text: 'Do you want to continue?',
                                                type: 'warning',
                                                buttons: [
                                                    {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                                                        // this = button element
                                                        // $noty = $noty element

                                                        $noty.close();
                                                        $('.body_blur').show();
                                                        $.post('<?php echo base_url();?>admin/Pooling/delete_commissionbyid/'+hiddentypeid, function(data){
                                                            $('.body_blur').hide();
                                                            if(data.status){
                                                                noty({text: 'Deleted Succesfully', type: 'success', timeout:1000});
                                                                cur.parent().parent().remove();
                                                            }else{
                                                                noty({text: 'Database Error', type: 'error'});
                                                            }
                                                        },'json');
                                                    }
                                                    },
                                                    {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                                                        $noty.close();

                                                    }
                                                    }
                                                ]
                                            });

                                        })
                                    });
                                </script>
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

<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>


<script>

    $(document).ready(function() {
        var table = $('#example').DataTable( {
            fixedHeader: {
                header: true,
                footer: true,

            }
        } );

    } );

</script>


<!-- Datatables -->

<!--============new customer popup start here=================-->

</body>
</html>
