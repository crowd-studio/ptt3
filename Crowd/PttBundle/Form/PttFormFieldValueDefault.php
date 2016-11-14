<?php

/*
 * COPYRIGHT © 2014 THE CROWD CAVE S.L.
 * All rights reserved. No part of this publication may be reproduced, distributed, or transmitted in any form or by any means, including photocopying, recording, or other electronic or mechanical methods, without the prior written permission of the publisher.
 */

namespace Crowd\PttBundle\Form;

class PttFormFieldValueDefault extends PttFormFieldValue
{
    public function value()
    {
        if ($this->entityInfo->hasMethod('get' . ucfirst($this->field->name), $this->languageCode)) {
            return $this->entityInfo->get($this->field->name, $this->languageCode);
        } else {
            return null;
        }
    }
}