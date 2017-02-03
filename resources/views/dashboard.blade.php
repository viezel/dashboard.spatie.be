@extends('layouts/master')

@section('content')

    @javascript(compact('pusherKey', 'pusherCluster', 'usingNodeServer'))

    <div class="dashboard" id="dashboard">
        <twitter initial-tweets="{{ json_encode($initialTweets) }}" grid="a1:a3"></twitter>
        <git-lab-builds grid="b1:b2"></git-lab-builds>
        <rain-forecast grid="b3"></rain-forecast>
        <github-file file-name="freek" grid="c1"></github-file>
        <github-file file-name="rogier" grid="c2"></github-file>
        <internet-connection grid="c3"></internet-connection>
        <new-relic-server grid="d1:d3"></new-relic-server>
        <last-fm grid="e3"></last-fm>
        <current-time grid="e1" dateformat="ddd DD/MM"></current-time>
        <packagist-statistics grid="e2"></packagist-statistics>
        <wunderlist-tasks grid="f1:f2"></wunderlist-tasks>

    </div>

@endsection
