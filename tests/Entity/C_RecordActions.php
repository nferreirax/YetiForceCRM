<?php

/**
 * Record Actions test class.
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace Tests\Entity;

class C_RecordActions extends \Tests\Base
{
	/**
	 * Temporary record object.
	 *
	 * @var Vtiger_Record_Model
	 */
	protected static $recordAccounts;
	/**
	 * Temporary record object.
	 *
	 * @var Vtiger_Record_Model
	 */
	protected static $recordCampaigns;
	/**
	 * Temporary Leads record object.
	 *
	 * @var Vtiger_Record_Model
	 */
	protected static $recordLeads;
	/**
	 * Temporary loremIpsum text.
	 *
	 * @var string
	 */
	protected static $loremIpsumText;
	/**
	 * Temporary loremIpsum html.
	 *
	 * @var string
	 */
	protected static $loremIpsumHtml;

	/**
	 * Load lorem ipsum clear text for tests.
	 *
	 * @return string
	 */
	public static function createLoremIpsumText()
	{
		if (static::$loremIpsumText) {
			return static::$loremIpsumText;
		}
		return static::$loremIpsumText = \file_get_contents('./tests/data/stringText.txt');
	}

	/**
	 * Load lorem ipsum html text for tests.
	 *
	 * @return string
	 */
	public static function createLoremIpsumHtml()
	{
		if (static::$loremIpsumHtml) {
			return static::$loremIpsumHtml;
		}
		return static::$loremIpsumHtml = \file_get_contents('./tests/data/stringHtml.txt');
	}

	/**
	 * Creating leads module record for tests.
	 *
	 * @return \Vtiger_Record_Model
	 */
	public static function createLeadRecord()
	{
		if (static::$recordLeads) {
			return static::$recordLeads;
		}
		$recordModel = \Vtiger_Record_Model::getCleanInstance('Leads');
		$recordModel->set('company', 'TestLead sp. z o.o.');
		$recordModel->set('description', 'autogenerated test lead for \App\TextParser tests');
		$recordModel->save();
		return static::$recordLeads = $recordModel;
	}

	/**
	 * Creating leads module record for tests.
	 *
	 * @return \Vtiger_Record_Model
	 */
	public static function createCampaignRecord()
	{
		if (static::$recordCampaigns) {
			return static::$recordCampaigns;
		}
		$recordModel = \Vtiger_Record_Model::getCleanInstance('Campaigns');
		$recordModel->set('description', 'autogenerated test campaign for \App\TextParser tests');
		$recordModel->save();
		return static::$recordCampaigns = $recordModel;
	}

	/**
	 * Creating account module record for tests.
	 */
	public static function createAccountRecord()
	{
		if (static::$recordAccounts) {
			return static::$recordAccounts;
		}
		$record = \Vtiger_Record_Model::getCleanInstance('Accounts');
		$record->set('accountname', 'YetiForce Sp. z o.o.');
		$record->set('legal_form', 'PLL_GENERAL_PARTNERSHIP');
		$record->save();
		static::$recordAccounts = $record;
		return $record;
	}

	/**
	 * Testing the record creation.
	 */
	public static function testCreateRecord()
	{
		static::assertInternalType('int', static::createAccountRecord()->getId());
	}

	/**
	 * Testing editing permissions.
	 */
	public function testPermission()
	{
		$this->assertTrue(static::$recordAccounts->isEditable());
		$this->assertTrue(static::$recordAccounts->isCreateable());
		$this->assertTrue(static::$recordAccounts->isViewable());
		$this->assertFalse(static::$recordAccounts->privilegeToActivate());
		$this->assertTrue(static::$recordAccounts->privilegeToArchive());
		$this->assertTrue(static::$recordAccounts->privilegeToMoveToTrash());
		$this->assertTrue(static::$recordAccounts->privilegeToDelete());
	}

	/**
	 * Testing the edit block feature.
	 */
	public function testCheckLockFields()
	{
		$this->assertTrue(static::$recordAccounts->checkLockFields());
	}

	/**
	 * Testing record editing.
	 */
	public function testEditRecord()
	{
		static::$recordAccounts->set('accounttype', 'Customer');
		static::$recordAccounts->save();
		$this->assertTrue((new \App\Db\Query())->from('vtiger_account')->where(['account_type' => 'Customer'])->exists());
	}

	/**
	 * Testing the record label.
	 */
	public function testGetDisplayName()
	{
		$this->assertTrue(static::$recordAccounts->getDisplayName() === 'YetiForce Sp. z o.o.');
	}

	/**
	 * Testing the change record state.
	 */
	public function testStateRecord()
	{
		static::$recordAccounts->changeState('Trash');
		$this->assertSame(1, (new \App\Db\Query())->select(['deleted'])->from('vtiger_crmentity')->where(['crmid' => static::$recordAccounts->getId()])->scalar());
		static::$recordAccounts->changeState('Active');
		$this->assertSame(0, (new \App\Db\Query())->select(['deleted'])->from('vtiger_crmentity')->where(['crmid' => static::$recordAccounts->getId()])->scalar());
		static::$recordAccounts->changeState('Archived');
		$this->assertSame(2, (new \App\Db\Query())->select(['deleted'])->from('vtiger_crmentity')->where(['crmid' => static::$recordAccounts->getId()])->scalar());
	}
}
