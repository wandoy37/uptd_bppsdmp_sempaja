<?php

namespace App\Http\Controllers;

use App\Models\TentangKami;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class TentangKamiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aboutUs = TentangKami::latest()->paginate(10);
        return view('dashboard.tentang_kami.index', compact('aboutUs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.tentang_kami.create');
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
                'status' => 'required'
            ],
            [
                'thumbnail.mimes' => 'Thumbnail harus berupa file bertipe: png.',
            ],
        );

        // If failur validate
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // If Success
        DB::beginTransaction();
        try {
            // This Process File/Image
            if ($request['thumbnail']) {
                // Make Directory
                $path = public_path() . '/uploads/image/';
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0775, true, true);
                }
                // New Thumbnail
                $image = $request['thumbnail'];
                $imageName = Str::slug($request->title, '-') . '-' . date('Y-m-d') . '.' . $image->getClientOriginalExtension();
                // Resize Image
                $thumbnail = image::make($image->getRealPath())->resize(400, 400);
                // Save Image
                $thumbPath = $path . $imageName;
                $thumbnail = Image::make($thumbnail)->save($thumbPath);
            }

            TentangKami::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-') . '-' . date('Y-m-d'),
                'thumbnail' => $imageName ?? 'no-image.png',
                'content' => $request->content,
                'status' => $request->status,
            ]);
            return redirect()->route('dashboard.tentang_kami.index')->with('success', $request->title . ' berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.tentang_kami.index')->with('fails', $request->title . ' gagal ditambahkan.');
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
        $about = TentangKami::where('slug', $slug)->first();
        // return response()->json($about);
        return view('dashboard.tentang_kami.edit', compact('about'));
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
                'status' => 'required'
            ],
            [
                'thumbnail.mimes' => 'Thumbnail harus berupa file bertipe: png.',
            ],
        );

        // If failur validate
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // If Success
        DB::beginTransaction();
        try {
            // Get this data
            $about = TentangKami::where('slug', $slug)->first();

            // This Process File/Image
            if ($request['thumbnail']) {
                // Make Directory
                $path = public_path() . '/uploads/image/';
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0775, true, true);
                }
                // Old Thumbnail
                $oldThumbnail = $about->thumbnail;
                File::delete($path, $oldThumbnail);
                // New Thumbnail
                $image = $request['thumbnail'];
                $imageName = Str::slug($request->title, '-') . '-' . date('Y-m-d') . '.' . $image->getClientOriginalExtension();
                // Resize Image
                $thumbnail = image::make($image->getRealPath())->resize(400, 400);
                // Save Image
                $thumbPath = $path . $imageName;
                $thumbnail = Image::make($thumbnail)->save($thumbPath);
            }

            $about->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-') . '-' . date('Y-m-d'),
                'thumbnail' => $imageName ?? $about->thumbnail,
                'content' => $request->content,
                'status' => $request->status,
            ]);
            return redirect()->route('dashboard.tentang_kami.index')->with('success', $request->title . ' berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.tentang_kami.index')->with('fails', $request->title . ' gagal ditambahkan.');
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
            $about = TentangKami::where('slug', $slug)->first();
            $path = public_path() . '/uploads/image/';
            File::delete($path . $about->thumbnail);

            $about->delete($about);
            return redirect()->route('dashboard.tentang_kami.index')->with('success', 'Delete has ben successfuly');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.tentang_kami.index')->with('fail', 'Delete has ben fails');
        } finally {
            DB::commit();
        }
    }

    private function statuses()
    {
        return [
            'publish' => 'publish',
            'draft' => 'draft'
        ];
    }
}
