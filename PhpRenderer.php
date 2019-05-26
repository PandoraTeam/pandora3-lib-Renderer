<?php
namespace Pandora3\Libs\Renderer;

use Pandora3\Core\Interfaces\RendererInterface;

/**
 * Class PhpRenderer
 * @package Pandora3\Libs\Renderer
 */
class PhpRenderer implements RendererInterface {

	/** @var string $path */
	protected $path;

	/**
	 * @param string $path
	 */
	public function __construct(string $path = '') {
		$this->path = $path;
	}

	/**
	 * {@inheritdoc}
	 */
	public function render(string $viewPath, array $context = []): string {
		$viewPath = preg_replace('#(\.php)?$#', '.php', $viewPath, 1);
		if ($this->path) {
			$viewPath = "{$this->path}/{$viewPath}";
		}
		extract($context);
		try {
			ob_start();
				include($viewPath);
			return ob_get_clean();
		} catch (\Throwable $ex) {
			throw new \RuntimeException("Rendering view '$viewPath' failed", E_WARNING, $ex);
		}
	}

}