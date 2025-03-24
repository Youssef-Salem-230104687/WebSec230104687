@extends('layouts.master')

@section('title', 'My Purchases')

@section('content')
<div class="container">
    <h1>My Purchases</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->product->name }}</td>
                    <td>${{ $purchase->price }}</td>
                    <td>{{ $purchase->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection