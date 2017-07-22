<div class="container-fluid">
   <!-- Top Stats -->
   <div class="row">
      <div class="col-xs-12">
         <div class="col-xs-6">
            <div class="panel panel-default panel-heading-tile">
               <div class="panel-body" id="divGrossSales">
                  <h2><b><div class="text-center" id="grossSales"></div></b></h2>
                  <div class="panel-footer text-center" id="divGrossSales">
                     <small class="pull-right"><span id="infoGrossSales" class="glyphicon glyphicon-question-sign"></span></small>
                     <b>Gross Sales</b><br>
                     <b><div class="ly" id="grossSalesLy">&nbsp</div></b>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xs-6">
            <div class="panel panel-default panel-tile panel-heading-tile">
               <div class="panel-body" id="divDiscounts">
                  <h2><b><div class="text-center" id="checkAverage"></div></b></h2>
                  <div class="panel-footer text-center" id="divCheckAverage">
                     <b>Check Avg</b><br>
                     <b><div class="ly" id="checkAverageLy">&nbsp</div></b>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-xs-12">
         <div class="col-xs-6">
            <div class="panel panel-default panel-heading-tile">
               <div class="panel-body" id="divGrossSales">
                  <h2><b><div class="text-center" id="guestAverage"></div></b></h2>
                  <div class="panel-footer text-center" id="divGuestAverage">
                     <b>Guest Avg</b><br>
                     <b><div class="ly" id="guestAverageLy">&nbsp</div></b>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xs-6">
            <div class="panel panel-default panel-heading-tile">
               <div class="panel-body" id="divTotalEntrees">
                  <h2><b><div class="text-center" id="totalEntrees"></div></b></h2>
                  <div class="panel-footer text-center" id="divTotalEntrees">
                     <b>Entrees</b><br>
                     <b><div class="ly" id="totalEntreesLy">&nbsp</div></b>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>

      <div class="row">
         <div class="col-xs-12">
            <div class="col-xs-6">
               <div class="panel panel-default panel-heading-tile">
                  <div class="panel-body" id="divGrossSales">
                     <h2><b><div class="text-center" id="totalGuests"></div></b></h2>
                     <div class="panel-footer text-center" id="divTotalGuests">
                        <b>Guests</b><br>
                        <b><div class="ly" id="totalGuestsLy">&nbsp</div></b>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xs-6">
               <div class="panel panel-default panel-tile panel-heading-tile">
                  <div class="panel-body" id="divTotalChecks">
                     <h2><b><div class="text-center" id="totalChecks"></div></b></h2>
                     <div class="panel-footer text-center" id="divTotalChecks">
                        <b>Checks</b><br>
                        <b><div class="ly" id="totalChecksLy">&nbsp</div></b>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- End Top Stats -->

      <div class="row">
         <div class="col-lg-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <i class="fa fa-pie-chart-o fa-fw"></i><b>Payment Methods <small class="pull-right"><span id="infoPayment" class="glyphicon glyphicon-question-sign"></small></b>
               </div>
               <div class="panel-body" style="overflow-y: scroll">
                  <div class="col-lg-12">
                     <div id="paymentMethods"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <i class="fa fa-pie-chart-o fa-fw"></i><b>Profit Centers <small class="pull-right"><span id="infoProfitCenters" class="glyphicon glyphicon-question-sign"></small></b>
               </div>
               <div class="panel-body" style="overflow-y: scroll">
                  <div class="col-lg-12">
                     <div id="profitCenterDetails"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <i class="fa fa-pie-chart-o fa-fw"></i><b>Server Sales <small class="pull-right"><span id="infoServerSales" class="glyphicon glyphicon-question-sign"></small></b>
               </div>
               <div class="panel-body" style="overflow-y: scroll">
                  <div class="col-lg-12">
                     <div id="salesByServer"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <i class="fa fa-pie-chart-o fa-fw"></i><b>Hourly Sales <small class="pull-right"><span id="infoHourlySales" class="glyphicon glyphicon-question-sign"></small></b>
                  <b class="pull-right"><div class="btn-group bgTimeframe" role="group"><button type="button" class="btn btn-success btn-xs" id="btnHourly">Hour</button>&nbsp<button type="button" class="btn btn-default btn-xs" id="btnHalfHour">Half</button>&nbsp<button type="button" class="btn btn-default btn-xs" id="btnQtr">Quarter</button></div></b>
               </div>
               <div class="panel-body" style="overflow-y: scroll">
                  <div class="col-lg-12">
                     <div id="hourlySales"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <i class="fa fa-pie-chart-o fa-fw"></i><b>Mealtime Sales <small class="pull-right"><span id="infoMealtimeSales" class="glyphicon glyphicon-question-sign"></small></b>
               </div>
               <div class="panel-body" style="overflow-y: scroll">
                  <div class="col-lg-12">
                     <div id="mealtimeSales"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <i class="fa fa-pie-chart-o fa-fw"></i><b>Sales By Room<small class="pull-right"><span id="infoSalesByRoom" class="glyphicon glyphicon-question-sign"></small></b>
               </div>
               <div class="panel-body" style="overflow-y: scroll">
                  <div class="col-lg-12">
                     <div id="roomSales"></div>
                  </div>
               </div>
            </div>
         </div>
         <!--
         <div class="col-lg-6">
           <div class="panel panel-default">
              <div class="panel-heading">
                 <i class="fa fa-pie-chart-o fa-fw"></i><b>Table Turns by Room <small class="pull-right"><span id="infoTableTurns" class="glyphicon glyphicon-question-sign"></small></b>
              </div>
              <div class="panel-body" style="overflow-y: scroll">
                 <div class="col-lg-12">
                    <div id="tableTurns"></div>
                 </div>
              </div>
           </div>
         </div>
         -->
      </div>

   </div>

