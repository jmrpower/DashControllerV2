<?php

/**
 * Functions for Overview page
 *
 * Overview description.
 *
 * @version 1.0
 * @author Justin
 *
 *
 *
 */

require('app/utils/k3utils.php');

class Overview extends Controller
{

   public function dashDataEcho()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.selectedDate');
      $cg = $this->f3->get('POST.cg');
      header('Access-Control-Allow-Origin: *');
      echo json_encode($this->dashData($storeMID, $date, $cg));
   }

   public function dashData($storeMID, $date, $cg) // Echos JSON encoded array when called
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
         $dateLY = $date; // Keep as a string
         $date = new DateTime($date);
         $date = $date->format('Y-m-d');
         $prevDay = date('Y-m-d', strtotime($date. '- 1 days'));
         $nextDay = date('Y-m-d', strtotime($date. '+ 1 days'));
      }
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "SELECT tbl_store.name,
                tbl_ticket.date,
                SUM(tbl_ticket.guest_count) AS guest_count,
                SUM(tbl_ticket.entree_count) AS entree_count,
                SUM(tbl_ticket.bev_count) AS bev_count,
                SUM(tbl_ticket.items) AS item_sales,
                SUM(tbl_ticket.discount) AS total_discounts,
                SUM(tbl_ticket.hash) AS hash_sales,
                SUM(tbl_ticket.hash_discount) AS hash_discount,
                SUM(tbl_ticket.tip+tbl_ticket.grat) AS total_tips,
                SUM(tbl_ticket.tax1) as total_tax,
                COUNT(tbl_ticket.date) AS total_checks,
                SUM(tbl_ticket.grat) as grat,
                SUM(tbl_ticket.house_grat) AS houseGrat
                FROM tbl_ticket
                INNER JOIN tbl_store ON tbl_ticket.store_mid = tbl_store.mid
                WHERE tbl_ticket.voidrsn_mid = 1
                AND tbl_ticket.date = \"$date\"
                AND tbl_ticket.cg = $cg
                AND tbl_ticket.store_mid = $storeMID
                GROUP BY tbl_store.name, tbl_ticket.date";

      $res = $db->query($query);

      foreach($res as $row)
      {
         $ret[0] = $row;
      }

      $query = "select SUM(net) AS net from tbl_payout WHERE cg = $cg and store_mid = $storeMID AND dttm BETWEEN '$date 00:00:00.000' AND '$nextDay 06:00:00.000' AND reference NOT LIKE '*%'";
      $res = $db->query($query);

      foreach($res as $row)
      {
         if ($ret[0][paidIO])
         {
            $ret[0][paidIO] = $row[net];
         }
      }

      $ly = k3ThisDayLastYear($dateLY);
      $lyQuery = "SELECT tbl_store.name, tbl_ticket.date, SUM(tbl_ticket.guest_count) AS guest_count, SUM(tbl_ticket.entree_count) AS entree_count, SUM(tbl_ticket.bev_count) AS bev_count, SUM(tbl_ticket.items) AS item_sales, SUM(tbl_ticket.discount) AS total_discounts, SUM(tbl_ticket.hash) AS hash_sales, SUM(tbl_ticket.hash_discount) AS hash_discount, SUM(tbl_ticket.tip+tbl_ticket.grat) AS total_tips, SUM(tbl_ticket.tax1) as total_tax, COUNT(tbl_ticket.date) AS total_checks, SUM(tbl_ticket.grat) as grat, SUM(tbl_ticket.house_grat) AS houseGrat FROM tbl_ticket INNER JOIN tbl_store ON tbl_ticket.store_mid = tbl_store.mid WHERE tbl_ticket.voidrsn_mid = 1 AND tbl_ticket.date = \"$ly\" AND tbl_ticket.cg = $cg AND tbl_ticket.store_mid = $storeMID GROUP BY tbl_store.name, tbl_ticket.date";
      $lyRet = $db->query($lyQuery);

      if ($lyRet)
      {
         foreach($lyRet as $row)
         $ret[999999999] = $row;
         $query = "select SUM(net) AS net from tbl_payout WHERE cg = $cg and store_mid = $storeMID AND dttm BETWEEN '$date 00:00:00.000' AND '$nextDay 06:00:00.000' AND reference NOT LIKE '*%'";
         $res = $db->query($query);
         foreach($res as $row)
         {
            if ($ret[999999999][paidIO])
            {
               $ret[999999999][paidIO] = $row[net];
            }
         }
      }

      $totalLaborCost = $this->totalLaborCost($storeMID, $date, $cg);

      $sendback = [];

      $totalGuests = $ret[0][guest_count];
      $totalEntrees = $ret[0][entree_count];
      $totalBev = $ret[0][bev_count];
      $itemSales = $ret[0][item_sales];
      $totalDiscounts = $ret[0][total_discounts];
      $hashSales = $ret[0][hash_sales];
      $hashDiscount = $ret[0][hash_discount];
      $totalTips = $ret[0][total_tips];
      $totalTax = $ret[0][total_tax];
      $totalChecks = $ret[0][total_checks];
      $totalGrat = $ret[0][grat];
      $houseGrat = $ret[0][houseGrat];

      if ($ret[999999999][item_sales])
      {
         $totalGuestsLY = $ret[999999999][guest_count];
         $entreeCountLY = $ret[999999999][entree_count];
         $bevCountLY = $ret[999999999][bev_count];
         $itemSalesLY = $ret[999999999][item_sales];
         $totalDiscountsLY = $ret[999999999][total_discounts];
         $hashSalesLY = $ret[999999999][hash_sales];
         $hashDiscountLY = $ret[999999999][hash_discount];
         $totalTipsLY = $ret[999999999][total_tips];
         $totalTaxLY = $ret[999999999][total_tax];
         $totalChecksLY = $ret[999999999][total_checks];
         $totalGratLY = $ret[999999999][grat];
         $houseGratLY = $ret[999999999][houseGrat];
         $netLY = $itemSalesLY - $totalGratLY + $totalDiscountsLY + $houseGratLY;
         $sendback[netLY] = $netLY;
         $sendback[netLYRnd] = number_format(round($netLY,2),2);
         $sendback[discountsLY] = $totalDiscountsLY;
         $sendback[laborPctLY] = round($totalLaborCost[999999999][total_pay] / $netLY *100, 2);
         $sendback[laborCostLY] = number_format(round($totalLaborCost[999999999][total_pay],2),2);
         $sendback[guestsLY] = $totalGuestsLY;
         $sendback[checksLY] = $totalChecksLY;
         $sendback[entreesLY] = $entreeCountLY;
      }

      $net = $itemSales - $totalGrat + $totalDiscounts + $houseGrat;
      $sendback[net] = number_format(round($itemSales - $totalGrat + $totalDiscounts + $houseGrat,2),2);
      $sendback[discounts] = number_format(round($totalDiscounts,2),2);
      $sendback[laborPct] =  round($totalLaborCost[0][total_pay] / $net *100,2);
      $sendback[laborCost] = number_format(round($totalLaborCost[0][total_pay],2),2);
      $sendback[guests] = $totalGuests;
      $sendback[checks] = $totalChecks;
      $sendback[entrees] = $totalEntrees;

      return $sendback;
   }

   function totalLaborCost($storeMID, $date, $cg) // Returns array to caller
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
      $query = "SELECT tbl_store.name, SUM(tbl_time_clock.reg_pay + tbl_time_clock.ot_pay + tbl_time_clock.dt_pay) AS total_pay FROM rpower.tbl_time_clock INNER JOIN rpower.tbl_store ON tbl_time_clock.store_mid = tbl_store.mid INNER JOIN rpower.tbl_job  ON tbl_time_clock.job_mid = tbl_job.mid INNER JOIN rpower.tbl_payroll_category ON tbl_job.pyrlcat_mid = tbl_payroll_category.mid INNER JOIN rpower.tbl_payroll_department ON tbl_payroll_category.pyrldep_mid = tbl_payroll_department.mid WHERE tbl_time_clock.in_dttm BETWEEN '$date 06:00:00' AND '$nextDay 05:59:59' AND tbl_time_clock.cg = '$cg' AND tbl_time_clock.store_mid = '$storeMID'";
      $res = $db->query($query);

      foreach($res as $row)
      {
         $ret[0] = $row;
      }

      $ly = k3ThisDayLastYear($date);
      $ly = new DateTime($ly);
      $ly = $ly->format('Y-m-d');
      $nextDayLy = date('Y-m-d', strtotime($ly. '+ 1 days'));
      $lyQuery = "SELECT tbl_store.name, SUM(tbl_time_clock.reg_pay + tbl_time_clock.ot_pay + tbl_time_clock.dt_pay) AS total_pay FROM rpower.tbl_time_clock INNER JOIN rpower.tbl_store ON tbl_time_clock.store_mid = tbl_store.mid INNER JOIN rpower.tbl_job  ON tbl_time_clock.job_mid = tbl_job.mid INNER JOIN rpower.tbl_payroll_category ON tbl_job.pyrlcat_mid = tbl_payroll_category.mid INNER JOIN rpower.tbl_payroll_department ON tbl_payroll_category.pyrldep_mid = tbl_payroll_department.mid WHERE tbl_time_clock.in_dttm BETWEEN '$ly 06:00:00' AND '$nextDayLy 05:59:59' AND tbl_time_clock.cg = '$cg' AND tbl_time_clock.store_mid = '$storeMID'";
      $lyRet = $db->query($lyQuery);

      if ($lyRet)
      {
         foreach($lyRet as $row)
            $ret[999999999] = $row;
      }

      return $ret;
   }
}