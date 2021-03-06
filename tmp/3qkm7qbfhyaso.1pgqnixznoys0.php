<div class="container-fluid col-xs-12">
   <div id="divSales" class="container-fluid">
      <div class="row">
         <div class="col-xs-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <i class="fa fa-pie-chart-o fa-fw"></i><b>Discounts</b>
               </div>
               <div class="panel-body">
                  <div class="col-xs-12">
                     <div class=" font-12px" id="divDiscountDetails"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <i class="fa fa-pie-chart-o fa-fw"></i><b>Voids</b>
               </div>
               <div class="panel-body">
                  <div class="col-xs-12">
                     <div class=" font-12px" id="divVoidDetails"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="app/js/stupidtable.js"></script>

<script>
window.setInterval(function()
{
   if (localStorage.getItem("needUpdate") == 1)
   {
      var user = localStorage.getItem("user");
      var pass = localStorage.getItem("pass");
      var selectedStore = localStorage.getItem("selectedStore");
      var selectedDate = localStorage.getItem("selectedDate");
      var token = localStorage.getItem("token");
      var cg = localStorage.getItem("cg");
      //var uuid = localStorage.getItem("uuid");
      var license = localStorage.getItem("license");
      //refreshData(user, pass, cg, selectedStore, token, selectedStore, selectedDate, uuid, license);
      refreshData(user, pass, cg, selectedStore, token, selectedStore, selectedDate, license);
      localStorage.setItem("needUpdate", 0);
   }
}, 500);

var user = localStorage.getItem("user");
var pass = localStorage.getItem("pass");
var selectedStore = localStorage.getItem("selectedStore");
var selectedDate = localStorage.getItem("selectedDate");
var token = localStorage.getItem("token");
var cg = localStorage.getItem("cg");
// var uuid = localStorage.getItem("uuid");
var license = localStorage.getItem("license");
// refreshData(user, pass, cg, selectedStore, token, selectedStore, selectedDate, uuid, license);
refreshData(user, pass, cg, selectedStore, token, selectedStore, selectedDate, license);
$('#error').hide();

function refreshData(user, pass, rpowerCG, rpowerStore, token, selectedStore, selectedDate, license)
{
   postData = {user: user, pass: pass, cg: rpowerCG, selectedStore: selectedStore, token: token, selectedStore: selectedStore, selectedDate: selectedDate, license: license};

   $.ajax({
      url: 'http://192.168.0.66:34295/discountDetailsHTML?XDEBUG_SESSION_START',
      dataType: 'html',
      crossDomain: true,
      method: 'post',
      data: postData,
      success: function (data)
      {
         $('#divDiscountDetails').html(data);
         $("#tblDiscountDetails").stupidtable();
      },
      error: function (data)
      {
         errorHandler(data);
      },
   });

   $.ajax({
      url: 'http://192.168.0.66:34295/voidDetailsHTML?XDEBUG_SESSION_START',
      dataType: 'html',
      crossDomain: true,
      method: 'post',
      data: postData,
      success: function (data)
      {
         $('#divVoidDetails').html(data);
         $("#tblVoidDetails").stupidtable();
      },
      error: function (data)
      {
         errorHandler(data);
      },
   });
}

   $('tr[id^="aRID"]').click(function (e)
   {
      var date = localStorage.getItem('dateSelected');
      k3ReconstructCheck(this.dataset.rid, date);
   });

</script>
