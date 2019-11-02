<?php
    $this->ImportClass("system.data.abstracttable", "AbstractTable");
 /**
     * SecureCodes table class
     * @author Sergey Grishko <sgrishko@reaktivate.com>
     * @version 1.0
     * @package Framework
     * @subpackage classes.module.data
     * @access public
     **/
    class SecureCodesTable extends AbstractTable {
        /**
            * Class constructor
            * @param  object    Connection object
            * @access public
         */

        function SecureCodesTable(&$Connection, $sessionsTable) {
            AbstractTable::AbstractTable(&$Connection, $sessionsTable);
        }

  /**
   * Method prepare columns array
   * @access  public
  */
        function prepareColumns() {
            $this->columns[] = array("name" => "id", "type" => DB_COLUMN_NUMERIC, "key" => true);
            $this->columns[] = array("name" => "hash",  "type" => DB_COLUMN_STRING);
            $this->columns[] = array("name" => "number", "type" => DB_COLUMN_STRING, "dtype"=>"string", "length"=>10 );
            $this->columns[] = array("name" => "inittime", "type" => DB_COLUMN_STRING, "dtype"=>"string", "length"=>14 );

        }


   /**
   * Method deletes opbsolete records
   * @access		public
   **/
   function DeleteObsolete(){
       $SQL = sprintf("DELETE FROM %s WHERE inittime < %s",
                      $this->defaultTableName,
                      date("YmdHis", time()-60)
                     );
        $this->Connection->ExecuteNonQuery($SQL);
   }

    }
?>