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
                    <b>Dodaj nowy wpis</b><br/><br/>
                    
                    <form method="POST" action="@if($item) /update_item @else /add_item @endif">

                        <label for="subject">Temat</label>
                        <input id="subject" name="subject" type="text" value="@if($item) {{$item->subject}} @else{{old('subject')}}@endif" /><br/><br/>


                        <label for="description">Opis</label>
                        <textarea name="description" id="description">@if($item) {{$item->description}} @else{{old('description')}}@endif</textarea><br/><br/>


                        <input type="submit" value="Zapisz" />

                        <input type="hidden" value="@if($item){{$item->id}}@endif" name="item_id" />

                        @csrf
                    </form>
                    </div>
                </div>
            </div>
</div>
    
</x-app-layout>