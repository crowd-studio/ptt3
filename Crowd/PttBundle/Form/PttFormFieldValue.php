<?php

/*
 * COPYRIGHT © 2014 THE CROWD CAVE S.L.
 * All rights reserved. No part of this publication may be reproduced, distributed, or transmitted in any form or by any means, including photocopying, recording, or other electronic or mechanical methods, without the prior written permission of the publisher.
 */

namespace Crowd\PttBundle\Form;

use Symfony\Component\HttpFoundation\Request;

class PttFormFieldValue
{
    protected $field;
    protected $entityInfo;
    protected $sentData;
    protected $languageCode;
    protected $request;

    public function __construct(PttField $field, PttEntityInfo $entityInfo, $sentData, Request $request, $languageCode)
    {
        $this->field = $field;
        $this->entityInfo = $entityInfo;
        $this->sentData = $sentData;
        $this->request = $request;
        $this->languageCode = $languageCode;
    }
}