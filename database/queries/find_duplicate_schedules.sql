-- Find duplicate schedules (same subject, teacher, room, day, start_time, end_time)
SELECT subject_id, teacher_id, room_id, day, start_time, end_time, COUNT(*) as count
FROM schedules
GROUP BY subject_id, teacher_id, room_id, day, start_time, end_time
HAVING COUNT(*) > 1;
