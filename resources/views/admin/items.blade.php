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
                
                <form method="get" action="{{route('items')}}">
                    Wpisy:
                    <select name="rows">
                        <option value="0" @if((Request::has('rows') && Request::get('rows') == 0) || !Request::has('rows')) selected="selected" @endif>Aktywne</option>
                        <option value="1" @if(Request::has('rows') && Request::get('rows') == 1) selected="selected" @endif>Wszystkie</option>
                        <option value="2" @if(Request::has('rows') && Request::get('rows') == 2) selected="selected" @endif>Usunięte</option>
                    </select>
                    <input type="submit" value="Szukaj" />
                </form>
                
                
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    <table>
                        <tr>
                            <td>id</td>
                            <td>Tytuł</td>
                            <td>Opis</td>
                            <td>Komentarze</td>
                            <td>Data dodania</td>
                            <td>Data edycji</td>
                            <td>Data usunięcia</td>
                            <td>Dodał</td>
                        </tr>
                        
                        @foreach($items as $item)
                        <tr>
                            <td><a href="{{route('item', $item->id)}}">{{$item->id}}</a></td>
                            <td><a href="{{route('item', $item->id)}}">{{$item->subject}}</a></td>
                            <td>{{substr($item->description, 0, 15)}}</td>
                            <td><a href="{{route('comments', $item->id)}}">{{$item->comments->count()}}</a></td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->updated_at}}</td>
                            <td>@if($item->deleted_at)<a href="{{route('restore_item', $item->id)}}" onclick="return confirm('Czy przywrócić wpis?')">{{$item->deleted_at}}<br/>przywróć</a>@else<a href="{{route('remove_item', $item->id)}}" onclick="return confirm('Czy usunąć wpis?')">usuń</a>@endif</td>
                            <td>{{$item->user->name}}</td>
                        </tr>
                        @endforeach
                    </table>
                    
                </div>                              
            </div>
                {{$items->links()}}
        </div>
    </div>    
</x-app-layout>
