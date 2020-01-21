@extends('layouts.pascal')

@section('title', 'Stats - Pascal Sommer')

@section('content')

<h1>Stats</h1>

<table class="inline-block">
    @foreach($stats as $statname => $statval)
        <tr>
            <td style="text-align: right">
                {{ $statname . (trim($statname) !== '' ? ':' : '') }}
            </td>
            <td>&nbsp;&nbsp;</td>
            <td style="text-align: right">
                {{ $statval }}
            </td>
        </tr>
    @endforeach
</table>

@endsection
