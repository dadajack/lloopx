<?php
/**
 * Plugin Name: Lloopx Audio Player
 * Plugin URI: https://yourwebsite.com/
 * Description: This plugin displays a table of audio files with a player and a short description on the user dashboard.
 * Version: 1.0.2
 * Author: Marcin Dudek
 * Author URI: https://www.upwork.com/freelancers/marcindudekdev/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function get_wavesurfer_html($url) {
    // Return null if the URL is empty
    if (empty($url)) {
        return null;
    }

    $random_id = 'w' . bin2hex(random_bytes(5));

    return <<<HTML
<div class="wavesurfer">
  <button id="$random_id-play"></button>
  <div id="$random_id"></div>
  <span id="$random_id-duration"></span>
</div>

<script type="module">
import WaveSurfer from 'https://unpkg.com/wavesurfer.js@beta'

window._wavesurfers = window._wavesurfers || []

const id = '$random_id'

const wavesurfer = WaveSurfer.create({
  height: 45,
  waveColor: '#B8B8B8',
  progressColor: '#4E97FD',
  cursorColor: '#4E97FD',
  barWidth: 3,
  barRadius: 3,
  container: '#' + id,
  url: '$url'
})

wavesurfer.once('ready', (duration) => {
  const durationEl = document.getElementById(id + '-duration')
  const minutes = Math.floor(duration / 60)
  const seconds = ('00' + (Math.round(duration) % 60)).slice(-2)
  durationEl.textContent = minutes + ':' + seconds
})

const playButton = document.getElementById(id + '-play')
playButton.onclick = () => wavesurfer.playPause()
wavesurfer.on('play', () => playButton.className = 'wavesurfer-pause')
wavesurfer.on('pause', () => playButton.className = '')

window._wavesurfers.push(wavesurfer)

wavesurfer.on('play', () => {
  window._wavesurfers.forEach((ws) => {
    if (ws !== wavesurfer && ws.isPlaying()) {
	  ws.stop()
    }
  })
})
</script>

<style>
  .wavesurfer {
      margin-left: auto; /* Lässt den Player nach rechts rücken */
    margin-right: 0; /* Lässt den Player nach rechts rücken */

   
  width: 70%; 
    display: flex;
	justify-content: center;
	align-items: center;
	gap: 16px;
	font-size: 11px;
	color: #fff;
  }
  .wavesurfer > button {
    background-color: #fff;
    border: 1px solid #fff;
    background-size: cover;
    background-position: center center;
    background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBVcGxvYWRlZCB0bzogU1ZHIFJlcG8sIHd3dy5zdmdyZXBvLmNvbSwgR2VuZXJhdG9yOiBTVkcgUmVwbyBNaXhlciBUb29scyAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIGZpbGw9IiMwMDAwMDAiIGhlaWdodD0iODAwcHgiIHdpZHRoPSI4MDBweCIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiANCgkgdmlld0JveD0iMCAwIDUxMiA1MTIiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggZD0iTTI1NiwwQzExNC42MTcsMCwwLDExNC42MTUsMCwyNTZzMTE0LjYxNywyNTYsMjU2LDI1NnMyNTYtMTE0LjYxNSwyNTYtMjU2UzM5Ny4zODMsMCwyNTYsMHogTTM0NC40OCwyNjkuNTdsLTEyOCw4MA0KCWMtMi41OSwxLjYxNy01LjUzNSwyLjQzLTguNDgsMi40M2MtMi42NjgsMC01LjM0LTAuNjY0LTcuNzU4LTIuMDA4QzE5NS4xNTYsMzQ3LjE3MiwxOTIsMzQxLjgyLDE5MiwzMzZWMTc2DQoJYzAtNS44MiwzLjE1Ni0xMS4xNzIsOC4yNDItMTMuOTkyYzUuMDg2LTIuODM2LDExLjMwNS0yLjY2NCwxNi4yMzgsMC40MjJsMTI4LDgwYzQuNjc2LDIuOTMsNy41Miw4LjA1NSw3LjUyLDEzLjU3DQoJUzM0OS4xNTYsMjY2LjY0MSwzNDQuNDgsMjY5LjU3eiIvPg0KPC9zdmc+");
    border-radius: 100%;
    width: 32px;
    height: 32px;
    padding: 0;
    box-shadow: none;
    transition: all 0.3s ease;
  }
  .wavesurfer > button:hover {
    background-size: 110%;
	background-color: #4e97fd;
	border-color: #4e97fd;
  }
  .wavesurfer > button.wavesurfer-pause {
    background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBVcGxvYWRlZCB0bzogU1ZHIFJlcG8sIHd3dy5zdmdyZXBvLmNvbSwgR2VuZXJhdG9yOiBTVkcgUmVwbyBNaXhlciBUb29scyAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIGZpbGw9IiMwMDAwMDAiIGhlaWdodD0iODAwcHgiIHdpZHRoPSI4MDBweCIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiANCgkgdmlld0JveD0iMCAwIDUxMiA1MTIiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggZD0iTTI1NiwwQzExNC42MTcsMCwwLDExNC42MTUsMCwyNTZzMTE0LjYxNywyNTYsMjU2LDI1NnMyNTYtMTE0LjYxNSwyNTYtMjU2UzM5Ny4zODMsMCwyNTYsMHogTTIyNCwzMjANCgljMCw4LjgzNi03LjE2NCwxNi0xNiwxNmgtMzJjLTguODM2LDAtMTYtNy4xNjQtMTYtMTZWMTkyYzAtOC44MzYsNy4xNjQtMTYsMTYtMTZoMzJjOC44MzYsMCwxNiw3LjE2NCwxNiwxNlYzMjB6IE0zNTIsMzIwDQoJYzAsOC44MzYtNy4xNjQsMTYtMTYsMTZoLTMyYy04LjgzNiwwLTE2LTcuMTY0LTE2LTE2VjE5MmMwLTguODM2LDcuMTY0LTE2LDE2LTE2aDMyYzguODM2LDAsMTYsNy4xNjQsMTYsMTZWMzIweiIvPg0KPC9zdmc+");

  }
  .wavesurfer > div {
    flex: 1;
  }
