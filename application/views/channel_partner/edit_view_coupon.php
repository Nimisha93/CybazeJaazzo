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
    View Coupon
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
    <th>Customer</th>
    <th>Actual Price</th>
    <th>Special Price</th>
    <th>Coupon Code</th>
    <th>Coupon Price</th>
    <th>Paid Status</th>
</tr>
</thead>

<tbody>

<?php foreach($coupon as $key => $c){?>
    <tr>
        <td class="titleclass">
            <?php echo $key+1;?></td>
        <td class="descrip"><?php echo $c['deal_name'];?></td>
        <td class="descrip"><?php echo $c['name'];?></td>
        <td class="descrip"><?php echo $c['actual_cost'];?></td>
       
        <td class="descrip"><?php echo $c['special_prize'];?></td>
       <td class="descrip"><?php echo $c['coupon_code'];?></td>
        <td class="descrip"><?php echo $c['amount'];?></td>
        <?php $paid_status = ($c['is_paid']=='1')?'Paid' :'Pending' ;  ?>
        <td class="descrip"><?php echo $paid_status;?></td>
       
     </tr>
<?php }?>
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
        }); 
</script>
</body>

</html>