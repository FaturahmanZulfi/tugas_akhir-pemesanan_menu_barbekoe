<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/"
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

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->
    <style>
      /* Custom CSS to ensure SweetAlert is on top */
      .swal2-container {
        z-index: 10600 !important; /* Ensure it has the highest z-index */
      }
    </style>
    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
  </head>

  {{-- <body style="background-color: #adc4f4"> --}}
  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="" class="app-brand-link">
              <span class="app-brand-text menu-text fw-bolder ms-2" style="font-size: 23px">BARBEKOE</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            @if(Auth::user()->level_id == 3 || Auth::user()->level_id == 4 || Auth::user()->level_id == 5)
            <li class="menu-item @if($active == "orders") active @endif">
              <a href="/pesanan" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dish"></i>
                <div>Pesanan</div>
              </a>
            </li>
            @endif

            @if(Auth::user()->level_id == 4 || Auth::user()->level_id == 5)
            <li class="menu-item @if($active == "menus") active @endif">
              <a href="/menu" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div>Menu</div>
              </a>
            </li>
            @endif

            @if(Auth::user()->level_id == 1)
            <li class="menu-item @if($active == "users") active @endif">
              <a href="/user" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>User</div>
              </a>
            </li>
            @endif

            @if(Auth::user()->level_id == 1 || Auth::user()->level_id == 2)
            <li class="menu-item @if($active == "log") active @endif">
              <a href="/log" class="menu-link">
                <i class="menu-icon tf-icons bx bx-id-card"></i>
                <div>Data Log</div>
              </a>
            </li>            

            <li class="menu-item @if($active == "report") active @endif">
              <a href="/laporan" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div>Laporan</div>
              </a>
            </li>
            @endif
           
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                  {{ Auth::user()->username }}
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar">
                      <i class="bx bx-user-circle bx-md me-2"></i>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar">
                              <i class="bx bx-user-circle bx-md me-2"></i>
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ Auth::user()->username }}</span>
                            <small class="text-muted">{{ Auth::user()->level->level }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Users Table -->
              @yield('content')
              <!--/ Users Table -->

            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="footer bg-light">
                  <div
                    class="container-fluid d-flex flex-md-row flex-column justify-content-between align-items-md-center gap-1 container-p-x py-3"
                  >
                    <div>
                      Template By <a href="https://themeselection.com/">ThemeSelection</a>
                    </div>
                    {{-- <div>
                      <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                    </div> --}}
                  </div>
                </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="/assets/vendor/js/menu.js"></script>
    <script src="/assets/vendor/sweet-alert/sweetalert2.all.min.js"></script>
    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/dashboards-analytics.js"></script>
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

      // Swal.fire({
      //   title: "Good job!",
      //   text: "You clicked the button!",
      //   icon: "success"
      // });
    </script>
    <!-- endbuild -->

    <!-- Vendors JS -->


    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    {{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}
  </body>
</html>
