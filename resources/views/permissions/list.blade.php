<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions') }}
            </h2>
            <a href="{{Route ('permissions.create')}}" class="bg-slate-700 text-white text-sm rounded-md px-3 py-2">Create</a>
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
                            <th class="py-4 px-4 border-b border-gray-300 text-left" width="200">Created At</th>
                            <th class="py-4 px-4 border-b border-gray-300 text-left" width="200">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($permissions->isNotEmpty())
                            @foreach ($permissions as $permission)                         
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-4 border-b border-gray-300">{{$permission->id}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">{{$permission->name}}</td>
                                <td class="py-4 px-4 border-b border-gray-300">
                                    <!-- {{$permission->created_at}} -->
                                     {{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    <a href="{{Route ('permissions.edit', $permission->id)}}" class="bg-green-700 text-white text-sm rounded-md px-3 py-2 hover:bg-green-600">Edit</a>
                                    <a href="javascript:void(0)" onclick="deletePermissions( {{ $permission->id }} )" class="bg-red-700 text-white text-sm rounded-md px-3 py-2 hover:bg-red-600">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">
                    {{$permissions->links()}}
                </div>
            </div>

        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">
            function deletePermissions(id){
                if (confirm("Are you sure you want to delete ?")){
                    $.ajax({
                        url: '{{route("permissions.delete")}}',
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
