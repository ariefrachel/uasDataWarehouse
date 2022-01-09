<?php
require './connect.php';
?>
<div class="bobot">
    <div class="row">
        <div class="col-4">
            <div class="panel">
                <?php
                include 'tambahbobot2.php';
            ?>
            </div>
        </div>
        <div class="col-8">
            <div class="panel">
                <h3>Daftar bobot</h3>
                <div class="panel-middle">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                        $query="SELECT bobot_kriteria.id_produk AS idproductbobot,productdim.namaProduk AS namaProduct FROM bobot_kriteria INNER JOIN productdim WHERE bobot_kriteria.id_produk=productdim.id GROUP BY idproductbobot ORDER BY idproductbobot ASC";
                        $execute=$konek->query($query);
                        if ($execute->num_rows > 0){
                            $no=1;
                            while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                                echo"
                                <tr id='data'>
                                    <td>$no</td>
                                    <td>$data[namaProduct]</td>
                                    <td></tr>";
                                $no++;
                            }
                        }else{
                            echo "<tr><td  class='text-center text-green' colspan='4'><b>Kosong</b></td></tr>";
                        }
                        ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-bottom"></div>
            </div>
        </div>
    </div>
</div>