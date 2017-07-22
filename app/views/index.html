<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="icon" href="../../favicon.ico">
   <title>RPOWER Mobile Dash</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="js/k3.js"></script>
   <script type="text/javascript" charset="utf-8" src="cordova.js"></script>
   <link href="css/k3.css" rel="stylesheet">
</head>

<body>

<div class="container-fluid">
   <nav class="navbar navbar-default">
      <div class="container-fluid">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
            <img class="pull-right" src="images/rpower.png" alt="" />
         </div>
         <div id="navbar" class="navbar-collapse collapse">
         </div>
      </div>
   </nav>
</div>

<div class="container-fluid">
   <div id="body">
      <div class="container">
         <div class="col-xs-8">
            <form class="form-signin" method="POST">
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
      </div>  
   </div>
</div>

   <script>
      $(document).ready(function ()
      {
         var user = localStorage.getItem('user');
         var pass = localStorage.getItem('pass');
         var license = localStorage.getItem('license');
         localStorage.setItem('server', 'http://rpower.com:1337/');
         
         var loginCount = localStorage.getItem('loginCount');
         if (!loginCount)
         {
            loginCount = 0;
         }

         if (localStorage.getItem('user') && localStorage.getItem('pass') && localStorage.getItem('license') && loginCount == 0)
         {
            $('#tbUser').val(user);
            $('#tbPass').val(pass);
            $('#tbLicense').val(license);
            $('#btnSubmit').click();
            localStorage.setItem('loginCount', 0);
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

      $('#btnSubmit').click(function (e)
      {
         var url = 'http://rpower.com:1337/';
         e.preventDefault();
         var user = document.getElementById('tbUser').value;
         var pass = document.getElementById('tbPass').value;
         var license = document.getElementById('tbLicense').value;
         localStorage.setItem('user', user);
         localStorage.setItem('pass', pass);
         localStorage.setItem('license', license);
         var postData = { user: user, pass: pass, license: license };

         $.ajax({
            url: url + 'authenticateMobile',
            dataType: 'json',
            crossDomain: true,
            method: 'post',
            data: postData,
            success: function (data)
            {
               if (data.status == 200)
               {
                  localStorage.setItem('token', data.token);
                  localStorage.setItem('userID', data.id);
                  window.location.href = 'layout.html';
                  localStorage.setItem('loginCount', 0);
               }
               else
               {
                  localStorage.setItem('loginCount', 1);
                  return;
               }
            },
            error: function (data)
            {
               errorHandler(data);
            },
         });

      });

   </script>

</body>

</html>
