<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php echo $header; ?>
<link href="<?php echo base_url();?>assets/admin/css/offer_style.css" rel="stylesheet">


<style type="text/css">
    @charset "utf-8";
/* CSS Document */
body {
    margin: 0;
    padding: 0;
    background-color: #FAFAFA;
    font: 10pt "arial";
    
}
* {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}
.page {
    width: 21cm;
    min-height: 29.7cm;
    padding:70px;
    margin: 1cm auto;
    background: white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.adrss {
    margin-bottom: 50px ;
}

.brdr_fl{
    border-left:1px solid;
}
tr{
    width:100%;
    border-bottom: 1px solid;
    }
td{
        padding: 2px;
    border-left: 1px solid;
    border-collapse: collapse;
    }
table {
    font-size: 14px;    
    border-collapse: collapse;
}
.head {
    width: 100%;
    height: 500px;
    float: left;
    /*border: 1px solid;*/
}   
.sub_page{
    height:auto;
    width:100%;
    /*background-color:#f2f2f2;
    border:1px solid;
    border-radius: 10px; 
    padding: 10px;*/
    float:left;}

.adrss {
    margin-bottom: 70px ;
}
.content {
    line-height: 19px;
}















@page {
    size: A4;
    margin: 0;
}
@media print {
    .page {
        margin: 0;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
    }

}
</style>
<body>
                     <?php 
                     $basic_salary=$employee_details['salary'];
                     $annul= $basic_salary*12;
                     $date_of_join=$employee_details['join_date'];
                     $join_date= date("jS M Y", strtotime($date_of_join));
                      //echo jSMY($date_of_join);

                     ?>


 <button  target="_blank" class="btn btn-primary" style="background-color: white !important;
    width: 81px;
    height: 40px;
       color: black;" onclick="printDiv('html-content-holder')(this.id)" >Print</button>
<button class="btn btn-primary " onclick="goBack()" style="background-color: white !important;width: 81px;height: 40px;color: black;" " >Back</button>

 <!--==============================STRT FIRST PAGE==============================================--> 
<div id="html-content-holder">
<div class="wrapper">
<div class="book">
    <div class="page">

    	<div class="sub_page">
        
        	<div class="head">
        		
                <div class="adrss">
                    <p>FM/HR/JJ/01-2017</p>
                    
                    <p>Dated  <?php echo date("d/m/Y");?></p>

                    <p>Mr/Mrs.<?= $employee_details['name'];?><br>
                        <?php $add=$employee_details['address'];
                           
                           $address= (explode(",",$add));
                            
                             echo $address[0];
                          
                            ?>
                         <br>
                        <?php $add=$employee_details['address'];
                           
                           $address= (explode(",",$add));
                            
                             echo empty($row->name) ? '' :$address[1];
                            ?>

                        <br>
                      
                    </p>

                </div>

                <h4 style="font-weight: 600; text-align: center;margin-bottom: 0;">OFFER LETTER</h4>
                
                <div class="content">
                    <p style="margin-top: 0;">Dear Mr/Mrs. <?= $employee_details['name'];?>,</p>
                    <p>This letter is in response to the interview held with you at The Jazzo on <?= $join_date;?>.  We offer you the post of  <?= $employee_details['desig'];?>  at  <?= $employee_details['branch'];?> H.Q.     on the following CTC.
                    </p>

                    <p style="font-weight: bold; margin: 40px 0">CTC ANNUALLY:    Rs <?= $annul;?>/=    <br>
                        Take Home Salary:   Rs. <?= $employee_details['salary'];?>/=
                    </p>

                    <p style="margin-bottom: 30px;">Annual CTC shown above will include your  bonus of Rs.7000/=, Leave Travel 
allowance of Rs.20,000/= (both will be paid annually) and employer’s contribution 
towards EPF.  EPF will be coming into effect, after six months of employment. </p>

                    <p>You will be eligible for the following Field Allowance per Field Working day:</p>

                    <p style="margin: 0 0 60px 40px ;">Head quarter & Ex-Headquarter work Allowance: Rs300.00 & 350.00
Out Station work Allowance: Rs. 750.00 on transit day..
Travelling Allowance: Rs.2.30 / KM</p>

                    <!-- <p style="margin-bottom: 80px;">You will be responsible to maintain and to lead a team of Territory Business Officers in the
Trivandrum,Kollam,Pathanamthitta head quarters and bring successful sales performance as
per the sales objectives given in time, as per company needs.  
Also, you should stay in your work head quarter of Kozhikode.  Within 15 days from the date
of joining you should give the details of your work head quarter residence address details to
HO.</p> -->

                    <p>As a token of your acceptance, you may sign the copy of the offer letter and submit the
details the asked in this letter.  On receipt of the same, we will be issuing your appointment​
letter.</p>



                </div>



        	</div>
            
        </div>
    </div>
    
    </div>
    
    
 <!--==============================END FIRST PAGE==============================================-->   





 <!--==============================STRT second PAGE==============================================--> 
<div class="book">
    <div class="page">
        <div class="sub_page">
        
            <div class="head">
                
                

                <div class="content">
                    

                    <p style="font-weight: bold; margin: 20px 0">You will be required to submit the following documents:
                    </p>

                    <p style="margin: 0 0 0px 40px ;">
                        1. Signed offer letter,<br>
                        1. 3 Passport size photographs,<br>
                        2. Photocopies of Educational Certificates,<br>
                        3. Photocopy of Driving License,<br>
                        4. Photocopies of Address Proof, Age proof<br>
                        5. Photocopy of Pan card, Aadhar Card<br>
                        6. Previous companies Appointment letter,<br>
                        7. Previous Companies Last Salary Slip,<br>
                        8. Copy of resignation to Previous Company & Relieving letter<br>
                        9. Cancelled Cheque<br>
                        10. Application form duly filled.</p>

                    <p>Thanking you,</p>

                    <p>For Jazzo.</p>
                    
                    <p>Chief Executive Officer.   
I accept the post of <?= $employee_details['desig'];?>  in the terms of monthly salary and other
terms of payment and job profile noted above.</p><br>
<?= $employee_details['name'];?>






                </div>



            </div>
            
        </div>
    </div>
    
    </div>
    
    
 <!--==============================END second PAGE==============================================-->   

</div>
</div>

</div>
    <script type="text/javascript">


        function printDiv(divName)
        {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }


    </script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
