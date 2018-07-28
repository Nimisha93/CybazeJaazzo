<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Salary Slip</title>
    <link href="<?php echo base_url();?>style/images/fav.png" rel="shortcut icon">

    <link href="style.css" rel="stylesheet"type="text/css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

    <script type="text/javascript">





        function printDiv(divName)

        {

            var printContents = document.getElementById(divName).innerHTML;

            var originalContents = document.body.innerHTML;



            document.body.innerHTML = printContents;



            window.print();



            document.body.innerHTML = originalContents;

        }
        
           function nWin() {

      


 document.getElementById('print').style.display = 'none';

//        var originalTitle = document.title;
//        document.title = "Print page title";
        var divToPrint=document.getElementById("html-content-holder");
        newWin= window.open("");

        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
        document.getElementById('print').style.display = 'block';

    }
        $(function() {
        $("a#print").click(nWin);
    });






    </script>

    <script>

        function goBack() {

            window.history.back();

        }

    </script>

<style type="text/css">

    /*@charset "utf-8";*/

    /* CSS Document */

    body{



        margin: 0;

        font-family:Arial, Helvetica, sans-serif;}



    .wrapper{

        width:21cm;

        height:29.7cm;

        margin:50px auto;

        border:1px solid #000;

    }

    .wrapper_inner_body{

        padding: 20px;}



    h4, h6{

        margin:0;

        font-weight:bold;

        text-align:center;}



    table{

        width:100%;

        border:1px solid;

        border-collapse:collapse;}



    td, th{

        padding:5px;

        border:1px solid;
    vertical-align: top;
    }



    .lft_tbl{

        width: 55%;

        padding: 18px 18px 0 0;

        float: left;}

    .rght_tbl{

        width: 35%;

        padding: 18px 0 0px 57px;

        float: left;

    }





    .brdr_none{

        border:none;}



    .tble_body {

        height: 300px;

        width: 100%;

    }

    .line {

        width: 100%;

        background-color: #000;

        height: 1px;

        margin: 10px 0 10px 0;

    }

    .header {

        line-height: 4px;

        height: auto;

        font-size: 14px;

        width: 100%;

        border-bottom: 1px solid;

        margin-bottom: 10px;

    }

</style>

</head>



<body>


<div id="html-content-holder">

 
   <div class="col-md-3"  style="padding-top: 19px;
    margin-top: 10px;
    padding-left: 26px;">    
<a href="javascript:;" id="print"  style="background-color: #204d74;
    width: 81px;
    height: 40px;
       color: white;padding-left: 24px;
    padding-top: 13px; padding-right: 25px;
    padding-bottom: 13px;" class="btn btn-success pull-right" ><i class="fa fa-print" aria-hidden="true"></i>Print</a>
       </div>

<style type="text/css">

    /*@charset "utf-8";*/

    /* CSS Document */

    body{



        margin: 0;

        font-family:Arial, Helvetica, sans-serif;}



    .wrapper{

        width:21cm;

        height:29.7cm;

        margin:50px auto;

        border:1px solid #000;

    }

    .wrapper_inner_body{

        padding: 20px;}



    h4, h6{

        margin:0;

        font-weight:bold;

        text-align:center;}



    table{

        width:100%;

        border:1px solid;

        border-collapse:collapse;}



    td, th{

        padding:5px;

        border:1px solid}



    .lft_tbl{

        width: 55%;

        padding: 18px 18px 0 0;

        float: left; vertical-align: top;}

    .rght_tbl{

        width: 35%;

        padding: 18px 0 0px 57px;

        float: left;

    }





    .brdr_none{

        border:none;}



    .tble_body {

        height: 300px;

        width: 100%;

    }

    .line {

        width: 100%;

        background-color: #000;

        height: 1px;

        margin: 10px 0 10px 0;

    }

    .header {

        line-height: 4px;

        height: auto;

        font-size: 14px;

        width: 100%;

        border-bottom: 1px solid;

        margin-bottom: 10px;

    }
@media print{

    td, th{
    vertical-align: top;
        font-size: 14px;;
    }


}
</style>

<div class="wrapper" style="height: 24.7cm;">



    <div class="wrapper_inner_body">







        <div class="header">

            <p>JAAZZO</p>
<!--             <p>PPXIV 430&431 CASAMARINA COMPLEX TALAP</p>
 -->            <p> CALICUT</p>
            <p>356376778578 </p>

        </div>

