<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>System Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { margin-top: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { border: 1px solid #333; padding: 6px; font-size: 11px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>System Report</h1>
    <h2>Users</h2>
    <table>
        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($users as $u)
            <tr><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ $u->role }}</td><td>{{ $u->status }}</td></tr>
        @endforeach
        </tbody>
    </table>
    <h2>Schedules</h2>
    <table>
        <thead><tr><th>Subject</th><th>Teacher</th><th>Room</th><th>Day</th><th>Start</th><th>End</th></tr></thead>
        <tbody>
        @foreach($schedules as $s)
            <tr><td>{{ $s->subject->name ?? '' }}</td><td>{{ $s->teacher->name ?? '' }}</td><td>{{ $s->room->name ?? '' }}</td><td>{{ $s->day }}</td><td>{{ $s->start_time }}</td><td>{{ $s->end_time }}</td></tr>
        @endforeach
        </tbody>
    </table>
    <h2>Rooms</h2>
    <table>
        <thead><tr><th>Name</th><th>Capacity</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($rooms as $r)
            <tr><td>{{ $r->name }}</td><td>{{ $r->capacity }}</td><td>{{ $r->status }}</td></tr>
        @endforeach
        </tbody>
    </table>
    <h2>Teachers</h2>
    <table>
        <thead><tr><th>Name</th><th>Email</th><th>Contact</th></tr></thead>
        <tbody>
        @foreach($teachers as $t)
            <tr><td>{{ $t->name }}</td><td>{{ $t->email }}</td><td>{{ $t->contact }}</td></tr>
        @endforeach
        </tbody>
    </table>
    <h2>Subjects</h2>
    <table>
        <thead><tr><th>Name</th><th>Code</th><th>Description</th></tr></thead>
        <tbody>
        @foreach($subjects as $sub)
            <tr><td>{{ $sub->name }}</td><td>{{ $sub->code }}</td><td>{{ $sub->description }}</td></tr>
        @endforeach
        </tbody>
    </table>
    <h2>Recent Activity Logs</h2>
    <table>
        <thead><tr><th>User</th><th>Action</th><th>Description</th><th>Date</th></tr></thead>
        <tbody>
        @foreach($logs as $log)
            <tr><td>{{ $log->username }}</td><td>{{ $log->action }}</td><td>{{ $log->description }}</td><td>{{ $log->created_at }}</td></tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
