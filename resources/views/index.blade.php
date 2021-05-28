<x-app-layout>

    <div class="py-12">        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @component('components.message')
                @endcomponent
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                
                
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    <b><a href="/add_update_item">Dodaj nowy wpis &raquo;</a></b><br/><br/>
                    <hr/><br/><br/>
                    @foreach($items as $item)
                    
                    <u><a href="/item/{{$item->id}}" title="{{$item->subject}}">{{$item->subject}}</a></u> {{$item->created_at}} 
                    
                        @auth   
                            @if(Auth::user()->id == $item->users_id || Auth::user()->is_admin)
                            &nbsp|&nbsp;<a href="/remove_item/{{$item->id}}" onclick="return confirm('Czy na pewno chcesz usunąć wpis?')">Usuń</a>&nbsp;|&nbsp;
                            
                            <a href="/add_update_item/{{$item->id}}">Zmień</a>
                            @endif
                        @endauth
                        <br/><br/>
                    
                        {{$item->description}}<br/><br/>
                        
                        @if($item->user)
                        <b><a href="/profile/{{$item->user->id}}">{{$item->user->name}}</a></b><br/><br/>
                        @endif
                        <hr/>
                        
                        @foreach($item->comments as $comment)
                        
                            {{$comment->subject}} {{$item->created_at}}<br/><br/>
                            
                            {{$comment->description}}<br/><br/>
                            
                            @if($comment->user)
                            <b><a href="/profile/{{$comment->user->id}}" title="Profil">{{$comment->user->name}}</a></b><br/>
                            @endif
                        @endforeach
                        
                        <hr/>
                        
                    @endforeach
                    
                </div>                              
            </div>
            
            {{$items->links()}}
        </div>
    </div>    
</x-app-layout>
