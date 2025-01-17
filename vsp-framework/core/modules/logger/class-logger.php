<?php
/**
 * VPS Logger.
 *
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 * @version 1.0
 * @since 1.0
 *
 * Date 14-04-2018
 * Time 08:07 AM
 *
 * @package   vsp-framework/core/modules/logger
 * @link      http://github.com/varunsridharan/vsp-framework
 * @copyright 2018 Varun Sridharan
 * @license   GPLV3 Or Greater (https://www.gnu.org/licenses/gpl-3.0.txt)
 */

/**
 * Class VSP_Logger
 *
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 * @since 1.0
 */
class VSP_Logger implements VSP_Logger_Interface {
	/**
	 * Stores registered log handlers.
	 *
	 * @var array
	 */
	protected $handlers;
	/**
	 * Minimum log level this handler will process.
	 *
	 * @var int Integer representation of minimum log level to handle.
	 */
	protected $threshold;

	/**
	 * Constructor for the logger.
	 *
	 * @param array  $handlers Optional. Array of log handlers. If $handlers is not provided,
	 *     the filter 'vsp_register_log_handlers' will be used to define the handlers.
	 *     If $handlers is provided, the filter will not be applied and the handlers will be
	 *     used directly.
	 * @param string $threshold Optional. Define an explicit threshold. May be configured
	 *     via  VSP_LOG_THRESHOLD. By default, all logs will be processed.
	 */
	public function __construct( $handlers = null, $threshold = null ) {
		if ( null === $handlers ) {
			$handlers = apply_filters( 'vsp_register_log_handlers', array() );
		}
		$register_handlers = array();
		if ( ! empty( $handlers ) && is_array( $handlers ) ) {
			foreach ( $handlers as $handler ) {
				$implements = class_implements( $handler );
				if ( is_object( $handler ) && is_array( $implements ) && in_array( 'VSP_Log_Handler_Interface', $implements ) ) {
					$register_handlers[] = $handler;
				} else {
					vsp_doing_it_wrong( __METHOD__, sprintf( /* translators: 1: class name 2: VSP_Log_Handler_Interface */
						__( 'The provided handler %1$s does not implement %2$s.', 'vsp-framework' ), '<code>' . esc_html( is_object( $handler ) ? get_class( $handler ) : $handler ) . '</code>', '<code>VSP_Log_Handler_Interface</code>' ), '3.0' );
				}
			}
		}
		if ( null !== $threshold ) {
			$threshold = VSP_Log_Levels::get_level_severity( $threshold );
		} elseif ( defined( 'VSP_LOG_THRESHOLD' ) && VSP_Log_Levels::is_valid_level( VSP_LOG_THRESHOLD ) ) {
			$threshold = VSP_Log_Levels::get_level_severity( VSP_LOG_THRESHOLD );
		} else {
			$threshold = null;
		}
		$this->handlers  = $register_handlers;
		$this->threshold = $threshold;
		register_shutdown_function( array( $this, 'log_errors' ) );
	}

	/**
	 * Ensures fatal errors are logged so they can be picked up in the status report.
	 *
	 * @since 3.2.0
	 */
	public function log_errors() {
		$error = error_get_last();


		if ( E_ERROR === $error['type'] ) {
			vsp_log_msg( __( 'File & Line No :' ) . $error['file'] . '-' . $error['line'], 'critical', false, array(
				'source' => 'fatal-errors',
			) );

			vsp_log_msg( $error['message'], 'critical', false, array(
				'source' => 'fatal-errors',
			) );
		}
	}

	/**
	 * Adds a critical level message.
	 *
	 * Critical conditions.
	 * Example: Application component unavailable, unexpected exception.
	 *
	 * @see VSP_Logger::log
	 *
	 * @param string $message
	 * @param array  $context
	 */
	public function critical( $message, $context = array() ) {
		$this->log( VSP_Log_Levels::CRITICAL, $message, $context );
	}

