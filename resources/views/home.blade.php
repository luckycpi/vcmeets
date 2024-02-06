@extends('layouts.app')
@section('body-classes', 'inner-page')
@section('content')
    <div class="header position-relative">
        <img src="{{asset('images/vc-header-bg.png')}}" alt="Hub71" class="img-fluid p-0"/>

        <div class="logo-wrapper position-absolute w-100 top-0">
            <div class="container py-5">
                <div class="row">
                    <div class="col-12 text-end">
                        <a href="{{route('home')}}">
                            <img src="{{asset('images/hub71-logo.png')}}" alt="Hub71 Logo" class="logo"/>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h1 class="header-text">Nurturing Tomorrow's <br class="d-none d-md-block"/>Entrepreneurs</h1>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="container">
        <form action="." method="get" name="search" id="search-form">
            @csrf
            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="form-floating">
                        <select name="funding" class="form-select" id="fundingFilter" aria-label="Search by Funding">
                            <option value="">All</option>
                            <option value="0|1" {{request('funding') == '0|1'? 'selected' : ''}}>Less than $1M</option>
                            <option value="1|5" {{request('funding') == '1|5'? 'selected' : ''}}>$1M - $5M</option>
                            <option value="5|10" {{request('funding') == '5|10'? 'selected' : ''}}>$5M - $10M</option>
                            <option value="10|20" {{request('funding') == '10|20'? 'selected' : ''}}>$10M - $20M
                            </option>
                            <option value="20|30" {{request('funding') == '20|30'? 'selected' : ''}}>$20M - $30M
                            </option>
                            <option value="30|999" {{request('funding') == '30|999'? 'selected' : ''}}>Greater than
                                $30M
                            </option>
                        </select>
                        <label for="fundingFilter">Search by Funding</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="form-floating">
                        <select name="sector" class="form-select" id="sectorFilter" aria-label="Search by Sector">
                            <option value="">All</option>
                            @forelse($sectors as $sector)
                                <option value="{{$sector->sector}}" {{request('sector') == $sector->sector? 'selected' : ''}}>{{$sector->sector}}</option>
                            @empty
                                <option>No records found</option>
                            @endforelse
                        </select>
                        <label for="sectorFilter">Search by Sector</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input name="s" type="search" class="form-control" id="floatingInput" placeholder="Search by..."
                               value="{{request('s')}}">
                        <label for="floatingInput">Search By...</label>
                    </div>
                </div>
                <p class="text-end text-muted small">
                    @php
                        $total = $startups->total();
                        $currentPage = $startups->currentPage();
                        $perPage = $startups->perPage();

                        $from = ($currentPage - 1) * $perPage + 1;
                        $to = min($currentPage * $perPage, $total);

                        echo "Showing {$from} to {$to} of {$total} entries";
                    @endphp
                </p>
            </div>
        </form>
        @forelse($startups as $startup)
            <div class="card mb-3 shadow rounded rounded-4 border-0 mb-4 position-relative {{$startup->votes->count() > 0? 'voted' : ''}}"
                 id="card-{{$startup->id}}">
                <span class="loader fa-3x position-absolute d-none">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
                <div class="row g-0">
                    <div class="col-md-4 p-3 logo-img">
                        <div class="d-flex align-items-center justify-content-center h-100 border border-primary rounded rounded-4">
                            <div class="card-img text-center p-3">
                                @if (file_exists(public_path($image_path = 'images/logos/' . $startup->id . '.png')))
                                    <img src="{{asset($image_path)}}" alt="Ovasave"
                                     class="img-fluid align-content-center"/>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body ps-md-0">
                            <h4 class="card-title">{{$startup->name}}</h4>
                            <p class="card-text">{{$startup->description}}</p>

                            <div class="row">
                                <div class="col-6 col-md">
                                    <h5>Sector</h5>
                                    <span>{{$startup->sector}}</span>
                                </div>
                                <div class="col-6 col-md">
                                    <h5>Founders</h5>
                                    <span>{{$startup->founders}}</span>
                                </div>
                                <div class="col-6 col-md">
                                    <h5>Founders Nationality</h5>
                                    <span>{{$startup->founders_nationality}}</span>
                                </div>
                                <div class="col-6 col-md">
                                    <h5>Headquarter</h5>
                                    <span>{{$startup->headquarters}}</span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6 col-md-3">
                                    <h5>Investment Stage</h5>
                                    <span>{{$startup->investment_stage}}</span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <h5>Funds Raised</h5>
                                    <span>{{$startup->funds_raised}} {{$startup->fund_value}}</span>
                                </div>

                                <div class="col-md-6 mt-3 mt-md-0 d-flex justify-content-end align-items-end">

                                    <a href="#" class="btn btn-success rounded rounded-pill glow-on-hover interested {{$startup->votes->count() > 0? 'voted' : ''}}"
                                       data-id="{{$startup->id}}">
                                        {{$startup->votes->count() > 0? __("Not Interested") : __("I'm Interested")}}
                                    </a>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>Sorry, no records found...</p>
        @endforelse

        {!! $startups->withQueryString()->onEachSide(0)->links() !!}

    </div>

    <footer>

    </footer>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function (e) {
            $('.interested').on('click', function (e) {
                e.preventDefault();

                let $id = $(this).data('id');
                let $card = $('#card-' + $id);
                let $vote_btn = $(this);
                let $btn_txt = "Not Interested";
                let $url = "{{route('vote')}}";

                if($vote_btn.hasClass('voted')) {
                    $url = "{{route('unvote')}}";
                    $btn_txt = "I'm Interested";
                }

                $card.children('.loader').removeClass('d-none');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: $url,
                    data: {'id': $id},
                    success: function (data) {
                        $card.toggleClass('voted').children('.loader').addClass('d-none');
                        $vote_btn.text($btn_txt).toggleClass('voted');
                        console.log(data);
                    },
                    error: function (data) {
                        console.log(data);
                    },
                    complete: function (data) {
                        $card.children('.loader').addClass('d-none');
                    }
                });

            });

            $('#fundingFilter, #sectorFilter').on('change', function (e) {
                $('#search-form').submit();
            });
        });
    </script>
@endpush
