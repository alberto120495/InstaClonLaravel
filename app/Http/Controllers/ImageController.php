<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Comment;
use App\Like;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('image.create');
    }

    public function save(Request $request)
    {

        //?Validacion
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|image',
        ]);

        //?Recoger los datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //?Asignar valores al objeto
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

        //?subir fichero
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            //?Setear
            $image->image_path = $image_path_name;
        }

        $image->save();
        return redirect()->route('home')->with([
            'message'=>'La imagen ha sido subida correctamente'
        ]);
    }
    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file,200);
    }
    public function detail($id){
        $image = Image::find($id);
        return view('image.detail',[
            'image'=> $image
        ]);
    }

    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);

        //?Comentarios y likes asociados a la imagen para eliminar
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($user && $image && $image->user->id == $user->id){
            //?Eliminar comentarios
            if($comments && count($comments)>=1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }
            //?Eliminar likes
            if($likes && count($likes)>=1){
                foreach($likes as $like){
                    $like->delete();
                }
            }
            //?Eliminar ficheros de imagen
            Storage::disk('images')->delete($image->image_path);

            //?Eliminar el registro de la imagen
            $image->delete();
            $message = array('message' => 'La imagen se ha Eliminado');
            
        }else{
            $message = array('message' => 'La imagen No se ha podido Eliminar');
        }
        return redirect()->route('home')->with($message);
    }

    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);

        if($user && $image && $image->user->id == $user->id){
            return view('image.edit', [
                'image' => $image
            ]);
        }else{
            return redirect()->route('home');
        }
    }

    public function update(Request $request){
        //?Validacion
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'image',
        ]);
        //?Recoger datos
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //?Conseguir objeto imagen
        $image = Image::find($image_id);
        $image->description = $description;

        //?subir fichero
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            //?Setear
            $image->image_path = $image_path_name;
        }
        //?Actualizar registro
        $image->update();
        return redirect()->route('image.detail',['id' => $image_id])
        ->with(['message' => 'Publicacion actualizado correctamente']);
    }
}
