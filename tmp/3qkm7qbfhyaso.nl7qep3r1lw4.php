<script src="js/stupidtable.js"></script>  
<script>
   $("#return").hide();
   $("#btnRealtimeBack").hide();
   $("#divRealtimeDetail").hide();

     $("#btnCheckGo").click(function(e)
     {
        var date = checkDate.value;
        var checkNumber = $('#checkNumber').val();
        
        k3FindCheckRID(date, checkNumber).then(function (ticketRID)
        {
           if (ticketRID == null)
           {
              $('#mGHeader').html("<h2>Error</h2>");
              $('#mGBody').html("<small>Check not found</small>");
              $('#modalGeneric').modal("show");
           }
           else
           {
              rid = ticketRID[0].rid;
              var isMobile = localStorage.getItem('isMobile');
              k3ReconstructCheck(rid, date, isMobile);
           }
        });
     });

     $("#btnChangePassGo").click(function (e)
     {
        if ($('#passwordNew').val() == $('#passwordConfirm').val() && $('#passwordNew').val() != "" && $('#passwordConfirm').val() != "")
        {
           var user = localStorage.getItem('user');
           var oldPass = $('#passwordOld').val();
           var newPass = $('#passwordNew').val();
           // var url = 'http://192.168.0.66:34295';
           var url = 'http://rpower.com:1337';

           var postData = { user: user, oldPass: oldPass, newPass: newPass };

           $.ajax({
              url: url + '/changePassword?XDEBUG_SESSION_START',
              dataType: 'html',
              crossDomain: true,
              method: 'post',
              data: postData,
              success: function (data)
              {
                 var status = JSON.parse(data);
                 if (status.status == 201)
                 {
                    $('#return').html('\
                        <div class="alert alert-success" role="alert"> \
                           <strong>Password Changed</strong> \
                        </div>');
                    $("#return").show();
                 }
                 else if (status.status == 401)
                 {
                    $('#return').html('\
                        <div class="alert alert-danger" role="alert"> \
                           <strong>Error</strong> \
                        </div>');
                    $("#return").show();
                 }
              },
              error: function (data)
              {
                 errorHandler(data);
                 $('#return').html('\
                        <div class="alert alert-danger" role="alert"> \
                           <strong>Error</strong> \
                        </div>');
                 $("#return").show();
              },
           });
        }
        else
        {

        }
        
     });

     $("#btnRealtimeChecks").click(function (e)
     {
        var storeMID = localStorage.getItem("selectedStore");
        var userID = localStorage.getItem("userID");
        var user = localStorage.getItem("user");
        var pass = localStorage.getItem("pass");
        var cg = localStorage.getItem("cg");
        var token = localStorage.getItem("token");
        var license = localStorage.getItem("license");
        var serial = localStorage.getItem("serial");

        var postData = { userID: userID, storeMID: storeMID, license: license, token: token, user: user, pass: pass, isMobile: 1, serial: serial };
        //var url = 'http://192.168.0.66:34295';
        var url = 'http://rpower.com:1337';

        $('#divRealtimeChecks').html('Please wait. This operation may take up to 30 seconds to complete depending on the response time from the store.');
        
        $.ajax({
           url: url + '/realtimeCheckList?XDEBUG_SESSION_START',
           method: 'post',
           dataType: 'html',
           data: postData,
           crossDomain: true,
           success: function (data)
           {
              if (data.indexOf('>') == -1) // Not html, we're getting an error back
              {
                 var status = JSON.parse(data);
                 if (status.status == 408)
                 {
                    // Store offline
                    $('#divRealtimeChecks').html('\
                        <div class="alert alert-danger text-center" role="alert"> \
                           <strong>Store Offline</strong> \
                        </div>');
                    console.log('STORE POLL TIMEOUT');
                    exit;
                 }
              }

              $('#divRealtimeChecks').html(data);
              $('#tblRealtimeCheckList').stupidtable();
              $('tr[id^="RID"]').click(function (e)
              {
                 var rid = this.dataset.rid
                 postData = { userID: userID, storeMID: storeMID, license: license, token: token, user: user, pass: pass, isMobile: 1, rid: rid, serial: serial};
                 var date = localStorage.getItem('dateSelected');
                 var isMobile = localStorage.getItem('isMobile');

                 $.ajax({
                    url: url + '/realtimeCheckDetail?XDEBUG_SESSION_START',
                    method: 'POST',
                    dataType: 'HTML',
                    data: postData,
                    crossDomain: true,
                    success: function (data)
                    {
                       $("#btnRealtimeChecks").hide();
                       $('#divRealtimeChecks').hide();
                       $('#divRealtimeDetail').html(data);
                       $("#btnRealtimeBack").show();
                       $("#divRealtimeDetail").show();
                    },
                    error: function (data)
                    {
                       errorHandler(data);
                    },
                    timeout:30000
                 });


              });
           },
           error: function (data)
           {
              $('#divRealtimeChecks').html('\
                        <div class="alert alert-danger text-center" role="alert"> \
                           <strong>Store Offline</strong> \
                        </div>');
              console.log('STORE POLL TIMEOUT');
              errorHandler(data);
           }
        });
     });

     $('#igNewPass').change(function ()
     {
        var test = $('#passwordNew').val();
        if ($('#passwordNew').val() != $('#passwordConfirm').val())
        {
           $('#igNewPass').removeClass('has-success');
           $('#igConfirmPass').removeClass('has-success');
           $('#igNewPass').addClass('has-error');
           $('#igConfirmPass').addClass('has-error');
        }
        else if ($('#passwordNew').val() == $('#passwordConfirm').val())
        {
           $('#igNewPass').removeClass('has-error');
           $('#igConfirmPass').removeClass('has-error');
           $('#igNewPass').addClass('has-success');
           $('#igConfirmPass').addClass('has-success');
        }
     });

     $('#igConfirmPass').change(function ()
     {
        var test = $('#passwordConfirm').val();
        if ($('#passwordNew').val() != $('#passwordConfirm').val())
        {
           $('#igNewPass').removeClass('has-success');
           $('#igConfirmPass').removeClass('has-success');
           $('#igNewPass').addClass('has-error');
           $('#igConfirmPass').addClass('has-error');
        }
        else if ($('#passwordNew').val() == $('#passwordConfirm').val())
        {
           $('#igNewPass').removeClass('has-error');
           $('#igConfirmPass').removeClass('has-error');
           $('#igNewPass').addClass('has-success');
           $('#igConfirmPass').addClass('has-success');
        }
     });

     $("#btnRealtimeBack").click(function ()
     {
        $("#btnRealtimeBack").hide();
        $("#divRealtimeDetail").hide();
        $("#btnRealtimeChecks").show();
        $('#divRealtimeChecks').show();
     });

  </script>

