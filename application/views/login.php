  <!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image">
                    <img src="<?php echo $this->config->item('assets_url')?>img/login-bg/bg-7.jpg" data-id="login-cover-image" alt="" />
                </div>
                <div class="news-caption">
                    <h4 class="caption-title"><i class="fa fa-bar-chart text-success"></i> Survey Reports</h4>
                    
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="right-content">
                <!-- begin login-header -->
                <div class="login-header">
                    <div class="brand">
                       <img src="<?php echo $this->config->item('assets_url')?>img/pageLogo.png" />
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                </div>
                <!-- end login-header -->
                <!-- begin login-content -->
                <div class="login-content">
                    <form name="loginForm" id="loginform" method="POST" class="margin-bottom-0">
                        <div class="form-group m-b-15">
                            <input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username" />
                        </div>
                        <div class="form-group m-b-15">
                            <input type="password"  name="password" id="password" class="form-control input-lg" placeholder="Password" />
                        </div>
                        <div class="checkbox m-b-30">
                            <label>
                                <input type="checkbox" /> Remember Me
                            </label>
                        </div>
                        <div class="login-buttons">
                            <button type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
                        </div>
                        
                        <hr />
                        <p class="text-center text-inverse">
                            &copy; Techmart Solutions All Right Reserved <?php echo date('Y'); ?>
                        </p>
                    </form>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end right-container -->
        </div>
        <!-- end login -->
        
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
		   dataString = $('form[name=loginForm]').serialize();
		   $.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/verifylogin',
					success:function(data) {
						  if (data.status=='success'){
							 window.location.href = "<?php echo base_url();?>"; 			    				  
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