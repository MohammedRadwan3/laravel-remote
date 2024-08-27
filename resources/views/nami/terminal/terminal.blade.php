@extends('admin.layout.indexs.index')
@section("style")
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
        #terminal {
            width: 100%;
            height: 100%;
            /* max-width: 800px; */
            background-color: #2d2d2d;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        #output {
            height: 400px;
            overflow-y: scroll;
            background-color: #1e1e1e;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        #command-select, #command-input {
            width: calc(100% - 90px);
            padding: 10px;
            border: 1px solid #555;
            border-radius: 4px;
            background-color: #1e1e1e;
            color: #d4d4d4;
            display: block;
            margin-bottom: 10px;
        }
        #command-input {
            display: none;
        }
        button {
            padding: 10px 20px;
            border: 1px solid #555;
            border-radius: 4px;
            background-color: #007acc;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #005f99;
        }
        pre {
            margin: 0;
        }
    </style>
@endsection
@section('page-title')
    {{ $bladeTitle }}

@endsection
@section('page-links')
    <li class="breadcrumb-item active" aria-current="page"> {{__("finance.clients")}}</li>
@endsection
@section('content')

    <div id="terminal" style="width:100%">
        <div id="output"></div>
        <select id="command-select" onchange="toggleCommandInput()">
            <option value="">{{ __("auth.Select a command") }}</option>
            @foreach($commands as $command)
                <option value="{{ $command->command }}">{{ $command->command }}</option>
            @endforeach
            <option value="custom">{{ __("auth.Other (type your command)") }}</option>
        </select>
        <input type="text" id="command-input" placeholder="Enter command">
        <button onclick="sendCommand()">{{ __('auth.Execute') }}</button>
    </div>


@endsection
@section('js')
    <script>
        function toggleCommandInput() {
            var select = document.getElementById('command-select');
            var input = document.getElementById('command-input');
            if (select.value === 'custom') {
                input.style.display = 'block';
            } else {
                input.style.display = 'none';
            }
        }

        function sendCommand() {
            var select = document.getElementById('command-select');
            var input = document.getElementById('command-input');
            var command = select.value === 'custom' ? input.value : select.value;

            if (!command) {
                alert('Please select or enter a command');
                return;
            }

            fetch('{{ route('terminal.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ command: command })
            })
            .then(response => response.json())
            .then(data => {
                var outputDiv = document.getElementById('output');
                if (data.output) {
                    outputDiv.innerHTML += '<pre>' + data.output + '</pre>';
                } else {
                    outputDiv.innerHTML += '<pre>Command not allowed</pre>';
                }
                input.value = '';
                select.value = '';
                input.style.display = 'none';
                outputDiv.scrollTop = outputDiv.scrollHeight; // Scroll to bottom of output
            })
            .catch(error => {
                console.error('Error:', error);
                var outputDiv = document.getElementById('output');
                outputDiv.innerHTML += '<pre>Error executing command</pre>';
            });
        }
    </script>
@endsection
