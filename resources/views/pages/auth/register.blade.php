@extends('layout.auth')
@section('title', 'Register')

@section('custom-css')

@endsection

@section('content')
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header py-4 text-center bg-secondary">
                            <a href="{{ url('/') }}">
                                <span><img src="assets/images/logo.png" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Register</h4>
                            </div>

                            <form action="#">

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input class="form-control" type="email" id="name" required="" placeholder="Enter your name">
                                    <p class="error-message text-danger" id="name-error"></p>
                                </div>

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email</label>
                                    <input class="form-control" type="email" id="email" required="" placeholder="Enter your email">
                                    <p class="error-message text-danger" id="email-error"></p>
                                </div>

                                <div class="mb-3">
                                    {{-- <a href="pages-recoverpw.html" class="text-muted float-end"><small>Forgot your password?</small></a> --}}
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                    <p class="error-message text-danger" id="password-error"></p>
                                </div>

                                <div class="d-grid text-center">
                                    <button id="signin" class="btn btn-primary" type="button" onclick="signIn(this.id)">
                                        <span id="title">Sign Up</span>
                                        <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>
                                    </button>
                                </div>

                                <!-- end d-grid -->
                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <p class="text-muted pb-sm-0">Already have account?  <a href="/login" class="text-muted ms-1"><b>Sign Up</b></a></p>
                                    </div>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->


                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection

@section('custom-js')
    <script>
        $(document).ready(() => {
            $('#spinner').hide()
        })

        async function signIn(id) {
            const button = $(`#${id}`);
            const email = $('#email').val().trim();
            const password = $('#password').val();
            const titleSpan = $(`#${id} span#title`);
            const spinner = $(`#${id} span#spinner`);

            titleSpan.text('');
            spinner.show();

            setTimeout(function () {
                button.prop('disabled', false);
                titleSpan.text('Log In');
                spinner.hide();
            }, 3000);
        }
    </script>
@endsection
