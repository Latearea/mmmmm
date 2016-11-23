<?php
function koneksi(){
$servername = "127.0.0.1";
$username = "fauzipadlaw";
$password = "";
$database = "c9";


  return $conn = new mysqli($servername, $username, $password, $database);
}


function koneksitas(){
$servername = "127.0.0.1";
$username = "fauzipadlaw";
$password = "";
$database = "tas";

return $conn = new mysqli($servername, $username, $password, $database);

}

function koneksimarket(){
$servername = "127.0.0.1";
$username = "fauzipadlaw";
$password = "";
$database = "market";

return $conn = new mysqli($servername, $username, $password, $database);

}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

  function insertOrUpdate($kon, $sql){
    if ($kon->query($sql) === TRUE) {
      return "sukses bray";
    } else {
      return "Error: " . $sql . "<br>" . $kon->error;
    }
  }

  function read($kon, $sql){
    $result = $kon->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }
    $conn->close();
  }

  function ambilAkhir($grupnama){
    $penghitung="1";
        $urut="1";
        $nada="0";
        $kolom="no";
        while($urut<=10)
        {
        $konten=tampilRules(koneksi(),$kolom,$penghitung,$grupnama);
        if($nada<=$konten)
        {
            $nada=$konten;
        }
        $penghitung++;
        $urut++;
        }

        return $nada;
  }

function ambilmin($grupnama){
    $penghitung="10";
        $urut="10";
        $nada="1";
        $kolom="no";
        while($urut>=0)
        {
        $konten=tampilRules(koneksi(),$kolom,$penghitung,$grupnama);
        if($nada>=$konten&&$konten!=0)
        {
            $nada=$konten;
        }
        $penghitung--;
        $urut--;
        }

        return $nada;
  }



  function updateclan($kon,$nomor, $isi,$grup,$senjata,$baju)
  {
    $sql = "update $grup set clan = '$isi',senjata='$senjata',baju='$baju',hp='100',lokasi='1' where id = '$nomor'";
    insertOrUpdate($kon, $sql);
  }
  
  function updateuse($kon,$nomor,$brg,$senjata,$grup)
  {
    $sql = "update $grup set $brg ='$senjata' where id = '$nomor'";
    insertOrUpdate($kon, $sql);
  }
  
  function updategold($kon,$nomor,$senjata,$grup)
  {
    $sql = "update $grup set gold ='$senjata' where id = '$nomor'";
    insertOrUpdate($kon, $sql);
  }
  
  function updatehp($kon,$nomor,$senjata,$grup)
  {
    $sql = "update $grup set hp ='$senjata' where no = '$nomor'";
    insertOrUpdate($kon, $sql);
  }
  
  function updateusetas($kon,$nomor,$senjata,$grup)
  {
    $sql = "update $grup set nobrg='$senjata' where id = '$nomor'";
    insertOrUpdate($kon, $sql);
  }
  
  function updatetasbeli($kon,$nomor,$senjata,$status,$grup)
  {
    $sql = "update $grup set nobrg='$senjata',status='$status' where id = '$nomor'";
    insertOrUpdate($kon, $sql);
  }
  
  function updatedrop($kon,$nomor,$senjata,$grup)
  {
    $sql = "update $grup set id='$senjata' where id = '$nomor'";
    insertOrUpdate($kon, $sql);
  }
  
  function updatenama($kon,$nomor, $isi,$grup)
  {
    $sql = "update $grup set nick = '$isi',lvl = '1',gold ='300' where id = '$nomor'";
    insertOrUpdate($kon, $sql);
  }

  function bacanama($kon, $kolom,$nomor,$grup)
  {
    $sql="select * from $grup where id like '$nomor'";
    $data = read($kon, $sql);
    return $data["$kolom"];
  }
  
  function bacatas($kon, $kolom,$nomor,$no,$grup)
  {
    $sql="select * from $grup  where (id like '$nomor') and (status like '$no') ";
    $data = read($kon, $sql);
    return $data["$kolom"];
  }
  
  function tampildata($kon, $kolom,$nomor,$grup)
  {
    $sql="select * from $grup where id like '$nomor'";
    $data = read($kon, $sql);
    return $data["$kolom"];
  }
  
  function tampilhp($kon, $kolom,$nomor,$grup)
  {
    $sql="select * from $grup where no like '$nomor'";
    $data = read($kon, $sql);
    return $data["$kolom"];
  }
  
  function menghapus($kon,$id,$grup)
  {
    $sql= "delete from $grup where id='$id'";
    insertOrUpdate($kon, $sql);
  }
  
  function tambahtable($kon,$grup)
  {
    $sql = "CREATE TABLE IF NOT EXISTS $grup (
  no int NOT NULL AUTO_INCREMENT primary key,
  id int NOT NULL  ,
  user text (255) NOT NULL,
  nama text (255) NOT NULL)";
  insertOrUpdate($kon, $sql);
  }
  
  function menambahid($kon,$id,$grup)
  {
    $sql = "INSERT INTO $grup (id ) VALUES ( '$id')";
    insertOrUpdate($kon,$sql);
  }
  
  function menambahtas($kon,$id,$no,$st,$grup)
  {
    $sql = "INSERT INTO $grup (id,nobrg,status ) VALUES ('$id','$no','$st')";
    insertOrUpdate($kon,$sql);
  }
  
  function menghapustable($kon,$grup)
  {
    $sql="DROP TABLE $grup";
    insertOrUpdate($kon,$sql);
  }
 
  function tambahtas($kon,$grup)
  {
    $sql = "CREATE TABLE IF NOT EXISTS $grup (
  id int NOT NULL AUTO_INCREMENT primary key,
  nobrg int NOT NULL  ,
  status int NOT NULL )";
  
    insertOrUpdate($kon, $sql);
  }
  
 ?>
