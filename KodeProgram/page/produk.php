<div class="produk">
    <h2>Daftar Produk</h2>
    <div class="table">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Vendor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        $query="SELECT * FROM productdim";
                        $execute=$konek->query($query);
                        if ($execute->num_rows > 0){
                            $no=1;
                            while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                                echo"
                                <tr id='data'>
                                    <td>$no</td>
                                    <td>$data[kodeProduk]</td>
                                    <td>$data[namaProduk]</td>
                                    <td>$data[vendorProduk]</td>
                                </div></tr>";
                                $no++;
                            }
                        }else{
                            echo "<tr><td  class='text-center text-green' colspan='3'>Kosong</td></tr>";
                        }
                        ?>
            </tbody>
        </table>
    </div>
</div>