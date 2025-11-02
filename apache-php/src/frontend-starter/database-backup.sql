--
-- PostgreSQL database dump
--

-- Dumped from database version 17.5 (Debian 17.5-1.pgdg110+1)
-- Dumped by pg_dump version 17.5 (Debian 17.5-1.pgdg110+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;


--
-- Name: EXTENSION postgis; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis IS 'PostGIS geometry and geography spatial types and functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: objets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.objets (
    id integer NOT NULL,
    nom character varying(100) NOT NULL,
    type character varying(20) NOT NULL,
    "position" public.geometry(Point,4326),
    zoom_min integer DEFAULT 15,
    icone_url character varying(255),
    code character varying(4),
    objet_bloquant_id integer,
    indice text
);


ALTER TABLE public.objets OWNER TO postgres;

--
-- Name: objets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.objets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.objets_id_seq OWNER TO postgres;

--
-- Name: objets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.objets_id_seq OWNED BY public.objets.id;


--
-- Name: scores; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.scores (
    id integer NOT NULL,
    nom_joueur character varying(100) NOT NULL,
    score integer NOT NULL,
    temps integer NOT NULL,
    date_jeu timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.scores OWNER TO postgres;

--
-- Name: scores_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.scores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.scores_id_seq OWNER TO postgres;

--
-- Name: scores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.scores_id_seq OWNED BY public.scores.id;


--
-- Name: objets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.objets ALTER COLUMN id SET DEFAULT nextval('public.objets_id_seq'::regclass);


--
-- Name: scores id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scores ALTER COLUMN id SET DEFAULT nextval('public.scores_id_seq'::regclass);


--
-- Data for Name: objets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.objets (id, nom, type, "position", zoom_min, icone_url, code, objet_bloquant_id, indice) FROM stdin;
1	Clé du Palais	recuperable	0101000020E61000007B14AE47E13A13407D3F355EBAF94540	15	icones/cle.png	\N	\N	\N
2	Parchemin Codé	code	0101000020E6100000B81E85EB51381340A8C64B3789F94540	15	icones/parchemin.png	1234	\N	\N
3	Coffre du Jardin	bloque_code	0101000020E610000060E5D022DB3913409A99999999F94540	15	icones/coffre.png	\N	\N	Le code est dans le parchemin
4	Cristal Ancien	recuperable	0101000020E6100000B81E85EB51381340EF38454772F94540	15	icones/cristal.png	\N	1	\N
5	Porte Secrète	bloque_objet	0101000020E61000006519E25817371340A8C64B3789F94540	15	icones/porte.png	\N	3	Tu as besoin du cristal ancien
6	Journal d'Adalf	code	0101000020E6100000265305A3923A1340D34D621058F94540	15	icones/journal.png	5678	\N	\N
7	Sceau Papal	recuperable	0101000020E6100000F2B0506B9A371340E17A14AE47F94540	15	icones/sceau.png	\N	4	\N
8	Amulette Magique	bloque_code	0101000020E6100000B5A679C7293A13407DAEB6627FF94540	15	icones/amulette.png	\N	5	Le code est dans le journal
9	Relique Finale	final	0101000020E610000046B6F3FDD4381340D3DEE00B93F94540	15	icones/relique.png	\N	6	Félicitations! Vous avez brisé la malédiction!
10	Carte des Tunnels	recuperable	0101000020E6100000F6285C8FC23513409A081B9E5EF94540	15	icones/carte.png	\N	8	Cette carte révèle les passages secrets
\.


--
-- Data for Name: scores; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.scores (id, nom_joueur, score, temps, date_jeu) FROM stdin;
1	JoueurTest	850	360	2025-11-02 14:19:59.074575
\.


--
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.spatial_ref_sys (srid, auth_name, auth_srid, srtext, proj4text) FROM stdin;
\.


--
-- Name: objets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.objets_id_seq', 10, true);


--
-- Name: scores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.scores_id_seq', 1, true);


--
-- Name: objets objets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.objets
    ADD CONSTRAINT objets_pkey PRIMARY KEY (id);


--
-- Name: scores scores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.scores
    ADD CONSTRAINT scores_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

