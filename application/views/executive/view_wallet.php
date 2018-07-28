 <?php echo $header; ?>

<body>
<div class="wrapper">

 <?php echo $sidebar; ?>
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header card-header-icon" data-background-color="purple">
    Wallet
</div><br><br>
<div class="card-content">
<!--    <h4 class="card-title">Commision</h4>-->
<div class="toolbar">
    <!--        Here you can write extra buttons/actions for the toolbar              -->
</div>
<div class="material-datatables">
<table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead>
<tr>
   
    <th>Reward Amount</th>
    <th>Date</th>
    <th>Description</th>
</tr>
</thead>

<tbody>
<?php 
 $total=0;
 foreach($wallet_details as $key=>$type){
       
        $total+=$type['change_value'];
    ?>
<tr>

    <td><?php echo $type['change_value'];?></td>
    <td><?php echo $type['date_modified'];?></td>
    <td><?php echo $type['description'];?></td>
</tr>
<?php } ?>

<tr style="text-align: center;">
    <th style="text-align: center;">Total Reward</th>
    <th></th>
    <th><?php echo $total; ?></th>

</tr>

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

 <?php echo $footer; ?>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.datatables.js"></script>

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
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>

</body>

</html>