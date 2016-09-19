@extends("master")

@section("title", "Add new product")
@section("description", "We will adding a new product")

@section("styles")
	<style type="text/css">
		textarea {
			resize: none;
		}
	</style>


@endsection

@section("content")

	<h1>Add New Product</h1>
	<form id="add-product" method="post" enctype="multipart/form-data" action="/submit-product">
		{!! csrf_field() !!}

		<div class="form-group {{ $errors->has("product_title") ? "has-error" : "" }}">

			<label>Product Title</label>
			<input type="text" class="form-control" name="product_title" placeholder="Product Title" value="{{ old('product_title') }}">

			{!!$errors->first("product_title","<span class='help-block'>:message</span>")!!}
		</div>

		<div class="form-group {{ $errors->has("product_description") ? "has-error" : "" }}">
			<label>Product Description</label>
			<textarea class="form-control" name="product_description" placeholder="Product Description" rows="5">{{ old('product_description') }}</textarea>

			{!!$errors->first("product_description","<span class='help-block'>:message</span>")!!}
		</div>

{{-- 		<div class="form-group {{ $errors->has("product_type") ? "has-error" : "" }}">
			<label>Product Type</label>
			<input type="text" class="form-control" name="product_type" placeholder="Product Type" value="{{ old('product_type') }}">

			{!!$errors->first("product_type","<span class='help-block'>:message</span>")!!}
		</div>
 --}}
		<div class="form-group {{ $errors->has("product_price") ? "has-error" : "" }}">
			<label>Product Price</label>
			<input type="number" class="form-control" name="product_price" min="0" placeholder="Product Price" value="{{ old('product_price') }}">

			{!!$errors->first("product_price","<span class='help-block'>:message</span>")!!}
		</div>

		<div class="form-group {{ $errors->has("product_quantity") ? "has-error" : "" }}">
			<label>Product Quantity</label>
			<input type="number" class="form-control" name="product_quantity" min="1" placeholder="Product Price" value="{{ old('product_quantity') }}">

			{!!$errors->first("product_quantity","<span class='help-block'>:message</span>")!!}
		</div>

		<div class="form-group {{ $errors->has("product_image") ? "has-error" : "" }}">
			<label>Product Image</label>
			<input type="file" class="form-control" name="product_image" placeholder="Product Image">

			{!!$errors->first("product_image","<span class='help-block'>:message</span>")!!}
		</div>


		<div class="form-group">
			<button type="submit" class="btn btn-primary"> Add Product </button>
		</div>

	</form>

{{-- 	@if(count($errors))
		<ul>
			@foreach($errors->all() as $error )
				<li>{{$error}}</li>
			@endforeach
		</ul>
	@endif
 --}}
@endsection

@section("scripts")



@endsection
