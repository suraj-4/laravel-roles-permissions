<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Role') }}
            </h2>
            <a href="{{Route ('roles.create')}}" class="bg-slate-700 text-white text-sm rounded-md px-3 py-2">Create</a>
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
                            <th class="py-4 px-4 border-b border-gray-300 text-left">Permission</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left" width="200">Created At</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left" width="200">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($roles->isNotEmpty())     
                            @foreach ($roles as $role)                         
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-4 border-b border-gray-300">{{$role->id}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">{{$role->name}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">{{$role->permissions->pluck('name')->implode(', ')}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">
                                    {{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    <a href="{{Route ('roles.edit', $role->id)}}" class="bg-green-700 text-white text-sm rounded-md px-3 py-2 hover:bg-green-600">Edit</a>
                                    <a href="javascript:void(0)" onclick="deleteRole( {{ $role->id }} )" class="bg-red-700 text-white text-sm rounded-md px-3 py-2 hover:bg-red-600">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">
                    {{$roles->links()}}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">
            function deleteRole(id){
                if (confirm("Are you sure you want to delete ?")){
                    $.ajax({
                        url: '{{route("roles.delete")}}',
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
