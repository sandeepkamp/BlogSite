<?php

namespace App\Http\Requests;

use App\Http\Requests\StorePost as StorePostRequest;
use Auth;


use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function store(StorePostRequest $request)
   {
    $data = $request->only('title', 'body');
    $data['slug'] = str_slug($data['title']);
    $data['user_id'] = Auth::user()->id;
    $post = Post::create($data);
    return redirect()->route('edit_post', ['id' => $post->id]);
   }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'title' => 'required|unique:posts',
            'body' => 'require'
        ];
    }
}
