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

    function __construct($inputName,
                         $inputFormName,
                         $inputType,
                         $inputChoices,
                         $inputOrder,
                         $inputQuestion,
                         $inputPrivate,
                         $inputRequired)
    {
        $this->setName($inputName);
        $this->setFormName($inputFormName);
    }

    private function setName($inputName)
    {
        if ($this->checkStringLength($inputName, 255)) {
            $this->name = htmlspecialchars($inputName);
        }
    }

    private function checkStringLength($input_string, $maximum_length): \bool
    {
        if (strlen($input_string) < $maximum_length) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $inputFormName String Must be all lowercase using only letters a-z, no spaces.
     */
    private function setFormName($inputFormName)
    {
        if ($this->checkStringLength($inputFormName, 255)) {
            if (preg_match("/^[a-z]/", $inputFormName)) {
                $this->formname = htmlspecialchars($inputFormName);
            }
        }
    }

    /**
     * @param $inputType integer '0 = text, 1 = select',
     * Select "Text" to allow any user input. Choose "Selection" to provide limited options.
     */
    private function setType($inputType)
    {
        if ($inputType == 0) {
            $this->type = 0;
        } elseif ($inputType == 1) {
            $this->type = 1;
        }
    }
}