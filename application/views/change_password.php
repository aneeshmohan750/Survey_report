  <div class="changepasswordDiv">
                <form  id="changepasswordForm" name="changepasswordForm" method="POST" class="margin-bottom-0">
                   <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?> " />
                    <div class="form-group m-b-20">
                        <input type="password" id="current_password" name="current_password" class="form-control input-lg" placeholder="Current Password" />
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" id="new_password" name="new_password" class="form-control input-lg" placeholder="New Password" />
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control input-lg" placeholder="Reenter New Password" />
                    </div>
                    
                    <div class="login-buttons">
                        <button type="submit" id="changepasswordbtn" class="btn btn-success btn-block btn-lg">Change</button>
                    </div>
                </form>
</div>
 <!-- Ajax script login process -->

<script>
	$(document).ready(function(){
	   $("#current_password,#new_password,confirm_password").keyup(function(event){
          if(event.keyCode == 13){
            $("#changepasswordForm").submit();
          }
       });
	    
	   $('#changepasswordForm').submit(function(e){
	        e.preventDefault();
			var password = $('#current_password').val();
			var new_password = $('#new_password').val();
			var confirm_password = $('#confirm_password').val();
			if(password=='' || new_password =='' || confirm_password==''){
			  setTimeout(function() {
									toastr.options = {
										closeButton: true,
										progressBar: true,
										showMethod: 'slideDown',
										timeOut: 4000
									};
                                    toastr.error('Enter password');
                               }, 1300);		
		      return false;
			}
			else if(new_password!=confirm_password){
			    setTimeout(function() {
									toastr.options = {
										closeButton: true,
										progressBar: true,
										showMethod: 'slideDown',
										timeOut: 4000
									};
                                    toastr.error('Password Mismatch');
                               }, 1300);		
		        return false;					
			}
			$('#changepasswordbtn').text('Requesting......');
			dataString = $('form[name=changepasswordForm]').serialize();
			$.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/change_password',
					success:function(data) {
						  if (data.status=='success'){
							window.location.href = "<?php echo base_url();?>index.php/index/logout";			    				  
						  }
						  else{							        	  
							    setTimeout(function() {
									toastr.options = {
										closeButton: true,
										progressBar: true,
										showMethod: 'slideDown',
										timeOut: 4000
									};
                                    toastr.error('Current Password entered is wrong');

                               }, 1300);	
							   $('#changepasswordbtn').text('Change');					
						  }
					}
				  });
				
	  });
	});
</script>
  

