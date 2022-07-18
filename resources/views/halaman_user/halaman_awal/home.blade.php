@extends('master_layouts.halaman_home')

@section('content')
	<aside id="fh5co-hero" class="js-fullheight">
		<div class="flexslider js-fullheight">
			<ul class="slides">
			<li style="background-image:url('{{asset('gambar/brs.jpeg')}}')">
		   		<div class="overlay-gradient"></div>
		   		<div class="container">
		   			<div class="col-md-6 col-md-offset-3 col-md-pull-3 js-fullheight slider-text">
		   				<div class="slider-text-inner">
		   					<div class="desc">
		   						{{-- <span class="price">Rp.{{ number_format($b->harga, 0, '.', '.') }}</span> --}}
		   						<h2>Ayo Belanja</h2>
		   						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod, sed laudantium amet harum eligendi dicta, perferendis dignissimos ex asperiores enim quisquam placeat, adipisci nulla nostrum cum nobis! Laudantium, in voluptates!.</p>
			   					<p><a href="#" class="btn btn-primary btn-outline btn-lg">Purchase Now</a></p>
		   					</div>
		   				</div>
		   			</div>
		   		</div>
		   	</li>
            @php
                $barang = DB::table('barang')
                    ->join('persediaan', 'barang.kode_barang', '=', 'persediaan.kode_barang')
                    ->get();
            @endphp
            @foreach ($barang as $b)
		   	<li style="background-image:url('{{asset('gambar/'. $b->gambar)}}')">
		   		<div class="overlay-gradient"></div>
		   		<div class="container">
		   			<div class="col-md-6 col-md-offset-3 col-md-pull-3 js-fullheight slider-text">
		   				<div class="slider-text-inner">
		   					<div class="desc">
		   						<span class="price">Rp.{{ number_format($b->harga, 0, '.', '.') }}</span>
		   						<h2>{{ $b->nama_barang }}</h2>
		   						<p>{{ $b->deskripsi }}.</p>
			   					<p><a href="{{ route('detail_barang', $b->id_barang) }}" class="btn btn-primary btn-outline btn-lg">Purchase Now</a></p>
		   					</div>
		   				</div>
		   			</div>
		   		</div>
		   	</li>
            @endforeach
		  	</ul>
	  	</div>
	</aside>

	<div id="fh5co-services" class="fh5co-bg-section">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-4 text-center">
					<div class="feature-center animate-box" data-animate-effect="fadeIn">
						<span class="icon">
							<i class="icon-credit-card"></i>
						</span>
						<h3>Credit Card</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove</p>
						<p><a href="#" class="btn btn-primary btn-outline">Learn More</a></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 text-center">
					<div class="feature-center animate-box" data-animate-effect="fadeIn">
						<span class="icon">
							<i class="icon-wallet"></i>
						</span>
						<h3>Save Money</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove</p>
						<p><a href="#" class="btn btn-primary btn-outline">Learn More</a></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 text-center">
					<div class="feature-center animate-box" data-animate-effect="fadeIn">
						<span class="icon">
							<i class="icon-paper-plane"></i>
						</span>
						<h3>Free Delivery</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove</p>
						<p><a href="#" class="btn btn-primary btn-outline">Learn More</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="fh5co-product">
		<div class="container">
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
					<span>Cool Stuff</span>
					<h2>Products.</h2>
					{{-- <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p> --}}
				</div>
			</div>
			<div class="row">
                 @php
                    $barang = DB::table('barang')
                        ->join('persediaan', 'barang.kode_barang', '=', 'persediaan.kode_barang')
                        ->get();
                @endphp
                @foreach ($barang as $b)
				<div class="col-md-4 text-center animate-box">
					<div class="product">
						<div class="product-grid" style="background-image:url('{{asset('gambar/'. $b->gambar)}}')">
							<div class="inner">
								<p>
									<a href="{{ route('detail_barang', $b->id_barang) }}" class="icon"><i class="icon-eye"></i></a>
								</p>
							</div>
						</div>
						<div class="desc">
							<h3><a href="{{ route('detail_barang', $b->id_barang) }}">{{ $b->nama_barang }}</a></h3>
							<span class="price">Rp.{{ number_format($b->harga, 0, '.', '.') }}</span>
						</div>
					</div>
				</div>
                @endforeach
				
			</div>
		</div>
	</div>



  

@endsection
