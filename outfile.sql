--
-- PostgreSQL database dump
--

-- Dumped from database version 14.3
-- Dumped by pg_dump version 14.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: albums; Type: TABLE; Schema: public; Owner: bas
--

CREATE TABLE public.albums (
    album_id integer NOT NULL,
    albumtitle character varying(200) NOT NULL,
    performername character varying(200) NOT NULL,
    releasedate date NOT NULL,
    recordlabel character varying(200) NOT NULL,
    imagelocation character varying(200)
);


ALTER TABLE public.albums OWNER TO bas;

--
-- Name: albums_album_id_seq; Type: SEQUENCE; Schema: public; Owner: bas
--

CREATE SEQUENCE public.albums_album_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.albums_album_id_seq OWNER TO bas;

--
-- Name: albums_album_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bas
--

ALTER SEQUENCE public.albums_album_id_seq OWNED BY public.albums.album_id;


--
-- Name: albumtracks; Type: TABLE; Schema: public; Owner: bas
--

CREATE TABLE public.albumtracks (
    album_id integer NOT NULL,
    track_id integer NOT NULL
);


ALTER TABLE public.albumtracks OWNER TO bas;

--
-- Name: instruments; Type: TABLE; Schema: public; Owner: bas
--

CREATE TABLE public.instruments (
    instrument_id integer NOT NULL,
    name character varying(200) NOT NULL
);


ALTER TABLE public.instruments OWNER TO bas;

--
-- Name: instruments_id_seq; Type: SEQUENCE; Schema: public; Owner: bas
--

CREATE SEQUENCE public.instruments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.instruments_id_seq OWNER TO bas;

--
-- Name: instruments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bas
--

ALTER SEQUENCE public.instruments_id_seq OWNED BY public.instruments.instrument_id;


--
-- Name: musicianalbum; Type: TABLE; Schema: public; Owner: bas
--

CREATE TABLE public.musicianalbum (
    musician_id integer NOT NULL,
    album_id integer NOT NULL
);


ALTER TABLE public.musicianalbum OWNER TO bas;

--
-- Name: musicianplaysinstrument; Type: TABLE; Schema: public; Owner: bas
--

CREATE TABLE public.musicianplaysinstrument (
    musician_id integer NOT NULL,
    instrument_id integer NOT NULL
);


ALTER TABLE public.musicianplaysinstrument OWNER TO bas;

--
-- Name: musicianplaystrack; Type: TABLE; Schema: public; Owner: bas
--

CREATE TABLE public.musicianplaystrack (
    musician_id integer NOT NULL,
    track_id integer NOT NULL
);


ALTER TABLE public.musicianplaystrack OWNER TO bas;

--
-- Name: musicians; Type: TABLE; Schema: public; Owner: bas
--

CREATE TABLE public.musicians (
    musician_id integer NOT NULL,
    firstname character varying(200) NOT NULL,
    lastname character varying(200) NOT NULL,
    birthdate date NOT NULL,
    deathdate date,
    bio character varying(500),
    imagelocation character varying(200)
);


ALTER TABLE public.musicians OWNER TO bas;

--
-- Name: musicians_id_seq; Type: SEQUENCE; Schema: public; Owner: bas
--

CREATE SEQUENCE public.musicians_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.musicians_id_seq OWNER TO bas;

--
-- Name: musicians_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bas
--

ALTER SEQUENCE public.musicians_id_seq OWNED BY public.musicians.musician_id;


--
-- Name: tracks; Type: TABLE; Schema: public; Owner: bas
--

CREATE TABLE public.tracks (
    track_id integer NOT NULL,
    title character varying(200) NOT NULL
);


ALTER TABLE public.tracks OWNER TO bas;

--
-- Name: tracks_track_id_seq; Type: SEQUENCE; Schema: public; Owner: bas
--

CREATE SEQUENCE public.tracks_track_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tracks_track_id_seq OWNER TO bas;

--
-- Name: tracks_track_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: bas
--

ALTER SEQUENCE public.tracks_track_id_seq OWNED BY public.tracks.track_id;


--
-- Name: albums album_id; Type: DEFAULT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.albums ALTER COLUMN album_id SET DEFAULT nextval('public.albums_album_id_seq'::regclass);


