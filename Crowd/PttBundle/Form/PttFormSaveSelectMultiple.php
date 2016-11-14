<?php

/*
 * COPYRIGHT © 2014 THE CROWD CAVE S.L.
 * All rights reserved. No part of this publication may be reproduced, distributed, or transmitted in any form or by any means, including photocopying, recording, or other electronic or mechanical methods, without the prior written permission of the publisher.
 */

namespace Crowd\PttBundle\Form;

use Crowd\PttBundle\Form\PttFormSave;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PttFormSaveSelectMultiple extends PttFormSave
{
    public function value()
    {
        $em = $this->entityInfo->getEntityManager();
        $entityModel = null;
        if($this->languageCode){
            $model = $this->sentData[$this->languageCode][$this->field->name . '_model'];
            $id = $this->sentData[$this->languageCode][$this->field->name];
            $entityModel = $em->getRepository($this->entityInfo->getBundle() . ':' . $model . 'Trans')->findOneBy(array('relatedId' => $id, 'language' => $this->languageCode));
        } else {
            $model = $this->sentData[$this->field->name . '_model'];
            $id = $this->sentData[$this->field->name];
            $entityModel = $em->getRepository($this->entityInfo->getBundle() . ':' . $model)->find($id);
        }

        if($entityModel){
            if(method_exists($entityModel, 'getTitle')){
                $this->entityInfo->set($this->field->name . '_title', $entityModel->getTitle(), $this->languageCode);
            } else {
                $this->entityInfo->set($this->field->name . '_title', '', $this->languageCode);
            }
        }

        return $this->entityInfo->get($this->field->name, $this->languageCode);
    }
}