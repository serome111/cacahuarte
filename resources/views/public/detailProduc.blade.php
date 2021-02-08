@extends('layout')

@section('title','Cacahuarte')

@section('content')

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="{{route('index') }}">Inicio</a></li>
          <li>Detalles del producto</li>
        </ol>
        <h2>Detalles del producto</h2>
      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section class="portfolio-details">
    	<div class="card mb-3 col-md-8 shadow mx-auto">
		  <div class="row g-0 py-2 px-2">
		    <div class="col-md-7">
		      <img src="{{$product->picture}}" alt="{{$product->name}}"
		      style="height: 400px; width: 500px;">
		    </div>
		    <div class="col-md-4">
		      <div class="card-body">
		      	<h1 class="card-text">${{$product->price}} COP</h1>
		        <h5 class="card-title">{{$product->name}}</h5>
		        <p class="card-text">{{$product->description}}</p>
		      </div>
		    </div>
		  </div>
		</div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->


@endsection()