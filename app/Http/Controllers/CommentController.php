<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request)
    {

        //?Validacion
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);
        //?Recoger datos
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //?Asgino los valores al objeto a guardar
        $comment = new Comment();

        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        //?Guardar en la base de datos
        $comment->save();

        //?Redireccion
        return redirect()->route('image.detail', ['id' => $image_id])
            ->with([
                'message' => 'Se ha publicado tu comentario correctamente'
            ]);
    }

    public function delete($id)
    {
        //?Conseguir datos del usuario identificado
        $user = \Auth::user();
        //?Conseguir objeto del comentario
        $comment = Comment::find($id);

        //?Comprobar si soy el dueño del comentario o de la publicacion
        if ($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)) {
            $comment->delete();

            return redirect()->route('image.detail', ['id' => $comment->image->user_id])
                ->with([
                    'message' => 'Se ha eliminado el comentario'
                ]);
        } else {
            return redirect()->route('image.detail', ['id' => $comment->image->user_id])
                ->with([
                    'message' => 'El comentario NO SE HA ELIMINADO'
                ]);
        }
    }
}
