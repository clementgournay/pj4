<?php
/**
 * Maudern Admin Inbox Messages.
 *
 * @package  maudern
 * @since    1.0.0
 */

use Automattic\WooCommerce\Admin\Notes\Note;
use Automattic\WooCommerce\Admin\Notes\NoteTraits;

defined( 'ABSPATH' ) || exit;

/**
 * The initial Maudern inbox message.
 */
class Maudern_Inbox_Messages_Customize {

	use NoteTraits;

	/**
	* Name of the note for use in the database.
	*/
	const NOTE_NAME = 'maudern-customize';

	/**
	 * Get the note.
	 *
	 * @return Note
	 */
	public static function get_note() {
		$note = new Note();
		$note->set_title( _x( 'Design your store with Maudern 🎨', 'Theme starter content', 'maudern' ) );
		$note->set_content( _x( 'Visit the Maudern settings page to start setup and customization of your shop.', 'Theme starter content', 'maudern' ) );
		$note->set_type( Note::E_WC_ADMIN_NOTE_INFORMATIONAL );
		$note->set_name( self::NOTE_NAME );
		$note->set_content_data( (object) array() );
		$note->set_source( 'maudern' );
		$note->add_action(
			'customize-store-with-maudern',
			_x( 'Let\'s go!', 'Theme starter content', 'maudern' ),
			admin_url( 'customize.php/?maudern_starter_content=1' ),
			Note::E_WC_ADMIN_NOTE_ACTIONED,
			true
		);
		return $note;
	}
}
