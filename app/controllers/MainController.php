<?php
/**

 /**
 * Controller class
 *
 * @category PHP
 * @package  Fat-Free-PHP-Bootstrap-Site
 * @author   Mark Takacs <takacsmark@takacsmark.com>
 * @license  MIT
 * @link     takacsmark.com
 */

require('app/bin/mysql.php');
require('app/controllers/Auth.php');
require('app/bin/k3Utils.php');
require('app/utils/TableBuilder.php');
require('app/utils/PageBuilder.php');

class MainController extends Controller
{
    /**
     * Renders the dashboard view template
     *
     * @return void
     */

   function tableTest()
   {
      $test = new TableBuilder();
      $test->tableStart("ID", "CLASS");
      $test->tbody("<tr><td></td></tr>");
      $test->tbody("<tr><td></td></tr>");
      $test->thead = "<thead>";
      echo $test->getTable();
   }

    function render()
    {
        $this->f3->set('body', 'index.html');
        $template=new Template;
        echo $template->render('layout.html');
    }

    function overview()
    {
        $template=new Template;
        echo $template->render('overview.html');
    }

    function sales()
    {
        $template=new Template;
        echo $template->render('sales.html');
    }

    function disvoid()
    {
       $template=new Template;
       echo $template->render('disvoid.html');
    }

    function labor()
    {
       $template=new Template;
       echo $template->render('labor.html');
    }

    function utils()
    {
       // instead of this, can we just pass the xtags array to the render engine
       // then do an in_array and set var
       $rtc = $this->f3->get('SESSION.xtags');
       if (array_search("RTC", $rtc))
       {
          $this->f3->set('rtc', true);
       }
       $template=new Template;
       echo $template->render('utils.html');
    }

    function orders()
    {
       $template=new Template;
       echo $template->render('orders.html');
    }

    function alerts()
    {
       $template=new Template;
       echo $template->render('alerts.html');
    }

   function destroySession()
   {
      $f3 = Base::instance();
      $f3->clear('SESSION');
      $f3->reroute('/login');
   }

   function storeListByUser()
   {
      $token = $this->f3->get('SESSION.token');
      $username = $this->f3->get('SESSION.user');

      $db = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $db->where('token', $token);
      $res = $db->get('rp_dash_users');
      if ($res)
      {
         $db = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
         $db->where('username', $username);
         $res = $db->get('tbl_users');
         if ($res)
         {
            // load store list
            $storeList = array();
            $userCG = $res[0][user_cg];
            $userStores = $res[0][user_store_sn];
            if (strpos($userCG, "|"))
            {
               // This doesn't mean they have access to all stores in this cg.....
               // We should check the store list for pipes because that will override
               // pipes in CG
               if (strpos($userStores, "|"))
               {
                  // Get these stores instead of loading stores in the CGs
                  $userStores = str_replace("|", ",", $userStores);
                  $query = "SELECT CAST(mid AS CHAR) as mid, tag_name, cg, serial_number, lup_zdttm FROM tbl_store WHERE serial_number IN ($userStores) ";
               }
               elseif ($userStores == 4)
               {
                  // Yes, they have access to ALL stores in ALL listed CGs
                  $userCG = str_replace("|", ",", $userCG);
                  $query = "SELECT CAST(mid AS CHAR) as mid, tag_name, cg, serial_number, lup_zdttm FROM tbl_store WHERE cg IN ($userCG) ";
               }
               else
               {
                  // You shouldn't be here.
                  return "wtf";
               }
            }
            elseif (!strpos($userCG, "|") && strpos($userStores, "|"))
            {
               // Only one CG, dump store list for all stores in $userStores
               $userStores = str_replace("|", ",", $userStores);
               $query = "SELECT CAST(mid AS CHAR) as mid, tag_name, cg, serial_number, lup_zdttm FROM tbl_store WHERE serial_number IN ($userStores) ";
            }
            else
            {
               // only one CG/Store, dump store list for that CG
               $userCG = str_replace("|", ",", $userCG);
               $query = "SELECT CAST(mid AS CHAR) as mid, tag_name, cg, serial_number, lup_zdttm FROM tbl_store WHERE cg IN ($userCG) ";
            }
            $storeRet = $db->query($query);
            foreach ($storeRet as $key => $value)
            {
               $storeList[] = $value[serial_number];
            }
            // write delim store list to DB for billing
            $storeList = implode("|", $storeList);
            $updateData = array('userStores' => $storeList);
            $db->where('id', $valid->id);
            $res = $db->update('rp_dash_users', $updateData);
            if ($res)
            {
               header('Access-Control-Allow-Origin: *');
               echo json_encode($storeRet);
            }
            else
            {
               return "error";
            }
         }
         return "error";
      }
      return "error";
   }

