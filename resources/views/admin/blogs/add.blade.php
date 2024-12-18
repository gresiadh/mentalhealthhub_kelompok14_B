@extends('admin.layouts.app')

@section('content')
    <section class="">
        <div>
            <a href="{{ url('admin/blogs') }}"
                class="bg-indigo-500 hover:bg-indigo-600 relative shadow-xl rounded-md p-2 mb-12 lg:mb-3 text-gray-100 my-4">
                Back to Blogs
            </a>
        </div>

        <form method="POST" action="{{ url('/admin/blogs') }}" enctype="multipart/form-data"
            class="mx-auto container max-w-2xl md:w-3/4 shadow-xl">
            @csrf
            <div class="bg-gray-100 p-4 border-t-2 bg-opacity-5 border-indigo-400 rounded-t">
                <h2 class="font-bold text-2xl my-3">Add Blog</h2>
                <hr>
            </div>
            <div class="bg-white space-y-6">
                <!-- Title -->
                <div class="md:inline-flex space-y-4 md:space-y-0 w-full p-4 text-gray-500 items-center">
                    <h2 class="md:w-1/3 max-w-sm mx-auto">Title</h2>
                    <div class="md:w-2/3 max-w-sm mx-auto">
                        <input type="text" name="title"
                            class="w-full focus:outline-none focus:text-gray-600 p-2 border" placeholder="Blog Title"
                            required />
                        @error('title')
                            <span class="text-red-500" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Thumbnail -->
                <div class="md:inline-flex space-y-4 md:space-y-0 w-full p-4 text-gray-500 items-center">
                    <h2 class="md:w-1/3 max-w-sm mx-auto">Thumbnail</h2>
                    <div class="md:w-2/3 max-w-sm mx-auto">
                        <input type="file" name="thumbnail" class="w-full focus:outline-none focus:text-gray-600 p-2"
                            accept="image/*" required />
                        @error('thumbnail')
                            <span class="text-red-500" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Content -->
                <div class="md:inline-flex space-y-4 md:space-y-0 w-full p-4 text-gray-500 items-center">
                    <h2 class="md:w-1/3 max-w-sm mx-auto">Content</h2>
                    <div class="md:w-2/3 max-w-sm mx-auto">
                        <textarea name="description" rows="6" class="w-full focus:outline-none focus:text-gray-600 p-2 border"
                            placeholder="Blog description" required></textarea>
                        @error('description')
                            <span class="text-red-500" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <hr />
                <div class="flex justify-center items-center p-4 text-gray-100">
                    <button
                        class="w-2/5 max-w-sm rounded-md text-center bg-indigo-400 hover:bg-indigo-500 py-2 px-4 inline-flex focus:outline-none shadow-xl">
                        Add Blog
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