</style>
HTML;
}






class Lloopx_Audio_Player {

	const MAX_ENTRIES_LIMIT = 10;
	const FULL_ACCESS_ROLE = 'member';

	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'lloopx_activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'lloopx_deactivate' ) );

		add_shortcode( 'lloopx_audio_player', array( $this, 'lloopx_shortcode' ) );

		add_action( 'admin_menu', function () {
			add_options_page(
				'Lloopx Audio Player Settings', // page title
				'Lloopx Audio Player', // menu title
				'manage_options', // capability
				'lloopx_audio_player', // menu slug
				array( $this, 'lloopx_audio_player_settings_page' ) // function to display the settings page
			);
		} );


		if ( ! is_admin() || $this->request_is_frontend_ajax() ) {
			// Shortcode Override Functions
			add_filter( 'wp_audio_shortcode_override', array( $this, 'wp_audio_shortcode_override' ), 10, 2 );
		}

		add_action( 'wp_ajax_delete_forminator_entry', array( $this, 'delete_forminator_entry_callback' ) );

	}
	
	
	
	
	
	
	
	
	
	
	
	
	



	
	
	
	
	
	
	
	
	
	

	/**
	 * See if an AJAX request come from front-end or Back-End
	 * Prevents shortcode rendering in Post Editor (which uses AJAX)
	 *
	 * https://snippets.khromov.se/determine-if-wordpress-ajax-request-is-a-backend-of-frontend-request/
	 * @since 2.7.3
	 */
	private function request_is_frontend_ajax() {

		$script_filename = isset( $_SERVER['SCRIPT_FILENAME'] ) ? $_SERVER['SCRIPT_FILENAME'] : '';

		//Try to figure out if frontend AJAX request... If we are DOING_AJAX; let's look closer
		if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			//From wp-includes/functions.php, wp_get_referer() function.
			//Required to fix: https://core.trac.wordpress.org/ticket/25294
			$ref = '';
			if ( ! empty( $_REQUEST['_wp_http_referer'] ) ) {
				$ref = wp_unslash( $_REQUEST['_wp_http_referer'] );
			} elseif ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
				$ref = wp_unslash( $_SERVER['HTTP_REFERER'] );
			}

			//If referer does not contain admin URL and we are using the admin-ajax.php endpoint, this is likely a frontend AJAX request
			if ( ( ( strpos( $ref, admin_url() ) === false ) && ( basename( $script_filename ) === 'admin-ajax.php' ) ) ) {
				return true;
			}
		}

		//If no checks triggered, we end up here - not an AJAX request.
		return false;

	}

	public function lloopx_activate() {
		// This function runs when the plugin is activated.
	}

	public function lloopx_deactivate() {
		// This function runs when the plugin is deactivated.
	}

	public function lloopx_shortcode( $atts = [], $content = null ) {
		// Extract shortcode attributes
		$atts            = shortcode_atts( [ 'user_id' => '', 'form_id' => '' ], $atts, 'lloopx_audio_player' );
		$is_own_profile  = false;
		$current_user_id = get_current_user_id();

		if ( empty( $atts['user_id'] ) && is_user_logged_in() ) {

			if ( function_exists( 'um_profile_id' ) ) {
				$atts['user_id'] = um_profile_id();
			}

			// If user_id is still empty after attempting to get it from Ultimate Member, show current user
			if ( empty( $atts['user_id'] ) ) {
				//fallback
				$atts['user_id'] = get_current_user_id();
			}

		}
		// If either user_id or form_id are empty, return an empty string
		if ( empty( $atts['user_id'] ) || empty( $atts['form_id'] ) ) {
			return $this->admin_eyes_only( '"user_id" and "form_id" are required' );
		}

		// Set this to check if can delete
		$is_own_profile = $atts['user_id'] == $current_user_id;

		// Fetch Forminator Entries for the user and form
		$entries = $this->fetch_forminator_entries( $atts['form_id'], $atts['user_id'] );

		if ( empty( $entries ) ) {
			return $this->admin_eyes_only( sprintf( 'No loops uploaded.', $atts['user_id'], $atts['form_id'] ) );
		}

		// Check if the user has the 'member' role
		$user               = get_userdata( $atts['user_id'] );
		$limit_user_entries = $user && ! in_array( self::FULL_ACCESS_ROLE, (array) $user->roles );
		$limited_disclaimer = '';

		if ( count( $entries ) > self::MAX_ENTRIES_LIMIT ) {
			// Limit the entries to the first self::MAX_ENTRIES_LIMIT entries
			$entries = array_slice( $entries, 0, self::MAX_ENTRIES_LIMIT );
		}

		if ( $limit_user_entries ) {
			$limited_disclaimer = sprintf( _n(
				get_option( 'lloopx_limited_disclaimer', 'Non-members can see only their first entry.' ),
				get_option( 'lloopx_limited_disclaimer', 'Non-members can see only their first %d entries.' ),
				self::MAX_ENTRIES_LIMIT,
				'lloopx_audio_player'
			), self::MAX_ENTRIES_LIMIT );
		}

		$output = '';

		if ( ! empty( $limited_disclaimer ) ) {
			$output .= '<div class="lloopx_disclaimer">' . $limited_disclaimer . '</div>';
		}
		// Initialize output
		$output .= '<div class="lloopx_container">';

		$nonce = wp_create_nonce( 'delete_forminator_entry_nonce' );
		
		
		
		
		
		
		
		
		
		// Add items
		// Action Button (Download, Delete)
$output .= '<div class="lloopx_items_container">';
$output .= '<style>';
$output .= '.info-item, .action-button { box-sizing: border-box; border: 1px solid #444; padding: 8px 12px; border-radius: 10px; height: 43px; }';
$output .= '.info-item { background-color: #555; color: #EEE; margin-right: 10px; }';
$output .= '.action-button { background-color: #333; color: #EEE; transition: background-color 0.3s; }';
$output .= '.lloopx_items_container .actions-container .action-button { text-decoration: none !important; }';
$output .= '.action-button:hover { background-color: #555; }';
$output .= '.info-item, .action-button, .lloopx_item h3 { font-family: Arial, sans-serif; }';
$output .= '.lloopx_item h3 { color: #fff; }';
$output .= '.info-container { display: flex; margin-left: 30%; }';
$output .= '.title-container { margin-left: 30%; }';
$output .= '.player-container { display: flex; align-items: center; }';
$output .= '.image-container  { margin-right: 10px; margin-left: 80px; }';
$output .= '.image-container img { max-height: 200px; max-width: 200px; width: 200px; height: 200px; object-fit: cover; }';


// CSS for favorite-button
$output .= '.favorite-button { border: none; background-color: transparent; color: #EEE; font-size: 30px; }';
$output .= '.favorite-button:before { content: "\2606"; }';  // Unicode for an empty star
$output .= '.favorite-button:hover:before { content: "\2605"; }';  // Unicode for a full star

// Add this line
$output .= '.info-actions-container { margin-top: -30px; }';

$output .= '</style>';
		

foreach ($entries as $i => $entry) {
    $output .= '<div class="lloopx_item">';
    $output .= '<div class="title-container">';
    $output .= '<h3>' . esc_html($entry['loop_name']) . '</h3>';
    $output .= '</div>';
    $output .= '<div class="player-container">';
    // Einfügen des Bildes
    $output .= '<div class="image-container">';
    // Überprüfen, ob das Bild existiert. Wenn nicht, wird ein Platzhalterbild verwendet.
    $imageUrl = (!empty($entry['image_url'])) ? esc_url($entry['image_url']) : 'https://get.wallhere.com/photo/illustration-minimalism-text-logo-cassette-audio-brand-rectangle-design-screenshot-font-118564.png';
    $output .= "<img src='{$imageUrl}' alt='" . esc_html($entry['loop_name']) . " cover image'>";
    $output .= '</div>';
    $output .= do_shortcode('[audio src="' . esc_url($entry['file_url']) . '"]');
    $output .= '</div>';
    $output .= '<div class="info-actions-container" style="display: flex; justify-content: space-between;">';
    $output .= '<div class="info-container">';
    $output .= '<p class="info-item">BPM: ' . esc_html($entry['bpm']) . '</p>';
    $output .= '<p class="info-item">Mood: ' . esc_html($entry['mood']) . '</p>';
    
   // Add the "Key" information, if it exists
    if (!empty($entry['key'])) {
        $output .= '<p class="info-item">Key: ' . esc_html($entry['key']) . '</p>';
    }

    $output .= '</div>';
    $output .= '<div class="actions-container" style="display: flex;">';
    $output .= '<a href="' . esc_url($entry['file_url']) . '" class="action-button download-button" download>Download</a>';
    if ($is_own_profile) {
        $output .= '<a href="#" class="action-button delete-button delete-entry" data-entry-id="' . $entry['entry_id'] . '" data-nonce="' . $nonce . '">Delete</a>';
    }
    $output .= '<a href="#" class="action-button favorite-button" data-entry-id="' . $entry['entry_id'] . '"> </a>'; // Removed "Favorisieren" text
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
}
$output .= '</div>';

if (is_user_logged_in()) {
    $output .= '<style>.favorite-button { margin-right: 10px; }</style>';
}


		
		
		
		
		
		
		
		
		
		
		
		


		// Add the CSS to the footer if the shortcode is present
		// Hover effect color Download & Delete Button
		add_action( 'wp_footer', function () {
			echo '<style>
			
		
			.action-button.download-button:hover, .action-button.delete-button:hover {
    background-color: #4e97fd;
    color: #ffffff; /* Weiß, um den Text sichtbar zu machen */
	transition: none;
}

			
			
            .lloopx_disclaimer {
                background-color: #f2f2f2;
                font-weight: bold;
                padding: 10px;
                margin-bottom: 20px;
                border-radius: 5px;
            }
        </style>';
			
			$admin_ajax_url = admin_url( 'admin-ajax.php' );

			ob_start();
			?>
			<script>
				jQuery( document ).ready( function ( $ ) {
	$( '.lloopx_item .delete-entry' ).on( 'click', function ( e ) {
		e.preventDefault();

		if ( confirm( 'Are you sure you want to delete this entry?' ) ) {
			var entryId = $( this ).data( 'entry-id' );
			var parentItem = $(this).parents('.lloopx_item')

			$.ajax( {
				url: '<?=$admin_ajax_url?>',
				type: 'POST',
				data: {
					action: 'delete_forminator_entry',
					entry_id: entryId,
					nonce: $( this ).data( 'nonce' )
				},
				success: function ( response ) {
					if ( response.success ) {
						alert( 'Entry deleted successfully.' );
						parentItem.remove();
					} else {
						alert( 'Failed to delete entry.' );
					}
				}
			} );
		}
	} );
} );

			</script>
			<?php
			echo ob_get_clean();
		} );

		return $output;
	}

	private function admin_eyes_only( $message ) {
		return current_user_can( 'manage_options' ) ? $message : '';
	}

	private function fetch_forminator_entries( $form_id, $user_id ) {
		$result = array();

		// Fetch Forminator Entries for the user from the database
		$filters = array();
		$entries = Forminator_Form_Entry_Model::get_filter_entries( $form_id, $filters );

		if ( empty( $entries ) ) {
			return $result;
		}

		// Loop each entry to build the $result array
		foreach ( $entries as $entry ) {
			// Get the entry data
			$entry_data = $entry->meta_data;

			// Check if the 'hidden-1' field exists and matches the provided user_id
			if ( isset( $entry_data['hidden-1'] ) && $entry_data['hidden-1']['value'] == $user_id ) {
				// Prepare the data for this entry
				$entry_info = array(
					'entry_id'  => $entry->entry_id,
					'loop_name' => isset( $entry_data['text-1'] ) ? $entry_data['text-1']['value'] : '',
					'bpm'       => isset( $entry_data['text-2'] ) ? $entry_data['text-2']['value'] : '',
					'mood'      => isset( $entry_data['select-1'] ) ? $entry_data['select-1']['value'] : '',
					'key' => isset( $entry_data['select-2'] ) ? $entry_data['select-2']['value'] : '', 
					'file_url'  => isset( $entry_data['upload-1']['value']['file']['file_url'] ) ? $entry_data['upload-1']['value']['file']['file_url'] : '',
					'file_name' => isset( $entry_data['upload-1']['value']['file']['file_name'] ) ? $entry_data['upload-1']['value']['file']['file_name'] : '',
					'image_url' => isset( $entry_data['upload-2']['value']['file']['file_url'] ) ? $entry_data['upload-2']['value']['file']['file_url'] : '',

				);

				// Add the entry data to the result array
				$result[] = $entry_info;
			}
		}

		return $result;
	}

	function delete_forminator_entry_callback() {
		// Verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'delete_forminator_entry_nonce' ) ) {
			wp_send_json_error( 'Nonce verification failed.' );
			exit;
		}

		// Get entry_id from request
		$entry_id        = isset( $_POST['entry_id'] ) ? intval( $_POST['entry_id'] ) : null;
		$entry_data      = new Forminator_Form_Entry_Model( $entry_id );
		$current_user_id = get_current_user_id();

		// Get user_id from entry (you need to determine how you are storing user_id in the entry)
		$entry_user_id = $entry_data->meta_data['hidden-1']['value']; /* code to get user_id from entry */;

		// Check if current user ID matches the user ID in the entry
		if ( get_current_user_id() != $entry_user_id ) {
			wp_send_json_error( 'User not authorized to delete this entry.' );
			exit;
		}

		// Delete the entry
		if ( $entry_id ) {
			Forminator_Form_Entry_Model::delete_by_entry( $entry_id );
			wp_send_json_success();
		} else {
			wp_send_json_error( 'Failed to delete entry.' );
		}
	}

	function lloopx_audio_player_settings_page() {
		// Check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Check if the user has submitted the settings
		if ( isset( $_POST['lloopx_settings_nonce'] ) && wp_verify_nonce( $_POST['lloopx_settings_nonce'], 'lloopx_settings_save' ) ) {
			// Update the settings
			update_option( 'lloopx_label_number', $_POST['lloopx_label_number'] );
			update_option( 'lloopx_label_loop_name', $_POST['lloopx_label_loop_name'] );
			update_option( 'lloopx_label_bpm', $_POST['lloopx_label_bpm'] );
			update_option( 'lloopx_label_mood', $_POST['lloopx_label_mood'] );
			
			update_option( 'lloopx_label_key', $_POST['lloopx_label_key'] );

			update_option( 'lloopx_label_player', $_POST['lloopx_label_player'] );
			update_option( 'lloopx_label_download', $_POST['lloopx_label_download'] );
			update_option( 'lloopx_limited_disclaimer', sanitize_text_field( $_POST['lloopx_limited_disclaimer'] ) );
		}

		// Display the settings page
		?>
		<div class="wrap">
			<h1><?= esc_html( get_admin_page_title() ); ?></h1>
			<form action="" method="post">
				<?php wp_nonce_field( 'lloopx_settings_save', 'lloopx_settings_nonce' ); ?>
				<table class="form-table">
					<tr>
						<th scope="row"><label for="lloopx_label_number">Number Label</label></th>
						<td><input name="lloopx_label_number" id="lloopx_label_number" type="text"
						           value="<?= esc_attr( get_option( 'lloopx_label_number', '#' ) ); ?>"
						           class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="lloopx_label_loop_name">Loop Name Label</label></th>
						<td><input name="lloopx_label_loop_name" id="lloopx_label_loop_name" type="text"
						           value="<?= esc_attr( get_option( 'lloopx_label_loop_name', 'Loop Name' ) ); ?>"
						           class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="lloopx_label_bpm">BPM Label</label></th>
						<td><input name="lloopx_label_bpm" id="lloopx_label_bpm" type="text"
						           value="<?= esc_attr( get_option( 'lloopx_label_bpm', 'BPM' ) ); ?>"
						           class="regular-text"></td>
					</tr>
					<tr>
    					<th scope="row"><label for="lloopx_label_key">Key Label</label></th>
   						 <td><input name="lloopx_label_key" id="lloopx_label_key" type="text"
          				     value="<?= esc_attr( get_option( 'lloopx_label_key', 'Key' ) ); ?>"
           					    class="regular-text"></td>
					</tr>				
					<tr>
						<th scope="row"><label for="lloopx_label_mood">Mood Label</label></th>
						<td><input name="lloopx_label_mood" id="lloopx_label_mood" type="text"
						           value="<?= esc_attr( get_option( 'lloopx_label_mood', 'Mood' ) ); ?>"
						           class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="lloopx_label_player">Player Label</label></th>
						<td><input name="lloopx_label_player" id="lloopx_label_player" type="text"
						           value="<?= esc_attr( get_option( 'lloopx_label_player', 'Player' ) ); ?>"
						           class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="lloopx_label_download">Download Label</label></th>
						<td><input name="lloopx_label_download" id="lloopx_label_download" type="text"
						           value="<?= esc_attr( get_option( 'lloopx_label_download', 'Download' ) ); ?>"
						           class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row">
							<label for="lloopx_limited_disclaimer">
								<?php _e( 'Limited Entries Disclaimer', 'lloopx_audio_player' ); ?>
							</label>
						</th>
						<td>
							<input name="lloopx_limited_disclaimer" id="lloopx_limited_disclaimer" type="text"
							       value="<?= esc_attr( get_option( 'lloopx_limited_disclaimer', 'Non-members can see only their first %d entries.' ) ); ?>"
							       class="regular-text">
							<p class="description">
								<?php _e( 'Use "%d" to represent the limit number.', 'lloopx_audio_player' ); ?>
							</p>
						</td>
					</tr>

				</table>
				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
				                         value="Save Changes"></p>
			</form>
		</div>
		<?php
	}

	/**
	 * Audio Shortcode output
	 */
	public function wp_audio_shortcode_override( $html, $attr ) {

		// Filter/Add ShortCode Attributes
		$attr = apply_filters( 'wavesurfer_wp_shortcode_attributes', $attr, 'audio' );

		//self::$load_front_ressources = true;
		$html = ''; // Value for not overring render

		// Check if shortcode render must be override or not
		if ( ! empty( $attr['player'] ) && $attr['player'] === 'default' ) {
			return $html;
		}

		// Check audio type to determine the link
		if ( isset( $attr['wav'] ) ) {
			$link = $attr['wav'];
		}
		if ( isset( $attr['mp3'] ) ) {
			$link = $attr['mp3'];
		}
		if ( isset( $attr['m4a'] ) ) {
			$link = $attr['m4a'];
		}
		if ( isset( $attr['ogg'] ) ) {
			$link = $attr['ogg'];
		}
		if ( isset( $attr['src'] ) ) {
			$link = $attr['src'];
		}

		$html = get_wavesurfer_html($link);

		return $html;

	}

	/**
	 * Enqueue script for ajax
	 */
	public function my_enqueue_script( $script ) {
		$wavesurfer_nonce = wp_create_nonce( 'wavesurfer_nonce' );

		wp_localize_script( $script, 'lloopx_audio_player', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => $wavesurfer_nonce,
		) );

		wp_enqueue_script( $script );
	}

	/**
	 * Get Player Translation Strings
	 *
	 */
	public function get_player_translation_strings() {
		// Localize Scripts Strings
		$localize_strings = array(
			'play'   => __( 'Play', 'lloopx_audio_player' ),
			'pause'  => __( 'Pause', 'lloopx_audio_player' ),
			'resume' => __( 'Resume', 'lloopx_audio_player' ),
			'stop'   => __( 'Stop', 'lloopx_audio_player' ),
			'loop'   => __( 'Loop', 'lloopx_audio_player' ),
			'unloop' => __( 'Unloop', 'lloopx_audio_player' ),
			'mute'   => __( 'Mute', 'lloopx_audio_player' ),
			'unmute' => __( 'Unmute', 'lloopx_audio_player' )
		);

		return $localize_strings;
	}
}

// Initialize the plugin
$lloopx_audio_player = new Lloopx_Audio_Player();
