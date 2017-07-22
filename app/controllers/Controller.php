<?php
/**
 * Generic Parent Controller of the Sample Site
 * All controllers extend this class
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Fat-Free-PHP-Bootstrap-Site
 * @author   Mark Takacs <takacsmark@takacsmark.com>
 * @license  MIT
 * @link     takacsmark.com
 */

 /**
 * Parent Controller class
 *
 * @category PHP
 * @package  Fat-Free-PHP-Bootstrap-Site
 * @author   Mark Takacs <takacsmark@takacsmark.com>
 * @license  MIT
 * @link     takacsmark.com
 */

class Controller
{
    protected $f3;
    protected $db;

    /**
     * The beforeroute event handler is provided by f3 and it is
     * automatically invoked by f3 before every time routing happens
     *
     * We check in the below code if there is a user information in the session
     * i.e. if there is a logged in user
     *
     * @return void
     */

    function beforeroute()
    {
       if (!class_exists('MysqliDb'))
       {
          require("app/utils/mysql.php");
       }

       $isMobile = $_POST[isMobile];

       if ($isMobile == 1)
       {
          $user = $_POST[user];
          $pass = $_POST[pass];
          $license = $_POST[license];
          $token = $_POST[token];

          $db1 = new MysqliDb ('192.168.0.18', 'rpower', 'rpower123', 'rpower');
          $db1->where('token', $token);
          $db1->where('username', $user);
          $res = $db1->get('rp_dash_users');
          if ($res)
          {
             $this->f3->set('SESSION.user', $_POST[user]);
             $this->f3->set('SESSION.pass', $_POST[pass]);
             $this->f3->set('SESSION.license', $_POST[license]);
             $this->f3->set('SESSION.token', $_POST[token]);
             $xtags = $_POST[xtags];
             $xtags = json_decode($xtags);
             $this->f3->set('SESSION.xtags', $xtags);
          }
          else
          {
             $ret = array('status' => '401');
             header('Access-Control-Allow-Origin: *');
             echo json_encode($ret);
             exit;
          }
       }

       if($this->f3->get('SESSION.user') === null )
       {
          $this->f3->reroute('/login');
          exit;
        }

       header('Access-Control-Allow-Origin: *');
    }

    /**
     * The beforeroute event handler is provided by f3 and it is
     * automatically invoked by f3 after every time routing happens
     *
     * The below code is just a placeholder
     *
     * @return void
     */
    function afterroute()
    {
        // your code comes here
    }

    /**
     * Class constructor
     * We connect to the mysql database here and
     * Assign value to f3 and db protected class variables defined above
     *
     * @return void
     */
    function __construct()
    {
        $f3=Base::instance();
        $this->f3=$f3;

        $db=new DB\SQL
        (
            $f3->get('devdb'),
            $f3->get('devdbusername'),
            $f3->get('devdbpassword'),
            array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
        );

        $this->db=$db;
    }
}