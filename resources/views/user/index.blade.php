@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.message')
            <h1>Personas</h1>
            <form action="{{route('user.index')}}" method="get" id="buscador">
                <div class="row">
                    <div class="form-group col ">
                        <input type="text" id="search" class="form-control" placeholder="Buscar perfil">
                    </div>
                    <div class="form-group col btn-search">
                        <input type="submit" class="btn  btn-primary" value="Buscar">
                    </div>
                </div>
            </form>
            <hr>
            @foreach($users as $user)
            <div class="profile-user">
                @if($user->image)
                <div class="container-avatar">
                    <a href="{{route('profile',['id'=>$user->id])}}">
                        <img src="{{ route('user.avatar',['filename'=> $user->image]) }}" class="avatar" />
                    </a>
                </div>
                @endif

                <div class="user-info">
                    <a href="{{route('profile',['id'=>$user->id])}}">
                        <h2>{{'@' . $user->nick}}</h2>
                    </a>
                    <h3>{{$user->name . ' '. $user->surname}}</h3>
                    <p>Se unió: <span>{{\FormatTime::LongTimeFilter($user->created_at) }} </span> </p>
                    <a href="{{route('profile',['id'=>$user->id])}}" class="btn btn-sm btn-success">Ver perfil</a>
                </div>
                <hr>
                <div class="clearfix">
                </div>
            </div>
            @endforeach

            <!--Paginacion-->
            <div class="clearfix"></div>
            {{$users->links()}}
        </div>
    </div>
</div>
@endsection