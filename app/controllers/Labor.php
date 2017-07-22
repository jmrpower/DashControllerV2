<?php

/**
 * Labor short summary.
 *
 * Labor description.
 *
 * @version 1.0
 * @author Justin
 */
class Labor extends Controller
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

   function labotByDeptCatHTML()
   {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.selectedDate');
      $cg = $this->f3->get('POST.cg');
      $data = self::laborByDeptCat($storeMID, $date, $cg);
      $labor = new Overview();
      $labor = $labor->dashData($storeMID, $date, $cg);
      $netSales = $labor[net];

      $ret = "<table id=\"tblLaborByDeptCat\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>Job</b></th>";
      $ret .= "<th class=\"text-center\"><b>Pay</b></th>
               <th class=\"text-center\"><b>%</b> <br /></th>
               </tr>
               </thead>";

      foreach ($data as $out => $job)
      {
         $ret .= "<tr>";
         $ret .= "<td class=\"text-left\"><b>$out</b></td>";
         $ret .= "<td class=\"text-right\"></td>";
         $ret .= "<td class=\"text-right\"></td>";
         $ret .= "</tr>";

         foreach ($job as $jobData => $detail)
         {
            foreach ($detail as $pay)
            {
               if ($pay > 0)
               {
                  $round = $pay/$netSales * 100;
                  $pct = round($round,2);
               }
               else
               {
                  $pct = 0;
               }
               $ret .= "<tr>";
               $ret .= "<td class=\"text-right\">$jobData</td>";
               $ret .= "<td class=\"text-right\">$pay</td>";
               $ret .= "<td class=\"text-right\">$pct</td>";
               $ret .= "</tr>";
               $payGT += $pay;
               $pctGT += $pct;
            }
            $payGroupTotal += $pay;
            $pctGroupTotal += $pct;
         }

         $ret .= "<tr>";
         $ret .= "<td class=\"text-right\"></td>";
         $ret .= "<td class=\"text-right\"><b>$payGroupTotal</b></td>";
         $ret .= "<td class=\"text-right\"><b>$pctGroupTotal</b></td>";
         $ret .= "</tr>";
         $payGroupTotal = 0;
         $pctGroupTotal = 0;
      }

      $payGT = number_format(round($payGT, 2), 2);
      $pctGT = number_format(round($pctGT, 2), 2);

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "<tr><th class=\"text-right\"><b>Totals:</b></th>";
      $ret .= "<th class=\"text-right\"><b>$payGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$pctGT</b></th>";
      $ret .= "</tr></tfoot>";

      echo $ret;
   }

    function tcDetailHTML()
    {
      $storeMID = $this->f3->get('POST.selectedStore');
      $date = $this->f3->get('POST.selectedDate');
      $cg = $this->f3->get('POST.cg');
      $data = self::tcDetail($storeMID, $date, $cg);

      $ret = "<table id=\"tblTCDetail\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>Staff</b> <br /></th>";
      $ret .= "<th class=\"text-center\"><b>Dept</b></th>
                <th class=\"text-center\"><b>Reg</b> <br /></th>
                <th class=\"text-center\"><b>OT</b> <br /></th>
                <th class=\"text-center\"><b>DT</b> <br /></th>
                <th class=\"text-center\"><b>In / Out</b> <br /></th>
                </tr>
                <tr>
                <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
                <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
                <th class=\"text-center\" data-sort=\"float\">      <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
                <th class=\"text-center\" data-sort=\"float\">      <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
                <th class=\"text-center\" data-sort=\"float\">      <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
                <th class=\"text-center\" data-sort=\"int\">        <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
                </tr>
                </thead>";

      foreach ($data as $out)
      {
          $name = $out[staff_name];
          $dept = $out[job_name];
          $reg = $out[reg_hours];
          $ot = $out[ot_hours];
          $dt = $out[dt_hours];
          $in = substr($out[in_dttm], 11, 5);
          $outTime = substr($out[out_dttm], 11, 5);
          /*
          if ($reg > 8)
          {

             if ($outTime == "00:00")
             {
               $ret .= "<tr class=\"danger onClock\">";
             }
             else
             {
                $ret .= "<tr class=\"danger offClock\">";
             }
          }
          else
          {
             if ($outTime == "00:00")
             {
               $ret .= "<tr class=\"onClock\">";
             }
             else
             {
                $ret .= "<tr class=\"offClock\">";
             }

          }
          */

          if ($outTime == "00:00")
          {
             $ret .= "<tr class=\"success onClock\">";
          }
          else
          {
             $ret .= "<tr class=\"danger offClock\">";
          }

          $ret .= "<td class=\"text-right\">$name</td>";
          $ret .= "<td class=\"text-right hash\">$dept</td>";
          $ret .= "<td class=\"text-right\">$reg</td>";
          $ret .= "<td class=\"text-right\">$ot</td>";
          $ret .= "<td class=\"text-right\">$dt</td>";
          $ret .= "<td class=\"text-right\">$in<br />$outTime</td>";
          $ret .= "</tr>";
      }

      $regGT = array_sum(array_column($data, 'reg_hours'));
      $otGT = array_sum(array_column($data, 'ot_hours'));
      $dtGT = array_sum(array_column($data, 'dt_hours'));

      //$amtGT = number_format($amtGT, 2);

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "<tr><th class=\"text-right\"><b>Totals:</b></th>";
      $ret .= "<th class=\"text-right\"></th>";
      $ret .= "<th class=\"text-right\"><b>$regGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$otGT</b></th>";
      $ret .= "<th class=\"text-right\"><b>$dtGT</b></th>";
      $ret .= "<th class=\"text-right\"></th>";
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

   function totalLaborCost($storeMID, $date, $cg)
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

   function laborByDeptCat($storeMID, $date, $cg)
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
      $query = "SELECT LEFT(tbl_time_clock.in_dttm, 10) as punch, tbl_payroll_category.name AS cat, tbl_job.name AS job, (SUM(tbl_time_clock.reg_pay) + SUM(tbl_time_clock.ot_pay) + SUM(tbl_time_clock.dt_pay)) AS totalPay
                  FROM rpower.tbl_job
                  INNER JOIN rpower.tbl_payroll_category ON tbl_job.pyrlcat_mid = tbl_payroll_category.mid
                  INNER JOIN rpower.tbl_time_clock ON tbl_time_clock.job_mid = tbl_job.mid
                  INNER JOIN rpower.tbl_employee ON tbl_time_clock.emp_mid = tbl_employee.mid
                  WHERE tbl_time_clock.in_dttm BETWEEN '$date 06:00:00' AND '$nextDay 05:59:59' AND tbl_time_clock.cg = $cg
                  GROUP BY `punch`, cat, job";
                  $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[$row['cat']][$row['job']][] = $row['totalPay'];
      }

      return $ret;
}

