@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{route('product.update',$product->id)}}" method="post" enctype="multipart/form-data">
                @if ($message = Session::get('message'))
                    <div class="alert alert-danger alert-block">
                        <button class="close" data-dismiss="alert">X</button>
                        <strong>{{$message}}</strong>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li> {{$err}} </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    
                @endif
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input value="{{$product->name}}" type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="Enter Name">
                 
                </div>
               @csrf
               @method('put')
                <div class="form-group">
                    <label for="">Price</label>
                  <input type="text" value="{{$product->price}}" class="form-control" name="price">
                  
                </div>

                <div class="form-group">
                    <img src="{{asset('storage/ava/'.$product->image)}}" alt="image" width="50" height="50">
                    <label for="exampleInputPassword1">Image</label>
                    <input type="file" class="form-control" name="image">
                  </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>
</div>
@endsection
