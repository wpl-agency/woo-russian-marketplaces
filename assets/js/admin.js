jQuery( function ( $ ) {
	const
		collapsed_class = 'wplovers-spoiler--collapsed',
		$spoilers       = $( '.wplovers-spoiler' );

	$( '.wplovers-spoiler__name' ).on(
		'click',
		function () {
			//$spoilers.addClass( collapsed_class );
			$( this ).parents( '.wplovers-spoiler' ).toggleClass( collapsed_class );
		}
	);
} );
