<?php
namespace Sample\Sdk\UserGroup\Adapter\UserGroup;

use PHPUnit\Framework\TestCase;

use Marmot\Interfaces\IRestfulTranslator;

use Sample\Sdk\UserGroup\Model\NullUserGroup;
use Sample\Sdk\UserGroup\Utils\ObjectGenerate;

class UserGroupRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(UserGroupRestfulAdapter::class)
                    ->setMethods(['fetchOneAction'])->getMock();
                    
        $this->childStub = new class extends UserGroupRestfulAdapter
        {
            public function getResource(): string
            {
                return parent::getResource();
            }

            public function getTranslator(): IRestfulTranslator
            {
                return parent::getTranslator();
            }

            public function getScenario(): array
            {
                return parent::getScenario();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testCorrectInstanceImplementsUserGroupAdapter()
    {
        $this->assertInstanceof(
            'Sample\Sdk\UserGroup\Adapter\UserGroup\IUserGroupAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('userGroups', $this->childStub->getResource());
    }

    public function testGetTransltor()
    {
        $this->assertInstanceOf(
            'Marmot\Interfaces\IRestfulTranslator',
            $this->childStub->getTranslator()
        );
    }

    /**
     * @dataProvider scenarioDataProvider
     */
    public function testScenario($expect, $actural)
    {
        $this->childStub->scenario($expect);
        $this->assertEquals($actural, $this->childStub->getScenario());
    }

    public function scenarioDataProvider()
    {
        return [
            ['USERGROUP_LIST', UserGroupRestfulAdapter::SCENARIOS['USERGROUP_LIST']],
            ['USERGROUP_FETCH_ONE', UserGroupRestfulAdapter::SCENARIOS['USERGROUP_FETCH_ONE']],
            ['NULL', array()]
        ];
    }

    public function testFetchOne()
    {
        $id = 1;

        $userGroup = ObjectGenerate::generateUserGroup($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullUserGroup())
            ->willReturn($userGroup);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($userGroup, $result);
    }
}
