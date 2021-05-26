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
                   
                    @foreach($items as $item)
                    
                        {{$item->subject}} {{$item->created_at}} <br/><br/>
                    
                        {{$item->description}}<br/><br/>
                        
                        <b>({{$item->user->name}})</b><br/><br/>
                        
                        <hr/>
                        
                        @foreach($item->comments as $comment)
                        
                            {{$comment->subject}} {{$item->created_at}}<br/><br/>
                            
                            {{$comment->description}}<br/><br/>
                            
                            <b>{{$comment->user->name}}</b>
                        @endforeach
                        
                        <hr/>
                        
                    @endforeach
                    
                </div>
            </div>
            
            {{$items->links()}}
        </div>
    </div>
</x-app-layout>
