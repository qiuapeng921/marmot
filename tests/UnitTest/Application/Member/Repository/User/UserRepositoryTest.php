<?php
namespace Member\Repository\User;

use tests\GenericTestCase;
use Prophecy\Argument;

use Marmot\Core;
use Member\Model\User;
use Member\Utils\ObjectGenerate;
use Member\Utils\UserUtils;
use Member\Adapter\User\IUserAdapter;

/**
 * Member/Repository/User/UserRepository.class.php 测试文件
 * @author chloroplast
 * @version 1.0.20160218
 */
class UserRepositoryTest extends GenericTestCase
{
    private $repository;

    public function setUp()
    {
        $this->repository = Core::$container->get('Member\Repository\User\UserRepository');
        parent::setUp();
    }
    /**
     * 测试仓库构建
     */
    public function testUserRepositoryConstructor()
    {
        $adapter= $this->getPrivateProperty(
            'Member\Repository\User\UserRepository',
            'adapter'
        );
        $this->assertInstanceOf(
            'Member\Adapter\User\UserDataBaseAdapter',
            $adapter->getValue($this->repository)
        );
    }
    //测试default getAdapter
    //测试setAdapter

    /**
     * 测试仓库add
     */
    public function testAdd()
    {
        $user = ObjectGenerate::generateUser(1);

        $adapter = $this->prophesize(IUserAdapter::class);
        $adapter->add(Argument::exact($user))
            ->shouldBeCalledTimes(1);

        $this->repository->setAdapter($adapter->reveal());

        $this->repository->add($user);
    }

    /**
     * 测试仓库save
     */
    public function testUpdate()
    {
        $user = ObjectGenerate::generateUser(1);
        $modifyKeys = array('nickName','realName');

        $adapter = $this->prophesize(IUserAdapter::class);
        $adapter->update(Argument::exact($user), Argument::exact($modifyKeys))
            ->shouldBeCalledTimes(1);

        $this->repository->setAdapter($adapter->reveal());

        $this->repository->update($user, $modifyKeys);
    }

    /**
     * 测试仓库获取单独数据
     */
    public function testGetOne()
    {
        $id = 1;

        $adapter = $this->prophesize(IUserAdapter::class);
        $adapter->getOne(Argument::exact($id))
                ->shouldBeCalledTimes(1);

        $this->repository->setAdapter($adapter->reveal());

        $this->repository->getOne($id);
    }

    /**
     * 测试仓库获取批量数据
     */
    public function testGetList()
    {
        $ids = [1,2,3,4,5,6,7,8,9,10];

        $adapter = $this->prophesize(IUserAdapter::class);
        $adapter->getList(Argument::exact($ids))
                ->shouldBeCalledTimes(1);

        $this->repository->setAdapter($adapter->reveal());

        $this->repository->getList($ids);
    }

    public function testFilter()
    {
        $filter = array('cellPhone'=>'15202939435');
        $sort = array('id'=>-1);
        $offset = 10;
        $size = 10;

        $adapter = $this->prophesize(IUserAdapter::class);
        $adapter->filter(
            Argument::exact($filter),
            Argument::exact($sort),
            Argument::exact($offset),
            Argument::exact($size)
        )->shouldBeCalledTimes(1);

        $this->repository->setAdapter($adapter->reveal());

        $this->repository->filter($filter, $sort, $offset, $size);
    }
}
