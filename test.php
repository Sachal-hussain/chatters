<!doctype html>
<html lang="en">

    
<!-- Mirrored from themesbrand.com/minia/layouts/form-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Feb 2024 14:47:20 GMT -->
<head>
        
        <meta charset="utf-8" />
        <title>Forms Advanced Plugins | Minia - Minimal Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- choices css -->
        <link href="assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

        <!-- color picker css -->
        <link rel="stylesheet" href="assets/libs/%40simonwep/pickr/themes/classic.min.css"/> <!-- 'classic' theme -->
        <link rel="stylesheet" href="assets/libs/%40simonwep/pickr/themes/monolith.min.css"/> <!-- 'monolith' theme -->
        <link rel="stylesheet" href="assets/libs/%40simonwep/pickr/themes/nano.min.css"/> <!-- 'nano' theme -->

        <!-- datepicker css -->
        <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">

        <!-- preloader css -->
        <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.svg" alt="" height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">Minia</span>
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.svg" alt="" height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">Minia</span>
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search...">
                                <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="search" class="icon-lg"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
        
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">

                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="dropdown d-none d-sm-inline-block">
                            <button type="button" class="btn header-item"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img id="header-lang-img" src="assets/images/flags/us.jpg" alt="Header Language" height="16">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="en">
                                    <img src="assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
                                </a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp">
                                    <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="gr">
                                    <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="it">
                                    <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ru">
                                    <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                                </a>
                            </div>
                        </div>

                        <div class="dropdown d-none d-sm-inline-block">
                            <button type="button" class="btn header-item" id="mode-setting-btn">
                                <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                                <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                            </button>
                        </div>

                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="grid" class="icon-lg"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                                <div class="p-2">
                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/github.png" alt="Github">
                                                <span>GitHub</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                                <span>Bitbucket</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                                <span>Dribbble</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                                <span>Dropbox</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                                <span>Mail Chimp</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/slack.png" alt="slack">
                                                <span>Slack</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="bell" class="icon-lg"></i>
                                <span class="badge bg-danger rounded-pill">5</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0"> Notifications </h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small text-reset text-decoration-underline"> Unread (3)</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">James Lemire</h6>
                                                <div class="font-size-13 text-muted">
                                                    <p class="mb-1">It will seem like simplified English.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>1 hour ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-sm me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="bx bx-cart"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your order is placed</h6>
                                                <div class="font-size-13 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>3 min ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-sm me-3">
                                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your item is shipped</h6>
                                                <div class="font-size-13 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>3 min ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="assets/images/users/avatar-6.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Salena Layfield</h6>
                                                <div class="font-size-13 text-muted">
                                                    <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>1 hour ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                        <i class="mdi mdi-arrow-right-circle me-1"></i> <span>View More..</span> 
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item right-bar-toggle me-2">
                                <i data-feather="settings" class="icon-lg"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium">Shawn L.</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="apps-contacts-profile.html"><i class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i> Profile</a>
                                <a class="dropdown-item" href="auth-lock-screen.html"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> Lock Screen</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="auth-logout.html"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" data-key="t-menu">Menu</li>

                            <li>
                                <a href="index.html">
                                    <i data-feather="home"></i>
                                    <span data-key="t-dashboard">Dashboard</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="grid"></i>
                                    <span data-key="t-apps">Apps</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="apps-calendar.html">
                                            <span data-key="t-calendar">Calendar</span>
                                        </a>
                                    </li>
        
                                    <li>
                                        <a href="apps-chat.html">
                                            <span data-key="t-chat">Chat</span>
                                        </a>
                                    </li>
        
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow">
                                            <span data-key="t-email">Email</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li><a href="apps-email-inbox.html" data-key="t-inbox">Inbox</a></li>
                                            <li><a href="apps-email-read.html" data-key="t-read-email">Read Email</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow">
                                            <span data-key="t-invoices">Invoices</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li><a href="apps-invoices-list.html" data-key="t-invoice-list">Invoice List</a></li>
                                            <li><a href="apps-invoices-detail.html" data-key="t-invoice-detail">Invoice Detail</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow">
                                            <span data-key="t-contacts">Contacts</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li><a href="apps-contacts-grid.html" data-key="t-user-grid">User Grid</a></li>
                                            <li><a href="apps-contacts-list.html" data-key="t-user-list">User List</a></li>
                                            <li><a href="apps-contacts-profile.html" data-key="t-profile">Profile</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);" class="">
                                            <span data-key="t-blog">Blog</span>
                                            <span class="badge rounded-pill badge-soft-danger float-end" key="t-new">New</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li><a href="apps-blog-grid.html" data-key="t-blog-grid">Blog Grid</a></li>
                                            <li><a href="apps-blog-list.html" data-key="t-blog-list">Blog List</a></li>
                                            <li><a href="apps-blog-detail.html" data-key="t-blog-details">Blog Details</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="users"></i>
                                    <span data-key="t-authentication">Authentication</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="auth-login.html" data-key="t-login">Login</a></li>
                                    <li><a href="auth-register.html" data-key="t-register">Register</a></li>
                                    <li><a href="auth-recoverpw.html" data-key="t-recover-password">Recover Password</a></li>
                                    <li><a href="auth-lock-screen.html" data-key="t-lock-screen">Lock Screen</a></li>
                                    <li><a href="auth-logout.html" data-key="t-logout">Log Out</a></li>
                                    <li><a href="auth-confirm-mail.html" data-key="t-confirm-mail">Confirm Mail</a></li>
                                    <li><a href="auth-email-verification.html" data-key="t-email-verification">Email Verification</a></li>
                                    <li><a href="auth-two-step-verification.html" data-key="t-two-step-verification">Two Step Verification</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="file-text"></i>
                                    <span data-key="t-pages">Pages</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="pages-starter.html" data-key="t-starter-page">Starter Page</a></li>
                                    <li><a href="pages-maintenance.html" data-key="t-maintenance">Maintenance</a></li>
                                    <li><a href="pages-comingsoon.html" data-key="t-coming-soon">Coming Soon</a></li>
                                    <li><a href="pages-timeline.html" data-key="t-timeline">Timeline</a></li>
                                    <li><a href="pages-faqs.html" data-key="t-faqs">FAQs</a></li>
                                    <li><a href="pages-pricing.html" data-key="t-pricing">Pricing</a></li>
                                    <li><a href="pages-404.html" data-key="t-error-404">Error 404</a></li>
                                    <li><a href="pages-500.html" data-key="t-error-500">Error 500</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="layouts-horizontal.html">
                                    <i data-feather="layout"></i>
                                    <span data-key="t-horizontal">Horizontal</span>
                                </a>
                            </li>

                            <li class="menu-title mt-2" data-key="t-components">Elements</li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="briefcase"></i>
                                    <span data-key="t-components">Components</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="ui-alerts.html" data-key="t-alerts">Alerts</a></li>
                                    <li><a href="ui-buttons.html" data-key="t-buttons">Buttons</a></li>
                                    <li><a href="ui-cards.html" data-key="t-cards">Cards</a></li>
                                    <li><a href="ui-carousel.html" data-key="t-carousel">Carousel</a></li>
                                    <li><a href="ui-dropdowns.html" data-key="t-dropdowns">Dropdowns</a></li>
                                    <li><a href="ui-grid.html" data-key="t-grid">Grid</a></li>
                                    <li><a href="ui-images.html" data-key="t-images">Images</a></li>
                                    <li><a href="ui-modals.html" data-key="t-modals">Modals</a></li>
                                    <li><a href="ui-offcanvas.html" data-key="t-offcanvas">Offcanvas</a></li>
                                    <li><a href="ui-progressbars.html" data-key="t-progress-bars">Progress Bars</a></li>
                                    <li><a href="ui-placeholders.html" data-key="t-progress-bars">Placeholders</a></li>
                                    <li><a href="ui-tabs-accordions.html" data-key="t-tabs-accordions">Tabs & Accordions</a></li>
                                    <li><a href="ui-typography.html" data-key="t-typography">Typography</a></li>
                                    <li><a href="ui-toasts.html" data-key="t-typography">Toasts</a></li>
                                    <li><a href="ui-video.html" data-key="t-video">Video</a></li>
                                    <li><a href="ui-general.html" data-key="t-general">General</a></li>
                                    <li><a href="ui-colors.html" data-key="t-colors">Colors</a></li>
                                    <li><a href="ui-utilities.html" data-key="t-colors">Utilities</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="gift"></i>
                                    <span data-key="t-ui-elements">Extended</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="extended-lightbox.html" data-key="t-lightbox">Lightbox</a></li>
                                    <li><a href="extended-rangeslider.html" data-key="t-range-slider">Range Slider</a></li>
                                    <li><a href="extended-sweet-alert.html" data-key="t-sweet-alert">SweetAlert 2</a></li>
                                    <li><a href="extended-session-timeout.html" data-key="t-session-timeout">Session Timeout</a></li>
                                    <li><a href="extended-rating.html" data-key="t-rating">Rating</a></li>
                                    <li><a href="extended-notifications.html" data-key="t-notifications">Notifications</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);">
                                    <i data-feather="box"></i>
                                    <span class="badge rounded-pill badge-soft-danger  text-danger float-end">7</span>
                                    <span data-key="t-forms">Forms</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="form-elements.html" data-key="t-form-elements">Basic Elements</a></li>
                                    <li><a href="form-validation.html" data-key="t-form-validation">Validation</a></li>
                                    <li><a href="form-advanced.html" data-key="t-form-advanced">Advanced Plugins</a></li>
                                    <li><a href="form-editors.html" data-key="t-form-editors">Editors</a></li>
                                    <li><a href="form-uploads.html" data-key="t-form-upload">File Upload</a></li>
                                    <li><a href="form-wizard.html" data-key="t-form-wizard">Wizard</a></li>
                                    <li><a href="form-mask.html" data-key="t-form-mask">Mask</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="sliders"></i>
                                    <span data-key="t-tables">Tables</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="tables-basic.html" data-key="t-basic-tables">Bootstrap Basic</a></li>
                                    <li><a href="tables-datatable.html" data-key="t-data-tables">DataTables</a></li>
                                    <li><a href="tables-responsive.html" data-key="t-responsive-table">Responsive</a></li>
                                    <li><a href="tables-editable.html" data-key="t-editable-table">Editable</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="pie-chart"></i>
                                    <span data-key="t-charts">Charts</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="charts-apex.html" data-key="t-apex-charts">Apexcharts</a></li>
                                    <li><a href="charts-echart.html" data-key="t-e-charts">Echarts</a></li>
                                    <li><a href="charts-chartjs.html" data-key="t-chartjs-charts">Chartjs</a></li>
                                    <li><a href="charts-knob.html" data-key="t-knob-charts">Jquery Knob</a></li>
                                    <li><a href="charts-sparkline.html" data-key="t-sparkline-charts">Sparkline</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="cpu"></i>
                                    <span data-key="t-icons">Icons</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="icons-boxicons.html" data-key="t-boxicons">Boxicons</a></li>
                                    <li><a href="icons-materialdesign.html" data-key="t-material-design">Material Design</a></li>
                                    <li><a href="icons-dripicons.html" data-key="t-dripicons">Dripicons</a></li>
                                    <li><a href="icons-fontawesome.html" data-key="t-font-awesome">Font Awesome 5</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="map"></i>
                                    <span data-key="t-maps">Maps</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="maps-google.html" data-key="t-g-maps">Google</a></li>
                                    <li><a href="maps-vector.html" data-key="t-v-maps">Vector</a></li>
                                    <li><a href="maps-leaflet.html" data-key="t-l-maps">Leaflet</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="share-2"></i>
                                    <span data-key="t-multi-level">Multi Level</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="javascript: void(0);" data-key="t-level-1-1">Level 1.1</a></li>
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow" data-key="t-level-1-2">Level 1.2</a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <li><a href="javascript: void(0);" data-key="t-level-2-1">Level 2.1</a></li>
                                            <li><a href="javascript: void(0);" data-key="t-level-2-2">Level 2.2</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                        </ul>

                        <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
                            <div class="card-body">
                                <img src="assets/images/giftbox.png" alt="">
                                <div class="mt-4">
                                    <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                                    <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>
                                    <a href="#!" class="btn btn-primary mt-2">Upgrade Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Forms Advanced Plugins</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item active">Forms Advanced Plugins</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Css Switch</h4>
                                        <p class="card-title-desc">Here are a few types of switches. </p>
                                    </div>
                                    <!-- end card header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h5 class="font-size-14 mb-3">Example switch</h5>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <input type="checkbox" id="switch1" switch="none" checked />
                                                    <label for="switch1" data-on-label="On" data-off-label="Off"></label>
    
                                                    <input type="checkbox" id="switch2" switch="default" checked />
                                                    <label for="switch2" data-on-label="" data-off-label=""></label>
    
                                                    <input type="checkbox" id="switch3" switch="bool" checked />
                                                    <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
    
                                                    <input type="checkbox" id="switch6" switch="primary" checked />
                                                    <label for="switch6" data-on-label="Yes" data-off-label="No"></label>
    
                                                    <input type="checkbox" id="switch4" switch="success" checked />
                                                    <label for="switch4" data-on-label="Yes" data-off-label="No"></label>
    
                                                    <input type="checkbox" id="switch7" switch="info" checked />
                                                    <label for="switch7" data-on-label="Yes" data-off-label="No"></label>
    
                                                    <input type="checkbox" id="switch5" switch="warning" checked />
                                                    <label for="switch5" data-on-label="Yes" data-off-label="No"></label>
    
                                                    <input type="checkbox" id="switch8" switch="danger" checked />
                                                    <label for="switch8" data-on-label="Yes" data-off-label="No"></label>
    
                                                    <input type="checkbox" id="switch9" switch="dark" checked />
                                                    <label for="switch9" data-on-label="Yes" data-off-label="No"></label>
                                                </div>
                                            </div>
                                            <!-- end col -->
    
                                            <div class="col-lg-6">
                                                <div class="mt-4 mt-lg-0">
                                                    <h5 class="font-size-14 mb-3">Square switch</h5>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <div class="square-switch">
                                                            <input type="checkbox" id="square-switch1" switch="none" checked />
                                                            <label for="square-switch1" data-on-label="On"
                                                                data-off-label="Off"></label>
                                                        </div>
                                                        <div class="square-switch">
                                                            <input type="checkbox" id="square-switch2" switch="info" checked />
                                                            <label for="square-switch2" data-on-label="Yes"
                                                                data-off-label="No"></label>
                                                        </div>
                                                        <div class="square-switch">
                                                            <input type="checkbox" id="square-switch3" switch="bool" checked />
                                                            <label for="square-switch3" data-on-label="Yes"
                                                                data-off-label="No"></label>
                                                        </div>
                                                        <div class="square-switch">
                                                            <input type="checkbox" id="square-switch4" switch="warning" checked />
                                                            <label for="square-switch4" data-on-label="Yes"
                                                                data-off-label="No"></label>
                                                        </div>
                                                        <div class="square-switch">
                                                            <input type="checkbox" id="square-switch5" switch="danger" checked />
                                                            <label for="square-switch5" data-on-label="Yes"
                                                                data-off-label="No"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Choices</h4>
                                        <p class="card-title-desc">Choices.js is a lightweight, configurable select box/text input plugin.</p>
                                    </div>
                                    <!-- end card header -->

                                    <div class="card-body">
                                        <div>
                                            <h5 class="font-size-14 mb-3">Single select input Example</h5>

                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="choices-single-default" class="form-label font-size-13 text-muted">Default</label>
                                                        <select class="form-control" data-trigger name="choices-single-default"
                                                            id="choices-single-default"
                                                            placeholder="This is a search placeholder">
                                                            <option value="">This is a placeholder</option>
                                                            <option value="Choice 1">Choice 1</option>
                                                            <option value="Choice 2">Choice 2</option>
                                                            <option value="Choice 3">Choice 3</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="choices-single-groups" class="form-label font-size-13 text-muted">Option
                                                            groups</label>
                                                        <select class="form-control" data-trigger name="choices-single-groups"
                                                            id="choices-single-groups">
                                                            <option value="">Choose a city</option>
                                                            <optgroup label="UK">
                                                                <option value="London">London</option>
                                                                <option value="Manchester">Manchester</option>
                                                                <option value="Liverpool">Liverpool</option>
                                                            </optgroup>
                                                            <optgroup label="FR">
                                                                <option value="Paris">Paris</option>
                                                                <option value="Lyon">Lyon</option>
                                                                <option value="Marseille">Marseille</option>
                                                            </optgroup>
                                                            <optgroup label="DE" disabled>
                                                                <option value="Hamburg">Hamburg</option>
                                                                <option value="Munich">Munich</option>
                                                                <option value="Berlin">Berlin</option>
                                                            </optgroup>
                                                            <optgroup label="US">
                                                                <option value="New York">New York</option>
                                                                <option value="Washington" disabled>Washington</option>
                                                                <option value="Michigan">Michigan</option>
                                                            </optgroup>
                                                            <optgroup label="SP">
                                                                <option value="Madrid">Madrid</option>
                                                                <option value="Barcelona">Barcelona</option>
                                                                <option value="Malaga">Malaga</option>
                                                            </optgroup>
                                                            <optgroup label="CA">
                                                                <option value="Montreal">Montreal</option>
                                                                <option value="Toronto">Toronto</option>
                                                                <option value="Vancouver">Vancouver</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="choices-single-no-search" class="form-label font-size-13 text-muted">Options added
                                                            via config with no search</label>
                                                        <select class="form-control" name="choices-single-no-search"
                                                            id="choices-single-no-search">
                                                            <option value="0">Zero</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="choices-single-no-sorting" class="form-label font-size-13 text-muted">Options added
                                                            via config with no search</label>
                                                        <select class="form-control" name="choices-single-no-sorting"
                                                            id="choices-single-no-sorting">
                                                            <option value="Madrid">Madrid</option>
                                                            <option value="Toronto">Toronto</option>
                                                            <option value="Vancouver">Vancouver</option>
                                                            <option value="London">London</option>
                                                            <option value="Manchester">Manchester</option>
                                                            <option value="Liverpool">Liverpool</option>
                                                            <option value="Paris">Paris</option>
                                                            <option value="Malaga">Malaga</option>
                                                            <option value="Washington" disabled>Washington</option>
                                                            <option value="Lyon">Lyon</option>
                                                            <option value="Marseille">Marseille</option>
                                                            <option value="Hamburg">Hamburg</option>
                                                            <option value="Munich">Munich</option>
                                                            <option value="Barcelona">Barcelona</option>
                                                            <option value="Berlin">Berlin</option>
                                                            <option value="Montreal">Montreal</option>
                                                            <option value="New York">New York</option>
                                                            <option value="Michigan">Michigan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end row -->
                                        </div>
                                        <!-- Single select input Example -->


                                        <div class="mt-4">
                                            <h5 class="font-size-14 mb-3">Multiple select input</h5>
    
                                            <div class="row">
                                                <!-- <div class="col-lg-4 col-md-6"> -->
                                                    <div class="mb-3">
                                                        <label for="choices-multiple-default" class="form-label font-size-13 text-muted">Default</label>
                                                        <select class="form-control" data-trigger
                                                            name="choices-multiple-default" id="choices-multiple-default"
                                                            placeholder="This is a placeholder" >
                                                            <!-- <option value="Choice 1" selected>Choice 1</option> -->
                                                            <option value="Choice 2">Choice 2</option>
                                                            <option value="Choice 3">Choice 3</option>
                                                            <option value="Choice 4" disabled>Choice 4</option>
                                                        </select>
                                                    </div>
                                               <!--  </div> -->
    
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="choices-multiple-remove-button" class="form-label font-size-13 text-muted">With
                                                            remove button</label>
                                                        <select class="form-control" name="choices-multiple-remove-button"
                                                            id="choices-multiple-remove-button"
                                                            placeholder="This is a placeholder" multiple>
                                                            <option value="Choice 1" selected>Choice 1</option>
                                                            <option value="Choice 2">Choice 2</option>
                                                            <option value="Choice 3">Choice 3</option>
                                                            <option value="Choice 4">Choice 4</option>
                                                        </select>
                                                    </div>
                                                </div>
    
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="choices-multiple-groups" class="form-label font-size-13 text-muted">Option
                                                            groups</label>
                                                        <select class="form-control" name="choices-multiple-groups"
                                                            id="choices-multiple-groups" placeholder="This is a placeholder"
                                                            multiple>
                                                            <option value="">Choose a city</option>
                                                            <optgroup label="UK">
                                                                <option value="London">London</option>
                                                                <option value="Manchester">Manchester</option>
                                                                <option value="Liverpool">Liverpool</option>
                                                            </optgroup>
                                                            <optgroup label="FR">
                                                                <option value="Paris">Paris</option>
                                                                <option value="Lyon">Lyon</option>
                                                                <option value="Marseille">Marseille</option>
                                                            </optgroup>
                                                            <optgroup label="DE" disabled>
                                                                <option value="Hamburg">Hamburg</option>
                                                                <option value="Munich">Munich</option>
                                                                <option value="Berlin">Berlin</option>
                                                            </optgroup>
                                                            <optgroup label="US">
                                                                <option value="New York">New York</option>
                                                                <option value="Washington" disabled>Washington</option>
                                                                <option value="Michigan">Michigan</option>
                                                            </optgroup>
                                                            <optgroup label="SP">
                                                                <option value="Madrid">Madrid</option>
                                                                <option value="Barcelona">Barcelona</option>
                                                                <option value="Malaga">Malaga</option>
                                                            </optgroup>
                                                            <optgroup label="CA">
                                                                <option value="Montreal">Montreal</option>
                                                                <option value="Toronto">Toronto</option>
                                                                <option value="Vancouver">Vancouver</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
    
                                            </div>
                                            <!-- end row -->
                                        </div>
                                        <!-- multi select input Example -->

                                        <div class="mt-4">
                                            <h5 class="font-size-14 mb-3">Text inputs</h5>
    
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="choices-text-remove-button" class="form-label font-size-13 text-muted">Limited to 5
                                                            values with remove button</label>
                                                        <input class="form-control" id="choices-text-remove-button" type="text"
                                                            value="Task-1,Task-2" placeholder="Enter something" />
                                                    </div>
                                                </div>
                                                <!-- end col -->
    
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="choices-text-unique-values" class="form-label font-size-13 text-muted">Unique values
                                                            only, no pasting</label>
                                                        <input class="form-control" id="choices-text-unique-values" type="text"
                                                            value="Project-A, Project-B" placeholder="This is a placeholder"
                                                            class="custom class" />
                                                    </div>
                                                </div>
                                                <!-- end col -->
                                            </div>
                                            <!-- end row -->
    
                                            <div>
                                                <label for="choices-text-disabled" class="form-label font-size-13 text-muted">Disabled</label>
                                                <input class="form-control" id="choices-text-disabled" type="text"
                                                    value="josh@joshuajohnson.co.uk, joe@bloggs.co.uk"
                                                    placeholder="This is a placeholder" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Colorpicker</h4>
                                        <p class="card-title-desc">Flat, Simple, Hackable Color-Picker.</p>
                                    </div>
                                    <div class="card-body">
    
                                        <div class="text-center">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mt-4">
                                                        <h5 class="font-size-14">Classic Demo</h5>
                                                        <div class="classic-colorpicker"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mt-4">
                                                        <h5 class="font-size-14">Monolith Demo</h5>
                                                        <div class="monolith-colorpicker"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mt-4">
                                                        <h5 class="font-size-14">Nano Demo</h5>
                                                        <div class="nano-colorpicker"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Datepicker</h4>
                                        <p class="card-title-desc">flatpickr is a lightweight and powerful datetime picker.</p>
                                    </div>
                                    <div class="card-body">
    
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Basic</label>
                                                        <input type="text" class="form-control" id="datepicker-basic">
                                                    </div>
    
                                                    <div class="mb-3">
                                                        <label class="form-label">DateTime</label>
                                                        <input type="text" class="form-control" id="datepicker-datetime">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Human-friendly Dates</label>
                                                        <input type="text" class="form-control flatpickr-input" id="datepicker-humanfd">
                                                    </div>
    
                                                    <div class="mb-3">
                                                        <label class="form-label">MinDate and MaxDate</label>
                                                        <input type="text" class="form-control" id="datepicker-minmax">
                                                    </div>
    
                                                    <div class="mb-3">
                                                        <label class="form-label">Disabling dates</label>
                                                        <input type="text" class="form-control" id="datepicker-disable">
                                                    </div>
    
                                                    <div class="mb-3">
                                                        <label class="form-label">Selecting multiple dates</label>
                                                        <input type="text" class="form-control" id="datepicker-multiple">
                                                    </div>
    
                                                    <div>
                                                        <label class="form-label">Range</label>
                                                        <input type="text" class="form-control" id="datepicker-range">
                                                    </div>
                                                </div>
    
                                                <div class="col-lg-6">
                                                    <div class="mt-3 mt-lg-0">
                                                        <div class="mb-3">
                                                            <label class="form-label">Timepicker</label>
                                                            <input type="text" class="form-control" id="datepicker-timepicker">
                                                        </div>
        
                                                        <div>
                                                            <label class="form-label">Inline Date Picker Demo</label>
                                                            <input type="text" class="form-control" id="datepicker-inline">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Minia.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by <a href="#!" class="text-decoration-underline">Themesbrand</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        
        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center p-3">

                    <h5 class="m-0 me-2">Theme Customizer</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="m-0" />

                <div class="p-4">
                    <h6 class="mb-3">Layout</h6>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout"
                            id="layout-vertical" value="vertical">
                        <label class="form-check-label" for="layout-vertical">Vertical</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout"
                            id="layout-horizontal" value="horizontal">
                        <label class="form-check-label" for="layout-horizontal">Horizontal</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Mode</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-light" value="light">
                        <label class="form-check-label" for="layout-mode-light">Light</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-dark" value="dark">
                        <label class="form-check-label" for="layout-mode-dark">Dark</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Width</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width"
                            id="layout-width-fuild" value="fuild" onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                        <label class="form-check-label" for="layout-width-fuild">Fluid</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width"
                            id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                        <label class="form-check-label" for="layout-width-boxed">Boxed</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Layout Position</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position"
                            id="layout-position-fixed" value="fixed" onchange="document.body.setAttribute('data-layout-scrollable', 'false')">
                        <label class="form-check-label" for="layout-position-fixed">Fixed</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position"
                            id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', 'true')">
                        <label class="form-check-label" for="layout-position-scrollable">Scrollable</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Topbar Color</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-color-light" value="light" onchange="document.body.setAttribute('data-topbar', 'light')">
                        <label class="form-check-label" for="topbar-color-light">Light</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                        <label class="form-check-label" for="topbar-color-dark">Dark</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Size</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                        <label class="form-check-label" for="sidebar-size-default">Default</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                        <label class="form-check-label" for="sidebar-size-compact">Compact</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                        <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Color</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                        <label class="form-check-label" for="sidebar-color-light">Light</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-dark" value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                        <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-brand" value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                        <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Direction</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction"
                            id="layout-direction-ltr" value="ltr">
                        <label class="form-check-label" for="layout-direction-ltr">LTR</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction"
                            id="layout-direction-rtl" value="rtl">
                        <label class="form-check-label" for="layout-direction-rtl">RTL</label>
                    </div>

                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <!-- pace js -->
        <script src="assets/libs/pace-js/pace.min.js"></script>

        <!-- choices js -->
        <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

       

        <!-- datepicker js -->
        <script src="assets/libs/flatpickr/flatpickr.min.js"></script>

        <!-- init js -->
        <!-- <script src="assets/js/pages/form-advanced.init.js"></script> -->

        <!-- <script src="assets/js/app.js"></script> -->
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
    var elements = document.querySelectorAll("[data-trigger]");
    for (var i = 0; i < elements.length; ++i) {
        var element = elements[i];
        new Choices(element, {
            placeholderValue: "This is a placeholder set in the config",
            searchPlaceholderValue: "This is a search placeholder"
        });
    }

    new Choices("#choices-single-no-search", {
        searchEnabled: false,
        removeItemButton: true,
        choices: [
            { value: "One", label: "Label One" },
            { value: "Two", label: "Label Two", disabled: true },
            { value: "Three", label: "Label Three" }
        ]
    }).setChoices([
        { value: "Four", label: "Label Four", disabled: true },
        { value: "Five", label: "Label Five" },
        { value: "Six", label: "Label Six", selected: true }
    ], "value", "label", false);

    new Choices("#choices-single-no-sorting", {
        shouldSort: false
    });

    new Choices("#choices-multiple-remove-button", {
        removeItemButton: true
    });

    new Choices(document.getElementById("choices-multiple-groups"));

    new Choices(document.getElementById("choices-text-remove-button"), {
        delimiter: ",",
        editItems: true,
        maxItemCount: 5,
        removeItemButton: true
    });

    new Choices("#choices-text-unique-values", {
        paste: false,
        duplicateItemsAllowed: false,
        editItems: true
    });

    new Choices("#choices-text-disabled", {
        addItems: false,
        removeItems: false
    }).disable();
});

        </script>
    </body>

<!-- Mirrored from themesbrand.com/minia/layouts/form-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Feb 2024 14:47:21 GMT -->
</html>
