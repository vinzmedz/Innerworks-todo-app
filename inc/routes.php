<?php
    function get_rules()
    {
        $rules['create']              = "/v1/payments/?"; //(cmd={function name}, opt={other fields})
        $rules['admission']             = "/v1/admission/?"; //(cmd={function name}, sch={school type}, opt={other fields})
  
        return $rules;
    }

?>