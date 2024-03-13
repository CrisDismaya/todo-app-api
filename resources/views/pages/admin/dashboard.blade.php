@extends('layout.dashboard')
@section('title', 'Dashboard')

@section('custom-css')

@endsection

@section('content')
    <h1>Hello, Admin</h1>

    <button type="button" class="btn btn-outline-secondary" onclick="notif()">Secondary</button> <br>

    <div id="google-maps" style="height: 400px; width: 100%;"></div>
@endsection

@section('custom-js')
    <script>
        var count = 1;
        $(document).ready(function(){

        });

        function notif(){
            var message = `
               <img src="assets/images/logo-dark-sm.png" alt="" class="me-2" height="18">
               This is the sample message. ${ count }
            `;
            showToast('success', message)
            count++
        }
    </script>
@endsection
