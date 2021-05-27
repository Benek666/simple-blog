@if ($errors->any())
<div class="p-6 bg-white border-b border-gray-200">
    <div class="alert alert-danger">
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
    <div class="alert alert-success">
        <ul>
            {{session()->get('message')}}
        </ul>
    </div>
</div>

@endif