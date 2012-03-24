<?php
	class PageNavigator {
		public static function draw($pageCount, $pageNumber, $maxPages, $params, $page) {
			$from = (int) ceil($pageNumber - ($maxPages - 1) / 2);
			$to = (int) floor($pageNumber + $maxPages / 2);
			if ($from <= 0)
				$to += 1 - $from;
			else
			if ($to > $pageCount)
				$from -= $to - $pageCount;
			$from = max($from, 1);
  			$to = min($to, $pageCount);
  			echo("<table bgcolor=\"#0b0b2f\" width=\"100%\"><tr><td>Page: ");
  			if ($from > 1)
  				printf("<a href=\"%s?page=1%s\">first</a> ... ", $page, $params);
  			for ($i = $from; $i <= $to; $i++) {
				if ($i != $from)
					echo(" | ");
				if ($i == $pageNumber)
					echo("<font color=\"#66CCFF\"><b>" . $i . "</b></font>");
				else
					printf("<a href=\"%s?page=%d%s\">%2\$d</a>", $page, $i, $params);
			}
			if ($to < $pageCount)
  				printf(" ... <a href=\"%s?page=%d%s\" title=\"page %2\$d\">last</a>", $page, $pageCount, $params);
			echo("</td></tr></table>");
		}
	}
?>