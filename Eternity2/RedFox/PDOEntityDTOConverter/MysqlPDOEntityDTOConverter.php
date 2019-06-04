<?php namespace Eternity2\RedFox\PDOEntityDTOConverter;


use Eternity2\RedFox\Fields\BoolField;
use Eternity2\RedFox\Fields\DateField;
use Eternity2\RedFox\Fields\DateTimeField;
use Eternity2\RedFox\Fields\JsonStringField;
use Eternity2\RedFox\Fields\SetField;

class MysqlPDOEntityDTOConverter extends AbstractPDOEntityDTOConverter {


	protected function toPDO($value, $type) {
		switch ($type) {
			case JsonStringField::class:
				$value = json_encode($value);
				break;
			case DateField::class:
				$value = (new \DateTime($value))->format('Y-m-d');
				break;
			case DateTimeField::class:
				$value = (new \DateTime($value))->format('Y-m-d H:i:s');
				break;
			case BoolField::class:
				$value = (int)$value;
				break;
			case SetField::class:
				$value = join(',', $value);
				break;
		}
		return $value;
	}

	protected function toDTO($value, $type) {
		switch ($type) {
			case JsonStringField::class:
				$value = json_decode($value, true);
				break;
			case DateField::class:
				$value .= ' 00:00:00';
				break;
			case DateTimeField::class:
				$date = new \DateTime($value);
				$date->setTimezone(new \DateTimeZone(date_default_timezone_get()));
				$value = $date->format('c');
				break;
			case BoolField::class:
				$value = (bool)$value;
				break;
			case SetField::class:
				$value = !$value ? [] : explode(',', $value);
				break;
		}
		return $value;
	}
}