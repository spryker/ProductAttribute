<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Glossary\Dependency\Facade;

use Spryker\Zed\Messenger\Business\MessengerFacade;
use Generated\Shared\Transfer\MessageTransfer;

class GlossaryToMessengerBridge implements GlossaryToMessengerInterface
{

    /**
     * @var MessengerFacade
     */
    protected $messengerFacade;

    /**
     * @param MessengerFacade $messengerFacade
     */
    public function __construct($messengerFacade)
    {
        $this->messengerFacade = $messengerFacade;
    }

    /**
     * @param MessageTransfer $message
     *
     * @return void
     */
    public function addErrorMessage(MessageTransfer $message)
    {
        $this->messengerFacade->addErrorMessage($message);
    }

}