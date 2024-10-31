<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/**
 * This is custom class reponsible for all table generator
 * for PC
 * @package     PN
 * @subpackage  admin/class
 * @since       1.0
 */
class PAC_Table_Generator{
    
    protected static $tables = array();
    
    private $_dataType = array();
    
    function __construct() {
        //$this->_dataType = $this->_dataType();
 	}
    
    /**
     * Create all required table for Podamibe Chat plugin
     * @param null
     * @return null
     *
     */
 	public static function createTableForPAC() {
		global $wpdb;
		foreach ( self::$tables as $tableName => $columns ) {
			$tableName =  PAC_TABLE_PREFIX . $tableName;
			$sql = "";
            $sql .= "CREATE TABLE IF NOT EXISTS {$tableName} (";
            $sn = 0;
            $total_col = count( $columns );
            $wpdb_collate = $wpdb->collate;
 			foreach ( $columns as $key => $col ) {
                if ( $sn < $total_col-1 ) {
                    $separator = ", ";
                } else {
                    $separator = "";
                }
                $cols = $col;
                //echo self::_colArgs($cols);
 			    $type_array = explode( '|',$col['type'] );
                $type = $type_array[0];
                $type = strtoupper( $type_array[0] );
                if( $type == 'ENUM' ){
                    if( $type_array[1] ) {
                        $enum_length = "'" . implode("', '", explode(',', $type_array[1])) . "'";
                        $length = "(" . $enum_length . ")";
                    } else {
                        $length = '';
                    }
                } else {
                    if( $type_array[1] ) {
                        $length = "(" . $type_array[1] . ")";
                    } else {
                        $length = '';
                    }
                }
                if ( $col['DEFAULT'] ) {
                    $default = $col['DEFAULT'];
                } else {
                    $default = '';
                }    
                if( $sn==0 ) {
 			        $sql .= $col['column'] . " ". $type . $length . " " . $default . " AUTO_INCREMENT, ";
                    $sql .= "PRIMARY KEY(" . $col['column'] ."), ";
 			    } else {
 			        $sql .= $col['column'] . " " . $type . $length . " " . $default . $separator;
 			    }                
                $sn++;
            }
            $sql .= ")COLLATE {$wpdb_collate}";
		 	self::_build( $sql );
		}
 	}
    
    /**
     * Create all required table for Podamibe Chat plugin
     * @param null
     * @return null
     *
     */
    public static function initTableStructureForPAC(){
        ob_start();
        self::_buildPacUserTable();
        ob_end_clean();
    }
    
    /**
     * 
 	 * This method is used to call all client table build method 
 	 * @param null
 	 * @return void
 	 * @since 1.0
 	 * @note (insert default method => 'DEFAULT' => "unsigned NOT NULL" and 'DEFAULT'=> "DEFAULT 'N' NOT NULL")
 	 **/
    private function _buildPacUserTable(){
        ob_start();
		self::$tables = array(
                			'user' => array (
                            				array(
                            					'column'  => 'id',
                            					'type'	  => 'BIGINT',
                            					'DEFAULT' => "unsigned NOT NULL"
                            					),
                            				array(
                            					'column' => 'name',
                            					'type'	 => 'VARCHAR|255'
                            					),
                            				array(
                            					'column' => 'email',
                            					'type'	 => 'VARCHAR|255'
                            					),
                            				array(
                            					'column' => 'subject',
                            					'type'	 => 'text'
                            					),
                            				array(
                            					'column' => 'remarks',
                            					'type'	 => 'text'
                            					),
                            				array(
                            					'column' => 'booked_date',
                            					'type'   => 'DATE'
                            					)
                				    )
			             );
		self::createTableForPAC();
		ob_end_clean();
    }       
    
    /**
     * 
     * Create table for Podamibe Chat plugin
     * @param null
     * @return null
     *
     */
    private function _build( $sql ){
		global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta( $sql );
    }
}