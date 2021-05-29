<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                   
                    @if(count($comments))
                    
                        <div class="mb-4"><b>Komentarze do profilu {{$user->name}}:</b></div>
                    
                        @foreach($comments as $comment)
                        
                        <div class="flex">
                            <div class="w-3/5">{{$comment->subject}}</div>
                            <div class="w-2/5 text-right">{{$comment->created_at}}
                                
                                    @if(Auth::user()->id == $comment->users_id || Auth::user()->is_admin)
                                    &nbsp|&nbsp;<a href="/remove_comment/{{$comment->id}}" onclick="return confirm('Czy na pewno chcesz usunąć komentarz?')">Usuń</a>&nbsp;|&nbsp;

                                    <a href="/profile/{{$user->id}}/comment/{{$comment->id}}">Zmień</a>
                                    @endif
                            </div>
                        </div>
                        <div class="mt-4 mb-4">
                                {{$comment->description}}
                        </div>
                        
                        <div class="text-right mb-4 pb-4 border-b border-gray-200">
                                <b><a href="/profile/{{$comment->user->id}}">{{$comment->user->name}}</a></b>
                        </div>

                        @endforeach
                    @else
                        Użytkownik <b>{{$user->name}}</b> nie posiada komentarzy do swojego profilu.
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
                        <textarea style="resize:none;" class="w-full" name="description" id="description">@if($userComment){{$userComment->description}}@else{{old('description')}}@endif</textarea><br/><br/>
                        </div>
                        
                        <div class="text-right">
                            <input class="p-2" type="submit" value="Zapisz" />
                        </div>
                        <input type="hidden" value="{{$user->id}}" name="user_id" />
                        
                        <input type="hidden" value="@if($userComment){{$userComment->id}}@endif" name="comments_id" />
                        @csrf
                    </form>
                </div>
            </div>
            
            <div class="pt-4">
           {{$comments->links()}}
            </div>
        </div>
    </div>
</x-app-layout>
