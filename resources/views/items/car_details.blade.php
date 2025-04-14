@extends('layouts.master')

@section('content')
    <h1>{{ $car->name }} Details</h1>
    
    <p><strong>Manufacturer:</strong> {{ $car->manufacturer_name }}</p>
    <p><strong>Model:</strong> {{ $car->model }}</p>
    <p><strong>Year:</strong> {{ $car->year }}</p>
    <p><strong>Type:</strong> {{ $car->type }}</p>

    <h2>Reviews</h2>
    @if ($reviews)
        @foreach ($reviews as $review)
            <div>
                <p><strong>Reviewer:</strong> {{ $review->reviewer_name }}</p>
                <p><strong>Rating:</strong> {{ $review->rating }}</p>
                <p><strong>Date:</strong> {{ $review->date }}</p>
                <p><strong>Review:</strong> {{ $review->review_text }}</p>
                <a href="{{ url('/edit-review/' . $review->id) }}">Edit Review</a>
                <hr>
            </div>
        @endforeach
    @else
        <p>No reviews yet.</p>
    @endif

    <!-- Form to delete the car -->
    <form action="{{ url('/delete-car/' . $car->id) }}" method="POST">
        @csrf
        <button type="submit">Delete Car</button>
    </form>
    
    <h2>Add a Review</h2>

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

    <!-- Show name changed message -->
    @if (session('name_changed_message'))
        <div class="alert alert-info">
            {{ session('name_changed_message') }}
        </div>
    @endif

    <form action="{{ url('/add-review') }}" method="POST" class="review-form">
        {{ csrf_field() }} <!-- CSRF Token Field -->

        <input type="hidden" name="car_id" value="{{ $car->id }}">

        <label for="reviewer_name">Reviewer Name:</label>
        <input type="text" id="reviewer_name" name="reviewer_name" class="form-input" required value="{{ old('reviewer_name', $reviewer_name) }}"><br> <!-- Pre-fill with session value -->

        <label for="rating">Rating (1-5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" class="form-input" required><br>

        <label for="review_text">Review Text:</label>
        <textarea id="review_text" name="review_text" rows="5" class="form-input" required></textarea><br>

        <input type="submit" value="Add Review" class="btn">
    </form>
    <br>
    <a href="{{ url('/') }}">Back to Home</a>
@endsection
