<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fruits | Fruit Store</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE 4 | Widgets - Small Box" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />
    <!--end::Primary Meta Tags-->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ asset('assets/cms/css/adminlte.css') }}" as="style" />
    <link rel="preload" href="{{ asset('assets/cms/css/font-awesome.min.css') }}" as="style" />
    <!--end::Accessibility Features-->
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'" />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('assets/cms/css/adminlte.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->

    <!--begin::Datatables-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />
    <!--end::Datatables-->


</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">

        <!--begin::Header-->
        @include('cms.layout.header')
        <!--end::Header-->

        <!--begin::Sidebar-->
        @include('cms.layout.sidebar')
        <!--end::Sidebar-->

        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Fruits</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Fruits</li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Fruits</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!-- Small Box (Stat card) -->
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-12 mb-2">
                            @if (session('success'))
                            <div class="alert alert-success mb-2">
                                {{ session('success') }}
                            </div>
                            @endif
                            @if (session('error'))
                            <div class="alert alert-danger mb-2">
                                {{ session('error') }}
                            </div>
                            @endif
                            <a href="{{ url('cms/addfruit') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add
                                New</a>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12">
                            @if(!empty($fruits))
                            <div class="col-12 col-sm-12 col-md-3">
                                <label for="filterDropdown">Filter by Type:</label>
                                <select class="form-select" id="filterDropdown">
                                    <option value="">All</option>
                                    @foreach ($fruit_types as $tkey => $ftype)
                                        <option value="{{ $ftype->type_name }}">{{ $ftype->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <table class="table table-bordered" id="ordersTable" role="table">
                                <thead>
                                    <tr>
                                        <th style="width: 10px" scope="col">#</th>
                                        <th scope="col">Fruit</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Price Per KG (₹)</th>
                                        <th scope="col">Qty In Stock</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fruits as $tkey => $fdata)
                                    <tr class="align-middle">
                                        <td>{{ $tkey+1 }}</td>
                                        <td>{{ $fdata->name }}</td>
                                        <td>{{ $fdata->type_name }}</td>
                                        <td>{{ $fdata->price }}</td>
                                        <td>{{ $fdata->stock_quantity }}</td>
                                        <td>@if(!empty($fdata->image))<img
                                                src="{{ url('assets/uploads/'.$fdata->image) }}" width="100">@endif</td>
                                        <td class="nowrapcell">
                                            <a href="{{ url('cms/editfruit/'.$fdata->fruit_id) }}"
                                                class="btn btn-sm text-bg-primary"><i class="bi bi-pencil"></i></a>
                                            &nbsp;
                                            <button class="btn btn-sm text-bg-danger btnDeleteFruit"
                                                data-fid="{{ $fdata->fruit_id }}"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <h4 class="text-danger">No data found!</h4>
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->

        <!--begin::Footer-->
        @include('cms.layout.footer')
        <!--end::Footer-->

    </div>
    <!--end::App Wrapper-->

    <!--begin::Script-->
    <script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)-->
    <!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous">
    </script>
    <!--end::Required Plugin(Bootstrap 5)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('assets/cms/js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)-->
    <!--begin::OverlayScrollbars Configure-->
    <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                },
            });
        }
    });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>

    <script>
    let curUrl = "{{ url('cms/fruits') }}";
    $(document).ready(function() {
        // delete fruit type
        $(document).on("click", ".btnDeleteFruit", function() {
            let url = "{{ url('cms/deletefruit') }}";
            let fruitId = $(this).data('fid');
            Swal.fire({
                title: "Are you sure to delete?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                // confirmButtonColor: "#3085d6",
                // cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            'fruitId': fruitId,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // You can return JSON from controller
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success"
                                }).then((result) => {
                                    window.location.href = curUrl;
                                });
                            } else {
                                Swal.fire({
                                    title: "An error occured!",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Something went wrong!",
                                text: xhr.responseText,
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });

        var fruitsDataTable = new DataTable('#ordersTable');

        // Dropdown change event to filter data
        $('#filterDropdown').on('change', function() {
            var selectedCategory = $(this).val();

            if (selectedCategory) {
                // If a category is selected, filter based on the second column (Category)
                fruitsDataTable.column(2).search('^' + selectedCategory + '$', true, false).draw();
            } else {
                // If no category is selected, reset the filter
                fruitsDataTable.column(2).search('').draw();
            }
        });
    });
    </script>

</body>
<!--end::Body-->

</html>