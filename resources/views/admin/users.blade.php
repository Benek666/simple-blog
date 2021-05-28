<x-app-layout>

    <div class="py-12">        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @component('components.message')
            @endcomponent
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <form method="get" action="{{route('users')}}">
                    <span class="p-4 m-2">Użytkownicy:</span>
                    <select name="rows" class="p-4 m-2 border-gray-300">
                        <option value="0" @if((Request::has('rows') && Request::get('rows') == 0) || !Request::has('rows')) selected="selected" @endif>Aktywni</option>
                        <option value="1" @if(Request::has('rows') && Request::get('rows') == 1) selected="selected" @endif>Wszyscy</option>
                        <option value="2" @if(Request::has('rows') && Request::get('rows') == 2) selected="selected" @endif>Usunięci</option>
                    </select>
                    <input type="submit" value="Szukaj" class="p-4 m-2" />
                </form>
                
                
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    @if(count($users))
                    <table class="shadow-lg border border-collapse table-fixed text-sm">
                        <tr>
                            {{--<td class="border p-4">id</td>--}}
                            <td class="border p-4">Nazwa</td>
                            <td class="border p-4">Email</td>
                            <td class="border p-4">Administrator</td>
                            <td class="border p-4">Komentarze</td>
                            <td class="border p-4">Data dodania</td>
                            <td class="border p-4">Data edycji</td>
                            <td class="border p-4">Data usunięcia</td>
                        </tr>
                        
                        @foreach($users as $user)
                        <tr @if($user->deleted_at) class="bg-red-200" @endif>
                            {{--<td class="border p-4"><a href="{{route('user', $user->id)}}">{{$user->id}}</a></td>--}}
                            <td class="border p-4"><a href="{{route('user', $user->id)}}">{{$user->name}}</a></td>
                            <td class="border p-4">{{$user->email}}</td>
                            <td class="border p-4">@if($user->is_admin)tak @else nie @endif</td>
                            <td class="border p-4"><a href="{{route('comments', [$user->id, 0])}}">{{$user->comments->count()}}</a></td>
                            <td class="border p-4">{{$user->created_at}}</td>
                            <td class="border p-4">{{$user->updated_at}}</td>
                            <td class="border p-4">@if($user->deleted_at)<a href="{{route('restore_user', $user->id)}}" onclick="return confirm('Czy przywrócić użytkownika?')">{{$user->deleted_at}}<br/>przywróć</a>@else<a href="{{route('remove_user', $user->id)}}" onclick="return confirm('Czy usunąć użytkownika?')">usuń</a>@endif</td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                        Brak użytkowników!
                    @endif
                </div>                              
            </div>
            <div class="mt-2">
                {{$users->links()}}
            </div>
        </div>
    </div>    
</x-app-layout>