<?php 
 $other_deduction = 0;$loss_of_pay = 0;$advance_salary = 0;$other_allowance = 0; $other_deduction = 0;
 $ta=0;$da=0;$hra=0;$add_ta=0;$bonus=0;$hq_allowance=0;$ex_hq_allowance=0;
 $outdoor_allowance=0;$pf=0;$cpf=0;$incentive=0;$insurance=0;$esi=0;
 foreach ($salary['other'] as $key => $value) {
 if($value['title'] == 'ADVANCE_SALARY')
   {
    $advance_salary = $value['amount_value'];
    //var_dump($advance_salary);exit();

   }
   if($value['title'] == 'INCENTIVE')
   {
    $incentive = $value['amount_value'];


   }

    if($value['title'] == 'BONUS')
   {
    $bonus = $value['amount_value'];
   
    

   }
   if($value['title'] == 'OTHER')
   {
    $other_deduction = $value['amount_value'];
   }
   if($value['title'] == 'TA')
   {
    $ta = $value['amount_value'];
   }
   if($value['title'] == 'DA')
   {
    $da = $value['amount_value'];
   }
   if($value['title'] == 'HRA')
   {
    $hra = $value['amount_value'];
   }
   if($value['title'] == 'ADDITIONAL_TA')
   {
    $add_ta = $value['amount_value'];
   }
    if($value['title'] == 'INSURANCE')
   {
    $insurance = $value['amount_value'];
   }
    if($value['title'] == 'HEADQAURTER_ALLOWANCE')
   {
    $hq_allowance = $value['amount_value'];
   }
    if($value['title'] == 'OUTDOOR_ALLOWANCE')
   {
    $outdoor_allowance = $value['amount_value'];
   }
    if($value['title'] == 'OTHER_ALLOWANCE')
   {
    $other_allowance = $value['amount_value'];
   }
    if($value['title'] == 'EX_HEADQAURTER_ALLOWANCE')
   {
    $ex_hq_allowance = $value['amount_value'];
   }
   if($value['title'] == 'LOP')
   {
    $loss_of_pay = $value['amount_value'];//var_dump($loss_of_pay);exit();
   }

    if($value['title'] == 'PF_EMPLOYEE')
   {
    $pf = $value['amount_value'];
       
     }

   if($value['title'] == 'PF_COMPANY')
   {
    $cpf = $value['amount_value'];
   
   }
  // var_dump($f1);var_dump($f2);exit;

   if($value['title'] == 'ESI')
   {
    $esi = $value['amount_value'];
    
       }
 }
 $gross_earning = $bonus+$ta+$da+$hra+$add_ta+$hq_allowance+$outdoor_allowance+$other_allowance+$incentive+$ex_hq_allowance;
 $gross_deduction = $advance_salary+$other_deduction+$insurance+$loss_of_pay+$pf+$esi;
 $date=$salary['basic'][0]['from_date'];
 $paid_date=$salary['basic'][0]['paid_date'];
 $date2=convert_ui_date($date);
 $p_date2=convert_ui_date($paid_date);
 //echo $date2;
 echo $p_date2;                                          
 $dt = $salary['basic'][0]['from_date'];
 $time=strtotime($dt);

 $month=date("F",$time);

 $year1=date("Y",$time);
 $allowed_leave = $salary['basic'][0]['allowed_leaves'];
 $total_leave = $salary['basic'][0]['total_leaves'];
 $total_workingdays = $salary['basic'][0]['total_workingdays'];
 $leave = $allowed_leave - $total_leave;
 $net_leave = $leave < 0 ? ($total_workingdays + $leave ) : ($total_workingdays - $leave );
 
    
