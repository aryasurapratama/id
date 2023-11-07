<?php
A1:
date_default_timezone_set("Asia/Jakarta");
require('./helper/app.php');
echo "[+] Input List (email|pass): ";
$file = trim(fgets(STDIN));
if(empty($file) || !file_exists($file)) {
	echo"[+] File not found!\n";
	goto A1;
}
$list = explode("\n", str_replace("\r", "", file_get_contents($file)));
foreach ($list as $key => $akun) {
    $nomor = explode("|",$akun)[0];
    $pw = explode("|",$akun)[1];
    $login = curl('https://api2.idgame365.com/api/login','{"account":"'.$nomor.'","password":"'.$pw.'"}');
    print_r($login);
    if(strpos($login,'"login berhasil"')){
        echo "LOGIN SUCCES \n";
        $respone = json_decode($login);
        $token = $respone->data->token;
        $cekuser = curl('https://api2.idgame365.com/api/userinfo',null, $token);
        $account = json_decode($cekuser)->data->nickname;
        save("$token\n","$account.txt");
    }
}
