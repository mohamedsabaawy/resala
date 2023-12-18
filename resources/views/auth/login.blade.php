<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>رسالة</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">
                </p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="phone" class="form-control" placeholder="phone" required autofocus name="phone" >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    تذكر دخولي
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">تسجيل الدخول</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

{{--                <div class="social-auth-links text-center mb-3">--}}
{{--                    <p>- OR -</p>--}}
{{--                    <a href="#" class="btn btn-block btn-primary">--}}
{{--                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook--}}
{{--                    </a>--}}
{{--                    <a href="#" class="btn btn-block btn-danger">--}}
{{--                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+--}}
{{--                    </a>--}}
{{--                </div>--}}
                <!-- /.social-auth-links -->

                <p class="mb-1 float-right w-100 text-right" >
                    <a href="#">نسيت الباسور</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</x-guest-layout>
