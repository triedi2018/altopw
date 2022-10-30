<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "key: 92114ef07b2b605ac63e62b05da1bba6"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $provinsi = json_decode($response,true);
}
?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form method="post">
                    <h4>Alamat pengirim</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Provinsi asal</label>
                                <select id="provinsi" name="provinsi" class="form-control"
                                    id="exampleFormControlSelect1">
                                    <option value="">Pilih Provinsi</option>
                                    <?php
                                    if ($provinsi['rajaongkir']['status']['code'] == '200'){
                                        foreach ($provinsi['rajaongkir']['results'] as $pv ){
                                            echo "<option value='$pv[province_id]' ".($pv['province_id'] == $this->input->post('provinsi') ? "selected" : "").
                                            ">$pv[province] </option> ";
                                        }

                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kota asal</label>
                                <select id="kota" name="kota" class="form-control" id="exampleFormControlSelect1">
                                    
                                    <?php 
                                    if (count($_POST)){
                                        $curl = curl_init();

                                        curl_setopt_array($curl, array(
                                        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?&province=".$this->input->post('provinsi'),
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => "",
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 30,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => "GET",
                                        CURLOPT_HTTPHEADER => array(
                                            "key: 92114ef07b2b605ac63e62b05da1bba6"
                                        ),
                                        ));

                                        $response = curl_exec($curl);
                                        $err = curl_error($curl);

                                        curl_close($curl);

                                        if ($err) {
                                        echo "cURL Error #:" . $err;
                                        } else {
                                            $kota = json_decode($response,true);

                                            if ($kota['rajaongkir']['status']['code'] == '200'){
                                                echo "<option value=''>Pilih Kota</option>";
                                                foreach ($kota['rajaongkir']['results'] as $kt){
                                                    echo "<option value='$kt[city_id]' ".($kt['city_id'] == $this->input->post('kota') ? "selected" : "").
                                                    ">$kt[city_name] </option>";
                                                }
                                            }
                                        }
                                    }else{
                                        echo "<option>Pilih Provinsi Dulu</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <h4>Alamat Penerima</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Provinsi penerima</label>
                                <select id="provinsi_penerima" name="provinsi_penerima" class="form-control"
                                    id="exampleFormControlSelect1">
                                    <option value="">Pilih Provinsi Penerima</option>
                                    <?php
                                    if ($provinsi['rajaongkir']['status']['code'] == '200'){
                                        foreach ($provinsi['rajaongkir']['results'] as $pv ){
                                            echo "<option value='$pv[province_id]' ".($pv['province_id'] == $this->input->post('provinsi_penerima') ? "selected" : "")
                                            .">$pv[province] </option> ";
                                        }

                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kota penerima</label>
                                <select id="kota_penerima" name="kota_penerima" class="form-control"
                                    id="exampleFormControlSelect1">
                                    <?php 
                                    if (count($_POST)){
                                        $curl = curl_init();

                                        curl_setopt_array($curl, array(
                                        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?&province=".$this->input->post('provinsi_penerima'),
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => "",
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 30,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => "GET",
                                        CURLOPT_HTTPHEADER => array(
                                            "key: 92114ef07b2b605ac63e62b05da1bba6"
                                        ),
                                        ));

                                        $response = curl_exec($curl);
                                        $err = curl_error($curl);

                                        curl_close($curl);

                                        if ($err) {
                                        echo "cURL Error #:" . $err;
                                        } else {
                                            $kota = json_decode($response,true);

                                            if ($kota['rajaongkir']['status']['code'] == '200'){
                                                echo "<option value=''>Pilih Kota</option>";
                                                foreach ($kota['rajaongkir']['results'] as $kt){
                                                    echo "<option value='$kt[city_id]' ".($kt['city_id'] == $this->input->post('kota_penerima') ? "selected" : "").
                                                    ">$kt[city_name] </option>";
                                                }
                                            }
                                        }
                                    }else{
                                        echo "<option>Pilih Provinsi Dulu</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Ekspedisi</label>
                                <select id="ekspedisi" name="ekspedisi" class="form-control"
                                    id="exampleFormControlSelect1">
                                    <option value="">Pilih Ekspedisi</option>
                                    <?php
                                    $eks = ['jne' => 'JNE','pos' => 'POS','tiki' => 'TIKI'];
                                    foreach ($eks as $key => $value){
                                        echo "<option value='$key' ".($key == $this->input->post('ekspedisi') ? "selected" : "").
                                        ">$value</option> ";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Berat (gram)</label>
                                <input type="text" name="berat" value="<?= $this->input->post('berat') ?>"
                                    class="form-control" id="exampleFormControlInput1" placeholder="gram">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mb-2">Proses</button>
                </form>
<?php if (count($_POST)) : ?>
                <div class="card-deck">
                    <?php
                        $biaya = json_decode($ongkir,true);

                        if ($biaya['rajaongkir']['status']['code'] == '200'){
                            foreach($biaya['rajaongkir']['results'][0]['costs'] as $by){
                                ?>
                    <div class="card">
                        <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                        <div class="card-body">
                            <h5 class="card-title"><?= $by['service'] ?></h5>
                            <p class="card-text"><?= $by['description'] ?></p>
                            <p class="card-text">Rp. <?= number_format($by['cost'][0]['value'],0,',','.' )?></p>
                            <p class="card-text"><small class="text-muted">Estimasi pengiriman <?= $by['cost'][0]['etd'] ?> hari</small></p>
                        </div>
                    </div>
                    <?php
                            }
                        }
endif
                    ?>

                </div>
            </div>


        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script>
    document.getElementById('provinsi').addEventListener('change', function() {

        fetch("<?= base_url('rajaongkir/kota/') ?>" + this.value, {
                method: 'GET',
            })
            .then((response) => response.text())
            .then((data) => {
                console.log(data)
                document.getElementById('kota').innerHTML = data
            })
    })
    document.getElementById('provinsi_penerima').addEventListener('change', function() {

        fetch("<?= base_url('rajaongkir/kota/') ?>" + this.value, {
                method: 'GET',
            })
            .then((response) => response.text())
            .then((data) => {
                console.log(data)
                document.getElementById('kota_penerima').innerHTML = data
            })
    })
    </script>
</body>

</html>