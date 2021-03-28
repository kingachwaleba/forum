<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
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
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $name
     * @return Factory|View
     */
    public function show($name)
    {
        $user = User::where('name', $name)->first();
        return view('account', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $name
     * @return Factory|View|RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($name)
    {
        $user = User::where('name', $name)->first();

        if (!Auth::check() || $user->id != Auth::user()->id)
            return redirect('home');

        return view('editAccount', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|string
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Gate::denies('update-user', $user))
            abort(403);

        if (!Auth::check() || $user->id != Auth::user()->id)
            return redirect('home');

        $request->validate([
            'name' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'about' => 'nullable|string|min:5|max:100',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:max_width=300,max_height=200,,min_width=50,min_height=50',
        ]);

        $user->name = $request->name;
        $user->about = $request->about;
        $user->gender_id = $request->gender_id;

        // Check if a profile image has been uploaded.
        if ($request->has('user_image')) {
            if ($user->comment_image !== NULL) {
                $image_path = public_path() . $user->user_image;
                // unlink — Deletes a file.
                unlink($image_path);
            }
            // Get image file.
            $image = $request->file('user_image');
            // Make a image name based on user name and current timestamp.
            $name = Str::slug($request->input('name')) . '_' . time();
            // Define folder path.
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension].
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            // Upload image.
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath.
            $user->user_image = $filePath;
        }

        if ($user->save()) {
            return redirect()->route('showUser', $user->name);
        }
        return "Wystąpił błąd.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Gate::denies('delete-user', $user))
            abort(403);

        if (!Auth::check() || $user->id != Auth::user()->id)
            return redirect('home');

        if ($user->delete()) {
            $picture = $user->user_image;

            if ($picture != NULL) {
                $image_path = public_path() . $picture;
                unlink($image_path);
            }

            return redirect()->route('home')->with([
                'success' => true,
                'message_type' => 'success',
                'message' => 'Pomyślnie usunięto użytkownika o nazwie ' . $user->name . '.'
            ]);
        }

        return back()->with([
            'success' => false, 'message_type' => 'danger',
            'message' => 'Wystąpił błąd podczas usuwania użytkownika o nazwie ' . $user->name . '. Spróbuj później.']);
    }

    /**
     * Remove picture from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroyPicture($id)
    {
        $user = User::findOrFail($id);

        if (Gate::denies('delete-user-picture', $user))
            abort(403);

        if (!Auth::check() || $user->id != Auth::user()->id)
            return redirect('home');

        $picture = $user->user_image;

        if ($user->update(['user_image' => NULL])) {
            $image_path = public_path() . $picture;
            unlink($image_path);

            return redirect()->route('editUser', $user->name);
        }
    }
}
