﻿/** Create WordPress database tables SQL */

$wp_queries = "CREATE TABLE $wpdb->terms (
 
term_id bigint(20) unsigned NOT NULL auto_increment,
 
name varchar(200) NOT NULL default '',
 
slug varchar(200) NOT NULL default '',
 
term_group bigint(10) NOT NULL default 0,
 PRIMARY KEY  (term_id),
 
UNIQUE KEY slug (slug),
 
KEY name (name)

)


CREATE TABLE $wpdb->term_taxonomy (
 
term_taxonomy_id bigint(20) unsigned NOT NULL auto_increment,
 
term_id bigint(20) unsigned NOT NULL default 0,
 
taxonomy varchar(32) NOT NULL default '',
 
description longtext NOT NULL,
 
parent bigint(20) unsigned NOT NULL default 0,
 
count bigint(20) NOT NULL default 0,
 
PRIMARY KEY  (term_taxonomy_id),
 
UNIQUE KEY term_id_taxonomy (term_id,taxonomy),
 
KEY taxonomy (taxonomy)
) 



CREATE TABLE $wpdb->term_relationships (
 
object_id bigint(20) unsigned NOT NULL default 0,
 
term_taxonomy_id bigint(20) unsigned NOT NULL default 0,
 
term_order int(11) NOT NULL default 0,
 
PRIMARY KEY  (object_id,term_taxonomy_id),
 
KEY term_taxonomy_id (term_taxonomy_id)

)


CREATE TABLE $wpdb->commentmeta (
 
meta_id bigint(20) unsigned NOT NULL auto_increment,
  
comment_id bigint(20) unsigned NOT NULL default '0',
  
meta_key varchar(255) default NULL,
  
meta_value longtext,
  
PRIMARY KEY  (meta_id),
  
KEY comment_id (comment_id),
  
KEY meta_key (meta_key)

) 



CREATE TABLE $wpdb->comments (
  

comment_ID bigint(20) unsigned NOT NULL auto_increment,
  
comment_post_ID bigint(20) unsigned NOT NULL default '0',
  
comment_author tinytext NOT NULL,
  
comment_author_email varchar(100) NOT NULL default '',
  
comment_author_url varchar(200) NOT NULL default '',
  
comment_author_IP varchar(100) NOT NULL default '',
  
comment_date datetime NOT NULL default '0000-00-00 00:00:00',
  
comment_date_gmt datetime NOT NULL default '0000-00-00 00:00:00',
  
comment_content text NOT NULL,
  
comment_karma int(11) NOT NULL default '0',
  
comment_approved varchar(20) NOT NULL default '1',
  
comment_agent varchar(255) NOT NULL default '',
  
comment_type varchar(20) NOT NULL default '',
  
comment_parent bigint(20) unsigned NOT NULL default '0',
  
user_id bigint(20) unsigned NOT NULL default '0',
  
PRIMARY KEY  (comment_ID),
  
KEY comment_approved (comment_approved),
  
KEY comment_post_ID (comment_post_ID),
  
KEY comment_approved_date_gmt (comment_approved,comment_date_gmt),
  
KEY comment_date_gmt (comment_date_gmt),
  
KEY comment_parent (comment_parent)

) 



CREATE TABLE $wpdb->links (
  
link_id bigint(20) unsigned NOT NULL auto_increment,
  
link_url varchar(255) NOT NULL default '',
  
link_name varchar(255) NOT NULL default '',
  
link_image varchar(255) NOT NULL default '',
  
link_target varchar(25) NOT NULL default '',
  
link_description varchar(255) NOT NULL default '',
  
link_visible varchar(20) NOT NULL default 'Y',
  
link_owner bigint(20) unsigned NOT NULL default '1',
  
link_rating int(11) NOT NULL default '0',
  
link_updated datetime NOT NULL default '0000-00-00 00:00:00',
  
link_rel varchar(255) NOT NULL default '',
  
link_notes mediumtext NOT NULL,
  
link_rss varchar(255) NOT NULL default '',
  
PRIMARY KEY  (link_id),
  
KEY link_visible (link_visible)
) 
$charset_collate;



CREATE TABLE $wpdb->options (
  
option_id bigint(20) unsigned NOT NULL auto_increment,
  
blog_id int(11) NOT NULL default '0',
  
option_name varchar(64) NOT NULL default '',
  
option_value longtext NOT NULL,
  
autoload varchar(20) NOT NULL default 'yes',
  
PRIMARY KEY  (option_id),
  
UNIQUE KEY option_name (option_name)

) 
$charset_collate;


CREATE TABLE $wpdb->postmeta (
  
meta_id bigint(20) unsigned NOT NULL auto_increment,
  
post_id bigint(20) unsigned NOT NULL default '0',
  
meta_key varchar(255) default NULL,
  
meta_value longtext,
  
PRIMARY KEY  (meta_id),
  
KEY post_id (post_id),
  
KEY meta_key (meta_key)

) 
$charset_collate;


#post table
CREATE TABLE posts (
ID bigint(20) unsigned NOT NULL auto_increment,
post_author bigint(20) unsigned NOT NULL default '0', 
post_date datetime NOT NULL default '0000-00-00 00:00:00',
post_date_gmt datetime NOT NULL default '0000-00-00 00:00:00',
post_content longtext NOT NULL,
post_title text NOT NULL,
post_excerpt text NOT NULL,
post_status varchar(20) NOT NULL default 'publish',
comment_status varchar(20) NOT NULL default 'open',
ping_status varchar(20) NOT NULL default 'open',
post_password varchar(20) NOT NULL default '',
post_name varchar(200) NOT NULL default '',
to_ping text NOT NULL,
pinged text NOT NULL,
post_modified datetime NOT NULL default '0000-00-00 00:00:00',
post_modified_gmt datetime NOT NULL default '0000-00-00 00:00:00',
post_content_filtered text NOT NULL,
post_parent bigint(20) unsigned NOT NULL default '0',
guid varchar(255) NOT NULL default '',
menu_order int(11) NOT NULL default '0',
post_type varchar(20) NOT NULL default 'post',
post_mime_type varchar(100) NOT NULL default '',
comment_count bigint(20) NOT NULL default '0',
PRIMARY KEY  (ID),  
KEY post_name (post_name),
KEY type_status_date (post_type,post_status,post_date,ID),
KEY post_parent (post_parent),
KEY post_author (post_author)
)
 
