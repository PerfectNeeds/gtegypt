<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\DynamicPage;

/**
 * DynamicPage controller.
 *
 * @Route("/services")
 */
class ServiceController extends Controller {

    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/advisory-services", name="fe_advisory")
     * @Method("GET")
     * @Template()
     */
    public function advisoryServicesAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/business-consulting", name="fe_business-consulting")
     * @Method("GET")
     * @Template()
     */
    public function businessConsultingAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/transaction-advisory", name="fe_transaction-advisory")
     * @Method("GET")
     * @Template()
     */
    public function transactionAdvisoryAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/forensic-investigative-and-dispute-services", name="fe_forensic-investigative")
     * @Method("GET")
     * @Template()
     */
    public function forensicInvestigativeAndDisputeServicesAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/restructuring-and-turnaround", name="fe_restructuring")
     * @Method("GET")
     * @Template()
     */
    public function restructuringAndTurnaroundAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/business-analytics", name="fe_business-analytics")
     * @Method("GET")
     * @Template()
     */
    public function businessAnalyticsAction() { 

        return array(
        );
    }
    
    
    
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/corporate-finance-services", name="fe_corporate-Finance-services")
     * @Method("GET")
     * @Template()
     */
    public function corporateFinanceServicesAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/management-services", name="fe_management-services")
     * @Method("GET")
     * @Template()
     */
    public function managementServicesAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/technology-solutions", name="fe_technology-solutions")
     * @Method("GET")
     * @Template()
     */
    public function technologySolutionsAction() { 

        return array(
        );
    }
    
    
    
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/enterprise-transformation", name="fe_enterprise-transformation")
     * @Method("GET")
     * @Template()
     */
    public function enterpriseTransformationAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/finance-operations", name="fe_finance-operations")
     * @Method("GET")
     * @Template()
     */
    public function financeOperationsAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/performance-improvement", name="fe_performance-improvement")
     * @Method("GET")
     * @Template()
     */
    public function performanceImprovementAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/governance-risk-and-compliance", name="fe_governance-risk-and-compliance")
     * @Method("GET")
     * @Template()
     */
    public function governanceRiskAndComplianceAction() { 

        return array(
        );
    }
    
    
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/cybersecurity", name="fe_cybersecurity")
     * @Method("GET")
     * @Template()
     */
    public function cyberSecurityAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/enterprise-risk-management", name="fe_enterprise-risk-management")
     * @Method("GET")
     * @Template()
     */
    public function enterpriseRiskManagementAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/internal-audit", name="fe_internal-audit")
     * @Method("GET")
     * @Template()
     */
    public function internalAuditAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/regulatory-compliance", name="fe_regulatory-compliance")
     * @Method("GET")
     * @Template()
     */
    public function regulatoryComplianceAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/service-organization-attestation-reports", name="fe_service-organization")
     * @Method("GET")
     * @Template()
     */
    public function serviceOrganizationAttestationReportsAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/audit", name="fe_audit")
     * @Method("GET")
     * @Template()
     */
    public function auditAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/fainancial-audit", name="fe_fainancial-audit")
     * @Method("GET")
     * @Template()
     */
    public function fainancialAuditAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/ifrs-reporting", name="fe_ifrs-reporting")
     * @Method("GET")
     * @Template()
     */
    public function ifrsReportingAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/fresh-start-accounting", name="fe_fresh-start-accounting")
     * @Method("GET")
     * @Template()
     */
    public function freshStartAccountingAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/public-finance", name="fe_public-finance")
     * @Method("GET")
     * @Template()
     */
    public function publicFinanceAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/employee-plan-audit", name="fe_employee-plan-audit")
     * @Method("GET")
     * @Template()
     */
    public function employeePlanAuditAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/tax", name="fe_tax")
     * @Method("GET")
     * @Template()
     */
    public function taxAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/compensation-and-benefits-consulting", name="fe_compensation-and-benefits-consulting")
     * @Method("GET")
     * @Template()
     */
    public function compensationAndBenefitsConsultingAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/international-tax", name="fe_international-tax")
     * @Method("GET")
     * @Template()
     */
    public function internationalTaxAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/private-wealth-services", name="fe_private-wealth-services")
     * @Method("GET")
     * @Template()
     */
    public function privateWealthServiceAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/state-and-local-tax", name="fe_state-and-local-tax")
     * @Method("GET")
     * @Template()
     */
    public function stateAndLocalTaxAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/tax-accounting", name="fe_tax-accounting")
     * @Method("GET")
     * @Template()
     */
    public function taxAccountingAction() { 

        return array(
        );
    }
    
    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/tax-compliance", name="fe_tax-compliance")
     * @Method("GET")
     * @Template()
     */
    public function taxComplianceAction() { 

        return array(
        );
    }
    
}
