-- tables
-- Table: correlation_datasetX_clr
CREATE TABLE correlation_datasetX_clr (
    gene_i1 int(11) NOT NULL,
    gene_i2 int(11) NOT NULL,
    corr1 double(10,10) NULL DEFAULT NULL,
    gene_info_gene_i int(11) NOT NULL,
    CONSTRAINT correlation_datasetX_clr_pk PRIMARY KEY (gene_i1,gene_i2)
) ENGINE MyISAM CHARACTER SET latin1;

CREATE INDEX gene_i2 ON correlation_datasetX_clr (gene_i2);

-- Table: correlation_datasetX_pear
CREATE TABLE correlation_datasetX_pear (
    gene_i1 int(11) NOT NULL,
    gene_i2 int(11) NOT NULL,
    corr1 double(10,10) NULL DEFAULT NULL,
    gene_info_gene_i int(11) NOT NULL,
    CONSTRAINT correlation_datasetX_pear_pk PRIMARY KEY (gene_i1,gene_i2)
) ENGINE MyISAM CHARACTER SET latin1;

CREATE INDEX gene_i2 ON correlation_datasetX_pear (gene_i2);

-- Table: experiment_datasetX
CREATE TABLE experiment_datasetX (
    exp_i int(11) NOT NULL AUTO_INCREMENT,
    exp_id varchar(60) NULL DEFAULT NULL,
    title varchar(255) NULL DEFAULT NULL,
    pubmed_id varchar(255) NULL DEFAULT '',
    web_link varchar(255) NULL DEFAULT NULL,
    summary text NULL,
    sample_ids text NULL,
    contributors text NULL,
    contact varchar(255) NULL DEFAULT NULL,
    CONSTRAINT experiment_datasetX_pk PRIMARY KEY (exp_i)
) ENGINE MyISAM CHARACTER SET latin1;

-- Table: expression_datasetX
CREATE TABLE expression_datasetX (
    sample_i int(11) NOT NULL,
    expression double(10,10) NULL DEFAULT NULL,
    gene_i int(11) NOT NULL,
    gene_info_gene_i int(11) NOT NULL,
    sample_datasetX_sample_i int(11) NOT NULL,
    CONSTRAINT expression_datasetX_pk PRIMARY KEY (sample_i,gene_i)
) ENGINE MyISAM CHARACTER SET latin1;

-- Table: gene_go
CREATE TABLE gene_go (
    go_i int(16) NOT NULL,
    gene_i int(16) NOT NULL,
    gene_info_gene_i int(16) NOT NULL,
    go_info_go_i int(16) NOT NULL,
    CONSTRAINT gene_go_pk PRIMARY KEY (go_i,gene_i)
) ENGINE MyISAM CHARACTER SET latin1;

CREATE INDEX gene_i ON gene_go (gene_i);

-- Table: gene_info
CREATE TABLE `gene_info` (
  `gene_id` varchar(60) CHARACTER SET utf8 NOT NULL,
  `chromosome_name` varchar(20) DEFAULT NULL,
  `gene_start` int(16) unsigned DEFAULT NULL,
  `gene_end` int(16) unsigned DEFAULT NULL,
  `strand` varchar(2) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `peptide_name` varchar(50) DEFAULT NULL,
  `gene_i` mediumint(16) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`gene_i`),
  UNIQUE KEY `gene_id` (`gene_id`)
);

CREATE INDEX gene_id ON gene_info (gene_id);

-- Table: go_info
CREATE TABLE go_info (
    go_i int(16) NOT NULL AUTO_INCREMENT,
    go_id varchar(16) NULL DEFAULT NULL,
    name_space varchar(255) NULL DEFAULT 'unknown',
    description varchar(255) NULL DEFAULT NULL,
    CONSTRAINT go_info_pk PRIMARY KEY (go_i)
) ENGINE MyISAM;

-- Table: go_relation
CREATE TABLE go_relation (
    go_c int(16) NOT NULL,
    go_p int(16) NOT NULL,
    gene_go_go_i int(16) NOT NULL,
    gene_go_gene_i int(16) NOT NULL,
    CONSTRAINT go_relation_pk PRIMARY KEY (go_c,go_p)
) ENGINE MyISAM CHARACTER SET latin1;

CREATE INDEX go_p ON go_relation (go_p);

