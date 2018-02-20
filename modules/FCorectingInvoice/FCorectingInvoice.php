<?php
/**
 * FCorectingInvoice CRMEntity Class.
 *
 * @copyright YetiForce Sp. z o.o
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
include_once 'modules/Vtiger/CRMEntity.php';

class FCorectingInvoice extends Vtiger_CRMEntity
{
	public $table_name = 'u_yf_fcorectinginvoice';
	public $table_index = 'fcorectinginvoiceid';

	/**
	 * Mandatory table for supporting custom fields.
	 */
	public $customFieldTable = ['u_yf_fcorectinginvoicecf', 'fcorectinginvoiceid'];

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	public $tab_name = ['vtiger_crmentity', 'u_yf_fcorectinginvoice', 'u_yf_fcorectinginvoicecf', 'u_yf_fcorectinginvoice_address'];

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	public $tab_name_index = [
		'vtiger_crmentity' => 'crmid',
		'u_yf_fcorectinginvoice' => 'fcorectinginvoiceid',
		'u_yf_fcorectinginvoicecf' => 'fcorectinginvoiceid',
		'u_yf_fcorectinginvoice_address' => 'fcorectinginvoiceaddressid',
	];

	/**
	 * Mandatory for Listing (Related listview).
	 */
	public $list_fields = [
		// Format: Field Label => Array(tablename, columnname)
// tablename should not have prefix 'vtiger_'
		'FL_SUBJECT' => ['fcorectinginvoice', 'subject'],
		'FL_SALE_DATE' => ['fcorectinginvoice', 'saledate'],
		'Assigned To' => ['crmentity', 'smownerid'],
	];
	public $list_fields_name = [
		// Format: Field Label => fieldname
		'FL_SUBJECT' => 'subject',
		'FL_SALE_DATE' => 'saledate',
		'Assigned To' => 'assigned_user_id',
	];

	/**
	 * @var string[] List of fields in the RelationListView
	 */
	public $relationFields = ['subject', 'saledate', 'assigned_user_id'];
	// Make the field link to detail view
	public $list_link_field = 'subject';
	// For Popup listview and UI type support
	public $search_fields = [
		// Format: Field Label => Array(tablename, columnname)
// tablename should not have prefix 'vtiger_'
		'FL_SUBJECT' => ['fcorectinginvoice', 'subject'],
		'FL_SALE_DATE' => ['fcorectinginvoice', 'saledate'],
		'Assigned To' => ['vtiger_crmentity', 'assigned_user_id'],
	];
	public $search_fields_name = [
		// Format: Field Label => fieldname
		'FL_SUBJECT' => 'subject',
		'FL_SALE_DATE' => 'saledate',
		'Assigned To' => 'assigned_user_id',
	];
	// For Popup window record selection
	public $popup_fields = ['subject'];
	// For Alphabetical search
	public $def_basicsearch_col = 'subject';
	// Column value to use on detail view record text display
	public $def_detailview_recname = 'subject';
	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	public $mandatory_fields = ['subject', 'assigned_user_id'];
	public $default_order_by = '';
	public $default_sort_order = 'ASC';
}
