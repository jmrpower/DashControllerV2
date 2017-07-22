<?php
   function getGUID()
   {
      mt_srand((double)microtime()*10000);
      $charid = strtoupper(md5(uniqid(rand(), true)));
      $hyphen = chr(45);// "-"
      $uuid = substr($charid, 0, 8).$hyphen
          .substr($charid, 8, 4).$hyphen
          .substr($charid,12, 4).$hyphen
          .substr($charid,16, 4).$hyphen
          .substr($charid,20,12);//
      return $uuid;

   }

   function k3ThisDayLastYear($date)
   {
      $date = new DateTime($date);
      $day = $date->format('l');
      $date->sub(new DateInterval('P1Y'));
      $date->modify('next ' . $day);
      return $date->format('Y-m-d');
   }

   function getTimeDifference($time1, $time2)
   {
      $time1 = strtotime("$time1");
      $time2 = strtotime("$time2");

      if ($time2 < $time1)
      {
         $time2 = $time2 + 86400;
      }

      return ($time2 - $time1) / 3600;
   }