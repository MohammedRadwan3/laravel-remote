<?php

namespace App\Http\Controllers\Nami\Command;

use App\Services\Nami\CommandTerminalService as objService;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Http\Controllers\Controller;

class TerminalController extends Controller
{

    public string $folderPath = "nami.terminal";

    public function index(objService $service) {
        $data["bladeTitle"] = __("auth.Server Terminal");
        $data["commands"] = $service->get();
        return view($this->folderPath . '.terminal', $data);
    }

    public function store(Request $request)
    {
        $command = $request->input('command');

        // Allow a wider range of commands (example)
        // $allowedCommands = ['ls', 'pwd', 'whoami', 'df', 'free', 'uptime', 'php'];
        // $explodedCommand = explode(' ', $command);
        // if (!in_array($explodedCommand[0], $allowedCommands)) {
            // return response()->json(['output' => 'Command not allowed'], 403);
        // }

        $process = Process::fromShellCommandline($command, base_path());
        $process->setTimeout(3600); // Set timeout to 1 hour if needed
        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json(['output' => 'Command failed: ' . $process->getErrorOutput()], 500);
        }

        $output = $process->getOutput();

        return response()->json(['output' => $output]);
    }



    // public function executeCommand(Request $request)
    // {
    //     $command = $request->input('command');

    //     // Only allow certain commands for security reasons
    //     $allowedCommands = ['ls', 'pwd', 'whoami', 'df', 'free', 'uptime'];
    //     $explodedCommand = explode(' ', $command);
    //     if (!in_array($explodedCommand[0], $allowedCommands)) {
    //         return response()->json(['output' => 'Command not allowed'], 403);
    //     }

    //     $process = new Process(explode(' ', $command));
    //     $process->run();

    //     if (!$process->isSuccessful()) {
    //         throw new ProcessFailedException($process);
    //     }

    //     $output = $process->getOutput();

    //     $pusher = new Pusher(
    //         env('PUSHER_APP_KEY'),
    //         env('PUSHER_APP_SECRET'),
    //         env('PUSHER_APP_ID'),
    //         [
    //             'cluster' => env('PUSHER_APP_CLUSTER'),
    //             'useTLS' => true
    //         ]
    //     );

    //     $pusher->trigger('terminal-channel', 'new-output', ['output' => $output]);

    //     return response()->json(['output' => $output]);
    // }
}
