<?php

/*
 * COPYRIGHT © 2014 THE CROWD CAVE S.L.
 * All rights reserved. No part of this publication may be reproduced, distributed, or transmitted in any form or by any means, including photocopying, recording, or other electronic or mechanical methods, without the prior written permission of the publisher.
 */

namespace Crowd\PttBundle\Form;

use Crowd\PttBundle\Util\PttUtil;

class PttFormValidationEmail extends PttFormValidation
{
	public function isValid()
	{
        if ($this->_sentValue() == '') {
            return true;
        } else {
            return (filter_var($this->_sentValue(), FILTER_VALIDATE_EMAIL));
        }
	}
}