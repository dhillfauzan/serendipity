<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Coffee & Resto Serendipity</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('template/html/assets/images/favicon.ico') }}">

  <!-- Library / Plugin Css Build -->
  <link rel="stylesheet" href="{{ asset('template/html/assets/css/core/libs.min.css') }}">

  <!-- Hope Ui Design System Css -->
  <link rel="stylesheet" href="{{ asset('template/html/assets/css/hope-ui.min.css?v=5.0.0') }}">

  <!-- Custom Css -->
  <link rel="stylesheet" href="{{ asset('template/html/assets/css/custom.min.css?v=5.0.0') }}">

  <!-- Customizer Css -->
  <link rel="stylesheet" href="{{ asset('template/html/assets/css/customizer.min.css?v=5.0.0') }}">

  <!-- RTL Css -->
  <link rel="stylesheet" href="{{ asset('template/html/assets/css/rtl.min.css?v=5.0.0') }}">
</head>

<body class="" data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">

  <!-- loader Start -->
  <div id="loading">
    <div class="loader simple-loader">
      <div class="loader-body"></div>
    </div>
  </div>
  <!-- loader END -->

  <div class="wrapper">
    <section class="login-content">
      <div class="row m-0 align-items-center bg-white vh-100">

        <div class="col-md-6">
          <div class="row justify-content-center">
            <div class="col-md-10">
              <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                <div class="card-body z-3 px-md-0 px-lg-4">

                  <h2 style="margin-bottom: 50px;" class="text-center">
                    Coffee & Resto Serendipity
                  </h2>

                  <h2 class="mb-2 text-center">Sign In</h2>

                  <form action="{{ route('backend.login') }}" method="post">
                    @csrf

                    <!-- Error Login -->
                    @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      <strong>{{ session('error') }}</strong>
                    </div>
                    @endif

                    <!-- Error Validasi -->
                    @if($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                      @foreach($errors->all() as $error)
                      <div>{{ $error }}</div>
                      @endforeach

                    </div>
                    @endif

                    <!-- Email Field -->
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="text"
                             name="email"
                             id="email"
                             value="{{ old('email') }}"
                             class="form-control @error('email') is-invalid @enderror"
                             placeholder="Masukkan Email">

                      @error('email')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
                      </span>
                      @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password"
                             name="password"
                             id="password"
                             class="form-control @error('password') is-invalid @enderror"
                             placeholder="Masukkan Password">

                      @error('password')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
                      </span>
                      @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary">
                        Login
                      </button>
                    </div>

                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
          <img src="{{ asset('template/html/assets/images/auth/09.jpg') }}"
               class="img-fluid gradient-main animated-scaleX"
               alt="images">
        </div>

      </div>
    </section>
  </div>

  <!-- Library Bundle Script -->
  <script src="{{ asset('template/html/assets/js/core/libs.min.js') }}"></script>

  <!-- External Library Bundle Script -->
  <script src="{{ asset('template/html/assets/js/core/external.min.js') }}"></script>

  <!-- Widgetchart Script -->
  <script src="{{ asset('template/html/assets/js/charts/widgetcharts.js') }}"></script>

  <!-- mapchart Script -->
  <script src="{{ asset('template/html/assets/js/charts/vectore-chart.js') }}"></script>
  <script src="{{ asset('template/html/assets/js/charts/dashboard.js') }}"></script>

  <!-- fslightbox Script -->
  <script src="{{ asset('template/html/assets/js/plugins/fslightbox.js') }}"></script>

  <!-- Settings Script -->
  <script src="{{ asset('template/html/assets/js/plugins/setting.js') }}"></script>

  <!-- Slider-tab Script -->
  <script src="{{ asset('template/html/assets/js/plugins/slider-tabs.js') }}"></script>

  <!-- Form Wizard Script -->
  <script src="{{ asset('template/html/assets/js/plugins/form-wizard.js') }}"></script>

  <!-- App Script -->
  <script src="{{ asset('template/html/assets/js/hope-ui.js') }}" defer></script>

</body>

</html>