@extends('layouts.master')

@section('title', 'Customers List')

@section('content')
<div class="container">
    <h1>Customers List</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Credit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>${{ $customer->credit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection