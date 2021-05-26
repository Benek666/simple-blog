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

                                {{$comment->subject}} {{$comment->created_at}}<br/><br/>

                                {{$comment->description}}<br/><br/>

                                <b><a href="/profile/{{$comment->user->id}}">{{$comment->user->name}}</a></b><br/>

                            <hr/>

                        @endforeach
                    @else
                        Wpis nie posiada komentarzy.
                    @endif
                </div>
                
               
            </div>
            
           {{$comments->links()}}
        </div>
    </div>
</x-app-layout>
