<?php

return [
    'test' => [
        'test.name' => ['required', 'string'],
        'test.test_type_id' => ['required', 'integer', 'exists:test_types,id'],
        'test.grade_id' => ['nullable', 'integer', 'exists:grades,id'],
        'test.max_attempts' => ['required', 'integer', 'min:1'],
        'test.open_at' => ['nullable', 'date_format:Y-m-d H:i:s', 'after_or_equal:now'],
        'test.close_at' => ['required', 'date_format:Y-m-d H:i:s', 'after:test.open_at', 'after:now'],
    ],
    'config' => [
        'mcq' => [
            'config.num_questions' => ['required', 'integer', 'min:1'],
            'config.dur_per' => ['required', 'integer', 'min:1'],
            'config.dur_extra' => ['required', 'integer', 'min:0'],
            //----
            'config.nplus' => ['required', 'integer', 'min:0'],
            'config.nminus' => ['required', 'integer', 'min:0'],
            'config.nmultiply' => ['required', 'integer', 'min:0'],
            'config.ndivition' => ['required', 'integer', 'min:0'],
            'config.shuffle_digits_order' => ['required', 'boolean'],

            'config.operation_order' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $slices = explode(',', $value);
                    $counts = array_count_values($slices);

                    $expectedOperationsCount =  $this->config->nplus + $this->config->nminus + $this->config->nmultiply + $this->config->ndivition;

                    if ($expectedOperationsCount < 2) {  // because minimum two operations required
                        return $fail('Please set the operation counts first. It must be larger than 1.');
                    }

                    $nplus = 0;
                    $nminus = 0;
                    $nmultiply = 0;
                    $ndivitions = 0;

                    if (isset($counts['+'])) $nplus = $counts['+'];
                    if (isset($counts['-'])) $nminus = $counts['-'];
                    if (isset($counts['*'])) $nmultiply = $counts['*'];
                    if (isset($counts['/'])) $ndivitions = $counts['/'];

                    $valid = true;

                    if ($nplus != $this->config->nplus) $valid = false;
                    if ($nminus != $this->config->nminus) $valid = false;
                    if ($nmultiply != $this->config->nmultiply) $valid = false;
                    if ($ndivitions != $this->config->ndivition) $valid = false;

                    if (!$valid) {                 
                        $describe = '<ul>';

                        if ($this->config->nplus > 0)  
                            $describe .= '<li>'.$this->config->nplus .' of Plus[+]</li>';
                        if ($this->config->nminus > 0) 
                            $describe .= '<li>'.$this->config->nminus .' of Minus[-]</li>';
                        if ($this->config->nmultiply > 0) 
                            $describe .= '<li>'.$this->config->nmultiply .' of Multiply[*]</li>';
                        if ($this->config->ndivition > 0) 
                            $describe .= '<li>'.$this->config->ndivition .' of Divitions[/]</li>';

                        $describe .= '</ul>';

                        $fail($describe);
                    } elseif (count($slices) != $expectedOperationsCount) {
                        $fail('Invalid order. double check the operation counts.');
                    }
                }
            ],     
            
            'config.digits_order' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $slices = explode(',', $value);
                    
                    $expectedCount =  $this->config->nplus + $this->config->nminus + $this->config->multiply + $this->config->ndivition + 1;

                    if ($expectedCount < 3) {  // because minimum two operations required
                        return $fail('Please set the operations count first. It must be larger than 1.');
                    }

                    $nonZeroIntegers = array_filter($slices, function ($item) {
                        $n = intval($item);
                        return $n > 0 && strlen(strval($n)) == strlen($item);
                    });

                    if (count($nonZeroIntegers) != count($slices)) {
                        return $fail('Invalid order. must not be include non-zero values & unnecessary commas or spaces');
                    }

                    if (count($slices) != $expectedCount) {
                        $fail('Size of order must be equal to '.$expectedCount.'. Because total operations count is '.($expectedCount - 1));
                    }
                }
            ],
        ]
    ]
];