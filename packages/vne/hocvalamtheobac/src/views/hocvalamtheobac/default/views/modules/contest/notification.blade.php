@extends('VNE-HOCVALAMTHEOBAC::layouts.master')
@section('title') {{ 'Thông báo'}} @stop
@section('content')
<main class="main">
	<div class="container container-main">
		<div class="row">
                <div class="col-lg-12 left-main">
                    <!-- news detail -->
                    <section class="section news-detail">
                        <div class="wrapper">
                            <div class="content">
                                {!! $messages !!}
                            </div>
                        </div>
                    </section>
                    <!-- news detail end -->
    
                </div>
    
                {{-- <div class="col-lg-4 right-main">
    
                    @include('VNE-THEME::layouts._sidebar')
    
                </div> --}}

		</div>
	</div>
</main>
@stop