   function storeLastUpdate()
   {
      $token = $this->f3->get('SESSION.token');
      $username = $this->f3->get('SESSION.user');
      $storeMID = $this->f3->get('POST.selectedStore');
      $cg = $this->f3->get('POST.cg');

      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "SELECT * FROM tbl_store WHERE cg = $cg AND mid = $storeMID";
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      /*
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "SELECT lastMessageAck FROM rp_dash_users where username = '$user'";
      $resLMA = $db->query($query);
      if ($resLMA)
      {
         foreach ($resLMA as $rowLMA)
         {
            $ret[999999999] = $rowLMA;
         }
      }
      */
      $query = "select MAX(date) as date from tbl_ticket where cg = $cg and store_mid = $storeMID";
      $resMaxDate = $db->query($query);

      if ($resMaxDate)
      {
         foreach ($resMaxDate as $rowMaxDate)
         {
            $ret[999999998] = $rowMaxDate;
         }
      }

      header('Access-Control-Allow-Origin: *');
      echo json_encode($ret);
   }


   function findCheckRID()
   {
      $checkNumber = $this->f3->get('POST.checkNumber');
      $storeMID = $this->f3->get('POST.storeMID');
      $cg = $this->f3->get('POST.cg');
      $date = $this->f3->get('POST.date');

      $db = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "SELECT CAST(rid AS CHAR) AS rid FROM tbl_ticket where cg = $cg AND store_mid = $storeMID AND ticket = $checkNumber AND date = '$date'";
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      echo json_encode($ret, JSON_HEX_QUOT | JSON_HEX_TAG);
   }

   function checkDetail()
   {
      $storeMID = $this->f3->get('POST.storeMID');
      $cg = $this->f3->get('POST.cg');
      $ticketRID = $this->f3->get('POST.ticketRID');
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "SELECT tbl_store.name AS storeName, tbl_ticket.ticket AS ticketNum, tbl_employee.name AS server, tbl_ticket.open_dttm AS openTime, tbl_ticket.close_dttm AS closeTime, tbl_ticket.guest_count AS guestCount, tbl_menu_item.name AS item, tbl_ticket_item.real_total AS amount, tbl_ticket_item.qty, tbl_ticket_item.note,
		      tbl_ticket_item.ticket, tbl_ticket.tax, CAST(tbl_ticket_item.ticket_rid AS CHAR) as rid, tbl_ticket_item.atom, tbl_ticket_item.parent_atom,
		      CASE WHEN tbl_ticket_item.parent_atom > 1
		      THEN tbl_ticket_item.parent_atom +1 ELSE tbl_ticket_item.atom
		      END AS ordered_atom
            FROM tbl_ticket_item
            INNER JOIN tbl_store ON tbl_store.mid = tbl_ticket_item.store_mid
            INNER JOIN tbl_menu_item ON tbl_ticket_item.menuitem_mid = tbl_menu_item.mid
            INNER JOIN tbl_ticket ON tbl_ticket_item.ticket_rid = tbl_ticket.rid
            INNER JOIN tbl_employee ON tbl_ticket.main_server = tbl_employee.mid
            WHERE tbl_ticket_item.ticket_rid = $ticketRID AND tbl_ticket_item.cg = $cg AND tbl_ticket_item.store_mid = $storeMID
            ORDER BY ordered_atom asc";
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      echo json_encode($ret);
   }

   function checkListByPMT()
   {
      $paymentMID = $this->f3->get('POST.paymentMID');
      $storeMID = $this->f3->get('POST.storeMID');
      $cg = $this->f3->get('POST.cg');
      $date = $this->f3->get('POST.date');
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "select *,
             tbl_payment_method.name,
             tbl_ticket.ticket,
             tbl_ticket.open_dttm AS open,
             tbl_ticket.close_dttm AS close,
             tbl_employee.name AS server
             FROM tbl_ticket_payment
             INNER JOIN tbl_payment_method
             ON tbl_payment_method.mid = tbl_ticket_payment.paymeth_mid
             INNER JOIN tbl_ticket
             ON tbl_ticket_payment.ticket_rid = tbl_ticket.rid
             INNER JOIN tbl_employee
             ON tbl_ticket.last_server = tbl_employee.mid
             where paymeth_mid = $paymentMID
             AND tbl_ticket_payment.date = '$date'
             AND tbl_ticket_payment.cg = $cg
             AND tbl_ticket_payment.store_mid = $storeMID
             ORDER BY tbl_ticket.ticket";
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      echo json_encode($ret);
   }

