@extends('layouts.master')

@section('content')
    <h1>Manufacturers</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Manufacturer Name</th>
                <th>Average Rating</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach ($manufacturers as $manufacturer)
        <tr>
            <td><a href="{{ url('/manufacturer/' . $manufacturer->id) }}">{{ $manufacturer->name }}</a></td>
            <td>{{ round($manufacturer->average_rating, 2) ?? 'No ratings' }}</td>
        </tr>
        @endforeach

        </tbody>
    </table>
@endsection
