<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
            <a href="javaScript:void(0)" class="bg-slate-700 text-white text-sm rounded-md px-3 py-2">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-4 px-4 border-b border-gray-300 text-left" width="60">ID</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left">Name</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left">Email</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left">Roles</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left" width="200">Created At</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left" width="200">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isNotEmpty())     
                            @foreach ($users as $user)                         
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-4 border-b border-gray-300">{{$user->id}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">{{$user->name}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">{{$user->email}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">{{$user->roles->pluck('name')->implode(', ')}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    <a href="{{ Route ('users.edit', $user->id) }}" class="bg-green-700 text-white text-sm rounded-md px-3 py-2 hover:bg-green-600">Edit</a>
                                    <a href="javascript:void(0)" class="bg-red-700 text-white text-sm rounded-md px-3 py-2 hover:bg-red-600">Delete</a>
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
            
        </script>
    </x-slot>
</x-app-layout>
