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
                   
                    
                    @if($item->comments->count()) 
                    <table>
                        <caption>Komentarze do wpisu <a href="{{route('item', $item->id)}}">{{$item->subject}}</a></caption>
                        <tr>
                            <td>id</td>
                            <td>Tytuł</td>
                            <td>Opis</td>
                            <td>Data dodania</td>
                            <td>Data edycji</td>
                            <td>Data usunięcia</td>
                            <td>Dodał</td>
                        </tr>
                        
                        @foreach($comments as $comment)
                        <tr>
                            <td><a href="{{route('comment', $comment->id)}}">{{$comment->id}}</a></td>
                            <td><a href="{{route('comment', $comment->id)}}">{{$comment->subject}}</a></td>
                            <td>{{substr($comment->description, 0, 15)}}</td>
                            <td>{{$comment->created_at}}</td>
                            <td>{{$comment->updated_at}}</td>
                            <td>{{$comment->deleted_at}}</td>
                            <td>{{$comment->user->name}}</td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    Wpis <a href="{{route('item', $item->id)}}">{{$item->subject}}</a> nie posiada komentarzy!
                    @endif
                </div>                              
            </div>
                {{$comments->links()}}
        </div>
    </div>    
</x-app-layout>
