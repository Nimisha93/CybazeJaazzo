<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Forgot_psw extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form','string'));
		$this->load->model('admin/Forgot_model');
    $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
	}





      public function forgot() {

        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/ex_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
         
   
   
        $this->load->view('admin/forgot',$data);

    }
    function forgot_password()
	{
			
			$username = $this->input->post('email');
			

				$validate_user = $this->Forgot_model->validate_user($username);
				
				if($validate_user){
					$password = random_string('alnum', 16);
				
					$update_password = $this->Forgot_model->update_password($password, $username);
					if($update_password){

            $message = '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:url(bg.jpg) repeat;"> <tbody>             
  <tr>
    <td align="center" valign="top">
      <table cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style=" background:#FFFFFF; border:1px solid #e3e3e3; border-radius: 3px; max-width:582px">    
        <tbody> 
          <tr>
            <td width="580" align="center" style="padding:5px;">
              <table border="0" cellpadding="0" cellspacing="0" align="center" style="max-width:570px;">
                <tbody>
                <tr>
                  <td align="center" valign="top">
                    <a href="http://exposoft.in/" style="display:block;">
                      <div style="width:100%"><img src="<?= base_url();?>assets/superadmin/dist/img/exposoft_logo.JPG" border="0" alt="" style="margin:0; display:block; max-width:570px; width:inherit" vspace="0" hspace="0" align="absmiddle">
                      </div>
                    </a>
                  </td>
                </tr>
                </tbody>
              </table>
            </td>    
          </tr>
      <tr>
        <td width="580" align="center" style="padding:15px;"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:540px;">
          <tbody>
            <tr bgcolor="#ffffff">
              <td width="540" align="left" style="font-size:14px; color:#333333; font-family: '.'Open Sans'.', Gill Sans, Arial, Helvetica, sans-serif;">Dear Customer,
                <br><br> We’re proud to annly change the way you hire. Exciting, isn’t it?<br><br>Your Bill details are given in the pdf attached with.

                </td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      
      
      <tr>
        <td width="580" align="center" style="padding:15px;"><table border="0" cellpadding="0" cellspacing="0" align="center" style="max-width:550px;">
          <tbody>
           <tr>
            <td width="550" style=" font-weight:bold;  font-size:15px; padding:5px 0px; font-family: '.'Open Sans'.', Gill Sans, Arial, Helvetica, sans-serif; text-align:left; "><a href="" style=" color:#0082c8; text-decoration:none;">Your User Details </a></td>
          </tr>
          <tr>
            <td width="550" style=" color:#333333; font-size:12px;  font-family: "Open Sans", Gill Sans, Arial, Helvetica, sans-serif; padding:5px 0px;">
              Username : '.$userna.' <br/>
              Password : '.$password.'
            </td>
          </tr>
          
          </tbody></table></td>
      </tr>
      
      
      <tr>
        <td width="580" align="center" style="padding:15px;"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:550px;">
          <tbody>
            <tr bgcolor="#ffffff">
              <td width="540" align="left" style=" font-size:14px; color:#333333; font-family: '.'Open Sans'.', Gill Sans, Arial, Helvetica, sans-serif;">If you’ve got any questions for us, drop us a note at <a href="mailto:info@exposoft.in" style="  color:#008BCF; text-decoration:none;" target="_blank">info@exposoft.in</a>. or call us on <a style="color:#008bcf; text-decoration:none;" href="tel:+91-9946259099">+91-9349208864</a>(Mon to Sat, 9 am to 6 pm). <br><br>Name<br>
                Team Exposoft</td>
              </tr>
              <tr>
          <td height="20"></td>
        </tr>
              <tr>
          <td align="center" style="font-size:11px; font-family: Helvetica,Arial,sans-serif;"><p style="margin:0;padding:3px 0 0px; font-size:11px; font-family: Helvetica,Arial,sans-serif; line-height:13px;">You are receiving this mail from Exposoft Solutions.  </p>
            <p style="margin:0;padding:3px 0 3px; font-size:11px; font-family: Helvetica,Arial,sans-serif;  line-height:13px;">For any assistance, visit our <a href="http://exposoft.in/" style=" font-size:11px; font-family: Helvetica,Arial,sans-serif; color:#008BCF;text-decoration:none;" target="_blank">Help center</a> or write to us at <a href="mailto:info@exposoft.in" style=" font-size:11px; font-family: Helvetica,Arial,sans-serif; color:#008BCF;text-decoration:none;" target="_blank">info@exposoft.in</a></p></td>
        </tr>
        <tr>
          <td align="center" style=" line-height:13px; font-size:11px; font-family: Helvetica,Arial,sans-serif; color:#008BCF; padding-bottom:10px;">  <a href="http://exposoft.in/" target="_blank" style="color:#0082c8; text-decoration:none;">exposoft.in/</a>
          </td>
        </tr>
            </tbody>
          </table></td>
      </tr>
      
      </tbody>
      
      </table>
      
      
      
      
    
    </td>
    </tr>
    </tbody></table>';


              $this->load->library('email');
              $config['protocol'] = "smtp";
              $config['smtp_host'] = "ssl://smtp.gmail.com";
              $config['smtp_port'] = "465";
              $config['smtp_user'] = 'pranavpk.pk1@gmail.com';
              $config['smtp_pass'] = '9544146763';
              $config['charset'] = "utf-8";
              $config['mailtype'] = "html";
              $config['newline'] = "\r\n";

              $this->email->initialize($config);
              $this->email->from('greenindia@gmail.com', 'Green India');
              $this->email->to($username);
              $this->email->reply_to('no-replay@gmail.com', 'OTP Verification');
              $this->email->subject('OTP Verification');
              $this->email->message($email_message);
              $this->email->send();


					
						exit(json_encode(array('status'=>TRUE)));
						
					} else
					{
						exit(json_encode(array('status'=>false, 'reason'=>'User does not exist')));
					}
				
			} else{
				exit(json_encode(array('status'=>false, 'reason'=>'User does not exist')));
			}
		}

   
}

?>