PGDMP                       }         	   Y-ALADZAN    17.2    17.2 �    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            �           1262    16388 	   Y-ALADZAN    DATABASE     �   CREATE DATABASE "Y-ALADZAN" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE "Y-ALADZAN";
                     postgres    false            �            1259    33961    admin_groups    TABLE     �   CREATE TABLE public.admin_groups (
    id bigint NOT NULL,
    admin_id bigint NOT NULL,
    group_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
     DROP TABLE public.admin_groups;
       public         heap r       postgres    false            �            1259    33960    admin_groups_id_seq    SEQUENCE     |   CREATE SEQUENCE public.admin_groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.admin_groups_id_seq;
       public               postgres    false    234            �           0    0    admin_groups_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.admin_groups_id_seq OWNED BY public.admin_groups.id;
          public               postgres    false    233            �            1259    33905    admins    TABLE     c  CREATE TABLE public.admins (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    foto character varying(255),
    salary integer NOT NULL,
    bonus_id bigint NOT NULL,
    phone character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.admins;
       public         heap r       postgres    false            �            1259    34004    loans    TABLE     �  CREATE TABLE public.loans (
    id bigint NOT NULL,
    admin_group_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    loan_date date NOT NULL,
    total_amount integer NOT NULL,
    total_payment integer DEFAULT 0 NOT NULL,
    outstanding_amount integer NOT NULL,
    phone character varying(255),
    codes_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.loans;
       public         heap r       postgres    false            �            1259    34079    admin_loan_view    VIEW     �  CREATE VIEW public.admin_loan_view AS
 SELECT ag.group_id,
    ag.admin_id,
    a.name,
    a.phone,
    a.foto,
    COALESCE(sum(l.total_payment), (0)::bigint) AS total_payments,
    COALESCE(sum(l.total_amount), (0)::bigint) AS total_amount
   FROM ((public.admin_groups ag
     JOIN public.admins a ON ((ag.admin_id = a.id)))
     LEFT JOIN public.loans l ON ((ag.id = l.admin_group_id)))
  GROUP BY ag.group_id, ag.admin_id, a.name, a.phone, a.foto;
 "   DROP VIEW public.admin_loan_view;
       public       v       postgres    false    234    240    240    240    234    226    226    226    226    234            �            1259    33904    admins_id_seq    SEQUENCE     v   CREATE SEQUENCE public.admins_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.admins_id_seq;
       public               postgres    false    226            �           0    0    admins_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.admins_id_seq OWNED BY public.admins.id;
          public               postgres    false    225            �            1259    33938    attendances    TABLE     �  CREATE TABLE public.attendances (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    image_url character varying(255) NOT NULL,
    description character varying(255) NOT NULL,
    entry_time time(0) without time zone NOT NULL,
    exit_time time(0) without time zone,
    duration double precision,
    attendance_date date NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.attendances;
       public         heap r       postgres    false            �            1259    33937    attendances_id_seq    SEQUENCE     {   CREATE SEQUENCE public.attendances_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.attendances_id_seq;
       public               postgres    false    230            �           0    0    attendances_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.attendances_id_seq OWNED BY public.attendances.id;
          public               postgres    false    229            �            1259    33895    bonuses    TABLE     S  CREATE TABLE public.bonuses (
    id bigint NOT NULL,
    total_amount numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    used_amount numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    remaining_amount numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.bonuses;
       public         heap r       postgres    false            �            1259    33894    bonuses_id_seq    SEQUENCE     w   CREATE SEQUENCE public.bonuses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.bonuses_id_seq;
       public               postgres    false    224            �           0    0    bonuses_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.bonuses_id_seq OWNED BY public.bonuses.id;
          public               postgres    false    223            �            1259    33979    cache    TABLE     �   CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);
    DROP TABLE public.cache;
       public         heap r       postgres    false            �            1259    33986    cache_locks    TABLE     �   CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);
    DROP TABLE public.cache_locks;
       public         heap r       postgres    false            �            1259    34047    category_expenses    TABLE     �   CREATE TABLE public.category_expenses (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    role character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 %   DROP TABLE public.category_expenses;
       public         heap r       postgres    false            �            1259    34046    category_expenses_id_seq    SEQUENCE     �   CREATE SEQUENCE public.category_expenses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.category_expenses_id_seq;
       public               postgres    false    246            �           0    0    category_expenses_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.category_expenses_id_seq OWNED BY public.category_expenses.id;
          public               postgres    false    245            �            1259    33994    codes    TABLE     �   CREATE TABLE public.codes (
    id bigint NOT NULL,
    code character varying(255) NOT NULL,
    bonus numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.codes;
       public         heap r       postgres    false            �            1259    33993    codes_id_seq    SEQUENCE     u   CREATE SEQUENCE public.codes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.codes_id_seq;
       public               postgres    false    238            �           0    0    codes_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.codes_id_seq OWNED BY public.codes.id;
          public               postgres    false    237            �            1259    34056    expenses    TABLE     �  CREATE TABLE public.expenses (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    admin_id bigint,
    date date NOT NULL,
    amount numeric(15,2) NOT NULL,
    category_id bigint NOT NULL,
    description text,
    method character varying(255) NOT NULL,
    image_url character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.expenses;
       public         heap r       postgres    false            �            1259    34055    expenses_id_seq    SEQUENCE     x   CREATE SEQUENCE public.expenses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.expenses_id_seq;
       public               postgres    false    248            �           0    0    expenses_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.expenses_id_seq OWNED BY public.expenses.id;
          public               postgres    false    247            �            1259    33952    groups    TABLE     �   CREATE TABLE public.groups (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.groups;
       public         heap r       postgres    false            �            1259    33951    groups_id_seq    SEQUENCE     v   CREATE SEQUENCE public.groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.groups_id_seq;
       public               postgres    false    232            �           0    0    groups_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.groups_id_seq OWNED BY public.groups.id;
          public               postgres    false    231            �            1259    34003    loans_id_seq    SEQUENCE     u   CREATE SEQUENCE public.loans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.loans_id_seq;
       public               postgres    false    240            �           0    0    loans_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.loans_id_seq OWNED BY public.loans.id;
          public               postgres    false    239            �            1259    33924    managers    TABLE     *  CREATE TABLE public.managers (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    phone character varying(255) NOT NULL,
    foto character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.managers;
       public         heap r       postgres    false            �            1259    33923    managers_id_seq    SEQUENCE     x   CREATE SEQUENCE public.managers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.managers_id_seq;
       public               postgres    false    228            �           0    0    managers_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.managers_id_seq OWNED BY public.managers.id;
          public               postgres    false    227            �            1259    34038    messages    TABLE     �   CREATE TABLE public.messages (
    id bigint NOT NULL,
    message_header text NOT NULL,
    message_footer text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.messages;
       public         heap r       postgres    false            �            1259    34037    messages_id_seq    SEQUENCE     x   CREATE SEQUENCE public.messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.messages_id_seq;
       public               postgres    false    244            �           0    0    messages_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.messages_id_seq OWNED BY public.messages.id;
          public               postgres    false    243            �            1259    33859 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         heap r       postgres    false            �            1259    33858    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public               postgres    false    218            �           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public               postgres    false    217            �            1259    33878    password_reset_tokens    TABLE     �   CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 )   DROP TABLE public.password_reset_tokens;
       public         heap r       postgres    false            �            1259    34024    payments    TABLE     3  CREATE TABLE public.payments (
    id bigint NOT NULL,
    loan_id bigint NOT NULL,
    amount integer NOT NULL,
    payment_date date NOT NULL,
    method character varying(255) NOT NULL,
    description text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.payments;
       public         heap r       postgres    false            �            1259    34023    payments_id_seq    SEQUENCE     x   CREATE SEQUENCE public.payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.payments_id_seq;
       public               postgres    false    242            �           0    0    payments_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.payments_id_seq OWNED BY public.payments.id;
          public               postgres    false    241            �            1259    33885    sessions    TABLE     �   CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);
    DROP TABLE public.sessions;
       public         heap r       postgres    false            �            1259    33866    users    TABLE     b  CREATE TABLE public.users (
    id bigint NOT NULL,
    username character varying(255) NOT NULL,
    role smallint NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.users;
       public         heap r       postgres    false            �            1259    33865    users_id_seq    SEQUENCE     u   CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public               postgres    false    220            �           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public               postgres    false    219            �           2604    33964    admin_groups id    DEFAULT     r   ALTER TABLE ONLY public.admin_groups ALTER COLUMN id SET DEFAULT nextval('public.admin_groups_id_seq'::regclass);
 >   ALTER TABLE public.admin_groups ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    233    234    234            �           2604    33908 	   admins id    DEFAULT     f   ALTER TABLE ONLY public.admins ALTER COLUMN id SET DEFAULT nextval('public.admins_id_seq'::regclass);
 8   ALTER TABLE public.admins ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    226    225    226            �           2604    33941    attendances id    DEFAULT     p   ALTER TABLE ONLY public.attendances ALTER COLUMN id SET DEFAULT nextval('public.attendances_id_seq'::regclass);
 =   ALTER TABLE public.attendances ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    230    229    230            �           2604    33898 
   bonuses id    DEFAULT     h   ALTER TABLE ONLY public.bonuses ALTER COLUMN id SET DEFAULT nextval('public.bonuses_id_seq'::regclass);
 9   ALTER TABLE public.bonuses ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    223    224    224            �           2604    34050    category_expenses id    DEFAULT     |   ALTER TABLE ONLY public.category_expenses ALTER COLUMN id SET DEFAULT nextval('public.category_expenses_id_seq'::regclass);
 C   ALTER TABLE public.category_expenses ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    245    246    246            �           2604    33997    codes id    DEFAULT     d   ALTER TABLE ONLY public.codes ALTER COLUMN id SET DEFAULT nextval('public.codes_id_seq'::regclass);
 7   ALTER TABLE public.codes ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    238    237    238            �           2604    34059    expenses id    DEFAULT     j   ALTER TABLE ONLY public.expenses ALTER COLUMN id SET DEFAULT nextval('public.expenses_id_seq'::regclass);
 :   ALTER TABLE public.expenses ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    247    248    248            �           2604    33955 	   groups id    DEFAULT     f   ALTER TABLE ONLY public.groups ALTER COLUMN id SET DEFAULT nextval('public.groups_id_seq'::regclass);
 8   ALTER TABLE public.groups ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    232    231    232            �           2604    34007    loans id    DEFAULT     d   ALTER TABLE ONLY public.loans ALTER COLUMN id SET DEFAULT nextval('public.loans_id_seq'::regclass);
 7   ALTER TABLE public.loans ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    240    239    240            �           2604    33927    managers id    DEFAULT     j   ALTER TABLE ONLY public.managers ALTER COLUMN id SET DEFAULT nextval('public.managers_id_seq'::regclass);
 :   ALTER TABLE public.managers ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    227    228    228            �           2604    34041    messages id    DEFAULT     j   ALTER TABLE ONLY public.messages ALTER COLUMN id SET DEFAULT nextval('public.messages_id_seq'::regclass);
 :   ALTER TABLE public.messages ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    243    244    244            �           2604    33862    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    218    217    218            �           2604    34027    payments id    DEFAULT     j   ALTER TABLE ONLY public.payments ALTER COLUMN id SET DEFAULT nextval('public.payments_id_seq'::regclass);
 :   ALTER TABLE public.payments ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    241    242    242            �           2604    33869    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    220    219    220            �          0    33961    admin_groups 
   TABLE DATA           V   COPY public.admin_groups (id, admin_id, group_id, created_at, updated_at) FROM stdin;
    public               postgres    false    234   ��       �          0    33905    admins 
   TABLE DATA           j   COPY public.admins (id, user_id, name, foto, salary, bonus_id, phone, created_at, updated_at) FROM stdin;
    public               postgres    false    226   ;�       �          0    33938    attendances 
   TABLE DATA           �   COPY public.attendances (id, user_id, image_url, description, entry_time, exit_time, duration, attendance_date, created_at, updated_at) FROM stdin;
    public               postgres    false    230   ��       �          0    33895    bonuses 
   TABLE DATA           j   COPY public.bonuses (id, total_amount, used_amount, remaining_amount, created_at, updated_at) FROM stdin;
    public               postgres    false    224   ��       �          0    33979    cache 
   TABLE DATA           7   COPY public.cache (key, value, expiration) FROM stdin;
    public               postgres    false    235   ��       �          0    33986    cache_locks 
   TABLE DATA           =   COPY public.cache_locks (key, owner, expiration) FROM stdin;
    public               postgres    false    236   ��       �          0    34047    category_expenses 
   TABLE DATA           S   COPY public.category_expenses (id, name, role, created_at, updated_at) FROM stdin;
    public               postgres    false    246   ˸       �          0    33994    codes 
   TABLE DATA           H   COPY public.codes (id, code, bonus, created_at, updated_at) FROM stdin;
    public               postgres    false    238   #�       �          0    34056    expenses 
   TABLE DATA           �   COPY public.expenses (id, user_id, admin_id, date, amount, category_id, description, method, image_url, created_at, updated_at) FROM stdin;
    public               postgres    false    248   ��       �          0    33952    groups 
   TABLE DATA           O   COPY public.groups (id, name, description, created_at, updated_at) FROM stdin;
    public               postgres    false    232   ��       �          0    34004    loans 
   TABLE DATA           �   COPY public.loans (id, admin_group_id, name, description, loan_date, total_amount, total_payment, outstanding_amount, phone, codes_id, created_at, updated_at) FROM stdin;
    public               postgres    false    240   I�       �          0    33924    managers 
   TABLE DATA           Z   COPY public.managers (id, user_id, name, phone, foto, created_at, updated_at) FROM stdin;
    public               postgres    false    228   b�       �          0    34038    messages 
   TABLE DATA           ^   COPY public.messages (id, message_header, message_footer, created_at, updated_at) FROM stdin;
    public               postgres    false    244   ��       �          0    33859 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public               postgres    false    218   4�       �          0    33878    password_reset_tokens 
   TABLE DATA           I   COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
    public               postgres    false    221   ��       �          0    34024    payments 
   TABLE DATA           r   COPY public.payments (id, loan_id, amount, payment_date, method, description, created_at, updated_at) FROM stdin;
    public               postgres    false    242   ��       �          0    33885    sessions 
   TABLE DATA           _   COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
    public               postgres    false    222   6�       �          0    33866    users 
   TABLE DATA           l   COPY public.users (id, username, role, email, password, remember_token, created_at, updated_at) FROM stdin;
    public               postgres    false    220   ��       �           0    0    admin_groups_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.admin_groups_id_seq', 30, true);
          public               postgres    false    233            �           0    0    admins_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.admins_id_seq', 11, true);
          public               postgres    false    225            �           0    0    attendances_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.attendances_id_seq', 100, true);
          public               postgres    false    229            �           0    0    bonuses_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.bonuses_id_seq', 11, true);
          public               postgres    false    223            �           0    0    category_expenses_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.category_expenses_id_seq', 4, true);
          public               postgres    false    245            �           0    0    codes_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.codes_id_seq', 4, true);
          public               postgres    false    237            �           0    0    expenses_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.expenses_id_seq', 6, true);
          public               postgres    false    247            �           0    0    groups_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.groups_id_seq', 3, true);
          public               postgres    false    231            �           0    0    loans_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.loans_id_seq', 30, true);
          public               postgres    false    239            �           0    0    managers_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.managers_id_seq', 1, true);
          public               postgres    false    227            �           0    0    messages_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.messages_id_seq', 1, true);
          public               postgres    false    243            �           0    0    migrations_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.migrations_id_seq', 6, true);
          public               postgres    false    217            �           0    0    payments_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.payments_id_seq', 50, true);
          public               postgres    false    241            �           0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 12, true);
          public               postgres    false    219            �           2606    33978 2   admin_groups admin_groups_admin_id_group_id_unique 
   CONSTRAINT     {   ALTER TABLE ONLY public.admin_groups
    ADD CONSTRAINT admin_groups_admin_id_group_id_unique UNIQUE (admin_id, group_id);
 \   ALTER TABLE ONLY public.admin_groups DROP CONSTRAINT admin_groups_admin_id_group_id_unique;
       public                 postgres    false    234    234            �           2606    33966    admin_groups admin_groups_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.admin_groups
    ADD CONSTRAINT admin_groups_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.admin_groups DROP CONSTRAINT admin_groups_pkey;
       public                 postgres    false    234            �           2606    33912    admins admins_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.admins DROP CONSTRAINT admins_pkey;
       public                 postgres    false    226            �           2606    33945    attendances attendances_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.attendances
    ADD CONSTRAINT attendances_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.attendances DROP CONSTRAINT attendances_pkey;
       public                 postgres    false    230            �           2606    33903    bonuses bonuses_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.bonuses
    ADD CONSTRAINT bonuses_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.bonuses DROP CONSTRAINT bonuses_pkey;
       public                 postgres    false    224            �           2606    33992    cache_locks cache_locks_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);
 F   ALTER TABLE ONLY public.cache_locks DROP CONSTRAINT cache_locks_pkey;
       public                 postgres    false    236            �           2606    33985    cache cache_pkey 
   CONSTRAINT     O   ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);
 :   ALTER TABLE ONLY public.cache DROP CONSTRAINT cache_pkey;
       public                 postgres    false    235            �           2606    34054 (   category_expenses category_expenses_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.category_expenses
    ADD CONSTRAINT category_expenses_pkey PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.category_expenses DROP CONSTRAINT category_expenses_pkey;
       public                 postgres    false    246            �           2606    34002    codes codes_code_unique 
   CONSTRAINT     R   ALTER TABLE ONLY public.codes
    ADD CONSTRAINT codes_code_unique UNIQUE (code);
 A   ALTER TABLE ONLY public.codes DROP CONSTRAINT codes_code_unique;
       public                 postgres    false    238            �           2606    34000    codes codes_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.codes
    ADD CONSTRAINT codes_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.codes DROP CONSTRAINT codes_pkey;
       public                 postgres    false    238            �           2606    34063    expenses expenses_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.expenses DROP CONSTRAINT expenses_pkey;
       public                 postgres    false    248            �           2606    33959    groups groups_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.groups DROP CONSTRAINT groups_pkey;
       public                 postgres    false    232            �           2606    34012    loans loans_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.loans
    ADD CONSTRAINT loans_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.loans DROP CONSTRAINT loans_pkey;
       public                 postgres    false    240            �           2606    33931    managers managers_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.managers
    ADD CONSTRAINT managers_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.managers DROP CONSTRAINT managers_pkey;
       public                 postgres    false    228            �           2606    34045    messages messages_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.messages DROP CONSTRAINT messages_pkey;
       public                 postgres    false    244            �           2606    33864    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public                 postgres    false    218            �           2606    33884 0   password_reset_tokens password_reset_tokens_pkey 
   CONSTRAINT     q   ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);
 Z   ALTER TABLE ONLY public.password_reset_tokens DROP CONSTRAINT password_reset_tokens_pkey;
       public                 postgres    false    221            �           2606    34031    payments payments_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.payments DROP CONSTRAINT payments_pkey;
       public                 postgres    false    242            �           2606    33891    sessions sessions_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.sessions DROP CONSTRAINT sessions_pkey;
       public                 postgres    false    222            �           2606    33877    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public                 postgres    false    220            �           2606    33873    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public                 postgres    false    220            �           2606    33875    users users_username_unique 
   CONSTRAINT     Z   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_unique UNIQUE (username);
 E   ALTER TABLE ONLY public.users DROP CONSTRAINT users_username_unique;
       public                 postgres    false    220            �           1259    33893    sessions_last_activity_index    INDEX     Z   CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);
 0   DROP INDEX public.sessions_last_activity_index;
       public                 postgres    false    222            �           1259    33892    sessions_user_id_index    INDEX     N   CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);
 *   DROP INDEX public.sessions_user_id_index;
       public                 postgres    false    222            �           2606    33967 *   admin_groups admin_groups_admin_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.admin_groups
    ADD CONSTRAINT admin_groups_admin_id_foreign FOREIGN KEY (admin_id) REFERENCES public.admins(id) ON DELETE CASCADE;
 T   ALTER TABLE ONLY public.admin_groups DROP CONSTRAINT admin_groups_admin_id_foreign;
       public               postgres    false    4816    226    234            �           2606    33972 *   admin_groups admin_groups_group_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.admin_groups
    ADD CONSTRAINT admin_groups_group_id_foreign FOREIGN KEY (group_id) REFERENCES public.groups(id) ON DELETE CASCADE;
 T   ALTER TABLE ONLY public.admin_groups DROP CONSTRAINT admin_groups_group_id_foreign;
       public               postgres    false    232    4822    234            �           2606    33918    admins admins_bonus_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_bonus_id_foreign FOREIGN KEY (bonus_id) REFERENCES public.bonuses(id) ON DELETE CASCADE;
 H   ALTER TABLE ONLY public.admins DROP CONSTRAINT admins_bonus_id_foreign;
       public               postgres    false    224    226    4814            �           2606    33913    admins admins_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.admins
    ADD CONSTRAINT admins_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 G   ALTER TABLE ONLY public.admins DROP CONSTRAINT admins_user_id_foreign;
       public               postgres    false    226    220    4804            �           2606    33946 '   attendances attendances_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.attendances
    ADD CONSTRAINT attendances_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 Q   ALTER TABLE ONLY public.attendances DROP CONSTRAINT attendances_user_id_foreign;
       public               postgres    false    220    230    4804            �           2606    34069 "   expenses expenses_admin_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_admin_id_foreign FOREIGN KEY (admin_id) REFERENCES public.admins(id) ON DELETE CASCADE;
 L   ALTER TABLE ONLY public.expenses DROP CONSTRAINT expenses_admin_id_foreign;
       public               postgres    false    226    248    4816            �           2606    34074 %   expenses expenses_category_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.category_expenses(id) ON DELETE CASCADE;
 O   ALTER TABLE ONLY public.expenses DROP CONSTRAINT expenses_category_id_foreign;
       public               postgres    false    246    4842    248            �           2606    34064 !   expenses expenses_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 K   ALTER TABLE ONLY public.expenses DROP CONSTRAINT expenses_user_id_foreign;
       public               postgres    false    248    4804    220            �           2606    34013 "   loans loans_admin_group_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.loans
    ADD CONSTRAINT loans_admin_group_id_foreign FOREIGN KEY (admin_group_id) REFERENCES public.admin_groups(id) ON DELETE CASCADE;
 L   ALTER TABLE ONLY public.loans DROP CONSTRAINT loans_admin_group_id_foreign;
       public               postgres    false    4826    234    240            �           2606    34018    loans loans_codes_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.loans
    ADD CONSTRAINT loans_codes_id_foreign FOREIGN KEY (codes_id) REFERENCES public.codes(id) ON DELETE CASCADE;
 F   ALTER TABLE ONLY public.loans DROP CONSTRAINT loans_codes_id_foreign;
       public               postgres    false    4834    240    238            �           2606    33932 !   managers managers_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.managers
    ADD CONSTRAINT managers_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 K   ALTER TABLE ONLY public.managers DROP CONSTRAINT managers_user_id_foreign;
       public               postgres    false    228    4804    220            �           2606    34032 !   payments payments_loan_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_loan_id_foreign FOREIGN KEY (loan_id) REFERENCES public.loans(id) ON DELETE CASCADE;
 K   ALTER TABLE ONLY public.payments DROP CONSTRAINT payments_loan_id_foreign;
       public               postgres    false    4836    242    240            �      x����!�����S,Բ�ױ����_4��`��p󸌗��Ţ-�}+�.�)�zd��	��I�B������-�H�߇xGS�D(��\�y��1
�C�\(�
9��y���Ϸ����4      �   8  x���[O�0�g�S�q�Dc����q-���ċ����\;T駟�tH�*-(y�,����9C=���ڕ����Mp�C�B�}���-U���yjk��U�O��L�=�KdHPI�ᓄ�XP��+��"qD�(LDFIF١��#�>�e.�E?�,�j'4�
�^3I5V���A���\XW�_�~]u�`���@eL �g�glD�(F�`��������q�nm��fQ (H���Xj!�jx *BN�ja�z���m3|F@����o� �4c�S3��A����+�Զ}�| �Ti-H��Wp��a�`����yk};sf�Ζ��7���p�#��
��$�<f��>$� �n�Os���;��\r�����u$(m��A�ɟ���c/�@OU��M��V>���O�zv��λo��s�݅�)gE8):���ˢ��q��d{n(���_��(d�&?����{��F�mpq�����N޿�/���Sy��f�?�?���g�^=L;�����W#��_C0,�"�4����k�8�Vt[ڭ�K��E�8��<��$��{      �      x��\ۮ�ƒ}f��?��fw�M
|`��� y�Jl�$Q)ß?���I��/%F���ݗ�Uk���eVe���2�~�����cw��c��a<�X[��6�����Q�����g�m��S�m8����x���<�oS��É~���?�9���p��|���N�]�2��ٕ6s�-�L+m�J��>Vo�����v�ڕ�_�Age)X��TX��O���_n�<���?~���H�Hk=��m.�@E�-3��-��Ԫh�:��¢U#Y��j���^���t���픏�>�a���6�_�q���9�=��O���u-ZӇ:�ZU��-;k+ZvU9��������H��%0���_Ǽ��0��k��)��sO�vw�/]����%h�SU���P�ЮTQV����`/�� |�q���RĜ(�i�����>�t�����m���;eB�ޕ�NW���Z��Z���o��p��c���y8�Ӎ�bi�����Sw�ܤ���r�X��uV7��^�'��ӪOc?d�c:�5D�`s�.��H�0�/qn��+V����؀uYK�j6PJ6�dV��������L������AS�����iH �+%3�� ��[�3&C�0��7�gV�f�`��5M�q��"$X���(���/���A����T�owUK)���zBJ���,�k�^�̉�=-<�������Zh������~�Q��C�_W\�%CU8��ً2���a�OP�<�S�'�ђ¡8}v��9�h�T������A�Bb���0ו�9U<��tF����b���E=�&?����ݮ������A��vJ�2�s.�|w-ʉv`2	��}�Ab3��� �{Z�]Jr(�f|�܋�N����:�h�`̮2�[Y�S����u�N����HT�N������F�3�����OAY��n�����,�FU6PM�޹�V��JT,�WaGJ�e'���J̈o�z�<��0�d!�������)w�fU��~�jQ����!Q���~'��ν���w����u�:�mAW@��D�ֶh_����h7�}��ٟ�����b~lp-����j�Z1S���.��-K�FT��8���v��;^4qSfK�4Ǎts��
e�μ�q���mEpjm�n��O,�`��D�;��HW
������6���W��"^�*�H�3E���Jģ�*Q#^��Ù"�u8Ǩax�CO���E(�h�MV�#�	.]f�e�o�z�4�s<e?m�p8�)�P�`\����p��5�4I����K�ڽ��Z��ޘ��H��+����V�Y���{0�50X�v������4�0��.�n$ۀ�����6��V^�aq�>���;[�F����}�3еI��u}�X�(C:�ǉ�eȇ�?�N�1�0{�-ށ��|�M��@rK��)r@[�גG�]����Ev��"�ErM�ҭB����U E|�MTe���>�.�ě&Eg#� C��!X��T:���o+i��?����)�C���ǉn�ӧ��70/�a�\W�QOxĥ��=Q��-��m����Y�꿵��PD��E՟�ۉ�%�g%,�A���N�0��
]���V���>%.L�����q�^ąY�Z�I�R@��j�
�%"Z'�uո|���t:��:~z��+m�<��U��TS5�zE_�J�""�娵��Q����|�ƍ�v�n}d���P�L^L[VQ��P�k�����	g���;I&&����E?"�AIx�-��$_�~I2\��%q�f)E5s�������<���tX}�)p�i�RRY��,�nm�$�[Q�7Mb�݉���e��j�)����;�9DomI{���X���*��+Q�W����� ��A��z��_b�5�bua	[ ��fÓ݆ZD\諸�*�s�ߣ�7\���lv���p�;�/T����~h���[U�S�n�����WU=N�/7��~@kj��	&�U?�U�Y�Q�$I��~Zݗ��L�#X-p^C�#��`=Qq�o<NKޢk5�����hwl&�FT�� ���$J!9���.�68�w�b��[GPd�l�Z���b-�mJ?���4�2;y��֒���p3�1hp�yի��I�Bbk �m�B?8����\"�+�\�^�������l��x�h����{+�)�S���D�����O7NR��K�3��.PU�(��1 O^���Ѕ.K�]���(�~�A�S�{Kg��GA+Мby��ޕ��,���5G��Z`L�B<��Cr `�v��_��ݫ�!�������֢pժ*�k�d�$O�&�L�CG̝ƙ��]_)�+�l��h��#Z�rO�u-��R�x�%��ᬣS3 �f�lJC����@�i����(_�zPM��lY&��!���p-%E����;L��K��oA�Y�R!%���¾(D�P���.]����n×!�&NO��* ��O$�d@L��aĺ�$��V�%p.E:E�N��
v]��C�>u2��: -:$47��#��30C���	m��Kv�.iS\�Ӳ���/T����ɉ� ��;��X
e�ά1��z��Y�"fSU�5C��_�J�ܵ5�/I�Q�@�iِVnWQemU]4��%��$��O>0E̃�m�a�Y�h�7���5.���e,UMa`I��8�ʔ	.#,8Z=��꣈ɇ	M�@`�4@%ł�Pڪx�Y�@���}��NJ]\ƴ��7�Ub�<[�-��s���D+����s �H6]�Ej#Ӟ�-/i�?�
NɒU�����a����s���a3�`�͸�}0|�!'��}�Znl���W�H�o����¡fq<l�
]rۚB�f U2?Y��k'<47�"\I1�|	_J{�e+�o��/�ᕰ��m[�Tq�L�T�FN���^!��-lf���\��^:�nmץzg�A-�@��Fm���A�a��([اX-s���K\t��届4�d@
��g��x�cw�?�m
�Zǭ.���D��p�>��a�*p�u�~g?�<���`��|j-�X�\��L�f�q�֡�C�ϫE�q�l�Q5ka���l�T&���U3�/=�z�b�6��ۦY�sx�x>���F@>W�k�^���}��ʔ��A'��V����[�f}[��juLD�RknY&�s��~^�n8qS�tmG��d�b�M��㤬,\d^�s����4H���v��	*��:v����u^Z�L4,2KWЦ<	ں�Q�8��6m��S��.�ԅH�x:������ 
�Zc�;�!K��sɨ@��e{
���?i`��.���p�-�s���u�d�S������F$�������ox����"��y�M��U��ac��'�C���+p�5�fS"���L�h�}g�E8�_�,ۮKܘ1�,Z�i���ږ+���3���
���iQԬ�7��Dg����|�W�	+��6k�S���3�õ6�ֳ<\�>K�?p�n�fVǯ�@���w�W��Z2�d��I�s?��q�c�\G�G��xe�E��r7Eq7�f�T�e%;v��1�i�_���HXuS� ~,Vct�X�Uw�?)�����S"��"�6�YAEim���4���@��\]8�+�h�ǡ*���z�E��>�(�Dn���
�w�y�i?��[�"p��/�������sE���
@#2�:�Z�I}��`�V����(F}�=���G�SF7�lV
_g!���� p��㮞�*44OL��q�6�m��K*+V�L��u*V���_�*��B:�̭�ذ3<���ºm�g�\
�^���^-�˓г�0�QO��}\���O��ڽc���o���g�31���:߳qR8-���2�J�NTx�T�M3�2c���@5�:]���I�ԿЉ�r��n�-X�芁T(��A����9j�p$|RJ���R�6of��N��F9?�'���Mi��؛��j۵Z<w���i�&=���M���Mn�7.��"`+^�ɐ!�gd�_�n��|�}�b:a�#ŗMa���	� ^  �G�]�����X�m*b�N��d�!?rx���pi\�����v�A�H`n�U�����hd;2&?|?m�yW����(}y�Ի0�yF���,��چG�(7,1)]��Wr�T*/2���wB��=�/����RU�UJ	L�P?�"+��ߧn'B|o�4/z��5_�d+ڸ�M�0�dMzo/���v&����kb����^��i�&"h�S�S��F㹫{�����f�S5[��;0����}�[	��[7.v.Bǅ?��V�0��$���*�������.��٦q�V�{��b��ˁ.3�W��������>�a�\����[n�ޭн�sJ�Z=N��p��MAw�r�Z�L�||���Gњ�5�P�a%�~]-χda/��k������y
r�Gu��aEA��Cn��m]V��8���4�<��T;k�!:��]� ��</O,�Y��$f�\vč�%�߱�_y�c~��8�}C��Ch<�߲D��E�?2[�<a|�Ɯ�_�E<��f�a��OU����p�2~+$|�xu�<$�}_%+�u��u�����o�/}~�e`�b���<k��kv��?������kK      �   �   x����	D!Ϧ�m��|Q�����}�{� ^�f4AX��P�����i��;ʷb�!�f�ꉑ���,�(K�Y��Nu��``�?�4��4ɫ���'�<�l����,DA4���Ns�������LD?�x�      �      x������ � �      �      x������ � �      �   H   x�3�tO���4�4202�50�52W00�24�24�&�e�锟WZL�c��N���pf�$����%F��� ��'9      �   j   x����� �G6�e9�Sk�C"�D��� |'��X:�=�%�H3�)	����h�X,��1#S�i��7k��P��K��ä���@)?1���~U�S{xec���2�      �     x����n�6���S��!%[���n�)�m��^i�HF$�<~Jv�.r�H 5"g8��3Zh�����Z�u�zw�M-j�#��%�3;ˉ|g=َ�f��l;$}�m2dr��<���h����d��c��C�q�a��%I߼��&Ny�h�e���b|ͦ��X�=���y���l2�5��)^���)�ΰ�޴|�}ǣl���l��f�dp/J5�R_���"w�R�v���ڑ�>j���l�J4X�t��S)Q�<h ���9�k�R4���ۄ��XRgc��M�#�<���r@�v�*4�8�5��wS���ޏŵ�p��5���1�':��̘Q���H�E�w�2�Iq~�����n7s��*}�f}���0��
�TZn�؈F>�CT �|�C�7���6Bm\�Q`�΃�9^e�h����@���{�����T���(�_��^(b��Ga��x��e�i-`�F�.��Z��z'j�le]p}�N���i�K�H&P����I�Z,nj/c��,�.��2$��(��'W%{�9��P��4w�¤�W��#����:�cR��w1dn����T��l��8��M�}���jYoл��m-�&��N�'��yկ0h[��׍���qD����4�bIL�u0��x��S+��AҌ��&LAO%��� 3.���Ϙ���>���qg�`���c� �BrJ�f�m��BrOS�F�1dC,�fVJ�x&����!��LH�D%�%�xG��C��y�??��O�Z��CEO      �   |   x���1�0D��>�\ ��(BJ��iV�"��`���D���f�_�KN����eB S~�%�n���.
�ʣK!�C�C� �KK�~5?��n�+���n���I�A+7�ra���K-���{�	44�      �   		  x��X�rܸ|���I�v 	��7Ƕ�J�}��}������ܒ\��b�}z��*��.K2�]�4z�{֊J���w/��m�/�n�~����%M2�K�i��x��,}ZB/��ܰ���lS/�"��0N2�4�n�r���8�j�?B�_k��uS˪����(cwJ�L%��I��t��kWډR���w�&?���x����.^�OC��Ҹ��M�ʢ�d罼IS�S�P�0r�^�����E~M�|��%�r�����p��9|M������	�(a�S�e�m�}��Q��ީJ�BWN�pT�4�nd��BO��ڈ7~�|��.�%�?�jzt�J�k���p�r�pb��O�ڀ�-~�h0��Р�S��/�i���
wʘ��+�%���������C~$��;EDEc�^�6��ΔN��6�-��m�*�3z���x��)��p���&>q?��q	�2f <�bk�O�N}����z��b=��{��K�w��� ����w
�)����>�z��S��*��/s毲��Th��<�1)���&R�O�1.^�X���)�-�L���{��A��0�n4����p �q�.L�W��P]8 �D��8ԙ!8�[�<�(+f�y����m4@�#����g��X�UQ6����,��4eQVP��&�)�,!��� ��$���s&\>��ŲŐLAz�e�N�������	�"�̟��������}=�4�#�)o��j�s��0kPp�(���-\a��������u���JKUF������� ������5w����3���?c������p��6�HfGRp�����z/O��c�,�>L~�J�0Y?��!���s�#��,�$�]�Q
#]�c�
��(̋.��)����%�Te�lJc�|��N%�֟z��˷~��$ނ�O5|k��U�!�lq�Ό��,������1a��<60QaOH@\�l��LԱ�#^ ��?�Q}"4��BTcg|e��7�̶�M�(@���5�q�ߌ�-��E�����s�RP鏾��j��a7������"S}S�9��D8��[tu�ׇ�S��r���qb�����Z4D�F;UWb�K[k��P�E��J�FO��Jka�?���Q��ʐf򏓕o�����!б�Qc/?��#�V;�=��h�b�2;O�f���gϊ���|`	g *��P������h�A� �vh����Hm(<�C���2�[�V��wrK(�:�[��ni%��wAM1�ؑ�y�[6;����E�m�79���7t��k>�� ��O<M��y6��Y�瘇�|�mGQ�`.�"�m�-�RbWC<�Bo�l
@�>�ЁfZ�M4˟=�]�!r�Li�o� ]f8��kY}6�'�ˏ<@l^�C �D쏁��`�P��k�!�,KS`����"+k��Q=��6�,Q��K�A�s0�V�kU�tCI�l�/N���5M �tR}�Vq�R�L���TW<Fr�Օ8���m�>�c�"�K`��#uGQ,�,%��8CwҜ���N�jG��Ja�)K�ȇ�\�A�F.E�ZK[�g�����!}1H�}�`���%���7�f�D�B�y��m������0)��>r!v�����د�sy�1?#'z��C�BA/��3!O�:JD��1�c:�ҕ��i�
!k*cMS�L(�AtY��T�9`g&|D���w������YW�m���'��O���9�e�d��P��"��nؠ8'ZFa<����3%�T�li������_r|F�TҔ�U��>y*��;��@z{�i�"�2ƻ�ƅ��㎴�n���-����~..�g�[�>)�(̱ۅ�ʹk���lb�+kx�T��P�t_����?�!�	j�r+�����2�`xͬ'����r����^�ɞ���u˻*���}��0t��*9H[[#::�
�]c������QJPʢz�^j�p�� m�|���8���f���9?
=O�V��F�\�W��������{��%�/��B8[�ƀu�i�h35ЫkY)�n���{۔"�*J�����|N���AR�ȳ��>��ūԮ2L=l8��　���J� ��6����2�m���w��t��9s^8���1El�?��iMaY�gV��pVZ,
S*�S+z]�����!#�̭ٓ�N�ȖDZ�;r�s����Y�?b>����7'�����:�#\o����8
���^8?�?'��t8���r���!���B����Y�pN�0,�$ N�Uae�|�t�������91      �   z   x�m˱�  ���F�)�]J�l����H(&P����/y$H���\J�ͧ�࡮�&���0��ŜV���ƨ�!6_^{���T�kº��ۣc�E�k��L�&���#���|*)��$.      �   8   x�3��JL�TH���T�I�̂pJJA##S]C]#sS+C+C#lb\1z\\\ Ι�      �   �   x�e�[
�0���d12�v��E�q�@M�u���X�����; ����Ы��Ӡ���4�g�����~ae��{��.��ڬ)
�	�%&I�cik�����)�3�+��#�,�[L�v�����ig�}�^KU      �      x������ � �      �   ?	  x��Xَ�8|���?P��Ҽy�^`X�3O��n�Z�џ������ U4f�*��Gddd�*+UVeUQU*K��\Ni�̶�o��3���f��qv�vC��mX�[��f����?�mr-��Vo]gz�h������&z~֟��.����~�Wv�ϛ�7�8��l]���ƿZ��_�O��a��ս�E?��3\����U:)K����g�.*KUQ\��Z���p�:e�ڞ�z���b^m&;;��е[����/<�=0����ٺ�z��;p��{����������q��؍��)d�:� �����g��E;������3
�����RU�fWd7I/�oR(X�� �ھL�k�è������m��=	0��ē��#��na�J��4�� 	a���T$�R7��x���q��M���3���qO����l�"(7�|Ui�2��L��k}J3J1LU�WmV�\|������:�t�	4�~lEEO�i,^��p�ߓ������x�c�{�3<�l��诵nA��؞5R��
�Wfn��
�}DnB��J�Y�$u�q^�p���~�P�nu�a7��Ώv��#�o��J��	5>8��7@ ���ϖ��F~�ov�Z'\�NG��c!:��z��z��
�p�3�����E?������8�\� �(/�w	��Sd=`���A�Ӌ��`��Q�?e����i�R8+g�qY	&��?�{��,tƵ�/pfTW%�,����P)
����_�E���D������p7b�n2q=G�c0��hb*3Gm��
����B�	��!_��N��9���@�鐨o6�x���|�{8Q ק,Q�ڐ���˗����5�F��^&K~y�#�P{��,p���~&bοi�5R�K��Gؗ�N ��w���> v���T�&yYdDj ����j1Z�jՇ�(���R�n\L��qc��M��W!�з��`/^έ^�8�.�[FU����:��`�W����^T~��E�{1�3uh[�֫O�e<��n}Z,gN��_�y����\\wl*0<���!r<�^��& bxtd���fe��y!Й�5��6�а�AUF�����Hm��:+�:�95�<Ql�ڻ��`k*� ]z߁���a�r��P�L�`/g�����c��]�q����38I�+$���t���@\����d:{��=���ᆰ��+�(�g�]ɡ��+���	+����_���"vg���+Q���:,CCF_��*.�h�p����Z1�Fq �[����{(,i=�3�V�S�<}fż���VJ�0�ʮg����S�٥�@cR#f��(�C�� G����!)��v��v["5�÷���CY�@`��2�T�q`::�?��|+����j�/��(���u���TZ����4��PHê��no{7f�HJO�>i>"X�S~~ E[�� ����$Y@�{c'�ɳA(V󷻝�u�)�&�U%<'fj���~�9~��s�z�:s0��� E�Z�ҥq��x�;��ѡ��((}�5��2��
��B,����A>y��F�Ө0I5���w�C蠍ڙuzCY�<ٲ�"���2�� ��p�Fw�]�Y^SV�T~I�<D�'`2g�}L��;��I9Ro5	!RǰeeQ�p�hp��J�����2B�n=�TTP���	�*	��}�s�ð��M���!т�#��, 9D���a�g<���7��&x44S�P�0C$���� �^��e�lTf4��w�z�5�'xG�pO�Â�s*��C��%�;��)�0�����ཆ����Ś�xI��Ez��왔�8b�t���dN�v񂬽��g3��h$��s_?�u��I4�w���Ϟ�7_qp����HU���r)*�Nh��Z��F#�O,����e��0e���b4J'���lұ�V%�~5C���vgTa���=����L<��@z���6އ%�sK~?��`���<�	L���T'~��7 �R��zhנ�e{���g�01�:�TE��J�"T������e,�HF�G�~��\�#�W��c�� �O��]d��wX����VfP�%�yE܊Z�WB5��W�͠<�p>�|�D"Q'SQ�H�L��ݰ��ţ�>�$������:����%�z>v�>������$�[?�1����/n����5��v8���\��c�G��^W��J�"+/�".4��q[Q\Y�/�OH
dwPC��;Kf�7F}�_�h���rY����v�ys
f+e�P_�p�B!C��U""}���c��o���=_�j+�|�x�I�߽�$�c	��S������?u׷����ݻw�ʂ��      �   �  x�5OMo�0<'��c+���U{����V����_iLL@	)�_�����ތ��L��:����l�R`��fx��p�YWWУĜ�	Ќ�:��zR&s}�*OT��*>Q�H�(#�/�-��idA��M�s3���7���/E�S�8Ev�����RW�@��AU��\ďd�H��vJ���RS�����P�xU�=|�!�0p����P�T�Wz�¢�mX��'	9�n���@x���d^��<�"����FdU'��O�h[�ܵѮ7��nx��v�+��K�eT?&�{����Fe�%�/yl?n�3m?���T�����;���x�����u#f�d��8{�[5�!����F��jy�Jr�|"#Xc4<���b����>��x9nC^���UNp���+!�=���	0��BS�����t:�����      �   r  x����r�0�x�.����-�
w��%���ؖ��%��ep���-�΄m�o����e��Z
�0;*A�A�~ˁ��K8���b�ԟfJL��T2�U�_-���=���4͂�`=��Z�u��C�_?0z� ۲k���߬Z�X-b���쓦�s&�}���Z��V�<�ob�ҸQ���f�[��C't�jH�`�3YzO#�7�
R0X+#ƋABú��iLq"�'M7	1�[���[eAhYߍ恝��.v�C�[9�׭�{��]o|��U���*����rnV������ʌ�Qe��*3�O�����j5A�pތV�j(M%��>1�|�@���u���c3�s�:����
\A�����2�11���j朷��jz����a���2�m�L|��8�S��K��ؔ\��C��[��ɩ�{0qI��z�� �/����]k"�Y�R�:��M1���� ����Guo>�Oӈu\�`����R�#���Q#���z��mz�ְ���	:ޘ�-�9���ۡ�:�!ľ�����ݧ���0��m��� bW���X�3����sݷ�l>u�.���tf3����	�G���E�~���[�Ѳ�s��;.�J? '��     