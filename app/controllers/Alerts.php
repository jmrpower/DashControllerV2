<?php

/**
 * Alerts short summary.
 *
 * Alerts description.
 *
 * @version 1.0
 * @author Justin
 */
require('app/utils/k3utils.php');

class Alerts extends Controller
{
   function createAlertSettings()
   {
      $token = $this->f3->get('POST.token');
      $cg = $this->f3->get('POST.cg');
      $storeMID = $this->f3->get('POST.storeMID');
      $alertEmail = $this->f3->get('POST.alertEmail');
      $userID = $this->f3->get('POST.userID');
      $t1 = $this->f3->get('POST.t1');
      $t2 = $this->f3->get('POST.t2');
      $void = $this->f3->get('POST.voidOn');
      $discount = $this->f3->get('POST.discountOn');
      $license = $this->f3->get('POST.license');

      // storeMID and userID make a unique record
      $dbTZ = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $queryTZ = "SELECT lup_dttm, lup_zdttm FROM tbl_store WHERE cg = $cg AND mid = $storeMID";
      $resTZ = $dbTZ->query($queryTZ);
      foreach($resTZ as $rowTZ)
      {
         $retTZ[] = $rowTZ;
      }
      $tz = getTimeDifference($retTZ[0][lup_dttm], $retTZ[0][lup_zdttm]);
      $dbRpUsers = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "INSERT INTO rp_txt_alert (id, cg, storeMID, alertEmail, userID, t1, t2, void, discount, lastRunD, lastRunV, tzDiff) VALUES (null, $cg, $storeMID, '$alertEmail', $userID, $t1, $t2, $void, $discount, null, null, $tz) ON DUPLICATE KEY UPDATE cg = $cg, storeMID = $storeMID, alertEmail = '$alertEmail', userID = $userID, t1 = $t1, t2 = $t2, void = $void, discount = $discount";
      $res = $dbRpUsers->query($query);
      $ret[0] = "success" ;
      header('Access-Control-Allow-Origin: *');
      echo json_encode($ret);
   }

   function getAlertSettings()
   {
      $userID = $this->f3->get('POST.userID');
      $storeMID = $this->f3->get('POST.storeMID');
      $db = mysqli_connect('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $query = "SELECT * FROM rp_txt_alert WHERE userID = $userID AND storeMID = $storeMID";
      $res = $db->query($query);
      foreach($res as $row)
      {
         $ret[] = $row;
      }
      header('Access-Control-Allow-Origin: *');
      echo json_encode($ret);
   }


}