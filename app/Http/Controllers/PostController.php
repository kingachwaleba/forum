<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\Traits\UploadTrait;
use PhpParser\Node\Expr\Array_;

class PostController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->simplePaginate(4);

        foreach ($posts as $post)
            $post->message = preg_replace("/\r|\n/", "", $post->message);

        return view('mainPage', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $post = new Post();
        return view('addPost', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return string
     */
    public function store(PostRequest $request)
    {
        if (Auth::user() == null) {
            return redirect('home');
        }

        $post = new Post();

        if (!Auth::check())
            return redirect('home');

        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->message = $request->message;
        if ($request->has('post_image')) {
            $image = $request->file('post_image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')) . '_' . time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $post->post_image = $filePath;
        }

        if ($post->save()) {
            return redirect()->route('show', $post->user->name);
        }
        return "Wystąpił błąd";
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $name
     * @return Factory|View|RedirectResponse
     */
    public function show($name)
    {
        $user = User::where('name', $name)->first();

        if (!Auth::check() || $user->id != Auth::user()->id)
            return redirect('home');

        return view('showPosts', compact('user'));
    }

    /**
     * Display the specified post.
     *
     * @param int $id
     * @param mixed $name
     * @return Factory|View
     */
    public function showPost($id, $name)
    {
        $post = Post::findOrFail($id);

        return view('postForm', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View|RedirectResponse|Redirector
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (!Auth::check() || $post->user_id != Auth::user()->id)
            return redirect('home');

        return view('editPost', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response|string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Gate::denies('update-post', $post))
            abort(403);

        if (!Auth::check() || $post->user_id != Auth::user()->id)
            return redirect('home');

        $post->title = $request->title;
        $post->message = $request->message;
        if ($request->has('post_image')) {
            if ($post->post_image !== NULL) {
                $image_path = public_path() . $post->post_image;
                unlink($image_path);
            }
            $image = $request->file('post_image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')) . '_' . time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $post->post_image = $filePath;
        }

        if ($post->save()) {
            return redirect()->route('show', $post->user->name);
        }
        return "Wystąpił błąd.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Gate::denies('delete-post', $post))
            abort(403);

        if (!Auth::check() || $post->user_id != Auth::user()->id)
            return redirect('home');

        if ($post->delete()) {
            $picture = $post->post_image;

            if ($picture != NULL) {
                $image_path = public_path() . $picture;
                unlink($image_path);
            }

            return redirect()->route('show', $post->user->name)->with([
                'success' => true,
                'message_type' => 'success',
                'message' => 'Pomyślnie usunięto post o tytule' . $post->title . '.'
            ]);
        }

        return back()->with([
            'success' => false, 'message_type' => 'danger',
            'message' => 'Wystąpił błąd podczas usuwania postu o tytule ' . $post->title . '. Spróbuj później.']);
    }

    /**
     * Remove picture from storage.
     *
     * @param int $id
     * @return Factory|View|RedirectResponse|Redirector
     */
    public function destroyPicture($id)
    {
        $post = Post::findOrFail($id);

        if (Gate::denies('delete-post-picture', $post))
            abort(403);

        if (!Auth::check() || $post->user_id != Auth::user()->id)
            return redirect('home');

        $picture = $post->post_image;

        if ($post->update(['post_image' => NULL])) {
            $image_path = public_path() . $picture;
            unlink($image_path);

            return view('editPost', compact('post'));
        }
    }
}