--
-- Name: instruments instrument_id; Type: DEFAULT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.instruments ALTER COLUMN instrument_id SET DEFAULT nextval('public.instruments_id_seq'::regclass);


--
-- Name: musicians musician_id; Type: DEFAULT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicians ALTER COLUMN musician_id SET DEFAULT nextval('public.musicians_id_seq'::regclass);


--
-- Name: tracks track_id; Type: DEFAULT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.tracks ALTER COLUMN track_id SET DEFAULT nextval('public.tracks_track_id_seq'::regclass);


--
-- Data for Name: albums; Type: TABLE DATA; Schema: public; Owner: bas
--

COPY public.albums (album_id, albumtitle, performername, releasedate, recordlabel, imagelocation) FROM stdin;
3	Quiet Nights	Miles Davis and Gil Evens	1963-12-16	Columbia	\N
2	Sketches of Spain	Miles Davis	1960-07-18	Columbia	\N
4	Tutu	Miles Davis	1986-09-01	Warner Bros	\N
6	My Funny Valentine	Miles Davis	1965-02-23	Columbia	\N
7	E.S.P.	Miles Davis	1965-08-16	Columbia	\N
8	Bitches Brew	Miles Davis	1970-04-01	Columbia	\N
9	In a Silent Way	Miles Davis	1970-07-30	Columbia	\N
10	You're Under Arrest	Miles Davis	1985-09-09	Columbia	\N
11	The Man with the Horn	Miles Davis	1980-07-01	Columbia	\N
5	Bags' Groove	Miles Davis	1957-12-01	Prestige	Images/Image-bagsgroove.jpg
1	Kind of Blue	Miles Davis	1959-08-17	Columbia	Images/MilesDavisKindofBlue.jpg
\.


--
-- Data for Name: albumtracks; Type: TABLE DATA; Schema: public; Owner: bas
--

COPY public.albumtracks (album_id, track_id) FROM stdin;
1	1
1	2
1	3
1	4
1	5
5	11
5	12
5	13
5	14
5	15
5	16
5	17
\.


--
-- Data for Name: instruments; Type: TABLE DATA; Schema: public; Owner: bas
--

COPY public.instruments (instrument_id, name) FROM stdin;
1	piano
2	trumpet
3	flugelhorn
4	cornet
5	drums
6	double bass
8	guitar
9	alto saxophone
10	tenor saxophone
11	bariton saxophone
12	fender rhodes
13	synths
14	french horn
15	clarinet
16	vocals
17	percussion
7	electric bass
18	keyboards
19	trombone
20	vibraphone
\.


--
-- Data for Name: musicianalbum; Type: TABLE DATA; Schema: public; Owner: bas
--

COPY public.musicianalbum (musician_id, album_id) FROM stdin;
1	1
9	1
7	1
8	1
4	1
6	1
10	1
1	5
2	5
\.


--
-- Data for Name: musicianplaysinstrument; Type: TABLE DATA; Schema: public; Owner: bas
--

COPY public.musicianplaysinstrument (musician_id, instrument_id) FROM stdin;
2	10
3	1
4	6
5	5
6	10
7	9
8	1
9	5
10	1
11	1
12	6
13	5
14	10
15	1
16	6
17	5
18	20
19	1
20	10
1	2
\.


--
-- Data for Name: musicianplaystrack; Type: TABLE DATA; Schema: public; Owner: bas
--

COPY public.musicianplaystrack (musician_id, track_id) FROM stdin;
1	1
7	1
6	1
8	1
4	1
9	1
1	2
7	2
6	2
10	2
4	2
9	2
1	3
6	3
8	3
4	3
9	3
1	4
7	4
6	4
8	4
4	4
9	4
1	5
7	5
6	5
8	5
4	5
9	5
1	11
1	12
1	13
1	14
1	15
1	16
1	17
2	13
2	14
2	15
2	16
2	17
\.


--
-- Data for Name: musicians; Type: TABLE DATA; Schema: public; Owner: bas
--

