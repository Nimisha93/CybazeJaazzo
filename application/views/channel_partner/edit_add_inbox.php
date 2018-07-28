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
    Notifications
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
    <th>Title</th>
    <th>Description</th>
    <th>Date</th>
</tr>
</thead>

<tbody>

<?php foreach($notification as $key => $noti){?>
    <tr>
        <td class="titleclass"><input type="hidden" value="<?php echo $noti->id;?>" class="hiddentype_id">
            <?php echo $noti->title;?></td>
        <td class="descrip"><?php echo $noti->description;?></td>
        <td class="descrip"><?php echo date('d-m-Y',strtotime($noti->created_on));?></td>
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
<div id="notifications"></div><input type="hidden" id="position" value="center">
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

       
    });
</script>
</body>

</html>