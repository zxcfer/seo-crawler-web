DROP TABLE assigned_roles;
CREATE TABLE assigned_roles ( id int(10) unsigned NOT NULL AUTO_INCREMENT, user_id int(10) unsigned NOT NULL, role_id int(10) unsigned NOT NULL, PRIMARY KEY (id), INDEX assigned_roles_user_id_index (user_id), INDEX assigned_roles_role_id_index (role_id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into assigned_roles (id, user_id, role_id) values (1, 1, 1);
insert into assigned_roles (id, user_id, role_id) values (2, 2, 2);
DROP TABLE cities;
CREATE TABLE cities ( id bigint NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL, region_id bigint, PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into cities (id, name, region_id) values (1, 'Lima', 15);
DROP TABLE comments;
CREATE TABLE comments ( id int(10) unsigned NOT NULL AUTO_INCREMENT, user_id int(10) unsigned NOT NULL, post_id int(10) unsigned NOT NULL, content text COLLATE utf8_unicode_ci NOT NULL, created_at timestamp DEFAULT '0000-00-00 00:00:00', updated_at timestamp DEFAULT '0000-00-00 00:00:00', PRIMARY KEY (id), INDEX comments_user_id_index (user_id), INDEX comments_post_id_index (post_id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into comments (id, user_id, post_id, content, created_at, updated_at) values (1, 1, 1, 'Lorem ipsum dolor sit amet, mutat utinam nonumy ea mel.', '2014-09-30 20:43:56', '2014-09-30 20:43:56');
insert into comments (id, user_id, post_id, content, created_at, updated_at) values (2, 1, 1, 'Lorem ipsum dolor sit amet, sale ceteros liberavisse duo ex, nam mazim maiestatis dissentiunt no. Iusto nominavi cu sed, has.', '2014-09-30 20:43:56', '2014-09-30 20:43:56');
insert into comments (id, user_id, post_id, content, created_at, updated_at) values (3, 1, 1, 'Et consul eirmod feugait mel! Te vix iuvaret feugiat repudiandae. Solet dolore lobortis mei te, saepe habemus imperdiet ex vim. Consequat signiferumque per no, ne pri erant vocibus invidunt te.', '2014-09-30 20:43:56', '2014-09-30 20:43:56');
insert into comments (id, user_id, post_id, content, created_at, updated_at) values (4, 1, 2, 'Lorem ipsum dolor sit amet, mutat utinam nonumy ea mel.', '2014-09-30 20:43:56', '2014-09-30 20:43:56');
insert into comments (id, user_id, post_id, content, created_at, updated_at) values (5, 1, 2, 'Lorem ipsum dolor sit amet, sale ceteros liberavisse duo ex, nam mazim maiestatis dissentiunt no. Iusto nominavi cu sed, has.', '2014-09-30 20:43:56', '2014-09-30 20:43:56');
insert into comments (id, user_id, post_id, content, created_at, updated_at) values (6, 1, 3, 'Lorem ipsum dolor sit amet, mutat utinam nonumy ea mel.', '2014-09-30 20:43:56', '2014-09-30 20:43:56');
DROP TABLE companies;
CREATE TABLE companies ( id bigint NOT NULL AUTO_INCREMENT, name varchar(255), code varchar(20), status varchar(1) DEFAULT 'I' NOT NULL, business_type varchar(100), description text, address varchar(255), zip varchar(20), email varchar(255), phone varchar(20), fax varchar(20), city_id bigint, region_id bigint(255), country varchar(255), created_at datetime, updated_at datetime, user_id bigint, url varchar(255), PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into companies (id, name, code, status, business_type, description, address, zip, email, phone, fax, city_id, region_id, country, created_at, updated_at, user_id, url) values (1, null, null, 'I', null, null, null, null, null, null, null, null, null, null, '2015-01-29 07:31:57', '2015-01-29 07:31:57', 0, null);
insert into companies (id, name, code, status, business_type, description, address, zip, email, phone, fax, city_id, region_id, country, created_at, updated_at, user_id, url) values (2, 'sdf sdf ds', null, 'A', null, 'fsdfds', null, null, null, null, null, null, null, null, '2015-01-29 07:34:22', '2015-01-29 07:34:22', 3, 'fsdfdsfds');
insert into companies (id, name, code, status, business_type, description, address, zip, email, phone, fax, city_id, region_id, country, created_at, updated_at, user_id, url) values (3, 'asdasdas', null, 'A', null, '', null, null, null, null, null, null, null, null, '2015-02-23 21:49:59', '2015-02-23 21:49:59', 2, '');
DROP TABLE districts;
CREATE TABLE districts ( id bigint NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL, city_id bigint, PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into districts (id, name, city_id) values (1, 'Breña', null);
insert into districts (id, name, city_id) values (2, 'La Victoria', null);
insert into districts (id, name, city_id) values (3, 'Lima', null);
insert into districts (id, name, city_id) values (4, 'Lince', null);
insert into districts (id, name, city_id) values (5, 'Rimac', null);
insert into districts (id, name, city_id) values (6, 'Barranco', null);
insert into districts (id, name, city_id) values (7, 'Jesús María', null);
insert into districts (id, name, city_id) values (8, 'La Molina', null);
insert into districts (id, name, city_id) values (9, 'Magdalena', null);
insert into districts (id, name, city_id) values (10, 'Miraflores', null);
insert into districts (id, name, city_id) values (11, 'Pueblo Libre', null);
insert into districts (id, name, city_id) values (12, 'San Borja', null);
insert into districts (id, name, city_id) values (13, 'San Isidro', null);
insert into districts (id, name, city_id) values (14, 'San Luis', null);
insert into districts (id, name, city_id) values (15, 'San Miguel', null);
insert into districts (id, name, city_id) values (16, 'Santiago de Surco', null);
insert into districts (id, name, city_id) values (17, 'Surquillo', null);
insert into districts (id, name, city_id) values (18, 'Ate', null);
insert into districts (id, name, city_id) values (19, 'Cieneguilla', null);
insert into districts (id, name, city_id) values (20, 'Distrito de Chaclacayo', null);
insert into districts (id, name, city_id) values (21, 'El Agustino', null);
insert into districts (id, name, city_id) values (22, 'Lurigancho-Chosica', null);
insert into districts (id, name, city_id) values (23, 'Santa Anita', null);
insert into districts (id, name, city_id) values (24, 'Ancón', null);
insert into districts (id, name, city_id) values (25, 'Carabayllo', null);
insert into districts (id, name, city_id) values (26, 'Comas', null);
insert into districts (id, name, city_id) values (27, 'Independencia', null);
insert into districts (id, name, city_id) values (28, 'Los Olivos', null);
insert into districts (id, name, city_id) values (29, 'Puente Piedra', null);
insert into districts (id, name, city_id) values (30, 'San Juan de Lurigancho', null);
insert into districts (id, name, city_id) values (31, 'San Martin de Porres', null);
insert into districts (id, name, city_id) values (32, 'Santa Rosa', null);
insert into districts (id, name, city_id) values (33, 'Chorrillos', null);
insert into districts (id, name, city_id) values (34, 'Lurín', null);
insert into districts (id, name, city_id) values (35, 'Pachacamac', null);
insert into districts (id, name, city_id) values (36, 'Pucusana', null);
insert into districts (id, name, city_id) values (37, 'Punta Hermosa', null);
insert into districts (id, name, city_id) values (38, 'Punta Negra', null);
insert into districts (id, name, city_id) values (39, 'San Bartolo', null);
insert into districts (id, name, city_id) values (40, 'San Juan de Miraflores', null);
insert into districts (id, name, city_id) values (41, 'Santa María del Mar', null);
insert into districts (id, name, city_id) values (42, 'Villa el Salvador', null);
insert into districts (id, name, city_id) values (43, 'Villa María del Triunfo', null);
DROP TABLE likeable_like_counters;
CREATE TABLE likeable_like_counters ( id int(10) unsigned NOT NULL AUTO_INCREMENT, likable_id varchar(36) COLLATE utf8_unicode_ci NOT NULL, likable_type varchar(255) COLLATE utf8_unicode_ci NOT NULL, count int(10) unsigned DEFAULT '0' NOT NULL, PRIMARY KEY (id), CONSTRAINT likeable_counts UNIQUE (likable_id, likable_type) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE likeable_likes;
CREATE TABLE likeable_likes ( id int(10) unsigned NOT NULL AUTO_INCREMENT, likable_id varchar(36) COLLATE utf8_unicode_ci NOT NULL, likable_type varchar(255) COLLATE utf8_unicode_ci NOT NULL, user_id varchar(36) COLLATE utf8_unicode_ci NOT NULL, created_at timestamp DEFAULT '0000-00-00 00:00:00', updated_at timestamp DEFAULT '0000-00-00 00:00:00', PRIMARY KEY (id), CONSTRAINT likeable_likes_unique UNIQUE (likable_id, likable_type, user_id), INDEX likeable_likes_user_id_index (user_id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE migrations;
CREATE TABLE migrations ( migration varchar(255) COLLATE utf8_unicode_ci NOT NULL, batch int NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into migrations (migration, batch) values ('2013_02_05_024934_confide_setup_users_table', 1);
insert into migrations (migration, batch) values ('2013_02_05_043505_create_posts_table', 1);
insert into migrations (migration, batch) values ('2013_02_05_044505_create_comments_table', 1);
insert into migrations (migration, batch) values ('2013_02_08_031702_entrust_setup_tables', 1);
insert into migrations (migration, batch) values ('2013_05_21_024934_entrust_permissions', 1);
insert into migrations (migration, batch) values ('2014_09_10_065447_create_likeable_tables', 2);
DROP TABLE password_reminders;
CREATE TABLE password_reminders ( email varchar(255) COLLATE utf8_unicode_ci NOT NULL, token varchar(255) COLLATE utf8_unicode_ci NOT NULL, created_at timestamp DEFAULT '0000-00-00 00:00:00' ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DROP TABLE permission_role;
CREATE TABLE permission_role ( id int(10) unsigned NOT NULL AUTO_INCREMENT, permission_id int(10) unsigned NOT NULL, role_id int(10) unsigned NOT NULL, PRIMARY KEY (id), CONSTRAINT permission_role_permission_id_role_id_unique UNIQUE (permission_id, role_id), INDEX permission_role_permission_id_index (permission_id), INDEX permission_role_role_id_index (role_id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into permission_role (id, permission_id, role_id) values (1, 1, 1);
insert into permission_role (id, permission_id, role_id) values (2, 2, 1);
insert into permission_role (id, permission_id, role_id) values (3, 3, 1);
insert into permission_role (id, permission_id, role_id) values (4, 4, 1);
insert into permission_role (id, permission_id, role_id) values (5, 5, 1);
insert into permission_role (id, permission_id, role_id) values (6, 6, 1);
insert into permission_role (id, permission_id, role_id) values (7, 6, 2);
DROP TABLE permissions;
CREATE TABLE permissions ( id int(10) unsigned NOT NULL AUTO_INCREMENT, name varchar(255) COLLATE utf8_unicode_ci NOT NULL, display_name varchar(255) COLLATE utf8_unicode_ci NOT NULL, PRIMARY KEY (id), CONSTRAINT permissions_name_unique UNIQUE (name), CONSTRAINT permissions_display_name_unique UNIQUE (display_name) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into permissions (id, name, display_name) values (1, 'manage_blogs', 'manage blogs');
insert into permissions (id, name, display_name) values (2, 'manage_posts', 'manage posts');
insert into permissions (id, name, display_name) values (3, 'manage_comments', 'manage comments');
insert into permissions (id, name, display_name) values (4, 'manage_users', 'manage users');
insert into permissions (id, name, display_name) values (5, 'manage_roles', 'manage roles');
insert into permissions (id, name, display_name) values (6, 'post_comment', 'post comment');
DROP TABLE posts;
CREATE TABLE posts ( id int(10) unsigned NOT NULL AUTO_INCREMENT, user_id int(10) unsigned NOT NULL, title varchar(255) COLLATE utf8_unicode_ci NOT NULL, slug varchar(255) COLLATE utf8_unicode_ci NOT NULL, content text COLLATE utf8_unicode_ci NOT NULL, meta_title varchar(255) COLLATE utf8_unicode_ci NOT NULL, meta_description varchar(255) COLLATE utf8_unicode_ci NOT NULL, meta_keywords varchar(255) COLLATE utf8_unicode_ci NOT NULL, created_at timestamp DEFAULT '0000-00-00 00:00:00', updated_at timestamp DEFAULT '0000-00-00 00:00:00', status varchar(10) COLLATE utf8_unicode_ci DEFAULT 'I' NOT NULL, city_id bigint, image varchar(255) COLLATE utf8_unicode_ci, website varchar(255) COLLATE utf8_unicode_ci, category varchar(2) COLLATE utf8_unicode_ci, type varchar(2) COLLATE utf8_unicode_ci, email varchar(255) COLLATE utf8_unicode_ci, company_id bigint, url varchar(255) COLLATE utf8_unicode_ci NOT NULL, disable_on datetime, enable_on datetime, price decimal(20,2), country varchar(255) COLLATE utf8_unicode_ci, region_id bigint(255), district varchar(255) COLLATE utf8_unicode_ci, PRIMARY KEY (id), INDEX posts_user_id_index (user_id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (1, 1, 'Fernando Vasquez', 'lorem-ipsum-dolor-sit-amet', 'In mea autem etiam menandri, quot elitr vim ei, eos semper disputationi id? Per facer appetere eu, duo et animal maiestatis. Omnesque invidunt mnesarchum ex mel, vis no case senserit dissentias. Te mei minimum singulis inimicus, ne labores accusam necessitatibus vel, vivendo nominavi ne sed. Posidonium scriptorem consequuntur cum ex? Posse fabulas iudicabit in nec, eos cu electram forensibus, pro ei commodo tractatos reformidans. Qui eu lorem augue alterum, eos in facilis pericula mediocritatem?

Est hinc legimus oporteat in. Sit ei melius delicatissimi. Duo ex qualisque adolescens! Pri cu solum aeque. Aperiri docendi vituperatoribus has ea!

Sed ut ludus perfecto sensibus, no mea iisque facilisi. Choro tation melius et mea, ne vis nisl insolens. Vero autem scriptorem cu qui? Errem dolores no nam, mea tritani platonem id! At nec tantas consul, vis mundi petentium elaboraret ex, mel appareat maiestatis at.

Sed et eros concludaturque. Mel ne aperiam comprehensam! Ornatus delicatissimi eam ex, sea an quidam tritani placerat? Ad eius iriure consequat eam, mazim temporibus conclusionemque eum ex.

Te amet sumo usu, ne autem impetus scripserit duo, ius ei mutat labore inciderint! Id nulla comprehensam his? Ut eam deleniti argumentum, eam appellantur definitionem ad. Pro et purto partem mucius!

Cu liber primis sed, esse evertitur vis ad. Ne graeco maiorum mea! In eos nostro docendi conclusionemque. Ne sit audire blandit tractatos? An nec dicam causae meliore, pro tamquam offendit efficiendi ut.

Te dicta sadipscing nam, denique albucius conclusionemque ne usu, mea eu euripidis philosophia! Qui at vivendo efficiendi! Vim ex delenit blandit oportere, in iriure placerat cum. Te cum meis altera, ius ex quis veri.

Mutat propriae eu has, mel ne veri bonorum tincidunt. Per noluisse sensibus honestatis ut, stet singulis ea eam, his dicunt vivendum mediocrem ei. Ei usu mutat efficiantur, eum verear aperiam definitiones an! Simul dicam instructior ius ei. Cu ius facer doming cotidieque! Quot principes eu his, usu vero dicat an.

Ex dicta perpetua qui, pericula intellegam scripserit id vel. Id fabulas ornatus necessitatibus mel. Prompta dolorem appetere ea has. Vel ad expetendis instructior!

Te his dolorem adversarium? Pri eu rebum viris, tation molestie id pri. Mel ei stet inermis dissentias. Sed ea dolorum detracto vituperata. Possit oportere similique cu nec, ridens animal quo ex?', 'meta_title1', 'meta_description1', 'meta_keywords1', '2015-01-29 07:03:45', '2014-09-30 20:43:56', 'A', null, null, null, null, null, null, null, '', null, null, null, null, null, null);
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (2, 1, 'Vivendo suscipiantur vim te vix', 'vivendo-suscipiantur-vim-te-vix', 'In mea autem etiam menandri, quot elitr vim ei, eos semper disputationi id? Per facer appetere eu, duo et animal maiestatis. Omnesque invidunt mnesarchum ex mel, vis no case senserit dissentias. Te mei minimum singulis inimicus, ne labores accusam necessitatibus vel, vivendo nominavi ne sed. Posidonium scriptorem consequuntur cum ex? Posse fabulas iudicabit in nec, eos cu electram forensibus, pro ei commodo tractatos reformidans. Qui eu lorem augue alterum, eos in facilis pericula mediocritatem?

Est hinc legimus oporteat in. Sit ei melius delicatissimi. Duo ex qualisque adolescens! Pri cu solum aeque. Aperiri docendi vituperatoribus has ea!

Sed ut ludus perfecto sensibus, no mea iisque facilisi. Choro tation melius et mea, ne vis nisl insolens. Vero autem scriptorem cu qui? Errem dolores no nam, mea tritani platonem id! At nec tantas consul, vis mundi petentium elaboraret ex, mel appareat maiestatis at.

Sed et eros concludaturque. Mel ne aperiam comprehensam! Ornatus delicatissimi eam ex, sea an quidam tritani placerat? Ad eius iriure consequat eam, mazim temporibus conclusionemque eum ex.

Te amet sumo usu, ne autem impetus scripserit duo, ius ei mutat labore inciderint! Id nulla comprehensam his? Ut eam deleniti argumentum, eam appellantur definitionem ad. Pro et purto partem mucius!

Cu liber primis sed, esse evertitur vis ad. Ne graeco maiorum mea! In eos nostro docendi conclusionemque. Ne sit audire blandit tractatos? An nec dicam causae meliore, pro tamquam offendit efficiendi ut.

Te dicta sadipscing nam, denique albucius conclusionemque ne usu, mea eu euripidis philosophia! Qui at vivendo efficiendi! Vim ex delenit blandit oportere, in iriure placerat cum. Te cum meis altera, ius ex quis veri.

Mutat propriae eu has, mel ne veri bonorum tincidunt. Per noluisse sensibus honestatis ut, stet singulis ea eam, his dicunt vivendum mediocrem ei. Ei usu mutat efficiantur, eum verear aperiam definitiones an! Simul dicam instructior ius ei. Cu ius facer doming cotidieque! Quot principes eu his, usu vero dicat an.

Ex dicta perpetua qui, pericula intellegam scripserit id vel. Id fabulas ornatus necessitatibus mel. Prompta dolorem appetere ea has. Vel ad expetendis instructior!

Te his dolorem adversarium? Pri eu rebum viris, tation molestie id pri. Mel ei stet inermis dissentias. Sed ea dolorum detracto vituperata. Possit oportere similique cu nec, ridens animal quo ex?', 'meta_title2', 'meta_description2', 'meta_keywords2', '2015-01-29 07:03:45', '2014-09-30 20:43:56', 'A', null, null, null, null, null, null, null, '', null, null, null, null, null, null);
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (3, 1, 'In iisque similique reprimique eum', 'in-iisque-similique-reprimique-eum', 'In mea autem etiam menandri, quot elitr vim ei, eos semper disputationi id? Per facer appetere eu, duo et animal maiestatis. Omnesque invidunt mnesarchum ex mel, vis no case senserit dissentias. Te mei minimum singulis inimicus, ne labores accusam necessitatibus vel, vivendo nominavi ne sed. Posidonium scriptorem consequuntur cum ex? Posse fabulas iudicabit in nec, eos cu electram forensibus, pro ei commodo tractatos reformidans. Qui eu lorem augue alterum, eos in facilis pericula mediocritatem?

Est hinc legimus oporteat in. Sit ei melius delicatissimi. Duo ex qualisque adolescens! Pri cu solum aeque. Aperiri docendi vituperatoribus has ea!

Sed ut ludus perfecto sensibus, no mea iisque facilisi. Choro tation melius et mea, ne vis nisl insolens. Vero autem scriptorem cu qui? Errem dolores no nam, mea tritani platonem id! At nec tantas consul, vis mundi petentium elaboraret ex, mel appareat maiestatis at.

Sed et eros concludaturque. Mel ne aperiam comprehensam! Ornatus delicatissimi eam ex, sea an quidam tritani placerat? Ad eius iriure consequat eam, mazim temporibus conclusionemque eum ex.

Te amet sumo usu, ne autem impetus scripserit duo, ius ei mutat labore inciderint! Id nulla comprehensam his? Ut eam deleniti argumentum, eam appellantur definitionem ad. Pro et purto partem mucius!

Cu liber primis sed, esse evertitur vis ad. Ne graeco maiorum mea! In eos nostro docendi conclusionemque. Ne sit audire blandit tractatos? An nec dicam causae meliore, pro tamquam offendit efficiendi ut.

Te dicta sadipscing nam, denique albucius conclusionemque ne usu, mea eu euripidis philosophia! Qui at vivendo efficiendi! Vim ex delenit blandit oportere, in iriure placerat cum. Te cum meis altera, ius ex quis veri.

Mutat propriae eu has, mel ne veri bonorum tincidunt. Per noluisse sensibus honestatis ut, stet singulis ea eam, his dicunt vivendum mediocrem ei. Ei usu mutat efficiantur, eum verear aperiam definitiones an! Simul dicam instructior ius ei. Cu ius facer doming cotidieque! Quot principes eu his, usu vero dicat an.

Ex dicta perpetua qui, pericula intellegam scripserit id vel. Id fabulas ornatus necessitatibus mel. Prompta dolorem appetere ea has. Vel ad expetendis instructior!

Te his dolorem adversarium? Pri eu rebum viris, tation molestie id pri. Mel ei stet inermis dissentias. Sed ea dolorum detracto vituperata. Possit oportere similique cu nec, ridens animal quo ex?', 'meta_title3', 'meta_description3', 'meta_keywords3', '2015-01-29 07:03:45', '2014-09-30 20:43:56', 'A', null, null, null, null, null, null, null, '', null, null, null, null, null, null);
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (78, 1, 'Coordinador Logístico - Selva', '', 'Coordinador Logistico -  (Campamento Selva)    BENEFICIOS:    Ingreso a planilla con todos los beneficios de acuerdo a ley.  Seguro de accidentes laborales.  Oportunidad de desarrollo profesional y gr ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/coordinador-logistico-selva-93muz', null, null, null, null, null, 'San Isidro');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (79, 1, 'AUXILIAR DE ALMACÉN CREACIÓN DE CODIGOS', '', 'Nuestro cliente, importante empresa trans- Nacional del rubro de Productos Electricos proveedor de a empresas Industriales y Minería Requiere de un AUXILIAR DE ALMACÉN/CREACIÓN DE CÓDIGOS   Requisitos ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/auxiliar-de-almacen-creacion-de-codigos-95t64', null, null, null, null, null, 'Chorrillos');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (80, 1, 'Asistente de logistica', '', 'Nuestra empresa una de las más importantes en el rubro de Publicidad Exterior, estamos en la búsqueda de un joven profesional para ejercer el cargo de Asistente de Logistica.    Deberá contar con form ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/asistente-de-logistica-ushm6', null, null, null, null, null, 'Villa Maria del Triunfo');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (81, 1, 'Asistente de logistica', '', 'Nuestra empresa una de las más importantes en el rubro de Publicidad Exterior, estamos en la búsqueda de un joven profesional para ejercer el cargo de Asistente de Logistica.    Deberá contar con form ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/asistente-de-logistica-t5hdq', null, null, null, null, null, 'Villa Maria del Triunfo');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (82, 1, 'INVENTARIADOR', '', 'Inventariador físico, tienda almacén, codificar, ubicar, limpiar, digitar ,auditar ingresos y salidas, en tienda en producción   Requisitos: - Estudios técnicos o universitarios concluidos  Deben tene ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/inventariador-arum9', null, null, null, null, null, 'Cercado de Lima');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (83, 1, 'Practicante de Ingeniería Industrial', '', 'Empresa minera requiere de 01 profesional egresado de la carrera Ingeniería Industrial para ocupar la posición de Practicante.    Experiencia mínima de 06 meses en el área logística, almacenes, planea ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/practicante-de-ingenieria-industrial-mdutt', null, null, null, null, null, 'Jesus Maria');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (84, 1, 'EMPACADOR ', '', 'Somos un laboratorio líder en el mercado farmacéutico a nivel nacional, contamos con más de 50 años de trayectoria ofreciendo productos de la más alta calidad. En la actualidad, deseamos integrar a nu ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/empacador-qg29g', null, null, null, null, null, 'Lince');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (85, 1, 'AUXILIAR DE INVENTARIOS', '', '?Controlar los movimientos de inventario (ingresos, salidas, ubicaciones, estados) de las agencias, bodegas, mayoreo, materiales y servicio técnico con su debida justificación.  ?Realizar el control y ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/auxiliar-de-inventarios-erq28', null, null, null, null, null, 'La Libertad');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (86, 1, 'ASISTENTE DE LOGÌSTICA', '', 'FUNCIONES:  -Traslado de equipos a los diferentes laboratorios para cambio de partes.  -Control del Merchandising Toshiba.  -Control y custodia de equipos de los clientes.  -Tener los equipos protegid ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/asistente-de-log-stica-q7j9t', null, null, null, null, null, 'Miraflores');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (87, 1, 'Operario de Almacen ', '', 'Empresas Industrial Metalmecánica desea incorporar operarios de Almacen    Requisito :    -Edad : 19 a 35 años    Funciones    - Acomodar, registrar, cargar y descargar la mercaderia    Otros    Acérc ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/operario-de-almacen-u8m7m', null, null, null, null, null, 'Bellavista');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (88, 1, 'ASISTENTE DE COMPRAS', '', '?	Encargado de la cotización .  ?	Responsable de la logística (Cotización de material, verificación de stock, Autorizaciones, orden de compra , descuentos, pagos en efectivo, guías, facturas, percepci ...', '', '', '', '2015-02-11 17:28:30', '2015-02-11 17:28:30', 'A', null, null, 'aptitus.com', 'AD', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/asistente-de-compras-4ym76', null, null, null, null, null, 'Cercado de Lima');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (89, 1, 'Tesorera - Chorrillos', '', 'Cadena de restaurantes requiere contratar 1 TESORERA para la zona de Chorrillos.    requisitos:  - Bachiller de economía o contabilidad  - Experiencia mínima de 2 años como tesorera  - Conocimientos d ...', '', '', '', '2015-02-11 17:28:32', '2015-02-11 17:28:32', 'A', null, null, 'aptitus.com', 'FI', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/tesorera-chorrillos-p7826', null, null, null, null, null, 'Chorrillos');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (90, 1, 'Auxiliar de cobranzas', '', 'TESORERIA COBRANZAS ...', '', '', '', '2015-02-11 17:28:32', '2015-02-11 17:28:32', 'A', null, null, 'aptitus.com', 'FI', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/auxiliar-de-cobranzas-763p7', null, null, null, null, null, 'Surquillo');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (91, 1, 'SUPERVISOR DE FORMACIÓN - LIMA ESTE', '', 'COMPARTAMOS FINANCIERA, empresa líder en el sector de las microfinanzas con solidez y crecimiento en el mercado Peruano y miembro del Grupo GENTERA, continúa con su plan de expansión y crecimiento por ...', '', '', '', '2015-02-11 17:28:32', '2015-02-11 17:28:32', 'A', null, null, 'aptitus.com', 'FI', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/supervisor-de-formacion-lima-este-z93at', null, null, null, null, null, 'Santa Anita');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (92, 1, 'PART TIME MAÑANA C/S EXPERIENCIA_MEDIO_TIEMPO', '', 'A TODOS LOS POSTULANTES. Se Requiere Personal C/S Experiencia Para Labores De Oficina En Un Buen Ambiente Laboral, 4 H/D (PART TIME) De LUNES - VIERNES, Personas De 17- 45 Años De Edad. Únete A Nuestr ...', '', '', '', '2015-02-11 17:28:32', '2015-02-11 17:28:32', 'A', null, null, 'aptitus.com', 'FI', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/part-time-manana-c-s-experiencia-medio-tiempo-apuqm', null, null, null, null, null, 'Los Olivos');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (93, 1, 'Jefe de crédito y cobranza', '', '- Analizar y evaluar el pedido de los clientes.  - Visitar a lso principales clientes de cada zona.  - Supervisar las funciones del personal a su cargo. - Morosidad de la empresa. ...', '', '', '', '2015-02-11 17:28:32', '2015-02-11 17:28:32', 'A', null, null, 'aptitus.com', 'FI', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/jefe-de-credito-y-cobranza-mnjmy', null, null, null, null, null, 'Chorrillos');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (94, 1, 'Practicante Profesional de Finanzas', '', 'Empresa que ayuda a sus clientes a lograr plenamente la Promesa Tecnológica. Ninguna otra compañía proporciona toda la gama de tecnología global y servicios logísticos a sus clientes a nivel mundial.  ...', '', '', '', '2015-02-11 17:28:32', '2015-02-11 17:28:32', 'A', null, null, 'aptitus.com', 'FI', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/practicante-profesional-de-finanzas-9ap4y', null, null, null, null, null, 'San Isidro');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (95, 1, 'Encargado de Créditos y Cobranzas', '', 'Importante Operador Logístico se encuentra en la búsqueda de un Profesional que cumpla el siguiente perfil:    REQUISITOS:  - Titulado en Contabilidad, Economía, Administración, Ing. Industrial y/o af ...', '', '', '', '2015-02-11 17:28:33', '2015-02-11 17:28:33', 'A', null, null, 'aptitus.com', 'FI', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/encargado-de-creditos-y-cobranzas-6mdgv', null, null, null, null, null, 'Ate');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (96, 1, 'Asistente de Finanzas y Tesoreria', '', 'Importante grupo empresarial líder a nivel nacional en el rubro de consumo masivo (Distribución, almacén, ventas y transporte de bebidas gasificadas no alcohólicas Coca Cola - Inca Kola) , se encuentr ...', '', '', '', '2015-02-11 17:28:33', '2015-02-11 17:28:33', 'A', null, null, 'aptitus.com', 'FI', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/asistente-de-finanzas-y-tesoreria-6mgh5', null, null, null, null, null, 'San Isidro');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (97, 1, 'Cobrador  Mensajero', '', 'ARCHIVO DE DOCUMENTOS.    COBRANZA A CLIENTES.    COMPETENCIAS  - PROACTIVO  - ORDENADO  - HONESTO  - TENER INICIATIVA  - TRABAJO EN EQUIPO    EDAD ENTRE 20 A 28 AÑOS           CONOCIMIENTOS ZONAS -RU ...', '', '', '', '2015-02-11 17:28:33', '2015-02-11 17:28:33', 'A', null, null, 'aptitus.com', 'FI', null, null, null, 'http://aptitus.comhttp://aptitus.com/ofertas-de-trabajo/cobrador-mensajero-238ne', null, null, null, null, null, 'Callao');
insert into posts (id, user_id, title, slug, content, meta_title, meta_description, meta_keywords, created_at, updated_at, status, city_id, image, website, category, type, email, company_id, url, disable_on, enable_on, price, country, region_id, district) values (99, 2, 'asdasd', 'asdasd', 'asdas;kd sa;kd;sakdodsjoifgdaj foijdsa fijds foijsda ofij dsafafd
dsjf ojsad flksjda fkjds lfkdsj flkdsj flksjd fdskafd
lkjsadfj lsadk', 'asdasd', '', '', '2015-02-23 21:49:59', '2015-02-23 21:49:59', 'I', null, null, null, null, null, null, null, '', null, null, null, null, null, null);
DROP TABLE regions;
CREATE TABLE regions ( id bigint NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL, country varchar(255), PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into regions (id, name, country) values (1, 'Amazonas', 'PE');
insert into regions (id, name, country) values (2, 'Áncash', 'PE');
insert into regions (id, name, country) values (3, 'Apurímac', 'PE');
insert into regions (id, name, country) values (4, 'Arequipa', 'PE');
insert into regions (id, name, country) values (5, 'Ayacucho', 'PE');
insert into regions (id, name, country) values (6, 'Cajamarca', 'PE');
insert into regions (id, name, country) values (7, 'Callao', 'PE');
insert into regions (id, name, country) values (8, 'Cuzco', 'PE');
insert into regions (id, name, country) values (9, 'Huancavelica', 'PE');
insert into regions (id, name, country) values (10, 'Huánuco', 'PE');
insert into regions (id, name, country) values (11, 'Ica', 'PE');
insert into regions (id, name, country) values (12, 'Junín', 'PE');
insert into regions (id, name, country) values (13, 'La Libertad', 'PE');
insert into regions (id, name, country) values (14, 'Lambayeque', 'PE');
insert into regions (id, name, country) values (15, 'Lima', 'PE');
insert into regions (id, name, country) values (16, 'Loreto', 'PE');
insert into regions (id, name, country) values (17, 'Madre de Dios', 'PE');
insert into regions (id, name, country) values (18, 'Moquegua', 'PE');
insert into regions (id, name, country) values (19, 'Pasco', 'PE');
insert into regions (id, name, country) values (20, 'Piura', 'PE');
insert into regions (id, name, country) values (21, 'Puno', 'PE');
insert into regions (id, name, country) values (22, 'San Martín', 'PE');
insert into regions (id, name, country) values (23, 'Tacna', 'PE');
insert into regions (id, name, country) values (24, 'Tumbes', 'PE');
insert into regions (id, name, country) values (25, 'Ucayali', 'PE');
DROP TABLE roles;
CREATE TABLE roles ( id int(10) unsigned NOT NULL AUTO_INCREMENT, name varchar(255) COLLATE utf8_unicode_ci NOT NULL, created_at timestamp DEFAULT '0000-00-00 00:00:00', updated_at timestamp DEFAULT '0000-00-00 00:00:00', PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into roles (id, name, created_at, updated_at) values (1, 'admin', '2014-09-30 20:43:56', '2014-09-30 20:43:56');
insert into roles (id, name, created_at, updated_at) values (2, 'comment', '2014-09-30 20:43:56', '2014-09-30 20:43:56');
DROP TABLE users;
CREATE TABLE users ( id int(10) unsigned NOT NULL AUTO_INCREMENT, username varchar(255) COLLATE utf8_unicode_ci NOT NULL, email varchar(255) COLLATE utf8_unicode_ci NOT NULL, password varchar(255) COLLATE utf8_unicode_ci NOT NULL, confirmation_code varchar(255) COLLATE utf8_unicode_ci NOT NULL, remember_token varchar(255) COLLATE utf8_unicode_ci, confirmed tinyint(1) DEFAULT '0' NOT NULL, created_at timestamp DEFAULT '0000-00-00 00:00:00', updated_at timestamp DEFAULT '0000-00-00 00:00:00', PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into users (id, username, email, password, confirmation_code, remember_token, confirmed, created_at, updated_at) values (1, 'admin', 'iwxadmin@gmail.com', '$2y$10$yS0BSNvtWJ4TZXNwl2Nzlenn1utjtkzDWqxENmAFxBUyUWAjN/5T.', '1eb8d3e3b0782b6ddc321b8bf559da95', 'cbXJOM0KUEshnzwoAjw3stcl9d8D9r5E31l1E4JuGMVmTDkD7l5QkzHphFLF', true, '2014-09-30 20:43:56', '2015-02-09 15:46:08');
insert into users (id, username, email, password, confirmation_code, remember_token, confirmed, created_at, updated_at) values (2, 'anon', 'iwxanon@gmail.com', '$2y$10$zs1kYmQLlfvWC060iHP5S.yTMGeNS4ZT1x/c5GVzU.CZSP2fhVhjK', 'ca18e1542ecf74e531abf51efb3f7d5a', null, true, '2014-09-30 20:43:56', '2014-09-30 20:43:56');
insert into users (id, username, email, password, confirmation_code, remember_token, confirmed, created_at, updated_at) values (5, 'iwxfer', 'iwxfer@gmail.com', '$2y$10$eUwROC1MZvqZSLg6Sv5ou.270kNcP/JtHta8pzfmFrVvZ4wouA0zG', 'f906eb7afa95433644442c1f8fbf28ad', '9VMPeFXPNaEFtY3DhlZt6iv2bv0w5nO7MfO4lUlMOQZ9BSlA6cXg0SXwrkNP', true, '2015-02-09 15:47:04', '2015-02-09 15:50:57');
ALTER TABLE assigned_roles ADD CONSTRAINT assigned_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE;
ALTER TABLE assigned_roles ADD CONSTRAINT assigned_roles_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE;
ALTER TABLE comments ADD CONSTRAINT comments_post_id_foreign FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE;
ALTER TABLE comments ADD CONSTRAINT comments_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE;
ALTER TABLE permission_role ADD CONSTRAINT permission_role_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE;
ALTER TABLE permission_role ADD CONSTRAINT permission_role_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE;
ALTER TABLE posts ADD CONSTRAINT posts_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE;
