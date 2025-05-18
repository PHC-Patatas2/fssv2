-- Find duplicate rooms by name
SELECT name, COUNT(*) as count
FROM rooms
GROUP BY name
HAVING COUNT(*) > 1;