function tcDetail($storeMID, $date, $cg)
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
   $query = "SELECT tbl_employee.name AS staff_name, tbl_store.name AS store_name, tbl_job.name AS job_name, ROUND(tbl_time_clock.reg_hours, 2) AS reg_hours, ROUND(tbl_time_clock.ot_hours, 2) AS ot_hours, ROUND(tbl_time_clock.dt_hours, 2) AS dt_hours, tbl_time_clock.reg_pay AS reg_pay, tbl_time_clock.ot_pay AS ot_pay, tbl_time_clock.dt_pay AS dt_pay, tbl_time_clock.in_dttm, tbl_time_clock.out_dttm, tbl_time_clock.break_minutes AS break_min
              FROM tbl_time_clock
              INNER JOIN tbl_employee ON tbl_time_clock.emp_mid = tbl_employee.mid
              INNER JOIN tbl_store ON tbl_time_clock.store_mid = tbl_store.mid
              INNER JOIN tbl_job ON tbl_time_clock.job_mid = tbl_job.mid
              WHERE (CONVERT(tbl_time_clock.in_dttm, DATETIME) LIKE '$date%') AND tbl_time_clock.cg = $cg AND tbl_time_clock.store_mid = $storeMID";
   $res = $db->query($query);
   foreach($res as $row)
   {
      $ret[] = $row;
   }
   return $ret;
}





}
