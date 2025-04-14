@extends('layouts.master')

@section('content')
    <h1>Edit Review for {{ $car->name }}</h1>
    
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
    
    <form action="{{ url('/update-review') }}" method="POST" class="review-form">
        {{ csrf_field() }} <!-- CSRF Token Field -->

        <input type="hidden" name="review_id" value="{{ $review->id }}">

        <label for="reviewer_name">Reviewer Name:</label>
        <input type="text" id="reviewer_name" name="reviewer_name" value="{{ $review->reviewer_name }}" class="form-input" required><br>

        <label for="rating">Rating (1-5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" value="{{ $review->rating }}" class="form-input" required><br>

        <label for="review_text">Review Text:</label>
        <textarea id="review_text" name="review_text" rows="5" class="form-input" required>{{ $review->review_text }}</textarea><br>

        <input type="submit" value="Update Review" class="btn">
    </form>
    <br>
    <a href="{{ url('/car/' . $car->id) }}">Back to Car Details</a>
@endsection
