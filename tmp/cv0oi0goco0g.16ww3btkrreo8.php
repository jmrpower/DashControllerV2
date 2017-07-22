      <div class="row">
         <div class="col-xs-12">
            <div class="col-xs-6">
               <div class="panel panel-default panel-heading-tile">
                  <div class="panel-body">
                     <h2 class="divNetSales" id="divNetSales"><b><div class="text-center" id="itemSales"></div></b></h2>
                     <div class="panel-footer text-center">
                        <b>Net</b><br /><span class="pull-left glyphicon glyphicon-question-sign" id="infoNetSales"></span><span class="divGrossSales pull-right glyphicon glyphicon-circle-arrow-right"></span>
                        <b><div class="ly" id="divNetSalesLY">&nbsp</div></b>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xs-6">
               <div class="panel panel-default panel-tile panel-heading-tile">
                  <div class="panel-body">
                     <h2 class="divDiscounts" id="divDiscounts"><b><div class="text-center" id="totalDiscounts"></div></b></h2>
                     <div class="panel-footer text-center">
                        <b>Disc</b><br /><span class="divDiscounts pull-right glyphicon glyphicon-circle-arrow-right"></span>
                        <b><div class="ly" id="divDiscountsLY">&nbsp</div></b>
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
                  <div class="panel-body">
                     <h2 class="divLaborPct" id="divLaborPercent"><b><div class="text-center" id="laborPercent"></div></b></h2>
                     <div class="panel-footer text-center">
                        <b>Labor %</b><br /><span class="divLaborPct pull-right glyphicon glyphicon-circle-arrow-right"></span>
                        <b><div class="ly" id="divLaborPercentLY">&nbsp</div></b>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xs-6">
               <div class="panel panel-default panel-tile panel-heading-tile">
                  <div class="panel-body">
                     <h2 class="divLaborDollars" id="divLaborDollars"><b><div class="text-center" id="totalLaborCost"></div></b></h2>
                     <div class="panel-footer text-center">
                        <b>Labor $</b><br /><span class="divLaborDollars pull-right glyphicon glyphicon-circle-arrow-right"></span>
                        <b><div class="ly" id="divLaborDollarsLY">&nbsp</div></b>
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
                  <div class="panel-body">
                     <h2 class="divGuestCount" id="divGuestCount"><b><div class="text-center" id="guests"></div></b></h2>
                     <div class="panel-footer text-center">
                        <b>Guests</b><br /><span class="divGuestCount pull-right glyphicon glyphicon-circle-arrow-right"></span>
                        <b><div class="ly text-center"> <p id="divGuestCountLY"></p></div></b>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xs-6">
               <div class="panel panel-default panel-heading-tile">
                  <div class="panel-body">
                     <h2 class="divTotalChecks" id="divTotalChecks"><b><div class="text-center" id="checks"></div></b></h2>
                     <div class="panel-footer text-center">
                        <b>Checks</b><br /><span class="divTotalChecks pull-right glyphicon glyphicon-circle-arrow-right"></span>
                        <b><div class="ly"><p id="divTotalChecksLY"></p></div></b>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

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

         var postData = { dateSelected: selectedDate, selectedStore: selectedStore, cg: cg };

         $.ajax({
            url: 'http://192.168.0.66:34295/dashDataEcho?XDEBUG_SESSION_START',
            dataType: 'json',
            crossDomain: true,
            method: 'post',
            data: postData,
            success: function (data)
            {
               console.log(data);
               $('#itemSales').html(data.net);
               $('#totalDiscounts').html(data.discounts);
               $('#laborPercent').html(data.laborPct);
               $('#totalLaborCost').html(data.laborCost);
               $('#guests').html(data.guests);
               $('#checks').html(data.checks);

               $('#divNetSalesLY').html("LY: " + data.netLY);
               $('#divDiscountsLY').html("LY: " + data.discountsLY);
               $('#divLaborPercentLY').html("LY: " + data.laborPctLY);
               $('#divLaborDollarsLY').html("LY: " + data.laborCostLY);
               $('#divGuestCountLY').html("LY: " + data.guestsLY);
               $('#divTotalChecksLY').html("LY: " + data.checksLY);
            },
            error: function (data)
            {
               errorHandler(data);
            },
         });
      }

      $('.divGrossSales').click(function (e)
      {
         $("#error").hide();
         $("#body").html("");
         localStorage.setItem("lastPage", "sales");
         $("#body").load("sales.html");
      });

      $('.divDiscounts').click(function (e)
      {
         $("#error").hide();
         $("#body").html("");
         localStorage.setItem("lastPage", "disvoid");
         $("#body").load("disvoid.html");
      });

      $('.divLaborPct').click(function (e)
      {
         $("#error").hide();
         $("#body").html("");
         localStorage.setItem("lastPage", "labor");
         $("#body").load("labor.html");
      });

      $('.divLaborDollars').click(function (e)
      {
         $("#error").hide();
         $("#body").html("");
         localStorage.setItem("lastPage", "labor");
         $("#body").load("labor.html");
      });

      $('.divGuestCount').click(function (e)
      {
         $("#error").hide();
         $("#body").html("");
         localStorage.setItem("lastPage", "sales");
         $("#body").load("sales.html");
      });

      $('.divTotalChecks').click(function (e)
      {
         $("#error").hide();
         $("#body").html("");
         localStorage.setItem("lastPage", "sales");
         $("#body").load("sales.html");
      });

      $('#infoNetSales').click(function (e)
      {
         $('#mGHeader').html('<h3>Net Sales</h3>');
         $('#mGBody').html('This is a net amount that includes open checks but does not include Hash items such as Deposits and Gift Card Sales. This number can decrease due to discounts being added to checks.<br /> <b>Calculation: Item Sales - Discounts - Grat/Tips - Tax - Paid-Outs + \'House Grat\' = Net</b>');
         $('#modalGeneric').modal("show");
      });

   $('#infoNetSales').click(function (e)
   {
      $('#mGHeader').html('<h3>Net Sales</h3>');
      $('#mGBody').html('This is a net amount that includes open checks but does not include Hash items such as Deposits and Gift Card Sales. This number can decrease due to discounts being added to checks.<br /> <b>Calculation: Item Sales - Discounts - Grat/Tips - Tax - Paid-Outs + \'House Grat\' = Net</b>');
      $('#modalGeneric').modal("show");
   });

</script>
