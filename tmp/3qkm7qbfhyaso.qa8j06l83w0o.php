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
   debugger;
   postData = { userID: userID, storeMID: storeMID, license: license, token: token, user: user, pass: pass, isMobile: 0 };

   $.ajax({
      url: 'http://192.168.0.66:34295/getAlertSettings?XDEBUG_SESSION_START',
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
            /*
            email to text
            $("#carrierButtonText").html(data[0].smsCarrier);
            */
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
            else{}
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
      var cg = localStorage.getItem("cg");
      var license = localStorage.getItem("license");
      // var uuid = localStorage.getItem("uuid");
      // This is used for email to text
      // var smsCarrier = localStorage.getItem("smsCarrier");
      // localStorage.setItem("smsCarrier", smsCarrier);
      // var smsNumber = $("#smsNumber").val();
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

      // email to text
      // postData = {cg: cg, storeMID: storeMID, smsNumber: smsNumber, smsCarrier: smsCarrier, userID: userID, t1: t1, t2: t2, voidOn: voidOn, discountOn: discountOn, alertEmail: alertEmail};
      postData = {token: token, license: license, cg: cg, storeMID: storeMID, userID: userID, t1: t1, t2: t2, voidOn: voidOn, discountOn: discountOn, alertEmail: alertEmail, isMobile: 0};

      $.ajax({
        url: 'http://rpower.com:1338/api.php?op=createAlertSettings',
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
        },
      });
   }

  $('.btn-toggle').click(function()
  {
     $(this).find('.btn').toggleClass('active');

     if ($(this).find('.btn-primary').size()>0)
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
            <!-- email to text
            <div class="row">
               <div class="col-lg-12">
                  <div class="col-xs-3">
                     <strong>SMS #</strong>
                  </div>
                  <div class="col-xs-4">
                     <input id="smsNumber" class="input-sm" type="tel" placeholder="5555555555"tabindex="1"></input>
                  </div>
               </div>
            </div>
         -->
            <hr>
            <div class="row">
               <div class="col-xs-3">
                  <strong>Email</strong>
               </div>
               <div class="col-xs-8">
                  <input id="alertEmail" class="input-sm" type="text" placeholder="abc@xyz.com" tabindex="2"></input>
               </div>



               <!-- Code for email to text

               <div class="col-xs-3">
                  <strong>Carrier</strong>
               </div>
               <div class="col-xs-8">
                  <div class="dropdown">
                     <button class="btn btn-default dropdown-toggle btn-full" type="button" id="btnDDCarrier" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="caret"></span>&nbsp&nbsp<span id="carrierButtonText">Select Carrier</span>
                     </button>
                     <ul id="ddCarrier" class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenu">
                        <li><a data-carrier="txt.att.net" href="#">AT&T / Cingular</a></li>
                        <li><a data-carrier="myboostmobile.com" href="#">Boost Mobile</a></li>
                        <li><a data-carrier="mymetropcs.com" href="#">Metro PCS</a></li>
                        <li><a data-carrier="qwestmp.com" href="#">Qwest</a></li>
                        <li><a data-carrier="pcs.rogers.com" href="#">Rogers</a></li>
                        <li><a data-carrier="messaging.sprintpcs.com" href="#">Sprint</a></li>
                        <li><a data-carrier="tmomail.net" href="#">T-Mobile</a></li>
                        <li><a data-carrier="msg.telus.com" href="#">Telus</a></li>
                        <li><a data-carrier="txt.att.net" href="#">Tracfone</a></li>
                        <li><a data-carrier="email.uscc.net" href="#">US Cellular</a></li>
                        <li><a data-carrier="uswestdatamail.com" href="#">US West</a></li>
                        <li><a data-carrier="vtext.com" href="#">Verizon</a></li>
                        <li><a data-carrier="vmobl.com" href="#">Virgin Mobile</a></li>
                        <li><a data-carrier="sms.3rivers.net" href="#">3 River Wireless</a></li>
                        <li><a data-carrier="paging.acswireless.com" href="#">ACS Wireless</a></li>
                        <li><a data-carrier="message.alltel.com" href="#">Alltel</a></li>
                        <li><a data-carrier="message.alltel.com" href="#">Bell Canada</a></li>
                        <li><a data-carrier="blueskyfrog.com" href="#">Blue Sky Frog</a></li>
                        <li><a data-carrier="sms.bluecell.com" href="#">Bluegrass Cellular</a></li>
                        <li><a data-carrier="myboostmobile.com" href="#">Boost Mobile</a></li>
                        <li><a data-carrier="bplmobile.com" href="#">BPL Mobile</a></li>
                        <li><a data-carrier="cwwsms.com" href="#">Carolina West Wireless</a></li>
                        <li><a data-carrier="mobile.celloneusa.com" href="#">Cellular One</a></li>
                        <li><a data-carrier="csouth1.com" href="#">Cellular South</a></li>
                        <li><a data-carrier="cwemail.com" href="#">Centennial Wireless</a></li>
                        <li><a data-carrier="messaging.centurytel.net" href="#">CenturyTel</a></li>
                        <li><a data-carrier="msg.clearnet.com" href="#">Clearnet</a></li>
                        <li><a data-carrier="comcastpcs.textmsg.com" href="#">Comcast</a></li>
                        <li><a data-carrier="corrwireless.net" href="#">Corr Wireless</a></li>
                        <li><a data-carrier="mobile.dobson.net" href="#">Dobson</a></li>
                        <li><a data-carrier="sms.edgewireless.com" href="#">Edge Wireless</a></li>
                        <li><a data-carrier="fido.ca" href="#">Fido</a></li>
                        <li><a data-carrier="sms.goldentele.com" href="#">Golden Telecom</a></li>
                        <li><a data-carrier="messaging.sprintpcs.com" href="#">Helio</a></li>
                        <li><a data-carrier="text.houstoncellular.net" href="#">Houston Cellular</a></li>
                        <li><a data-carrier="ideacellular.net" href="#">Idea Cellular</a></li>
                        <li><a data-carrier="ivctext.com" href="#">Illinois Valley Cellular</a></li>
                        <li><a data-carrier="inlandlink.com" href="#">Inland Cellular Telephone</a></li>
                        <li><a data-carrier="pagemci.com" href="#">MCI</a></li>
                        <li><a data-carrier="page.metrocall.com" href="#">Metrocall</a></li>
                        <li><a data-carrier="fido.ca" href="#">Microcell</a></li>
                        <li><a data-carrier="clearlydigital.com" href="#">Midwest Wireless</a></li>
                        <li><a data-carrier="mobilecomm.net" href="#">Mobilcomm</a></li>
                        <li><a data-carrier="text.mtsmobility.com" href="#">MTS</a></li>
                        <li><a data-carrier="messaging.nextel.com" href="#">Nextel</a></li>
                        <li><a data-carrier="pcsone.net" href="#">PCS One</a></li>
                        <li><a data-carrier="txt.bell.ca" href="#">President's Choice</a></li>
                        <li><a data-carrier="sms.pscel.com" href="#">Public Service Cellular</a></li>
                        <li><a data-carrier="pcs.rogers.com" href="#">Rogers Canada</a></li>
                        <li><a data-carrier="email.swbw.com" href="#">Southwestern Bell</a></li>
                        <li><a data-carrier="tms.suncom.com" href="#">Suncom</a></li>
                        <li><a data-carrier="mobile.surewest.com" href="#">Surewest Communicaitons</a></li>
                        <li><a data-carrier="tms.suncom.com" href="#">Triton</a></li>
                        <li><a data-carrier="utext.com" href="#">Unicel</a></li>
                        <li><a data-carrier="vmobile.ca" href="#">Virgin Mobile Canada</a></li>
                        <li><a data-carrier="sms.wcc.net" href="#">West Central Wireless</a></li>
                        <li><a data-carrier="cellularonewest.com" href="#">Western Wireless</a></li>
                     </ul>
                  </div>
               </div>
            -->

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
