<?php
	class XmlHelper {
		public static function xmlToArray($xml) {
			$doc = new DOMDocument();
			$doc->loadXML($xml);
			return self::nodeToArray($doc);
		}

		public static function nodeToArray($node) {
			if ($node->nodeType == XML_DOCUMENT_NODE)
				$node = $node->documentElement;

			$len = $node->childNodes->length;
			if ($len == 0)
				return null;

			$result = null;		
			if (($len == 1) && ($node->firstChild->nodeType == XML_TEXT_NODE))
				return $node->firstChild->nodeValue;
			else
			if ($node->attributes->getNamedItem("collection")) {
				$result = array();
				for ($i = 0; $i < $len; $i++) {
					$result[$i] = self::nodeToArray($node->childNodes->item($i));
				}
				
			} else {
				$result = array();
				for ($i = 0; $i < $len; $i++) {
					$child = $node->childNodes->item($i);
					$result[strtolower($child->nodeName)] = self::nodeToArray($child);
				}
			}
			return $result;
		}

		public static function getChildByName($node, $childName) {
			for ($i = 0; $i < $node->childNodes->length; $i++) {
				$child = $node->childNodes->item($i);
				$name = $child->nodeName;
				if ($name && (strtolower($name) == $childName))
					return $child;
			}
			return null;
		}
	}
?>