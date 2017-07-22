﻿<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="icon" href="../../favicon.ico">
   <title>RPOWER Mobile Dash</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="app/js/validate.js"></script>
   <script src="app/js/k3.js"></script>
   <script type="text/javascript" charset="utf-8" src="cordova.js"></script>
   <link href="app/css/k3.css" rel="stylesheet">
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
            <img class="pull-right" src="app/images/rpower.png" alt="" />
         </div>
         <div id="navbar" class="navbar-collapse collapse">
            <?php if ($SESSION['loggedin']): ?>
               
                  <ul class="nav navbar-nav">
                     <li id="overviewPage" class="navigation" data-page="overview"><a href="">Overview</a></li>
                     <li id="salesPage" class="navigation" data-page="sales"><a href="">Sales</a></li>
                     <li id="disvoidPage" class="navigation" data-page="disvoid"><a href="">Discounts/Voids</a></li>
                     <li id="laborPage" class="navigation" data-page="labor"><a href="">Labor</a></li>
                     <li id="alertPage" class="navigation" data-page="alerts"><a href="">Email Alerts</a></li>
                     <li id="utilsPage" class="navigation" data-page="utils"><a href="">Utils</a></li>
                     <li id="utilsPage" class="navigation" data-page="order"><a href="">Order Supplies</a></li>
                     <li class="navigation" data-page="settings"><a href="/destroySession">Logout</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right"></ul>
               
            <?php endif; ?>
         </div>
      </div>
   </nav>
</div>

<div class="container-fluid">
   <?php if ($SESSION['loggedin']): ?>
      
         <div class"row">
            <div class="container-fluid dropdown-space-10px">
               <div class="col-xs-6 centered">
                  <input id="date" class="input-sm datepick pull-left datesmall" type="date" placeholder="date"></input>
               </div>
               <div class="col-xs-6">
                  <div class="dropdown">
                     <button class="btn btn-default dropdown-toggle btn-full input-no-border" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="caret"></span>&nbsp&nbsp<span id="storeButtonText"></span>
                     </button>
                     <ul id="ddStoreList" class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenu" role="menu"></ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xs-12 text-center color-white">
               <small>Last Update: <span id="storeLastPost">No Data</span></small>
            </div>
         </div>
      
   <?php endif; ?>
</div>

<div class="container-fluid">
   <div id="body">
      <?php echo $this->render($body,$this->mime,get_defined_vars()); ?>
   </div>
</div>


<div id="divModalGeneric">
   <div class="modal fade" id="modalGeneric" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header centered">
               <h4 class="modal-title" id="myModalLabel"><p id="mGHeader"><strong>HEADER</strong></h4></p>
            </div>
            <div class="modal-body">
               <p class="text-center" id="mGBody"></p>
            </div>
            <div class="modal-footer text-center">
               <p class="text-center" id="mGFooter">
                  <button type="button" class="btn btn-danger" id="closeButton">Close</button>
               </p>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="divModalPrompt">
   <div class="modal fade" id="modalPrompt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-body">
               <p class="text-center" id="mPBody"></p>
            </div>
            <div class="modal-footer text-center">
               <p class="text-center" id="mPFooter"></p>
            </div>
         </div>
      </div>
   </div>
</div>

  

</body>

</html>
