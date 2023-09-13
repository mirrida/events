<?php

namespace Mirrida\Events;

use Mirrida\Patterns\Singleton;
use Mirrida\Patterns\Traits\DefaultSingleton;

class Events implements Singleton {
	use DefaultSingleton;

	/**
	 * @var array<string,callable[]>
	 */
	private array $events = [];

	/**
	 * Register event handler.
	 * @param string $event
	 * @param callable $handler
	 * @return void
	 */
	public function handle(string $event, callable $handler): void {
		if (!isset(self::$events[$event])) {
			self::$events[$event] = [];
		}

		self::$events[$event][] = $handler;
	}

	/**
	 * Run all event handlers with named function arguments.
	 * @param string $event
	 * @param array<string,mixed> $arguments
	 * @return void
	 */
	public function trigger(string $event, array $arguments = []): void {
		if (!isset(self::$events[$event])) {
			return;
		}

		$handlers = self::$events[$event];

		foreach ($handlers as $handler) {
			call_user_func_array($handler, $arguments);
		}
	}
}
