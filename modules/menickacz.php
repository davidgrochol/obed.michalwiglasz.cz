<?php

class MenickaCz extends LunchMenuSource {

	private $id;

	public function __construct($id, $title, $link, $icon) {
		$this->id = $id;
		$this->title = $title;
		$this->link = $link;
		$this->icon = $icon;

		$this->sourceLink = "https://www.menicka.cz/$this->id.html";
	}

	public function getTodaysMenu($todayDate, $cacheSourceExpires) {

		$cached = $this->downloadHtml($cacheSourceExpires);

		if (!$cached['html']) {
			throw new ScrapingFailedException("No html returned");
		}

		$todayBlock = $cached['html']->find("div.obsah div.menicka", 0);
		if (!$todayBlock) {
			throw new ScrapingFailedException("div.obsah div.menicka was not found");
		}

		$result = new LunchMenuResult($cached['stored']);
		foreach ($todayBlock->find("ul li") as $dish) {
			$nameTag = $dish->find("div.polozka", 0);
			$priceTag = $dish->find("div.cena", 0);
			if (!$nameTag) continue;

			$name = iconv('windows-1250', 'utf-8', trim($nameTag->plaintext));
			$price = ($priceTag) ? iconv('windows-1250', 'utf-8', trim($priceTag->plaintext)) : NULL;

			$result->dishes[] = new Dish($name, $price);
		}

		return $result;
	}
}