	/**
	 * Add a log entry.
	 *
	 * @param string $level One of the following:
	 *     'emergency': System is unusable.
	 *     'alert': Action must be taken immediately.
	 *     'critical': Critical conditions.
	 *     'error': Error conditions.
	 *     'warning': Warning conditions.
	 *     'notice': Normal but significant condition.
	 *     'info': Informational messages.
	 *     'debug': Debug-level messages.
	 * @param string $message Log message.
	 * @param array  $context Optional. Additional information for log handlers.
	 */
	public function log( $level, $message, $context = array() ) {
		if ( ! VSP_Log_Levels::is_valid_level( $level ) ) {
			/* translators: 1: VSP_Logger::log 2: level */
			vsp_doing_it_wrong( __METHOD__, sprintf( __( '%1$s was called with an invalid level "%2$s".', 'vsp-framework' ), '<code>VSP_Logger::log</code>', $level ), '3.0' );
		}
		if ( $this->should_handle( $level ) ) {
			$timestamp = current_time( 'timestamp' );
			$message   = apply_filters( 'vsp_logger_log_message', $message, $level, $context );
			foreach ( $this->handlers as $handler ) {
				$handler->handle( $timestamp, $level, $message, $context );
			}
		}
	}

	/**
	 * Determine whether to handle or ignore log.
	 *
	 * @param string $level emergency|alert|critical|error|warning|notice|info|debug
	 *
	 * @return bool True if the log should be handled.
	 */
	protected function should_handle( $level ) {
		if ( null === $this->threshold ) {
			return true;
		}
		return $this->threshold <= VSP_Log_Levels::get_level_severity( $level );
	}

	/**
	 * Add a log entry.
	 *
	 * This is not the preferred method for adding log messages. Please use log() or any one of
	 * the level methods (debug(), info(), etc.). This method may be deprecated in the future.
	 *
	 * @param string $handle
	 * @param string $message
	 * @param string $level
	 *
	 * @return bool
	 */
	public function add( $handle, $message, $level = VSP_Log_Levels::NOTICE ) {
		$message = apply_filters( 'vsp_logger_add_message', $message, $handle );
		$this->log( $level, $message, array(
			'source'  => $handle,
			'_legacy' => true,
		) );
		return true;
	}

	/**
	 * Adds an emergency level message.
	 *
	 * System is unusable.
	 *
	 * @see VSP_Logger::log
	 *
	 * @param string $message
	 * @param array  $context
	 */
	public function emergency( $message, $context = array() ) {
		$this->log( VSP_Log_Levels::EMERGENCY, $message, $context );
	}

	/**
	 * Adds an alert level message.
	 *
	 * Action must be taken immediately.
	 * Example: Entire website down, database unavailable, etc.
	 *
	 * @see VSP_Logger::log
	 *
	 * @param string $message
	 * @param array  $context
	 */
	public function alert( $message, $context = array() ) {
		$this->log( VSP_Log_Levels::ALERT, $message, $context );
	}

	/**
	 * Adds an error level message.
	 *
	 * Runtime errors that do not require immediate action but should typically be logged
	 * and monitored.
	 *
	 * @see VSP_Logger::log
	 *
	 * @param string $message
	 * @param array  $context
	 */
	public function error( $message, $context = array() ) {
		$this->log( VSP_Log_Levels::ERROR, $message, $context );
	}

	/**
	 * Adds a warning level message.
	 *
	 * Exceptional occurrences that are not errors.
	 *
	 * Example: Use of deprecated APIs, poor use of an API, undesirable things that are not
	 * necessarily wrong.
	 *
	 * @see VSP_Logger::log
	 *
	 * @param string $message
	 * @param array  $context
	 */
	public function warning( $message, $context = array() ) {
		$this->log( VSP_Log_Levels::WARNING, $message, $context );
	}

	/**
	 * Adds a notice level message.
	 *
	 * Normal but significant events.
	 *
	 * @see VSP_Logger::log
	 *
	 * @param string $message
	 * @param array  $context
	 */
	public function notice( $message, $context = array() ) {
		$this->log( VSP_Log_Levels::NOTICE, $message, $context );
	}

	/**
	 * Adds a info level message.
	 *
	 * Interesting events.
	 * Example: User logs in, SQL logs.
	 *
	 * @see VSP_Logger::log
	 *
	 * @param string $message
	 * @param array  $context
	 */
	public function info( $message, $context = array() ) {
		$this->log( VSP_Log_Levels::INFO, $message, $context );
	}

	/**
	 * Adds a debug level message.
	 *
	 * Detailed debug information.
	 *
	 * @see VSP_Logger::log
	 *
	 * @param string $message
	 * @param array  $context
	 */
	public function debug( $message, $context = array() ) {
		$this->log( VSP_Log_Levels::DEBUG, $message, $context );
	}
}
