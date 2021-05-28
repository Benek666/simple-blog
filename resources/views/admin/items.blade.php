<x-app-layout>

    <div class="py-12">        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @component('components.message')
            @endcomponent
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <form method="get" action="{{route('items')}}">
                    
                    <span class="p-4 m-2">Wpisy:</span>
                    <select name="rows" class="p-4 m-2 border-gray-300">
                        <option value="0" @if((Request::has('rows') && Request::get('rows') == 0) || !Request::has('rows')) selected="selected" @endif>Aktywne</option>
                        <option value="1" @if(Request::has('rows') && Request::get('rows') == 1) selected="selected" @endif>Wszystkie</option>
                        <option value="2" @if(Request::has('rows') && Request::get('rows') == 2) selected="selected" @endif>Usunięte</option>
                    </select>
                    <input type="submit" value="Szukaj" class="p-4 m-2" />
                </form>
                
                
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    <table class="shadow-lg border border-collapse table-fixed text-sm">
                        <tr>
                            {{-- <td class="border p-4 border ">id</td>--}}
                            <td class="border p-4 border ">Tytuł</td>
                            <td class="border p-4 border ">Opis</td>
                            <td class="border p-4 border ">Komentarze</td>
                            <td class="border p-4 border ">Data dodania</td>
                            <td class="border p-4 border ">Data edycji</td>
                            <td class="border p-4 border ">Data usunięcia</td>
                            <td class="border p-4 border ">Dodał</td>
                        </tr>
                        
                        @foreach($items as $item)
                        <tr @if($item->deleted_at) class="bg-red-200" @endif>
                            {{--<td class="border p-4 border "><a href="{{route('item', $item->id)}}">{{$item->id}}</a></td>--}}
                            <td class="border p-4 border "><a href="{{route('item', $item->id)}}">{{$item->subject}}</a></td>
                            <td class="border p-4 border ">{{substr($item->description, 0, 15)}}</td>
                            <td class="border p-4 border "><a href="{{route('comments', $item->id)}}">{{$item->comments->count()}}</a></td>
                            <td class="border p-4 border ">{{$item->created_at}}</td>
                            <td class="border p-4 border ">{{$item->updated_at}}</td>
                            <td class="border p-4 border ">@if($item->deleted_at)<a href="{{route('restore_item', $item->id)}}" onclick="return confirm('Czy przywrócić wpis?')">{{$item->deleted_at}}<br/>przywróć</a>@else<a href="{{route('remove_item', $item->id)}}" onclick="return confirm('Czy usunąć wpis?')">usuń</a>@endif</td>
                            <td class="border p-4 border ">@if($item->user){{$item->user->name}} @else usunięty @endif</td>
                        </tr>
                        @endforeach
                    </table>
                    
                </div>                              
            </div>
            
            <div class="mt-2">
                {{$items->links()}}
            </div>
        </div>
    </div>    
</x-app-layout>
