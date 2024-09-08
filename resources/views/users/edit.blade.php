<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User / Edit
            </h2>
            <a href="{{Route ('users.index')}}" class="bg-slate-700 text-white text-sm rounded-md px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('users.update',$user->id)}}" method="POST">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                 <input type="text" value="{{old ('name', $user->name)}}" name="name" class="border-grey-300 shadow-sm w-1/2 rounded-lg" placeholder="Name">
                                 @error('name')
                                    <p class="text-red-400 font-sm">{{$message}}</p>
                                 @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                 <input type="email" value="{{old ('email', $user->email)}}" name="email" class="border-grey-300 shadow-sm w-1/2 rounded-lg" placeholder="Email">
                                 @error('email')
                                    <p class="text-red-400 font-sm">{{$message}}</p>
                                 @enderror
                            </div>

                            <div class="grid grid-cols-4">
                            @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)            
                                <div class="my-3">
                                    <input {{ ($hasRole->contains($role->id)) ? 'checked' : '' }} type="checkbox" class="rounded" name="role[]" id="role-{{ $role->id }}" value="{{ $role->name }}">
                                    <label for="role-{{ $role->id }}">{{ $role->name }}</label>
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
