<?php

/**
 * Sales short summary.
 *
 * Sales description.
 *
 * @version 1.0
 * @author Justin
 */

//require('app/utils/k3utils.php');
//require('app/controllers/Overview.php');
//require('app/utils/TableBuilder.php');

class Sales extends Controller
{

   /*
    *
    *
    *
    * Output Functions
    *
    *
    *
    *
    */



   function paymentMethodHTML()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.dateSelected');
      $cg = $this->f3->get('POST.cg');
      $pmtGT = 0;

      $data = self::paymentMethodDetails($storeMID, $date, $cg);

      $ret = "<table id=\"tblPmt\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>Name</b> <br /></th>";
      $ret .= "<th class=\"text-center\"><b>Net<br>*Hash</b> <br /></th>
               <th class=\"text-center\"><b>Tax</b> <br /></th>
               <th class=\"text-center\"><b>Tip</b> <br /></th>
               <th class=\"text-center\"><b>Gross</b> <br /></th>
               </tr>
               <tr>
               <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               </tr>
               </thead>";

      foreach ($data as $out)
      {
         if (isset($out[pmid]))
         {
            $amt = number_format($out[amt]-$out[tax]-$out[grat], 2);
            $hash = number_format($out[hash], 2);
            $tax = number_format($out[tax], 2);
            $grat = number_format($out[grat], 2);
            $tip = number_format($out[tip], 2);
            $tg = number_format($grat + $tip, 2);
            $pmtGT = number_format($out[amt] + $tg, 2);
            $amtSort = $out[amt]-$out[tax]-$out[grat];
            $taxSort = $out[tax];
            $tgSort = $grat + $tip;
            $pmtGTSort = $out[amt] + $tg;

            $ret .= "<tr id=\"PMT$out[pmid]\">";
            $ret .= "<td class=\"text-right\"><a data-pmMID=\"$out[pmid]\">$out[payment]</a></td>";
            if ($out[hash] > 0)
            {
               $ret .= "<td class=\"text-right hash\" data-sort-value=\"$amtSort\">$amt<br> <b>*$hash</b></td>";
            }
            else
            {
               $ret .= "<td class=\"text-right hash\" data-sort-value=\"$amtSort\">$amt</td>";
            }

            $ret .= "<td class=\"text-right\" data-sort-value=\"$taxSort\">$tax</td>";
            $ret .= "<td class=\"text-right\" data-sort-value=\"$tgSort\">$tg</td>";
            $ret .= "<td class=\"text-right\" data-sort-value=\"$pmtGTSort\">$pmtGT</td>";
            $ret .= "</tr>";
         }
         if (isset($data[paidIO]))
         {
            $adj = $data[paidIO];
         }
      }

      $amtGT = array_sum(array_column($data, 'amt'));
      $hashGT = array_sum(array_column($data, 'hash'));
      $taxGT = array_sum(array_column($data, 'tax'));
      $tipGT = array_sum(array_column($data, 'tip'));
      $gratGT = array_sum(array_column($data, 'grat'));
      $amtSubGT = number_format($amtGT - $hashGT - $taxGT - $gratGT, 2);
      $amtGT = $amtGT - $taxGT - $gratGT;
      $tgGT = $tipGT + $gratGT;
      $totalGT = $amtGT + $tipGT + $taxGT + $gratGT;
      $amtGT = number_format($amtGT, 2);
      //$totalGT = number_format($totalGT, 2);


      $totalGT -= $adj;

      $adj *= -1; // Flip to neg for display

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "<tr>";
      $ret .= "<th class=\"text-right\"><b> - Paid Outs</b> </th>";
      $ret .= "<th class=\"text-right\"><b>$adj</b></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"><b>$adj</b></th>";
      $ret .= "</tr>";
      $ret .= "<tr><th class=\"text-right\"><b>Sub: <br> Hash: <br> Grand:</b></th>";
      $ret .= "<th class=\"text-right\"><b>$amtSubGT <br> $hashGT <br> $amtGT</b></th>";
      $ret .= "<th class=\"text-right\"><b><br><br>$taxGT</b></th>";
      $ret .= "<th class=\"text-right\"><b><br><br>$tgGT</b></th>";
      $ret .= "<th class=\"text-right\"><b><br><br>$totalGT</b></th>";
      $ret .= "</tr></tfoot>";

