
<?php
include 'jaringan.php';
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
    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context  = stream_context_create($options); 
    $result = file_get_contents(request_url('sendMessage'), false, $context);
    if ($debug) 
        print_r($result);
}
 

function create_response($text, $message)
{
    return $hasil;
}
 
// fungsi pesan yang sekaligus mengupdate offset 
// biar tidak berulang-ulang pesan yang di dapat 
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
    // jika debug=0 atau debug=false, pesan ini tidak akan dimunculkan
    if ((!empty($updates)) and ($debug) )  {
        echo "\r\n===== isi diterima \r\n";
        print_r($updates);
    }
 
    foreach ($updates as $message)
    {
        echo '+';
        $update_id = process_message($message);
    }
    
    // update file id, biar pesan yang diterima tidak berulang
    file_put_contents("last_update_id", $update_id + 1);
}
// metode poll
// proses berulang-ulang
// sampai di break secara paksa
// tekan CTRL+C jika ingin berhenti 
while (true) {
    process_one();
    

    $selalu=7;
    $data=tampilhp(koneksi(),"nick",$selalu,"player");
    while ($data!=null)
    {    
         $bajuhp=tampilhp(koneksi(),"baju",$selalu,"player");
         $ibajuhp=tampildata(koneksi(),"hp",$bajuhp,"baju");
         $totalhp=100+$ibajuhp;
         $tdata=tampilhp(koneksi(),"hp",$selalu,"player");
         if($tdata<$totalhp)
         {
         
         $madadata[$selalu]=$tdata+1;
         $x=updatehp(koneksi(),$selalu,$madadata[$selalu],"player");
         $selalu++;
         $data=tampilhp(koneksi(),"nick",$selalu,"player");
         }
        else 
        {
            $selalu++;
         $data=tampilhp(koneksi(),"nick",$selalu,"player");
        }
          
    }   

    sleep(12);
}

?>
