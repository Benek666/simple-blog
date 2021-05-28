<x-app-layout>

    <div class="py-12">        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @component('components.message')
            @endcomponent
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                          
                <form method="get" action="{{route('comments', [$obj->id, $isItem])}}">
                     <span class="p-4 m-2">Komentarze</span>
                    <select name="rows" class="p-4 m-2 border-gray-300">
                        <option value="0" @if((Request::has('rows') && Request::get('rows') == 0) || !Request::has('rows')) selected="selected" @endif>Aktywne</option>
                        <option value="1" @if(Request::has('rows') && Request::get('rows') == 1) selected="selected" @endif>Wszystkie</option>
                        <option value="2" @if(Request::has('rows') && Request::get('rows') == 2) selected="selected" @endif>Usunięte</option>
                    </select>
                    <input type="submit" value="Szukaj" class="p-4 m-2" />
                </form>
                
                
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    
                    @if($obj->comments->count()) 
                    <table class="shadow-lg border border-collapse table-fixed text-sm">
                        <caption class="text-left pb-4 text-lg"><b>
                                
                                @if($isItem)
                                Komentarze do wpisu <a href="{{route('item', $obj->id)}}">{{$obj->subject}}</a>
                                @else
                                Komentarze do profilu <a href="{{route('user', $obj->id)}}">{{$obj->name}}</a>
                                @endif
                                
                            </b></caption>
                        <tr>
                            {{--<td class="border p-4">id</td>--}}
                            <td class="border p-4">Tytuł</td>
                            <td class="border p-4">Opis</td>
                            <td class="border p-4">Data dodania</td>
                            <td class="border p-4">Data edycji</td>
                            <td class="border p-4">Data usunięcia</td>
                            <td class="border p-4">Dodał</td>
                        </tr>
                        
                        @foreach($comments as $comment)
                        <tr>
                            {{--<td class="border p-4"><a href="{{route('comment', $comment->id)}}">{{$comment->id}}</a></td>--}}
                            <td class="border p-4"><a href="{{route('comment', $comment->id)}}">{{$comment->subject}}</a></td>
                            <td class="border p-4">{{substr($comment->description, 0, 15)}}</td>
                            <td class="border p-4">{{$comment->created_at}}</td>
                            <td class="border p-4">{{$comment->updated_at}}</td>
                            <td class="border p-4">@if($comment->deleted_at)<a href="{{route('restore_comment', $comment->id)}}" onclick="return confirm('Czy przywrócić komentarz?')">{{$comment->deleted_at}}<br/>przywróć</a>@else<a href="{{route('remove_comment', $comment->id)}}" onclick="return confirm('Czy usunąć komentarz?')">usuń</a>@endif</td>
                            <td class="border p-4">@if($comment->user){{$comment->user->name}}@else usunięty @endif</td>
                        </tr>
                        
                        @endforeach
                    </table>
                    @else
                    Wpis <a href="{{route('item', $obj->id)}}">{{$obj->subject}}</a> nie posiada komentarzy!
                    @endif
                </div>                              
            </div>
                {{$comments->links()}}
        </div>
    </div>    
</x-app-layout>
