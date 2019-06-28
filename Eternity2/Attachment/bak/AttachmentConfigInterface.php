<?php namespace Eternity2\z;


interface AttachmentConfigInterface {
	static public function attachments_path();
	static public function attachments_url();
	static public function thumbnails_path();
	static public function thumbnails_url();
	static public function thumbnail_secret();
}