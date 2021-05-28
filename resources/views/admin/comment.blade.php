<x-app-layout>

    <div class="py-12">        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

               @component('components.message')

               @endcomponent
               
                <div class="p-6 bg-white border-b border-gray-200">
                    <b>Edytuj komentarz</b><br/><br/>
                    
                    <form method="POST" action="/update_comment">
                        
                        <label for="subject">Temat</label><br/>
                        <input id="subject" name="subject" type="text" value="@if($comment){{$comment->subject}}@else{{old('subject')}}@endif" /><br/><br/>
                        
                        
                        <label for="description">Opis</label><br/>
                        <textarea cols="50" rows="10" name="description" id="description">@if($comment){{$comment->description}}@else{{old('description')}}@endif</textarea><br/><br/>
                        
                        
                        <input type="submit" value="Zapisz" class="p-3" />
                        
                        <input type="hidden" value="{{$comment->id}}" name="comments_id" />
                        <input type="hidden" value="{{$comment->commentable_id}}" name="item_id" />
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>    
</x-app-layout>
