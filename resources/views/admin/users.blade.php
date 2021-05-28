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
                
                <form method="get" action="{{route('users')}}">
                    Użytkownicy:
                    <select name="rows">
                        <option value="0" @if((Request::has('rows') && Request::get('rows') == 0) || !Request::has('rows')) selected="selected" @endif>Aktywni</option>
                        <option value="1" @if(Request::has('rows') && Request::get('rows') == 1) selected="selected" @endif>Wszyscy</option>
                        <option value="2" @if(Request::has('rows') && Request::get('rows') == 2) selected="selected" @endif>Usunięci</option>
                    </select>
                    <input type="submit" value="Szukaj" />
                </form>
                
                
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    <table>
                        <tr>
                            <td>id</td>
                            <td>Nazwa</td>
                            <td>Email</td>
                            <td>Administrator</td>
                            <td>Komentarze</td>
                            <td>Data dodania</td>
                            <td>Data edycji</td>
                            <td>Data usunięcia</td>
                        </tr>
                        
                        @foreach($users as $user)
                        <tr>
                            <td><a href="{{route('user', $user->id)}}">{{$user->id}}</a></td>
                            <td><a href="{{route('user', $user->id)}}">{{$user->name}}</a></td>
                            <td>{{$user->email}}</td>
                            <td>@if($user->is_admin)tak @else nie @endif</td>
                            <td><a href="{{route('comments', $user->id)}}">{{$user->comments->count()}}</a></td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td>@if($user->deleted_at)<a href="{{route('restore_user', $user->id)}}" onclick="return confirm('Czy przywrócić użytkownika?')">{{$user->deleted_at}}<br/>przywróć</a>@else<a href="{{route('remove_user', $user->id)}}" onclick="return confirm('Czy usunąć użytkownika?')">usuń</a>@endif</td>
                        </tr>
                        @endforeach
                    </table>
                    
                </div>                              
            </div>
                {{$users->links()}}
        </div>
    </div>    
</x-app-layout>
