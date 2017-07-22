  <script>
 
  refreshAlerts();
  $('#error').hide();
  $('#saved').hide();

function refreshAlerts()
{
   var storeMID = localStorage.getItem("selectedStore");
   var userID = localStorage.getItem("userID");
   var user = localStorage.getItem("user");
   var pass = localStorage.getItem("pass");
   var cg = localStorage.getItem("cg");
   var token = localStorage.getItem("token");
   var license = localStorage.getItem("license");

   var url = localStorage.getItem('server');
   var debug = localStorage.getItem('debug');
   if (!debug)
   {
      debug = "";
   }

   postData = { userID: userID, storeMID: storeMID, license: license, token: token, user: user, pass: pass, isMobile: 1 };
   
   $.ajax({
      url: url + '/getAlertSettings' + debug,
      dataType: 'json',
      crossDomain: true,
      method: 'post',
      data: postData,
      success:
      function(data)
      {
         if (data == null || data == undefined || !data)
         {
            $('#smsNumber').val('');
            $('#discountAlertAmount').val('');
            $('#voidAlertAmount').val('');
            $('#alertEmail').val('');

            var vActive = $('#vAlertOn').hasClass('active');
            if ( vActive == true )
            {
               $('#vAlertOff').toggleClass('active btn-primary btn-default');
               $('#dAlertOff').toggleClass('active btn-primary btn-default');
               $('#vAlertOn').toggleClass('active btn-primary btn-default');
               $('#dAlertOn').toggleClass('active btn-primary btn-default');
             }

            var dActive = $('#dAlertOn').hasClass('active');
            if ( dActive == true )
            {
               $('#vAlertOff').toggleClass('active btn-primary btn-default');
               $('#dAlertOff').toggleClass('active btn-primary btn-default');
               $('#vAlertOn').toggleClass('active btn-primary btn-default');
               $('#dAlertOn').toggleClass('active btn-primary btn-default');
             }
          }
          else
          {
             $('#smsNumber').val(data[0].smsNumber);
             $('#discountAlertAmount').val(data[0].t2);
             $('#voidAlertAmount').val(data[0].t1);
             $('#alertEmail').val(data[0].alertEmail);

             var vActive = $('#vAlertOn').hasClass('active');
             var dActive = $('#dAlertOn').hasClass('active');

             if (data[0].void == "1" && vActive == false)
             {
                $('#vAlertOn').toggleClass('active btn-primary btn-default');
                $('#vAlertOff').toggleClass('active btn-primary btn-default');
             }
             else if (data[0].void == "1" && vActive == true)
             {
             
             }
             else if (data[0].void == "0" && vActive == true)
             {
                $('#vAlertOn').toggleClass('active btn-primary btn-default');
                $('#vAlertOff').toggleClass('active btn-primary btn-default');
             }
             else{}
             
             if (data[0].discount == "1" && dActive == false)
             {
                $('#dAlertOn').toggleClass('active btn-primary btn-default');
                $('#dAlertOff').toggleClass('active btn-primary btn-default');
             }
             else if (data[0].discount == "1" && dActive == true)
             {
             
             }
             else if (data[0].discount == "0" && dActive == true)
             {
                $('#dAlertOn').toggleClass('active btn-primary btn-default');
                $('#dAlertOff').toggleClass('active btn-primary btn-default');
             }
             else
             {
             }
         }
        },
        error:
        function(data)
        {
           console.log(data);
        }
     });
  }

function createUpdateAlert()
{
      $('#saveAlertSettings').removeClass('btn-success');
      $('#saveAlertSettings').addClass('btn-default');
      var storeMID = localStorage.getItem("selectedStore");
      var userID = localStorage.getItem("userID");
      var user = localStorage.getItem("user");
      var pass = localStorage.getItem("pass");
      var cg = localStorage.getItem("cg");
      var license = localStorage.getItem("license");
      var alertEmail = $("#alertEmail").val();
      var t1 = $("#voidAlertAmount").val();
      var t2 = $("#discountAlertAmount").val();
      var voidOn = 0;
      var discountOn = 0;

      if ($('#vAlertOn').hasClass('active'))
      {
         var voidOn = 1;
      }
      if ($('#dAlertOn').hasClass('active'))
      {
         var discountOn = 1;
      }

      postData = {token: token, license: license, cg: cg, storeMID: storeMID, userID: userID, t1: t1, t2: t2, voidOn: voidOn, discountOn: discountOn, alertEmail: alertEmail, user: user, pass: pass, isMobile: 1};

      $.ajax({
         url: url + '/createAlertSettings?XDEBUG_SESSION_START',
        dataType: 'json',
        crossDomain: true,
        method: 'post',
        data: postData,
        success:
        function(data)
        {
             $('#saveAlertSettings').removeClass('btn-default');
             $('#saveAlertSettings').removeClass('btn-danger');
             $('#saveAlertSettings').addClass('btn-success');
        },
        error:
        function(data)
        {
           $('#saveAlertSettings').removeClass('btn-default');
           $('#saveAlertSettings').addClass('btn-danger');
           console.log(data);
        },
      });
   }

  $('.btn-toggle').click(function()
  {
     $(this).find('.btn').toggleClass('active');

     if ($(this).find('.btn-primary').length > 0)
     {
        $(this).find('.btn').toggleClass('btn-primary');
     }
     $(this).find('.btn').toggleClass('btn-default');

  });

  $('#saveAlertSettings').click(function()
  {
       createUpdateAlert();
  });

  $('#cancelAlertSettings').click(function()
  {

  });

  $('#ddStoreList').click(function(e)
  {
     e.preventDefault();
     var selectedStore = e.target.dataset.storemid;
     var userID = localStorage.getItem("userID");
     refreshAlerts(userID, selectedStore);
  });

  </script>

<div class="container-fluid">
   <div class="col-xs-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <i class="fa fa-pie-chart-o fa-fw"></i><b>Alert Settings</b><i class="pull-right">(For this store)</i>
         </div>
         <div class="panel-body" style="overflow-y: none">
            <hr>
            <div class="row">
               <div class="col-xs-3">
                  <strong>Email</strong>
               </div>
               <div class="col-xs-8">
                  <input id="alertEmail" class="input-sm" type="text" placeholder="abc@xyz.com" tabindex="2"></input>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-xs-12">
                  <div class="col-xs-5">
                     <strong>Discount Alerts</strong>
                     <div class="btn-group btn-toggle">
                        <button id="dAlertOn" class="btn btn-sm btn-default">ON</button>
                        <button id="dAlertOff" class="btn btn-sm btn-primary active">OFF</button>
                     </div>
                  </div>
                  <div class="col-xs-4">
                     <strong>Threshold</strong>
                     <input id="discountAlertAmount" class="input-sm" type="number" placeholder="0.00" min="0" tabindex="3"></input>
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-xs-12">
                  <div class="row">
                     <div class="col-xs-12">
                        <div class="col-xs-5">
                           <strong>Void Alerts</strong>
                           <div class="btn-group btn-toggle">
                              <button id="vAlertOn" class="btn btn-sm btn-default">ON</button>
                              <button id="vAlertOff" class="btn btn-sm btn-primary active">OFF</button>
                           </div>
                        </div>
                        <div class="col-xs-4">
                           <strong>Threshold</strong>
                           <input id="voidAlertAmount" class="input-sm" type="number" placeholder="0.00" min="0" tabindex="4"></input>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <hr>
            <div class="panel-footer">
               <button id="saveAlertSettings" type="button" class="btn btn-success" tabindex="5">Save changes</button>
            </div>
         </div>
      </div>
   </div>
</div>
