<?php
/**
 *   File: inc/bsoup1-loader.php
 *
 *   Class: BSoup1_Loader
 *
 *     Functions:
 *
 *       __construct()
 *       add_action( $hook, $component, $callback, $priority, $accepted_args )
 *       add_filter( $hook, $component, $callback, $priority, $accepted_args )
 *       add( $hooks, $hook, $component, $callback, $priority, $accepted_args )
 *       run()
 */
class BSoup1_Loader {
  protected $actions;
  protected $filters;

  /*******************************************************************************************************************/
  public function __construct() {
    $this->actions = array();
    $this->filters = array();
  }

  /*******************************************************************************************************************/
  public function add_action( $hook, $component, $callback, $priority, $accepted_args ) {
    $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args  );
  }

  /*******************************************************************************************************************/
  public function add_filter( $hook, $component, $callback, $priority, $accepted_args ) {
    $this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args  );
  }

  /*******************************************************************************************************************/
  private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {
    $hooks[] = array(
      'hook'          => $hook,
      'component'     => $component,
      'callback'      => $callback,
      'priority'      => $priority,
      'accepted_args' => $accepted_args
    );
    return $hooks;
  }

  /*******************************************************************************************************************/
  public function run() {
    foreach ( $this->filters as $hook ) {
      add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
    }
    foreach ( $this->actions as $hook ) {
      add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
    }
  }
}
