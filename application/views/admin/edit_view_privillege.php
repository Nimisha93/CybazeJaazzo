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
                        <h2>Group<small></small></h2>
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
                                    <th>Group</th>
                                    <th></th>


                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Group</th>
                                    <td></td>

                                </tr>
                                </tfoot>
                                <tbody style=" height:100px;overflow:scroll">
                                <?php foreach($group['grp'] as $grp){?>
                                <tr>
                                    <td class="titleclass"><input type="hidden" name="hiddenid" class="hiddentype_id" value="<?php echo $grp['id'];?>">
                                        <?php echo $grp['group'];?></td>
                                    <td><a href="<?php echo base_url();?>admin/privillage/get_group_byid/<?php echo $grp['id'];?>"><button type="button" class="btn btn-primary">Edit </button></a>
                                        <button type="button" class="btn btn-danger grp_delete">Delete </button></td>

                                </tr>
                                    <?php }?>
                                <script>
                                    $(document).ready(function(){


                                        $(document).on('click','.grp_delete',function(){
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
                                                        $.post('<?php echo base_url();?>admin/privillage/delete_group/'+hiddentypeid, function(data){
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
</div>
</div>
</div>
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


<!-- Datatables -->

<!--============new customer popup start here=================-->


</body>
</html>





