      echo $ret;
   }

   function profitCenterDetailsHTML()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.dateSelected');
      $cg = $this->f3->get('POST.cg');

      $pmtGT = 0;

      $data = self::profitCenterDetails($storeMID, $date, $cg);

      $ret = "<table id=\"tblPC\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>Name <br /></th>";
      $ret .= "<th class=\"text-center\"><b>Net<br>*Hash</b> <br /></th>
               <th class=\"text-center\"><b>Tax</b> <br /></th>
               <th class=\"text-center\"><b>Tip</b> <br /></th>
               <th class=\"text-center\"><b>Gross</b> <br /></th>
               </tr>
               <tr>
               <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               </tr>
               </thead>";

      foreach ($data as $out)
      {
         if (isset($out[totalSales]))
         {
            $amt = number_format($out[totalSales]+$out[totalDiscounts], 2);
            $hash = number_format($out[hash], 2);
            $tax = number_format($out[totalTax], 2);
            $grat = number_format($out[grat], 2);
            $tip = number_format($out[totalTip], 2);
            $tg = number_format($grat + $tip, 2);
            $pmtGT = number_format($out[amt] + $tg, 2);
            $amtSort = $out[totalSales]+$out[totalDiscounts];
            $taxSort = $out[totalTax];
            $tgSort = $grat + $tip;
            $pmtGTSort = $out[totalSales] + $tg;

            $ret .= "<tr id=\"PMT$out[pmid]\">";
            $ret .= "<td class=\"text-right\">$out[profitCenterName]</td>";
            if ($out[hash] > 0)
            {
               $ret .= "<td class=\"text-right hash\" data-sort-value=\"$amtSort\">$amt<br> <b>*$hash</b></td>";
            }
            else
            {
               $ret .= "<td class=\"text-right hash\" data-sort-value=\"$amtSort\">$amt</td>";
            }

            $ret .= "<td class=\"text-right\" data-sort-value=\"$taxSort\">$tax</td>";
            $ret .= "<td class=\"text-right\" data-sort-value=\"$tgSort\">$tg</td>";
            $ret .= "<td class=\"text-right\" data-sort-value=\"$pmtGTSort\">$pmtGT</td>";
            $ret .= "</tr>";
         }
         if (isset($data[paidIO]))
         {
            $adj = $data[paidIO];
         }
      }

      $amtGT = array_sum(array_column($data, 'totalSales'));
      $hashGT = array_sum(array_column($data, 'hash'));
      $taxGT = array_sum(array_column($data, 'totalTax'));
      $tipGT = array_sum(array_column($data, 'totalTip'));
      $gratGT = array_sum(array_column($data, 'grat'));
      $totalDiscounts = array_sum(array_column($data, 'totalDiscounts'));
      $amtSubGT = number_format($amtGT + $totalDiscounts, 2);
      $tgGT = $tipGT + $gratGT;
      $totalGT = $amtGT + $hashGT + $tgGT + $taxGT + $totalDiscounts;
      $amtGT = $amtGT + $totalDiscounts - $adj + $hashGT;
      $amtGT = number_format($amtGT, 2);
      //$totalGT = number_format($totalGT, 10);

      $totalGT -= $adj;

      $adj *= -1; // Flip to neg for display

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "<tr>";
      $ret .= "<th class=\"text-right\"><b> - Paid Outs</b> </th>";
      $ret .= "<th class=\"text-right\"><b>$adj</b></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"><b>$adj</b></th>";
      $ret .= "</tr>";
      $ret .= "<tr><th class=\"text-right\"><b>Sub: <br> Hash: <br> Grand:</b></th>";
      $ret .= "<th class=\"text-right\"><b>$amtSubGT <br> $hashGT <br> $amtGT</b></th>";
      $ret .= "<th class=\"text-right\"><b><br><br>$taxGT</b></th>";
      $ret .= "<th class=\"text-right\"><b><br><br>$tgGT</b></th>";
      $ret .= "<th class=\"text-right\"><b><br><br>$totalGT</b></th>";
      $ret .= "</tr></tfoot>";

      echo $ret;
   }

   function salesByServerHTML()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.dateSelected');
      $cg = $this->f3->get('POST.cg');

      $pmtGT = 0;

      $data = self::salesByServer($storeMID, $date, $cg);

      $ret = "<table id=\"tblSBS\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>Name</b></th>";
      $ret .= "<th class=\"text-center\"><b>Net<br>*Hash</b></th>
               <th class=\"text-center\"><b>Chks<br />Avg</b></th>
               <th class=\"text-center\"><b>Gsts<br />Avg</b></th>
               <th class=\"text-center\"><b>Tip / Grat<br /><!-- % --></b></th>
               </tr>
               <tr>
               <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               </tr>
               </thead>";

      foreach ($data as $out)
      {
         if (isset($out[totalSales]))
         {
            $amt = $out[totalSales] - $out[totalGrat] - $out[totalTax] - $out[subtractGrat];
            $hash = number_format($out[totalHash], 2);
            $tax = number_format($out[totalTax], 2);
            $grat = number_format($out[totalGrat], 2);
            $tip = number_format($out[totalTip], 2);
            $tg = number_format($grat + $tip, 2);
            $pmtGT = number_format($out[amt] + $tg, 2);
            $gsts = $out[totalGuests];
            $chks = $out[totalChecks];
            $gstAvg = $amt / $gsts;
            $chkAvg = $amt / $chks;
            $gstAvg = number_format($gstAvg, 2);
            $chkAvg = number_format($chkAvg, 2);

            if ($out[totalTip] > 0)
            {
               //$tipPct = $tg / $out[alloc];
               //$tipPct = number_format($tipPct *100, 2);
            }
            else
            {
               $tipPct = 0;
            }

            $amt = number_format($amt, 2);


            $ret .= "<tr id=\"PMT$out[pmid]\">";
            $ret .= "<td class=\"text-right\">$out[name]</td>";

            if ($out[totalHash] > 0)
            {
               $ret .= "<td class=\"text-right hash\">$amt<br> <b>*$hash</b></td>";
            }
            else
            {
               $ret .= "<td class=\"text-right hash\">$amt</td>";
            }

            $ret .= "<td class=\"text-right\">$chks<br>$chkAvg</td>";
            $ret .= "<td class=\"text-right\">$gsts<br>$gstAvg</td>";
            $ret .= "<td class=\"text-right\">$tg<br><!-- $tipPct% --></td>";
            $ret .= "</tr>";
         }
         if (isset($data[paidIO]))
         {
            $adj = $data[paidIO];
         }
      }

      $amtGT = array_sum(array_column($data, 'totalSales'));
      $hashGT = array_sum(array_column($data, 'totalHash'));
      $tipGT = array_sum(array_column($data, 'totalTip'));
      $gratGT = array_sum(array_column($data, 'totalGrat'));
      $subtractGratGT = array_sum(array_column($data, 'subtractGrat'));
      $totalDiscounts = array_sum(array_column($data, 'totalDiscounts'));
      $checksGT = array_sum(array_column($data, 'totalChecks'));
      $guestsGT = array_sum(array_column($data, 'totalGuests'));
      $tgGT = number_format($tipGT + $gratGT, 2);
      //$totalGT = $amtGT + $hashGT + $tgGT + $taxGT + $totalDiscounts;
      $amtGT = $amtGT - $taxGT - $subtractGratGT + $hashGT;
      $amtSubGT = number_format($amtGT - $hashGT, 2);
      $totalGT = number_format($amtGT + $taxGT + $tipGT + $gratGT, 2);
      $amtGT = number_format($amtGT, 2);

      $totalGT -= $adj;

      $adj *= -1; // Flip to neg for display

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "<tr>";
      $ret .= "<th class=\"text-right\"> - Paid Outs </th>";
      $ret .= "<th class=\"text-right\">$adj</th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\">$adj</th>";
      $ret .= "</tr>";
      $ret .= "<tr><th class=\"text-right\"><b>Sub: <br> Hash: <br> Grand:</b></th>";
      $ret .= "<th class=\"text-right\"><b>$amtSubGT <br> $hashGT <br> $amtGT</b></th>";
      $ret .= "<th class=\"text-right\"><b><br><br>$checksGT</b></th>";
      $ret .= "<th class=\"text-right\"><b><br><br>$guestsGT</b></th>";
      $ret .= "<th class=\"text-right\"><b><br><br>$tgGT</b></th>";
      $ret .= "</tr></tfoot>";

      echo $ret;
   }

   function hourlySalesHTML()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.dateSelected');
      $cg = $this->f3->get('POST.cg');
      $timeFrame = $this->f3->get('POST.timeFrame');

      $pmtGT = 0;

      $data = self::hourlySales($storeMID, $date, $cg, $timeFrame);

      $ret = "<table id=\"tblHourlySales\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>Name <br /></b></th>";
      $ret .= "<th class=\"text-center\"><b>Net</b></th>
               <th class=\"text-center\"><b>Gst</b> <br /></th>
               <th class=\"text-center\"><b>Ent</b> <br /></th>
               <th class=\"text-center\"><b>Bev</b> <br /></th>
               </tr>
               <tr>
               <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               </tr>
               </thead>";

      foreach ($data as $out)
      {
         if (isset($out[totalSales]))
         {
            $amt = $out[totalSales] - $out[grat] - $out[totalTax] - $out[hash] - $out[subtractGrat] + $out[totalDiscounts];
            $tax = number_format($out[totalTax], 2);
            $grat = number_format($out[grat], 2);
            $tip = number_format($out[totalTip], 2);
            $tg = number_format($grat + $tip, 2);
            $pmtGT = number_format($out[totalSales] + $tg, 2);
            $amt = number_format($amt - $tg - $tax - $hash, 2);
            $gst = $out[guestCount];
            $ent = $out[entCount];
            $bev = $out[bevCount];

            $ret .= "<td class=\"text-right\">$out[hr]</td>";
            if ($out[hash] > 0)
            {
               $ret .= "<td class=\"text-right hash\">$amt<br> <b>*$hash</b></td>";
            }
            else
            {
               $ret .= "<td class=\"text-right hash\">$amt</td>";
            }

            $ret .= "<td class=\"text-right\">$gst</td>";
            $ret .= "<td class=\"text-right\">$ent</td>";
            $ret .= "<td class=\"text-right\">$bev</td>";
            $ret .= "</tr>";
         }
         if (isset($data[paidIO]))
         {
            $adj = $data[paidIO];
         }
      }

      $amtGT = array_sum(array_column($data, 'totalSales'));
      $hashGT = array_sum(array_column($data, 'hash'));
      $taxGT = array_sum(array_column($data, 'totalTax'));
      $tipGT = array_sum(array_column($data, 'totalTip'));
      $gratGT = array_sum(array_column($data, 'grat'));
      $gstGT = array_sum(array_column($data, 'guestCount'));
      $bevGT = array_sum(array_column($data, 'bevCount'));
      $entGT = array_sum(array_column($data, 'entCount'));
      $totalDiscounts = array_sum(array_column($data, 'totalDiscounts'));
      $tgGT = $tipGT + $gratGT;
      $totalGT = $amtGT + $totalDiscounts;
      $amtGT = $amtGT + $totalDiscounts - $adj;
      $amtGT = number_format($amtGT, 2);

      $totalGT -= $adj;

      $adj *= -1; // Flip to neg for display

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "<tr><th class=\"text-center\"><b>Totals</b></th>";
      $ret .= "<th class=\"text-right\"0><b>$amtGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$gstGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$entGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$bevGT</b></th>";
      $ret .= "</tr></tfoot>";

      echo $ret;
   }

   function mealtimeSalesHTML()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.dateSelected');
      $cg = $this->f3->get('POST.cg');

      $pmtGT = 0;

      $data = self::mealtimeSales($storeMID, $date, $cg);

      $ret = "<table id=\"tblMTS\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>Name</b> <br /></th>";
      $ret .= "<th class=\"text-center\"><b>Net</b></th>
               <th class=\"text-center\"><b>Gst</b> <br /></th>
               <th class=\"text-center\"><b>Ent</b> <br /></th>
               <th class=\"text-center\"><b>Bev</b> <br /></th>
               </tr>
               <tr>
               <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               </tr>
               </thead>";

      foreach ($data as $out)
      {
         if (isset($out[totalSales]))
         {
            $amt = $out[totalSales] - $out[grat] - $out[totalTax] - $out[hash] - $out[subtractGrat] + $out[totalDiscounts];
            $tax = number_format($out[totalTax], 2);
            $grat = number_format($out[grat], 2);
            $tip = number_format($out[totalTip], 2);
            $tg = number_format($grat + $tip, 2);
            $pmtGT = number_format($out[totalSales] + $tg, 2);
            $amt = number_format($amt - $tg - $tax - $hash, 2);
            $gst = $out[totalGuests];
            $ent = $out[totalEntrees];
            $bev = $out[totalBev];

            $ret .= "<td class=\"text-right\">$out[mealtime]</td>";
            if ($out[hash] > 0)
            {
               $ret .= "<td class=\"text-right hash\">$amt<br> <b>*$hash</b></td>";
            }
            else
            {
               $ret .= "<td class=\"text-right hash\">$amt</td>";
            }

            $ret .= "<td class=\"text-right\">$gst</td>";
            $ret .= "<td class=\"text-right\">$ent</td>";
            $ret .= "<td class=\"text-right\">$bev</td>";
            $ret .= "</tr>";
         }
         if (isset($data[paidIO]))
         {
            $adj = $data[paidIO];
         }
      }

      $amtGT = array_sum(array_column($data, 'totalSales'));
      $hashGT = array_sum(array_column($data, 'hash'));
      $taxGT = array_sum(array_column($data, 'totalTax'));
      $tipGT = array_sum(array_column($data, 'totalTip'));
      $gratGT = array_sum(array_column($data, 'grat'));
      $gstGT = array_sum(array_column($data, 'totalGuests'));
      $bevGT = array_sum(array_column($data, 'totalBev'));
      $entGT = array_sum(array_column($data, 'totalEntrees'));
      $totalDiscounts = array_sum(array_column($data, 'totalDiscounts'));
      $tgGT = $tipGT + $gratGT;
      $totalGT = $amtGT + $totalDiscounts;
      $amtGT = $amtGT + $totalDiscounts - $adj;
      $amtGT = number_format($amtGT, 2);

      $totalGT -= $adj;

      $adj *= -1; // Flip to neg for display

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "<tr><th class=\"text-center\"><b>Totals</b></th>";
      $ret .= "<th class=\"text-right\"><b>$amtGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$gstGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$entGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$bevGT</b></th>";
      $ret .= "</tr></tfoot>";

      echo $ret;
   }

   function roomSalesHTML()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.dateSelected');
      $cg = $this->f3->get('POST.cg');

      $pmtGT = 0;

      $data = self::roomSales($storeMID, $date, $cg);

      $ret = "<table id=\"tblRoomSales\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>Name</b> <br /></th>";
      $ret .= "<th class=\"text-center\"><b>Net</b></th>
               <th class=\"text-center\"><b>Gst</b> <br /></th>
               <th class=\"text-center\"><b>Ent</b> <br /></th>
               <th class=\"text-center\"><b>Bev</b> <br /></th>
               </tr>
               <tr>
               <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               </tr>
               </thead>";

      foreach ($data as $out)
      {
         if (isset($out[totalSales]))
         {
            $amt = $out[totalSales] - $out[grat] - $out[totalTax] - $out[hash] - $out[subtractGrat] + $out[totalDiscounts];
            $tax = number_format($out[totalTax], 2);
            $grat = number_format($out[grat], 2);
            $tip = number_format($out[totalTip], 2);
            $tg = number_format($grat + $tip, 2);
            $pmtGT = number_format($out[totalSales] + $tg, 2);
            $amt = number_format($amt - $tg - $tax - $hash, 2);
            $gst = $out[totalGuests];
            $ent = $out[totalEntrees];
            $bev = $out[totalBev];

            $ret .= "<td class=\"text-right\">$out[name]</td>";
            if ($out[hash] > 0)
            {
               $ret .= "<td class=\"text-right hash\">$amt<br> <b>*$hash</b></td>";
            }
            else
            {
               $ret .= "<td class=\"text-right hash\">$amt</td>";
            }

            $ret .= "<td class=\"text-right\">$gst</td>";
            $ret .= "<td class=\"text-right\">$ent</td>";
            $ret .= "<td class=\"text-right\">$bev</td>";
            $ret .= "</tr>";
         }
         if (isset($data[paidIO]))
         {
            $adj = $data[paidIO];
         }
      }

      $amtGT = array_sum(array_column($data, 'totalSales'));
      $hashGT = array_sum(array_column($data, 'totalHash'));
      $taxGT = array_sum(array_column($data, 'totalTax'));
      $tipGT = array_sum(array_column($data, 'totalTip'));
      $gratGT = array_sum(array_column($data, 'totalGrat'));
      $gstGT = array_sum(array_column($data, 'totalGuests'));
      $bevGT = array_sum(array_column($data, 'totalBev'));
      $entGT = array_sum(array_column($data, 'totalEntrees'));
      $totalDiscounts = array_sum(array_column($data, 'totalDiscounts'));
      $tgGT = $tipGT + $gratGT;
      $totalGT = $amtGT + $totalDiscounts;
      $amtGT = $amtGT + $totalDiscounts - $adj + $gratGT;
      $amtGT = number_format($amtGT, 2);

      $totalGT -= $adj;

      $adj *= -1; // Flip to neg for display

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "<tr><th class=\"text-center\"><b>Totals</b></th>";
      $ret .= "<th class=\"text-right\"><b>$amtGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$gstGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$entGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$bevGT</b></th>";
      $ret .= "</tr></tfoot>";

      echo $ret;
   }

   function searchItemHTML()
   {
      $cg = $this->f3->get('POST.cg');
      $cg = $this->f3->get('POST.txt');
      $itemList = self::searchItem($cg, $txt);
      header('Access-Control-Allow-Origin: *');
      echo json_encode($itemList);
   }