COPY public.musicians (musician_id, firstname, lastname, birthdate, deathdate, bio, imagelocation) FROM stdin;
3	Red	Garland	1923-05-13	1984-04-23	\N	\N
5	Philly Joe	Jones	1923-07-15	1985-08-30	\N	\N
11	Herbie	Hancock	1940-04-12	\N	\N	\N
12	Ron	Carter	1937-05-04	\N	\N	\N
13	Tony	Williams	1945-12-12	1997-02-23	\N	\N
14	Wayne	Shorter	1933-08-25	\N	\N	\N
15	Horace	Silver	1928-09-02	2014-06-18	\N	\N
16	Percy	Heath	1923-04-30	2005-04-28	\N	\N
17	Kenny	Clarke	1914-01-09	1985-01-26	\N	\N
18	Milt	Jackson	1923-01-01	1999-10-09	\N	\N
19	Thelonious	Monk	1917-10-10	1982-02-17	\N	\N
20	George	Coleman	1935-03-08	\N	\N	\N
4	Paul	Chambers	1935-04-22	1969-01-04	Paul Laurence Dunbar Chambers Jr.  was an American jazz double bassist. A fixture of rhythm sections during the 1950s and 1960s, his importance in the development of jazz bass can be measured not only by the extent of his work in this short period, but also by his impeccable timekeeping and virtuosic improvisations. He was also known for his bowed solos.	Images/Paul_Laurence_Dunbar_Chambers.jpg
8	Bill	Evans	1929-08-16	1980-09-15	William John Evans was an American jazz pianist and composer who mostly worked as the leader of a trio. His use of impressionist harmony, interpretation of traditional jazz repertoire, block chords, and trademark rhythmically independent, "singing" melodic lines continues to influence jazz pianists today.	Images/Bill_Evans_(1961_publicity_photo_by_Steve_Schapiro).jpg
9	Jimmy	Cobb	1929-01-20	2020-05-24	Wilbur James Cobb was an American jazz drummer. He was part of Miles Davis's First Great Sextet. At the time of his death, he had been the band's last surviving member for nearly thirty years. He was awarded an NEA Jazz Masters Fellowship in 2009.	Images/Jimmy_Cobb.jpg
7	Cannonball	Adderley	1928-09-15	1975-08-08	Julian Edwin "Cannonball" Adderley was an American jazz alto saxophonist of the hard bop era of the 1950s and 1960s.	Images/Julian_and_Nat_Adderley_1966.JPG
1	Miles	Davis	1926-05-26	1991-09-28	Miles Dewey Davis III  was an American trumpeter, bandleader, and composer. He is among the most influential and acclaimed figures in the history of jazz and 20th-century music. Davis adopted a variety of musical directions in a five-decade career that kept him at the forefront of many major stylistic developments in jazz.	Images/Miles_Davis_by_Palumbo_cropped.jpg
10	Wynton	Kelly	1931-12-02	1971-04-12	Wynton Charles Kelly was an American jazz pianist and composer. He is known for his lively, blues-based playing and as one of the finest accompanists in jazz. He began playing professionally at the age of 12 and was pianist on a No. 1 R&B hit at the age of 16. His recording debut as a leader occurred three years later, around the time he started to become better known as an accompanist to singer Dinah Washington, and as a member of trumpeter Dizzy Gillespies band. 	Images/Wynton_Kelly.jpg
6	John	Coltrane	1926-09-23	1967-07-17	John William Coltrane was an American jazz saxophonist and composer. 	Images/330px-John_Coltrane_in_1963.jpg
2	Sonny	Rollins	1930-09-07	\N	Walter Theodore "Sonny" Rollins is an American jazz tenor saxophonist who is widely recognized as one of the most important and influential jazz musicians. In a seven-decade career, he has recorded over sixty albums as a leader. A number of his compositions, including "St. Thomas", "Oleo", "Doxy", "Pent-Up House", and "Airegin", have become jazz standards. Rollins has been called "the greatest living improviser" and the "Saxophone Colossus". 	Images/Sonny_Rollins_2011.jpg
\.


--
-- Data for Name: tracks; Type: TABLE DATA; Schema: public; Owner: bas
--

COPY public.tracks (track_id, title) FROM stdin;
1	So What
2	Freddie Freeloader
3	Blue in Green
4	All Blues
5	Flamenco Sketches
11	"Bags' Groove" (Take 1)
12	"Bags' Groove" (Take 2)
13	Airegin
14	Oleo
15	But Not for Me (Take 2)
16	Doxy
17	But Not for Me (Take 1)
\.


