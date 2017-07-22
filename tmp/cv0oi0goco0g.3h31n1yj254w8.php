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
                     <li id="ordersPage" class="navigation" data-page="order"><a href="">Order Supplies</a></li>
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

<div id="divModal2">
   <div class="modal fade" id="modal2" z-index="2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header centered">
               <h4 class="modal-title" id="myModalLabel"><p id="m2Header"><strong>HEADER</strong></h4></p>
            </div>
            <div class="modal-body">
               <p class="text-center" id="m2Body">

               </p>
            </div>
            <div class="modal-footer text-center">
               <p class="text-center" id="m2Footer">
                  <button type="button" class="btn btn-danger" id="closeButton2">Close</button>
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

   <script>
var server = 'http://192.168.0.66:34295/';
//var server = 'http://rpower.com:1338/api.php?op=';

// Starting out, we need to see if this is running on a phone
var isCordovaApp = !!window.cordova;

// If so, we are going to register events that only happen on a phone
// events register and uuidDone gets called which calls docReady with the uuid
if (isCordovaApp == true)
{
  document.addEventListener("backbutton", onBackKeyDown, false);
  document.addEventListener("deviceready", onDeviceReady, false);
  document.addEventListener("pause", onDevicePause, false);
  document.addEventListener("resume", onDeviceResume, false);
}

// Otherwise we just load docReady
else
{
  docReady();
}

// Phone event handlers
function onBackKeyDown()
{
    e.preventDefault();
}

function onDeviceReady()
{

}

function onDevicePause()
{

}

function onDeviceResume()
{
   var selectedDate = localStorage.getItem("selectedDate");
   var maxDate = localStorage.getItem("maxDate");

   if (localStorage.getItem("token"))
   {
      localStorage.setItem("1stRun", 0);
   }

   if (selectedDate != maxDate && maxDate)
   {
      $('#mPBody').html('<h2>Switch to today?</h2>');
      $('#mPFooter').html('<button type=\"button\" class=\"btn btn-danger pull-left\" id=\"btnNoSTT\">NO</button><button type=\"button\" class=\"btn btn-success pull-right\" id=\"btnYesSTT\">YES</button>');
      $('#modalPrompt').modal('show');
   }
}

