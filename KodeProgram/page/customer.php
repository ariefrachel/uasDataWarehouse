<div class="customer">
    <h2>Daftar Customer</h2>
    <div class="panel-middle">
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Customer</th>
                        <th>No. Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query="SELECT * FROM customerdim";
                        $execute=$konek->query($query);
                        if ($execute->num_rows > 0){
                            $no=1;
                            while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                                echo"
                                <tr id='data'>
                                    <td>$no</td>
                                    <td>$data[namaCustomer]</td>
                                    <td>$data[noTelp]</td>
                                </tr>";
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
</div>