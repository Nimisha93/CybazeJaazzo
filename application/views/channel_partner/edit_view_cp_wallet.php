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
   Wallet Statement
</div>
<div class="card-content">
<br><br>
<div class="toolbar">
    <!--        Here you can write extra buttons/actions for the toolbar      date-range-filter    data-date-format="yyyy-mm-dd"    -->
</div>
<div class="material-datatables">
    <div class="row">
       <div class="col-md-2  pull-right">
          <button class="btn btn-fill btn-rose btn_clear" onclick="location.reload();">CLEAR</button>
      </div>
      <div class="col-md-5 pull-right">
          <div class="input-group input-daterange">

            <input type="date" id="min-date" class="form-control date-range-filter" placeholder="From:" data-date-format="DD-MM-YYYY">

            <div class="input-group-addon">to</div>

            <input type="date" id="max-date" class="form-control date-range-filter"  placeholder="To:" data-date-format="DD-MM-YYYY">

          </div>
      </div>
     
  </div>
<BR>
<table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead>

<tr class="filters">
    <th>No</th>
    <th>Name of the Customer</th>
    <th>Bill Total</th>
    <th>Rewards to Jaazzo</th>
    <th>Rewards redeemed by customer</th>
    <th>Purchased On</th>
    </tr>
</thead>

<tbody>

<?php
$tot_reward = 0;
$cus_redeemed = 0;
 foreach($wallet as $key => $wl){?>
    <tr>
        <td class="titleclass">
            <?php echo $key+1;?></td>
        <td class="descrip"><?php echo $wl['name'];?></td>
        <td class="descrip"><?php echo $wl['bill_total'];?></td>
       
        <td class="descrip"><?php echo $wl['total_commission']; ?></td>
        <?php $tot_reward += $wl['total_commission'];
          $cus_redeemed += $wl['wallet_total'];
         ?>
        <td class="descrip"><?php echo $wl['wallet_total'];?></td>
      
        <td class="descrip"><?php echo $wl['purchsed_on'];?></td>
       
     </tr>
<?php }?>
</tbody>
</table>
</div>
</div>
<!-- end content-->
</div>
<!--  end card  -->

<div class="card">

<div class="card-content">
<br><br>

<div class="material-datatables">
<table id="datatables" class="table  table-bordered table-striped  table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead style="background-color: #3c4a7c;color: #fff;text-align: center;">

<tr class="" style="text-align: center;">
    <th style="text-align: center;">Total Rewards to Jaazzo</th>
    <th style="text-align: center;">Customer Redeemed Rewards</th>
    
    <th style="text-align: center;">Paid Amount</th>
    <th style="text-align: center;">Received Amount</th>
    <th style="text-align: center;">Channel to Jaazzo</th>
    <th style="text-align: center;">Jaazzo to Channel</th>
</tr>
</thead>
<!-- $wl['name'] -->
<?php

    $toAdmin = (empty($trans['toAdmin'])) ? 0 : $trans['toAdmin'];
    $toCp = empty($trans['toCp']) ? 0 : $trans['toCp'];
    $c2j = $tot_reward - $toAdmin;
    $j2c = $cus_redeemed - $toCp;
    $toJaazzo = ($c2j > $j2c) ? ($c2j - $j2c) :0 ;
    $toChannel = ($c2j < $j2c) ? ($j2c - $c2j) :0 ;
   
?>
<tbody>
    <tr  style="text-align: center;">
        <td class="descrip"><?php echo $tot_reward;?></td>
        <td class="descrip"><?php echo $cus_redeemed;?></td>
        
        <td class="descrip"><?= round($toAdmin,2) ?></td>
        <td class="descrip"><?= round($toCp,2) ?></td> 
        <td class="descrip"><?php echo $toJaazzo;?></td>
        <td class="descrip"><?php echo $toChannel;?></td>       
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

<?= $footer; ?>

<script type="text/javascript">
    $(document).ready(function() {
        // $('.datepicker').datepicker();
        $('.datepicker').datetimepicker(
                {format: 'DD-MM-YYYY'}
        );
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

        // Extend dataTables search
        $.fn.dataTable.ext.search.push(
          function(settings, data, dataIndex) {
            var min = $('#min-date').val();
            var max = $('#max-date').val();
            //alert(min);alert(max);
            var createdAt = data[5] || 0; // Our date column in the table

            if (
              (min == "" || max == "") ||
              (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
            ) {
              return true;
            }
            return false;
          }
        );

        // Re-draw the table when the a date range filter changes
        $('.date-range-filter').change(function() {
            table.draw();
        });

      
        }); 


</script>
</body>

</html>