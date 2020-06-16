
<?php


function ascii_to_dec($str)
{
  for ($i = 0, $j = strlen($str); $i < $j; $i++) {
    $dec_array[] = ord($str[$i]);
  }
  return $dec_array;
}

if(isset($_POST['submit'])){
    $kalimat = htmlentities($_POST['kalimat']);
    $kunci = htmlentities($_POST['chiper']);
} else{
    $kalimat = "aaaaaa";
    $kunci = "bbbbbb";
}

$jumlah_kalimat = count(str_split($kalimat));
$hasil_kalimat = ascii_to_dec($kalimat);
$jumlah_kunci = count(str_split($kunci));

$desimal_ascii_kalimat = '';
foreach($hasil_kalimat as $hkalimat){
	$desimal_ascii_kalimat .=$hkalimat.' ';
}
	
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if($jumlah_kalimat >= $jumlah_kunci){
	$selisih = count($hasil_kalimat) - $jumlah_kunci;
	$kunci .= generateRandomString($selisih);
}else{
	$kunci = substr($kunci,0, $jumlah_kalimat);
}

$hasil_kunci = ascii_to_dec($kunci);
$desimal_ascii_kunci = '';
foreach($hasil_kunci as $hkunci){
	$desimal_ascii_kunci .=$hkunci.' ';
};

$chiper = '';
$proses_enc = '';
$proses_dec = '';
$hasil_enc = '';
$hasil_dec = '';
$desimal_ascii_dekrip = '';
foreach($hasil_kalimat as $index => $huruf){
		$key = $hasil_kunci[$index];
        $enkrip = ($huruf + $key) % 255;
        $dekrip = ($enkrip - $key) % 255;
        $proses_dec .= '('.$enkrip.' - '.$key.') % 255 = '.$dekrip.' ('.htmlentities(chr($dekrip), ENT_QUOTES, 'cp1252').')<br>';
        $chiper .= htmlentities(chr($key), ENT_QUOTES, 'cp1252');
        $hasil_enc .= htmlentities(chr($enkrip), ENT_QUOTES, 'cp1252');
        $hasil_dec .= htmlentities(chr($dekrip), ENT_QUOTES, 'cp1252');
        $desimal_ascii_dekrip .= $dekrip.' ';
		$proses_enc .= htmlentities(chr($huruf), ENT_QUOTES, 'cp1252').' ('.$huruf.') + '.htmlentities(chr($key), ENT_QUOTES, 'cp1252').' ('.$key.') mod 255 = '.$enkrip.' ('.htmlentities(chr($enkrip), ENT_QUOTES, 'cp1252').')<br>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>OTP dengan PHP</title>
</head>
<body>
<div class="container-fluid">
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
  <a class="navbar-brand" href="#">OTP by Saiful Riza</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" target="_blank" href="#">Source <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" target="_blank" href="https://wa.me/089503061976">Contact</a>
      </li>
    </ul>
  </div>
</nav>
</div>

<div class="container d-flex flex-column">
<div class="row">
<div class="col-5 m-1">
            <div class="card text-white bg-primary mb-3" >
                <div class="card-header">Kalimat</div>
                <div class="card-body">
                    <p class="card-text">
                    <form method="post">
                    <label>Kalimat</label>
                    <input type="text" class="form-control mb-1" name="kalimat">
                    <label>Chiper</label>
                    <input type="text" class="form-control" name="chiper">
                    <input type="submit" class="btn btn-success m-1" name="submit" value="Proses">
                    </form>
                    </p>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-5 m-1">
        <div class="card text-white bg-primary mb-3" >
                <div class="card-header">Kalimat</div>
                <div class="card-body">
                    <p class="card-text">
                        kalimat (Pi)= <?=$kalimat?> <br>
                        Chiper (Ki) = <?=$chiper?> <br>
                        Kalimat ke Desimal ASCII = <?=$desimal_ascii_kalimat?><br>
                        Chiper ke Desimal ASCII = <?=$desimal_ascii_kunci?><br>
                        Hasil Dekripsi = <?=$hasil_enc?><br>
                        Hasil Dekripsi ke Desimal ASCII = <?=$desimal_ascii_dekrip?>
                    </p>
                </div>
            </div>
        </div>
        <!-- end col -->
</div>
    <div class="row">
        <div class="col-5 m-1">
            <div class="card text-white bg-primary mb-3" >
                <div class="card-header">Proses Enkripsi Kalimat</div>
                <div class="card-body">
                <div class="card-title">
                Enkripsi = (Pi + Ki) mod 255 
                <br> <i>255 karena jumlah karakter ASCII adalah 255</i>
                </div>
                    <p class="card-text"><?=$proses_enc?></p>
                    <p class="card-text">Hasil Enkripsi = <?=$hasil_enc?></p>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-5 m-1">
            <div class="card text-white bg-primary mb-3" >
                <div class="card-header">Proses Dekripsi Kalimat</div>
                <div class="card-body">
                <div class="card-title">
                Dekripsi =(Pi -Ki) mod 255
                <br> <i>255 karena jumlah karakter ASCII adalah 255</i>
                </div>
                    <p class="card-text"><?=$proses_dec?></p>
                    <p class="card-text">Hasil Dekripsi = <?=$hasil_dec?></p>
                </div>
            </div>
        </div>
        <!-- end col -->
        

    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>