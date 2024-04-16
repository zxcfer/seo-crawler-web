-- delete from crawl_stats  where id>1;
select * from migrations;
select * from crawl_stats where created_at > '2015-06-15 00:00:00';
select * from crawl_stats where crawl_id in (62,49,46);
select * from crawl_stats where amount=18;
select * from alert;
select * from url where website_id in (11,6);
select * from items;
select * from orders;
select * from crawl order by created_at desc;
select * from website where status in (1,2);
select * from website_user;
select * from url_status where robots_index is null;
select * from url_status where url_id=885;
select * from url_status where url_status_code=301;
select * from url where id in (1034,1035, 885);
select count(*) from url_status where crawl_id = 44; --280->515
select * from url where url like '%fer%';
select * from url_status where url_id = 810;
select * from url_status where crawl_id >52;
select * from url_alert where crawl_id >52;
select * from url where url = 'http://www.wealthsmart.com.au/life-insurance-comparison/ages-60-plus/';
select * from url_status order by created_at desc;
select * from url_status where crawl_id is not null;
select * from url_status where pagination != '';
select count(*), crawl_id from url_status group by crawl_id;

-- delete from url_status where crawl_id>1;
-- delete from url_alert where crawl_id>1;
-- delete from crawl_stats where id >1;
-- delete from crawl where id >1;


select * from url_status where crawl_id=47;
select * from url_alert where crawl_id=48;

select * from crawl c
join website w on w.id = c.website_id
join url u on u.website_id = w.id
join url_status us on us.url_id = u.id
where c.website_id=6 and c.id=15 and c.worked_on='2015-05-24'
group by c.worked_on;

select count(*) from url_status where crawl_id=
    reported_on = (select worked_on from crawl where id=15)
    and url_id in (select id from url where website_id = 6);
    
select * from url_status where crawl_id=15;
select * from website;

select c.id,
        (select max(depth) from url_status where crawl_id=c.id),
        (select count(*) from url_status where crawl_id=c.id)
 from crawl c where c.website_id=6;
 
select * from website w
join crawl c on c.website_id = w.id
where c.id=15;
select * from url_alert where crawl_id=35 order by alert_id, url_id;
select * from url_status where crawl_id=35;


select * from crawl_stats where crawl_id=15;
select * from url_status where crawl_id=15;
select * from url where id in (select url_id from url_status where crawl_id = 15);
select * from url_status where crawl_id = 15;

select title, meta_desc, url_short, count(*) from url_status us
join url u on u.id = us.url_id
where us.crawl_id=15
group by title, meta_desc, url_short;

sum=> total
count items => unique
total - unique = duplicated;

select worked_on, sum(amount) 
from crawl_stats cs
join crawl c on c.id = cs.crawl_id
where c.website_id = 6
and cs.description = 'duplicated'
-- and typ = 'overview'
group by worked_on;

SELECT * FROM crawl_stats cs
WHERE crawl_id IN (SELECT id FROM crawl WHERE website_id = '6')
AND typ = 'indexation';

SELECT u.url FROM url_status us 
JOIN url u ON u.id = us.url_id
WHERE crawl_id = 62 AND url 
NOT IN (
SELECT url FROM url_status us 
JOIN url u ON u.id = us.url_id
WHERE crawl_id = 49);

select u.url from url_status us
join url u on us.url_id = u.id where crawl_id=59;

SELECT count(*) AS total
FROM url_status us
JOIN url u ON u.id = us.url_id
WHERE us.crawl_id = 62
GROUP BY title, meta_desc, url_short;

SELECT `url`.`url`, `url_status`.`id`, `url_status`.`created_at`, count(*)
FROM `url_status`
INNER JOIN `url` ON `url`.`id` = `url_status`.`url_id`
INNER JOIN `crawl` ON `crawl`.`id` = `url_status`.`crawl_id`
WHERE `url_status`.`crawl_id` = '114'
GROUP BY `title`, `meta_desc`, `url_short`;

SELECT COUNT(*) AS AGGREGATE
FROM (
SELECT '1' AS ROW
FROM `url_status`
INNER JOIN `url` ON `url`.`id` = `url_status`.`url_id`
INNER JOIN `crawl` ON `crawl`.`id` = `url_status`.`crawl_id`
WHERE `url_status`.`crawl_id` = '114' AND `url`.`url` NOT IN ('1', '2')) AS count_row_table;

SELECT * FROM gwt_dump where month(created_at) = month(now());
SELECT * FROM gwt_sitemap;
SELECT * FROM gwt_error_count;
SELECT * FROM gwt_error_samples;
-- delete from gwt_error_count where id>1;
-- delete from gwt_sitemap where id>1;
-- DELETE FROM gwt_dump where id>1;
insert into `gwt_sitemap` (`path`, `type`, `errors`, `warnings`, `last_submitted`, `gwt_dump_id`) values (http://www.binacube.com/sitemap.xml, sitemap, 0, 0, 2015-07-08T10:40:14.257Z, 4)
;ipod
 phones
 iphone
 blog
 forums
 android
 apps
 webapp
 project management webapp
 one page webapp
 education webapp
 chat apps
 
 /* count */
 
 -- select * from url_status where crawl_id=93 order by created_at desc limit 20;
-- select * from crawl order by created_at desc;
select count(distinct url) from url where website_id=3;
226133