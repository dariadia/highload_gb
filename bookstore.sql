CREATE DATABASE bookshop ENCODING = 'UTF8' LC_COLLATE = 'English_United States.1252' LC_CTYPE = 'English_United States.1252';


ALTER DATABASE bookshop OWNER TO postgres;

\connect bookshop

CREATE TYPE public.book_rating AS ENUM (
    'G',
    'PG',
    'PG-13',
    'R',
    'NC-17'
);


ALTER TYPE public.book_rating OWNER TO postgres;


CREATE FUNCTION public.book_in_stock(p_book_id integer, p_store_id integer, OUT p_book_count integer) RETURNS SETOF integer
    LANGUAGE sql
    AS $_$
     SELECT inventory_id
     FROM inventory
     WHERE book_id = $1
     AND store_id = $2
     AND inventory_in_stock(inventory_id);
$_$;


ALTER FUNCTION public.book_in_stock(p_book_id integer, p_store_id integer, OUT p_book_count integer) OWNER TO postgres;

--
-- Name: book__not_in_stock(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.book__not_in_stock(p_book_id integer, p_store_id integer, OUT p_book_count integer) RETURNS SETOF integer
    LANGUAGE sql
    AS $_$
    SELECT inventory_id
    FROM inventory
    WHERE book_id = $1
    AND store_id = $2
    AND NOT inventory_in_stock(inventory_id);
$_$;


ALTER FUNCTION public.book__not_in_stock(p_book_id integer, p_store_id integer, OUT p_book_count integer) OWNER TO postgres;
