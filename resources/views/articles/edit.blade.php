<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Article / Create
            </h2>
            <a href="{{Route ('article.index')}}" class="bg-slate-700 text-white text-sm rounded-md px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('article.update', $article->id)}}" method="POST">
                        @csrf
                        <div>
                            <label for="title" class="text-lg font-medium">Title</label>
                            <div class="my-3">
                                 <input type="text" value="{{old ('title', $article->title)}}" name="title" id="title" class="border-grey-300 shadow-sm w-1/2 rounded-lg" placeholder="Title here">
                                 @error('title')
                                    <p class="text-red-400 font-sm">{{$message}}</p>
                                 @enderror
                            </div>
                            <label for="description" class="text-lg font-medium">Description</label>
                            <div class="my-3">
                                 <textarea value="{{old ('description')}}" name="description" id="description" class="border-grey-300 shadow-sm w-1/2 rounded-lg" placeholder="Description here" rows="10" cols="3">
                                 {{$article->description}}
                                 </textarea>
                                 @error('description')
                                    <p class="text-red-400 font-sm">{{$message}}</p>
                                 @enderror
                            </div>
                            <label for="author" class="text-lg font-medium">Author</label>
                            <div class="my-3">
                                 <input type="text" value="{{old ('author', $article->author)}}" name="author" id="author" class="border-grey-300 shadow-sm w-1/2 rounded-lg" placeholder="Author here">
                                 @error('author')
                                    <p class="text-red-400 font-sm">{{$message}}</p>
                                 @enderror
                            </div>
                            <button class="bg-slate-700 text-white text-sm rounded-md px-5 py-3 mt-4">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
