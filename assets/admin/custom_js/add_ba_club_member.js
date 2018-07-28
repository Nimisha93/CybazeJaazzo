$(document).ready(function(){
	var base_url = $(document).find('#baseurl').val()
	
	  $("#club_ba_form").validationEngine();
        
        
          var options = { 
            dataType : "json",    
            success  :    function(data)
            {   
              if(data.status == true)
              {          
              	var data = data.data;
              	var email = data.email;
              	var phone = data.phone;

                noty({text:"Varification code Sent To :"+ phone+'/'+email, type: 'success',layout: 'top', timeout: 3000});
                $(document).find('#ba_otp_model').modal('show'); 
                $('.ba_otp_forms').find('#otp_mail').val(email);
                $('.ba_otp_forms').find('#otp_phone').val(phone);    
              }
              else
              {
                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                return false;
              }
            } 
          };  
          // club reg
          $('#club_ba_form').submit(function(e){
       
              e.preventDefault();
              $('.body_blur').show();
              var st = $("#club_ba_form").validationEngine("validate");
             
      			$('.body_blur').hide();
              if(st == true)
              {
       
                $(this).ajaxSubmit(options);
                $('.body_blur').hide();
      
              }
      
            });
          
         $('#ba_otp_forms').ajaxForm({ 
        // dataType identifies the expected content type of the server response 
        dataType:  'json', 
 
        // success identifies the function to invoke when the server response 
        // has been received 
        success:   function(data)
        {
        	if(data.status)
        	{
        		var data = data.data;
        		var id = data.user_id;
        		noty({text:"Completed", type: 'success',layout: 'top', timeout: 3000});
                window.location = base_url+'admin/clubmember/become_ba_clubmember/'+id;
        	}else{
        		noty({text:data.reason, type: 'error',layout: 'top', timeout: 3000});
        	}
        } 
    	}); 
         $('#payment_sub_ba').click(function(e){
          e.preventDefault();
            var datas = $('#payment_ba_form').serializeArray();
            $.post(base_url+'paynow', datas, function(data){
              if(data.status){
                noty({text:"Completed", type: 'success',layout: 'top', timeout: 3000});
              } else{
                noty({text:data.reason, type: 'error',layout: 'top', timeout: 3000});
              }
            },'json');
         });
});