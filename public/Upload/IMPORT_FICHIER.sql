CREATE TABLE PRM_MODELEFICHIER ( PMFC_UID NUMBER(12) NOT NULL, PMFC_COD VARCHAR2(20 BYTE), PMFC_DES VARCHAR2(500 BYTE), PMFC_FICTXT INTEGER, PMFC_TABDST VARCHAR2(300 BYTE) );


ALTER TABLE PRM_MODELEFICHIER ADD ( CONSTRAINT PMFC_PK PRIMARY KEY (PMFC_UID) ENABLE VALIDATE);



CREATE TABLE PRM_STUCTUREMODELEFIC ( PSMF_UID NUMBER(12) NOT NULL, PMFC_UID NUMBER(12) NOT NULL, PSMF_COD VARCHAR2(20 BYTE), PSMF_DES VARCHAR2(500 BYTE), PSMF_ORD NUMBER(10), PSMF_POSDEB NUMBER(10), PSMF_NBRCAR NUMBER(10), PSMF_CHPDST VARCHAR2(300 BYTE), PSMF_TABDST VARCHAR2(300 BYTE) );


ALTER TABLE PRM_STUCTUREMODELEFIC ADD ( CONSTRAINT PSMF_PK PRIMARY KEY (PSMF_UID) ENABLE VALIDATE);



CREATE TABLE PRM_TYPEGENERATION ( PTPG_UID NUMBER(12) NOT NULL, PRCD_UIDGEN NUMBER(12), PMFC_UID NUMBER(12), PRCD_UIDANNGEN NUMBER(12), PTPG_COD VARCHAR2(20 BYTE), PTPG_DES VARCHAR2(100 BYTE), PTPG_STATUT VARCHAR2(3 BYTE) );


ALTER TABLE PRM_TYPEGENERATION ADD ( CONSTRAINT PTPG_PK PRIMARY KEY (PTPG_UID) ENABLE VALIDATE);



CREATE TABLE PRM_FICHIERS ( PFIC_UID NUMBER(12) NOT NULL, PTPG_UID NUMBER(12) NOT NULL, PFIC_COD VARCHAR2(20 BYTE), PFIC_DES VARCHAR2(500 BYTE), PFIC_DAT DATE, PFIC_STATUT VARCHAR2(3 BYTE), PFIC_FICGEN BLOB, PFIC_NOMFIC VARCHAR2(100 BYTE) );


ALTER TABLE PRM_FICHIERS ADD ( CONSTRAINT PFIC_PK PRIMARY KEY (PFIC_UID) ENABLE VALIDATE);



