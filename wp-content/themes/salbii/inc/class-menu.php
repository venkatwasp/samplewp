<?php
/**
 * Custom class that creates WordPress menus programmatically
 * https://gist.github.com/OzzyCzech/4148529
 *
 * @method Menu db_id
 * @method Menu object_id
 * @method Menu object
 * @method Menu parent_id
 * @method Menu position
 * @method Menu type
 * @method Menu title
 * @method Menu url
 * @method Menu description
 * @method Menu attr-title
 * @method Menu target
 * @method Menu classes
 * @method Menu xfn
 * @method Menu status
 */

class LMBNCreateMenu {

	/** @var null */
	public $id = null;

	/** @var null */
	public $menu = null;

	/** @var int */
	public $position = 1;

	/** @var array */
	public $item = null;

	/**
	 * @param $name
	 * @param bool $delete
	 */
	public function __construct($name, $delete = true) {
		if ($delete) wp_delete_nav_menu($name);

		if (is_nav_menu($name)) {
			$this->menu = wp_get_nav_menu_object($name);
			$this->id = (int)$this->menu->term_id;
		} else {
			$this->id = (int)wp_create_nav_menu($name);
			$this->menu = wp_get_nav_menu_object($name);
		}
	}

	/**
	 * @return object
	 */
	public function save() {
		// upravim pole pred save
		$this->item['menu-item-position'] = isset($this->item['menu-item-position']) ? $this->item['menu-item-position'] : $this->position++;
		$this->item['menu-item-status'] = isset($this->item['menu-item-status']) ? $this->item['menu-item-status'] : 'publish';
		$this->item['menu-item-type'] = isset($this->item['menu-item-type']) ? $this->item['menu-item-type'] : 'custom';

		$id = wp_update_nav_menu_item($this->id, 0, (array)$this->item);
		$this->item = array(); // smazu po ulozeni

		return wp_setup_nav_menu_item($id);
	}

	/**
	 * @param string $location
	 */
	public function setLocation($location = 'primary') {
		$locations = get_nav_menu_locations();
		$locations[$location] = $this->menu->term_id;
		set_theme_mod('nav_menu_locations', $locations);
	}

	/**
	 * @return array|WP_Error
	 */
	public static function getAllMenus() {
		return get_terms('nav_menu', array('hide_empty' => true));
	}


	/**
	 * @param $name
	 * @param $value
	 * @return Menu
	 */
	public function __call($name, $value) {
		$this->item['menu-item-' . str_replace('_', '-', $name)] = reset($value);
		return $this;
	}
}