@include('layouts.header')

<div class="row mt-3">
	<div class="col-8">
		@yield('content')
	</div>

	<div class="col-4">

		@section('sidebar')
			<h2> Barra lateral </h2>
		@show

	</div>
</div>

@include('layouts.footer')