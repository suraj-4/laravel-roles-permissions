<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles / Edit
            </h2>
            <a href="{{Route ('roles.index')}}" class="bg-slate-700 text-white text-sm rounded-md px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('roles.update',$role->id)}}" method="POST">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                 <input type="text" value="{{old ('name', $role->name)}}" name="name" class="border-grey-300 shadow-sm w-1/2 rounded-lg" placeholder="Role name">
                                 @error('name')
                                    <p class="text-red-400 font-sm">{{$message}}</p>
                                 @enderror
                            </div>
                            <div class="grid grid-cols-4">
                            @if ($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)            
                                <div class="my-3">
                                    <input {{ ($hasPermissions->contains($permission->name)) ? 'checked' : '' }} type="checkbox" class="rounded" name="permission[]" id="permission-{{ $permission->id }}" value="{{ $permission->name }}">
                                    <label for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                                @endforeach
                            @endif
                            </div>

                            <button class="bg-slate-700 text-white text-sm rounded-md px-5 py-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
