<?php
namespace UserGroup\Adapter\UserGroup;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Marmot\Framework\Interfaces\ITranslator;

use UserGroup\Model\NullUserGroup;
use UserGroup\Utils\ObjectGenerate;

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

            public function getTranslator(): ITranslator
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
            'UserGroup\Adapter\UserGroup\IUserGroupAdapter',
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
            'Marmot\Framework\Interfaces\ITranslator',
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
