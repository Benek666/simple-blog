<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold text-left text-text-gray-800" style="text-transform: uppercase;">
            <a href="/admin/items">Wpisy</a>&nbsp;|&nbsp;<a href="/admin/users">Użytkownicy</a>
        </h2>
    </x-slot>

    <div class="py-12">        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @component('components.message')
            @endcomponent
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                
                
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    <b>Edytuj użytkownika</b><br/><br/>
                    
                        <form method="POST" action="{{route('update_user')}}">

                        <label for="email">Email</label>
                        <input id="email" name="email" type="text" value="@if($user) {{$user->email}} @else{{old('email')}}@endif" /><br/><br/>

                        <label for="name">Nazwa</label>
                        <input id="name" name="name" type="text" value="@if($user) {{$user->name}} @else{{old('name')}}@endif" /><br/><br/>

                        <label for="is_admin">Admin</label>
                        <input id="is_admin" name="is_admin" type="checkbox" @if($user->is_admin) checked="checked" @endif/>
                        
                        <input type="submit" value="Zapisz" />

                        <input type="hidden" value="{{$user->id}}" name="id" />

                        @csrf
                    </form>
                    
                </div>                              
            </div>

        </div>
    </div>    
</x-app-layout>
