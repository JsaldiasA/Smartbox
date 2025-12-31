/*Ecribe el nombre de la tabla para generar el codigo */
SET @Table = 'checklist';

/* PARA DbEntities.php declaracion variables */
SELECT CONCAT('public $',column_name,';')
 FROM information_schema.columns
 WHERE table_schema = 'sirecor' AND table_name = @Table;
/* PARA DbEntities.php para el constructor */

SELECT CONCAT('$',column_name,',')
 FROM information_schema.columns
 WHERE table_schema = 'sirecor' AND table_name = @Table; 
/* ATENCION ELIMINAR la utima coma */

/* PARA DbEntities.php para el constructor, asiganar variables */
SELECT CONCAT('$this->',column_name,' = $',column_name,';')
 FROM information_schema.columns
 WHERE table_schema = 'sirecor' AND table_name = @Table;

/* PARA DbEntities.php funcionres get para reemplazar variables, no eliminar las funciones que no sean realacionadas a variables*/
SELECT CONCAT('function get_',column_name,'() { return $this->',column_name,'; }')
 FROM information_schema.columns
 WHERE table_schema = 'sirecor' AND table_name = @Table;

/* PARA model.php */
SELECT CONCAT('$row["',column_name,'"],')
 FROM information_schema.columns
 WHERE table_schema = 'sirecor' AND table_name = @Table;