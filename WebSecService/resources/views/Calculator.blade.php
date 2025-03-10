@extends('layouts.master')

@section('title', 'Calculator')

@section('content')
<div class="card m-4">
    <div class="card-header">Calculator</div>
    <div class="card-body">
        <!-- Calculator Form -->
        <form id="calculatorForm">
            @csrf <!-- CSRF Token for security -->
            <div class="mb-3">
                <label for="num1" class="form-label">Number 1</label>
                <input type="number" class="form-control" id="num1" placeholder="Enter first number" required>
            </div>
            <div class="mb-3">
                <label for="num2" class="form-label">Number 2</label>
                <input type="number" class="form-control" id="num2" placeholder="Enter second number" required>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary m-2" onclick="calculate('add')">Add (+)</button>
                <button type="button" class="btn btn-primary m-2" onclick="calculate('subtract')">Subtract (-)</button>
                <button type="button" class="btn btn-primary m-2" onclick="calculate('multiply')">Multiply (*)</button>
                <button type="button" class="btn btn-primary m-2" onclick="calculate('divide')">Divide (/)</button>
            </div>
        </form>

        <!-- Result Display -->
        <div class="result mt-4">
            <h4 class="text-center">Result: <span id="result"></span></h4>
        </div>
    </div>
</div>

<!-- JavaScript for Calculator -->
<script>
    function calculate(operation) {
        // Get input values
        const num1 = parseFloat(document.getElementById('num1').value);
        const num2 = parseFloat(document.getElementById('num2').value);

        // Check if inputs are valid numbers
        if (isNaN(num1)) {
            alert("Please enter a valid number for Number 1.");
            return;
        }
        if (isNaN(num2)) {
            alert("Please enter a valid number for Number 2.");
            return;
        }

        let result;
        switch (operation) {
            case 'add':
                result = num1 + num2;
                break;
            case 'subtract':
                result = num1 - num2;
                break;
            case 'multiply':
                result = num1 * num2;
                break;
            case 'divide':
                if (num2 === 0) {
                    alert("Cannot divide by zero!");
                    return;
                }
                result = num1 / num2;
                break;
            default:
                result = "Invalid operation";
        }

        // Display the result
        document.getElementById('result').innerText = result;
    }
</script>
@endsection