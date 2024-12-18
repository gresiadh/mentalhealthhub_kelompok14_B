<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;



class BlogController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("admin.blogs.index");
    }


    public function all()
    {
        $blogs = Blog::get();
        return view('blogs.index', compact('blogs'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blogs.detail', compact('blog'));
    }

    public function displayBlogs()
    {
        $data = Blog::orderBy('id', 'DESC'); // Ganti dengan model `Blog` atau nama model terkait.

        return Datatables::of($data)
            ->addColumn('title', function ($blog) {
                return $blog->title; // Pastikan `title` adalah nama kolom di tabel Blog.
            })
            ->addColumn('slug', function ($blog) {
                return $blog->slug; // Pastikan `slug` adalah nama kolom di tabel Blog.
            })
            ->addColumn('thumbnail', function ($blog) {
                return '<img src="' . asset( $blog->thumbnail) . '" alt="Thumbnail" style="width: 50px; height: auto;">'; // Asumsi `thumbnail` berisi path gambar.
            })
            ->addColumn('action', function ($blog) {
                return view('admin.partials.admin_blog_action')->with([
                    'blog' => $blog,
                ]);
            })
            ->editColumn('created_at', function ($blog) {
                return $blog->created_at->format('d/m/Y'); // Format tanggal sesuai kebutuhan.
            })
            ->rawColumns(['thumbnail', 'action']) // Tambahkan `thumbnail` untuk mengizinkan HTML.
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blogs.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
       ]);

        // Tambahkan slug dan user_id
        $validatedData['slug'] = Str::slug($request->title);
        $validatedData['user_id'] = Auth::id(); // Mendapatkan ID pengguna yang sedang login

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            // Ambil file dari request
            $file = $request->file('thumbnail');

            // Tentukan nama file unik (opsional)
            $filename = time() . '-' . $file->getClientOriginalName();

            // Tentukan lokasi penyimpanan (folder 'public/thumbnails')
            $destinationPath = public_path('thumbnails');

            // Pindahkan file ke folder publik
            $file->move($destinationPath, $filename);

            // Simpan path ke database
            $validatedData['thumbnail'] = 'thumbnails/' . $filename;
        }

        // Simpan data ke database
        Blog::create($validatedData);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Blog has been added successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);  // Cari blog berdasarkan ID
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);  // Cari blog berdasarkan ID

        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        // Update data blog
        $blog->title = $request->title;
        $blog->description = $request->description;

        // Jika ada thumbnail baru
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama
            if ($blog->thumbnail && file_exists(public_path($blog->thumbnail))) {
                unlink(public_path($blog->thumbnail));
            }
                  // Ambil file dari request
            $file = $request->file('thumbnail');

            // Tentukan nama file unik (opsional)
            $filename = time() . '-' . $file->getClientOriginalName();

            // Tentukan lokasi penyimpanan (folder 'public/thumbnails')
            $destinationPath = public_path('thumbnails');

            // Pindahkan file ke folder publik
            $file->move($destinationPath, $filename);
            $blog->thumbnail = 'thumbnails/' . $filename;
        }

        $blog->save();  // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Cek jika ada file thumbnail dan hapus dari folder 'public/thumbnails'
        if ($blog->thumbnail && file_exists(public_path($blog->thumbnail))) {
            unlink(public_path($blog->thumbnail));
        }

        // Hapus data blog dari database
        $blog->delete();

        return redirect()->back();

    }
}
