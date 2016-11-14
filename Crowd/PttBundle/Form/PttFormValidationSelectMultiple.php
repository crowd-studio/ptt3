<?php

/*
 * COPYRIGHT © 2014 THE CROWD CAVE S.L.
 * All rights reserved. No part of this publication may be reproduced, distributed, or transmitted in any form or by any means, including photocopying, recording, or other electronic or mechanical methods, without the prior written permission of the publisher.
 */

namespace Crowd\PttBundle\Form;

class PttFormValidationSelectMultiple extends PttFormValidation
{
	public function isValid()
	{
		if($this->_sentValue() !== '' && $this->pttForm->getSentData($this->field->name . '_title', $this->languageCode) !== ''){
			return true;
		} else {
			return false;
		}
	}
}