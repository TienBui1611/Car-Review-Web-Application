@extends('layouts.master')

@section('content')
    <h1>Cars from {{ $manufacturer->name }}</h1>

    <table>
        <thead>
            <tr>
                <th>Car Name</th>
                <th>Model</th>
                <th>Year</th>
                <th>Type</th>
                <th>Average Rating</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cars as $car)
                <tr>
                    <td><a href="{{ url('/car/' . $car->id) }}">{{ $car->name }}</a></td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->year }}</td>
                    <td>{{ $car->type }}</td>
                    <td>{{ round($car->avg_rating, 2) ?? 'No ratings' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <a href="{{ url('/manufacturers') }}">Back to Manufacturers</a>
@endsection