CREATE TABLE PRM_DETAILFICHIER ( PDFI_UID NUMBER(12) NOT NULL, PFIC_UID NUMBER(12) NOT NULL, PDFI_CHM01 VARCHAR2(1000 BYTE), PDFI_CHM02 VARCHAR2(1000 BYTE), PDFI_CHM03 VARCHAR2(1000 BYTE), PDFI_CHM04 VARCHAR2(1000 BYTE), PDFI_CHM05 VARCHAR2(1000 BYTE), PDFI_CHM06 VARCHAR2(1000 BYTE), PDFI_CHM07 VARCHAR2(1000 BYTE), PDFI_CHM08 VARCHAR2(1000 BYTE), PDFI_CHM09 VARCHAR2(1000 BYTE), PDFI_CHM10 VARCHAR2(1000 BYTE), PDFI_CHM11 VARCHAR2(1000 BYTE), PDFI_CHM12 VARCHAR2(1000 BYTE), PDFI_CHM13 VARCHAR2(1000 BYTE), PDFI_CHM14 VARCHAR2(1000 BYTE), PDFI_CHM15 VARCHAR2(1000 BYTE), PDFI_CHM16 VARCHAR2(1000 BYTE), PDFI_CHM17 VARCHAR2(1000 BYTE), PDFI_CHM18 VARCHAR2(1000 BYTE), PDFI_CHM19 VARCHAR2(1000 BYTE), PDFI_CHM20 VARCHAR2(1000 BYTE), PDFI_CHM21 VARCHAR2(1000 BYTE), PDFI_CHM22 VARCHAR2(1000 BYTE), PDFI_CHM23 VARCHAR2(1000 BYTE), PDFI_CHM24 VARCHAR2(1000 BYTE), PDFI_CHM25 VARCHAR2(1000 BYTE), PDFI_CHM26 VARCHAR2(1000 BYTE), PDFI_CHM27 VARCHAR2(1000 BYTE), PDFI_CHM28 VARCHAR2(1000 BYTE), PDFI_CHM29 VARCHAR2(1000 BYTE), PDFI_CHM30 VARCHAR2(1000 BYTE), PDFI_CHM31 VARCHAR2(1000 BYTE), PDFI_CHM32 VARCHAR2(1000 BYTE), PDFI_CHM33 VARCHAR2(1000 BYTE), PDFI_CHM34 VARCHAR2(1000 BYTE), PDFI_CHM35 VARCHAR2(1000 BYTE), PDFI_CHM36 VARCHAR2(1000 BYTE), PDFI_CHM37 VARCHAR2(1000 BYTE), PDFI_CHM38 VARCHAR2(1000 BYTE), PDFI_CHM39 VARCHAR2(1000 BYTE), PDFI_CHM40 VARCHAR2(1000 BYTE), PDFI_CHM41 VARCHAR2(1000 BYTE), PDFI_CHM42 VARCHAR2(1000 BYTE), PDFI_CHM43 VARCHAR2(1000 BYTE), PDFI_CHM44 VARCHAR2(1000 BYTE), PDFI_CHM45 VARCHAR2(1000 BYTE), PDFI_CHM46 VARCHAR2(1000 BYTE), PDFI_CHM47 VARCHAR2(1000 BYTE), PDFI_CHM48 VARCHAR2(1000 BYTE), PDFI_CHM49 VARCHAR2(1000 BYTE), PDFI_CHM50 VARCHAR2(1000 BYTE), PDFI_TABORG VARCHAR2(100 BYTE), PDFI_UIDORG NUMBER(12), PDFI_STATUT VARCHAR2(3 BYTE) );


ALTER TABLE PRM_DETAILFICHIER ADD ( CONSTRAINT PDFI_PK PRIMARY KEY (PDFI_UID) ENABLE VALIDATE);



ALTER TABLE PRM_MODELEFICHIER ADD ( CONSTRAINT PMFC_PMFC_FK FOREIGN KEY (PMFC_UIDPER) REFERENCES PRM_MODELEFICHIER (PMFC_UID) ENABLE VALIDATE);


ALTER TABLE PRM_STUCTUREMODELEFIC ADD ( CONSTRAINT PSMF_PMFC_FK FOREIGN KEY (PMFC_UID) REFERENCES PRM_MODELEFICHIER (PMFC_UID) ENABLE VALIDATE);


ALTER TABLE PRM_TYPEGENERATION ADD ( CONSTRAINT PTPG_PMFC_FK FOREIGN KEY (PMFC_UID) REFERENCES PRM_MODELEFICHIER (PMFC_UID) ENABLE VALIDATE);

ALTER TABLE PRM_TYPEGENERATION ADD ( CONSTRAINT PTPG_PRCDANNGEN_FK FOREIGN KEY (PRCD_UIDANNGEN) REFERENCES PRM_PROCEDURE (PROC_UID) ENABLE VALIDATE);

ALTER TABLE PRM_TYPEGENERATION ADD ( CONSTRAINT PTPG_PRCDGEN_FK FOREIGN KEY (PRCD_UIDGEN) REFERENCES PRM_PROCEDURE (PROC_UID) ENABLE VALIDATE);


ALTER TABLE PRM_FICHIERS ADD ( CONSTRAINT PFIC_PTPG_FK FOREIGN KEY (PTPG_UID) REFERENCES PRM_TYPEGENERATION (PTPG_UID) ENABLE VALIDATE);


ALTER TABLE PRM_DETAILFICHIER ADD ( CONSTRAINT PDFI_PFIC_FK FOREIGN KEY (PFIC_UID) REFERENCES PRM_FICHIERS (PFIC_UID) ENABLE VALIDATE);