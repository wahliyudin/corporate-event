@extends('layouts.app')

@section('content')
    <!-- Start::row-1 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-sm-4">
                            <div class="d-flex">
                                <h6 class="fw-semibold mb-0">Upcoming Events (<span id="total-events">0</span>)</h6>
                            </div>
                        </div>
                        <div class="col-sm-8 mt-3 mt-sm-0">
                            <div class="input-group">
                                <input type="text" id="searchBox" class="form-control w-25"
                                    placeholder="Enter your keyword here">
                                <button type="button" class="btn btn-primary">
                                    <i class="ri-search-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->

    <!-- Start::row-2 -->
    <div class="row">
        <div class="col-xxl-3 col-xl-4">
            <div class="card custom-card products-navigation-card">
                <div class="card-body p-0">
                    <div class="py-4 px-sm-4 p-3 border-bottom">
                        <h6 class="fw-semibold mb-0">Categories</h6>
                        <div class="px-sm-2 px-0 py-3 pb-0" id="event-categories">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-9 col-xl-8">
            <div id="list-events"></div>
        </div>
        <div id="pagination"></div>
    </div>
    <!-- End::row-2 -->
@endsection

@push('js')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    @vite(['resources/js/pages/event/upcoming/index.js'])
@endpush
