<?php
require '../connect.php';
require '../function/crud.php';
$crud=new crud($konek);

if ($_SERVER['REQUEST_METHOD']=='GET') {
    $id=@$_GET['id'];
    $op=@$_GET['op'];
}else if ($_SERVER['REQUEST_METHOD']=='POST'){
    $id=@$_POST['id'];
    $op=@$_POST['op'];
}
$produk=@$_POST['barang'];
$customer=@$_POST['supplier'];
$kriteria=@$_POST['kriteria'];
$sifat=@$_POST['sifat'];
$nilai=@$_POST['nilai'];
$keterangan=@$_POST['keterangan'];
$bobot=@$_POST['bobot'];
switch ($op){
    case 'barang'://tambah data barang
        $query="INSERT INTO productdim (namaProduk) VALUES ('$produk')";
        $crud->addData($query,$konek);
    break;
    case 'supplier': //tambah data supplier
        $query="INSERT INTO customerdim (namaCustomer) VALUES ('$customer')";
        $crud->addData($query,$konek);
    break;
    case 'kriteria'://tambah data kriteria
        $cek="SELECT namaKriteria FROM kriteria WHERE namaKriteria='$kriteria'";
        $query=null;
        $query="INSERT INTO kriteria (namaKriteria,sifat) VALUES ('$kriteria','$sifat')";
        $crud->multiAddData($cek,$query,$konek);
    break;
    case 'subkriteria'://tambah data sub kriteria
        $cek="SELECT id_nilaikriteria FROM nilai_kriteria WHERE (id_kriteria='$kriteria' AND nilai ='$nilai') OR (id_kriteria='$kriteria' AND keterangan = '$keterangan')";
        $query=null;
        $query.="INSERT INTO nilai_kriteria (id_kriteria,nilai,keterangan) VALUES ('$kriteria','$nilai','$keterangan');";
        $crud->multiAddData($cek,$query,$konek);
    break;
    case 'bobot'://tambah data bobot
        $cek="SELECT id_bobotkriteria FROM bobot_kriteria WHERE id_produk='$produk'";
        $query=null;
        for ($i=0;$i<count($kriteria);$i++){
            $query.="INSERT INTO bobot_kriteria (id_produk,id_kriteria,bobot) VALUES ('$produk','$kriteria[$i]','$bobot[$i]');";
        }
        $crud->multiAddData($cek,$query,$konek);
    break;
    case 'nilai'://tambah data nilai
        $cek="SELECT id_customer FROM nilai_customer WHERE id_customer='$customer'";
        $query=null;
        for ($i=0;$i<count($nilai);$i++){
            $query.="INSERT INTO nilai_customer (id_customer,id_produk,id_kriteria,id_nilaikriteria) VALUES ('$customer','$produk','$kriteria[$i]','$nilai[$i]');";
        }
        $crud->multiAddData($cek,$query,$konek);
    break;
}