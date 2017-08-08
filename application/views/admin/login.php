<div id="page-loader" class="fade in hide"><span class="spinner"></span></div>
<div class="login-content">
                <form  method="POST" name="loginform" id="loginform" class="margin-bottom-0">
                    <div class="form-group m-b-20">
                        <input id="username" name="username" type="text" class="form-control input-lg" placeholder="Username" />
                    </div>
                    <div class="form-group m-b-20">
                        <input id="password" name="password" type="password" class="form-control input-lg" placeholder="Password" />
                    </div>
                    <div class="checkbox m-b-20">
                        <label>
                            <input type="checkbox" /> Remember Me
                        </label>
                    </div>
                    <div class="login-buttons">
                        <button id="submit" type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- end login -->
        
        
        
        <!-- begin theme-panel -->
        
        <!-- end theme-panel -->
	</div>
	<!-- end page container -->
	
<script>
	$(document).ready(function(){
	   $("#username,#password").keyup(function(event){
          if(event.keyCode == 13){
            $("#loginform").submit();
          }
       }); 
	  $('#loginform').submit(function(e){
		   e.preventDefault();
		   var username = $('#username').val();
		   var password = $('#password').val();
		   if(username=='')
		     toastr.error('Enter username'); 
		   else if(password=='')
		     toastr.error('Enter password'); 
		   $('#page-loader').removeClass('hide');	 
		   dataString = $('form[name=loginform]').serialize();
		   $.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/admin/custom_ajax/verifylogin',
					success:function(data) {
						  if (data.status=='success'){
							 window.location.href = "<?php echo base_url();?>index.php/admin"; 			    				  
						  }
						  else{	
						        $('#page-loader').addClass('hide');						        	  
							    setTimeout(function() {
									toastr.options = {
										closeButton: true,
										progressBar: true,
										showMethod: 'slideDown',
										timeOut: 4000
									};
                                    toastr.error('Invalid Credentials');

                               }, 1300);				
						  }
					}
				  });	 	 		   
		     
	  });
	});

</script>		