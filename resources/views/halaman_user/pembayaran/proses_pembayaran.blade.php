@extends('master_layouts.halaman_home')

@section('content')
    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner"
        style="background-image:url('{{ asset('gambar/bg2.jpg') }}'); margin-bottom:100px">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1>Proses Pembayaran</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Submit Ad -->
    <div class="submit-ad main-grid-border">
        <div class="container">
            <h2 class="head">Proses Pembayaran</h2>
            <div class="post-ad-form">
                <table class="table table-bordered">
                    <tr class="text-center">
                        <td>LIST</td>
                        <td>Total Pembayaran</td>
                    </tr>
                    <tr class="text-center">
                        @php
                            $total = 0;
                            $grandtotal = 0;
                        @endphp
                        @foreach ($proses as $p)
                            @php
                                $total = ($p->harga - $p->diskon) * $p->kuantiti;
                                $grandtotal += $total;
                            @endphp
                        @endforeach
                        <td>Total</td>
                        <td id="total_harga">Rp {{ number_format($grandtotal) }}</td>
                    </tr>
                </table>
                <div class="personal-details" style="margin-bottom: 40px">
                    <form action="{{ route('proses_checkout') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="total_akhir" id="total_harga1" value="{{ $grandtotal }}">
                        <div class="clearfix"></div>

                        <div class="clearfix"></div>
                        <label>Alamat Kota <span>*</span></label>
                        <select class="form-control" onchange="pilihKota(this);" name="kota">
                            <option selected value="">Open this select menu</option>
                            @php
                                $array = ['Kota Padang' => '1', 'Luar Kota Padang' => '2'];
                            @endphp
                            @foreach ($array as $a => $value)
                                <option value="{{ $a }}">{{ $a }}</option>
                            @endforeach
                        </select>
                        <div class="clearfix"></div>

                        <label>Pilih Kurir ( Untuk Wilayah Kota Padang Saja) <span>*</span></label>
                        <select id="pilih-kurir" name="id_kurir" class="form-control" onchange="SelectKurir(this.value);">
                            @php
                                $kurir = DB::table('kurir')->get();
                            @endphp
                            {{-- <option data-harga="0" id="kurir_none" value="">Pilih Kurir</option>
                            @foreach ($kurir as $k)
                                <option id="{{ $k->id_kurir }}" data-harga="{{ $k->harga }}" data-kurir="jne"
                                    value="{{ $k->id_kurir }}">
                                    {{ $k->nama_kurir }} ===
                                    {{ number_format($k->harga) }}</option>
                                    @endforeach --}}
                            <option>Pilih Kurir</option>
                        </select>

                        <label for="alamat">Alamat Lengkap <span>*</span></label>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control" placeholder="Alamat Lengkap"></textarea>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <label for="1" class="form-label">Metode Pembayaran</label>
                        <select id="pilih" onchange="cek()" name="tipe_pembayaran" class="form-control">
                            <option selected value="">Pilih Metode Pembayaran</option>
                            <option value="transfer">Transfer</option>
                            <option value="cod">Cash On Delevery</option>
                        </select><br>
                        <div id="hasil"></div>
                        <div class="clearfix"></div>

                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Kirim Bukti Pembayaran</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Nama Akun : BRS Beauty Care</p><br>
                                        <p>Nomor Rekening : 12345678910</p><br>
                                        <p>Kirim Bukti pembayaran</p><br>
                                        <input type="file" name="bukti_pembayaran"><br>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            aria-label="Close">SAVE</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <button type="submit" class="btn btn-success">Chekout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- // Submit Ad -->
    <script>
        function pilihKota(val) {
            console.log(val);
            $.ajax({
                type: 'post',
                url: "{{ route('ajax_kota') }}",
                datatype: 'HTML',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kota": val.value
                },
                success: function(response) {
                    const data = response
                    const pilihKurir = document.getElementById("pilih-kurir")

                    data.forEach(e => {
                        var hargaKurir = e.harga;
                        let optNama = document.createElement('option');
                        optNama.value = e.id_kurir;
                        optNama.innerHTML = `${e.nama_kurir} ---- (${e.harga}) ------ (${e.wilayah})`;
                        pilihKurir.appendChild(optNama);
                    });
                }
            })
        }

        function SelectKurir(id_kurir) {
            $.ajax({
                type: 'post',
                url: "{{ route('ajax_harga') }}",
                datatype: 'HTML',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "idKurir": id_kurir
                },
                success: function(response) {
                    const data = response
                    console.log(response)
                    let total = document.getElementById("total_harga")
                    total = total.innerText
                    console.log(total);
                    total = total.split("Rp")[1].split(",").join("")
                    total = parseInt(total) + data.harga
                    document.getElementById("total_harga").innerText =
                        `Rp.${new Intl.NumberFormat().format(total)}`

                    // untuk kirim ke database

                    let insert = document.getElementById("total_harga1")
                    insert = insert.value
                    insert1 = parseInt(insert) + data.harga
                    document.getElementById("total_harga1").value = insert1
                }
            })
        }
    </script>
    <script>
        function cek() {
            var tes = document.getElementById("pilih").value;
            if (tes == 'transfer') {
                $('#modal-default').modal('show');
            } else {
                document.getElementById("hasil").innerHTML = ("");
            }
        }

        let pilih = document.getElementById("pilih-kurir")
    </script>
@endsection
