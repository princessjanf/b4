@extends('layout')

@section('content')
<h1>We are Team B4!</h1>
    <div class="description">
        <h3>Hello there! We are Team B4!</h3>
        <h4>Alvin && Gerald && Adinda && Dwiki && Princess</h4>
    </div>
</div>

@stop

@section('style')
    a:hover:not(.about) {
            color: orange;
        }

    .about {
        background-color: #333333;
        color: #C0C0C0;
    }

    .description{
        padding-left: 10%;
        padding-right: 10%;
    }
@stop