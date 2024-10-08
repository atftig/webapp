/* Migrazione 8 Ottobre 2024 */

ALTER TABLE buyer_app.product_ispettori ADD `insegna-pv` varchar(100) DEFAULT 'xx' NOT NULL;

UPDATE buyer_app.product_ispettori pi
SET pi.`insegna-pv` = CONCAT(pi.`insegna`, '-', pi.`pv`) 

ALTER TABLE buyer_app.product_ispettori ADD CONSTRAINT product_ispettori_pk PRIMARY KEY (`insegna-pv`);
ALTER TABLE buyer_app.product_details_ispettori ADD CONSTRAINT product_details_ispettori_product_ispettori_FK
   FOREIGN KEY (`insegna-pv`) REFERENCES buyer_app.product_ispettori(`insegna-pv`);
  
 ALTER TABLE buyer_app.product_details_ispettori CHANGE `insegna-pv` id varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'codan-verona' NOT NULL;

 ALTER TABLE buyer_app.product_details_ispettori CHANGE `id` id_product_ispettori varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci  NOT NULL;

ALTER TABLE buyer_app.product_ispettori CHANGE `insegna-pv` id varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;

ALTER TABLE buyer_app.product_details_ispettori ADD id_user varchar(100) DEFAULT 'x' NOT NULL;



-- da eseguire su digital ocean--