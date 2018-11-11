<?php

namespace DansMaCulotte\ColissimoWebServices;

use DansMaCulotte\ColissimoWebServices\Client;

/**
 * Implementation of Postage Web Service
 * https://www.colissimo.entreprise.laposte.fr/system/files/imagescontent/docs/spec_ws_affranchissement.pdf
 */
class Postage extends Client
{
    const SERVICE_URL = 'https://ws.colissimo.fr/sls-ws/SlsServiceWS/2.0?wsdl';

    public function __construct($credentials, $options = array())
    {
        parent::__construct($credentials, self::SERVICE_URL, $options);
    }

    public function generateLabel($outputFormat, $letter, $options = array())
    {
        $options = array_merge(
            array(
                'outputFormat' => $outputFormat,
                'letter' => $letter,
            ),
            $options
        );

        $result = $this->soapExec(
            'generateLabel',
            $options
        );

        $result = $result->return;

        if ($result->errorCode != 0) {
            throw new \Exception(
                'Failed to generate label: '.$result->errorMessage
            );
        }

    }
}