@extends('admin.layout.master')

@section('title')
    Reviews
@endsection

@section('css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
    <!-- END: Vendor CSS-->


@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Reviews</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ List</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Reviews</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item active">Reviews List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session()->get('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mg-b-0">Product Reviews</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example1">
                                        <thead>
                                            <tr>
                                                <th class="wd-5p border-bottom-0">#</th>
                                                <th class="wd-15p border-bottom-0">Product</th>
                                                <th class="wd-15p border-bottom-0">Reviewer</th>
                                                <th class="wd-10p border-bottom-0">Rating</th>
                                                <th class="wd-30p border-bottom-0">Comment</th>
                                                <th class="wd-10p border-bottom-0">Status</th>
                                                <th class="wd-10p border-bottom-0">Date</th>
                                                <th class="wd-10p border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reviews as $review)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if($review->product)
                                                            <a href="{{ route('product.show', $review->product->slug) }}" target="_blank">
                                                                {{ $review->product->name }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Deleted Product</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $review->name }}<br>
                                                        <small class="text-muted">{{ $review->phone }}</small>
                                                    </td>
                                                    <td>
                                                        @for($i=1; $i<=5; $i++)
                                                            <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                        @endfor
                                                    </td>
                                                    <td>{{ Str::limit($review->comment, 100) }}</td>
                                                    <td>
                                                        <button 
                                                            class="btn btn-sm status-btn {{ $review->is_approved ? 'btn-success' : 'btn-warning' }}" 
                                                            data-id="{{ $review->id }}"
                                                            data-status="{{ $review->is_approved }}">
                                                            {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                                        </button>
                                                    </td>
                                                    <td>{{ $review->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="post" style="display:inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="button" class="btn btn-sm btn-danger delete-btn">
                                                                <i class="feather icon-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row closed -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@section('script')
    <!-- Internal Data tables -->
    <script src="{{ asset('admin/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/js/scripts/datatables/datatable.js') }}"></script>

    <!-- Internal Notify js -->
    {{-- Toastr is already included in master layout --}}

    <script>
        $(document).ready(function() {
            // Initialize DataTable if not already by theme
            if ( ! $.fn.DataTable.isDataTable( '#example1' ) ) {
                $('#example1').DataTable({
                    responsive: true,
                    language: {
                        searchPlaceholder: 'Search...',
                        sSearch: '',
                        lengthMenu: '_MENU_ items/page',
                    }
                });
            }
            // Toggle Status (Event Delegation for DataTable)
            $(document).on('click', '.status-btn', function() {
                var $this = $(this);
                var reviewId = $this.data('id');
                var currentStatus = $this.data('status');
                var newStatus = currentStatus ? 0 : 1;
                var newText = newStatus ? 'Approved' : 'Pending';
                var newClass = newStatus ? 'btn-success' : 'btn-warning';
                var oldClass = currentStatus ? 'btn-success' : 'btn-warning';

                // Optimistic UI update
                $this.text(newText)
                     .removeClass(oldClass)
                     .addClass(newClass)
                     .data('status', newStatus);

                $.ajax({
                    url: '/admin/reviews/status/' + reviewId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_approved: newStatus
                    },
                    success: function(response) {
                        toastr.success("Status Updated Successfully", "Success");
                    },
                    error: function() {
                         toastr.error("Error Updating Status", "Error");
                         // Revert on error
                        $this.text(currentStatus ? 'Approved' : 'Pending')
                             .removeClass(newClass)
                             .addClass(oldClass)
                             .data('status', currentStatus);
                    }
                });
            });

             // Delete Confirmation (Event Delegation for DataTable)
            $(document).on('click', '.delete-btn', function(e) {
                var form = $(this).closest('form');
                if(confirm("Are you sure you want to delete this review?")) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
