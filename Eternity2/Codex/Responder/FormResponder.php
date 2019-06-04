<?php namespace Eternity2\Codex\Responder;


use Eternity2\Codex\Validation\ValidationResult;
use Eternity2\Codex\AdminDescriptor;
use Eternity2\WebApplication\Response\Responder\JsonResponder;
use Eternity2\RedFox\Entity;

class FormResponder extends JsonResponder {

	/** @var AdminDescriptor */
	protected $adminDescriptor;
	/** @var FormResponse */
	protected $response;


	protected function respond() {

		$adminDescriptorClass = $this->getArgumentsBag()->get('admin');
		$this->adminDescriptor = new $adminDescriptorClass();
		$this->response = new FormResponse();


		$method = $this->getArgumentsBag()->get('method');
		$id = $this->getPathBag()->get('id');

		switch ($method) {
			case 'save':
				$this->save($id, $this->getJsonParamBag()->get('data'));
				break;
			case 'delete':
				$this->delete($id);
				break;
			case 'getForm':
				$this->getForm($id);
				break;
		}

		return $this->response;
	}

	protected function save($id, $data) {

		$formDataManager = $this->adminDescriptor->getFormDataManager();

		try {
			/** @var ValidationResult[] $result */
			$result = $formDataManager->save($id, $data);
		} catch (\Throwable $exception) {
			$this->getResponse()->setStatusCode(422);
			$this->response->addMessage('Hiba történt a mentés közben. Ellenőrizd az adatokat!');
			return;
		}

		if ($result[ 'validationResult' ]->getStatus() === false) {
			$this->getResponse()->setStatusCode(422);
			foreach ($result[ 'validationResult' ]->getMessages() as $message) {
				$this->response->addMessage($message[ 'label' ] . ' ' . $message[ 'message' ] . ' (' . $message[ 'subject' ] . ')');
			}
		}
		$this->response->set('id', $result[ 'id' ]);
	}

	protected function delete($id) {
		/** @var Entity $entityClass */
		$entityClass = $this->adminDescriptor->getEntityClass();
		/** @var Entity $item */
		$item = $entityClass::repository()->pick($id);
		try {
			if(!$item->delete()){
				$this->getResponse()->setStatusCode(422);
				$this->response->addMessage('Nem sikerült törölni!');
			}
		} catch (\Exception $exception) {
			$this->getResponse()->setStatusCode(422);
			$this->response->addMessage('Hiba történt a törlés közben. Ellenőrizd az adatokat!');
		}
	}

	protected function getForm($id) {
		$formHandler = $this->adminDescriptor->getFormHandler();
		$formDataManager = $this->adminDescriptor->getFormDataManager();
		$this->response->set('data', $formDataManager->get($id));
		$this->response->set('form', $formHandler->get($id));
	}

}

