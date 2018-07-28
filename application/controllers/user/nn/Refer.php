<?php
class Refer extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('user/refer_model'));
		$this->load->library(array('form_validation'));
		$this->load->helper(array('form', 'date'));
	}
function add_friend()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("mobile1", "Mobile ", "trim|required|htmlspecialchars");
            if( $this->form_validation->run() == TRUE )
            {
                $name = $this->input->post('name');
                $mail1 = $this->input->post('mail1');
                $mail2 = $this->input->post('mail2');
                $mob1 = $this->input->post('mobile1');
                $mob2 = $this->input->post('mobile2');
                $result = $this->refer_model->refer_validation($mail1,$mail2,$mob1,$mob2);
                if($result == 'bothtrue')
                {
                    $result1 = $this->refer_model->refer_exists($mail1,$mail2,$mob1,$mob2);
                    if($result1 == 'allok')
                    {
                            $result2 = $this->refer_model->refer($name,$mail1,$mail2,$mob1,$mob2,$lid);
                            if($result2==TRUE)
                            {   
                                $s=18;
                                $email = "maneeshakk16@gmail.com";
                                $mail_head = 'Message From Jaazzo';
                                $status = send_custom_email($email, $mail_head, $mail1, 'Add Friend', $this->load->view('templates/public/mail/add_friend_success','',TRUE));
                                exit(json_encode(array("status"=>TRUE)));
                            }elseif($result2==FALSE){ 
                                $s=19;
                            }
                    }elseif($result1 == 'allerror')
                    { $s=20;
                        // echo "bot mails & mobnos exists"; exit();
                    }
                    elseif($result1 == '1')
                    { $s=21;
                        // echo "mail1 exists"; exit();
                    }
                    elseif($result1 == '2')
                    { $s=22;
                        // echo "mail2 exists"; exit();
                    }
                    elseif($result1 == '3')
                    { $s=23;
                        // echo "mob1 exists"; exit();
                    }   
                    elseif($result1 == '4')
                    { $s=24;   
                        // echo "mob2 exists"; exit();
                    }
                    elseif($result1 == '5')
                    { $s=25;   
                        // echo "mail1&2 exists"; exit();
                    }
                    elseif($result1 == '6')
                    { $s=26;   
                        // echo "mob1&2 exists"; exit();
                    }
                    elseif($result1 == '7')
                    { $s=27;   
                        // echo "mail1&mob1 exists"; exit();
                    }
                    elseif($result1 == '8')
                    { $s=28;   
                        // echo "mail1&mob2 exists"; exit();
                    }
                    elseif($result1 == '9')
                    { $s=29;   
                        // echo "mail2&mob1 exists"; exit();
                    }
                    elseif($result1 == '10')
                    { $s=30;   
                        // echo "mail2&mob2 exists"; exit();
                    }
                    elseif($result1 == '11')
                    { $s=31;   
                        // echo "both mails & mob1 exists exists"; exit();
                    }
                    elseif($result1 == '12')
                    { $s=32;   
                        // echo "both mails & mob2 exists exists"; exit();
                    }
                    elseif($result1 == '13')
                    { $s=33;   
                        // echo "both mobnos & mail1 exists exists"; exit();
                    }
                    elseif($result1 == '14')
                    { $s=34;   
                        // echo "both mobnos & mail2 exists exists"; exit();
                    }
                }elseif($result == 'bothfalse' )
                    { $s=35;
                    // echo "bothfalse"; exit();
                    }
                    elseif($result == 'mobfalse' )
                    { $s=36; 
                    // echo "mobfalse"; exit();
                    }
                    elseif($result == 'mailfalse' )
                    { $s=37; 
                    // echo "mailfalse"; exit();
                    }
                    elseif($result == 'bothsame' )
                    { $s=38; 
                    // echo "mailfalse"; exit();
                    }
                    elseif($result == 'mobsame' )
                    { $s=39; 
                    // echo "mailfalse"; exit();
                    }
                    elseif($result == 'mailsame' )
                    { $s=40; 
                    // echo "mailfalse"; exit();
                    }
                    else
                    { $s=$s+1; print_r($result); exit(); } 
                    }
                if($s==19){ exit(json_encode(array('status'=> False,"reason"=>"Unsuccess"))); }
                elseif($s==20){ exit(json_encode(array('status'=> False,"reason"=>"Both Mail ids & Mobile numbers Exists"))); }
                elseif($s==21){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 1 Exists"))); }
                elseif($s==22){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 2 Exists"))); }
                elseif($s==23){ exit(json_encode(array('status'=> False,"reason"=>"Mobile number 1 Exists"))); }
                elseif($s==24){ exit(json_encode(array('status'=> False,"reason"=>"Mobile number 2 Exists"))); }
                elseif($s==25){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 1 & 2 Exists"))); }
                elseif($s==26){ exit(json_encode(array('status'=> False,"reason"=>"Mobile number 1 & 2 Exists"))); }
                elseif($s==27){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 1 & Mobile number 1 Exists"))); }
                elseif($s==28){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 1 & Mobile number 2 Exists"))); }
                elseif($s==29){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 2 & Mobile number 1 Exists"))); }
                elseif($s==30){ exit(json_encode(array("status"=> FALSE,"reason"=>"Mail id 2 & Mobile number 2 Exists"))); }
                elseif($s==31){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Email ids & Mobile number 1 Exists"))); }    
                elseif($s==32){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Email ids & Mobile number 2 Exists"))); }    
                elseif($s==33){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Mobile numbers & Email id 1 Exists"))); }    
                elseif($s==34){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Mobile numbers & Email id 2 Exists"))); }    
                elseif($s==35){ exit(json_encode(array("status"=> FALSE,"reason"=>"Invalid Email & Mobile Format"))); }    
                elseif($s==36){ exit(json_encode(array("status"=> FALSE,"reason"=>"Invalid Mobile Format"))); }    
                elseif($s==37){ exit(json_encode(array("status"=> FALSE,"reason"=>"Invalid Email Format"))); }    
                elseif($s==38){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Mails & Mobiles are same"))); }    
                elseif($s==39){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Mobiles are same"))); }    
                elseif($s==40){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Mails are same"))); }    
            }else{  
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }               
        }
        else{
            show_error("We are unable to process this request on this way!");   
        }
    }
function add()
{
       $session_array = $this->session->userdata('logged_in_user');
			if(isset($session_array))
			{
			$lid = $session_array['id'];
			    if($this->input->is_ajax_request())
			 	{ 
                    // $s=1;                                    
                // $this->form_validation->set_rules("name", "Name ", "trim|required|htmlspecialchars");
                 //$this->form_validation->set_rules("mail1", "Email id ", "trim|required|htmlspecialchars");
                 //$this->form_validation->set_rules("mail2", "Alt Email id", "trim|required|htmlspecialchars");
                 $this->form_validation->set_rules("mobile1", "Mobile ", "trim|required|htmlspecialchars");
                 //$this->form_validation->set_rules("mobile2", "Alt Mobile ", "trim|required|htmlspecialchars");
                    if($this->form_validation->run()== TRUE)
                    { 
                    // $s=$s+1;
                    $name = $this->input->post('name');
                    $mail1 = $this->input->post('mail1');
                    $mail2 = $this->input->post('mail2');
                    $mob1 = $this->input->post('mobile1');
                    $mob2 = $this->input->post('mobile2');
                    // print_r($name);print_r($mail1);print_r($mail2);print_r($mob1);print_r($mob2); exit();
                        $result = $this->refer_model->refer_validation($mail1,$mail2,$mob1,$mob2);
                        // $s=$s+1;
                    	if($result == 'bothtrue')
						{
                        // exit(json_encode(array("status"=>TRUE)));
                        // echo "1"; exit();
                        // $mail1='s@z.s45';$mail2='s@z.q';$mob1='24';$mob2='287';
                        $result1 = $this->refer_model->refer_exists($mail1,$mail2,$mob1,$mob2);
                            if($result1 == 'allok')
                                {
                                    // echo "do"; exit();
                                    $result2 = $this->refer_model->refer($name,$mail1,$mail2,$mob1,$mob2,$lid);
                                                    $ci = get_instance();
                                                    $ci->load->library('email');
                                                    $config['protocol'] = "smtp";
                                                    $config['smtp_host'] = "ssl://smtp.gmail.com";
                                                    $config['smtp_port'] = "465";
                                                    $config['smtp_user'] = 'pranavpk.pk1@gmail.com';
                                                    $config['smtp_pass'] = '9544146763';
                                                    $config['charset'] = "utf-8";
                                                    $config['mailtype'] = "html";
                                                    $config['newline'] = "\r\n";
                                                    $ci->email->initialize($config);
                                                    $ci->email->from('vyshakh007monu@gmail.com', 'Green');
                                                    $ci->email->to($mail1);
                                                    $this->email->reply_to('vyshakh007monu@gmail.com', 'Green');
                                                    $ci->email->subject('Green India Refferel');
                                                    // $ci->email->message('A Green India Club Member has been refered you, please register at http://localhost/green/index.php/home ');
                                                    $ci->email->message('
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
@charset "utf-8";
/* CSS Document */
body{
    background-color:#f2f2f2;
    margin:0;
    padding:0;
    font-family:Arial;
    color:#999;
    }
h3 {
    margin:10px 35px;
    }   
#main_body{
    /* height: 700px; */
    /* width: 60%; */
    padding: 0px 0px 65px 0px;
    background-color: #fff;
    float: left;
    margin: 2% 20%;
    }   
.line{
    height:1px;
    width:100%;
    background-color:#f2f2f2;
    float:left;
    margin: 0px 3%;
    }   
.admin{
    height:80px;
    width:100%;
    background-color:;} 
h5{
    margin:0;}  
.to{
    font-size:12px;
    font-style:normal;} 
.scnd_main{
    font-size: 13px;
    padding: 1px 20px;
    width: 78%;
    margin: 70px 70px 0px;
    line-height: 17px;
    border-top: 0;
    clear: both;
    background-color: #f2f2f2;
}   
.log_box{
    padding: 0px 0px 0px 37%;
    width:100%;
    background-color:;
    float:left;}
.log_box img{
    margin:17px 0px;}       
.txt_box{
    background: #fff;
    color: #5b5b5b;
    border-radius: 4px;
    font-family: arial;
    font-size: 13px;
    padding: 5px 20px 15px 20px;
    width: 90%;
    margin: 20px auto;
    line-height: 20px;
    border: 1px #ddd solid;
    border-top: 0;
    clear: both;}   
.color{
    background-color:#06306c;
    padding: 1px 20px;  
    }   
.color p{
    color:#fff;
    text-align:center;}  
.social_media{
    padding: 5px 0px 45px 37%;
    background-color:;} 
.fb{
    height:40px;
    width:40px;
    border-radius:100%;
    background-color:;
    float:left;
    margin:0px 5px;}    
.gift{
    height: 105px;
    width: 150px;
    float: left;
    margin: 0px 30px 10px 6px;
    }
.offr_link{
    font-size:18px;
    }
.offr_link a:visited{
    color:#06306c;
    text-decoration:none;
    }
.offr_link a:hover{
    color:#06306c;
    text-decoration:none;
    }   
</style>
</head>
<body>
    <div id="main_body">
        <div class="scnd_main">
            <div class="log_box">
                <img src="<?= base_url();?>assets/img/online-portal-logo.png" />
            </div>
            <div class="txt_box">
                <p>Hi '.$name.'</p>
                <p>Thanks for ordering automatic! You are on your way to driving smarter.</p>
                <div class="gift">
                    <img src="<?= base_url();?>assets/img/gift.png" width="115px" style="margin:0px 18px;" />
                </div>
                <p>want to get $20 back? share the url below with your friends and family. when one of them buys Automatic Youll Get $20 Credited to Your               accound.</p>
                <p class="offr_link"><a href="#">http://fbuy.me/xlrB</a></p>
                <p>Since any friend of yours is  a friend of ours, your friend will get 20% off their order. Share today, this offer is only good for a 
                limited time. </p>
                <div class="social_media">
                    <div class="fb">
                        <a href="#"><img src="<?= base_url();?>assets/img/fb.png" height="40px" /></a>
                    </div>
                    <div class="fb">
                        <a href="#"><img src="<?= base_url();?>assets/img/twtr.png" height="40px" /></a>
                    </div>
                    <div class="fb">
                        <a href="#"><img src="<?= base_url();?>assets/img/gpls.png" height="40px" /></a>
                    </div>
                </div>
            </div>
            <div class="txt_box color">
                <p>www.greenindia.com</p>
            </div>
            </div>
        </div>
</body>
</html>');
                                    $ci->email->send();
                                    
                                    if($result2==TRUE)
                                    { $s=18;
                                    exit(json_encode(array("status"=>TRUE)));
                                    // echo "success"; exit(); 
                                    }
                                    elseif($result2==FALSE)
                                    { $s=19;
                                    // echo "unsuccess"; exit(); 
                                    }
                                }
                                elseif($result1 == 'allerror')
                                        { $s=20;
                                            // echo "bot mails & mobnos exists"; exit();
                                        }
                                        elseif($result1 == '1')
                                        { $s=21;
                                            // echo "mail1 exists"; exit();
                                        }
                                        elseif($result1 == '2')
                                        { $s=22;
                                            // echo "mail2 exists"; exit();
                                        }
                                        elseif($result1 == '3')
                                        { $s=23;
                                            // echo "mob1 exists"; exit();
                                        }   
                                        elseif($result1 == '4')
                                        { $s=24;   
                                            // echo "mob2 exists"; exit();
                                        }
                                        elseif($result1 == '5')
                                        { $s=25;   
                                            // echo "mail1&2 exists"; exit();
                                        }
                                        elseif($result1 == '6')
                                        { $s=26;   
                                            // echo "mob1&2 exists"; exit();
                                        }
                                        elseif($result1 == '7')
                                        { $s=27;   
                                            // echo "mail1&mob1 exists"; exit();
                                        }
                                        elseif($result1 == '8')
                                        { $s=28;   
                                            // echo "mail1&mob2 exists"; exit();
                                        }
                                        elseif($result1 == '9')
                                        { $s=29;   
                                            // echo "mail2&mob1 exists"; exit();
                                        }
                                        elseif($result1 == '10')
                                        { $s=30;   
                                            // echo "mail2&mob2 exists"; exit();
                                        }
                                        elseif($result1 == '11')
                                        { $s=31;   
                                            // echo "both mails & mob1 exists exists"; exit();
                                        }
                                        elseif($result1 == '12')
                                        { $s=32;   
                                            // echo "both mails & mob2 exists exists"; exit();
                                        }
                                        elseif($result1 == '13')
                                        { $s=33;   
                                            // echo "both mobnos & mail1 exists exists"; exit();
                                        }
                                        elseif($result1 == '14')
                                        { $s=34;   
                                            // echo "both mobnos & mail2 exists exists"; exit();
                                        }
                        }
						elseif($result == 'bothfalse' )
						    { $s=35;
                            // echo "bothfalse"; exit();
						    }
							elseif($result == 'mobfalse' )
                                { $s=36; 
                                // echo "mobfalse"; exit();
                                }
                                elseif($result == 'mailfalse' )
                                    { $s=37; 
                                    // echo "mailfalse"; exit();
                                    }
                                    elseif($result == 'bothsame' )
                                        { $s=38; 
                                        // echo "mailfalse"; exit();
                                        }
                                        elseif($result == 'mobsame' )
                                            { $s=39; 
                                            // echo "mailfalse"; exit();
                                            }
                                            elseif($result == 'mailsame' )
                                                { $s=40; 
                                                // echo "mailfalse"; exit();
                                                }
                                                else
                                                    { $s=$s+1; print_r($result); exit(); } 
					}
			        else
			         	{	
			         		$s=41;
		 		        // exit(json_encode(array("status"=>FALSE,"reason"=>"form val eror")));
			            }   				
                }
                else
                {	
                $s=42;
		 		// exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			    }
                                if($s==19){ exit(json_encode(array('status'=> False,"reason"=>"Unsuccess"))); }
                            elseif($s==20){ exit(json_encode(array('status'=> False,"reason"=>"Both Mail ids & Mobile numbers Exists"))); }
                            elseif($s==21){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 1 Exists"))); }
                            elseif($s==22){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 2 Exists"))); }
                            elseif($s==23){ exit(json_encode(array('status'=> False,"reason"=>"Mobile number 1 Exists"))); }
                            elseif($s==24){ exit(json_encode(array('status'=> False,"reason"=>"Mobile number 2 Exists"))); }
                            elseif($s==25){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 1 & 2 Exists"))); }
                            elseif($s==26){ exit(json_encode(array('status'=> False,"reason"=>"Mobile number 1 & 2 Exists"))); }
                            elseif($s==27){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 1 & Mobile number 1 Exists"))); }
                            elseif($s==28){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 1 & Mobile number 2 Exists"))); }
                            elseif($s==29){ exit(json_encode(array('status'=> False,"reason"=>"Mail id 2 & Mobile number 1 Exists"))); }
                            elseif($s==30){ exit(json_encode(array("status"=> FALSE,"reason"=>"Mail id 2 & Mobile number 2 Exists"))); }
					        elseif($s==31){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Email ids & Mobile number 1 Exists"))); }    
                            elseif($s==32){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Email ids & Mobile number 2 Exists"))); }    
                            elseif($s==33){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Mobile numbers & Email id 1 Exists"))); }    
                            elseif($s==34){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Mobile numbers & Email id 2 Exists"))); }    
                            elseif($s==35){ exit(json_encode(array("status"=> FALSE,"reason"=>"Invalid Email & Mobile Format"))); }    
                            elseif($s==36){ exit(json_encode(array("status"=> FALSE,"reason"=>"Invalid Mobile Format"))); }    
                            elseif($s==37){ exit(json_encode(array("status"=> FALSE,"reason"=>"Invalid Email Format"))); }    
                            elseif($s==38){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Mails & Mobiles are same"))); }    
                            elseif($s==39){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Mobiles are same"))); }    
                            elseif($s==40){ exit(json_encode(array("status"=> FALSE,"reason"=>"Both Mails are same"))); }    
                            elseif($s==41){ exit(json_encode(array("status"=> FALSE,"reason"=>"Form Validation Error"))); }    
                            elseif($s==42){ exit(json_encode(array("status"=> FALSE,"reason"=>"Validation Error"))); }    
                            else{ exit(json_encode(array("status"=>FALSE,"reason"=>".$result.Hai.$s."))); }    
            }
}

function transfer_amount()
{
       $session_array = $this->session->userdata('logged_in_user');
		if(isset($session_array)){
			 $login_id = $session_array['id'];

			 if($this->input->is_ajax_request()){

                 $this->form_validation->set_rules("transfer_mobile", "Mobile ", "trim|required|htmlspecialchars");
                 $this->form_validation->set_rules("transfer_amount", "Amount", "trim|required|htmlspecialchars");
         

                 if($this->form_validation->run()== TRUE){

                     $reg_phone =  $this->input->post('transfer_mobile');
                         $reg_amount =  $this->input->post('transfer_amount');
					 $transfer_phone = $this->user_model->transfer_phone($reg_phone);
                         if($transfer_phone==TRUE){
                         	 $userid=$transfer_phone['id'];
                               $wallet_res = $this->user_model->transfer_amount($userid,$reg_amount,$login_id );     
                                	if($wallet_res==TRUE){
					                    exit(json_encode(array("status"=>TRUE)));
					                }
					                else{

					                    exit(json_encode(array("status"=>FALSE,"reason"=>"less amount")));
					                }     			  
				            }
			              else{	
		 		          exit(json_encode(array("status"=>FALSE,"reason"=>"Mobile doesnt exist")));
			              }				
                  }
                  else{	
		 		          exit(json_encode(array("status"=>FALSE,"reason"=>"validation_errors()")));
			       }	

                }
           

         }

     }
   

 }






?>