?>


        <table class="brdr_none">

            <tr>

                <td class="brdr_none" style="padding:0; font-size:28px;"><h4>SALARY ADVICE</h4></td>

            </tr>

            <tr>

                <td class="brdr_none" style="padding:0; font-size:25px;"><h6><?= $month; ?>&nbsp;<?= $year1; ?></h6></td>

            </tr>

        </table>





        <table style="margin: 20px 0 10px 0;" class="brdr_none">

            <tr>

                <td class="brdr_none" style="width: 11%;">Staff Code</td>

                <td class="brdr_none"><b>: <?php echo $salary['basic'][0]['employee_code'];?></b></td>



                <td class="brdr_none" style="width: 12%;">Designation</td>

                <td class="brdr_none"><b>: <?php echo $salary['basic'][0]['designation']; ?></b></td>



                <td class="brdr_none" style="width: 8%;    padding-left: 0px;">Bank Name</td>

                <td class="brdr_none" style="width: 12%;"><b>:<?php echo $salary['basic'][0]['bank_name'];?></b></td>

            </tr>

            <tr>

                <td class="brdr_none">Name</td>

                <td class="brdr_none" style="width: 20%;"><b>: <?php echo $salary['basic'][0]['name'];?></b></td>



                <td class="brdr_none">Basic Salary</td>

                <td class="brdr_none" style="width: 20%;"><b>: <?php echo $salary['basic'][0]['basic_pay'];?></b></td>



                <td class="brdr_none">Account</td>

                <td class="brdr_none"><b>: <?php echo $salary['basic'][0]['bank_ac_no'];?></b></td>

            </tr>

        </table>



        <div class="tble_body">



            <div class="lft_tbl">

                <table>

                    <tr>

                        <th style="    text-align: left;">Particulars</th>

                       
                        <th style="text-align: CENTER;">Amount</th>

                    </tr>
                  
                    <tr>
                        <td>Basic</td>
                        <td style="text-align: CENTER;"><b><?php echo $salary['basic'][0]['basic_pay'];?></b></td>
                    </tr>
                    
                   <?php if($ta!=0){ ?>
                    <tr>
                        <td>TA</td>
                        <td style="text-align: CENTER;"><b><?php echo $ta;?></b></td>
                    </tr>
                    <?php } ?>
                     <?php if($da!=0){ ?>
                    <tr>
                        <td>DA</td>
                        <td style="text-align: CENTER;"><b><?php echo $da;?></b></td>
                    </tr>
                    <?php } ?>
                     <?php if($hra!=0){ ?>
                    <tr>
                        <td>HRA</td>
                        <td style="text-align: CENTER;"><b><?php echo $hra;?></b></td>
                    </tr>
                    <?php } ?>
                     <?php if($bonus !=0){ ?>
                      <tr>
                        <td>BONUS</td>
                        <td style="text-align: CENTER;"><b><?php echo $bonus;?> </b></td>
                    </tr>
                    <?php } ?>
                     <?php if($hq_allowance!=0){ ?>
                    <tr>
                        <td>HEADQAURTER ALLOWANCE</td>
                        <td style="text-align: CENTER;"><b><?php echo $hq_allowance;?></b></td>
                    </tr>
                    <?php } ?>
                    <?php if($ex_hq_allowance !=0){ ?>
                    <tr>
                        <td>EX-HEADQAURTER ALLOWANCE</td>
                        <td style="text-align: CENTER;"><b><?php echo $ex_hq_allowance;?></b></td>
                    </tr>
                    <?php } ?>
                   <?php if($incentive !=0){ ?>
                    <tr>
                        <td>INCENTIVE</td>
                        <td style="text-align: CENTER;"><b><?php echo $incentive;?> </b></td>
                    </tr>
                    <?php } ?>
                    <?php if($other_allowance !=0){ ?>
                      <tr>
                        <td>OTHER ALLOWANCE</td>
                        <td style="text-align: CENTER;"><b><?php echo $other_allowance;?> </b></td>
                    </tr>
                    <?php } ?>
                    <?php if($add_ta !=0){ ?>
                      <tr>
                        <td>ADDITIONAL ALLOWANCE</td>
                        <td style="text-align: CENTER;"><b><?php echo $add_ta;?> </b></td>
                    </tr>
                    <?php } ?>
                    <?php if($outdoor_allowance !=0){ ?>
                      <tr>
                        <td>OUTDOOR ALLOWANCE</td>
                        <td style="text-align: CENTER;"><b><?php echo $outdoor_allowance;?> </b></td>
                    </tr>
                    <?php } ?>

                    


                </table>



            </div>



            <div class="rght_tbl">

                <table>

                    <tr>

                        <th style="    text-align: left;">Deductions</th>

                        <th>Amount</th>

                    </tr>
                   <?php if($advance_salary !=0){ ?>
                    <tr>
                        <td>Advance</td>
                        <td style="text-align: center;"><b><?php echo $advance_salary;?></b></td>
                    </tr>
                    <?php } ?>
                    <?php if($loss_of_pay !=0){ ?>
                    <tr>
                        <td>Lop</td>
                        <td style="text-align: center;"><b><?php echo $loss_of_pay;?></b></td>
                    </tr>
                    <?php } ?>
                    <?php if($pf !=0){ ?>
                     <tr>
                        <td>PF</td>
                        <td style="text-align: center;"><b><?php echo $pf;?></b></td>
                    </tr>
                    <?php } ?>
                    <?php if($esi !=0){ ?>
                     <tr>
                        <td>ESI</td>
                        <td style="text-align: center;"><b><?php echo $esi;?></b></td>
                    </tr>
                    <?php } ?>
                     <?php if($insurance !=0){ ?>
                    <tr>
                        <td>INSURANCE</td>
                        <td style="text-align: center;"><b><?php echo $insurance;?></b></td>
                    </tr>
                    <?php } ?>
                    <?php if($other_deduction !=0){ ?>
                    <tr>
                        <td>Others</td>
                        <td style="text-align: center;"><b><?php echo $other_deduction;?></b></td>
                    </tr>
                    <?php } ?>
                </table>

            </div>



        </div>



        <table class="brdr_none">

            <tr>

                <td class="brdr_none" style="width: ;">Gross Earning</td>

                <td class="brdr_none"><b>: <?php echo $gross_earning;?></b></td>



                <td class="brdr_none" style="width:;">Total Deductions</td>

                <td class="brdr_none"><b>: <?php echo $gross_deduction;?></b></td>



                <td class="brdr_none" style="">Net Salary Payable</td>

                <td class="brdr_none" style=""><b>: <?php echo $salary['basic'][0]['net_paid'];?></b></td>

            </tr>

            <tr>

                <td class="brdr_none">No. of Days Paid</td>

                <td class="brdr_none" style=""><b>: <?= $net_leave ?></b></td>



                <td class="brdr_none">Total Days</td>

                <td class="brdr_none" style=""><b>: <?php echo $salary['basic'][0]['total_workingdays'];?></b></td>



            </tr>

        </table>





        <table class="brdr_none">

            <tr>

                <td class="brdr_none" style="text-align:right; padding-top:20px;">Signature..................</td>

            </tr>

        </table>



        <div class="line"></div>















    </div>

</div>



</div>

</body>

</html>