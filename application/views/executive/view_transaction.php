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
Transcation Details
    
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
    <th>No</th>
    <th>Amount</th>
    <th>Date</th>
    <th>description</th>

</tr>
</tfoot>
<tbody>

<?php
/*print_r($partner['partner']);exit();*/

 foreach($transaction as $key=>$type){
 
    ?>
<tr>
    <td><?php echo $key+1;?></td>
    <td><?php echo $type['transaction_amount'];?></td>
    <td><?php echo $type['trans'];?></td>
    <td><?php echo $type['narration'];?></td>
</tr>
<?php } ?>

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


</body>

</html>