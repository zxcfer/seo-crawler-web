@extends('site.layouts.default')

@section('css')
<link rel="stylesheet" href="{{asset('assets/css/freelancer.css')}}">
@stop

{{-- Content --}}
@section('content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="{{asset('assets/img/profile.png')}}" alt="">
                    <div class="intro-text">
                        <span class="name">SEO Spider Tool</span>
                        <hr class="star-light">
                        <span class="skills">Websites Spider</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@stop

{{-- Scripts --}}
@section('scripts')
	<script type="text/javascript">
		
	</script>
@stop