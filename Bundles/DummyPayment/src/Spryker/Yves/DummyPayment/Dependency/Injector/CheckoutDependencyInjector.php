<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\DummyPayment\Dependency\Injector;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Shared\Kernel\ContainerInterface;
use Spryker\Yves\Checkout\CheckoutDependencyProvider;
use Spryker\Yves\Kernel\Dependency\Injector\AbstractDependencyInjector;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection;

/**
 * @method \Spryker\Yves\DummyPayment\DummyPaymentFactory getFactory()
 */
class CheckoutDependencyInjector extends AbstractDependencyInjector
{

    /**
     * @param \Spryker\Shared\Kernel\ContainerInterface|\Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Shared\Kernel\ContainerInterface|\Spryker\Yves\Kernel\Container
     */
    public function inject(ContainerInterface $container)
    {
        $container = $this->injectPaymentSubForms($container);
        $container = $this->injectPaymentMethodHandler($container);

        return $container;
    }

    /**
     * @param \Spryker\Shared\Kernel\ContainerInterface $container
     *
     * @return \Spryker\Shared\Kernel\ContainerInterface
     */
    protected function injectPaymentSubForms(ContainerInterface $container)
    {
        $container->extend(CheckoutDependencyProvider::PAYMENT_SUB_FORMS, function (SubFormPluginCollection $paymentSubForms) {
            $paymentSubForms->add($this->getFactory()->createCreditCardSubFormPlugin());
            $paymentSubForms->add($this->getFactory()->createInvoiceSubFormPlugin());

            return $paymentSubForms;
        });

        return $container;
    }

    /**
     * @param \Spryker\Shared\Kernel\ContainerInterface $container
     *
     * @return \Spryker\Shared\Kernel\ContainerInterface
     */
    protected function injectPaymentMethodHandler(ContainerInterface $container)
    {
        $container->extend(CheckoutDependencyProvider::PAYMENT_METHOD_HANDLER, function (StepHandlerPluginCollection $paymentMethodHandler) {
            $dummyPaymentHandlerPlugin = $this->getFactory()->createDummyPaymentHandlerPlugin();

            $paymentMethodHandler->add($dummyPaymentHandlerPlugin, PaymentTransfer::DUMMY_PAYMENT_CREDIT_CARD);
            $paymentMethodHandler->add($dummyPaymentHandlerPlugin, PaymentTransfer::DUMMY_PAYMENT_INVOICE);

            return $paymentMethodHandler;
        });

        return $container;
    }

}