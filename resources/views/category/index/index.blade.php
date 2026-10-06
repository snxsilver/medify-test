@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('category/form/new')}}" class="btn btn-secondary">+ Kategori Baru</a>
            </div>
            <div class="card">
                <div class="card-header">Daftar Kategori</div>

                <div class="card-body">
                    @include('category.index.filter')
                    @include('category.index.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@include('category.index.js')
@endsection