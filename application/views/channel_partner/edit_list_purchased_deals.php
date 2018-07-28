<?= $header; ?>
<style type="text/css">
    .card img {
    width: 100px;
    height: auto;
}
</style>
<body>
<div class="wrapper">

<?= $sidebar; ?>

<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header card-header-icon" data-background-color="purple">
    View Purchased Deals
</div>
<div class="card-content">
<br><br>
<div class="toolbar">
    <!--        Here you can write extra buttons/actions for the toolbar              -->
</div>
<div class="material-datatables">
<table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead>

<tr>
    <th>No</th>
    <th>Deal</th>
    <th>Amount</th>
    <th>Duration</th>
    <th>Description</th>
   
    <th class="disabled-sorting text-right">Actions</th>
</tr>
</thead>

<tbody>

<?php
 if(!empty($deal)){
 foreach($deal as $key => $dl){?>
    <tr>
        <td class="descrip"><?php echo $key+1;?></td>
        <td class="descrip"><?php echo $dl->name;?></td>
        <td class="descrip"><?php echo $dl->amount;?></td>
        <td class="descrip"><?php echo $dl->duration;?></td>
        <td class="descrip"><?php echo $dl->description;?></td>
       
        <td class="text-right">

        <a href="<?php echo base_url();?>admin/Deal/add_deal/<?php echo $dl->id; ?>/<?php echo $dl->duration; ?>" class="btn btn-simple btn-warning btn-icon edit">Add Deal</a>

        <!-- <button type="submit" class="btn btn-simple btn-rose prosubmit" name="prosubmit" id="prosubmit" style="color: #3c4a7b;">Add Deal<div class="ripple-container"></div></button> -->
       
     </tr>
<?php } }?>
</tbody>
</table>
</div>
</div>
<!-- end content-->
</div>
<!--  end card  -->
</div>
<!-- end col-md-12 -->
</div>
<!-- end row -->
</div>


</div>

<?= $footer; ?>



<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            //alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });
         $('.card .material-datatables label').addClass('form-group');
        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            var cur=$(this);
            var hiddentypeid=cur.parent().parent().find('.hiddentype_id').val();
            $('.body_blur').show();
            $.post('<?php echo base_url();?>admin/Product/delete_productbyid/'+hiddentypeid, function(data){
                $('.body_blur').hide();
                if(data.status){
                    alert("deleted");
                    table.row($tr).remove().draw();
                    //noty({text: 'Deleted Succesfully', type: 'success', timeout:1000});
                    //cur.parent().parent().remove();
                }else{
                    alert("failed");
                    //noty({text: 'Database Error', type: 'error'});
                }
            },'json');
            
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        

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
                        $.post('<?php echo base_url();?>admin/Product/delete_productbyid/'+hiddentypeid, function(data){
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
</body>

</html>