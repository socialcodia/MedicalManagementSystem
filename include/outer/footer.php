</body>
  <!-- Compiled and minified JavaScript -->
  <script src="js/materialize.min.js"></script>
	 <script src="js/jquery-3.4.1.min.js"></script>

  <script type="text/javascript">
    let API_URL = '<?php echo API_URL; ?>';
    let url = document.location.pathname;
    let pathname = url.substring(url.lastIndexOf("/")+1);
    if (pathname==='forgotPassword')
    {
      let elemOTP = document.getElementById('elemOTP');
      let elemNewPassword = document.getElementById('elemNewPassword');
      let elemBtnForgot = document.getElementById('elemBtnForgot');
      let elemBtnReset = document.getElementById('elemBtnReset');
      let inputNewPassword = document.getElementById('inputNewPassword');
      let inputOtp = document.getElementById('inputOtp');
      let btnForgot = document.getElementById('btnForgot');
      let btnReset = document.getElementById('btnReset');
      elemOTP.style.display = 'none';
      elemNewPassword.style.display = 'none';
      elemBtnReset.style.display =  'none';
    }
    else if(pathname==='register')
    {
      let btnRegister = document.getElementById('btnRegister');
      let inputPassword = document.getElementById('inputPassword');
      let inputName = document.getElementById('inputName');
      let name = inputName.value;
      let password = inputPassword.value;
    }
    let elemEmail = document.getElementById('elemEmail');
    let inputEmail = document.getElementById('inputEmail');
    let errorMessage = document.getElementById('errorMessage');

  	function register()
  	{
      let name = inputName.value;
      let email = inputEmail.value;
      let password = inputPassword.value;
  		if(name=='')
  		{
  			errorMessage.innerHTML = 'Enter Name';
  			return;
  		}
  		if (email=='')
  		{
  			errorMessage.innerHTML = 'Enter Email';
  			return;
  		}
  		if (password=='')
  		{
  			errorMessage.innerHTML = 'Enter Password';
  			return;
  		}
  		if(name.length<4)
  		{
  			errorMessage.innerHTML = 'Name is too short!';
  			return;
  		}
  		if(name.length>30)
  		{
  			errorMessage.innerHTML = 'Name is too big';
  			return;
  		}
      if (!validateEmail(email))
      {
        errorMessage.innerHTML = 'Enter Valid Email';
        return;
      }
  		if(password.length<8)
  		{
  			errorMessage.innerHTML = 'Password should be greater than 8 charecter';
  			return;
  		}
  		btnRegister.classList.add('disabled');
  		$.ajax({
  			type:'post',
  			url:API_URL+'register',
  			data:{
  				'name':name,
  				'email':email,
  				'password':password
  			},
  			success:(response)=>
  			{
  				btnRegister.classList.remove('disabled');
  				console.log(response);
  				errorMessage.innerHTML = response.message;
  			}
  		})
  	}

    function forgotPassword()
    {
      let email = inputEmail.value;
      if (email=='')
      {
        errorMessage.innerHTML = 'Enter Email';
        return;
      }
      if (!validateEmail(email))
      {
        errorMessage.innerHTML = 'Enter Valid Email';
        return;
      }

      btnForgot.classList.add('disabled');
      $.ajax({
        type:'post',
        url:API_URL+'password/forgot',
        data:{
          'email':email
        },
        success:(response)=>
        {
          if (!response.error)
          {
            inputEmail.readOnly = true;
            elemOTP.style.display = 'block';
            elemNewPassword.style.display = 'block';
            elemBtnReset.style.display =  'block';
            elemBtnForgot.style.display = 'none';
          }
          btnForgot.classList.remove('disabled');
          console.log(response);
          errorMessage.innerHTML = response.message;
        }
      })
    }

    function resetPassword()
    {
      let email = inputEmail.value;
      let otp = inputOtp.value;
      let newPassword = inputNewPassword.value;

      if (email=='')
      {
        errorMessage.innerHTML = 'Enter Email';
        return;
      }
      if (!validateEmail(email))
      {
        errorMessage.innerHTML = 'Enter Valid Email';
        return;
      }
      if (otp=='')
      {
        errorMessage.innerHTML = 'Enter OTP';
        return;
      }
      if (otp.length!=6)
      {
        errorMessage.innerHTML = 'Enter Valid OTP';
        return;
      }
      if (newPassword=='')
      {
        errorMessage.innerHTML = 'Enter Password';
        return;
      }
      if(newPassword.length<8)
      {
        errorMessage.innerHTML = 'Password should be greater than 8 charecter';
        return;
      }
      btnReset.classList.add('disabled');
      $.ajax({
        type:'post',
        url:API_URL+'password/reset',
        data:{
          'email':email,
          'newPassword':newPassword,
          'otp':otp
        },
        success:(response)=>
        {
          if (!response.error)
          {
            inputEmail.readOnly = false;
            elemOTP.style.display = 'none';
            elemNewPassword.style.display = 'none';
            elemBtnReset.style.display =  'none';
            elemBtnForgot.style.display = 'block';
          }
          btnReset.classList.remove('disabled');
          console.log(response);
          errorMessage.innerHTML = response.message;
        }
      })
    }

    function validateEmail(email) 
    {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
  </script>
</html>