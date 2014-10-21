<?php
require 'app/code/core/Mage/Customer/controllers/AccountController.php';
class Sitemaster_AjaxLogin_Customer_AccountController extends Mage_Customer_AccountController
{
    protected $_honeyPotFields = array('site');

    protected function _isHoneyPotFilled()
    {
        $result  = false;
        $request = $this->getRequest();
        foreach ($this->_honeyPotFields as $field) {
            $value = $request->getPost($field);
            if (trim($value)) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    public function loginCustomerAction()
    {
        $response = $this->getResponse();
        $request  = $this->getRequest();
        $result   = new Varien_Object();

        if ($this->_getSession()->isLoggedIn() || !$request->isPost()) {
            $result->redirect = Mage::getUrl('*/*/');
            return $response->setBody($result->toJSON());
        }

        $login = $request->getPost('login');
        if (empty($login['username']) || empty($login['password'])) {
            $result->error = $this->__('Login and password are required.');
            return $response->setBody($result->toJSON());
        }

        $session = $this->_getSession();
        try {
            $session->login($login['username'], $login['password']);
            if ($session->getCustomer()->getIsJustConfirmed()) {
                $this->_welcomeCustomer($session->getCustomer(), true);
            }
        } catch (Mage_Core_Exception $e) {
            switch ($e->getCode()) {
                case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
                    $value = Mage::helper('customer')->getEmailConfirmationUrl($login['username']);
                    $message = Mage::helper('customer')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
                    break;
                case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                    $message = $e->getMessage();
                    break;
                default:
                    $message = $e->getMessage();
            }
            $result->error = $message;
            $session->setUsername($login['username']);
        } catch (Exception $e) {
        }

        if (!$session->getBeforeAuthUrl() || $session->getBeforeAuthUrl() == Mage::getBaseUrl()) {
            // Set default URL to redirect customer to
            $session->setBeforeAuthUrl(Mage::helper('customer')->getAccountUrl());
            // Redirect customer to the last page visited after logging in
            if ($session->isLoggedIn()) {
                if (!Mage::getStoreConfigFlag('customer/startup/redirect_dashboard')) {
                    $referer = $this->getRequest()->getParam(Mage_Customer_Helper_Data::REFERER_QUERY_PARAM_NAME);
                    if ($referer) {
                        $referer = Mage::helper('core')->urlDecode($referer);
                        if ($this->_isUrlInternal($referer)) {
                            $session->setBeforeAuthUrl($referer);
                        }
                    }
                } else if ($session->getAfterAuthUrl()) {
                    $session->setBeforeAuthUrl($session->getAfterAuthUrl(true));
                }
            } else {
                $session->setBeforeAuthUrl(Mage::helper('customer')->getLoginUrl());
            }
        } else if ($session->getBeforeAuthUrl() == Mage::helper('customer')->getLogoutUrl()) {
            $session->setBeforeAuthUrl(Mage::helper('customer')->getDashboardUrl());
        } else {
            if (!$session->getAfterAuthUrl()) {
                $session->setAfterAuthUrl($session->getBeforeAuthUrl());
            }
            if ($session->isLoggedIn()) {
                $session->setBeforeAuthUrl($session->getAfterAuthUrl(true));
            }
        }

        $result->redirect = $session->getBeforeAuthUrl(true);
        return $response->setBody($result->toJSON());
    }

    public function createCustomerAction()
    {
        $response = $this->getResponse();
        $request  = $this->getRequest();
        $result   = new Varien_Object();
        $session  = $this->_getSession();

        if ($session->isLoggedIn() || !$request->isPost()) {
            $result->redirect = Mage::getUrl('*/*/');
            return $response->setBody($result->toJSON());
        }

        if ($this->_isHoneyPotFilled()) {
            $result->error = $this->__('Invalid data');
            return $response->setBody($result->toJSON());
        }

        if (!$customer = Mage::registry('current_customer')) {
            $customer = Mage::getModel('customer/customer')->setId(null);
        }

        /* @var $customerForm Mage_Customer_Model_Form */
        $customerForm = Mage::getModel('customer/form');
        $customerForm->setFormCode('customer_account_create')
            ->setEntity($customer);

        $request->setPost('confirmation', $request->getPost('password'));
        $customerData = $customerForm->extractData($request);
        /**
         * Initialize customer group id
         */
        $customer->getGroupId();
        $errors = array();

        try {
            $customerErrors = $customerForm->validateData($customerData);
            if ($customerErrors === true) {
                $customerForm->compactData($customerData);
                $customer->setPassword($request->getPost('password'));
                $customer->setConfirmation($request->getPost('confirmation'));
                $customerErrors = $customer->validate();
                if (is_array($customerErrors)) {
                    $errors = array_merge($customerErrors, $errors);
                }
            } else {
                $errors = $customerErrors;
            }

            if (empty($errors)) {
                $customer->save();

                if ($customer->isConfirmationRequired()) {
                    $customer->sendNewAccountEmail('confirmation', $session->getBeforeAuthUrl());
                    $result->error    = $this->__('Account confirmation is required. Please, check your email for the confirmation link. To resend the confirmation email please <a href="%s">click here</a>.', Mage::helper('customer')->getEmailConfirmationUrl($customer->getEmail()));
                    $result->redirect = Mage::getUrl('*/*/index', array('_secure'=>true));
                } else {
                    $session->setCustomerAsLoggedIn($customer);
                    $url = $this->_welcomeCustomer($customer);
                    $result->redirect = $url;

                }
            }
        } catch (Mage_Core_Exception $e) {
            if ($e->getCode() === Mage_Customer_Model_Customer::EXCEPTION_EMAIL_EXISTS) {
                $url = Mage::getUrl('customer/account/forgotpassword');
                $message = $this->__('There is already an account with this email address. If you are sure that it is your email address, <a href="%s">click here</a> to get your password and access your account.', $url);
                $session->setEscapeMessages(false);
            } else {
                $message = $e->getMessage();
            }
            $errors[] = $message;
        } catch (Exception $e) {
            $errors[] = $this->__('Cannot save the customer.');
        }

        if (!empty($errors)) {
            $result->error = $errors;
        }

        return $response->setBody($result->toJSON());
    }
}
