  <script>
  $("#btnCheckGo").click(function(e)
  {
     var user = localStorage.getItem("user");
     var pass = localStorage.getItem("pass");
     var selectedStore = localStorage.getItem("selectedStore");
     var date = checkDate.value;
     var token = localStorage.getItem("token");
     var rpowerCG = localStorage.getItem("cg");
     //var uuid = localStorage.getItem("uuid");
     var license = localStorage.getItem("license");
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

  </script>

<div class="container-fluid">
   <div class="col-xs-6">
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
