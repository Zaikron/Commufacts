<html lang="es">
    <head>
        <link rel="shortcut icon" href="{{ asset('images/general/logo.png') }}">
    </head>
</html>

<x-app-layout>
    <div class="justify-center items-center flex bg-gray-100 w-full">
        <div class="grid grid-cols-1 place-items-stretch bg-gray-100 h-auto w-full md:w-11/12 lg:w-3/4 p-4">
            {{-- HECHO --}}
            <div class="text-gray-700 text-center px-4 py-2 m-2">
                <p class="text-3xl font-bold text-orange-800">{{$fact->title}}</p>
            </div>
            <div class="grid grid-cols-2 w-full h-full items-end p-8 bg-white">
                <div class="flex justify-start">
                    <p class="text-lg text-orange-800 font-bold ">
                        {{$fact->country . ', '. $fact->city . '. ' . $fact->created_at}}
                    </p>
                </div>
                <div class="flex justify-end">
                    <p class="text-md text-white bg-gray-700 rounded-full font-bold py-2 px-4">
                        {{$fact->type}}
                    </p>
                </div>
            </div>
            <div class="text-gray-700 text-start bg-white px-8 py-4"> 
                <p class="text-xl text-gray-500 inline">{!! $fact->text !!}</p><br><br>
            </div>
            <div class="grid grid-cols-2 bg-white p-8">
                @foreach ($fact->images as $image)
                <div class="p-4 flex justify-center items-center">
                    <a href="{{ asset('images/facts/' . $image->path) }}" target="_blank">
                        @if(file_exists(storage_path('app/public/images/facts/' . $image->path)))
                            <img src="{{ asset('images/facts/' . $image->path) }}" alt="Fact Image">
                            <img src="{{ Storage::url('images/facts/' . $image->path) }}" alt="Fact Image" class="hidden">
                        @else
                            <img src="{{ Storage::url('images/facts/cel2.jpg') }}" alt="Fact Image" class="hidden">
                            <img src="{{ asset('images/facts/cel2.jpg') }}" alt="Fact Image">
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
            <div class="bg-white w-full p-8">
                <p class="text-md text-gray-600 font-bold inline">Ubicacion exacta: </p> <p class="text-md text-gray-400 inline">{{$fact->address}}</p>
            </div>

            {{-- COMENTARIOS --}}
            <div class="bg-white w-full p-8 mt-4">
                <p class="text-lg text-orange-700 font-bold py-4">{{ $fact->messages->count() }} comentarios en total</p>
                {{-- PUBLICAR COMENTARIO --}}
                <div class="w-full flex">
                    <div class="pr-4">
                        <img class="h-15 w-15 rounded-full my-1 mx-1 border-2 border-gray-400" src="{{ auth()->user()->profile_photo_url }}" alt=""> 
                    </div>

                    <div class="w-11/12">
                        {!! Form::open(['route' => 'messages.store', 'method' => 'POST']) !!}
                        {{ Form::text('text', null, ['id' => 'comment-input', 'class' => 'w-full border-b-gray-600 border-t-transparent border-r-transparent border-l-transparent', 'placeholder' => 'Agrega un comentario...']) }}
                        <div class="w-full flex justify-end py-4">
                            {{ Form::hidden('user_id', auth()->user()->id) }}
                            {{ Form::hidden('fact_id', $fact->id) }}
                            {{ Form::submit('Comentar', ['id' => 'comment-button', 'class' => 'py-2 px-4 bg-orange-800 text-white font-bold rounded-full', 'disabled' => 'true', 'style' => 'cursor: pointer;']) }}
                        </div>
                    {!! Form::close() !!}
                    </div>

                </div><br>

                {{-- MOSTRAR COMENTARIOS--}}
                @foreach ($fact->messages()->latest()->get() as $message)
                    <div class="w-full flex border-l-2">
                        <div class="px-4">
                            <img class="h-10 w-10 rounded-full my-1 mx-1 border-2 border-gray-400" src="{{ $message->users->profile_photo_url }}" alt=""> 
                        </div>

                        <div class="w-11/12">
                            <p class="text-md text-gray-800 font-bold inline">{{ $message->users->name }}</p>
                            <p class="text-sm text-gray-400 font-bold inline">{{ $message->created_at}}</p>
                            <p class="text-md text-gray-700">{{ $message->message }} </p>
                            <p class="text-sm text-orange-700 font-bold mt-2">
                                {{$message->users->country . ', '. $message->users->city}}
                            </p>
                        </div>
                    </div>

                    <br>
                @endforeach
            </div>

        </div>


    </div>


    <script>
        const commentInput = document.getElementById('comment-input');
        const commentButton = document.getElementById('comment-button');
        
        commentInput.addEventListener('input', function() {
            if (commentInput.value.trim() !== '') {
                commentButton.removeAttribute('disabled');
            } else {
                commentButton.setAttribute('disabled', 'true');
            }
        });
    </script>
    
</x-app-layout>