<?php
/**
 *
 * Copyright © Magestore, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magestore\Quotation\Controller\Quote;

use Magestore\Quotation\Api\QuotationManagementInterface;

class View extends \Magestore\Quotation\Controller\AbstractAction
{
    /**
     * @var \Magento\Quote\Model\QuoteFactory
     */
    protected $quoteFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magestore\Quotation\Api\QuotationManagementInterface
     */
    protected $quotationManagement;

    /**
     * View constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magestore\Quotation\Helper\Data $helper
     * @param \Magestore\Quotation\Api\QuotationManagementInterface $quotationManagement
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magestore\Quotation\Helper\Data $helper,
        \Magestore\Quotation\Api\QuotationManagementInterface $quotationManagement,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $customerSession
    ){
        parent::__construct($context, $helper);
        $this->quotationManagement = $quotationManagement;
        $this->quoteFactory = $quoteFactory;
        $this->registry = $registry;
        $this->customerSession = $customerSession;
    }

    /**
     * Customer quote detail
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $quoteId = (int)$this->getRequest()->getParam('quote_id');
        if (!$quoteId) {
            $resultForward = $this->createForwardResult();
            return $resultForward->forward('noroute');
        }

        $quote = $this->quoteFactory->create()->load($quoteId);
        if ($quote->getId()) {
            $canView = $this->quotationManagement->canView($quote);
            if($canView['error'] === false){
                $this->quotationManagement->isExpired($quote);
                $this->registry->register('current_quote', $quote);
                $resultPage = $this->createPageResult();
                $navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation');
                if ($navigationBlock) {
                    $navigationBlock->setActive('quotation/quote/history');
                }
                return $resultPage;
            }else{
                if($canView['error_code'] == QuotationManagementInterface::ERROR_NOT_LOGIN){
                    $resultRedirect = $this->createRedirectResult();
                    $resultRedirect->setPath('customer/account/login');
                    return $resultRedirect;
                }else{
                    if($canView['error_message']){
                        $this->messageManager->addErrorMessage($canView['error_message']);
                    }
                }
            }
        }
        $resultRedirect = $this->createRedirectResult();
        return $resultRedirect->setUrl($this->_url->getUrl('*/*/history'));
    }
}
