@extends('layout.cms')

@section('header')
    <title> -  </title>
@stop




@section('content')
<main id="js-page-content" role="main" class="page-content">
                <div class="row">
                    <div class="col-xl-12">
                        <div id="panel-1" class="panel">
                            @if(Session::has('success'))

                                <div class="alert bg-success-400 text-white" role="alert">
                                    {!! Session::get("success") !!}
                                </div>
                            @elseif(Session::has('error'))
                                <div class="alert bg-danger-400 text-white" role="alert">
                                    {!! Session::get("error") !!}
                                </div>
                            @endif <br>

                            <div class="panel-hdr">
                                <h2>
                                    კანდიდატები <span class="fw-300"><i></i></span>
                                </h2>
                                <div class="panel-toolbar">
                                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="collapse"></button>
                                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="fullscreen"></button>
                                </div>
                            </div>


                            <div class="panel-container show">
                                <div class="panel-content">

                                    <button style="margin-bottom: 20px" class="btn bt-md btn-outline-primary add">ახალი კანდიდატი</button>


                                    <table class="table table-bordered table-hover table-striped w-100" id="candidatesTable">
                                        <thead>
                                        <tr>
                                            <th>სახელი/გვარი</th>
                                            <th>პოზიცია</th>
                                            <th>სტატუსი</th>
                                            <th>ხელფასი</th>
                                            <th>skills</th>
                                            <th>ქმედება</th>
                                        </tr>
                                        </thead>
                                    </table>


                                </div>
                            </div>





                        </div>
                    </div>
                </div>

            </main>

    @include('layout.modals.CandidateModal')
@endsection


@section('scripts')
    <script src="{{asset('assets/custom/js/candidates.js')}}"></script>

    <script>
        let datatableRoute = '{{route('candidate.datatable')}}';
        let getRoute = '{{route('candidate.get')}}';
        let storeRoute  = '{{route('candidate.store')}}'


    </script>


@stop
