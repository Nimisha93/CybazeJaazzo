<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">

</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
<div class="">

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Channel Partner Type<small></small></h2>
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
                            <th>Type</th>
                            <th>Description</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Type</th>
                            <th>Description</th>
                            <td></td>

                        </tr>
                        </tfoot>
                        <tbody style=" height:100px;overflow:scroll">
                        <?php foreach($category['type'] as $type){ ?>

                        <tr>
                            <td class="titleclass"><input type="hidden" value="<?php echo $type['id'];?>" class="hiddentype_id"><?php echo $type['title'];?></td>
                            <!-- <td class="descrip"><?php echo $type['description'];?></td> -->
                            <td class="descrip"><?php echo $type['description']; ?></td>
                            <td><button type="button" class="btn btn-primary type_sub" data-toggle="modal" data-target="#agree1"> Edit </button>
                                <button type="button" class="btn btn-danger type_delete">Delete </button></td>
                            <div id="agree1" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">X</button>
                                            <h4 class="modal-title">Edit Channel Partner Type</h4>
                                        </div>
                                        <div class="modal-body" style="overflow:hidden">
                                            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel">
                                                    <!--                            <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">-->
                                                    <!--                                <h4 class="panel-title"></h4>-->
                                                    <!--                            </a>-->
                                                </div>
                                                <form method="post" id="type_forms" class="type_forms" name="type_forms">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label>Title</label>
                                                        <input type="hidden" placeholder="Last Name" class="form-control" id="hiddentype" name="hiddentype">
                                                        <input type="text" placeholder="Last Name" class="form-control" id="title" name="title">
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label>Description</label>
                                                        <textarea class="form-control" id="descriptext" name="descriptext"></textarea>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary editsub" id="editsub">Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                            <?php $pid=$type['id']; foreach($subcategory['type'] as $stype){ if($stype['parent_id']==$pid){ ?>
                            <tr style="color: red;">
                                <td class="titleclass"><input type="hidden" value="<?php echo $stype['id'];?>" class="hiddentype_id"><?php echo $stype['title'];?></td>
                                <td class="descrip"><?php echo $stype['description']; ?></td>
                                <td><button type="button" class="btn btn-primary type_sub" data-toggle="modal" data-target="#agree1">Edit</button>
                                    <button type="button" class="btn btn-danger type_delete">Delete </button></td>
                                <div id="agree1" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">X</button>
                                                <h4 class="modal-title">Edit Category</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel">
                                                        <!--                            <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">-->
                                                        <!--                                <h4 class="panel-title"></h4>-->
                                                        <!--                            </a>-->
                                                    </div>

                                        </div>
                                    </div>
                                </div>
                            </tr>
                                <?php } } ?>
                            <?php }  ?>
                        <script>
                            $(document).ready(function(){
                                $(document).on('click','.type_sub',function(){
                                    var cur=$(this);
                                    var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
                                  // alert(hiddentype_id);

                                    var title=cur.parent().parent().find('.titleclass').text();
                                    var descrip=cur.parent().parent().find('.descrip').text();
                                    $(document).find('#title').val(title);
                                    $(document).find('#descriptext').val(descrip);
                                    $(document).find('#hiddentype').val(hiddentype_id);

                                });
                                $("#editsub").click(function(e){
                                    e.preventDefault();
                                    var str = $("#type_forms").validationEngine("validate");
                                    if(str==true){

                                        var data=$("#type_forms").serializeArray();
                                        $('.body_blur').show();
                                        $.post("<?php echo base_url();?>admin/Channel_partner/edit_partnertype_byid", data, function(data){
                                            $('.body_blur').hide();
                                            if(data.status){
                                                noty({text:"Successfully updated",type: 'success',layout: 'top', timeout: 3000});
                                                $('#type_forms')[0].reset();
                                            }
                                            else{
                                                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                                                $('#type_forms')[0].reset();
                                            }
                                        },'json');
                                    }
                                    else{

                                    }

                                })
                                $(document).on('click','.type_delete',function(){
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
                                                $.post('<?php echo base_url();?>admin/Product/delete_category/'+hiddentypeid, function(data){
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


<!-- <script>

    $(document).ready(function() {
        var table = $('#example').DataTable( {
            fixedHeader: {
                header: true,
                footer: true,

            }
        } );

    } );

</script>
 -->

<!-- Datatables -->

<!--============new customer popup start here=================-->


<script>

$(document).ready(function() {
    var table = $('#example').DataTable( {
        fixedHeader: {
            header: true,
            footer: true,
			
        }
    } );
	
} );
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );
</script>
<style>
tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
		background-color:#e6e6e6;
    }
	tfoot {background-color:#f1f1f1}
	</style>

</body>
</html>





























