@if ($errors->any())
<div class="p-6 bg-white border-b border-gray-200">
    <div class="alert alert-danger text-red-600">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

@if(session()->has('message'))
<div class="p-6 bg-white border-b border-gray-200">
    <div class="alert alert-success text-green-600">
            {{session()->get('message')}}
    </div>
</div>

@endif