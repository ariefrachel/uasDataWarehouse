<div class="hasil">
    <h2>Hasil</h2>
    <p><b>Pilih List Produk, untuk menampilkan hasil</b></p>
    <div class="panel">
        <div class="panel-top">
            <div style="float:left;width: 300px;">
                <select class="form-custom" name="pilih" id="pilihHasil">
                    <option disabled selected value="">Pilih Nama Produk</option>;
                    <?php
                $query="SELECT*FROM productdim";
                $execute=$konek->query($query);
                if ($execute->num_rows > 0){
                    while ($data=$execute->fetch_array(MYSQLI_ASSOC)){
                        echo "<option value=$data[id]>$data[namaProduk]</option>";
                    }
                }else{
                    echo '<option disabled value="">Tidak ada data</option>';
                }
                ?>
                </select>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="panel-middle">
            <div id="valueHasil">

            </div>
        </div>
        <div class="panel-bottom"></div>
    </div>
</div>