/* Formatted on 14/04/2023 09:34:49 (QP5 v5.362) */
CREATE OR REPLACE FORCE VIEW V_PRM_LISTETYPEGENERATION
(
    PTPG_UID,
    PRCD_UIDGEN,
    PMFC_UID,
    PRCD_UIDANNGEN,
    PTPG_COD,
    PTPG_DES,
    PTPG_STATUT
)
BEQUEATH DEFINER
AS
    SELECT "PTPG_UID",
           "PRCD_UIDGEN",
           "PMFC_UID",
           "PRCD_UIDANNGEN",
           "PTPG_COD",
           "PTPG_DES",
           "PTPG_STATUT"
      FROM PRM_TYPEGENERATION;


/* Formatted on 14/04/2023 09:34:49 (QP5 v5.362) */
CREATE OR REPLACE FORCE VIEW V_PRM_LISTMODELEFICHIERTYPGEN
(
    PMFC_UID,
    PMFC_COD,
    PMFC_FICTXT
)
BEQUEATH DEFINER
AS
    SELECT "PMFC_UID", "PMFC_COD", "PMFC_DES" "PMFC_FICTXT"
      FROM PRM_MODELEFICHIER;

COMMENT ON TABLE V_PRM_LISTMODELEFICHIERTYPGEN IS 'Liste des modeles de fichiers. Ecran "Type de generation"';


/* Formatted on 14/04/2023 09:34:49 (QP5 v5.362) */
CREATE OR REPLACE FORCE VIEW V_PRM_LISTPRCDANLGNRDONN
(
    PROC_UID,
    PROC_CODE,
    PROC_DESC,
    PROC_MODULE,
    PROC_DETAIL
)
BEQUEATH DEFINER
AS
    SELECT PROC_UID,
           PROC_CODE,
           PROC_DESC,
           PROC_MODULE,
           PROC_DETAIL
      FROM PRM_PROCEDURE;

COMMENT ON TABLE V_PRM_LISTPRCDANLGNRDONN IS 'Liste des procedures pour l''anulation de donnee. Ecran "Type de generation"';


/* Formatted on 14/04/2023 09:34:49 (QP5 v5.362) */
CREATE OR REPLACE FORCE VIEW V_PRM_LISTPRCDGNRDONN
(
    PROC_UID,
    PROC_CODE,
    PROC_DESC,
    PROC_MODULE,
    PROC_DETAIL
)
BEQUEATH DEFINER
AS
    SELECT PROC_UID,
           PROC_CODE,
           PROC_DESC,
           PROC_MODULE,
           PROC_DETAIL
      FROM PRM_PROCEDURE;

COMMENT ON TABLE V_PRM_LISTPRCDGNRDONN IS 'Liste des procedures pour la generation de donnee. Ecran "Type de generation"';