-- Table: pfam_table
CREATE TABLE pfam_table (
    gene_i int(16) NULL DEFAULT NULL,
    pfam_i int(16) NOT NULL AUTO_INCREMENT,
    pfam_id varchar(60) NULL DEFAULT NULL,
    description varchar(255) NULL DEFAULT NULL,
    gene_info_gene_i int(16) NOT NULL,
    CONSTRAINT pfam_table_pk PRIMARY KEY (pfam_i)
) ENGINE MyISAM CHARACTER SET latin1;

-- Table: sample_datasetX
CREATE TABLE sample_datasetX (
    sample_i int(16) NOT NULL,
    sample_id varchar(60) NOT NULL,
    exp_i int(16) NULL DEFAULT NULL,
    title varchar(255) NOT NULL DEFAULT '',
    last_update varchar(60) NOT NULL DEFAULT '',
    type varchar(255) NOT NULL DEFAULT '',
    source_name varchar(255) NULL DEFAULT NULL,
    organism varchar(255) NULL DEFAULT '',
    characteristics varchar(255) NULL DEFAULT NULL,
    treatment_protocol varchar(255) NULL,
    growth_protocol varchar(255) NULL,
    molecule varchar(255) NULL DEFAULT NULL,
    extract_protocol varchar(255) NULL,
    lable varchar(255) NULL DEFAULT NULL,
    lable_protocol varchar(255) NULL,
    hyb_protocol varchar(255) NULL,
    description varchar(255) NULL,
    contact varchar(255) NULL DEFAULT NULL,
    supplementary_file varchar(255) NULL,
    exp_id varchar(200) NULL DEFAULT '',
    experiment_datasetX_exp_i int(16) NOT NULL,
    CONSTRAINT sample_datasetX_pk PRIMARY KEY (sample_i)
) ENGINE MyISAM CHARACTER SET latin1;

CREATE INDEX fk_Sample_PO1 ON sample_datasetX (last_update);

CREATE INDEX fk_Sample_ENVO1 ON sample_datasetX (type);

CREATE INDEX fk_Sample_Experiment1 ON sample_datasetX (title);

CREATE INDEX exp_i ON sample_datasetX (exp_i);

CREATE INDEX sample_i ON sample_datasetX (sample_i);

-- Table: tf
CREATE TABLE tf (
    TF_family_i int(11) NOT NULL,
    gene_i int(11) NOT NULL,
    transcript_i int(11) NULL DEFAULT NULL,
    gene_info_gene_i int(11) NOT NULL,
    CONSTRAINT tf_pk PRIMARY KEY (TF_family_i,gene_i)
) ENGINE MyISAM CHARACTER SET latin1;

CREATE INDEX fk_TF_GeneTable1 ON tf (gene_i);

CREATE INDEX transcript_i ON tf (transcript_i);

-- Table: tf_family
CREATE TABLE tf_family (
    tf_family_i int(11) NOT NULL,
    tf_family_id varchar(255) NULL DEFAULT NULL,
    tf_TF_family_i int(11) NOT NULL,
    tf_gene_i int(11) NOT NULL,
    CONSTRAINT tf_family_pk PRIMARY KEY (tf_family_i)
) ENGINE MyISAM CHARACTER SET latin1;

CREATE INDEX transcript_i ON tf_family (tf_family_id);

-- Table: tf_set
CREATE TABLE tf_set (
    TF_dbi int(11) NOT NULL AUTO_INCREMENT,
    TF_desciption varchar(255) NULL DEFAULT NULL,
    TF_link varchar(60) NULL DEFAULT NULL,
    TF_family_i int(11) NOT NULL,
    tf_TF_family_i int(11) NOT NULL,
    tf_gene_i int(11) NOT NULL,
    CONSTRAINT tf_set_pk PRIMARY KEY (TF_dbi)
) ENGINE MyISAM CHARACTER SET latin1;

CREATE INDEX fk_TF_set_TF1 ON tf_set (TF_dbi);

-- Table: transcript_atg
CREATE TABLE transcript_atg (
    atg_id varchar(60) NOT NULL,
    transcript_i int(11) NOT NULL,
    description varchar(255) NULL DEFAULT NULL,
    transcript_info_transcript_i int(11) NOT NULL,
    CONSTRAINT transcript_atg_pk PRIMARY KEY (transcript_i)
) ENGINE MyISAM CHARACTER SET latin1;

CREATE INDEX transcript_i ON transcript_atg (transcript_i);

CREATE INDEX atg_id ON transcript_atg (atg_id);

