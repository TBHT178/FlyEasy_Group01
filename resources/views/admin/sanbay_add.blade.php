@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h1 style="padding:20px 0px;text-align: center;">Add New Airport</h1>
    <form action="{{route('sb_addprocess')}}" method="POST">
        @csrf
        <div class="form-group">
            <label>Airport Code <span style="color:red;">(*)</span></label>
            <input name="airport_code" value="{{ old('airport_code') }}"  class="form-control" >
            @error('airport_code')
            <div style="color:red">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Airport Name <span style="color:red;">(*)</span></label>
            <input input name="airport_name" value="{{ old('airport_name') }}" class="form-control">
            @error('airport_name')
            <div style="color:red">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>City <span style="color:red;">(*)</span></label>
            <input class="form-control" name="city" value="{{ old('city') }}">
            @error('city')
            <div style="color:red">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Country <span style="color:red;">(*)</span></label>
            <input  class="form-control" name="country" value="{{ old('country') }}">
            @error('country')
            <div style="color:red">
                {{$message}}
            </div>
            @enderror
        </div>
        <p style="color:red;">All <span >(*)</span> are required fields</p>
        <button style="float:right;" type="submit" class="btn btn-primary">Add Airport</button>
    </form>
</div>

@endsection