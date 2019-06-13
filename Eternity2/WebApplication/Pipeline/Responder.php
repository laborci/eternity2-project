<?php namespace Eternity2\WebApplication\Pipeline;

abstract class Responder extends Segment {
	abstract protected function respond();
}