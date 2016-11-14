<?php

/*
 * COPYRIGHT © 2014 THE CROWD CAVE S.L.
 * All rights reserved. No part of this publication may be reproduced, distributed, or transmitted in any form or by any means, including photocopying, recording, or other electronic or mechanical methods, without the prior written permission of the publisher.
 */

namespace Crowd\PttBundle\Form;

use Symfony\Component\HttpFoundation\Request;

class PttFormFieldSentValueDefault extends PttFormFieldSentValue
{
    public function value()
    {
        // return (isset($this->sentData[$this->field->name])) ? $this->sentData[$this->field->name] : null;
        return (isset($this->sentData)) ? $this->sentData : null;
    }
}