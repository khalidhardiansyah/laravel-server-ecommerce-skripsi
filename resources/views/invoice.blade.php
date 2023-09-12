<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    <div class="mx-auto px-4">
        <div class="border-2 border-slate-300 mt-10 py-5 px-8">
            <div class="text-center mb-4 ">
                <h1 class="text-2xl font-bold">Vampire Kingdom</h1>
            </div>
            <div class="flex flex-row flex-nowrap justify-between">
                <div >
                    <h2 class="text-lg font-semibold mb-2">PELANGGAN</h2>
                    <table style="font-size: 12px">
                        <tr class="pr-4">
                            <td class="uppercase">Nama Pelanggan</td>
                            <td>:</td>
                            <td>{{ $invoice->user->name }}</td>
                        </tr>
                        <tr class="pr-4">
                            <td class="uppercase">Hp Pelanggan</td>
                            <td>:</td>
                            <td>{{ $invoice->user->no_hp }}</td>
                        </tr>
                        <tr>
                            <td class="uppercase">Alamat</td>
                            <td>:</td>
                            <td class="lowercase">{{ $invoice->user->alamat[0]['kelurahan']['name'] }}, {{ $invoice->user->alamat[0]['kecamatan']['name'] }}, {{ $invoice->user->alamat[0]['kabupaten']['name'] }}, {{ $invoice->user->alamat[0]['provinsi']['name'] }}, {{ $invoice->user->alamat[0]['kode_pos']}}</td>
                        </tr>
                        <tr>
                            <td class="uppercase">
                                Alamat Detail
                            </td>
                            <td>
                                :
                            </td>
                        <td>{{ $invoice->user->alamat[0]->alamat_detail }}</td>

                        </tr>
                    </table>
                </div>
                
               <div class="order">
                   <h2 class="text-lg font-semibold mb-2">ORDER</h2>
                <table style="font-size: 12px">
                    <tr>
                        <td>ORDER ID</td>
                        <td>:</td>

                    <td>{{ $invoice->order_number }}</td>
                    </tr>
                    <tr>
                        <td>TANGGAL</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>STATUS</td>
                        <td>:</td>
                        <td>{{ $invoice->payment->status }}</td>

                    </tr>
                </table>
               </div>
            </div>
            <div class="mb-8 mt-5">
                <table class="w-full border">
                    <thead style="font-size: 13px">
    
                        <tr >
                            <th class="border px-2 py-1">No.</th>
                            <th class="border px-2 py-1">Produk</th>
                            <th class="border px-2 py-1">Qty</th>
                            <th class="border px-2 py-1">Harga</th>
                            <th class="border px-2 py-1">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
    
                        @php
                            $index = 1;
                            $total = 0;
                        @endphp
    
                        @foreach ($invoice->transaksiDetail as $item)
                        <tr style="font-size: 11px">
                            <td class="border px-2 py-1">{{ $index++ }}</td>
                            <td class="border px-2 py-1">{{ $item->product->nama_barang }} 
                            @if ($item->stock->size !== 'null')
                            {{ $item->stock->size }}
                            @else
                            
                            @endif
                            </td>
                            <td class="border px-2 py-1">{{ $item->jumlah }}</td>
                            <td class="border px-2 py-1">Rp {{ number_format($item->product->harga_jual, 2, ',', '.') }} </td>
                            <td class="border px-2 py-1">
                                Rp {{ number_format($item->product->harga_jual * $item->jumlah, 2, ',', '.') }}
                          
    
                            @php
                                $total +=$item->product->harga_jual* $item->jumlah
                            @endphp
                        </tr>
                        @endforeach
                  
                        <!-- Tambahkan baris lain sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
            <div  style="display: flex;">
                <table style="margin-left: auto;">
                        <tr>
                            <td>Total</td>
                            <td>:</td>
                            <td>Rp {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>

                        <tr>
                            <td>Biaya Pengiriman</td>
                            <td>:</td>
                            <td>Rp {{ number_format($invoice->biaya_pengiriman, 2, ',', '.') }}</td>
                        </tr>

                        <tr>
                            <td>Biaya yang harus dibayar</td>
                            <td>:</td>
                            <td class="font-semi-bold">Rp {{ number_format($invoice->payment->total_pembayaran, 2, ',', '.') }}</td>
                        </tr>

                    </table>
            </div>
        </div>
    </div>
</body>
</html>
