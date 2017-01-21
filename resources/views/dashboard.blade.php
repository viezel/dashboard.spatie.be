@extends('layouts/master')

@section('content')

    @javascript(compact('pusherKey', 'initialState'))

    <div class="dashboard" id="dashboard">
        <twitter
                grid="a1:a3"
                initial-state="{{ $initialState['twitter'] }}"
        ></twitter>

        <google-calendar
                grid="b1:b2"
                initial-state="{{ $initialState['googleCalendar'] }}"
        ></google-calendar>

        <rain-forecast
                grid="b3"
                initial-state="{{ $initialState['rainForecast'] }}"
        ></rain-forecast>

        <github-file
                grid="c1"
                file-name="freek"
                initial-state="{{ $initialState['githubFile'] }}"
        ></github-file>

        <github-file
                grid="d1"
                file-name="seb"
                initial-state="{{ $initialState['githubFile'] }}"
        ></github-file>

        <github-file
                grid="c2"
                file-name="rogier"
                initial-state="{{ $initialState['githubFile'] }}"
        ></github-file>

        <github-file
                grid="d2"
                file-name="willem"
                initial-state="{{ $initialState['githubFile'] }}"
        ></github-file>

        <internet-connection grid="c3"></internet-connection>

        <last-fm
                grid="d3:e3"
                initial-state="{{ $initialState['lastFm'] }}"
        ></last-fm>

        <current-time grid="e1" dateformat="ddd DD/MM"></current-time>

        <packagist-statistics
                grid="e2"
                initial-state="{{ $initialState['lastFm'] }}"
        ></packagist-statistics>
    </div>

@endsection
