<?php namespace Eternity2\RedFox\Fields;
use Eternity2\RedFox\Field;
/**
 * @datatype \DateTime
 */
class DateField extends Field {

	public function importFromDTO($value) {
		$date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
		if(!$date) $date = \DateTime::createFromFormat('Y-m-d', $value);
		if(!$date) $date = null;
		return $date;
	}

	/**
	 * @param \DateTime $value
	 * @return string
	 */
	public function exportToDTO($value) { return is_null($value) ? null : $value->format('Y-m-d'); }

	public function set($value) {
		if (is_string($value)) $value = $this->importFromDTO($value);
		if (get_class($value) !== 'DateTime' && !is_null($value)) throw new \Exception('Date Field type set error');
		return $value;
	}

}