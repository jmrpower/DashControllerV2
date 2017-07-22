<?php

/**
 * Auth short summary.
 *
 * Auth description.
 *
 * @version 1.0
 * @author Justin
 */
class Auth
{
   /* Legacy
   function triAuth($token, $license)
   {
      $db = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $db->where('token', $token);
      $license = strtoupper($license);

      $db->where('license', $license);
      $res = $db->get('rp_dash_users');

      if ($res)
      {
         $ret = array("id" => $res[0][id], "valid" => 1, "securityLevel" => $res[0][securityLevel]);
         return json_encode($ret);
      }
      else
      {
         $ret = array("valid" => 0);
         return json_encode($ret);
      }
   }

   function authUserOLD()
   {
      $user = $this->f3->get('POST.user');
      $pass = $this->f3->get('POST.pass');
      $license = $this->f3->get('POST.license');
      $userUpper = strtoupper($user);
      $license = strtoupper($license);
      $pwString = "B1L2hexX9KToBABBu2TBx41dGKYBn7ex4OdTTwJF". $pass . $userUpper . $pass;
      $rpPass = hash('sha256', $pwString);
      $rpPass = strtoupper($rpPass);
      $dbRpower = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $dbRpower->where('username', $user);
      $dbRpower->where('password', $rpPass);
      $resRPDB = $dbRpower->get('tbl_users');

      if (count($resRPDB) == 1)
      {
         // If we have a user in tbl_user, check to see if we have a valid user in rp_dash_users.
         // if not, check rp_dash_license to see if we've built a user with a licence key
         // write this to rp_dash_user and update rp_dash_licence with the ID from rp_dash_user


         $token = uniqid();
         $token = $token . uniqid();
         $updateData = array ('token' => $token);
         $dbRPAuth = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
         $dbRPAuth->where('username', $user);
         $resdbRPAuth = $dbRPAuth->get('rp_dash_users');
         $storeCG = $resRPDB[0][user_cg];


         // We dont have a record in rp_dash_users so we will build one
         if (count($resdbRPAuth)  == 0)
         {

            // check rp_dash_license, make sure supplied licence key matches the username, add to rp_dash_users
            $dbRPDL = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
            $dbRPDL->where('username', $user);
            $dbRPDL->where('licenseKey', $license);
            $resdbRPDL = $dbRPDL->get('rp_dash_license');

            if ($resdbRPDL)
            {
               // Continue
            }
            else
            {
               $ret = array('status' => '401');
            }

            // here we add code to ignore multiple CGs because we just really don't care about tying a user to a cg..
            // that's handled by the list of stores, this field doesnt matter at all

            if (strpos($storeCG, "|"))
            {
               $storeCG = 1;
            }

            // [m2] add code for lastMessage
            $dbRpUsers = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
            $updateData = array('id' => null, 'username' => $user, 'cg' => $storeCG, 'token' => $token, 'license' => $license, 'xtags' => 'mdash');
            $res = $dbRpUsers->insert('rp_dash_users', $updateData);

            if ($res)
            {
               $xtags = explode("|", $user->xtags);
               $xtags = json_encode($xtags);
               $id = $res;
               $ret = array('status' => '200', 'token' => $res[0][token], 'id' => $res[0][id], 'xtags' => $xtags, 'storeCG' => $storeCG, 'id' => $id);
               $ret = json_encode($ret);
               return $ret;
            }
            else
            {
               $ret = array('status' => '401');
            }
         }

         // We have a record in rp_dash_users, check license against UUID
         elseif (count($resdbRPAuth) == 1 )
         {
            // If we don't have a licence populated, populate it.
            if ($license && $resdbRPAuth[0][license] == null)
            {
               $id = $resdbRPAuth[0][id];
               $dbRpUsers = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
               $updateData = array('username' => $user, 'cg' => 1, 'token' => $token, 'license' => $license, 'xtags' => 'mdash');
               $dbRpUsers->where('id', $id);
               $res = $dbRpUsers->update('rp_dash_users', $updateData);

               if ($res)
               {
                  $id = $res;
               }
            }
            elseif ($license != $resdbRPAuth[0][license])
            {
               $ret = array('status' => '401');
            }
            else
            {
            }

            $token = $resdbRPAuth[0][token];
            $id = $resdbRPAuth[0][id];
            $ret = array('status' => '200', 'token' => $resdbRPAuth[0][token], 'id' => $resdbRPAuth[0][id], 'xtags' => $xtags, 'storeCG' => $resdbRPAuth, 'id' => $id);
            $ret = json_encode($ret);
            echo $ret;
         }
         else
         {
            $ret = array('status' => '401');
         }
      }
      else
      {
         $ret = array('status' => '401');
      }
      echo $ret;
   }

   function checkTokenAuth($token, $uuid, $license)
   {
      $db = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
      $db->where('token', $token);
      $license = strtoupper($license);

      $db->where('license', $license);
      $res = $db->get('rp_dash_users');

      if ($res)
      {
         $cg = $res[0][cg];
         $xtags = $res[0][xtags];
         $lastMessage = $res[0][lastMessage];
         $ret = array("cg" => $cg, "token" => $token, "xtags" => $xtags, "lastMessage" => $lastMessage);
         return json_encode($ret);
      }
      elseif (!$res)
      {
         $token = authUser($user, $pass);
         return $token;
      }
      else
      {
         return "error";
      }
   }
*/



}
