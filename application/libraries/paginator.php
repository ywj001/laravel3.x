<?php 

class Paginator extends Laravel\Paginator{
 
	
	public function links($adjacent = 3)
	{
		if ($this->last <= 1) return '';

		// The hard-coded seven is to account for all of the constant elements in a
		// sliding range, such as the current page, the two ellipses, and the two
		// beginning and ending pages.
		//
		// If there are not enough pages to make the creation of a slider possible
		// based on the adjacent pages, we will simply display all of the pages.
		// Otherwise, we will create a "truncating" sliding window.
		if ($this->last < 7 + ($adjacent * 2))
		{
			$links = $this->range(1, $this->last);
		}
		else
		{
			$links = $this->slider($adjacent);
		}echo $this->last;
		if($this->page==$this->last) 
			$content = '<ul>' . $this->previous() . $links  . '</ul>';
		if($this->page==1) 
			$content = '<ul>' .  $links . $this->next() . '</ul>';
		else 
			$content = '<ul>' . $this->previous() . $links . $this->next() . '</ul>';
		return '<div class="pagination">'.$content.'</div>';
	}
}