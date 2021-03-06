<?php 
/**
* 
*/
class Purchase extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('user/purchase_model'));
		$this->load->library(array('form_validation'));
		$this->load->helper(array('form', 'date'));
	}
	function give_notification()
	{
        //var_dump('hi');exit;
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules("channel_partner_con_id","Select Shope","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("login_id","Customer","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("price[]","Price","trim|htmlspecialchars");
			$this->form_validation->set_rules("sum_of_billing","Total","trim|htmlspecialchars|numeric|required");

			if( $this->form_validation->run() == TRUE )
			{
				$wal_amount = $this->purchase_model->get_total_wallet_amount_customer();
				$wallet_price = $this->input->post('price');
				$sum_enterd = 0;
				foreach ($wallet_price as $key => $price) {
					$sum_enterd += $price;
				}
				$in_wallet = $wal_amount['as_total'];
                $in_wallet = intval($in_wallet);
                $sum_enterd = intval($sum_enterd);
				//var_dump($in_wallet);
                //var_dump($sum_enterd);exit;
                //echo "inWallet:".$in_wallet;
                //echo "-sumEnt:".$sum_enterd;
				if($in_wallet > $sum_enterd){
					$check_bal_in_wallet = $this->purchase_model->check_bal_in_wallet();
						//var_dump($check_bal_in_wallet);exit;
					if($check_bal_in_wallet["status"] == TRUE){
						$result=$this->purchase_model->give_notification();
					
						if($result){
							exit(json_encode(array("status"=>TRUE)));
						}else{
							exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
						}
					} else{
						exit(json_encode(array("status"=>FALSE,"reason"=>'Not Enough Money')));
					}
						
				}else{
					exit(json_encode(array("status"=>FALSE,"reason"=>'Not Enough Money in Your Wallet ')));
				}
											
			}else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}			
		
		}else{
			show_error("We are unable to process this request on this way!");
		}
	}
}
?>