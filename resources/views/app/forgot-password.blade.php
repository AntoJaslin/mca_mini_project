@extends('layouts.app.auth')

@section('content')
<main>

        <!-- Section -->
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center form-bg-image">
                    <p class="text-center"><a href="/user-login" class="d-flex align-items-center justify-content-center">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                        Back to log in
                        </a>
                    </p>
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="signin-inner my-3 my-lg-0 bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                            <h1 class="h3">Forgot your password?</h1>
                            <p class="mb-4">Don't fret! Just type in your email and we will send you a code to reset your password!</p>
                            <form id="forgotPasswordForm" action="#">
                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="email">Your Email</label>
                                    <div class="input-group">
                                        <input type="email" name="user_email" class="form-control" id="email" placeholder="john@company.com" required autofocus>
                                    </div>  
                                </div>
                                <!-- End of Form -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-gray-800">Recover password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
    $('#forgotPasswordForm').validate({ // initialize the plugin
        rules: {
            user_email: {
                required: true,
                email: true
            },
        },
        messages: {
            user_email: {
                required: "This field is required",
                email: "Email ID is invalid"
            },
        },
        errorPlacement: function (error, element) {
            console.log(element);
            error.insertAfter($(element).parent(".input-group"));
        },
    });
});
</script>
@endsection('content')