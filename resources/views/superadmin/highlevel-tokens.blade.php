<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('High Level Tokens') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900">

                    <table class="table-fixed w-full mb-12">
                        <tr>
                            <th class="text-left">
                                Client ID
                            </th>
                            <th class="text-left">
                                Client Secret
                            </th>
                            <th class="text-left">Friendly Name</th>
                            <th class="text-left">Actions</th>
                        </tr>
                        @if(count($tokens) > 0)
                            @foreach($tokens as $token)
                                <tr>
                                    <td>
                                        <input type="text" value="{{$token->token}}" readonly>
                                    </td>
                                    <td>
                                        <input type="password" value="{{$token->secret}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" value="{{$token->friendly_name}}" readonly>
                                    </td>
                                    <td>
                                        <a href="/admin/delete-integration-token/{{$token->id}}">
                                            <x-danger-button>
                                                Delete
                                            </x-danger-button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">
                                    No tokens found
                                </td>
                            </tr>
                        @endif
                    </table>


                    <form method="post" action="/admin/store-highlevel-token">
                        <h2>Add new token</h2>
                        @csrf
                        <table>
                            <tr>
                                <td class="mb-4">
                                    <label for="client_id" class="block text-sm font-medium text-gray-700">Client
                                        ID</label>
                                    <input type="text" name="client_id" id="client_id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300
                            rounded-md">
                                </td>
                                <td class="mb-4">
                                    <label for="client_secret" class="block text-sm font-medium text-gray-700">Client
                                        Secret</label>
                                    <input type="text" name="client_secret" id="client_secret" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300
                            rounded-md">
                                </td>
                                <td class="mb-4">
                                    <label for="friendly_name" class="block text-sm font-medium text-gray-700">Friendly
                                        Name</label>
                                    <input type="text" name="friendly_name" id="friendly_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300
                            rounded-md">
                                </td>

                            </tr>
                        </table>
                        <x-primary-button type="submit">
                            Add New Token
                        </x-primary-button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
