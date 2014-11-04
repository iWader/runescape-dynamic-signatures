<?php
	
	/**
	 * Dynamic Runescape Stats signature
	 *
	 * @author		Wader
	 * @copyright	(c) 2012 Wade Urry
	 * @link 		http://www.iwader.co.uk/
	 */
	 
	# Set timezone cause new PHP screams about us not using it
	date_default_timezone_set("Canada/Eastern");
	
	# Suppress all error printing (view httpd logs if debugging)
	ini_set('display_errors', 0);
	
	#Load cache class
	require('cache.class.php');
	
	# Send headers immediately
	header('Content-type: image/png');
	
	class Signature {
	
		# Set background directory
		static private $bg_dir = "backgrounds/";
		
		# Set background template directory
		static private $bg_tpl_dir = "backgrounds_set/";
		
		# Set fonts directory
		static private $font_dir = "fonts/";
		
		# Set cache directory
		static private $cache_dir = "cache/";
		
		# Set signature link
		static private $link = "www.iWader.co.uk";
		
		# Set font file
		static private $fontFile = "./Times_New_Roman.ttf";
		
		# Runescape Display Name [string]
		public $rsn = null;
		
		# Background [int]
		public $bg = null;
		
		# Font colour [int]
		public $fc = null;
		
		# Stores the font colours [resource]
		public $fontColour = null;
		
		# Stores the image [resource]
		public $image = null;
		
		# Skill names [assoc]
		public $skills = array();
		
		# User stats [assoc]
		protected $stats = array();
		
		
		
		
		
		# Construct function
		public function __construct($rsn = "", $bg = 0, $fc = 1) {
			$this->rsn = $rsn;
			$this->bg = (empty($bg) ? 0 : $bg);
			$this->fc = (empty($fc) ? 1 : $fc);
			$this->skills = array("Overall", "Attack", "Defence", "Strength", "Constitution", "Ranged", "Prayer", "Magic", "Cooking", "Woodcutting", "Fletching", "Fishing", "Firemaking", "Crafting", "Smithing", "Mining", "Herblore", "Agility", "Thieving", "Slayer", "Farming", "Runecrafting", "Hunter", "Construction", "Summoning", "Dungeoneering");
			
			$this->loadStats();
			$this->createImage();
		}
		
		# Destruct function
		public function __destruct() {
			ImagePNG($this->image);
			ImageDestroy($this->image);
		}
		
		# Retrieves the users stats and stores them in $this->stats
		public function loadStats() {
			# Check $this->rsn isnt empty
			if (empty($this->rsn)) {
				$this->stats = false;
				return;
			}
			
			# Create cache for faster loading and use less bandwidth
			$cache = new FileCache(array("key" => "sig-stats-{$this->rsn}"), $this::$cache_dir);
			
			if (!$cache->getCache()) {
				$url = "http://hiscore.runescape.com/index_lite.ws?player=" . urlencode($this->rsn);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$file = curl_exec($ch);
				curl_close($ch);
				$cache->setCache($file, '+15 minutes', true);
			} else {
				$file = $cache->getCache();
			}
			
			if (!$file) {
				$this->stats = false;
				return;
			}
			
			if (preg_match("~<(/)?html>~", $file)) {
				$this->stats = false;
				return;
			}
			
			$file = explode("\n", $file);
			for ($i = 0; $i < count($this->skills); $i++) {
				$stat = explode(",", $file[$i]);
				
				$this->stats[$this->skills[$i]]['rank'] = $this::checkRank($stat[0]);
				$this->stats[$this->skills[$i]]['level'] = $this::checkStat($stat[1]);
				$this->stats[$this->skills[$i]]['exp'] = $this::checkStat($stat[2]);
			}
		}
		
		public function createImage() {
			# Check user exists
			if (empty($this->stats)) {
				$this->image = ImageCreateFromPng($this::$bg_dir . $this->bg . ".png");
				$text = "User Error";
				imageTTFtext($this->image, 30, 0, 75, 80, $this->fontColour, $this::$fontFile, $text);
				exit();
			}
			# Create image from pre-set templates
			$this->image = ImageCreateFromPng($this::$bg_tpl_dir . $this->bg . ".png");
			
			# Initialize font resource
			$this->initFontSettings();
			
			# Create image from template
			$this->image = ImageCreateFromPng($this::$bg_tpl_dir . $this->bg . ".png");
			
			# Attach skill levels to image
			ImageString($this->image, 4, 29, 15, $this->stats['Attack']['level'], $this->fontColour);
			ImageString($this->image, 4, 29, 40, $this->stats['Strength']['level'], $this->fontColour);
			ImageString($this->image, 4, 29, 65, $this->stats['Defence']['level'], $this->fontColour);
			ImageString($this->image, 4, 29, 90, $this->stats['Constitution']['level'], $this->fontColour);
			ImageString($this->image, 4, 29, 115, $this->stats['Ranged']['level'], $this->fontColour);
			ImageString($this->image, 4, 78, 15, $this->stats['Prayer']['level'], $this->fontColour);
			ImageString($this->image, 4, 78, 40, $this->stats['Magic']['level'], $this->fontColour);
			ImageString($this->image, 4, 78, 65, $this->stats['Cooking']['level'], $this->fontColour);
			ImageString($this->image, 4, 78, 90, $this->stats['Woodcutting']['level'], $this->fontColour);
			ImageString($this->image, 4, 78, 115, $this->stats['Fletching']['level'], $this->fontColour);
			ImageString($this->image, 4, 128, 15, $this->stats['Fishing']['level'], $this->fontColour);
			ImageString($this->image, 4, 128, 40, $this->stats['Firemaking']['level'], $this->fontColour);
			ImageString($this->image, 4, 128, 65, $this->stats['Crafting']['level'], $this->fontColour);
			ImageString($this->image, 4, 128, 90, $this->stats['Smithing']['level'], $this->fontColour);
			ImageString($this->image, 4, 128, 115, $this->stats['Mining']['level'], $this->fontColour);
			ImageString($this->image, 4, 178, 15, $this->stats['Herblore']['level'], $this->fontColour);
			ImageString($this->image, 4, 178, 40, $this->stats['Agility']['level'], $this->fontColour);
			ImageString($this->image, 4, 178, 64, $this->stats['Thieving']['level'], $this->fontColour);
			ImageString($this->image, 4, 178, 90, $this->stats['Slayer']['level'], $this->fontColour);
			ImageString($this->image, 4, 178, 115, $this->stats['Farming']['level'], $this->fontColour);
			ImageString($this->image, 4, 228, 15, $this->stats['Runecrafting']['level'], $this->fontColour);
			ImageString($this->image, 4, 228, 40, $this->stats['Construction']['level'], $this->fontColour);
			ImageString($this->image, 4, 275, 15, $this->stats['Hunter']['level'], $this->fontColour);
			ImageString($this->image, 4, 275, 40, $this->stats['Summoning']['level'], $this->fontColour);
			ImageString($this->image, 4, 320, 15, $this->stats['Dungeoneering']['level'], $this->fontColour);
			
			# Attatch user stats to image
			ImageString($this->image, 30, 215, 65, $this->rsn, $this->fontColour);
			ImageString($this->image, 3, 215, 80, "Overall: " . number_format($this::checkRank($this->stats['Overall']['level'])), $this->fontColour);
			ImageString($this->image, 3, 215, 95, "Rank: " . number_format($this::checkRank($this->stats['Overall']['rank'])), $this->fontColour);
			ImageString($this->image, 3, 215, 110, "XP: " . number_format($this::checkRank($this->stats['Overall']['exp'])), $this->fontColour);
			
			# Attach watermark
			ImageString($this->image, 2, 228, 132, $this::$link, $this->fontColour);
		}
		
		public function initFontSettings() {			
			# Load font colour
			switch($this->fc) {
				case 1:
					# Black
					$colour = ImageColorAllocate($this->image, 0, 0, 0);
					break;
				case 2:
					# Red
					$colour = ImageColorAllocate($this->image, 255, 0, 0);
					break;
				case 3:
					# Green
					$colour = ImageColorAllocate($this->image, 0, 255, 0);
					break;
				case 4:
					# Blue
					$colour = ImageColorAllocate($this->image, 0, 0, 255);
					break;
				case 5:
					# Yellow
					$colour = ImageColorAllocate($this->image, 255, 255, 0);
					break;
				case 6:
					# Cyan
					$colour = ImageColorAllocate($this->image, 0, 255, 255);
					break;
				case 7:
					# Magenta
					$colour = ImageColorAllocate($this->image, 255, 0, 255);
					break;
				case 8:
					# Grey
					$colour = ImageColorAllocate($this->image, 192, 192, 192);
					break;
				case 9:
					# White
					$colour = ImageColorAllocate($this->image, 255, 255, 255);
					break;
				default:
					# Black
					$colour = ImageColorAllocate($this->image, 0, 0, 0);
			}
			
			$this->fontColour = $colour;
		}
		
		static public function checkStat($stat) {
			return ($stat <= 0 ? "--" : $stat);
		}
		
		static public function checkRank($rank) {
			return ($rank <= 0 ? "N/A" : $rank);
		}
		
	}
	
	$sig = new Signature(@$_GET['rsn'], @$_GET['bg'], @$_GET['c']);
	
?>