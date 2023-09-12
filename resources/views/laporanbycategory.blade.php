<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        /* Add your custom styles here */
        table, td, th {
  border: 1px solid;
}

table {
  width: 100%;
  border-collapse: collapse;
}

.container {
  max-width: 60rem;
  display: grid;
  grid-column: 1;
  justify-items: center;
  /* border: 2px solid red; */
  margin: 0 auto;
}

.text-center{
    text-align: center;
}

h1{
    font-size: 30px;
    font-weight: bold;
    text-transform: uppercase
}

h4{
    font-size: 15px;
    font-weight: bold;
    /* text-transform: uppercase */
}

h3{
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase
}
th{
    padding-top:0.5rem;
    padding-bottom: 0.5rem;
    padding-right: 0.75rem;
    padding-left: 0.75rem;
    font-size: 14px;
    text-transform: uppercase
}

td{
    text-align: center;
    font-size: 12px;
    padding-top: 9px;
    padding-bottom: 9px;
}

    </style>
    <?php
        $date = \Carbon\Carbon::parse($tanggal_start)->locale('id');
        $date->settings(['formatFunction' => 'translatedFormat']);
    ?>
    <title>Laporan Penjualan Bulan {{ $date->format("F")}} tahun {{ $date->format("Y") }}</title> 
</head>
<body>
    <div class="container">
        <div class="text-center">
            <h1 style="margin-top:18px">
                VAMPIRE KINGDOM
            </h1>
            <h4 class="">
                Office : RT 7 Karangsemut trimulyo jetis bantul yogyakarta indonesia
            </h4>
        </div>
        <div class="">
            <h3 class="text-center" style="margin-bottom:20px;">
                Laporan Penjualan Bulan {{ $date->format("F")}} tahun {{ $date->format("Y") }}
            </h3>
            <div class="">
                <table class="">
                         
                    <tr class="">
                      <th scope="col" class="">KATEGORI</th>
                      <th scope="col" class="">QTY</th>
                      <th scope="col" class="">MODAL</th>
                      <th scope="col" class="">LABA KOTOR</th>
                      <th scope="col" class="">LABA BERSIH</th>
                    </tr>
                  
                    
                    <?php
                        $data_laporan = json_decode($laporan, true);
                        $kategoriData = [];

                        foreach ($data_laporan as $item) {
                            $kategori = $item['nama_category'];

                            if (isset($kategoriData[$kategori])) {
                                $kategoriData[$kategori]['jumlah'] += $item["jumlah"];
                                $kategoriData[$kategori]["laba_kotor"] += $item["jumlah"] * $item["harga_jual"];
                                $kategoriData[$kategori]["modal"] += $item["jumlah"] * $item["harga_modal"];
                                $kategoriData[$kategori]["laba_bersih"] +=  $kategoriData[$kategori]["laba_kotor"] -  $kategoriData[$kategori]["modal"];
                            } else {
                                $kategoriData[$kategori] = [
                                    "jumlah"=>$item['jumlah'],
                                    "laba_kotor"=>$item["jumlah"] * $item["harga_jual"],
                                    "modal"=>$item["jumlah"] * $item["harga_modal"],
                                    "laba_bersih"=> $item["harga_jual"] - $item["harga_modal"],
                                ];
                            }
                        }

                        // $total_qty = 0;
                        $total_laba_bersih = 0;
                    ?>
                    <?php foreach ($kategoriData as $kategori => $item): ?>
                        <tr class="">
                            <td class=""><?= $kategori ?></td>
                            <td class=""><?= $item["jumlah"] ?></td>
                            <td class="">Rp <?= number_format($item['modal'], 2, ',', '.') ?></td>
                            <td class="">Rp <?= number_format($item['laba_kotor'], 2, ',', '.') ?></td>
                            <td class="">Rp <?= number_format($item['laba_bersih'], 2, ',', '.') ?></td>
                        </tr>
                        
                        @php
                            $total_laba_bersih += $item['laba_bersih']
                        @endphp

                    <?php endforeach; ?>
      
                        <tr>
                            <td colspan="4"><strong>Total</strong></td>
                            <td><strong>Rp <?= number_format($total_laba_bersih, 2, ',', '.') ?></strong></td>
                        </tr>
                  </tbody>
                </table>
              </div>
              
        </div>
    </div>
</body>
</html>
