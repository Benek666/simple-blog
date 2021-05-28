<x-app-layout>

    <div class="py-12">        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @component('components.message')
            @endcomponent
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                
                
                <div class="p-6 bg-white border-b border-gray-200">
                   
                    <b>Edytuj użytkownika</b><br/><br/>
                    
                        <form method="POST" action="{{route('update_user')}}">

                            <div class="flex">
                                <div class="w-2/5">
                                    <label for="email">Email</label><br/>
                                    <input id="email" name="email" type="text" value="@if($user){{$user->email}}@else{{old('email')}}@endif" /><br/><br/>
                                </div>

                                <div class="w-2/5">
                                    <label for="name">Nazwa</label><br/>
                                    <input id="name" name="name" type="text"  value="@if($user){{$user->name}}@else{{old('name')}}@endif" /><br/><br/>
                                </div>
                            
                                <div class="w-1/5">
                                    <label for="is_admin">Admin</label><br/>
                                    <input id="is_admin" name="is_admin" type="checkbox" @if($user->is_admin) checked="checked" @endif/>
                                </div>

                              
                            </div>
                            
                              <div class="text-right">
                                    <input type="submit" value="Zapisz" class="p-3" />
                                </div>
                            
                            <input type="hidden" value="{{$user->id}}" name="id" />

                        @csrf
                    </form>
                    
                </div>                              
            </div>

        </div>
    </div>    
</x-app-layout>