--
-- Name: albums_album_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bas
--

SELECT pg_catalog.setval('public.albums_album_id_seq', 11, true);


--
-- Name: instruments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bas
--

SELECT pg_catalog.setval('public.instruments_id_seq', 20, true);


--
-- Name: musicians_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bas
--

SELECT pg_catalog.setval('public.musicians_id_seq', 20, true);


--
-- Name: tracks_track_id_seq; Type: SEQUENCE SET; Schema: public; Owner: bas
--

SELECT pg_catalog.setval('public.tracks_track_id_seq', 17, true);


--
-- Name: albums albums_pkey; Type: CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.albums
    ADD CONSTRAINT albums_pkey PRIMARY KEY (album_id);


--
-- Name: albumtracks albumtracks_pkey; Type: CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.albumtracks
    ADD CONSTRAINT albumtracks_pkey PRIMARY KEY (album_id, track_id);


--
-- Name: instruments instruments_pkey; Type: CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.instruments
    ADD CONSTRAINT instruments_pkey PRIMARY KEY (instrument_id);


--
-- Name: musicianalbum musicianalbum_pkey; Type: CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicianalbum
    ADD CONSTRAINT musicianalbum_pkey PRIMARY KEY (musician_id, album_id);


--
-- Name: musicianplaysinstrument musicianplaysinstrument_pkey; Type: CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicianplaysinstrument
    ADD CONSTRAINT musicianplaysinstrument_pkey PRIMARY KEY (musician_id, instrument_id);


--
-- Name: musicianplaystrack musicianplaystrack_pkey; Type: CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicianplaystrack
    ADD CONSTRAINT musicianplaystrack_pkey PRIMARY KEY (track_id, musician_id);


--
-- Name: musicians musicians_pkey; Type: CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicians
    ADD CONSTRAINT musicians_pkey PRIMARY KEY (musician_id);


--
-- Name: tracks tracks_pkey; Type: CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.tracks
    ADD CONSTRAINT tracks_pkey PRIMARY KEY (track_id);


--
-- Name: albumtracks albumtracks_album_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.albumtracks
    ADD CONSTRAINT albumtracks_album_id_fkey FOREIGN KEY (album_id) REFERENCES public.albums(album_id);


--
-- Name: albumtracks albumtracks_track_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.albumtracks
    ADD CONSTRAINT albumtracks_track_id_fkey FOREIGN KEY (track_id) REFERENCES public.tracks(track_id);


--
-- Name: musicianalbum musicianalbum_album_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicianalbum
    ADD CONSTRAINT musicianalbum_album_id_fkey FOREIGN KEY (album_id) REFERENCES public.albums(album_id);


--
-- Name: musicianalbum musicianalbum_musician_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicianalbum
    ADD CONSTRAINT musicianalbum_musician_id_fkey FOREIGN KEY (musician_id) REFERENCES public.musicians(musician_id);


--
-- Name: musicianplaysinstrument musicianplaysinstrument_instrument_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicianplaysinstrument
    ADD CONSTRAINT musicianplaysinstrument_instrument_id_fkey FOREIGN KEY (instrument_id) REFERENCES public.instruments(instrument_id);


--
-- Name: musicianplaysinstrument musicianplaysinstrument_musician_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicianplaysinstrument
    ADD CONSTRAINT musicianplaysinstrument_musician_id_fkey FOREIGN KEY (musician_id) REFERENCES public.musicians(musician_id);


--
-- Name: musicianplaystrack musicianplaystrack_musician_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicianplaystrack
    ADD CONSTRAINT musicianplaystrack_musician_id_fkey FOREIGN KEY (musician_id) REFERENCES public.musicians(musician_id);


--
-- Name: musicianplaystrack musicianplaystrack_track_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bas
--

ALTER TABLE ONLY public.musicianplaystrack
    ADD CONSTRAINT musicianplaystrack_track_id_fkey FOREIGN KEY (track_id) REFERENCES public.tracks(track_id);


--
-- PostgreSQL database dump complete
--

