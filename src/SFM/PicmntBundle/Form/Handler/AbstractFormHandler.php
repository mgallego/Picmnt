<?php

namespace SFM\PicmntBundle\Form\Handler;

abstract class AbstractFormHandler
{

    public function showFormErrors()
    {
        $messages = [];

        foreach ($this->form->getErrors() as $error) {
            $params = $error->getMessageParameters();
            if (array_key_exists('{{ extra_fields }}', $params)) {
                $formattedParams = explode(', ', str_replace("\"", "", $params['{{ extra_fields }}']));
                $messages[] = "This form should not contain extra fields: " . implode(', ', $formattedParams);
                continue;
            }

            $messages[] = $error->getMessage();
        }

        return implode(', ', $messages);
    }
}