-- Table: transcript_info
CREATE TABLE `transcript_info` (
  `transcript_id` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `chromosome_name` varchar(20) DEFAULT NULL,
  `transcript_start` int(16) unsigned DEFAULT NULL,
  `transcript_end` int(16) unsigned DEFAULT NULL,
  `strand` varchar(2) DEFAULT NULL,
  `gene_id` varchar(60) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `gene_i` mediumint(16) unsigned DEFAULT NULL,
   `transcript_i` mediumint(16) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`transcript_i`),
  UNIQUE KEY `transcript_id` (`transcript_id`)
);

-- foreign keys
-- Reference: correlation_datasetX_clr_gene_info (table: correlation_datasetX_clr)
ALTER TABLE correlation_datasetX_clr ADD CONSTRAINT correlation_datasetX_clr_gene_info FOREIGN KEY correlation_datasetX_clr_gene_info (gene_info_gene_i)
    REFERENCES gene_info (gene_i);

-- Reference: correlation_datasetX_pear_gene_info (table: correlation_datasetX_pear)
ALTER TABLE correlation_datasetX_pear ADD CONSTRAINT correlation_datasetX_pear_gene_info FOREIGN KEY correlation_datasetX_pear_gene_info (gene_info_gene_i)
    REFERENCES gene_info (gene_i);

-- Reference: expression_datasetX_gene_info (table: expression_datasetX)
ALTER TABLE expression_datasetX ADD CONSTRAINT expression_datasetX_gene_info FOREIGN KEY expression_datasetX_gene_info (gene_info_gene_i)
    REFERENCES gene_info (gene_i);

-- Reference: expression_datasetX_sample_datasetX (table: expression_datasetX)
ALTER TABLE expression_datasetX ADD CONSTRAINT expression_datasetX_sample_datasetX FOREIGN KEY expression_datasetX_sample_datasetX (sample_datasetX_sample_i)
    REFERENCES sample_datasetX (sample_i);

-- Reference: gene_go_gene_info (table: gene_go)
ALTER TABLE gene_go ADD CONSTRAINT gene_go_gene_info FOREIGN KEY gene_go_gene_info (gene_info_gene_i)
    REFERENCES gene_info (gene_i);

-- Reference: gene_go_go_info (table: gene_go)
ALTER TABLE gene_go ADD CONSTRAINT gene_go_go_info FOREIGN KEY gene_go_go_info (go_info_go_i)
    REFERENCES go_info (go_i);

-- Reference: go_relation_gene_go (table: go_relation)
ALTER TABLE go_relation ADD CONSTRAINT go_relation_gene_go FOREIGN KEY go_relation_gene_go (gene_go_go_i,gene_go_gene_i)
    REFERENCES gene_go (go_i,gene_i);

-- Reference: pfam_table_gene_info (table: pfam_table)
ALTER TABLE pfam_table ADD CONSTRAINT pfam_table_gene_info FOREIGN KEY pfam_table_gene_info (gene_info_gene_i)
    REFERENCES gene_info (gene_i);

-- Reference: sample_datasetX_experiment_datasetX (table: sample_datasetX)
ALTER TABLE sample_datasetX ADD CONSTRAINT sample_datasetX_experiment_datasetX FOREIGN KEY sample_datasetX_experiment_datasetX (experiment_datasetX_exp_i)
    REFERENCES experiment_datasetX (exp_i);

-- Reference: tf_family_tf (table: tf_family)
ALTER TABLE tf_family ADD CONSTRAINT tf_family_tf FOREIGN KEY tf_family_tf (tf_TF_family_i,tf_gene_i)
    REFERENCES tf (TF_family_i,gene_i);

-- Reference: tf_gene_info (table: tf)
ALTER TABLE tf ADD CONSTRAINT tf_gene_info FOREIGN KEY tf_gene_info (gene_info_gene_i)
    REFERENCES gene_info (gene_i);

-- Reference: tf_set_tf (table: tf_set)
ALTER TABLE tf_set ADD CONSTRAINT tf_set_tf FOREIGN KEY tf_set_tf (tf_TF_family_i,tf_gene_i)
    REFERENCES tf (TF_family_i,gene_i);

-- Reference: transcript_atg_transcript_info (table: transcript_atg)
ALTER TABLE transcript_atg ADD CONSTRAINT transcript_atg_transcript_info FOREIGN KEY transcript_atg_transcript_info (transcript_info_transcript_i)
    REFERENCES transcript_info (transcript_i);

-- Reference: transcript_info_gene_info (table: transcript_info)
ALTER TABLE transcript_info ADD CONSTRAINT transcript_info_gene_info FOREIGN KEY transcript_info_gene_info (gene_info_gene_i)
    REFERENCES gene_info (gene_i);

-- End of file.