<div class="container-fluid">
   <div class="col-xs-12 col-sm-6">
      <div class="panel panel-default">
         <div class="panel-heading centered">
            <i class="fa fa-pie-chart-o fa-fw"></i><b>Check Lookup</b>
         </div>
         <div class="panel-body" style="overflow-y: none">
            <hr>
            <div class="row">
               <div class="col-xs-12">
                  <input id="checkNumber" class="input-sm" type="number" placeholder="check number"></input>
               </div>
            </div>
            <div class="row">
               <div class="col-xs-12">
                  <input id="checkDate" class="input-sm" type="date" placeholder="date"></input>
               </div>
            </div>
            <hr>
         </div>
         <div class="panel-footer centered" style="overflow-y: none">
            <button type="button" id="btnCheckGo" class="btn btn-primary">Go</button>
         </div>
      </div>
   </div>
</div>

<?php if ($rtc): ?>
   <div class="container-fluid">
      <div class="col-xs-12 col-sm-6">
         <div class="panel panel-default">
            <div class="panel-heading centered">
               <i class="fa fa-pie-chart-o fa-fw"></i><b>Realtime Check Information</b>
            </div>
            <div class="panel-body" style="overflow-y: none">
               <hr>
               <div id="divRealtimeChecks">

               </div>
               <div id="divRealtimeDetail">

               </div>
               <hr>
            </div>
            <div class="panel-footer centered" style="overflow-y: none">
               <button type="button" id="btnRealtimeChecks" class="btn btn-primary">Get Checks From POS</button>
               <button type="button" id="btnRealtimeBack" class="btn btn-primary">Back</button>
            </div>
         </div>
      </div>
   </div>
<?php endif; ?>

   <div class="container-fluid">
      <div class="col-xs-12 col-sm-6">
         <div class="panel panel-default">
            <div class="panel-heading centered">
               <i class="fa fa-pie-chart-o fa-fw"></i><b>Change Password</b>
            </div>
            <div class="panel-body" style="overflow-y: none">
               <hr>
               <div class="row">
                  <div class="col-xs-12">
                     <div class="input-group" id="igOldPass">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="passwordOld" type="password" class="form-control" name="tbOldPass" placeholder="Old Password">
                     </div>
                  </div>
                  <div class="col-xs-12">
                     <div class="input-group" id="igNewPass">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="passwordNew" type="password" class="form-control" name="tbNewPass" placeholder="New Password">
                     </div>
                  </div>
                  <div class="col-xs-12">
                     <div class="input-group" id="igConfirmPass">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="passwordConfirm" type="password" class="form-control" name="tbConfirmPass" placeholder="Confirm Password">
                     </div>
                  </div>
               </div>
            </div>
            <br />
            <div id="return" class="text-center">

            </div>
            <hr />
            <div class="panel-footer centered" style="overflow-y: none">
               <button type="button" id="btnChangePassGo" class="btn btn-primary">Go</button>
            </div>
         </div>
      </div>
   </div>
