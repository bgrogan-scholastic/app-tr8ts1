drop table if exists manifest;
create table manifest
(
 product_id	 varchar(16),
 feature_id varchar(16),
 uid varchar(24) Primary Key,
 puid varchar(24),
 slp_id varchar(24),
 type varchar(16),
 fext varchar(16),
 title_ascii varchar(255),
 title_ent varchar(255),
 priority int(11),
 category varchar(128),
 credit text,
 caption_id varchar(36),
 ada_text text,
 lexile varchar(18),
 height int(11),
 width int(11),
 language varchar(2),
 volume varchar(24),
 sort_order int(11),
 primary_doc char(1),
 src_product_id varchar(16),
 src_feature_id varchar(16),
 grades varchar(80),
 xref_blind_entry char(1),
 ar char(1),
 src char(1),
 isbn_13 varchar(24),
 src_points int(11),
 isbn_10 varchar(32), 
word_count varchar(24), 
authors varchar(255), 
description varchar(255), 
total_pgs varchar(24), 
grl varchar(256)
);
create index manifest_type_idx on manifest(type);
create index manifest_puid_idx on manifest(puid);
create index manifest_caption_idx on manifest(caption_id);
create index manifest_slp_id_idx on manifest(slp_id);