@extends('layouts.app')

@section('content')
    <div id="app">
        <stripe-checkout :course-id="1" course-name="Vue Mastery" course-price="49.99"></stripe-checkout>
    </div>
@endsection

@vite(['resources/js/app.js'])