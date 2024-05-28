<script setup>
import { Link } from "@inertiajs/vue3";
import { defineComponent, inject } from "vue";

defineComponent({
  Link,
});

const config = inject("$config");
</script>
<template>
  <div class="left-sidebar bg-dark">
    <!-- LOGO -->
    <div class="brand bg-dark border-light">
      <Link href="/administrator/home" class="logo">
        <div class="d-flex align-items-center p-2 justify-content-center">
          <img
            src="http://localhost:8003/paperless-logo.png"
            alt="logo-small"
            class="img-fluid me-3"
            style="width: 2vw"
          />
          <h3 class="fw-bolder text-white text-uppercase" style="letter-spacing: 4.5px">
            Paperless
          </h3>
        </div>
      </Link>
    </div>
    <!--end logo-->
    <div class="menu-content h-100" data-simplebar>
      <div class="menu-body navbar-vertical tab-content">
        <div class="collapse navbar-collapse" id="sidebarCollapse">
          <!-- Navigation -->
          <ul class="navbar-nav">
            <li class="menu-label mt-0">M<span>ain</span></li>

            <li class="nav-item">
              <Link href="/administrator/home" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-speedometer"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z"
                    />
                    <path
                      fill-rule="evenodd"
                      d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0"
                    />
                  </svg>
                </div>
                <span class="mx-2">Dashboard</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link href="/administrator/legislation" method="get" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-journal-bookmark-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"
                    />
                    <path
                      d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"
                    />
                    <path
                      d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"
                    />
                  </svg>
                </div>
                <span class="mx-2">Legislation</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link href="/sanggunian-members" method="get" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-people-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"
                    />
                  </svg>
                </div>
                <span class="mx-2">Sanggunian Members</span>
              </Link>
            </li>
            <li class="menu-label mt-0">M<span>aintenance</span></li>
            <li class="nav-item">
              <Link href="/schedules" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-calendar-check-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708"
                    />
                  </svg>
                </div>
                <span class="mx-2">Schedules</span>
              </Link>
            </li>

            <li class="nav-item">
              <Link href="/committee" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-file-earmark-check-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"
                    />
                  </svg>
                </div>
                <span class="mx-2">OB & Committees</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link href="/agendas" method="get" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-person-badge-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"
                    />
                  </svg>
                </div>
                <span class="mx-2">Chairmanship</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link href="/division" method="get" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-buildings-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zM2 11h1v1H2zm2 0h1v1H4zm-1 2v1H2v-1zm1 0h1v1H4zm9-10v1h-1V3zM8 5h1v1H8zm1 2v1H8V7zM8 9h1v1H8zm2 0h1v1h-1zm-1 2v1H8v-1zm1 0h1v1h-1zm3-2v1h-1V9zm-1 2h1v1h-1zm-2-4h1v1h-1zm3 0v1h-1V7zm-2-2v1h-1V5zm1 0h1v1h-1z"
                    />
                  </svg>
                </div>
                <span class="mx-2">Divisions</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link href="/types/" method="get" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-tags-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"
                    />
                    <path
                      d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z"
                    />
                  </svg>
                </div>
                <span class="mx-2">Types</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link href="/account" method="get" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-person-lines-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"
                    />
                  </svg>
                </div>
                <span class="mx-2">Users</span>
              </Link>
            </li>
            <li class="menu-label mt-0">M<span>onitor</span></li>
            <li class="nav-item">
              <Link href="/regular-session" method="get" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-display"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M0 4s0-2 2-2h12s2 0 2 2v6s0 2-2 2h-4q0 1 .25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75Q6 13 6 12H2s-2 0-2-2zm1.398-.855a.76.76 0 0 0-.254.302A1.5 1.5 0 0 0 1 4.01V10c0 .325.078.502.145.602q.105.156.302.254a1.5 1.5 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.76.76 0 0 0 .254-.302 1.5 1.5 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.76.76 0 0 0-.302-.254A1.5 1.5 0 0 0 13.99 3H2c-.325 0-.502.078-.602.145"
                    />
                  </svg>
                </div>
                <span class="mx-2">Screen Display</span>
              </Link>
            </li>
            <li class="menu-label mt-0">A<span>rchives</span></li>

            <li class="nav-item">
              <Link href="/invited-guests" method="get" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-person-vcard-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0"
                    />
                  </svg>
                </div>
                <span class="mx-2">Invited Guests</span>
              </Link>
            </li>
            <li class="nav-item">
              <Link href="/files" method="get" class="nav-link">
                <div class="text-white">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-folder-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3m-8.322.12q.322-.119.684-.12h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981z"
                    />
                  </svg>
                </div>
                <span class="mx-2">File Manager</span>
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- end left-sidenav-->

  <!-- Top Bar Start -->
  <!-- Top Bar Start -->
  <div class="topbar">
    <!-- Navbar -->
    <nav class="navbar-custom" id="navbar-custom">
      <ul
        class="list-unstyled topbar-nav d-flex justify-content-between align-items-center mb-0"
      >
        <h5 class="ms-4 fw-bolder">
          <!-- display logo -->
        </h5>

        <li class="dropdown">
          <a
            class="nav-link dropdown-toggle nav-user"
            data-bs-toggle="dropdown"
            href="#"
            role="button"
            aria-haspopup="false"
            aria-expanded="false"
          >
            <div class="d-flex align-items-center">
              <img
                :src="`${config.baseUrl}/storage/user-images/no_image.png`"
                alt="profile-user"
                class="rounded-circle me-2 thumb-sm"
              />
              <div>
                <small class="d-none d-md-block font-11">NAME</small>
                <span class="d-none d-md-block fw-semibold font-12"
                  ><i class="mdi mdi-chevron-down"></i
                ></span>
              </div>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end">
            <div class="text-center">
              <Link class="dropdown-item" href="/profile">
                <i class="ti ti-user font-16 me-1 align-text-bottom"></i> Profile
              </Link>
            </div>
            <div class="dropdown-divider mb-0"></div>
            <form action="/logout" method="POST">
              <div class="d-grid">
                <button type="submit" class="btn btn-transparent">
                  <i class="ti ti-power font-16 me-1 align-text-bottom"></i>
                  Logout
                </button>
              </div>
            </form>
          </div>
        </li>
        <!--end topbar-profile-->
      </ul>
      <!--end topbar-nav-->
    </nav>
    <!-- end navbar-->
  </div>
  <!-- Top Bar End -->

  <div class="page-wrapper">
    <!-- Page Content-->
    <div class="page-content-tab">
      <div class="container-fluid">
        <slot></slot>
      </div>
      <!-- container -->

      <!--Start Rightbar-->
      <!--end Rightbar-->

      <!--Start Footer-->
      <!-- Footer Start -->
      <footer class="footer text-center text-sm-start">&nbsp;</footer>
      <!-- end Footer -->
      <!--end footer-->
    </div>
    <!-- end page content -->
  </div>
  <!-- end page-wrapper -->

  <!-- Javascript  -->
  <!-- vendor js -->
</template>

<style>
.required::after {
  color: red;
  content: " *";
}

.cursor-pointer {
  cursor: pointer;
}
</style>
