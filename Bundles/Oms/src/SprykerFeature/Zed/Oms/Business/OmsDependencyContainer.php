<?php

namespace SprykerFeature\Zed\Oms\Business;

use SprykerEngine\Zed\Kernel\Business\AbstractDependencyContainer;
use SprykerFeature\Zed\Oms\Business\OrderStateMachine\BuilderInterface;
use SprykerFeature\Zed\Oms\Business\OrderStateMachine\DummyInterface;
use SprykerFeature\Zed\Oms\Business\OrderStateMachine\FinderInterface;
use SprykerFeature\Zed\Oms\Business\Process\ProcessInterface;
use SprykerFeature\Zed\Oms\Business\OrderStateMachine\PersistenceManagerInterface;
use SprykerFeature\Zed\Oms\Business\OrderStateMachine\OrderStateMachineInterface;
use SprykerFeature\Zed\Oms\Business\OrderStateMachine\TimeoutInterface;
use SprykerFeature\Zed\Oms\Business\Util\CollectionToArrayTransformerInterface;
use SprykerFeature\Zed\Oms\Business\Util\DrawerInterface;
use SprykerFeature\Zed\Oms\Business\Util\TransitionLogInterface;
use SprykerFeature\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use SprykerFeature\Zed\Oms\Business\Process\EventInterface;
use SprykerFeature\Zed\Oms\Business\Process\StateInterface;
use SprykerFeature\Zed\Oms\Business\Process\TransitionInterface;
use SprykerFeature\Zed\Oms\OmsConfig;
use SprykerFeature\Zed\Oms\Persistence\OmsQueryContainer;
use Generated\Zed\Ide\FactoryAutoCompletion\OmsBusiness;

/**
 * @method OmsBusiness getFactory()
 * @method OmsConfig getConfig()
 */
class OmsDependencyContainer extends AbstractDependencyContainer
{
    /**
     * @return CollectionToArrayTransformerInterface
     */
    public function createUtilCollectionToArrayTransformer()
    {
        return $this->getFactory()->createUtilCollectionToArrayTransformer();
    }

    /**
     * @return ReadOnlyArrayObject
     */
    public function createUtilReadOnlyArrayObject()
    {
        return $this->getFactory()->createUtilReadOnlyArrayObject(array());
    }

    /**
     * @return OmsQueryContainer
     */
    public function createQueryContainer()
    {
        return $this->getLocator()->oms()->queryContainer();
    }

    /**
     * @param array $logContext
     *
     * @return OrderStateMachineInterface
     */
    public function createOrderStateMachineOrderStateMachine(array $logContext)
    {
        return $this->getFactory()->createOrderStateMachineOrderStateMachine(
            $this->createQueryContainer(),
            $this->createOrderStateMachineBuilder(),
            $this->createUtilTransitionLog($logContext),
            $this->createOrderStateMachineTimeout(),
            $this->createUtilCollectionToArrayTransformer(),
            $this->createUtilReadOnlyArrayObject(),
            $this->getConfig()->getConditions(),
            $this->getConfig()->getCommands(),
            $this->getFactory()
        );
    }

    /**
     * @param string $xmlFolder
     *
     * @return BuilderInterface
     */
    public function createOrderStateMachineBuilder($xmlFolder = null)
    {
        return $this->getFactory()->createOrderStateMachineBuilder(
            $this->createProcessEvent(),
            $this->createProcessState(),
            $this->createProcessTransition(),
            $this->createProcessProcess(),
            $xmlFolder
        );
    }

    /**
     * @return DummyInterface
     */
    public function createModelDummy()
    {
        return $this->getFactory()->createOrderStateMachineDummy(
            $this->createOrderStateMachineBuilder()
        );
    }

    /**
     * @return FinderInterface
     */
    public function createOrderStateMachineFinder()
    {
        $config = $this->getConfig();

        return $this->getFactory()->createOrderStateMachineFinder(
            $this->createQueryContainer(),
            $this->createOrderStateMachineBuilder(),
            $config->getActiveProcesses()
        );
    }

    /**
     * @return TimeoutInterface
     */
    public function createOrderStateMachineTimeout()
    {
        return $this->getFactory()->createOrderStateMachineTimeout(
            $this->createQueryContainer()
        );
    }

    /**
     * @param array $logContext
     *
     * @return TransitionLogInterface
     */
    public function createUtilTransitionLog(array $logContext)
    {
        $queryContainer = $this->createQueryContainer();

        return $this->getFactory()
            ->createUtilTransitionLog($queryContainer, $logContext);
    }

    /**
     * @return PersistenceManagerInterface
     */
    public function createOrderStateMachinePersistenceManager()
    {
        return $this->getFactory()->createOrderStateMachinePersistenceManager();
    }

    /**
     * @return EventInterface
     */
    public function createProcessEvent()
    {
        return $this->getFactory()->createProcessEvent();
    }

    /**
     * @return StateInterface
     */
    public function createProcessState()
    {
        return $this->getFactory()->createProcessState();
    }

    /**
     * @return TransitionInterface
     */
    public function createProcessTransition()
    {
        return $this->getFactory()->createProcessTransition();
    }

    /**
     * @return ProcessInterface
     */
    public function createProcessProcess()
    {
        return $this->getFactory()
            ->createProcessProcess($this->createUtilDrawer());
    }

    /**
     * @return DrawerInterface
     */
    public function createUtilDrawer()
    {
        return $this->getFactory()
            ->createUtilDrawer($this->getConfig());
    }
}