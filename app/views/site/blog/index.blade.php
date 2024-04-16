@extends('site.layouts.default')

{{-- Content --}}
@section('content')
@foreach ($posts as $post)
<div class="row">
	<div class="col-md-12">
		<!-- Post Content -->
		<div class="row">
			<div class="col-md-2">
				<a href="{{{ $post->url() }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			</div>
			<div class="col-md-8">
			    <h4><strong><a href="{{{ $post->url() }}}">{{ String::title($post->title) }}</a></strong>
                    <fieldset class="rating">
                        <input type="checkbox" id="star{{{ $post->id }}}" name="rating{{{ $post->id }}}" value="0" />
                        <label for="star{{{ $post->id }}}"></label>
                    </fieldset>
			    </h4>
				<p>
					{{ String::tidy(Str::limit($post->content, 200)) }}
				</p>
			</div>
		</div>
		<!-- ./ post content -->

		<!-- Post Footer -->
		<div class="row">
			<div class="col-md-8">
				<p></p>
				<p>
					<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $post->author->username }}}</span>
					| <span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $post->date() }}}
					| <span class="glyphicon glyphicon-comment"></span> <a href="{{{ $post->url() }}}#comments">{{$post->comments()->count()}} {{ \Illuminate\Support\Pluralizer::plural('Comment', $post->comments()->count()) }}</a>
				</p>
			</div>
		</div>
		<!-- ./ post footer -->
	</div>
</div>

<hr />
@endforeach
{{ $posts->links() }}
@stop
