<?PHP

class AOD_IndexTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testAOD_Index()
    {

        
        $aod_index = new AOD_Index();
        $this->assertInstanceOf('AOD_Index', $aod_index);
        $this->assertInstanceOf('Basic', $aod_index);
        $this->assertInstanceOf('SugarBean', $aod_index);

        $this->assertAttributeEquals('AOD_Index', 'module_dir', $aod_index);
        $this->assertAttributeEquals('AOD_Index', 'object_name', $aod_index);
        $this->assertAttributeEquals('aod_index', 'table_name', $aod_index);
        $this->assertAttributeEquals(true, 'new_schema', $aod_index);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aod_index);
        $this->assertAttributeEquals(false, 'importable', $aod_index);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aod_index);
    }

    public function testisEnabled()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $aod_index = new AOD_Index();

        
        $result = $aod_index->isEnabled();
        $this->assertTrue($result);
        
        
        
        
    }

    public function testfind()
    {
        self::markTestIncomplete('[Zend_Search_Lucene_Exception] File \'modules/AOD_Index/Index/Index/segments_31\' is not readable.');
        $aod_index = new AOD_Index();

        $aod_index->id = 1;
        $aod_index->location = 'modules/AOD_Index/Index/Index';

         
         $hits = $aod_index->find('/');
        $this->assertTrue(is_array($hits));
    }

    public function testoptimise()
    {
	self::markTestIncomplete('[Zend_Search_Lucene_Exception] File \'modules/AOD_Index/Index/Index/segments_31\' is not readable.');
        

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('tracker');

	
        
        $aod_index = new AOD_Index();
        $aod_index->id = 1;
        $aod_index->location = 'modules/AOD_Index/Index/Index';
        $last_optimized = $aod_index->last_optimised;

        
        $aod_index->optimise();
        $this->assertGreaterThan($last_optimized, $aod_index->last_optimised);
        
        
        
        $state->popTable('tracker');

    }

    public function testgetIndex()
    {
        $aod_index = new AOD_Index();
        $result = $aod_index->getIndex();

        
        $this->assertInstanceOf('AOD_Index', $result);
        $this->assertNotSame($aod_index, $result);
    }

    public function testgetDocumentForBean()
    {
        $user = new User(1);

        $aod_index = new AOD_Index();
        $result = $aod_index->getDocumentForBean($user);

        
        $this->assertTrue(is_array($result));

        
        $this->assertInstanceOf('Zend_Search_Lucene_Document', $result['document']);
    }

    public function testcommit()
    {
        self::markTestIncomplete('File \'modules/AOD_Index/Index/Index/segments_31\' is not readable.');
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $aod_index = new AOD_Index();
        $aod_index->id = 1;
        $aod_index->location = 'modules/AOD_Index/Index/Index';

        
        try {
            $aod_index->commit();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testisModuleSearchable()
    {

        
        $this->assertFalse(AOD_Index::isModuleSearchable('', ''));

        
        $this->assertTrue(AOD_Index::isModuleSearchable('DocumentRevisions', 'DocumentRevision'));
        $this->assertTrue(AOD_Index::isModuleSearchable('Cases', 'Case'));
        $this->assertTrue(AOD_Index::isModuleSearchable('Accounts', 'Account'));

        
        $this->assertFalse(AOD_Index::isModuleSearchable('AOD_IndexEvent', 'AOD_IndexEvent'));
        $this->assertFalse(AOD_Index::isModuleSearchable('AOD_Index', 'AOD_Index'));
        $this->assertFalse(AOD_Index::isModuleSearchable('AOW_Actions', 'AOW_Action'));
        $this->assertFalse(AOD_Index::isModuleSearchable('AOW_Conditions', 'AOW_Condition'));
        $this->assertFalse(AOD_Index::isModuleSearchable('AOW_Processed', 'AOW_Processed'));
        $this->assertFalse(AOD_Index::isModuleSearchable('SchedulersJobs', 'SchedulersJob'));
        $this->assertFalse(AOD_Index::isModuleSearchable('Users', 'User'));
    }

    public function testindex()
    {
        $aod_index = new AOD_Index();
        $aod_index->id = 1;
        $aod_index->location = 'modules/AOD_Index/Index/Index';

        
        $result = $aod_index->index('Users', 1);
        $this->assertFalse($result);

        
        $result = $aod_index->index('Accounts', 1);
        $this->assertEquals(null, $result);
        
    }

    public function testremove()
    {
        self::markTestIncomplete('File \'modules/AOD_Index/Index/Index/segments_31\' is not readable.');
        
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $aod_index = new AOD_Index();
        $aod_index->id = 1;
        $aod_index->location = 'modules/AOD_Index/Index/Index';

        
        try {
            $aod_index->remove('Accounts', 1);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testgetIndexableModules()
    {
        $expected = array(
            'AM_ProjectTemplates' => 'AM_ProjectTemplates',
            'AM_TaskTemplates' => 'AM_TaskTemplates',
            'AOK_KnowledgeBase' => 'AOK_KnowledgeBase',
            'AOK_Knowledge_Base_Categories' => 'AOK_Knowledge_Base_Categories',
            'AOP_Case_Events' => 'AOP_Case_Events',
            'AOP_Case_Updates' => 'AOP_Case_Updates',
            'AOR_Charts' => 'AOR_Chart',
            'AOR_Conditions' => 'AOR_Condition',
            'AOR_Fields' => 'AOR_Field',
            'AOR_Reports' => 'AOR_Report',
            'AOS_Contracts' => 'AOS_Contracts',
            'AOS_Product_Categories' => 'AOS_Product_Categories',
            'AOW_WorkFlow' => 'AOW_WorkFlow',
            'Accounts' => 'Account',
            'Bugs' => 'Bug',
            'Calls' => 'Call',
            'Calls_Reschedule' => 'Calls_Reschedule',
            'Campaigns' => 'Campaign',
            'Cases' => 'aCase',
            'Contacts' => 'Contact',
            'DocumentRevisions' => 'DocumentRevision',
            'Documents' => 'Document',
            'FP_events' => 'FP_events',
            'Leads' => 'Lead',
            'Meetings' => 'Meeting',
            'Notes' => 'Note',
            'Opportunities' => 'Opportunity',
            'OutboundEmailAccounts' => 'OutboundEmailAccounts',
            'Project' => 'Project',
            'ProjectTask' => 'ProjectTask',
            'ProspectLists' => 'ProspectList',
            'Prospects' => 'Prospect',
            'SurveyQuestionOptions' => 'SurveyQuestionOptions',
            'SurveyQuestionResponses' => 'SurveyQuestionResponses',
            'SurveyQuestions' => 'SurveyQuestions',
            'SurveyResponses' => 'SurveyResponses',
            'Surveys' => 'Surveys',
            'Tasks' => 'Task'
        );

        $aod_index = new AOD_Index();

        
        $actual = $aod_index->getIndexableModules();
        $this->assertSame($expected, $actual);
    }
}
