<?php

/**
 * DisVoid short summary.
 *
 * DisVoid description.
 *
 * @version 1.0
 * @author Justin
 */
class DisVoid extends Controller
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

   function discountDetailsHTML()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.selectedDate');
      $cg = $this->f3->get('POST.cg');
      $data = self::discountDetails($storeMID, $date, $cg);

      $ret = "<table id=\"tblDiscountDetails\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>Discount</b> <br /></th>";
      $ret .= "<th class=\"text-center\"><b>Mgr</b></th>
               <th class=\"text-center\"><b>Tkt</b> <br /></th>
               <th class=\"text-center\"><b>Amt</b> <br /></th>
               <th class=\"text-center\"><b>Note</b> <br /></th>
               </tr>
               <tr>
               <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"string-ins\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"int\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"string-ins\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               </tr>
               </thead>";

      if ($data)
      {
         foreach ($data as $out)
         {
            $amt = number_format($out[amt], 2);
            $tkt = $out[tkt];
            $discName = $out[discname];
            $note = $out[note];
            $mgr = $out[empName];

            $ret .= "<tr id=\"aRID$out[tktRID]\">";
            $ret .= "<td class=\"text-right\">$discName</td>";
            $ret .= "<td class=\"text-right hash\">$mgr</td>";
            $ret .= "<td class=\"text-right\"><a data-rid=\"$out[tktRID]\">$out[tkt]</a></td>";
            $ret .= "<td class=\"text-right\">$amt</td>";
            $ret .= "<td class=\"text-right\">$note</td>";
            $ret .= "</tr>";
         }

         $amtGT = array_sum(array_column($data, 'amt'));
         $amtGT = number_format($amtGT, 2);
      }

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "<tr><th class=\"text-right\"><b>Totals:</b></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"><b>$amtGT</b></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "</tr></tfoot>";

      echo $ret;
   }

   function voidDetailsHTML()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.selectedDate');
      $cg = $this->f3->get('POST.cg');
      $data = self::voidDetails($storeMID, $date, $cg);

      $ret = "<table id=\"tblVoidDetails\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>Void</b> <br /></th>";
      $ret .= "<th class=\"text-center\"><b>Mgr</b></th>
               <th class=\"text-center\"><b>Itm</b> <br /></th>
               <th class=\"text-center\"><b>Qty</b> <br /></th>
               <th class=\"text-center\"><b>Amt</b> <br /></th>
               </tr>
               <tr>
               <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"string-ins\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"string-ins\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"int\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"float\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               </tr>
               </thead>";

      if ($data)
      {
         foreach ($data as $out)
         {
            $amt = number_format($out[amt], 2);
            $voidName = $out[name];
            $item = $out[item];
            $mgr = $out[mgr];
            $qty = $out[qty];

            $ret .= "<td class=\"text-right\">$voidName</td>";
            $ret .= "<td class=\"text-right hash\">$mgr</td>";
            $ret .= "<td class=\"text-right\">$item</td>";
            $ret .= "<td class=\"text-right\">$qty</td>";
            $ret .= "<td class=\"text-right\">$amt</td>";
            $ret .= "</tr>";
         }

         $amtGT = array_sum(array_column($data, 'amt'));
         $amtGT = number_format($amtGT, 2);
      }

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "<tr><th class=\"text-right\"><b>Total:</b></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"><b>$amtGT</b></th>";
      $ret .= "</tr></tfoot>";

      echo $ret;
   }


   /*
    *
    *
    *
    * Data Functions
    *
    *
    *
    *
    */

      function discountDetails($storeMID, $date, $cg)
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
      $query = "SELECT tbl_store.name, tbl_employee.name AS empName, tbl_menu_item.name AS discname, tbl_ticket_item.real_total as amt, tbl_ticket_item.qty, tbl_ticket_item.note, tbl_ticket_item.ticket as tkt, CAST(tbl_ticket_item.ticket_rid AS CHAR) as tktRID
                FROM tbl_ticket_item
                INNER JOIN tbl_store ON tbl_store.mid = tbl_ticket_item.store_mid
                INNER JOIN tbl_menu_item ON tbl_ticket_item.menuitem_mid = tbl_menu_item.mid
                INNER JOIN tbl_employee ON tbl_ticket_item.mgr_mid = tbl_employee.mid
                WHERE tbl_ticket_item.date = '$date' AND tbl_ticket_item.real_total < '0.00' AND tbl_ticket_item.cg = $cg AND tbl_ticket_item.store_mid = $storeMID
                ORDER BY empname";
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      return $ret;
   }

   function voidDetails($storeMID, $date, $cg)
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
      $query = "SELECT SUM(tbl_ticket_sales.sales) as amt, tbl_ticket_sales.qty, tbl_ticket_sales.ticket, tbl_ticket_sales.ticket_rid, tbl_ticket_sales.date, tbl_void_reason.name, tbl_store.name AS store, tbl_menu_item.name AS item, tbl_employee.name AS mgr
             FROM tbl_ticket_sales
             INNER JOIN tbl_void_reason ON tbl_ticket_sales.voidrsn_mid = tbl_void_reason.mid
             INNER JOIN tbl_store ON tbl_ticket_sales.store_mid = tbl_store.mid
             INNER JOIN tbl_employee ON tbl_ticket_sales.voidmgr_mid = tbl_employee.mid
             INNER JOIN tbl_menu_item ON tbl_ticket_sales.menuitem_mid = tbl_menu_item.mid
             WHERE tbl_ticket_sales.voidrsn_mid > '1' and tbl_void_reason.name not like 'COMBINED' and date = '$date' AND tbl_ticket_sales.cg = $cg AND tbl_ticket_sales.store_mid = $storeMID
             GROUP BY tbl_store.name, tbl_menu_item.name, tbl_void_reason.name, tbl_ticket_sales.date, tbl_ticket_sales.ticket, tbl_ticket_sales.qty";
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      return $ret;
   }


}