function docReady() // We call this when we're ready
{

$(document).ready(function()
{
   $("#error").hide();
   $("#errorMsg").hide();
   $("#user").val(localStorage.getItem("user"));
   $("#pass").val(localStorage.getItem("pass"));
   $("#license").val(localStorage.getItem("license"));

   // Step 1 -
   // Do we have a date set? If not, set one.
   if (localStorage.getItem("selectedDate"))
   {
      $("#date").val(localStorage.getItem("selectedDate"));
   }
   else
   {
      var today = dateToday();
      $("#date").val(today);
      localStorage.setItem("selectedDate", today)
   }

   // Step 2 - If we don't have a key for "needUpdate" then we are going to assume we need to update
   // The only way we won't have this key is if it's a new install
   if (!localStorage.getItem("needUpdate"))
   {
      localStorage.setItem("needUpdate", 1);
   }

   // Step 3 - Gather login information
   token = localStorage.getItem("token");
   user = localStorage.getItem("user");
   license = localStorage.getItem("license");

   //if (localStorage.getItem("lastPage") && localStorage.getItem("token"))
   if (localStorage.getItem("lastPage"))
   {
      storeList(token, user, license);
      var page = localStorage.getItem("lastPage");
      pageLoad(page);
   }
   else // 1st load.. We wont have lastPage so load overview
   {
      storeList(token, user, license);
      pageLoad('overview');
   }



   ////////////////////////////////////////////////////////////////////////////////
   //                         Button Handlers                                    //
   ////////////////////////////////////////////////////////////////////////////////

   ///// Switch to today prompt /////
   $('#modalPrompt').on('click', 'button', function()
   {
      if(this.id == 'btnYesSTT')
      {
         $('#modalPrompt').modal('hide');
         var today = dateToday();
         localStorage.setItem("selectedDate", today);
         $("#date").val(today);
         localStorage.setItem("needUpdate", 1);
      }
      if(this.id == 'btnNoSTT')
      {
         $('#modalPrompt').modal('hide');
      }
   });


   ////////////////////////////////////////////////////////////////////////////////
   //                         Click/Change Handlers                              //
   ////////////////////////////////////////////////////////////////////////////////

   // This is for the top menu / navigation bar - calls pageLoad function with
   // the data-page attribute.. I.E. data-page="overview" would load overview();
   $('.navigation').click(function(e)
   {
      var link = this.dataset.page;
      if (link != "settings") // lastPage doesn't apply for this)
      {
         e.preventDefault();
         localStorage.setItem("lastPage", link);
         pageLoad(link);
      }
   });

   $('#saveSettings').click(function()
   {
      var user = $("#user").val();
      var pass = $("#pass").val();
      var license = $("#license").val();
      license = license.toUpperCase();
      localStorage.setItem("userChanged", 1);
      localStorage.setItem('user', user);
      localStorage.setItem('pass', pass);
      localStorage.setItem('license', license);
      getToken(user, pass, license);
   });

   $('#logout').click(function ()
   {
         method = "post";
         var form = document.createElement("form");
         form.setAttribute("method", method);
         form.setAttribute("action", "/destroySession");
         document.body.appendChild(form);
         form.submit();
   });

   $('#cancelSettings').click(function()
   {
      if (localStorage.getItem("token"))
      {
         $("#error").hide();
      }
   });

   $('#date').change(function(ev)
   {
      var selectedDate = this.value;
      localStorage.setItem("selectedDate", selectedDate);
      var user = localStorage.getItem("user");
      var pass = localStorage.getItem("pass");
      var selectedStore = localStorage.getItem("selectedStore");
      var selectedDate = localStorage.getItem("selectedDate");
      var token = localStorage.getItem("token");
      var cg = localStorage.getItem("cg");
      var license = localStorage.getItem("license");
      localStorage.setItem("needUpdate", "1");
   });

   $('#ddStoreList').click(function(e)
   {
      e.preventDefault();

      if (!e.target.dataset.storemid)
      {
         // Do nothing
      }
      else
      {
         var selectedStore = e.target.dataset.storemid;
         var storeName = e.target.dataset.storename;
         var cg = e.target.dataset.storecg;
         localStorage.setItem("cg", cg);
         localStorage.setItem("selectedStore", selectedStore);
         var user = localStorage.getItem("user");
         var pass = localStorage.getItem("pass");
         var token = localStorage.getItem("token");
         var selectedDate = localStorage.getItem("selectedDate");
         var license = localStorage.getItem("license");
         $("#storeButtonText").html(storeName);
         localStorage.setItem("needUpdate", 1);
      }
   });

   $('#openSettings').click(function(e)
   {
      e.preventDefault();
      openSettings();
   });

   $('#closeButton').click(function(e)
   {
      $('#mGHeader').html('');
      $('#mGBody').html('');
      $('#modalGeneric').modal("hide");
   });

   ///// Close Nav Menu on selection /////
   $(function()
   {
      var navMain = $("#navbar");
      navMain.on("click", "a", null, function ()
      {
         navMain.collapse('hide');
      });
   });

   $('#closeButton2').click(function (e)
   {
      $('#m2Header').html('');
      $('#m2Body').html('');
      $('#modal2').modal("hide");
   });

   ////////////////////////////////////////////////////////////////////////////////
   //                        End Click Handlers                                  //
   ////////////////////////////////////////////////////////////////////////////////


   // When the settings page opens, focus to Username
   $(window).on('shown.bs.modal', function (e)
   {
      $('#user').focus();
   });


   // If you press Enter in the Settins screen, it's going to click 'Save'
   // If you press Esc, it closes. This is mainly for testing.
   $('#settings').bind('keypress', function(e)
   {
      if (e.keyCode == 13)
      {
         $('#saveSettings').click();
      }
      if (e.keyCode == 27)
      {
         $('#settings').modal('hide');

         if (localStorage.getItem("token"))
         {
            $("#error").hide();
         }
      }
   });



////////// Functions //////////

function getToken(user, pass, license)
{
   var postData = {user: user, pass: pass, license: license};

   $.ajax({
      url: server + 'authUser',
      type: "POST",
      dataType: 'json',
      data: postData,
      crossDomain: true,
      success: function(data)
      {
         var token = data.token;
         var rpowerCg = data.storeCg;
         var userID = data.id;
         localStorage.setItem("cg", rpowerCg);
         localStorage.setItem("token", token);
         localStorage.setItem("userID", userID);

         if (data == 401)
         {
            $("#body").hide();
            //$("#error").show();
            //$("#errorMsg").show();
            throw new Error("Wrong response from auth!");
         }
         else if (data == 42)
         {
            // License/UUID mismatch
            $("#body").hide();
            //$("#error").show();
            //$("#errorMsg").show();
         }
         else
         {
            console.log('Got token!');
            $("#errorMsg").hide();
            $("#error").hide();
            $('#settings').modal('hide');
            var user = localStorage.getItem('user');
            var license = localStorage.getItem('license');
            storeList(token, user, license);
         }
      },
   });
}

function checkUpdateTime(token, cg, selectedStore, user, license)
{
   var user = localStorage.getItem("user");
   var storePost = {token: token, cg: cg, selectedStore: selectedStore, user: user, license: license};

   $.ajax({
      url: server + 'storeLastUpdate',
      type: "POST",
      dataType: 'json',
      data: storePost,
      crossDomain: true,
      success: function(data)
      {
         var lastUpdateSQL = new Date(data[0].lup_zdttm).toUTCString();
         var lastUpdateLS = new Date(localStorage.getItem("lastUpdate")).toUTCString();
         var lastMessageAck = localStorage.getItem("lastMessageAck");
         var lupd = data[0].lup_dttm;
         lupd = lupd.substring(5, 16);
         $('#storeLastPost').html(lupd)
         if (data[999999998])
         {
            var maxDate = dateFormat(data[999999998].date);
            localStorage.setItem("maxDate", maxDate);
         }
            // processMessage(lastMessageAck);
   /*
         if (data[999999999])
         {
            processMessage(data[999999999].lastMessageAck)
         }
*/
         if (lastUpdateSQL != lastUpdateLS)
         {
            localStorage.setItem("lastUpdate", lastUpdateSQL);
            localStorage.setItem("needUpdate", 1);
         }
      },
   });
}

function checkToken(user, pass, token, selectedStore, selectedDate, license)
{
   var postData = {token: token, user: user, pass: pass, license: license};

   return $.ajax({
      url: server + 'checkTokenAuth',
      type: "POST",
      dataType: 'json',
      data: postData,
      crossDomain: true,
      success: function(data)
      {
         localStorage.setItem("token", data.token);
      },
      error: function(data)
      {
      },
   });
}

function processMessage(lastMessageAck) // In progress
{
   if (!lastMessageAck)
   {
      var now = dateHourNow();
      localStorage.setItem("lastMessageAck", now)
   }
   else
   {
      var cg = localStorage.getItem("cg");
      var storeMID = localStorage.getItem("selectedStore");
      var token = localStorage.getItem("token");
      var postData = {token: token, cg: cg, storeMID: storeMID, lastMessageAck: lastMessageAck};

      $.ajax({
         url: 'http://rpower.com:1338/api.php?op=getMessages',
         type: "POST",
         dataType: 'json',
         data: postData,
         crossDomain: true,
         success: function(data)
         {
            var messageCount = Object.size(data);
            if (messageCount > 0)
            {
               var header;
               var footer;

               for (var g = 0; g < messageCount; g++)
               {
                  header = data[g].header;
                  body = data[g].body;
                  lastMessage = data[g].timestamp;
                  $('#mGHeader').html(header);
                  $('#mGBody').html(body);
                  $('#modalGeneric').modal("show");
                  localStorage.setItem("lastMessageAck", lastMessage);
               }
            }
         },
      });
   }
}

function storeList(token, user, license)
{
   var postData = {token: token, user: user, license: license};

   $("#ddStoreList").empty();

   $.ajax({
      url: server + 'storeListByUser?XDEBUG_SESSION_START',
      type: "POST",
      dataType: 'json',
      data: postData,
      crossDomain: true,
      success: function(data)
      {
         var storeArray = JSON.stringify(data);
         localStorage.setItem("stores", storeArray);

         for (var i = 0; i < data.length; i++)
         {
            name = data[i].tag_name;
            mid = data[i].mid;
            var currentCG = data[i].cg;
            var currentSerial = data[i].serial_number;
            storeLastUpdate = data[i].lup_zdttm;

            if ((i == 0) && (!localStorage.getItem("selectedStore")) || localStorage.getItem("userChanged") == 1)
            {
               localStorage.setItem("selectedStore", mid);
               if (localStorage.getItem("userChanged") == 1)
               {
                  localStorage.setItem("userChanged", 2);
                  currentCG = data[i].cg;
                  currentSerial = data[i].serial_number;
               }
            }

            if (mid == localStorage.getItem('selectedStore'))
            {
               $("#storeButtonText").html(name);
               localStorage.setItem("cg", currentCG);
               localStorage.setItem("serial", currentSerial);
            }

            $("#ddStoreList").append('<li role="presentation"><a data-storeLastUpdate ="' + storeLastUpdate + '"  data-storecg="' + currentCG + '" data-storemid="' + mid + '" data-storename="' + name + '" href="' + mid + '">' + name + '</a></li>');
         }

         if (localStorage.getItem("userChanged") == 2)
         {
            localStorage.setItem("userChanged", 0);
            userChange();
         }
      },
      error: function(data)
      {
         console.log(data);
      }
   });
}

function userChange()
{
   localStorage.removeItem("storeLastUpdate");
   var cg = localStorage.getItem("cg");
   var selectedStore = localStorage.getItem("selectedStore");
   var user = localStorage.getItem("user");
   var pass = localStorage.getItem("pass");
   var token = localStorage.getItem("token");
   var selectedDate = localStorage.getItem("selectedDate");
   var serial = localStorage.getItem("serial");
   var license = localStorage.getItem("license");

   checkToken(user, pass, token, selectedStore, selectedDate, license)
   .then
   (dealerOfRecord(serial))
   .then
   (storeList(token, user, license))
   .then
   (reloadPage());
}

function reloadPage()
{
   location.reload();
}

function dealerOfRecord(serial)
{
   var storePost = {serial: serial};

   return $.ajax({
      url: server + 'dealerOfRecord',
      type: "POST",
      dataType: 'json',
      data: storePost,
      crossDomain: true,
      success: function(data)
      {
         data = JSON.stringify(data);
         localStorage.setItem("dor", data);
      },
      error: function(data)
      {
         console.log(data);
      },
   });
}

function pageLoad(page)
{
   localStorage.setItem("lastPage", page);
   $("#error").hide();
   $("#body").html("");
   $("#body").load('http://192.168.0.66:34295/' + page);
   localStorage.setItem("needUpdate", "1");

}

function openSettings()
{
   $("#error").show();
   $('#settings').modal("show");
}

////////////////////////////////////////////////////////////////////////////////
//                     End Functions                                          //
////////////////////////////////////////////////////////////////////////////////

// Timer for checking the last update time of the store
// Run only if user is "logged in"
if (localStorage.getItem("token") || localStorage.getItem("user") || localStorage.getItem("pass"))
{
   window.setInterval(function()
   {
      var cg = localStorage.getItem("cg");
      var token = localStorage.getItem("token");
      var selectedStore = localStorage.getItem("selectedStore");
      var user = localStorage.getItem("user");
      var license = localStorage.getItem("license");
      checkUpdateTime(token, cg, selectedStore, user, license);
   }, 5000);
}


}); ////////// END document.ready //////////




}




   </script>

</body>

</html>
