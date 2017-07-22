<?php

/**
 * PageBuilder short summary.
 *
 * PageBuilder description.
 *
 * @version 1.0
 * @author Justin
 */
class PageBuilder
{
   function div($id, $class, $content)
   {

   }

   function i($id, $class, $content)
   {

   }

   function hr($id, $class)
   {

   }



}

class NavBar
{
   function getNav($xtags)
   {
      $xtags = json_decode($xtags);
      $ordOK = in_array("ORD", $xtags) ? true : false;
      
      $li .= "<li id=\"overviewPage\" class=\"navigation\" data-page=\"overview\"><a href=\"\">Overview</a></li>";
      $li .= "<li id=\"salesPage\" class=\"navigation\" data-page=\"sales\"><a href=\"\">Sales</a></li>";
      $li .= "<li id=\"disvoidPage\" class=\"navigation\" data-page=\"disvoid\"><a href=\"\">Discounts/Voids</a></li>";
      $li .= "<li id=\"laborPage\" class=\"navigation\" data-page=\"labor\"><a href=\"\">Labor</a></li>";
      $li .= "<li id=\"alertPage\" class=\"navigation\" data-page=\"alerts\"><a href=\"\">Email Alerts</a></li>";

      if ($ordOK == true)
      {
         $li .= "<li id=\"orderPage\" class=\"navigation\" data-page=\"order\"><a href=\"\">Order Supplies</a></li>";
      }

      $li .= "<li id=\"utilsPage\" class=\"navigation\" data-page=\"utils\"><a href=\"\">Utils</a></li>";
      $li .= "<li class=\"navigation\" data-page=\"logout\"><a href=\"\">Logout</a></li>";

      return $li;
   }
}