<?php
require '../connect.php';
require '../function/crud.php';
if ($_SERVER['REQUEST_METHOD']=='GET') {
    $id=@$_GET['id'];
    $op=@$_GET['op'];
}else if ($_SERVER['REQUEST_METHOD']=='POST'){
    $id=@$_POST['id'];
    $op=@$_POST['op'];
}
$crud=new crud();
switch ($op){
    case 'subkriteria':
    if (!empty($id)) {
        $where="WHERE nilai_kriteria.id_kriteria='$id'";
    }else{
        $where=null;
    }
    $query="SELECT id_nilaikriteria,nilai,keterangan,namaKriteria,id_kriteria FROM nilai_kriteria INNER JOIN kriteria USING (id_kriteria) $where ORDER BY id_kriteria,nilai ASC";
    $execute=$konek ->query($query);
    if ($execute->num_rows > 0){
        $no=1;
        while($data=$execute->fetch_array(MYSQLI_ASSOC)){
            echo"
            <tr id='data'>
                <td>$no</td>
                <td>".$data['namaKriteria']."</td>
                <td>".$data['nilai']."</td>
                <td>".$data['keterangan']."</td>
            </tr>";
            $no++;
        }
    }else{
        echo "<tr><td  class='text-center text-green' colspan='4'><b>Kosong</b></td></tr>";
    }
        break;
    case 'nilai':
        if (!empty($id)) {
            $where="WHERE nilai_customer.id_produk='$id'";
        }else{
            $where=null;
        }
        $query="SELECT id_nilaicustomer,id_customer,customerdim.namaCustomer AS namaCustomer,productdim.id AS id_produk,productdim.namaProduk AS namaProduk FROM nilai_customer INNER JOIN customerdim ON customerdim.id = nilai_customer.id_customer INNER JOIN productdim ON productdim.id = nilai_customer.id_customer $where GROUP BY id_customer ORDER BY id_produk,id_customer ASC";
        $execute=$konek->query($query);
        if ($execute->num_rows > 0){
            $no=1;
            while($data=$execute->fetch_array(MYSQLI_ASSOC)){
               echo"
                <tr id='data'>
                    <td>$no</td>
                    <td>$data[namaProduk]</td>
                    <td>$data[namaCustomer]</td>
                    <td>
                    <div class='norebuttom'>
                    <a class=\"btn btn-green\" href=\"./?page=penilaian&aksi=lihat&a=$data[id_customer]&b=$data[id_produk]\"><i class='fa fa-eye'></i></a>
                    <a class=\"btn btn-light-green\" href=\"./?page=penilaian&aksi=ubah&a=$data[id_customer]&b=$data[id_produk]\"><i class='fa fa-pencil-alt'></i></a>
                    <a class=\"btn btn-yellow\" data-a=\".$data[namaProduk] - $data[namaCustomer]\" id='hapus' href='./proses/proseshapus.php/?op=nilai&id=".$data['id_customer']."'><i class='fa fa-trash-alt'></i></a></td>
                </div></tr>";
                $no++;
            }
        }else{
            echo "<tr><td  class='text-center text-green' colspan='4'><b>Kosong</b></td></tr>";
        }
        break;
}