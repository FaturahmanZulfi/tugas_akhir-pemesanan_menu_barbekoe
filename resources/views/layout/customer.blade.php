<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Barbekoe Coffee And Resto</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <style>
      .swal2-container {
        z-index: 10600 !important; /* Ensure it has the highest z-index */
      }
    </style>
    <script src="/assets/vendor/js/helpers.js"></script>
    <script src="/assets/js/config.js"></script>
  </head>
  @if(ISSET($home))
    <body style="background-color:#fff">
  @else
    <body>
  @endif
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
      <div class="layout-container">
        <div class="layout-page">
            <nav
              class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
              id="layout-navbar"
            >
            <span class="app-brand-text fs-4 menu-text fw-bolder mt-1"><a style="text-decoration:none;color:#6d7d90" href="/">BARBEKOE</a></span>
              <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                  <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    @if(ISSET($home))
                      <a href="/login" class="btn btn-dark col-12">Login</a>
                    @else
                      <a class="nav-link" href="/pesanan-saya"  style="font-size: 30px">
                        <i class="bx bx-notepad bx-tada-hover fs-4 lh-0"></i>
                      </a>
                    @endif
                  </li>
                </ul>
              </div>
            </nav>
            <div class="content-wrapper">
              <div class="container-xxl flex-grow-1 container-p-y">
                @yield('content')
              </div>
            <footer class="footer bg-light">
                <div
                  class="container-fluid d-flex flex-md-row flex-column justify-content-between align-items-md-center gap-1 container-p-x py-3"
                >
                  <div>
                    Template By <a href="https://themeselection.com/">ThemeSelection</a>
                  </div>
                </div>
              </footer>
              <div class="content-backdrop fade"></div>
            </div>
          </div>
      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    
    <script src="/assets/vendor/js/menu.js"></script>
    <script src="/assets/vendor/sweet-alert/sweetalert2.all.min.js"></script>
    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>
    <script>
      
      window.addEventListener('sweetalert', (event) => {
        let alert = event.detail;

        const Toast = Swal.mixin({
          toast: true,
          position: alert.position,
          showConfirmButton: false,
          timer: 2000,
          background: '#fff',
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });

        Toast.fire({
          icon: alert.icon,
          title: alert.title
        });
      })

      window.addEventListener('closeoffcanvas', (event) => {
        let offcanvasid = event.detail.offcanvas;
        var offcanvasElement = document.getElementById(offcanvasid);
        var offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasElement);
        if (offcanvasInstance) {
            offcanvasInstance.hide();
        }
      })
    </script>
    @yield('scripts')
  </body>
</html>