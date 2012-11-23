<?php
/**
 * Native MySQL functions
 * @see http://www.php.net/manual/de/ref.mysql.php
 */


/**
 * Positiv Tests -> Should be captured by Codesniffer
 */

mysql_affected_rows();
mysql_client_encoding();
mysql_close();
mysql_connect();
mysql_create_db();
mysql_data_seek();
mysql_db_name();
mysql_db_query();
mysql_drop_db();
mysql_errno();
mysql_error();
mysql_escape_string();
mysql_fetch_array();
mysql_fetch_assoc();
mysql_fetch_field();
mysql_fetch_lengths();
mysql_fetch_object();
mysql_fetch_row();
mysql_field_flags();
mysql_field_len();
mysql_field_name();
mysql_field_seek();
mysql_field_table();
mysql_field_type();
mysql_free_result();
mysql_get_client_info();
mysql_get_host_info();
mysql_get_proto_info();
mysql_get_server_info();
mysql_info();
mysql_insert_id();
mysql_list_dbs();
mysql_list_fields();
mysql_list_processes();
mysql_list_tables();
mysql_num_fields();
mysql_num_rows();
mysql_pconnect();
mysql_ping();
mysql_query();
mysql_real_escape_string();
mysql_result();
mysql_select_db();
mysql_set_charset();
mysql_stat();
mysql_tablename();
mysql_thread_id();
mysql_unbuffered_query();

while($row = mysql_fetch_object($ergebnis))
{
  echo $row->url;
  echo "<br />";
  echo $row->urlname;
  echo "<br /><br />";
}
$abfrage = mysql_query("SELECT * FROM haustierwunsch WHERE haustier = '$haustier'");
$update = mysql_query("UPDATE haustierwunsch Set count = '$haustieranzahl' WHERE haustier = '$haustier'");

$connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or die("Verbindungsversuch fehlgeschlagen");
mysql_select_db($mysqldb, $connection) or die("Konnte die Datenbank nicht waehlen.");

$anzahl = mysql_num_rows($adressen_query);


/**
* Negativ Tests -> Should not be captured by Codesniffer
*/
$formelement = $TYPO3_DB->sql_fetch_assoc($RS_elements);

$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM mytable WHERE uid=123 AND title LIKE "%blabla%" ORDER BY title LIMIT 5');

$RS_elements = $TYPO3_DB->exec_SELECTquery(
				'tx_dkdshop_formelements.*, tx_dkdshop_form_formelements_mm.sorting',
				'tx_dkdshop_forms INNER JOIN tx_dkdshop_form_formelements_mm ON (tx_dkdshop_forms.uid = tx_dkdshop_form_formelements_mm.uid_local) INNER JOIN tx_dkdshop_formelements ON (tx_dkdshop_form_formelements_mm.uid_foreign = tx_dkdshop_formelements.uid)',
				'tx_dkdshop_forms.uid='.$form['uid'] . ' AND tx_dkdshop_formelements.sys_language_uid=0' . $this->cObj->enableFields('tx_dkdshop_formelements'),
				'',
				'tx_dkdshop_form_formelements_mm.sorting'

);
?>