<x-app-layout>

    <div class="py-12">        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @component('components.message')
                @endcomponent
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                
                
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    <b><a href="/add_update_item">Dodaj nowy wpis &raquo;</a></b><br/><br/>
                    <br/><br/>
                    @foreach($items as $item)
                    
                    <div class="flex border-t-2 pt-4 border-gray-200">
                        <div class="w-3/5">
                            <u><a href="/item/{{$item->id}}" title="{{$item->subject}}">{{$item->subject}}</a></u>
                        </div>

                        <div class="w-2/5 text-right">
                            {{$item->created_at}} 
                            @auth   
                                @if(Auth::user()->id == $item->users_id || Auth::user()->is_admin)
                                &nbsp;|&nbsp;<a href="/remove_item/{{$item->id}}" onclick="return confirm('Czy na pewno chcesz usunąć wpis?')">Usuń</a>&nbsp;|&nbsp;

                                <a href="/add_update_item/{{$item->id}}">Zmień</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                    
                    <div class="mt-4 mb-4">
                        {{$item->description}}
                    </div>
                    
                    <div class="text-right mb-5 pb-5">
                        @if($item->user)
                        <b><a href="/profile/{{$item->user->id}}">{{$item->user->name}}</a></b>
                        @endif
                    </div>
                        <div class="ml-4 mb-6">
                            @if(count($item->comments))

                            <b>Komentarze ({!!count($item->comments)!!}):</b><br/><br/>

                                @foreach($item->comments as $comment)

                                <div class="flex">
                                    <div class="w-3/5">{{$comment->subject}}</div> 
                                    <div class="w-2/5 text-right">{{$item->created_at}}
                                    
                                        @auth
                                            @if(Auth::user()->id == $comment->users_id || Auth::user()->is_admin)

                                            &nbsp|&nbsp;<a href="/remove_comment/{{$comment->id}}" onclick="return confirm('Czy na pewno chcesz usunąć komentarz?')">Usuń</a>&nbsp;|&nbsp;

                                            <a href="/item/{{$item->id}}/comment/{{$comment->id}}">Zmień</a>
                                            @endif
                                        @endauth
                                    </div>
                                </div>

                                <div class="mt-4">
                                    {{$comment->description}}
                                </div>
                                
                                
                                @if($comment->user)
                                <div class="text-right mb-4">
                                    <b><a href="/profile/{{$comment->user->id}}" title="Profil">{{$comment->user->name}}</a></b>
                                </div>
                                @endif
                                    
                                    
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                    
                </div>                              
            </div>
            
                <div class="pt-4">
                    {{$items->links()}}
                </div>
        </div>
    </div>    
</x-app-layout>
