   <div class="container">
      <div class="col-xs-8">
         <form class="form-signin" method="POST" onSubmit="return submit()" action="/authenticate">
            <h2 class="form-signin-heading text-white centered">Please sign in</h2>
            <label for="tbUser" class="sr-only">Username</label>
            <input type="text" id="tbUser" name="tbUser" class="form-control" placeholder="Username" required="1" autofocus="1">
            <label for="tbPass" class="sr-only">Password</label>
            <input type="password" id="tbPass" name="tbPass" class="form-control" placeholder="Password" required="1">
            <label for="tbLicense" class="sr-only">License Key</label>
            <input type="text" id="tbLicense" name="tbLicense" class="form-control" placeholder="License Key" required="1">
            <button class="btn btn-lg btn-primary btn-block" id="btnSubmit" type="submit">Sign in</button>
         </form>
      </div>
   </div> <!-- /container -->

<script>

   $(document).ready(function()
   {
      var user = localStorage.getItem('user');
      var pass = localStorage.getItem('pass');
      var license = localStorage.getItem('license');

      if (localStorage.getItem('user') && localStorage.getItem('pass') && localStorage.getItem('license'))
      {
         $('#tbUser').val(user);
         $('#tbPass').val(pass);
         $('#tbLicense').val(license);
      }
      else if (localStorage.getItem('user'))
      {
         $('#tbUser').val(user);
      }
      else if (localStorage.getItem('pass'))
      {
         $('#tbPass').val(pass);
      }
      else if (localStorage.getItem('license'))
      {
         $('#tbLicense').val(license);
      }


   });

   $('#btnSubmit').click(function ()
   {
      var user = document.getElementById('tbUser').value;
      var pass = document.getElementById('tbPass').value;
      var license = document.getElementById('tbLicense').value;
      localStorage.setItem('user', user);
      localStorage.setItem('pass', pass);
      localStorage.setItem('license', license);

   })
      
</script>