CREATE OR REPLACE FUNCTION hello_world()
RETURNS text
LANGUAGE sql
AS $$
    SELECT 'Hello World from PostgreSQL'::text;
$$;
