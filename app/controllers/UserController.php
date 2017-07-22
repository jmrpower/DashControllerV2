<?php
/**
 * User controller of sample applicaiton
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Fat-Free-PHP-Bootstrap-Site
 * @author   Mark Takacs <takacsmark@takacsmark.com>
 * @license  MIT
 * @link     takacsmark.com
 */

require("app/utils/mysql.php");

 /**
 *  User controller class
 *
 * @category PHP
 * @package  Fat-Free-PHP-Bootstrap-Site
 * @author   Mark Takacs <takacsmark@takacsmark.com>
 * @license  MIT
 * @link     takacsmark.com
 */
class UserController extends Controller
{
    /**
     * Renders the login screen
     *
     * @return void
     */
    function render()
    {
       $this->f3->set('body', 'login.htm');
       $template=new Template;
       echo $template->render('layoutLogin.htm');
    }
    /**
     * We override the beforeroute function in the `Controller` class
     * Therefore the parent behaviour will not happen
     * i.e. we do not check if there is a logged in user, because
     * no user is logged in when the login view is loaded
     *
     * @return void
     */
    function beforeroute()
    {
    }
    /**
     * Authenticates the user based on the inputs
     * from the login form on login.html
     * Redirects the user to the dashboard if login is successful
     * Redirects to login.html if login fails
     *
     * @return void
     */
    /*
    function authenticate()
    {
        $username = $this->f3->get('POST.tbUser');
        $password = $this->f3->get('POST.tbPass');
        $username = strtoupper($username);
        $password = "B1L2hexX9KToBABBu2TBx41dGKYBn7ex4OdTTwJF". $password . $username . $password;
        $password = hash('sha256', $password);
        $password = strtoupper($password);
        $user = new User($this->db);
        $user->getByName($username);
        if($user->dry())
        {
            $this->f3->reroute('/login');
        }
        if($password = $user->password)
        {
           $db = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
           $db->where('username', $username);
           $res = $db->get('rp_dash_users');






           $this->f3->set('SESSION.user', $username);
           $this->f3->set('SESSION.token', $res[0][token]);
           $this->f3->set('SESSION.id', $res[0][id]);
           $this->f3->set('SESSION.license', $res[0][license]);
           $this->f3->set('SESSION.securityLevel', $res[0][securityLevel]);
           $this->f3->set('SESSION.userStores', $res[0][userStores]);
           $this->f3->set('SESSION.loggedin', true);
           $this->f3->reroute('/');
        }
        else
        {
            $this->f3->reroute('/login');
        }
    }

    function authenticateMobile()
    {
       $username = $this->f3->get('POST.user');
       $password = $this->f3->get('POST.pass');
       $license = $this->f3->get('POST.license');
       $username = strtoupper($username);
       $password = "B1L2hexX9KToBABBu2TBx41dGKYBn7ex4OdTTwJF". $password . $username . $password;
       $password = hash('sha256', $password);
       $password = strtoupper($password);
       $user = new User($this->db);
       $user->getByName($username);
       if($user->dry())
       {
          $ret = array('status' => '401');
       }

       if($password = $user->password) // User exists in Ted's DB, check dash_license
       {
          $db = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
          $db->where('username', $username);
          $db->where('licenseKey', $license);
          $res = $db->get('rp_dash_license');

          if ($res) // User exists in Ted's DB and has a license, check for user record
          {
             $db->where('username', $username);
             $db->where('license', $license);
             $res = $db->get('rp_dash_users');

             if ($res) // User exists in Ted's DB, has license and a user record
             {
                $ret = array('status' => '200', 'token' => $res[0][token], 'id' => $res[0][id], 'xtags' => $xtags);
             }
             else // Noooooope - Make a user record
             {
                $updateData = array('id' => null, 'username' => $username, 'cg' => 1, 'token' => $token, 'license' => $license, 'xtags' => 'mdash');
                $res = $db->insert('rp_dash_users', $updateData);
                if ($res)
                {
                  $id = $res;
                  $ret = array('status' => '200', 'token' => $res[0][token], 'id' => $res[0][id], 'xtags' => $xtags);
                  $ret = json_encode($ret);
               }
               else
               {
                  // error, couldn't create user
                  $ret = array('status' => '401');
               }
             }
          }
          else // Noooope - License not valid
          {
             $ret = array('status' => '401');
          }
       }
       else // Nooooope - No record found in Ted's DB
       {
          $ret = array('status' => '401');
       }
       header('Access-Control-Allow-Origin: *');
       echo json_encode($ret);

    }
    */

// $this->f3->set('SESSION.user', $username);
//$this->f3->set('SESSION.token', $res[0][token]);
//$this->f3->set('SESSION.id', $res[0][id]);
//$this->f3->set('SESSION.license', $res[0][license]);
//$this->f3->set('SESSION.securityLevel', $res[0][securityLevel]);
//$this->f3->set('SESSION.userStores', $res[0][userStores]);
//$this->f3->set('SESSION.loggedin', true);
//$xtags = explode("|", $user->xtags);
//$xtags = json_encode($xtags);




    function changePassword()
    {
       $username = $this->f3->get('POST.user');
       $passwordOld = $this->f3->get('POST.oldPass');
       $passwordNew = $this->f3->get('POST.newPass');
       $username = strtoupper($username);
       $passwordNew = "B1L2hexX9KToBABBu2TBx41dGKYBn7ex4OdTTwJF". $passwordNew . $username . $passwordNew;
       $passwordNew = hash('sha256', $passwordNew);
       $passwordNew = strtoupper($passwordNew);
       $db = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
       $db->where('username', $username);
       $query = array('password' => $passwordNew);

       if ($db->update('tbl_users', $query))
       {
          header('Access-Control-Allow-Origin: *');
          $ret = array('status' => 200);
          echo json_encode($ret);
       }
       else
       {
          header('Access-Control-Allow-Origin: *');
          $ret = array('status' => 401);
          echo json_encode($ret);
       }
    }

    function authUser()
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

             $dbRpUsers = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
             $updateData = array('id' => null, 'username' => $user, 'cg' => $storeCG, 'token' => $token, 'license' => $license, 'xtags' => 'mdash');
             $res = $dbRpUsers->insert('rp_dash_users', $updateData);

             if ($res)
             {
                $xtags = explode("|", $resRPDB[0][xtags]);
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
             $xtags = explode("|", $resRPDB[0][xtags]);
             $xtags = json_encode($xtags);
             $token = $resdbRPAuth[0][token];
             $id = $resdbRPAuth[0][id];
             $ret = array('status' => '200', 'token' => $resdbRPAuth[0][token], 'id' => $resdbRPAuth[0][id], 'xtags' => $xtags, 'storeCG' => $resdbRPAuth[0][cg], 'id' => $id);
             $ret = json_encode($ret);
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
       header('Access-Control-Allow-Origin: *');
       echo $ret;
    }
}
