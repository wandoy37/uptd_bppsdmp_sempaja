<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\CategoryBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use PhpParser\Node\Stmt\Return_;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beritas = Berita::orderBy('created_at', 'DESC')->paginate(20);
        return view('dashboard.berita.index', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CategoryBerita::latest()->get();
        return view('dashboard.berita.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validator
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'content' => 'required',
                'thumbnail' => 'mimes:png',
                'category' => 'required',
                'status' => 'required',
            ],
            [
                'thumbnail.mimes' => 'Thumbnail harus berupa file bertipe: png.'
            ],
        );

        // If failur validate
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {

            // == Succesfuly Validator, Next
            if ($request['thumbnail']) {
                $image = $request['thumbnail'];
                $imageName = Str::slug($request->title, '-') . '-' . date('Y-m-d') . '.' . $image->getClientOriginalExtension();
                // Resize Image
                $thumbnail = image::make($image->getRealPath())->resize(600, 450);
                // Make Directory
                $path = public_path() . '/uploads/berita/';
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0775, true, true);
                }
                // Save Image
                $thumbPath = $path . '/' . $imageName;
                $thumbnail = Image::make($thumbnail)->save($thumbPath);
            }

            Berita::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-') . '-' . date('Y-m-d'),
                'content' => $request->content,
                'thumbnail' => $imageName ?? 'no-image.png',
                'status' => $request->status,
                'author_id' => Auth::user()->id,
                'category_id' => $request->category,
            ]);
            return redirect()->route('dashboard.berita.index')->with('success', 'Berhasil menambahkan berita');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.berita.index')->with('fails', 'Gagal menambahkan berita');
        } finally {
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        $categories = CategoryBerita::latest()->get();
        return view('dashboard.berita.edit', compact('berita', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        // Validator
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'content' => 'required',
                'thumbnail' => 'mimes:png',
                'category' => 'required',
                'status' => 'required',
            ],
            [
                'thumbnail' => 'Thumbnail harus berupa file bertipe: png.'
            ],
        );

        // If failur validate
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            // Get this berita
            $berita = Berita::where('slug', $slug)->first();

            // == Succesfuly Validator, Next
            if ($request['thumbnail']) {
                // Make Directory
                $path = public_path() . '/uploads/berita/';
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0775, true, true);
                }

                // Old Thumbnail
                $oldThumbnail = $berita->thumbnail;
                File::delete($path, $oldThumbnail);

                // New Thumbnail
                $image = $request['thumbnail'];
                $imageName = Str::slug($request->title, '-') . '-' . date('Y-m-d') . '.' . $image->getClientOriginalExtension();
                // Resize Thumbnail
                $thumbnail = image::make($image->getRealPath())->resize(600, 450);

                // Save Thumbnail
                $thumbPath = $path . $imageName;
                $thumbnail = Image::make($thumbnail)->save($thumbPath);
            }

            $berita->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-') . '-' . date('Y-m-d'),
                'content' => $request->content,
                'thumbnail' => $imageName ?? $berita->thumbnail,
                'status' => $request->status,
                'author_id' => Auth::user()->id,
                'category_id' => $request->category,
            ]);
            return redirect()->route('dashboard.berita.index')->with('success', 'Berhasil update berita');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.berita.index')->with('fails', 'Gagal update berita');
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        DB::beginTransaction();
        try {
            $berita = Berita::where('slug', $slug)->first();

            // Delete Thumbnail
            $path = public_path() . '/uploads/berita/';
            File::delete($path . '/' . $berita->thumbnail);

            $berita->delete($berita);
            return redirect()->route('dashboard.berita.index')->with('success', 'Berhasil delete berita');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.berita.index')->with('fails', 'Gagal delete berita');
        } finally {
            DB::commit();
        }
    }
}
