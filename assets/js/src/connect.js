jQuery.oauthpopup = function( options ) {
	options.windowName = options.windowName || 'ConnectWithOAuth'; // Should not include space for IE.
	options.windowOptions = options.windowOptions || 'location=0,status=0,width=600,height=500';
	options.callback = options.callback || function() { window.location.reload(); };
	var that = this;
	that._oauthWindow = window.open( options.path, options.windowName, options.windowOptions );
	that._oauthInterval = window.setInterval( function() {
		if ( that._oauthWindow.closed ) {
			window.clearInterval( that._oauthInterval );
			options.callback();
		}
	}, 1000 );
};