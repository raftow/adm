<?php
$lookup = [];
$lookup[5]=['ar'=> 'الكفاءة المتوسطة', 'en'=> 'Intermediate proficiency',
                'attributes' =>    [
                    ['attribute' => 'attribute_24', 'operator' => '>='],
                    // ['attribute' => 'attribute_99', 'operator' => '='],
                ]

            ];
$lookup[10]=['ar'=> 'الصف الأول الثانوي', 'en'=> 'first year of secondary school'];
$lookup[15]=['ar'=> 'الصف الثاني الثانوي', 'en'=> 'second year of secondary school'];
$lookup[20]=['ar'=> 'المستوى الثانوي', 'en'=> 'Secondary', 
                                        'attributes' =>    [
                                                ['attribute' => 'attribute_7', 'operator' => '='],
                                            ]
            ];
$lookup[30]=['ar'=> 'درجة جامعية متوسطة', 'en'=> 'Intermediate university certificate', 
                                            'attributes' =>    [
                                                    ['attribute' => 'attribute_4', 'operator' => '>='],
                                                ]
];
$lookup[40]=['ar'=> 'بكالوريوس', 'en'=> "Bachelor's"];
$lookup[45]=['ar'=> 'دبلوم عالي', 'en'=> 'Higher Diploma'];
