@extends('layouts.master')

@section('content')
    <h1>Add a New Car</h1>

    <!-- Show validation errors -->
    @if (!empty($errors))
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/add-car') }}" method="POST" class="review-form">
        {{ csrf_field() }} <!-- CSRF Token Field -->

        <label for="name">Car Name:</label>
        <input type="text" id="name" name="name" class="form-input" required><br>

        <label for="manufacturer_name">Manufacturer Name:</label>
        <input type="text" id="manufacturer_name" name="manufacturer_name" class="form-input" required><br>

        <label for="model">Model:</label>
        <input type="text" id="model" name="model" class="form-input" required><br>

        <label for="year">Year:</label>
        <input type="number" id="year" name="year" class="form-input" required><br>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" class="form-input" required><br>

        <input type="submit" value="Add Car" class="btn">
    </form>
    <br>
    <a href="{{ url('/') }}">Back to Home</a>
@endsection
