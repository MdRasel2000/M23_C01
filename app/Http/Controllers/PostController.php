<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        // return Post::all();

        return response()->json([

            'data' =>PostResource::collection($posts),
            'message' => 'success',
            'status' => 200
        ]);

        // return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        // $validator = Validator::make($request->all(), [

        //     'title' => 'required|string|max:255',
        //     'body' => 'required'
        // ]);

        // if ($validator->fails()) {

        //     // return $validator->errors();

        //     return response()->json([

        //         'errors' => $validator->errors(),
        //         'message' => 'validator error',
        //         'status' => 422
        //     ], 422);
        // }

        $data = $request->validated();
        $post = Post::create($data);


        // $post = Post::create([

        //     'title' => $request->title,
        //     'body' => $request->body

        // ]);

        // return $post;

        // return new PostResource($post);


        return response()->json([

            'data' => new PostResource($post),
            'message' => 'post create success',
            'status' => 201
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            // return "post not found";
              return response()->json([
                'message' => 'Post not found',
                'status' => 404
            ], 404);

        }

        return response()->json([

            'data' => new PostResource($post),
            'message' => 'success',
            'status' =>200
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            // return "post not found";

              return response()->json([
                'message' => 'Post not found',
                'status' => 404
            ], 404);
        }

          $data = $request->validated();
          $post->update($data);
    //   $validator = Validator::make($request->all(), [
    //         'title' => 'required|string|max:255',
    //         'body' => 'required',
    //      ]);

    //      if($validator->fails()){
    //          // return $validator->errors();
    //         return response()->json([
    //              'errors' => $validator->errors(),
    //             'message' => 'Validation Error',
    //             'status' => 422
    //        ], 422);
    //     }




        // $post = Post::create([

        //     'title' => $request->title,
        //     'body' => $request->body

        // ]);

        return response()->json([

            'data' => new PostResource($post),
            'message' => 'post update success',
            'status' => 200
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            // return "post not found";
            return response()->json([
                'message' => 'post is not found',
                'status' => 404
            ], 404);
        }

        $post->delete();
        return response()->json([
            'message' => 'post delete success',
            'status' => 200
        ], 200);
    }
}
