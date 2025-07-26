<x-app-layout>
<h2 class="text-xl font-bold mb-4">All User Time Logs</h2>

<table class="w-full border">
    <thead>
        <tr>
            <th class="border px-4 py-2">User</th>
            <th class="border px-4 py-2">Clock In</th>
            <th class="border px-4 py-2">Clock Out</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($timeLogs as $log)
            <tr>
                <td class="border px-4 py-2">{{ $log->user->name }}</td>
                <td class="border px-4 py-2">{{ $log->clock_in_time }}</td>
                <td class="border px-4 py-2">{{ $log->clock_out_time ?? 'Still Clocked In' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</x-app-layout>