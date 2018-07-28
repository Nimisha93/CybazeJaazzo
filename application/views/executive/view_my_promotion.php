 <?php echo $header; ?>
<body>
<div class="wrapper">

 <?php echo $sidebar; ?>

    <div class="content">
        <div class="container-fluid">

    </div>


        <div class="container-fluid">


            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title"> Module 1
                        </h4>

                    </div>

                    <div class="card-content">

                        <form method="#" action="#">



                            <div class="col-md-12">

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Count</label>
                                            <input type="text" class="form-control count1" name="count1">
                                            <span class="material-input"></span><span class="material-input"></span><span class="material-input"></span></div>

                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Amount</label>
                                            <input type="text" class="form-control promotion_amount1">
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Period</label>
                                            <input type="text" class="form-control promotion_period1" >
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                </div>
                            </div>

                           


                            <div class="col-md-12">
                           

                            </div>
                        </form>
                    </div>
                </div>
            </div>






        
                      
                        </form>
                    </div>
                </div>
            </div>




        </div>
        <?php echo $footer; ?>

        <link href="<?php echo base_url(); ?>assets/admin/css/sumoselect.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/admin/js/sumoslct.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
</body>
<script>
    $(document).on("change",".from",function(e) {
        e.preventDefault();
       
        var from = $(this).val();
       // alert(from);
        $.post('<?= base_url(); ?>admin/Executives/get_exec_to_data',{from:from },function(data)
        {
            if(data.status)
            {
                var opt = '';
                data = data.data.result.res;
                console.log(data);
                 for(var i = 0; i<data.length; i++)
                 {
                     opt += '<option value="'+data[i].id +'">'+data[i].designation +'</option>';
                 }
                 var sel = "";
                 sel += '<label>To Designation</label>'+
                        '<select>'+opt+'</select>';
                $('.to').html(sel);
            }
            else
            {
                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            }

        },'json');

    });
    </script>
    <script type="text/javascript">
    $("#view").click(function(e)
    {
       /* alert("dshgsh");*/
        e.preventDefault();
        var from = $('.from').val();
        var to = $('.to').val();
       
        var data= $("#desigination").serializeArray();
        $.post('<?= base_url(); ?>admin/Executives/get_promotion_view',{from:from ,to:to},function(data)
        {
            if(data.status)
            {

             data=data.data;
             
             var count1=data['promotion_count'];
             var count2=data['promotion_count2'];
             var count3=data['promotion_count3'];
             var promotion_period1=data['promotion_period'];
             var promotion_period2=data['promotion_period2'];
             var promotion_period3=data['promotion_period3'];
             var promotion_amount1=data['promotion_amount'];
             var promotion_amount2=data['promotion_amount2'];
             var promotion_amount3=data['promotion_amount3'];
             $('.count1').val(count1);
             $('.count2').val(count2);
             $('.count3').val(count3);
             $('.promotion_period1').val(promotion_period1);
             $('.promotion_period2').val(promotion_period2);
             $('.promotion_period3').val(promotion_period3);
             $('.promotion_amount1').val(promotion_amount1);
             $('.promotion_amount2').val(promotion_amount2);
             $('.promotion_amount3').val(promotion_amount3);
            }
            else
            {
                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            }

        },'json');

    });    
    </script>
</html>