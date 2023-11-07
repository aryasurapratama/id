<?php
date_default_timezone_set("Asia/Jakarta");
require('./helper/app.php');
echo color('green', "[" . date("H:i:s") . "] ") . "Input File example (token.txt) : ";
$file = trim(fgets(STDIN));

for ($i = 0; $i < 50; $i++) {
    echo"putaran ke $i \n";
    echo "\n";
    $list = explode("\n", str_replace("\r", "", file_get_contents($file)));
    foreach ($list as $key => $token) {
        $cekuser = curl('https://api2.idgame365.com/api/userinfo', null, $token);
        if (strpos($cekuser, '"ok"') !== false) {
            echo color('green', "[" . date("H:i:s") . "] ") . "Token Valid..\n";
            $account = json_decode($cekuser)->data->nickname;
            $saldo = json_decode($cekuser)->data->now_money;
            $poin = json_decode($cekuser)->data->integral;

            echo color('green', "[" . date("H:i:s") . "] ") . "Data Account :\n";
            echo color('green', "[" . date("H:i:s") . "] ") . "Nick name : $account\n";
            echo color('green', "[" . date("H:i:s") . "] ") . "saldo : $saldo\n";
            echo color('green', "[" . date("H:i:s") . "] ") . "poin : $poin\n";
            $bet_ganjil = curl('https://api2.idgame365.com/api/order/create_oe','{"type":1,"game_type":24,"money":"10001"}',$token);
            // print_r($bet_ganjil);
            if(strpos($bet_ganjil, '200')){
                echo color('green', "[" . date("H:i:s") . "] ") . "Bet Ganjil Succesfully \n";
            }else{
                echo color('red', "[" . date("H:i:s") . "] ") . "Bet Ganjil Gagal \n";

            }
            $bet_genap = curl('https://api2.idgame365.com/api/order/create_oe','{"type":1,"game_type":24,"money":"10000"}',$token);
            // print_r($bet_genap);
            if(strpos($bet_genap, '200')){
                echo color('green', "[" . date("H:i:s") . "] ") . "Bet Genap Succesfully \n";
            }else{
                echo color('red', "[" . date("H:i:s") . "] ") . "Bet Genap Gagal \n";

            }
            echo color('green', "[" . date("H:i:s") . "] ") ."Waiting 60 Sec....";
            sleep(61);
            $poinclaim = curl('https://api2.idgame365.com/api/order/game_order_return', '{}', $token);
            // print_r($poinclaim);
            if (strpos($poinclaim, '200') !== false) {
                echo color('green', "[" . date("H:i:s") . "] ") . "Claim poin berhasil \n";
            } else {
                echo color('red', "[" . date("H:i:s") . "] ") . "Claim poin gagal \n";
            }
        }
    }
   
}
?>