<script src="app/js/stupidtable.js"></script>

<script>

   refreshData();

   window.setInterval(function ()
   {
      if (localStorage.getItem("needUpdate") == 1)
      {
         var user = localStorage.getItem("user");
         var pass = localStorage.getItem("pass");
         var selectedStore = localStorage.getItem("selectedStore");
         var selectedDate = localStorage.getItem("selectedDate");
         var token = localStorage.getItem("token");
         var cg = localStorage.getItem("cg");
         var license = localStorage.getItem("license");
         refreshData();
         localStorage.setItem("needUpdate", 0);
      }
   }, 500);

   function refreshData()
   {
      var selectedStore = localStorage.getItem("selectedStore");
      var selectedDate = localStorage.getItem("selectedDate");
      var cg = localStorage.getItem("cg");

      hourlySales('hourly');

      var postData = { dateSelected: selectedDate, selectedStore: selectedStore, cg: cg };

      $.ajax({
         url: 'http://192.168.0.66:34295/salesOverview?XDEBUG_SESSION_START',
         dataType: 'json',
         crossDomain: true,
         method: 'post',
         data: postData,
         success: function (data)
         {
            $('#grossSales').html(data.gross);
            $('#checkAverage').html(data.checkavg);
            $('#guestAverage').html(data.guestavg);
            $('#totalChecks').html(data.checks);
            $('#totalGuests').html(data.guests);
            $('#totalEntrees').html(data.entrees);
         },
         error: function (data)
         {

         },
      });

      $.ajax({
         url: 'http://192.168.0.66:34295/paymentMethodHTML?XDEBUG_SESSION_START',
         dataType: 'html',
         crossDomain: true,
         method: 'post',
         data: postData,
         success: function (data)
         {
            $('#paymentMethods').html(data);
            $("#tblPmt").stupidtable();
         },
         error: function (data)
         {
         },
      });

      $.ajax({
         url: 'http://192.168.0.66:34295/profitCenterDetailsHTML?XDEBUG_SESSION_START',
         dataType: 'html',
         crossDomain: true,
         method: 'post',
         data: postData,
         success: function (data)
         {
            $('#profitCenterDetails').html(data);
            $("#tblPC").stupidtable();
         },
         error: function (data)
         {

         },
      });

      $.ajax({
         url: 'http://192.168.0.66:34295/salesByServerHTML?XDEBUG_SESSION_START',
         dataType: 'html',
         crossDomain: true,
         method: 'post',
         data: postData,
         success: function (data)
         {
            $('#salesByServer').html(data);
            $("#tblSBS").stupidtable();
         },
         error: function (data)
         {

         },
      });

      $.ajax({
         url: 'http://192.168.0.66:34295/mealtimeSalesHTML?XDEBUG_SESSION_START',
         dataType: 'html',
         crossDomain: true,
         method: 'post',
         data: postData,
         success: function (data)
         {
            $('#mealtimeSales').html(data);
            $("#tblMTS").stupidtable();
         },
         error: function (data)
         {

         },
      });

      $.ajax({
         url: 'http://192.168.0.66:34295/roomSalesHTML?XDEBUG_SESSION_START',
         dataType: 'html',
         crossDomain: true,
         method: 'post',
         data: postData,
         success: function (data)
         {
            $('#roomSales').html(data);
            $("#tblRoomSales").stupidtable();
         },
         error: function (data)
         {

         },
      });
   }

   function hourlySales(timeFrame)
   {
      var selectedStore = localStorage.getItem("selectedStore");
      var selectedDate = localStorage.getItem("selectedDate");
      var cg = localStorage.getItem("cg");
      postData = { dateSelected: selectedDate, selectedStore: selectedStore, cg: cg, timeFrame: timeFrame };

      $.ajax({
         url: 'http://192.168.0.66:34295/hourlySalesHTML?XDEBUG_SESSION_START',
         dataType: 'html',
         crossDomain: true,
         method: 'post',
         data: postData,
         success: function (data)
         {
            $('#hourlySales').html(data);
            $("#tblHourlySales").stupidtable();
         },
         error: function (data)
         {

         },
      });
   }

   $('#btnHourly').click(function (e)
   {
      $(".bgTimeframe > .btn").addClass("btn-default");
      $(".bgTimeframe > .btn").removeClass("btn-success");
      $("#btnHourly").addClass("btn-success");
      hourlySales('hourly');
   });

   $('#btnHalfHour').click(function (e)
   {
      $(".bgTimeframe > .btn").addClass("btn-default");
      $(".bgTimeframe > .btn").removeClass("btn-success");
      $("#btnHalfHour").addClass("btn-success");
      hourlySales('halfhour');
   });

   $('#btnQtr').click(function (e)
   {
      $(".bgTimeframe > .btn").addClass("btn-default");
      $(".bgTimeframe > .btn").removeClass("btn-success");
      $("#btnQtr").addClass("btn-success");
      hourlySales('quarter');
   });


   $('#btnHourly').click(function(e)
   {
      $(".bgTimeframe > .btn").addClass("btn-default");
      $(".bgTimeframe > .btn").removeClass("btn-success");
      $("#btnHourly").addClass("btn-success");
      hourlySales(postData, 'hourly');
   });

   $('#btnHalfHour').click(function(e)
   {
      $(".bgTimeframe > .btn").addClass("btn-default");
      $(".bgTimeframe > .btn").removeClass("btn-success");
      $("#btnHalfHour").addClass("btn-success");
      hourlySales(postData, 'halfhour');
   });

   $('#btnQtr').click(function(e)
   {
      $(".bgTimeframe > .btn").addClass("btn-default");
      $(".bgTimeframe > .btn").removeClass("btn-success");
      $("#btnQtr").addClass("btn-success");
      hourlySales(postData, 'quarter');
   });

   $(document).on('click', '#tblPmt tr', function (e)
   {
      var rid = this.id.substring(3);
      var user = localStorage.getItem("user");
      var pass = localStorage.getItem("pass");
      var selectedStore = localStorage.getItem("selectedStore");
      var date = localStorage.getItem("selectedDate");
      var token = localStorage.getItem("token");
      var rpowerCG = localStorage.getItem("cg");
      var license = localStorage.getItem("license");
      k3PaymentCheckList(token, rpowerCG, selectedStore, date, rid, license);
   });

   $('#infoPayment').click(function (e)
   {
      $('#mGHeader').html('<h3>Payments Grid</h3>');
      $('#mGBody').html('This is a net payment amount that includes Hash (I.E. Deposits and Gift Card Sales) <br /> * Indicates hash');
      $('#modalGeneric').modal("show");
   });

   $('#infoServerSales').click(function (e)
   {
      $('#mGHeader').html('<h3>Server Sales Grid</h3>');
      $('#mGBody').html('Matches with Server Sales on the Close Day Report. Does not include \'House Grat\' or other grats that are retained by the house and not paid to a staff member. Does not include Hash (I.E. Deposits and Gift Card Sales)');
      $('#modalGeneric').modal("show");
   });

   $('#infoProfitCenters').click(function (e)
   {
      $('#mGHeader').html('<h3>Profit Center Grid</h3>');
      $('#mGBody').html('Matches with the Profit Centers in \'Sales Totals\' on the Close Day Report. Includes Hash (I.E. Deposits and Gift Card Sales)');
      $('#modalGeneric').modal("show");
   });

   $('#infoHourlySales').click(function (e)
   {
      $('#mGHeader').html('<h3>Hourly Sales Grid</h3>');
      $('#mGBody').html('Shows sales by the time the item was added to the check. Does not include Hash (I.E. Deposits and Gift Card Sales)');
      $('#modalGeneric').modal("show");
   });

   $('#infoMealtimeSales').click(function (e)
   {
      $('#mGHeader').html('<h3>Mealtime Sales Grid</h3>');
      $('#mGBody').html('Shows sales by Mealtime. Matches with Mealtime on the Close Day Report. Does not include Hash (I.E. Deposits and Gift Card Sales)');
      $('#modalGeneric').modal("show");
   });

   $('#infoGrossSales').click(function (e)
   {
      $('#mGHeader').html('<h3>Gross Sales</h3>');
      $('#mGBody').html('This is a gross amount that includes Hash items such as Deposits and Gift Card Sales but does not include Open Checks. <br /><b>Calculation: Item Sales - Discounts + Tax + Tips/Grat + Hash - Paid-Outs = Gross</b>');
      $('#modalGeneric').modal("show");
   });

   $('#infoTableTurns').click(function (e)
   {
      $('#mGHeader').html('<h3>Table Turns</h3>');
      $('#mGBody').html('This shows the total guests, entrees, beverages, and average time checks have been open on a table. For more accurate data, servers should close checks out in a timely manner.</b>');
      $('#modalGeneric').modal("show");
   });

   $('#infoSalesByRoom').click(function (e)
   {
      $('#mGHeader').html('<h3>Sales By Room</h3>');
      $('#mGBody').html('This shows sales by room.');
      $('#modalGeneric').modal("show");
   });



</script>