/*
 *
 *
 *
 * Raw Functions
 *
 *
 *
 *
*/

   function salesOverview()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.dateSelected');
      $cg = $this->f3->get('POST.cg');
      $sendback = [];

      $overview = new Overview();
      $dashData = $overview->dashData($storeMID, $date, $cg);
      $gross = self::paymentMethodDetails($storeMID, $date, $cg);

      foreach($gross as $details)
      {
         if (isset($details[amt]))
         {
            $grossAmt += $details[amt] + $details[tip];
         }
      }

      $adj = $gross[paidIO];
      $grossSales = $grossAmt - $adj;
      $sendback[gross] = number_format(round($grossSales, 2), 2);
      $sendback[checks] = $dashData[checks];
      $sendback[guests] = $dashData[guests];
      $sendback[entrees] = $dashData[entrees];
      $sendback[checkavg] = number_format(round($grossSales / $dashData[checks], 2), 2);
      $sendback[guestavg] = number_format(round($grossSales / $dashData[guests], 2), 2);

      if ($dashData[netLY])
      {
         $sendback[999999999][guest_count] = $dashData[guestsLY];
         $sendback[999999999][total_checks] = $dashData[checksLY];
         $sendback[999999999][entree_count] = $dashData[entreesLY];
         $sendback[999999999][grossSalesLy] = number_format(round($dashData[netLY],2),2);
         $sendback[999999999][total_checks] = $dashData[checksLY];
         $netLY = intval($dashData[netLY]);
         $checksLY = intval($dashData[checksLY]);
         $sendback[999999999][checkavgLY] = number_format(round( $netLY / $checksLY, 2), 2);
         $sendback[999999999][guestavgLY] = number_format(round(intval($dashData[netLY]) / intval($dashData[guestsLY]), 2), 2);
      }

      echo json_encode($sendback);

   }

   function paymentMethodDetails($storeMID, $date, $cg)
   {
      if (!isset($storeMID) || !isset($date) || !isset($cg))
      {
         $storeMID = $this->f3->get('POST.selectedStore');
         $date = $this->f3->get('POST.dateSelected');
         $cg = $this->f3->get('POST.cg');
      }

      if (!$date)
      {
         $date = new DateTime();
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      else
      {
         $date = new DateTime($date);
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "SELECT tbl_payment_method.name AS payment,
            SUM(tbl_ticket_payment.paid_tip) AS tip, tbl_payment_department.name AS dept,
            SUM(tbl_ticket_payment.paid_ticket) AS amt,
            SUM(tbl_ticket_payment.tax) AS tax,
            tbl_ticket_payment.date,
            SUM(tbl_ticket_payment.hash) AS hash,
            SUM(tbl_ticket_payment.grat) AS grat, tbl_payment_method.mid AS pmid
            FROM tbl_payment_department
            INNER JOIN tbl_payment_method ON tbl_payment_department.mid = tbl_payment_method.pmtdep_mid
            INNER JOIN tbl_ticket_payment ON tbl_payment_method.mid = tbl_ticket_payment.paymeth_mid
            INNER JOIN tbl_ticket ON tbl_ticket.rid = tbl_ticket_payment.ticket_rid
            WHERE tbl_ticket_payment.date ='$date'
            AND tbl_ticket_payment.cg ='$cg'
            AND tbl_ticket_payment.store_mid = '$storeMID'
            AND tbl_ticket.voidrsn_mid = 1
            GROUP BY tbl_ticket_payment.date, tbl_payment_method.name, tbl_payment_department.name";

      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      $query = "select SUM(net) AS net from tbl_payout WHERE cg = $cg and store_mid = $storeMID AND dttm BETWEEN '$date 00:00:00.000' AND '$nextDay 06:00:00.000' AND reference NOT LIKE '*%'";
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[paidIO] = $row[net];
      }
      return $ret;
   }

   function profitCenterDetails($storeMID, $date, $cg)
   {
      if (!$date)
      {
         $date = new DateTime();
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      else
      {
         $date = new DateTime($date);
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "SELECT SUM(tbl_ticket.items) AS totalSales, SUM(tbl_ticket.tax) AS totalTax, SUM(tbl_ticket.tip) AS totalTip, tbl_ticket.date, tbl_profit_center.name as profitCenterName,
            SUM(tbl_ticket.hash) AS hash, SUM(tbl_ticket.grat) AS grat, SUM(tbl_ticket.discount) as totalDiscounts FROM tbl_ticket
            INNER JOIN tbl_profit_Center ON tbl_ticket.pcenter_mid = tbl_profit_center.mid
            WHERE tbl_ticket.date = '$date' AND tbl_ticket.cg = '$cg' AND tbl_ticket.store_mid = '$storeMID'
            AND tbl_ticket.voidrsn_mid = 1
            GROUP BY tbl_ticket.date, tbl_profit_center.name";
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      $query = "select SUM(net) AS net from tbl_payout WHERE cg = $cg and store_mid = $storeMID AND dttm BETWEEN '$date 00:00:00.000' AND '$nextDay 06:00:00.000' AND reference NOT LIKE '*%'";
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[paidIO] = $row[net];
      }
      return $ret;
   }

   function salesByServer($storeMID, $date, $cg)
   {
      if (!$date)
      {
         $date = new DateTime();
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      else
      {
         $date = new DateTime($date);
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "SELECT
                tbl_ticket.date,
                tbl_employee.name,
                SUM(tbl_ticket.items + tbl_ticket.discount) as totalSales,
                SUM(tbl_ticket.guest_count) as totalGuests,
                SUM(tbl_ticket.entree_count) as totalEntrees,
                SUM(tbl_ticket.bev_count) as totalBev,
                SUM(tbl_ticket.discount) as totalDiscounts,
                SUM(tbl_ticket.hash_discount) as totalHashDiscounts,
                SUM(tbl_ticket.hash) as totalHash,
                SUM(tbl_ticket.retained_tip) as retainedTip,
                SUM(tbl_ticket.grat) as totalGrat,
                SUM(tbl_ticket.house_grat + tbl_ticket.hidden_grat + tbl_ticket.retained_grat + tbl_ticket.service_grat) as subtractGrat,
                SUM(tbl_ticket.tip) as totalTip,
                SUM(tbl_ticket.tax) as totalTax,
                COUNT(tbl_ticket.rid) as totalChecks
                FROM tbl_ticket
                INNER JOIN tbl_store
                ON tbl_ticket.store_mid = tbl_store.mid
                INNER JOIN tbl_employee
                ON tbl_ticket.last_server = tbl_employee.mid
                WHERE tbl_ticket.cg = $cg
                AND tbl_ticket.store_mid = $storeMID
                AND tbl_ticket.date = \"$date\"
                AND tbl_ticket.voidrsn_mid = 1
                GROUP BY tbl_ticket.last_server
                ORDER BY tbl_ticket.last_server";

      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      return $ret;
   }

   function hourlySales($storeMID, $date, $cg, $timeFrame)
   {
      if (!$date)
      {
         $date = new DateTime();
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      else
      {
         $date = new DateTime($date);
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      if (!$timeFrame)
      {
         $timeFrame = 'hourly';
      }
      if ($timeFrame == 'hourly')
      {
         $query = "SELECT HOUR(sale_dttm) AS hr, date, sum(items) AS totalSales, SUM(tax) as totalTax, SUM(tip) as totalTip, SUM(discount) as totalDiscounts, SUM(grat) AS grat,
            SUM(guest_count) as guestCount, SUM(bev_count) as bevCount, SUM(entree_count) as entCount FROM tbl_ticket
            WHERE date = '$date' AND tbl_ticket.cg = '$cg' AND tbl_ticket.store_mid = '$storeMID' AND tbl_ticket.voidrsn_mid = 1
            GROUP BY HOUR(sale_dttm), date ORDER BY hr";
      }
      if ($timeFrame == 'halfhour')
      {
         $query = "SELECT CONCAT(CAST(HOUR(sale_dttm) AS CHAR(2)), ':', (CASE WHEN MINUTE(sale_dttm) <30 THEN '00' ELSE '30' END)) AS
            hr, date, sum(items) AS totalSales, SUM(tax) as totalTax, SUM(tip) as totalTip, SUM(discount) as totalDiscounts, SUM(grat) AS grat,
            SUM(guest_count) as guestCount, SUM(bev_count) as bevCount, SUM(entree_count) as entCount FROM tbl_ticket
            WHERE date = '$date' AND tbl_ticket.cg = '$cg' AND tbl_ticket.store_mid = '$storeMID' AND tbl_ticket.voidrsn_mid = 1
            GROUP BY HOUR(sale_dttm), FLOOR(MINUTE(sale_dttm)/30)";
      }
      if ($timeFrame == 'quarter')
      {
         $query = "SELECT CONCAT(CAST(HOUR(sale_dttm) AS CHAR(2)), ':', (CASE WHEN MINUTE(sale_dttm) <15 THEN '00' WHEN MINUTE(sale_dttm) < 30 THEN '15' WHEN MINUTE(sale_dttm) < 45 THEN '30' ELSE '45' END)) AS
            hr, date, sum(items) AS totalSales, SUM(tax) as totalTax, SUM(tip) as totalTip, SUM(discount) as totalDiscounts, SUM(grat) AS grat,
            SUM(guest_count) as guestCount, SUM(bev_count) as bevCount, SUM(entree_count) as entCount FROM tbl_ticket
            WHERE date = '$date' AND tbl_ticket.cg = '$cg' AND tbl_ticket.store_mid = '$storeMID' AND tbl_ticket.voidrsn_mid = 1
            GROUP BY HOUR(sale_dttm), FLOOR(MINUTE(sale_dttm)/15)";
      }
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      return $ret;
   }

   function mealtimeSales($storeMID, $date, $cg)
   {
      if (!$date)
      {
         $date = new DateTime();
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      else
      {
         $date = new DateTime($date);
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "
         SELECT
            SUM(tbl_ticket.items) AS totalSales,
            SUM(tbl_ticket.discount) AS totalDiscounts,
            SUM(tbl_ticket.hash) AS totalHash,
            SUM(tbl_ticket.hash_discount) AS hashDiscount,
            SUM(tbl_ticket.tip) AS totalTip,
            SUM(tbl_ticket.retained_tip) AS retainedTip,
            SUM(tbl_ticket.grat) AS totalGrat,
            SUM(tbl_ticket.house_grat) AS houseGrat,
            SUM(tbl_ticket.tax) AS totalTax,
            SUM(tbl_ticket.guest_count) AS totalGuests,
            SUM(tbl_ticket.entree_count) AS totalEntrees,
            SUM(tbl_ticket.bev_count) AS totalBev,
            COUNT(tbl_ticket.rid) as totalChecks,
	         tbl_meal_time.name AS mealtime
            FROM tbl_ticket
            INNER JOIN tbl_store
               ON tbl_ticket.store_mid = tbl_store.mid
            INNER JOIN tbl_meal_time
               ON tbl_ticket.mealtime_mid = tbl_meal_time.mid
            WHERE tbl_ticket.cg = $cg AND tbl_ticket.store_mid = $storeMID AND tbl_ticket.date = '$date'
            AND tbl_ticket.voidrsn_mid = 1
            GROUP BY tbl_meal_time.name";

      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      return $ret;
   }

   function roomSales($storeMID, $date, $cg)
   {
      if (!$date)
      {
         $date = new DateTime();
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      else
      {
         $date = new DateTime($date);
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "
        SELECT
            SUM(tbl_ticket.items) AS totalSales,
            SUM(tbl_ticket.discount) AS totalDiscounts,
            SUM(tbl_ticket.hash) AS totalHash,
            SUM(tbl_ticket.hash_discount) AS hashDiscount,
            SUM(tbl_ticket.tip) AS totalTip,
            SUM(tbl_ticket.retained_tip) AS retainedTip,
            SUM(tbl_ticket.grat) AS totalGrat,
            SUM(tbl_ticket.house_grat) AS houseGrat,
            SUM(tbl_ticket.tax) AS totalTax,
            SUM(tbl_ticket.guest_count) AS totalGuests,
            SUM(tbl_ticket.entree_count) AS totalEntrees,
            SUM(tbl_ticket.bev_count) AS totalBev,
            COUNT(tbl_ticket.rid) as totalChecks,
	         tbl_room.name AS name
            FROM tbl_ticket
            INNER JOIN tbl_store
               ON tbl_ticket.store_mid = tbl_store.mid
            INNER JOIN tbl_meal_time
               ON tbl_ticket.mealtime_mid = tbl_meal_time.mid
            INNER JOIN tbl_table
				   ON tbl_ticket.table_mid = tbl_table.mid
            INNER JOIN tbl_room
               ON tbl_table.room_mid = tbl_room.mid
            WHERE tbl_ticket.cg = $cg AND tbl_ticket.store_mid = $storeMID AND tbl_ticket.date = '$date'
            AND tbl_ticket.voidrsn_mid = 1
            GROUP BY tbl_room.name";

      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      return $ret;
   }

   function searchItem($cg, $txt)
   {
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "SELECT * from tbl_menu_item WHERE name LIKE %$txt%' AND cg = $cg";

      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      return $ret;
   }

}