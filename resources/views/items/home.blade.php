@extends('layouts.master')

@section('content')
    <h1>Cars List</h1>

    <!-- Sorting Form -->
    <form method="GET" action="{{ url('/') }}" class="sorting-form">
        <label for="sort_by">Sort by:</label>
        <select name="sort_by" id="sort_by">
            <option value="review_count" {{ $sortBy == 'review_count' ? 'selected' : '' }}>Number of Reviews</option>
            <option value="average_rating" {{ $sortBy == 'average_rating' ? 'selected' : '' }}>Average Rating</option>
        </select>

        <label for="sort_order">Order:</label>
        <select name="sort_order" id="sort_order">
            <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Ascending</option>
            <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Descending</option>
        </select>

        <button type="submit" class="btn btn-primary">Sort</button>
    </form>

    <!-- Car List -->
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Manufacturer</th>
                <th>Model</th>
                <th>Year</th>
                <th>Type</th> <!-- Add a new column for Type -->
                <th>Number of Reviews</th>
                <th>Average Rating</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cars as $car)
                <tr>
                    <td><a href="{{ url('/car/' . $car->id) }}">{{ $car->name }}</a></td>
                    <td>{{ $car->manufacturer }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->year }}</td>
                    <td>{{ $car->type }}</td> <!-- Display the car type -->
                    <td>{{ $car->review_count }}</td>
                    <td>{{ round($car->average_rating, 2) ?? 'No ratings' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <strong><a href="{{ url('/add-car') }}">Add Car</a><strong>
@endsection