   function realtimeCheckList()
   {
      $serial = $this->f3->get('POST.serial');
      $xml = "<XyzzyTalk><XyzzyHeader xyzzy_version=\"0.1.1.0\" api_id=\"POSCNX\" api_version=\"0.0.9.0\" api_command=\"CLOVERPOLL\"/></XyzzyTalk>";
      $storeIP = self::hqip($serial);
      //$storeIP = "192.168.0.66:32112";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "http://$storeIP");
      curl_setopt($ch, CURLOPT_PORT, "32112");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
      $output = curl_exec($ch);
      if ($output == false)
      {
         $ret = array('status' => 408);
         header('Access-Control-Allow-Origin: *');
      }
      else
      {
         curl_close($ch);
         $xml = new SimpleXMLElement($output);

         $ret = "<table id=\"tblRealtimeCheckList\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
         $ret .= "<thead><th class=\"text-center\"><b>Rm</b> <br /></th>";
         $ret .= "<th class=\"text-center\"><b>Svr</b></th>
               <th class=\"text-center\"><b>Tbl</b> <br /></th>
               <th class=\"text-center\"><b>Chk</b> <br /></th>
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

         foreach ($xml->PCX_TICKET as $out)
         {
            $attributes = current($out->attributes());
            $rid = $attributes[rid];
            $due = substr($attributes[due], 3, 20); // Cuts out $US from $US45.85
            $ret .= "<tr id=\"RID$rid\" data-rid=\"$rid\">";
            $ret .= "<td class=\"text-right\">$attributes[room]</td>";
            $ret .= "<td class=\"text-right\">$attributes[server]</td>";
            $ret .= "<td class=\"text-right\">$attributes[table]</td>";
            $ret .= "<td class=\"text-right\">$attributes[number]</td>";
            $ret .= "<td class=\"text-right\">$due</td>";
            $ret .= "</tr>";
         }

         $ret .= "</tbody>";
         $ret .= "<tfoot>";
         $ret .= "</tfoot>";
         header('Access-Control-Allow-Origin: *');
         echo $ret;
      }
   }

   function realtimeCheckDetail()
   {
      $rid = $this->f3->get('POST.rid');
      $serial = $this->f3->get('POST.serial');

      $xml = "<XyzzyTalk>
                 <XyzzyHeader xyzzy_version=\"0.1.1.0\" api_id=\"POSCNX\" api_version=\"0.0.9.0\" api_command=\"GETTICKET\" />
                    <PCX_TICKET rid='$rid'>
                       <Customer n=\"G\"/>
                    </PCX_TICKET>
              </XyzzyTalk>";

      $storeIP = self::hqip($serial);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "http://$storeIP");
      curl_setopt($ch, CURLOPT_PORT, "32112");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
      $output = curl_exec($ch);
      curl_close($ch);
      $xml = new SimpleXMLElement($output);

      $ret = "<table id=\"tblRealtimeCheckDetail\" class=\"table table-striped  table-condensed font-12px\" style=\"width:100%\" align=\"center\" border=\"2\">";
      $ret .= "<thead><th class=\"text-center\"><b>QTY</b> <br /></th>";
      $ret .= "<th class=\"text-center\"><b>ITM</b></th>
               <th class=\"text-center\"><b>Time</b> <br /></th>
               <th class=\"text-center\"><b>$</b> <br /></th>
               </tr>
               <tr>
               <th class=\"text-center\" data-sort=\"string-ins\"> <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"string-ins\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"time\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               <th class=\"text-center\" data-sort=\"string-ins\">  <span class=\"glyphicon glyphicon-arrow-down glyph-tiny glyph-flip\"></span> &nbsp <span class=\"glyphicon glyphicon-arrow-up glyph-tiny\"></span></th>
               </tr>
               </thead>";

      foreach ($xml->PCX_TICKET as $out)
      {

         foreach ($out->Item as $items)
         {
            $attributes1 = current($items);

            $qty = $attributes1[qty] ? $attributes1[qty] : "1";
            $name = $attributes1[n];
            $price = substr($attributes1[p], 3, 10);
            $time = substr($attributes1[t], 11, 8);
               // "1904-01-01T09:49:00"

            $ret .= "<tr>";
            $ret .= "<td class=\"text-right\">$qty</td>";
            $ret .= "<td class=\"text-right\">$name</td>";
            $ret .= "<td class=\"text-right\">$time</td>";
            $ret .= "<td class=\"text-right\">$price</td>";
            $ret .= "</tr>";

            foreach ($items->Mod as $mods)
            {
               $attributes2 = current($mods);
               $modName = $attributes2[n];
               $price = substr($attributes2[p], 3, 10);

               $ret .= "<tr>";
               $ret .= "<td class=\"text-right\"></td>";
               $ret .= "<td class=\"text-right text-danger\">$modName</td>";
               $ret .= "<td class=\"text-right\"></td>";
               $ret .= "<td class=\"text-right text-danger\">$price</td>";
               $ret .= "</tr>";
            }

         }
      }

      $ret .= "</tbody>";
      $ret .= "<tfoot>";
      $ret .= "</tfoot>";
      header('Access-Control-Allow-Origin: *');
      echo $ret;
   }

   function hqip($serial)
   {
      $command = "./hqip $serial";
      $ret = exec($command, $ip);
      return $ret;
   }

   function navBar()
   {
      $xtags = $this->f3->get('POST.xtags');
      $navBar = new NavBar();
      $bar = $navBar->getNav($xtags);
      header('Access-Control-Allow-Origin: *');
      echo $bar;
   }

}
