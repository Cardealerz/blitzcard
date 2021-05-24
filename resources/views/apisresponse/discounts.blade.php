@extends('layouts.app')

@section('content')


<div class="container">
    <h1>Descuentos de productos (Grupo 7) </h1>

    <div class="row">

            @if(count($discounts->products) > 0)
                @foreach($discounts->products as $product)
                    <div class="col-sm-3 m-1">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $product->category }} - {{ $product->manufacturer }}</h6>
                            <p class="card-text">{{ $product->description }}</p>
                            <h6>Quantity: <span class="badge badge-primary">{{ $product->quantity }}</span></h6>
                            <h6>Price: <span class="badge badge-secondary">{{ $product->price }}</span></h6>
                            <h6>Discount: <span class="badge badge-success">{{ $product->discount }}</span></h6>
                            </div>
                        </div>
                    </div>
                @endforeach    
            @else
                <div class="col-sm-12 m-1">
                    <div class="card">
                        <div class="card-body">
                            No hay productos con descuento
                        </div>
                    </div>
                </div>
            @endif
        
           
        
    </div>

</div>
@endsection