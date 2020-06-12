<?php

use Illuminate\Support\Facades\Route;
use App\Image;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    /*
    $images = Image::all();
    foreach($images as $image){
        echo $image->image_path . "<br>";
        echo $image->description . "<br>";
        echo $image->user->name. ' ' .$image->user->surname . "<br>";

        if(count($image->comments) >=1){
        echo "<h3>Comentarios</h3>";
        foreach($image->comments as $comment){
        echo $comment->user->name . $comment->user->surname .": " .$comment->content . "<br>";
        }        
    }
    echo "Likes: ". count($image->likes);
    echo "<hr>";
    }
    
    die();
    */
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//!USUARIO

//?Configuracion Usuario
Route::get('/configuracion', 'UserController@config')->name('config');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');

//?Pefil
Route::get('/perfil/{id}', 'UserController@profile')->name('profile');
Route::get('/personas/{search?}', 'UserController@index')->name('user.index');

//!IMAGEN

//?Imagenes
Route::get('/subir-imagen', 'ImageController@create')->name('image.create');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('/imagen/{id}', 'ImageController@detail')->name('image.detail');

//?Eliminar publicaciones
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');

//?Editar publicacion
Route::get('/image/edit/{id}', 'ImageController@edit')->name('image.edit');
Route::post('/image/update', 'ImageController@update')->name('image.update');

//!COMENTARIOS

//?Comentario
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

//!LIKES

//?Like
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');
Route::get('/likes', 'LikeController@index')->name('likes');














