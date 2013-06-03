<?php
namespace Ice\MercuryClientBundle\Util;

use Ice\MercuryClientBundle\Entity\Receivable;

/**
 * A class providing static functions for some common lookups
 *
 * Class Lookup
 * @package Ice\MercuryClientBundle\Util
 */
class Lookup
{
    /**
     * Returns a human-friendly form of a payment method code.
     *
     * @param string $method
     * @return string
     */
    public static function friendlyPaymentMethodDescription($method)
    {
        $mappings = [
            Receivable::METHOD_ONLINE => 'Online',
            Receivable::METHOD_MANUAL => 'Manual payment',
            Receivable::METHOD_BACS => 'BACS payment',
            Receivable::METHOD_CHEQUE => 'Cheque payment',
            Receivable::METHOD_INVOICE => 'Invoice payment',
            Receivable::METHOD_PDQ => 'PDQ payment',
            Receivable::METHOD_STUDENT_LOAN => 'Student loan'
        ];
        
        if (isset($mappings[$method])) {
            return $mappings[$method];
        }

        return ucwords($method);
    }
}