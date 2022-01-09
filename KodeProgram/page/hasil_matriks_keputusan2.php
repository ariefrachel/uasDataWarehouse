<?php
$cookiePilih=@$_COOKIE['pilih'];

if (isset($cookiePilih) && !empty($cookiePilih)){

    $valueMinMax=array(); $kriteriaArray=array(); $supplierArray=array(); $forminmax=array(); $simpanNormalisasi=array(); $bobotArray=array();
    $querykriteria="SELECT namaKriteria FROM kriteria";
    $queryAlternative="SELECT customerdim.namaCustomer AS namaCustomer,id_customer FROM nilai_customer INNER JOIN customerdim ON customerdim.id = nilai_customer.id_customer WHERE id_produk='$cookiePilih' GROUP BY id_customer ";
    $queryBobot="SELECT id_kriteria,bobot FROM bobot_kriteria WHERE id_produk='$cookiePilih'";

    $indexArray=0;
    $executeBobot=$konek->query($queryBobot);
    if ($executeBobot->num_rows>0) {
        while ($dataBobot=$executeBobot->fetch_array(MYSQLI_ASSOC)) {
            $bobotArray[$dataBobot['id_kriteria']]=@$dataBobot['bobot'];
        }
    }

$executeQueryTabel=$konek->query( $querykriteria);
echo "<div class='panel-middle'>";
echo "<p><b>Matriks Keputusan</b></p><table><tr><th rowspan='2'>Alternative</th><th colspan='$executeQueryTabel->num_rows'>Kriteria</th></tr><tr>";
while ($data=$executeQueryTabel->fetch_array(MYSQLI_ASSOC)){
    echo "<th>$data[namaKriteria]</th>";
    array_push($kriteriaArray,$data['namaKriteria']);
}
echo "</tr>";

$executeGetAlternative=$konek->query($queryAlternative);
$colspan=$executeQueryTabel->num_rows+1;
if ($executeGetAlternative->num_rows > 0){
    while ($dataAlternative=$executeGetAlternative->fetch_array(MYSQLI_ASSOC)){
        echo"<tr id=\"data\"><td>$dataAlternative[namaCustomer]</td>";
        $queryGetNilai="SELECT nilai_kriteria.nilai AS nilai,kriteria.sifat AS sifat,nilai_customer.id_kriteria AS id_kriteria FROM nilai_customer JOIN kriteria ON kriteria.id_kriteria=nilai_customer.id_customer JOIN nilai_kriteria ON nilai_kriteria.id_nilaikriteria=nilai_customer.id_nilaikriteria WHERE (id_produk='$cookiePilih' AND id_customer='$dataAlternative[id_customer]')";
        $executeNilai=$konek->query($queryGetNilai);
        $i=0;
        while ($dataNilai=$executeNilai->fetch_array(MYSQLI_ASSOC)){
            echo "<td>$dataNilai[nilai]</td>";
            $nilaiSupplier[$indexArray][$i]=array("sifat"=>$dataNilai['sifat'],"id_kriteria"=>$dataNilai['id_kriteria']);
            $forminmax[$dataNilai['id_kriteria']][$indexArray]=$dataNilai['nilai'];
            $i++;
        }
            echo "</tr>";
            $supplierArray[$indexArray]=["namaCustomer"=>$dataAlternative['namaCustomer'],"id_customer"=>$dataAlternative['id_customer']];
            $indexArray++;
    }
}else{
    echo "<tr class='text-center'><td colspan=\"$colspan\">Data Kosong</td></tr>";
}
echo "</table>";

echo "<p><b>Normalisasi Matriks Keputusan</b></p><table><tr><th rowspan='2'>Alternative</th><th colspan='$executeQueryTabel->num_rows'>Kriteria</th></tr><tr>";
foreach ($kriteriaArray as $namaKriteria) {
    echo "<th>$namaKriteria</th>";
}
echo "</tr>";

if (!empty($supplierArray)){
    $simpanrangking=array();
    if (!empty($bobotArray)) {
        for ($j=0; $j< count($supplierArray); $j++) { 
            echo "<tr id=\"data\"><td>".$supplierArray[$j]['namaCustomer']."</td>";
                for ($k=0; $k<count($nilaiSupplier[$j]) ; $k++) {
                    $idKriteria=$nilaiSupplier[$j][$k]['id_kriteria'];
                    echo "<td>".$hasil=normalisasi($forminmax[$idKriteria][$j],$forminmax[$idKriteria],$nilaiSupplier[$j][$k]["sifat"])."</td>";
                    $simpanrangking[$j][$k]=floatval($hasil)*$bobotArray[$idKriteria];
                }
            echo"</tr>";
        }
    }else{
        echo "<tr class='text-center'><td colspan=\"$colspan\"><b>Bobot Kriteria tidak boleh kosong</b></td></tr>";
    }
}else{
    echo "<tr class='text-center'><td colspan=\"$colspan\">Data Kosong</td></tr>";
}
echo "</table>";

echo "<p><b>Normalisasi Matriks Keputusan</b></p> <table> <tr><th rowspan='2'>Alternative</th><th colspan='$executeQueryTabel->num_rows'>Kriteria</th><th rowspan='2'>Hasil</th></tr><tr>";
foreach ($kriteriaArray as $namaKriteria) {
    echo "<th>$namaKriteria</th>";
}
echo "</tr>";

if (!empty($supplierArray)){
    if (!empty($bobotArray)) {
        for ($j=0; $j< count($supplierArray); $j++) {
            $hasilakhir=0;
            echo "<tr id=\"data\"><td>".$supplierArray[$j]['namaCustomer']."</td>";
                for ($k=0; $k<count($simpanrangking[$j]) ; $k++) {
                    echo "<td>".$hasil=$simpanrangking[$j][$k]."</td>";
                    $hasilakhir+=floatval($hasil);
                }
                    echo "<td>".round($hasilakhir,3)."</td>";
            echo"</tr>";
        }
    }else{
        echo "<tr class='text-center'><td colspan=\"$colspan\"><b>Bobot Kriteria tidak boleh kosong</b></td></tr>";
    }
}else{
    echo "<tr class='text-center'><td colspan=\"$colspan\">Data Kosong</td></tr>";
}
echo "</table>";
    $queryHasil="SELECT hasil.hasil AS hasil,productdim.namaProduk,customerdim.namaCustomer AS namaCustomer FROM hasil JOIN productdim ON productdim.id=hasil.id_produk JOIN customer ON customerdim.id=hasil.id_customer WHERE hasil.hasil=(SELECT MAX(hasil) FROM hasil WHERE id_produk='$cookiePilih')";
    $execute=$konek->query($queryHasil)->fetch_array(MYSQLI_ASSOC);
    echo "<p>Jadi rekomendasi <i>$execute[namaProduk]</i> jatuh pada <i>$execute[namaCustomer]</i> dengan Nilai <b>".round($execute['hasil'],3)."</b></p>";
echo "</div>";
}