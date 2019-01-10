<?php
declare(strict_types=1);
namespace model;
//
//CREATE TABLE `optionalfields` (
//`optionname` varchar(255) NOT NULL,
//  `optionformname` varchar(255) NOT NULL COMMENT 'no spaces, a-z only',
//  `optiontype` int(11) NOT NULL COMMENT '0 = text, 1 = select',
//  `optionchoices` varchar(700) NOT NULL COMMENT '";" delimited',
//  `optionorder` int(11) NOT NULL,
//  `optionquestion` varchar(255) NOT NULL,
//  `optionprivate` tinyint(1) NOT NULL DEFAULT '0',
//  `optionrequired` tinyint(1) NOT NULL DEFAULT '0',
//  PRIMARY KEY (`optionname`),
//  UNIQUE KEY `optionformname` (`optionformname`)
//) ENGINE=InnoDB DEFAULT CHARSET=latin1;
class OptionalField
{
    private $name;
    private $formname;
    private $type;
    private $choices;
    private $order;
    private $question;
    private $private;
    private $required;

    function __construct($input_name,
                         $input_formname,
                         $input_type,
                         $input_choices,
                         $input_order,
                         $input_question,
                         $input_private,
                         $input_required)
    {
        $this->set_name($input_name);
        $this->set_formname($input_formname);
    }

    private function set_name($input_name)
    {
        if ($this->check_string_length($input_name, 255)) {
            $this->name = htmlspecialchars($input_name);
        }
    }

    private function check_string_length($input_string, $maximum_length): \bool
    {
        if (strlen($input_string) < $maximum_length) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $input_formname String Must be all lowercase using only letters a-z, no spaces.
     */
    private function set_formname($input_formname)
    {
        if ($this->check_string_length($input_formname, 255)) {
            if (preg_match("/^[a-z]/", $input_formname)) {
                $this->formname = htmlspecialchars($input_formname);
            }
        }
    }

    /**
     * @param $input_type integer '0 = text, 1 = select',
     * Select "Text" to allow any user input. Choose "Selection" to provide limited options.
     */
    private function set_type($input_type)
    {
        if ($input_type == 0) {
            $this->type = 0;
        } elseif ($input_type == 1) {
            $this->type = 1;
        }
    }
}