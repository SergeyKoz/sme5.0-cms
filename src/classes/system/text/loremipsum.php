<?php
/**
 * LoremIpsum generator
 *
 * (С) 2008 Activemedia LLC
 * @version    $Id: loremipsum.php,v 1.1 2010/11/08 13:03:06 skozin Exp $
 * @author     Alexander A. Degtiar <adegtiar@activemedia.ua>
 *
*/

class LoremIpsum
{
    var $words = array();

    function LoremIpsum()
    {
        $this->words = explode(' ', 'lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum');
    }

    function makeWords($count = 1, $delimiter = ' ')
    {
        $result = array();
        for($i=0; $i<$count; $i++) {
            $result[] = $this->words[rand(0, (count($this->words)-1))];
        }
        return implode($delimiter, $result);
    }

    function makeParagraph($count, $asString = null)
    {
        $result = '';
        for($p=0;$p<$count;$p++) {
            $sentencesCount = rand(5, 8);
            $text = '';
            for($s=0;$s<$sentencesCount;$s++) {
                $text .= $this->makeSentence(10, 20, true) . ' ';
            }
            $result[] = $text;
        }
        return (null === $asString) ? $result : implode($asString, $result);
    }

    /**
    * @param integer $maxWords maximum number of words for this sentence
    * @param integer $minWords minimum number of words for this sentence
    * @param boolean $punctuation if false it will not append random commas and ending period
    * @return string greeked sentence
    */
    function makeSentence($minWords = 5, $maxWords = 10, $punctuation = true)
    {
        $string = '';
        $numWords = rand($minWords, $maxWords);
        for($w=0;$w<$numWords;$w++) {
            $word = $this->words[rand(0, (count($this->words)-1))];
            // if first word capitalize letter...
            if ($w == 0) {
                $word = ucwords($word);
            }
            $string .= $word;
            // if not the last word,
            if ($w != ($numWords-1)) {
                // 5% chance of a comma...
                if ($punctuation && rand(0,99) < 5) {
                    $string .= ', ';
                } else {
                    $string .= ' ';
                }
            }
        }
        if ($punctuation) {
            $string .= '.';
        }
        return $string;
    }
}
