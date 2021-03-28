<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\UploadTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentRequest $request
     * @param int $id
     * @return RedirectResponse|string
     */
    public function store(CommentRequest $request, $id)
    {
        if (Auth::user() == null) {
            return view('home');
        }

        $comment = new Comment();

        if (!Auth::check())
            return redirect('home');

        $comment->user_id = Auth::user()->id;
        $comment->post_id = $id;
        $comment->message = $request->message;
        if ($request->has('comment_image')) {
            $image = $request->file('comment_image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')) . '_' . time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $comment->comment_image = $filePath;
        }

        if ($comment->save()) {
            return redirect()->route('postForm', ['id' => $id, 'title' => Post::findOrFail($id)->title]);
        }

        return "Wystąpił błąd";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Factory|View|RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        if (!Auth::check() || $comment->user_id != Auth::user()->id)
            return redirect('home');

        return view('editComment', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommentRequest $request
     * @param  int  $id
     * @return RedirectResponse|Response|string
     */
    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if (Gate::denies('update-comment', $comment))
            abort(403);

        if(!Auth::check() || $comment->user_id != Auth::user()->id)
            return redirect('home');

        $comment->message = $request->message;
        if ($request->has('comment_image')) {
            if($comment->comment_image !== NULL) {
                $image_path = public_path() . $comment->comment_image;
                unlink($image_path);
            }
            $image = $request->file('comment_image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')) . '_' . time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $comment->comment_image = $filePath;
        }

        if($comment->save()) {
            return redirect()->route('postForm', ['id' => $comment->post_id, 'title' => Post::findOrFail($comment->post_id)->title]);
        }
        return "Wystąpił błąd.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $name
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($name, $id)
    {
        $comment = Comment::findOrFail($id);
        $post = $comment->post_id;

        if (Gate::denies('delete-comment', $comment))
            abort(403);

        if(!Auth::check() || $comment->user_id != Auth::user()->id)
            return redirect('home');

        if($comment->delete()){
            $picture = $comment->comment_image;

            if($picture != NULL) {
                $image_path = public_path() . $picture;
                unlink($image_path);
            }

            return redirect()->route('postForm', ['id' => $comment->post_id, 'title' => Post::findOrFail($post)->title]);
        }

        return back()->with([
            'success' => false, 'message_type' => 'danger',
            'message' => 'Wystąpił błąd podczas usuwania komentarza o nazwie '. $comment->name .'. Spróbuj później.']);
    }

    /**
     * Remove picture from storage.
     *
     * @param  int  $id
     * @return Factory|View|RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroyPicture($id)
    {
        $comment = Comment::findOrFail($id);

        if (Gate::denies('delete-comment-picture', $comment))
            abort(403);

        if (!Auth::check() || $comment->user_id != Auth::user()->id)
            return redirect('home');

        $picture = $comment->comment_image;

        if($comment->update(['comment_image' => NULL])) {
            $image_path = public_path() . $picture;
            unlink($image_path);

            return view('editComment', compact('comment'));
        }
    }
}
