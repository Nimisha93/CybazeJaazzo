<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Login extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form','string','my_common_helper'));
		$this->load->model('admin/login_model');
	}
	function index()
	{
     $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){        
          $this->load->view('admin/edit_login');
        }else{
          redirect('admin/dashboard/main_admin');
        }
		
	}
  function test()
  {
     
          $this->load->view('admin/test');
      
    
  }
  function cp_login()
  {
     $session_array = $this->session->userdata('logged_in_cp');
        if(!isset($session_array)){        
          $this->load->view('admin/edit_login_cp');
        }else{
          redirect('my_dashboard');
        }
    
  }
	function login_process()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == TRUE)
		{
			
			$result = $this->login_model->validate_login();
		  
			if($result['status'] == true)
			{
				$type = $result['data']['type'];
					$session_array = array();
					$session_array = array(
						'username'=> $result['data']['email'],
						'id' => $result['data']['id'],
						'type' => $result['data']['type'],
						'user_id' => $result['data']['user_id'],
            'desig' => $result['data']['desig'],
          
						'login' =>true);
             //var_dump($type);exit(); 
                if($type=='super_admin')
                {
                    $this->session->set_userdata('logged_in_admin', $session_array);
                    redirect('admin/dashboard/main_admin');
                }
                else if($type=='Employee')
                {
                  $this->session->set_userdata('logged_in_admin', $session_array);
                  redirect('admin/dashboard/main_admin');
                }



                 else if($type == 'executive')
                {

                  $this->session->set_userdata('logged_in_exec', $session_array);
                  redirect('admin/Executives/exec_dashboard');
                } 
                else if($type=='module')
                {
                    redirect('module_dashboard');
                }
                else if($type == 'Channel_partner')
                {
                    $this->session->set_userdata('logged_in_cp', $session_array);
                    redirect('my_dashboard');
                }
                else if($type=='ba')
                {
                 $this->session->set_userdata('logged_in_ba', $session_array);
                 redirect('admin/dashboard/ba_dashboard');
                }

			} else{
				$this->session->set_flashdata('errormsg', 'Invalid Username or Password');
				redirect('admin/login');
			}

		} else
		{
			/*$this->session->set_flashdata('errormsg', validation_errors());*/
			$this->session->set_flashdata('errormsg', strip_tags(validation_errors()));
			redirect('admin/login');
		}

	}
  function login_process_cp()
  {
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if($this->form_validation->run() == TRUE)
    {
      
      $result = $this->login_model->validate_login();
    
      if($result['status'] == true)
      {
        $type = $result['data']['type'];
          $session_array = array();
          $session_array = array(
            'username'=> $result['data']['email'],
            'id' => $result['data']['id'],
            'type' => $result['data']['type'],
            'user_id' => $result['data']['user_id'],
            'login' =>true);
          if($type=='ba'){
            $this->session->set_userdata('logged_in_ba', $session_array);
            redirect('admin/dashboard/ba_dashboard');
          }else{
          $this->session->set_userdata('logged_in_admin', $session_array);
                if($type=='super_admin')
                {
                    redirect('admin/dashboard/main_admin');
                } else if($type == 'executive')
                {
                  redirect('admin/Executives/exec_dashboard');
                } 
                else if($type=='module')
                {
                    redirect('module_dashboard');
                }
                else if($type == 'Channel_partner')
                {
                    redirect('my_dashboard');
                }
        }        

      } else{
        $this->session->set_flashdata('errormsg', 'Invalid Username or Password');
        redirect('admin/login');
      }

    } else
    {
      $this->session->set_flashdata('errormsg', validation_errors());
      redirect('admin/login');
    }

  }
	function forgot_password()
	{
			
			$username = $this->input->post('uname');
			
			
				$validate_user = $this->login_model->validate_user($username);
				///var_dump($validate_user);exit;
				if($validate_user){
					$password = random_string('alnum', 16);
					$userna = $validate_user['username'];
					$update_password = $this->login_model->update_password($password, $userna);
					if($update_password){


						$message = '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:url(bg.jpg) repeat;">	<tbody>  	     	    
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


            $sender_email="faisal@cybaze.com";
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.gmail.com,smtp.webmail.com';
            $config['smtp_port'] = 465;
            $config['smtp_user'] = $sender_email;
            $config['smtp_pass'] = "qwerty@123";

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
					$this->email->from('admin@exposoft.com', 'Exposoft');
					$this->email->to($userna);
					$this->email->subject('User Details');
					$this->email->message($message);
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

	public function loged_out()
	{
		$this->session->unset_userdata('logged_in_admin');
   	$this->session->unset_userdata('logged_in_cp');
    $this->session->unset_userdata('logged_in_exec');	
    $this->session->sess_destroy();
   	   	redirect("admin");
	}
}
?>