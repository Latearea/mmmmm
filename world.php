
<?php
include 'jaringan.php';
require_once 'baca.php';
$TOKEN      = "279034656:AAEXD-9EeukCV5E1_NK4pn3NNAho-efQAQI";
$debug = false;
 

 
function request_url($method)
{
    global $TOKEN;
    return "https://api.telegram.org/bot" . $TOKEN . "/". $method;
}
 

function get_updates($offset) 
{
    $url = request_url("getUpdates")."?offset=".$offset;
        $resp = file_get_contents($url);
        $result = json_decode($resp, true);
        if ($result["ok"]==1)
            return $result["result"];
        return array();
}

function send_reply($chatid, $msgid, $text)
{
    global $debug;
    $data = array(
        'chat_id' => $chatid,
        'text'  => $text,
        'reply_to_message_id' => $msgid   
    );
   $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context  = stream_context_create($options); 
    $result = file_get_contents(request_url('sendMessage?parse_mode=html&disable_web_page_preview=true'), false, $context);
    if ($debug) 
        print_r($result);
}
 

function create_response($text, $message)
{
    $hasil = '';  
    $fromid = $message["from"]["id"]; // variable penampung id user
    $chatid = $message["chat"]["id"];
    $pesanid= $message['message_id'];
    isset($message["from"]["username"])
        ? $chatuser = $message["from"]["username"]
        : $chatuser = '';
    isset($message["from"]["last_name"]) 
        ? $namakedua = $message["from"]["last_name"] 
        : $namakedua = '';   
    $namauser = $message["from"]["first_name"]. ' ' .$namakedua;
    $textur = preg_replace('/\s\s+/', ' ', $text); 
    $command = explode(' ',$textur,2);
    $tandac= substr($command[0],4,1);
    $tanda5= substr($command[0],5,1);
    $tanda6= substr($command[0],6,1);
    
    /*player*/
    $tdata=tampildata(koneksi(),"nick",$fromid,"player");
    $tlokasi=tampildata(koneksi(),"lokasi",$fromid,"player");
    $thp=tampildata(koneksi(),"hp",$fromid,"player");
    $tclan=tampildata(koneksi(),"clan",$fromid,"player");
    $txp=tampildata(koneksi(),"exp",$fromid,"player");
    $tgold=tampildata(koneksi(),"gold",$fromid,"player");
    $tdia=tampildata(koneksi(),"diamond",$fromid,"player");
    $tguild=tampildata(koneksi(),"guild",$fromid,"player");
    $tsenjata=tampildata(koneksi(),"senjata",$fromid,"player");
    $tbaju=tampildata(koneksi(),"baju",$fromid,"player");
    
    //senjata
    $isenjatanama=tampildata(koneksi(),"nama",$tsenjata,"senjata");
    $isenjatamin=tampildata(koneksi(),"min_attk",$tsenjata,"senjata");
    $isenjatamax=tampildata(koneksi(),"max_attk",$tsenjata,"senjata");
    $isenjatapow=tampildata(koneksi(),"power",$tsenjata,"senjata");
    
    //baju
    $ibajunama=tampildata(koneksi(),"nama",$tbaju,"baju");
    $ibajuhp=tampildata(koneksi(),"hp",$tbaju,"baju");
    $ibajupow=tampildata(koneksi(),"power",$tbaju,"baju");
    
    //tas
    
    
    
    
    $uxp="300";
    

    
    
    if($tdata!="")
    switch ($command[0])
    {
     case '!iamgm':
         $hasil="Selamat datang GM ";
         break;
    
    case '/market':
        if($tlokasi==1)
        {
            
        
        $dm[500];
        $kodetas="market"."$tlokasi";
        $pencari=1;
        while($pencari<=9)
    {
        $itasstatus=tampildata(koneksimarket(),"status","$pencari","$kodetas");
        $itasnobrg=tampildata(koneksimarket(),"nobrg","$pencari","$kodetas");
        if($itasstatus==1)
        {
            $dt="baju";
        }
        elseif ($itasstatus==2)
        {
            $dt="senjata";    
        }
        $d=bacatas(koneksi(),"nama","$itasnobrg","$itasstatus","$dt");
        $dm[$pencari]="$d";
        $pencari++;
    }
        $hasil="BARANG YANG DI JUAL :
1. $dm[1] /lihat1
2. $dm[2] /lihat2
3. $dm[3] /lihat3
4. $dm[4] /lihat4
5. $dm[5] /lihat5
6. $dm[6] /lihat6
7. $dm[7] /lihat7
8. $dm[8] /lihat8
9. $dm[9] /lihat9";
        }
        break;
        
        case '/lihat'.$tanda6:
            if ($tanda6>=1&&$tanda6<=9)
            {
        $kodetas="market"."$tlokasi";
        $itasstatus=tampildata(koneksimarket(),"status","$tanda6","$kodetas");
        $itasnobrg=tampildata(koneksimarket(),"nobrg","$tanda6","$kodetas");
        if($itasstatus==1)
        {   $dt="baju";
            $nama=bacatas(koneksi(),"nama","$itasnobrg","$itasstatus","$dt");
            $hp=bacatas(koneksi(),"hp","$itasnobrg","$itasstatus","$dt");
            $pow=bacatas(koneksi(),"power","$itasnobrg","$itasstatus","$dt");
            $harga=bacatas(koneksi(),"harga","$itasnobrg","$itasstatus","$dt");
            $hasil="NAMA : $nama
HP : $hp
POWER : $pow
HARGA : $harga
/buy$tanda6 untuk membeli";

        }
        elseif($itasstatus==2)
        {   
            $dt="senjata";
            $nama=bacatas(koneksi(),"nama","$itasnobrg","$itasstatus","$dt");
            $min=bacatas(koneksi(),"min_attk","$itasnobrg","$itasstatus","$dt");
            $max=bacatas(koneksi(),"max_attk","$itasnobrg","$itasstatus","$dt");
            $pow=bacatas(koneksi(),"power","$itasnobrg","$itasstatus","$dt");
            $harga=bacatas(koneksi(),"harga","$itasnobrg","$itasstatus","$dt");
            $hasil="NAMA : $nama
ATTACK MIN : $min
ATTACK MAX : $max
POWER : $pow
HARGA : $harga
/buy$tanda6 untuk membeli";
    
        }
        else
        {
            $hasil="Barang tidak ada!!!";
        }
    }
        else
            {
            $hasil="same";
            }
        break;
        
        case '/buy'.$tandac:
            if ($tandac>=1&&$tandac<=9)
            {
        $kodetas="market"."$tandac";
        $itasstatus=tampildata(koneksimarket(),"status","$tandac","$kodetas");
        $itasnobrg=tampildata(koneksimarket(),"nobrg","$tandac","$kodetas");
        
        if($itasstatus==1)
        {   
            $dt="baju";
            $harga=bacatas(koneksi(),"harga","$itasnobrg","$itasstatus","$dt");
            $tgold=tampildata(koneksi(),"gold",$fromid,"player");
            if($tgold<=$harga)
            {
                $hasil="Gold anda kurang";
                
            }
            else
            {
                $kode="tas_"."$fromid";
                $tri=1;$pm=true;
                $hit=0;
            $itasid=tampildata(koneksitas(),"id","$tri",$kode);
            if($itasid<=9)
            {
            while($tri<=9&&$pm==true)
            {
                
            if($itasid==null)
            {
            $uang[1]=$tgold-$harga;
            $u=updategold(koneksi(),$fromid,$uang[1],"player");
            $h=menambahtas(koneksitas(),$tri,$itasnobrg,$itasstatus,$kode);
            $hasil="Berhasil membeli";
            $pm=false;    
            }
            
            else
            {
                $tri++;
                $itasid=tampildata(koneksitas(),"id","$tri",$kode);
                $hit++;
            }
            if($hit==9)
            {
                $hasil="Tas anda penuh";
            }
            
            }
            
            }
            else 
            {
                $hasil="";
            }    
                
            }
        }
        elseif($itasstatus==2)
        {   
            $dt="senjata";
            $harga=bacatas(koneksi(),"harga","$itasnobrg","$itasstatus","$dt");
            $tgold=tampildata(koneksi(),"gold",$fromid,"player");
            if($tgold<=$harga)
            {
                $hasil="Gold anda kurang";
                
            }
            else
            {
                $kode="tas_"."$fromid";
                $tri=1;$pm=true;
            $itasid=tampildata(koneksitas(),"id","$tri",$kode);
            if($itasid<=9)
            {
            while($tri<=9&&$pm==true)
            {
                
            if($itasid==null)
            {
            $uang[1]=$tgold-$harga;
            $u=updategold(koneksi(),$fromid,$uang[1],"player");
            $h=menambahtas(koneksitas(),$tri,$itasnobrg,$itasstatus,$kode);
            $hasil="Berhasil membeli";
            $pm=false;    
            }
            
            else
            {
                $tri++;
                $itasid=tampildata(koneksitas(),"id","$tri",$kode);
                $hit++;
            }
            if ($hit==9)
            {
                $hasil="Tas Anda Penuh";
            }
            
            }
            
            }
            else 
            {
                $hasil="Tas Anda penuh";
            }    
                
            }
        }
            }
        else
            {
            $hasil="same";
            }
        break;
         
         
         
    case '/i':
        $totalhp=100+$ibajuhp;
        $hasil="NAMA : <b>$tdata</b>
HP : $thp / $totalhp
CLAN : $tclan
XP : $txp/$uxp
GOLD : $tgold
DIAMOND : $tdia
GUILD : $tguild

";
        break;
  
    case '/b':
        $power=$isenjatapow+$ibajupow;
        $hasil="SENJATA : $isenjatanama
ARMOR : $ibajunama
Attack Min : $isenjatamin
Attack Max : $isenjatamax
Battle Point : $power";

        break;
        
    case '/in':
        $dm[500];
        $kodetas="tas_"."$fromid";
        $pencari=1;
        while($pencari<=9)
    {
        $itasstatus=tampildata(koneksitas(),"status","$pencari","$kodetas");
        $itasnobrg=tampildata(koneksitas(),"nobrg","$pencari","$kodetas");
        if($itasstatus==1)
        {
            $dt="baju";
        }
        elseif ($itasstatus==2)
        {
            $dt="senjata";    
        }
        $d=bacatas(koneksi(),"nama","$itasnobrg","$itasstatus","$dt");
        $dm[$pencari]="$d";
        $pencari++;
    }
        $hasil="TAS :
1. $dm[1] /cek1
2. $dm[2] /cek2
3. $dm[3] /cek3
4. $dm[4] /cek4
5. $dm[5] /cek5
6. $dm[6] /cek6
7. $dm[7] /cek7
8. $dm[8] /cek8
9. $dm[9] /cek9";
        break;
        
        case '/cek'.$tandac:
            if ($tandac>=1&&$tandac<=9)
            {
        $kodetas="tas_"."$fromid";
        $itasstatus=tampildata(koneksitas(),"status","$tandac","$kodetas");
        $itasnobrg=tampildata(koneksitas(),"nobrg","$tandac","$kodetas");
        if($itasstatus==1)
        {   $dt="baju";
            $nama=bacatas(koneksi(),"nama","$itasnobrg","$itasstatus","$dt");
            $hp=bacatas(koneksi(),"hp","$itasnobrg","$itasstatus","$dt");
            $pow=bacatas(koneksi(),"power","$itasnobrg","$itasstatus","$dt");
            $hasil="NAMA : $nama
HP : $hp
POWER : $pow
/use$tandac untuk mengunakan
/drop$tandac untuk membuang";
        }
        elseif($itasstatus==2)
        {   
            $dt="senjata";
            $nama=bacatas(koneksi(),"nama","$itasnobrg","$itasstatus","$dt");
            $min=bacatas(koneksi(),"min_attk","$itasnobrg","$itasstatus","$dt");
            $max=bacatas(koneksi(),"max_attk","$itasnobrg","$itasstatus","$dt");
            $pow=bacatas(koneksi(),"power","$itasnobrg","$itasstatus","$dt");
            $hasil="NAMA : $nama
ATTACK MIN : $min
ATTACK MAX : $max
POWER : $pow
/use$tandac untuk mengunakan
/drop$tandac untuk membuang";
    
        }
        else
        {
            $hasil="Barang tidak ada!!!";
        }
    }
        else
            {
            $hasil="same";
            }
        break;
        
        case '/use'.$tandac:
            $mox[500];
            if ($tandac>=1&&$tandac<=10)
            {
        $kodetas="tas_"."$fromid";
        $itasstatus=tampildata(koneksitas(),"status","$tandac","$kodetas");
        $itasnobrg=tampildata(koneksitas(),"nobrg","$tandac","$kodetas");
        if($itasstatus==1)
        {   
            $mox[1]=$tbaju;
            $u=updateuse(koneksi(),$fromid,"baju",$itasnobrg,"player");
            $x=updateusetas(koneksitas(),$tandac,$mox[1],"$kodetas");
            $hasil="berhasil";
        }
        elseif($itasstatus==2)
        {   
            $mox[2]=$tsenjata;
            $u=updateuse(koneksi(),$fromid,"senjata",$itasnobrg,"player");
            $x=updateusetas(koneksitas(),$tandac,$mox[2],"$kodetas");
            $hasil="berhasil";
        }
        else
        {
            $hasil="Barang yang digunakan tidak ada!!!";
        }
    }
        else
            {
            $hasil="same";
            }
        break;    
         
        case '/drop'.$tanda5:
            $mox[500];
             
            if ($tanda5>=1&&$tanda5<=9)
            {
            $kodetas="tas_"."$fromid";
            $itasid=tampildata(koneksitas(),"id","$tanda5",$kodetas);
            if($itasid!=null)
            {
            $h=menghapus(koneksitas(),$tanda5,$kodetas);
            $peng=$tanda5+1;
            while($peng<=9)
            {   
                $next=$peng-1;
                $u=updatedrop(koneksitas(),$peng,$next,$kodetas);
                $peng++;
            }
            $hasil="berhasil";
            }
            
            else
            {
                $hasil="Barang yang di jatuhkan tidak ada";
            }
                
            }
            else
            {
            $hasil="Barang tidak ada";
            }
        break; 
         
    default:
        $hasil="";
        break;
         
    }  
    else
    {   
        if ($tclan=="")
        switch ($command[0])
        {
            case '/start':
                $hasil="Selamat datang di dunia Angel and Demon.
Pada abad pertengahan terjadi perperangan antara dua clan Angel dan Demon.
Perperangan ini meninggalkan pengikutnya.
Anda memilih mengikuti:
/angel memilih mengikuti clan Angel.
/demon memilih mengikuti clan Demon.";
                $m=menambahid(koneksi(),$fromid,"player");
                break;
                
            case '/angel':
                $hasil="Selamat ada memasuki clan Angel.
Semua melihat ke anda
Siapa Nama anda ?";
                $u=updateclan(koneksi(),$fromid,"Angel","player",3,3);
                $kodetas="tas_"."$fromid";
                $t=tambahtas(koneksitas(),"$kodetas");

                break;
                
            case '/demon':
                $hasil="Selamat ada memasuki clan Demon.
Semua melihat ke anda
Siapa Nama anda ?";
                $u=updateclan(koneksi(),$fromid,"Demon","player",4,4);
                $kodetas="tas_"."$fromid";
                $t=tambahtas(koneksitas(),"$kodetas");
                break;
                        
            
            default:
                $hasil="Ikuti step yang ada!!!";
                break;
        }
        else 
        {
            if ($textur!="")
            {
                $n=updatenama(koneksi(),$fromid,$textur,"player");
                $b=bacanama(koneksi(),$fromid,"nick","player");
                $hasil="Semua warga mengingat nama anda.
Selamat berkeliling kota.";
            }
        }
       
    }
    return $hasil;
}

function process_message($message)
{
    $updateid = $message["update_id"];
    $message_data = $message["message"];
    if (isset($message_data["text"])) {
    $chatid = $message_data["chat"]["id"];
        $message_id = $message_data["message_id"];
        $text = $message_data["text"];
        $response = create_response($text, $message_data);
        if (!empty($response))
          send_reply($chatid, $message_id, $response);
    }
    return $updateid;
}
 
function process_one()
{
    global $debug;
    $update_id  = 0;
    echo "-";
 
    if (file_exists("last_update_id")) 
        $update_id = (int)file_get_contents("last_update_id");
 
    $updates = get_updates($update_id);
   
    if ((!empty($updates)) and ($debug) )  {
        echo "\r\n===== isi diterima \r\n";
        print_r($updates);
    }
 
    foreach ($updates as $message)
    {
        echo '+';
        $update_id = process_message($message);
    }
    
   
    file_put_contents("last_update_id", $update_id + 1);
}

while (true) {
    process_one();
    sleep(1);
}

    
?>
