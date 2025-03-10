@extends('layouts.master')
@section('title', 'Bill Page')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>{{ $bill->supermarket }} - POS #{{ $bill->pos }}</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price (per unit)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bill->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>${{ number_format($product->quantity * $product->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-info">
                        <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                        <td><strong>${{ number_format(array_reduce($bill->products, function($carry, $product) {
                            return $carry + ($product->quantity * $product->price);
                        }, 0), 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection