<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @component('components.message')
                @endcomponent
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                   
                    <div class="flex">
                    
                        <div class="w-4/5"><u>{{$item->subject}}</u></div>
                        <div class="w-1/5 text-right">{{$item->created_at}}</div>
                    </div>    
                        <div class="mt-4 mb-4">
                            {{$item->description}}
                        </div>
                       
                        <div class="text-right">
                            <b><a href="/profile/{{$item->user->id}}">{{$item->user->name}}</a></b><br/><br/>
                        </div>
                    
                    @if(count($comments))
                    
                        <b>Komentarze do wpisu ({{count($comments)}}):</b><br/><br/>
                    
                        @foreach($comments as $comment)

                        <div class="flex">
                            <div class="w-3/5">{{$comment->subject}}</div>
                            <div class="w-2/5 text-right">
                                {{$comment->created_at}}
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
                        
                        <div class="text-right pb-4 mb-4 border-b border-gray-200">
                                <b><a href="/profile/{{$comment->user->id}}">{{$comment->user->name}}</a></b><br/>
                        </div>
                            

                        @endforeach
                    @else
                        Wpis nie posiada komentarzy.
                    @endif
                </div>
                
               @component('components.message')

               @endcomponent
               
                <div class="p-6 bg-white">
                    <b>Dodaj komentarz:</b><br/><br/>
                    
                    <form method="POST" action="@if($userComment) /update_comment @else /add_comment @endif">
                        
                        <div class="w-full">
                            <label for="subject">Temat</label><br/>
                            <input class="w-full" id="subject" name="subject" type="text" value="@if($userComment){{$userComment->subject}}@else{{old('subject')}}@endif" /><br/><br/>
                        </div>
                        
                        <div class="w-full">
                            <label for="description">Opis</label><br/>
                            <textarea class="w-full" style="resize:none;" rows="5" cols="30" name="description" id="description">@if($userComment){{$userComment->description}}@else{{old('description')}}@endif</textarea><br/><br/>
                        </div>
                        
                        <div class="text-right">
                            <input class="p-2" type="submit" value="Zapisz" />
                        </div>
                        <input type="hidden" value="{{$item->id}}" name="item_id" />
                        
                        <input type="hidden" value="@if($userComment){{$userComment->id}}@endif" name="comments_id" />
                        @csrf
                    </form>
                </div>
            </div>
            
            <div class="p-4">
           {{$comments->links()}}
            </div>
        </div>
    </div>
</x-app-layout>
