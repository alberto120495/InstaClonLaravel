@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Editar Imagen
                </div>
                <div class="card-body">
                    <form action="{{route('image.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="image_id" value="{{$image->id}}">
                        <div class="form-group row">
                            <label for="image_path" class="col-md-4 col-form-label text-md-right">Imagen</label>
                            <div class="col-md-6">
                                @if($image->user->image)
                                <div class="container-avatar">
                                <img src="{{route('image.file',['filename' => $image->image_path])}}" class="avatar" alt="">
                                </div>
                                @endif
                                <input id="image_path" type="file" name="image_path">
                                @error('image_path')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Descripcion</label>
                            <div class="col-md-6">
                                <textarea id="description" type="file" name="description" required>{{$image->description}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <input class="btn btn-primary" type="submit" value="Actualizar publicacion">
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection