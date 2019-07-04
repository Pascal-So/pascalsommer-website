@extends('layouts.pascal')

@section('content')

<h1>Login</h1>

<br>

<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    @include('layouts.errors')
    <br>

    <table class="inline-block">
        <tr>
            <td style="text-align: right">
                <label for="name">Name </label>
            </td>
            <td>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            </td>
        </tr>
        <tr>
            <td style="text-align: right">
                <label for="password">Password </label>
            </td>
            <td>
                <input id="password" type="password" name="password" value="{{ old('password') }}" required>
            </td>
        </tr>

    </table>

    <br><br>

    <button class="btn">Login</button>
</form>

@endsection
