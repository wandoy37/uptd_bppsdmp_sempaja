<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('atlantis') }}/img/icon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('atlantis') }}/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset('atlantis') }}/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('atlantis') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('atlantis') }}/css/atlantis.css">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <h3 class="text-center">Login</h3>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="login-form">
                    <div class="form-group form-floating-label">
                        <input name="email" type="email" class="form-control input-border-bottom" required>
                        <label class="placeholder">Email</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input name="password" type="password" class="form-control input-border-bottom" required>
                        <label class="placeholder">Password</label>
                        <div class="show-password">
                            <i class="icon-eye"></i>
                        </div>
                    </div>
                    <div class="row form-sub m-0">
                        <a href="#" class="link float-right">Lupa password ?</a>
                    </div>
                    <div class="form-action mb-3">
                        <button class="btn btn-success btn-rounded btn-login" type="submit">Login</button>
                    </div>
                    <div class="login-account">
                        <a href="#" class="link">Kembali ke beranda</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('atlantis') }}/js/core/jquery.3.2.1.min.js"></script>
    <script src="{{ asset('atlantis') }}/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="{{ asset('atlantis') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('atlantis') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('atlantis') }}/js/atlantis.min.js"></script>
</body>

</html>
