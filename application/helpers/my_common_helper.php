<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	function round_number( $NUM,$POS = 2 )
	{
		//return number_format((float)$NUM, $POS, '.', '');
		return number_format((int)$NUM,$POS, '.', ''); 


	}
	function round_number_no_decimal( $NUM,$POS = 0 )
	{
		//return number_format((float)$NUM, $POS, '.', '');
		return number_format((int)$NUM,$POS, '.', ''); 


	}
	function send_custom_email($from, $mail_head, $to, $subject, $email_message)
	{
		$ci =& get_instance();
        $ci->load->database();
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
		$ci->email->from($from, $mail_head);
		$ci->email->to($to);
		$ci->email->reply_to('no-replay@gmail.com', 'OTP Verification');
		$ci->email->subject($subject);
		$ci->email->message($email_message);
		$send = $ci->email->send();
		if($send == TRUE)
		{
			return TRUE;
		} else{
			return FALSE;
		}
	}

 	function activity_log($action,$userid,$status,$date){
	 	$date = date('m/d/Y h:i:s', time());
	    $ci =& get_instance();
	         //load databse library
	         $ci->load->database();
	         $ci->load->library('session');
	       $insert = array('action' => $action,
	       	'user_id'=> $userid,
	       	'status_' => $status,'date'=>$date

	       	);
	       
	       $qry = $ci->db->insert('gp_activity_log',$insert);
	    return $qry;
	}
	function get_execuitive_details()
	{
		$ci =& get_instance();
		$ci->load->library('session');
        $sesson_array =  $ci->session->userdata('logged_in_admin');
        $lgid = $sesson_array['id'];
        $userid = $sesson_array['user_id'];
        $qry = "select * from gp_pl_sales_team_members m where m.id = '$userid'";
        $query = $ci->db->query($qry);
        if($query->num_rows()>0)
        {
        	return $query->row_array();
        } else{
        	return array();
        }
	}

?>
