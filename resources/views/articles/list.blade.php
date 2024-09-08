<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Articles') }}
            </h2>
            <a href="{{Route ('article.create')}}" class="bg-slate-700 text-white text-sm rounded-md px-3 py-2">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-4 px-4 border-b border-gray-300 text-left" width="50">ID</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left">Title</th>
                            <!-- <th class="py-4 px-4 border-b border-gray-300 text-left">Description</th> -->
                            <th class="py-4 px-4 border-b border-gray-300 text-left">Author</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left" width="160">Created At</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left" width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($articles->isNotEmpty())
                            @foreach ($articles as $article)                         
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-4 border-b border-gray-300">{{$article->id}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">{{$article->title}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">{{$article->author}}</td>
                                <!-- <td class="py-4 px-4 border-b border-gray-300">{{$article->description}}</td> -->
                                <td class="py-4 px-4 border-b border-gray-300">
                                     {{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y') }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    <a href="{{Route ('article.edit', $article->id)}}" class="bg-green-700 text-white text-sm rounded-md px-3 py-2 hover:bg-green-600">Edit</a>
                                    <a href="javascript:void(0)"onclick="deleteArticle( {{ $article->id }} )" class="bg-red-700 text-white text-sm rounded-md px-3 py-2 hover:bg-red-600">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">

                </div>
            </div>

        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">
            function deleteArticle(id){
                if (confirm("Are you sure you want to delete ?")){
                    $.ajax({
                        url: '{{route("article.delete")}}',
                        type : 'delete',
                        data : {id: id},
                        dataType : 'json',
                        headers : {
                            'x-csrf-token': '{{csrf_token()}}'
                        },
                        success : function(response) {
                            window.location.reload();
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
