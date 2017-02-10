@extends('layouts/master')

@section('content')

    @javascript(compact('pusherKey', 'pusherCluster', 'usingNodeServer'))

    <div class="dashboard" id="dashboard">
        <zoho-summary-events grid="a1:a2"></zoho-summary-events>
        <zoho-newest-events grid="b1:b2"></zoho-newest-events>
        <zoho-latest-potentials grid="c1:c2"></zoho-latest-potentials>
        <zoho-won-potentials grid="d1:d2"></zoho-won-potentials>

        <current-time grid="d4" dateformat="ddd DD/MM"></current-time>
    </div>

@endsection
