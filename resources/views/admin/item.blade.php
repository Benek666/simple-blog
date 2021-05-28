<x-app-layout>

    <div class="py-12">        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @component('components.message')
            @endcomponent
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                
                
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    <b>Edytuj wpis</b><br/><br/>
                    
                        <form method="POST" action="{{route('update_item', 1)}}">

                            
                                <div class="w-1">
                                    <label for="subject">Temat</label><br/>
                                    <input id="subject" name="subject" type="text" value="@if($item) {{$item->subject}} @else{{old('subject')}}@endif" /><br/><br/>
                                </div>

                                <div class="w-1">
                                    <label for="description">Opis</label><br/>
                                    <textarea cols="50" rows="10" name="description" id="description">@if($item) {{$item->description}} @else{{old('description')}}@endif</textarea><br/><br/>
                                </div>
                            
                            
                            <div class="text-right">
                                <input type="submit" value="Zapisz" class="p-3"/>
                            </div>
                        
                        <input type="hidden" value="{{$item->id}}" name="item_id" />

                        @csrf
                    </form>
                    
                </div>                              
            </div>

        </div>
    </div>    
</x-app-layout>
