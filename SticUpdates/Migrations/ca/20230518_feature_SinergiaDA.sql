REPLACE INTO schedulers (id, deleted, date_entered, date_modified, created_by, modified_user_id, name, job, date_time_start, date_time_end, job_interval, time_from, time_to, last_run, status, catch_up) VALUES
('c5f7d492-5a02-6fe1-1d6e-6540b28a4b21', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Reconstrucció de les fonts de dades de SinergiaDA', 'function::rebuildSDASources', NOW(), NULL, '*::2::*::*::*', NULL, NULL, NULL, 'Active', 0);
