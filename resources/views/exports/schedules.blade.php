<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Schedules Grid Export</title>
    <style>
        @page { size: landscape; }
        body { margin: 10px; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #333; padding: 3px 6px; font-size: 12px; text-align: center; word-break: break-word; }
        th { background: #eee; }
        th, td { min-width: 80px; }
    </style>
</head>
<body>
    <h2>Schedule Grid</h2>
    <table>
        <thead>
            <tr>
                <th>Time</th>
                @php $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']; @endphp
                @foreach($days as $day)
                    <th>{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $timeSlots = [];
                for ($h = 7; $h < 18; $h++) {
                    $start = sprintf('%02d:00', $h);
                    $end = sprintf('%02d:30', $h);
                    $timeSlots[] = "$start - $end";
                    $start2 = sprintf('%02d:30', $h);
                    $end2 = sprintf('%02d:00', $h+1);
                    $timeSlots[] = "$start2 - $end2";
                }
            @endphp
            @foreach($timeSlots as $slot)
                <tr>
                    <td><b>{{ $slot }}</b></td>
                    @foreach($days as $day)
                        @php
                            [$start, $end] = explode(' - ', $slot);
                            $slotStart = $start . ':00';
                            $slotEnd = $end . ':00';
                            $has = $schedules->first(function($s) use ($day, $slotStart, $slotEnd) {
                                return $s->day === $day && $s->start_time == $slotStart && $s->end_time == $slotEnd;
                            });
                        @endphp
                        <td @if($has) style="background: #ffff99;" @endif>
                            @if($has)
                                <div><b>{{ $has->subject->name ?? '' }}</b></div>
                                <div>{{ $has->teacher->name ?? '' }}</div>
                                <div style="font-size:10px;">{{ $has->room->name ?? '' }}</div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
