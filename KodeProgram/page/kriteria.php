<div class="kriteria">
    <h2>Kriteria</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Sifat</th>
            </tr>
        </thead>
        <tbody>
            <?php
                        $query="SELECT * FROM kriteria";
                        $execute=$konek->query($query);
                        if ($execute->num_rows > 0){
                            $no=1;
                            while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                                echo"
                                <tr id='data'>
                                    <td>$no</td>
                                    <td>$data[namaKriteria]</td>
                                    <td>$data[sifat]</td>
                                </div></tr>";
                                $no++;
                            }
                        }else{
                            echo "<tr><td  class='text-center text-green' colspan='4'><b>Kosong</b></td></tr>";
                        }
                        ?>
        </tbody>
    </table>
</div>