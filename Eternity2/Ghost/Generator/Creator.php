<?php namespace Eternity2\Ghost\Generator;

use CaseHelper\CaseHelperFactory;
use Eternity2\Ghost\Config;
use Eternity2\Ghost\Field;
use Eternity2\Ghost\Model;
use Eternity2\Ghost\Relation;
use Eternity2\System\AnnotationReader\AnnotationReader;
use Eternity2\System\ServiceManager\Service;
use Ghost\User;
use Minime\Annotations\Reader;

use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\DBAccess\PDOConnection\AbstractPDOConnection;

use RedAnt\Console\Helper\SelectHelper;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Creator {

	use Service;

	/** @var \Eternity2\Ghost\Config */
	protected $config;
	/** @var SymfonyStyle */
	protected $style;
	/** @var InputInterface */
	protected $input;
	/** @var OutputInterface */
	protected $output;
	/** @var Application */
	protected $application;

	public function __construct(Config $config) {
		$this->config = $config;
	}

	public function execute(InputInterface $input, OutputInterface $output, Application $application) {

		$this->application = $application;
		$this->input = $input;
		$this->output = $output;

		$this->style = new SymfonyStyle($input, $output);

		$this->style->title('GHOST CREATOR');

		$name = $input->getArgument('name');
		$table = $input->getArgument('table');
		$database = $input->getArgument('database');

		if ($name) {
			$this->createMode($name, $table, $database);
		} else {
			$this->updateAll();
		}

	}

	protected function createMode($name, $table, $database) {
		$name = ucfirst($name);
		$table = is_null($table) ? CaseHelperFactory::make(CaseHelperFactory::INPUT_TYPE_CAMEL_CASE)->toSnakeCase($name) : $table;
		$database = is_null($database) ? $this->config->defaultDatabase() : $database;

		$this->style->section($name . ' Ghost');

		$filesExists = 0;

		$this->style->writeln('Check existing files');

		$file = "{$this->config->ghostPath()}/{$name}.php";
		$this->style->write(" - {$file}");
		if (is_file($file)) {
			$filesExists = 1;
			$this->style->writeln(' - [EXISTS]');
		} else $this->style->writeln(' - [NOT FOUND]');

		$file = "{$this->config->ghostPath()}/Helper/Ghost{$name}.php";
		$this->style->write(" - {$file}");
		if (is_file($file)) {
			$filesExists = 1;
			$this->style->writeln(' - [EXISTS]');
		} else $this->style->writeln(' - [NOT FOUND]');
		$this->style->writeln("\n");

		$action = 'create';
		if ($filesExists === 1) {
			$action = $this->menu("Files for ({$name}) Ghost are exists", [
				'update' => "Update",
				'create' => "Create {$name} as a new Ghost (delete previous implementation)",
				'cancel' => "Cancel",
			], "update");
		} else {
			$this->style->writeln("");
		}

		if ($action === 'create') {
			$this->purge($name);
			$this->create($name, $table, $database);
		} else if ($action === 'update') {
			$this->update($name, $table, $database);
		}
		$this->style->success('done');
	}

	protected function updateAll() {
		$cwd = getcwd();
		chdir($this->config->ghostPath());
		$files = glob('*.php');
		chdir($cwd);
		foreach($files as $file){
			$name = substr($file, 0, -4);
			$ghostClass = $this->config->ghostNamespace().'\\'.$name;
			/** @var Model $model */
			$model = $ghostClass::$model;
			$this->style->section($name . ' Ghost');
			$this->update($name, $model->table, $model->connectionName);
		}
	}

	protected function purge($name) {
		$this->style->writeln("Remove existing files");
		$file = "{$this->config->ghostPath()}/Helper/Ghost{$name}.php";
		if (file_exists($file)) {
			$this->style->write("- {$file}");
			unlink($file);
			$this->style->writeln(' - [OK]');

		}
		$file = "{$this->config->ghostPath()}/{$name}.php";
		if (file_exists($file)) {
			$this->style->write("- {$file}");
			unlink($file);
			$this->style->writeln(' - [OK]');
		}
		$this->style->writeln("");
	}

	protected function create($name, $table, $database) {
		$this->generateGhost($name, $table, $database);
		$this->generateGhostHelperFromDatabase($name, $table, $database);
		$this->updateGhostHelper($name);
	}

	protected function update($name, $table, $database){
		$this->generateGhostHelperFromDatabase($name, $table, $database);
		$this->updateGhostHelper($name);
	}

	protected function updateGhostHelper($name){
		$file = "{$this->config->ghostPath()}/Helper/Ghost{$name}.php";
		$this->style->writeln("Update Helper");

		$this->style->write("- Open Ghost ({$name}) model");
		$ghostClass = $this->config->ghostNamespace().'\\'.$name;
		$this->style->writeln(" - [OK]");
		/** @var Model $model */
		$model = $ghostClass::$model;

		$annotations = [];
		$properties = [];
		$getterSetter = [];

		foreach ($model->fields as $field){
			$properties[] = "\t".($field->protected ? 'protected' : 'public')." \${$field->name};";
			if($field->protected){

				if($field->setter !== false && $field->getter !== false){
					$annotations[] = " * @property $".$field->name;
				}elseif ($field->getter !== false){
					$annotations[] = " * @property-read $".$field->name;
				}elseif ($field->setter !== false){
					$annotations[] = " * @property-write $".$field->name;
				}
				if(is_string($field->getter)){
					$getterSetter[] = "\t".'abstract protected function '.$field->getter.'();';
				}
				if(is_string($field->setter)){
					$getterSetter[] = "\t".'abstract protected function '.$field->setter.'($value);';
				}
			}
		}

		foreach ($model->getAttachmentStorage()->getCategories() as $category){
			$annotations[] = ' * @property-read AttachmentCategoryManager $'.$category->getName();
		}

		foreach ($model->relations as $relation){
			if($relation->type === Relation::TYPE_BELONGSTO){
				$annotations[] = ' * @property-read \\'.$relation->descriptor['ghost'].' $'.$relation->name;
			}elseif ($relation->type === Relation::TYPE_HASMANY){
				$annotations[] = ' * @property-read \\'.$relation->descriptor['ghost'].'[] $'.$relation->name;
				$annotations[] = ' * @method \\'.$relation->descriptor['ghost'].'[] '.$relation->name.'($order = null, $limit = null, $offset = null)';
			}
		}

		$template = file_get_contents($file);
		$template = str_replace('/*ghost-generator-properties*/', join("\n", $properties), $template);
		$template = str_replace(' * ghost-generator-annotations', join("\n", $annotations), $template);
		$template = str_replace('/*ghost-generator-getters-setters*/', join("\n", $getterSetter), $template);

		$this->style->write("- {$file}");
		file_put_contents($file, $template);
		$this->style->writeln(" - [OK]\n");
	}

	protected function generateGhost($name, $table, $database) {
		$this->style->writeln("Generate Ghost");
		$file = "{$this->config->ghostPath()}/{$name}.php";
		$this->style->write("- {$file}");

		if (file_exists($file)) {
			$this->style->writeln(" - [ALREADY EXISTS]\n");
		} else {
			$template =
				'<?php namespace {{namespace}};

class {{name}} extends Helper\Ghost{{name}} {
}

{{name}}::init();';
			$template = str_replace('{{namespace}}', $this->config->ghostNamespace(), $template);
			$template = str_replace('{{name}}', $name, $template);
			$template = str_replace('{{table}}', $table, $template);
			file_put_contents($file, $template);
			$this->style->writeln(" - [OK]\n");

		}
	}

	protected function generateGhostHelperFromDatabase($name, $table, $database) {

		$file = "{$this->config->ghostPath()}/Helper/Ghost{$name}.php";


		$this->style->writeln("Connecting to database");
		$this->style->write("- ${database}");
		/** @var AbstractPDOConnection $connection */
		$connection = ServiceContainer::get($database);
		$smartAccess = $connection->createSmartAccess();
		$this->style->writeln(" - [OK]\n");


		$this->style->writeln("Fetching table information");
		$this->style->write("- ${table}");
		$fields = $smartAccess->getFieldData($table);
		$this->style->writeln(" - [OK]\n");

		$constants = [];
		$addFields = [];
		foreach ($fields as $field) {
			$addFields[] = '		$model->addField("' . $field['Field'] . '", ' . $this->fieldType($field, $field['Field']) . ');';
			if(strpos($field['Type'], 'set') === 0 || strpos($field['Type'], 'enum') === 0){
				$values = $smartAccess->getEnumValues($table, $field['Field']);
				foreach ($values as $value){
					$constants[] = "\t".'const '.strtoupper($field['Field']).'_'.strtoupper($value).' = "'.$value.'";';
				}
			}
		}
		$addFields[] = '		$model->protectField("id");';



		$template =
			'<?php namespace {{namespace}}\Helper;

use Eternity2\Attachment\AttachmentCategoryManager;
use Eternity2\DBAccess\Filter\Filter;
use Eternity2\Ghost\Field;
use Eternity2\Ghost\Ghost;
use Eternity2\Ghost\Model;

/**
 * @method static Ghost{{name}}Finder search(Filter $filter = null)
 * ghost-generator-annotations
 */
abstract class Ghost{{name}} extends Ghost{
	
	/** @var Model */
	public static $model;
	public static $table = "{{table}}";
	public static $connectionName = "{{connectionName}}";
	
{{constants}}

/*ghost-generator-properties*/

/*ghost-generator-getters-setters*/

	final static protected function createModel(): Model{
		$model = new Model(static::$connectionName, static::$table, get_called_class());
{{add-fields}}
		return $model;
	}
}

/**
 * Nobody uses this class, it exists only to help the code completion
 * @method \{{namespace}}\{{name}}[] collect($limit = null, $offset = null)
 * @method \{{namespace}}\{{name}}[] collectPage($pageSize, $page, &$count = 0)
 * @method \{{namespace}}\{{name}} pick()
 */
abstract class Ghost{{name}}Finder extends \Eternity2\DBAccess\Finder\AbstractFinder {}';

		$template = str_replace('{{name}}', $name, $template);
		$template = str_replace('{{table}}', $table, $template);
		$template = str_replace('{{connectionName}}', $database, $template);
		$template = str_replace('{{namespace}}', $this->config->ghostNamespace(), $template);
		$template = str_replace('{{add-fields}}', join("\n", $addFields), $template);
		$template = str_replace('{{constants}}', join("\n", $constants), $template);

		$this->style->writeln("Generate Helper from database");
		$this->style->write("- {$file}");
		file_put_contents($file, $template);
		$this->style->writeln(" - [OK]\n");
	}

	protected function fieldType($db_field, $fieldName) {
		$dbtype = $db_field['Type'];

		if ($db_field['Comment'] == 'json') return 'Field::TYPE_JSON';

		if ($dbtype == 'tinyint(1)') return 'Field::TYPE_BOOL';
		if ($dbtype == 'date') return 'Field::TYPE_DATE';
		if ($dbtype == 'datetime') return 'Field::TYPE_DATETIME';
		if ($dbtype == 'float') return 'Field::TYPE_FLOAT';
		if (strpos($dbtype, 'int(11) unsigned') === 0 && (substr($fieldName, -2) == 'Id' || $fieldName == 'id')) return 'Field::TYPE_ID';
		if (strpos($dbtype, 'int') === 0) return 'Field::TYPE_ID';
		if (strpos($dbtype, 'tinyint') === 0) return 'Field::TYPE_INT';
		if (strpos($dbtype, 'smallint') === 0) return 'Field::TYPE_INT';
		if (strpos($dbtype, 'mediumint') === 0) return 'Field::TYPE_INT';
		if (strpos($dbtype, 'bigint') === 0) return 'Field::TYPE_INT';;

		if (strpos($dbtype, 'varchar') === 0) return 'Field::TYPE_STRING';
		if (strpos($dbtype, 'char') === 0) return 'Field::TYPE_STRING';
		if (strpos($dbtype, 'text') === 0) return 'Field::TYPE_STRING';
		if (strpos($dbtype, 'text') === 0) return 'Field::TYPE_STRING';
		if (strpos($dbtype, 'tinytext') === 0) return 'Field::TYPE_STRING';
		if (strpos($dbtype, 'mediumtext') === 0) return 'Field::TYPE_STRING';
		if (strpos($dbtype, 'longtext') === 0) return 'Field::TYPE_STRING';

		if (strpos($dbtype, 'set') === 0) return 'Field::TYPE_SET';
		if (strpos($dbtype, 'enum') === 0) return 'Field::TYPE_ENUM';
		return '';
	}

	protected function menu($title, $options, $default) { return array_search($this->style->choice($title, array_values($options), $options[$default]), $options); }

}