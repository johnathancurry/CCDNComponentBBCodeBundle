<?php

/*
 * This file is part of the CCDNComponent BBCodeBundle
 *
 * (c) CCDN (c) CodeConsortium <http://www.codeconsortium.com/> 
 * 
 * Available on github <http://www.github.com/codeconsortium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CCDNComponent\BBCodeBundle\Component\Node\Lexeme\Tag\Block;

use CCDNComponent\BBCodeBundle\Component\Node\Lexeme\LexemeBase;
use CCDNComponent\BBCodeBundle\Component\Node\Lexeme\LexemeInterface;

/**
 *
 * @category CCDNComponent
 * @package  BBCodeBundle
 *
 * @author   Reece Fowell <reece@codeconsortium.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 2.0
 * @link     https://github.com/codeconsortium/CCDNComponentBBCodeBundle
 *
 */
class Code extends LexemeBase implements LexemeInterface
{
	/**
	 * 
	 * @var string $canonicalLexemeName
	 */
	protected static $canonicalLexemeName = 'Code';
	
	/**
	 * 
	 * @var string $canonicalTokenName
	 */
	protected static $canonicalTokenName = 'CODE';
	
	/**
	 * 
	 * @var string $canonicalGroupName
	 */
	protected static $canonicalGroupName = 'Block';	
	
	/**
	 * 
	 * @var bool $isParameterAccepted
	 */
	protected static $parametersAcceptedOnToken = array(0 => array(0 => 'lang'));
	
	/**
	 * 
	 * @var bool $isParameterRequired
	 */
	protected static $parametersRequiredOnToken = array();
	
	protected static $isStandalone = false;	
	
	/**
	 * 
	 * @var array $lexingPattern
	 */
//	protected static $lexingPattern = array('/^\[CODE(?:\=[\P{C}\p{Cc}]*)?\]$/', '/^\[\/CODE\]$/');
	protected static $lexingPattern = array('/^\[CODE(?:\=(.*?)*)?\]$/', '/^\[\/CODE\]$/');

	protected static $lexingHtml = array('<div class="bbtag_code">{{ param[0] }}<pre><code class="cpp">', '</code></pre></div>');
	
	/**
	 * 
	 * @var array $allowedNestable
	 */
	protected static $allowedNestable = array();
	protected static $lexemeTable = array();
	
	
	public function extractParameters()
	{
		// 1. Extract Parameter.
		$symbols = '\d\w _,.?!@#$%&*()^=:\+\-\'\/';
		$regex = '/(\=\"(['.$symbols.']*)\"{0,500})/';

		$param = preg_split($regex, $this->lexingMatch, null, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		
		// 2. Check Parameter meets some criteria.
		if (is_array($param) && count($param) > 2) {
			// 3. Store Parameter.
			$this->parameters[0] = $param[2];
			
			return true;
		}
		
		return false;
	}

	/**
	 * 
	 * @access public
	 */
	public function cascadeRender()
	{	
		if ($this->isValid(true)) {
			if ($this->tokenIndex == 0) {
				if (array_key_exists(0, $this->parameters)) {
					$tab = '<ul class="nav nav-tabs"><li class="active"><a href="#"><bdi>' . htmlentities($this->parameters[0], ENT_QUOTES) . '</bdi></a></li></ul>';
					
					return str_replace('{{ param[0] }}', $tab, static::$lexingHtml[$this->tokenIndex]);
				}
			
				return str_replace('{{ param[0] }}', '', static::$lexingHtml[$this->tokenIndex]);
			} else {
				return str_replace('{{ param[0] }}', '', static::$lexingHtml[$this->tokenIndex]);
			}			
		}
	
		return $this->renderErrors();
	}

	/**
	 *
	 * @access public
	 * @return array
	 */
	public static function subNodeGroupWhiteList()
	{
		return array(
		
		);
	}
	
	/**
	 *
	 * @access public
	 * @return array
	 */
	public static function subNodeGroupBlackList()
	{
		return array(
			'*'
		);
	}
	
	/**
	 *
	 * @access public
	 * @return array
	 */
	public static function subNodeWhiteList()
	{
		return array(
		
		);
	}
	
	/**
	 *
	 * @access public
	 * @return array
	 */
	public static function subNodeBlackList()
	{
		return array(
			'*'
		);
	}
}