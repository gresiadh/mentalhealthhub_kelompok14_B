@extends('admin.layouts.app')

@section('content')
    <a href="{{ url('admin/blogs/create') }}"
        class="bg-indigo-500 hover:bg-indigo-600 relative shadow-xl rounded-md p-2 mb-12 lg:mb-3 text-gray-100">
        Add Blog
    </a>
    <h3 class="mt-6 text-3xl">Blogs</h3>
    <div class="flex flex-col mt-6">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 rounded-md shadow-md">
                    <table class="min-w-full overflow-x-scroll divide-y divide-gray-200" id="blogs_tbl">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-sm font-medium tracking-wider text-left text-gray-500">
                                    Title
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-sm font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Slug
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-sm font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Thumbnail
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-sm font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Date Created
                                </th>
                                <th scope="col"
                                    class="relative px-6 py-3 text-sm font-medium tracking-wider text-left text-gray-500 uppercase">
                                    <span>Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#blogs_tbl').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url('/admin/blogs/fetch') !!}',
                language: {
                    searchPlaceholder: "Search blogs..."
                },
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'thumbnail',
                        name: 'thumbnail',
                        orderable: false,
                        render: function(data) {
                            return data;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endsection
