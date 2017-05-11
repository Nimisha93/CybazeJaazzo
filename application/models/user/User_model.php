<?php
/**
* 
*/
class User_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_wallete_values_user($login_id)
	{
		$qry = "select
				wal.id,
				wal.wallet_type_id,
				typ.title,
				wal.user_id,
        TRUNCATE(wal.total_value,2) as total_value
				from
				gp_wallet_values wal
				
				left join gp_wallet_types typ on  typ.id = wal.wallet_type_id
				where wal.user_id = ?
				order by typ.title asc";
		$qry = $this->db->query($qry, $login_id);
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		} else{
			return array();
		}		
	}
	function get_channel_partner()
	{
		$qry = "select
				con.id as con_id,
				cp.name,
				cp.phone,
				typ.title as shope_type,
				typ.`status`
				from
				gp_pl_channel_partner_type_connection con

				left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
				left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		} else{
			return array();
		}	

	}


	function get_totel_wallete_amount($login_id)
    {

		$qry= "select walv.total_value FROM gp_login_table logg 
		LEFT JOIN gp_wallet_values walv on walv.user_id=logg.id and walv.wallet_type_id='4' 
		where logg.id='$login_id'";
		
	    $query= $this->db->query($qry);
			if($query->num_rows()>0)
			{
				$data['amount'] =$query->row_array();
			} else{
				$data['amount'] =array();
			}	
			return $data;
	}

	function transfer_phone($reg_phone)
	{
           $qry= "select logg.id  FROM gp_login_table logg where  logg.mobile='$reg_phone'";
			$query=$this->db->query($qry);
			if($query->num_rows()>0)
			{
				return $query->row_array();
			} else{
				return array();
			}	
	}
     function transfer_amount($userid,$reg_amount,$login_id,$trans_type )
    {



           $qry= "select
					*
					from
					gp_wallet_values vl 
					where vl.wallet_type_id = '$trans_type'
					and vl.user_id = '$login_id'";
		$query=$this->db->query($qry);
       
		if($query->num_rows()>0)
		{
			$res = $query->row_array();
			if($res['total_value'] >= $reg_amount){
				$this->transfer_result($userid,$reg_amount,$login_id,$trans_type );
				return true;
			} else{
				return false;
			}
			

			
		} else{
			return false;
		}	




    }
	function transfer_result($userid,$reg_amount,$login_id,$trans_type)
	{


    $this->db->trans_begin();
    $rec_qry="update `gp_wallet_values` set total_value=total_value + '$reg_amount' where user_id='$userid' and wallet_type_id= '$trans_type'";

    $recquery=$this->db->query($rec_qry);


     $send_qry="update `gp_wallet_values` set total_value=total_value - '$reg_amount' where user_id='$login_id' and wallet_type_id= '$trans_type'";

     $query=$this->db->query($send_qry);
       // echo  $sql1 = $this->db->last_query();
     $created_on= date('Y-m-d H:i:s');

  $data=array(
            
            'form_id'=>$login_id,
            'to_id'=>$userid,
            'amount'=>$reg_amount,
                         'status' =>"1",
            'created_by' => $login_id,
            'created_on_date' => $created_on
        );
        $this->db->insert('gp_payment_transfer',$data);

    $this->db->trans_complete();
    if( $this->db->trans_status()===false){
    	$this->db->trans_rollback();
    	return false;

    }
    else{
        $this->db->trans_commit();
    	return true;
    }
			


	
	}		

 function get_normal_customer($id)
	 {
        $qry="select * from gp_login_table  left join gp_normal_customer on gp_login_table.user_id= gp_normal_customer.id where gp_login_table.user_id='$id'";

        $qry=$this->db->query($qry);

        if($qry->num_rows()>0){
            $data=$qry->row_array();
        }
        else{
            $data=array();
        }
        return $data;

    }
    function update_normal_customer_byid($id){
        $this->db->trans_begin();
       $session_array = $this->session->userdata('logged_in_user');
       $lg_id = $session_array['id'];
        $data=array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),
            'email'=>$this->input->post('email'),
            'address'=>$this->input->post('address')

        );

        $this->db->where('id',$id);
        $this->db->update('gp_normal_customer',$data);

         $datass=array(
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('phone')
            );
         $this->db->where('id',$lg_id);
        $this->db->update('gp_login_table',$datass);



        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }

   function image_add($data){


   	 $session_array = $this->session->userdata('logged_in_user');
       $userid = $session_array['user_id'];
       		$selqry = "select * from profile where user_id = '$userid'";
       		$selqry = $this->db->query($selqry);

       		if($selqry->num_rows()>0){
       			$datass = $selqry->result_array();
       				foreach ($data as $key => $datas) {
       					$del_img = $datas['profile'];


       					unlink(base_url('uploads/'.$del_img));
       					}
       			 $this->db->where('user_id',$userid);
                   
                    $this->db->delete('profile');
       			}
       			
                   



          if($this->input->post('upload')) {
          $img = $data[0]['profile'];
            $image=array('profile_image'=>$img);




                $this->db->where('id',$userid);
                $res= $this->db->update("gp_normal_customer",$image);

               $qry = $this->db->insert_batch('profile',$data);
              echo $this->db->last_query();
               return $qry;
   

   
         $qry = $this->db->insert_batch('profile',$data);
              echo $this->db->last_query();
              return $qry;

        }

    }

function get_image($id)
	 {
        $qry="SELECT * FROM `profile` WHERE user_id='$id'";

        $qry=$this->db->query($qry);
       // echo $this->db->last_query();

        if($qry->num_rows()>0){
            $data=$qry->result_array();
        }
        else{
            $data=array();
        }
        return $data;

    }



function get_cur_client_img($id)
{
     $this->db->select("profile");
        $this->db->from('profile');
          $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->row_array();
}



    public function edit_profile($image_file)
    {
       
        
       
                $data=array('profile'=>$image_file);

                $this->db->where('id',$id);
               $res= $this->db->update("profile",$data);
        return $res;





    }
    function get_all_club_types()
    {
      $qry = "select
              t.id,
              t.title,
              t.amount
              from
              club_member_type t
              where t.is_del= 0
              order by t.amount desc";
      $qry = $this->db->query($qry);        
      if($qry->num_rows()>0)
      {
        return $qry->result_array();
      } else{
        return array();
      }
    }
  

//hridya ads

  function get_ads()
  {
    $qry ="SELECT * FROM `advertisement` WHERE type='left' AND is_del='0'";
    
    $qry = $this->db->query($qry);
    if($qry->num_rows()>0)
    {
      return $qry->result_array();
    } else{
      return array();
    } 

  }

  function get_ads_center()
  {
    $qry ="SELECT * FROM `advertisement` WHERE type='center' AND is_del='0'";
    $qry = $this->db->query($qry);
    if($qry->num_rows()>0)
    {
      return $qry->result_array();
    } else{
      return array();
    } 

  }

  function get_ads_right()
  {
    $qry ="SELECT * FROM `advertisement` WHERE type='right' AND is_del='0'";
    $qry = $this->db->query($qry);
    if($qry->num_rows()>0)
    {
      return $qry->result_array();
    } else{
      return array();
    } 

  }

function get_current_pass($id)
    {
        $qry = $this->db->query("SELECT password from gp_login_table where id = '$id'");
        //echo $this->db->last_query();
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
    }
    function update_pass($pass, $id)
    {
        $qry = $this->db->query("update gp_login_table set password = '$pass' where id ='$id'");
        return $qry;
    }

  
}

?>