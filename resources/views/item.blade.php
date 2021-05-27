<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    {{$item->subject}} {{$item->created_at}} <br/><br/>
                    
                    {{$item->description}}<br/><br/>

                    <b><a href="/profile/{{$item->user->id}}">{{$item->user->name}}</a></b><br/><br/>

                    <hr/>
                    
                    @if(count($comments))
                    
                        <b>Komentarze do wpisu:</b><br/><br/>
                    
                        @foreach($comments as $comment)

                        {{$comment->id}} - {{$comment->subject}} {{$comment->created_at}}
                        
                        @auth   
                            @if(Auth::user()->id == $comment->users_id || Auth::user()->is_admin)
                            &nbsp|&nbsp;<a href="/remove_comment/{{$comment->id}}" onclick="return confirm('Czy na pewno chcesz usunąć komentarz?')">Usuń</a>&nbsp;|&nbsp;
                            
                            <a href="/item/{{$item->id}}/comment/{{$comment->id}}">Zmień</a>
                            @endif
                        @endauth
                        <br/><br/>
                        
                        
                                {{$comment->description}}<br/><br/>

                                <b><a href="/profile/{{$comment->user->id}}">{{$comment->user->name}}</a></b><br/>

                            <hr/>

                        @endforeach
                    @else
                        Wpis nie posiada komentarzy.
                    @endif
                </div>
                
               @component('components.message')

               @endcomponent
               
                <div class="p-6 bg-white border-b border-gray-200">
                    <b>Dodaj komentarz:</b><br/><br/>
                    
                    <form method="POST" action="@if($userComment) /update_comment @else /add_comment @endif">
                        
                        <label for="subject">Temat</label>
                        <input id="subject" name="subject" type="text" value="@if($userComment){{$userComment->subject}}@else{{old('subject')}}@endif" /><br/><br/>
                        
                        
                        <label for="description">Opis</label>
                        <textarea name="description" id="description">@if($userComment){{$userComment->description}}@else{{old('description')}}@endif</textarea><br/><br/>
                        
                        
                        <input type="submit" value="Zapisz" />
                        
                        <input type="hidden" value="{{$item->id}}" name="item_id" />
                        
                        <input type="hidden" value="@if($userComment){{$userComment->id}}@endif" name="comments_id" />
                        @csrf
                    </form>
                </div>
            </div>
            
           {{$comments->links()}}
        </div>
    </div>
</x-app-layout>
